<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Rute Halaman Utama & Publik
Route::get('/', fn () => view('welcome'));
Route::get('/home', fn () => view('home'))->name('home');

use App\Http\Controllers\AuthController;

// Guest (belum login)
Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// User sudah login
Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});

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