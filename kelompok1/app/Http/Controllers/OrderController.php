<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan.
     *
     * @return View
     */
    public function index(): View
    {
        $orders = Order::latest()->get();
        

        return view('order.index', compact('orders'));
    }
}