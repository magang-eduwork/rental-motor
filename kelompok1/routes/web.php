<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Rute Halaman Utama & Publik
Route::get('/', fn () => view('welcome'));
Route::get('/home', fn () => view('home'))->name('home');

// Rute Modul Pemesanan (Order)
// Gunakan prefix agar rute detail tidak konflik dengan URL lain
Route::prefix('daftar-pesanan')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        // GET /daftar-pesanan
        Route::get('/', 'index')->name('order.index');
        
        // GET /daftar-pesanan/{order}
        // Penambahan prefix di atas mencegah rute ini menimpa URL lain
        Route::get('/{order}', 'show')->name('order.show');
    });
});