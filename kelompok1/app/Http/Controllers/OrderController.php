<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang login.
     */
    public function index(): View
    {
        $orders = Order::with('product')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
        
        $products = Product::limit(4)->get(); 

        return view('order.index', compact('orders', 'products'));
    }

    /**
     * Mengambil detail pesanan untuk popup modal.
     */
    public function show($id): JsonResponse
    {
        try {
            // Menggunakan findOrFail untuk menangani ID yang tidak ditemukan
            $order = Order::with('product')->findOrFail($id);

            // 1. Keamanan: Pastikan user hanya bisa melihat pesanan miliknya sendiri
            if ((int)$order->user_id !== (int)Auth::id()) {
                return response()->json(['message' => 'Akses ditolak'], 403);
            }

            return response()->json($order);
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        } catch (\Exception $e) {
            // Log error ini untuk melihat masalahnya di storage/logs/laravel.log
            \Log::error('Error fetching order: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    /**
     * Memproses pembayaran pesanan.
     */
    public function pay(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|in:Transfer,Tunai,QRIS',
        ]);

        $order = Order::findOrFail($id);

        // Keamanan: Pastikan user hanya bisa membayar pesanan miliknya sendiri
        if ((int)$order->user_id !== (int)Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        // Simpan data pembayaran ke database
        \App\Models\Payment::create([
            'order_id'          => $order->id,
            'jumlah_bayar'      => (int)$order->harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->metode_pembayaran === 'Tunai' ? 'pending' : 'lunas',
        ]);

        // Update status order ke 'Selesai' untuk menandakan pembayaran sukses / diterima
        $order->status = 'Selesai';
        $order->save();

        return redirect()->route('order.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Selamat berkendara.');
    }
}