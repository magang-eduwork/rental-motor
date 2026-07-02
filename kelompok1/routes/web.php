<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk daftar pesanan
// Menggunakan OrderController untuk menangani logika pemesanan
Route::get('/daftar-pesanan', [OrderController::class, 'index'])->name('order.index');