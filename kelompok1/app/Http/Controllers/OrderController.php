<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang login.
     */
    public function index(): View
    {
        // Mengambil order milik user yang sedang login
        $orders = Order::with(['product', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);
        
        // Tetap melimit 4 produk opsional untuk kebutuhan section rekomendasi di view jika diperlukan
        $products = Product::limit(4)->get(); 

        return view('order.index', compact('orders', 'products'));
    }

    /**
     * Mengambil detail pesanan untuk popup modal.
     */
    public function show($id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);

            // Keamanan: Pastikan user hanya bisa melihat pesanan miliknya sendiri
            if ((int)$order->user_id !== (int)Auth::id()) {
                return response()->json(['message' => 'Akses ditolak'], 403);
            }

            return response()->json($order);
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching order: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    /**
     * Memproses pembayaran pesanan (Integrasi Midtrans Snap & Tunai).
     */
    public function pay(Request $request, $id): JsonResponse
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|in:Transfer,Tunai,QRIS',
        ]);

        try {
            // Eager load relasi 'user' untuk keperluan data customer Midtrans
            $order = Order::with('user')->findOrFail($id);

            // Keamanan: Pastikan user hanya bisa membayar pesanan miliknya sendiri
            if ((int)$order->user_id !== (int)Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
            }

            // --- STRATEGI 1: JIKA METODE PEMBAYARAN TUNAI (CASH ON DELIVERY) ---
            if ($request->metode_pembayaran === 'Tunai') {
                // Menggunakan updateOrCreate agar data payment tidak duplikat jika user mengganti metode pembayaran
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'jumlah_bayar'      => (int)$order->harga,
                        'metode_pembayaran' => 'Tunai',
                        'status_pembayaran' => 'pending', // Menunggu bayar di lokasi rental
                    ]
                );

                // Update status pesanan
                $order->status = 'Pending';
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Metode tunai berhasil dipilih. Silakan lakukan pembayaran saat pengambilan motor.',
                    'snap_token' => null
                ]);
            }

            // Cek jika pesanan sudah lunas
            if ($order->payment && $order->payment->status_pembayaran === 'success') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan ini sudah lunas.',
                ], 400);
            }

            // --- STRATEGI 2: JIKA METODE DIGITAL (TRANSFER BANK / QRIS VIA MIDTRANS SANDBOX) ---
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production'); // false = Sandbox
            Config::$isSanitized  = config('midtrans.is_sanitized');
            Config::$is3ds        = config('midtrans.is_3ds');

            // SSL verification handled by server configuration.
            // Tidak ada override khusus pada SDK Midtrans di lingkungan production cPanel.
            Config::$curlOptions = [];

            // Gunakan order_id unik per percobaan pembayaran agar Midtrans tidak menolak percobaan bayar ulang (Retry/Pay Later)
            $midtransOrderId = $order->kode_booking . '-' . time();
            $params = [
                'transaction_details' => [
                    'order_id'     => $midtransOrderId,
                    'gross_amount' => (int) $order->harga,
                ],
                'customer_details' => [
                    'first_name' => $order->nama_pemesan ?? $order->user->name,
                    'email'      => $order->user->email ?? 'customer@mail.com',
                    'phone'      => $order->no_wa ?? $order->user->whatsapp,
                ],
                'item_details' => [
                    [
                        'id'       => $order->product_id ?? $order->id, // Diselaraskan menggunakan ID produk jika kolom tersedia
                        'price'    => (int)$order->harga,
                        'quantity' => 1,
                        'name'     => 'Sewa Motor: ' . substr($order->nama_motor, 0, 40), // Batasi max 40 karakter aturan Midtrans
                    ]
                ],
                'callbacks' => [
                    'finish' => route('order.index'),
                ],
                'override_notification_url' => route('midtrans.webhook'),
            ];

            // Dapatkan token Snap dari API Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan / Perbarui record payment secara langsung saat token Snap dibuat
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'midtrans_order_id' => $midtransOrderId,
                    'jumlah_bayar'      => (int) $order->harga,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status_pembayaran' => 'pending',
                ]
            );

            // Log hanya order_id, JANGAN log snap token di production
            Log::info('Midtrans Snap: Token berhasil dibuat.', [
                'order_id' => $midtransOrderId,
            ]);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Midtrans Payment Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Memperbarui status pesanan secara instan melalui callback front-end (Midtrans Snap JS result).
     */
    public function finishPayment(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);

            // Keamanan: Pastikan user hanya bisa merubah pesanan miliknya sendiri
            if ((int)$order->user_id !== (int)Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
            }

            $transactionId     = $request->input('transaction_id');
            $paymentType       = $request->input('payment_type');
            $transactionStatus = $request->input('transaction_status', 'settlement');

            $statusPembayaran = 'pending';
            if (in_array($transactionStatus, ['settlement', 'capture', 'success'])) {
                $statusPembayaran = 'success';
            } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                $statusPembayaran = 'failed';
            }

            $paymentData = [
                'status_pembayaran' => $statusPembayaran,
            ];

            if (!empty($transactionId)) {
                $paymentData['midtrans_transaction_id'] = $transactionId;
            }

            if (!empty($paymentType)) {
                $paymentData['payment_type']      = $paymentType;
                $paymentData['metode_pembayaran'] = $paymentType;
            }

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                $paymentData
            );

            if ($statusPembayaran === 'success') {
                $order->status = 'Lunas';
                $order->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diperbarui.'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error finish payment frontend: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status'], 500);
        }
    }
}