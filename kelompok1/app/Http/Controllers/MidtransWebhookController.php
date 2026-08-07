<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request): JsonResponse
    {
        Log::info('Midtrans Webhook Masuk', $request->all());

        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('Payment tidak ditemukan', [
                'order_id' => $orderId,
            ]);

            return response()->json([
                'message' => 'OK'
            ], 200);
        }

        switch ($status) {
            case 'settlement':
                $payment->status_pembayaran = 'success';
                break;

            case 'pending':
                $payment->status_pembayaran = 'pending';
                break;

            case 'expire':
                $payment->status_pembayaran = 'expired';
                break;

            case 'cancel':
            case 'deny':
                $payment->status_pembayaran = 'failed';
                break;
        }

        $payment->payment_type = $request->payment_type;
        $payment->midtrans_transaction_id = $request->transaction_id;
        $payment->save();

        return response()->json([
            'message' => 'Webhook diproses'
        ]);
    }
}