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
        $orders = Order::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
        
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
                $order->status = 'Menunggu Pembayaran';
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Metode tunai berhasil dipilih. Silakan lakukan pembayaran saat pengambilan motor.',
                    'snap_token' => null
                ]);
            }

            // --- STRATEGI 2: JIKA METODE DIGITAL (TRANSFER BANK / QRIS VIA MIDTRANS) ---
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // PERBAIKAN SOLUSI SSL: Kosongkan curlOptions bawaan SDK untuk menghindari error 'Undefined array key 10023'
            Config::$curlOptions = [];

            // Mematikan verifikasi SSL menggunakan Stream Context global PHP khusus di lingkungan local/development
            if (config('app.env') === 'local' || env('APP_ENV') === 'local') {
                stream_context_set_default([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->kode_booking . '-' . time(), // Suffix waktu agar order_id Midtrans selalu unik jika di-retry
                    'gross_amount' => (int)$order->harga,
                ],
                'customer_details' => [
                    'first_name' => $order->nama_pemesan ?? $order->user->name,
                    'email' => $order->user->email ?? 'customer@mail.com',
                    'phone' => $order->no_wa ?? $order->user->whatsapp,
                ],
                'item_details' => [
                    [
                        'id' => $order->product_id ?? $order->id, // Diselaraskan menggunakan ID produk jika kolom tersedia
                        'price' => (int)$order->harga,
                        'quantity' => 1,
                        'name' => 'Sewa Motor: ' . substr($order->nama_motor, 0, 40), // Batasi max 40 karakter aturan Midtrans
                    ]
                ]
            ];

            // Dapatkan token Snap dari API Midtrans Sandbox
            $snapToken = Snap::getSnapToken($params);

            // Menggunakan updateOrCreate untuk mencegah penumpukan baris baru di tabel payments pada order_id yang sama
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'jumlah_bayar'      => (int)$order->harga,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status_pembayaran' => 'pending', // Menunggu proses penyelesaian di sisi gateway
                ]
            );

            return response()->json([
                'success' => true,
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
     * Memperbarui status pesanan secara instan melalui callback lokal front-end.
     */
    public function updateStatusLokal(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $order = Order::findOrFail($id);

            // Keamanan: Pastikan user hanya bisa merubah pesanan miliknya sendiri
            if ((int)$order->user_id !== (int)Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
            }

            // Update status pada tabel orders
            // Menyesuaikan string dengan pengecekan 'success' pada template Blade Anda
            $order->status = $request->status; // Menyimpan nilai 'success'
            $order->save();

            // Opsional: Update status pada tabel payments jika data tercatat di sana
            Payment::where('order_id', $order->id)->update([
                'status_pembayaran' => 'success'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui secara lokal.'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error update status lokal: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status'], 500);
        }
    }
}