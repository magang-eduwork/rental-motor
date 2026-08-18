<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class MidtransWebhookController extends Controller
{
    /**
     * Resolve internal order ID from Midtrans order ID (kode_booking).
     *
     * @param string $midtransOrderId
     * @return int|null
     */
    private function resolveOrderId(string $midtransOrderId): ?int
    {
        // 1. Cek langsung ke tabel payments berdasarkan midtrans_order_id
        $payment = Payment::where('midtrans_order_id', $midtransOrderId)->first();
        if ($payment) {
            return $payment->order_id;
        }

        // 2. Cek langsung ke tabel orders berdasarkan kode_booking
        $order = Order::where('kode_booking', $midtransOrderId)->first();
        if ($order) {
            return $order->id;
        }

        // 3. Jika midtrans_order_id berformat BK-XXXXX-123456789, ambil kode_booking di depan (BK-XXXXX)
        $parts = explode('-', $midtransOrderId);
        if (count($parts) >= 3) {
            $bookingCode = $parts[0] . '-' . $parts[1];
            $order = Order::where('kode_booking', $bookingCode)->first();
            if ($order) {
                return $order->id;
            }
        }

        // 4. Fallback search by prefix
        $order = Order::whereRaw('? LIKE CONCAT(kode_booking, "%")', [$midtransOrderId])->first();
        if ($order) {
            return $order->id;
        }

        return null;
    }

    public function handleNotification(Request $request): JsonResponse
    {
        // =============================================
        // STEP 1: Ambil semua field yang dibutuhkan
        // =============================================
        $orderId     = $request->input('order_id');
        $statusCode  = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $serverKey   = config('midtrans.server_key');

        // Guard against missing or empty order_id (some Midtrans test pings)
        if (empty($orderId)) {
            Log::info('Midtrans Webhook: Empty order_id – ignored as test notification.', $request->all());
            return response()->json(['message' => 'Empty order_id ignored'], 200);
        }

        // If this is a Midtrans test notification, skip signature verification
        // Use strpos for compatibility with older PHP versions
        if (strpos($orderId, 'payment_notif_test_') === 0) {
            Log::info('Midtrans Webhook: Test notification ignored.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Test notification ignored'], 200);
        }

        // =============================================
        // STEP 2: Verifikasi Signature Key dari Midtrans
        // Format: SHA512(order_id + status_code + gross_amount + server_key)
        // =============================================
        $signatureKey    = $request->input('signature_key');
        $expectedSig     = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSig) {
            Log::warning('Midtrans Webhook: Signature tidak valid.', [
                'order_id'    => $orderId,
                'status_code' => $statusCode,
            ]);
            // Tetap return 200 agar Midtrans tidak retry tanpa henti,
            // tapi tandai sebagai invalid di log.
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // =============================================
        // STEP 3: Logging aman — TIDAK mencatat server_key atau credential
        // =============================================
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus       = $request->input('fraud_status');
        $paymentType       = $request->input('payment_type');
        $transactionId     = $request->input('transaction_id');

        Log::info('Midtrans Webhook: Notifikasi diterima.', [
            'order_id'           => $orderId,
            'transaction_status' => $transactionStatus,
            'payment_type'       => $paymentType,
            'status_code'        => $statusCode,
            'fraud_status'       => $fraudStatus,
            'gross_amount'       => $grossAmount,
            'transaction_id'     => $transactionId,
        ]);

        // =============================================
        // STEP 4: Cari internal order ID
        // =============================================
        $internalOrderId = $this->resolveOrderId($orderId);
        if (is_null($internalOrderId)) {
            Log::warning('Midtrans Webhook: Order not found for Midtrans order_id.', ['midtrans_order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // =============================================
        // STEP 5: Idempotency Guard — jangan proses ulang jika sudah lunas
        // =============================================
        $existingPayment = Payment::where('order_id', $internalOrderId)->first();
        if ($existingPayment && $existingPayment->status_pembayaran === 'success') {
            Log::info('Midtrans Webhook: Notifikasi sudah diproses sebelumnya (lunas), dilewati.', [
                'order_id' => $orderId,
            ]);
            return response()->json(['message' => 'Already processed'], 200);
        }

        // =============================================
        // STEP 6: Tentukan status pembayaran baru berdasarkan transaction_status & fraud_status
        // =============================================
        $newStatus = null;
        if ($transactionStatus === 'capture') {
            $newStatus = ($fraudStatus === 'challenge') ? 'challenge' : 'success';
        } elseif ($transactionStatus === 'settlement') {
            $newStatus = 'success';
        } elseif ($transactionStatus === 'pending') {
            $newStatus = 'pending';
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $newStatus = 'failed';
        }

        // =============================================
        // STEP 7: Simpan / Perbarui Payment & Order secara atomis
        // =============================================
        $payment = DB::transaction(function () use ($orderId, $internalOrderId, $grossAmount, $paymentType, $transactionId, $newStatus) {
            $paymentData = [
                'midtrans_order_id' => $orderId,
                'jumlah_bayar'      => $grossAmount,
            ];

            if (!empty($paymentType)) {
                $paymentData['payment_type']      = $paymentType;
                $paymentData['metode_pembayaran'] = $paymentType;
            }

            if (!empty($transactionId)) {
                $paymentData['midtrans_transaction_id'] = $transactionId;
            }

            if ($newStatus !== null) {
                $paymentData['status_pembayaran'] = $newStatus;
            }

            $paymentRecord = Payment::updateOrCreate(
                ['order_id' => $internalOrderId],
                $paymentData
            );

            // Update status pesanan di tabel orders jika lunas
            if ($newStatus === 'success') {
                $order = Order::find($internalOrderId);
                if ($order) {
                    $order->status = 'Lunas';
                    $order->save();
                }
            }

            return $paymentRecord;
        });

        Log::info('Midtrans Webhook: Status pembayaran diperbarui.', [
            'order_id'          => $orderId,
            'status_pembayaran' => $payment->status_pembayaran,
            'transaction_id'    => $transactionId,
            'payment_type'      => $paymentType,
        ]);

        // Selalu kembalikan HTTP 200 agar Midtrans tidak mengirim ulang notifikasi
        return response()->json(['message' => 'Webhook diproses'], 200);
    }
}