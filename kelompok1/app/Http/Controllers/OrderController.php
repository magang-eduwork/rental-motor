<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan pagination.
     */
    public function index(): View
    {
        // Mengambil data pesanan terbaru
        $orders = Order::latest()->paginate(10);
        
        return view('order.index', compact('orders'));
    }

    /**
     * Mengambil detail pesanan untuk popup modal.
     * Menggunakan Route Model Binding (Order $order) agar Laravel 
     * otomatis mencari data berdasarkan ID di rute.
     */
    public function show(Order $order): JsonResponse
    {
        // Karena database sudah diperbarui, $order sudah mengandung 
        // kolom baru seperti nama_pemesan, no_wa, dsb.
        return response()->json($order);
    }
}