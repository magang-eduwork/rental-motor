<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Rute Halaman Utama & Publik
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    $products = Product::take(4)->get();
    return view('home', compact('products'));
})->name('home');

Route::get('/kendaraan', function () {
    $query = Product::query();

    if (request('tipe') && request('tipe') !== 'Semua') {
        $query->where('tipe', request('tipe'));
    }
    if (request('cari')) {
        $query->where('nama_motor', 'like', '%' . request('cari') . '%');
    }

    $products = $query->get();
    $tipes = Product::select('tipe')->distinct()->pluck('tipe');

    return view('kendaraan', compact('products', 'tipes'));
})->name('kendaraan');

// Rute yang membutuhkan Login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Booking
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Rute Modul Pemesanan (Order)
    // Dipindahkan ke dalam middleware 'auth' agar akses lebih aman
    Route::prefix('daftar-pesanan')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        
        // Menggunakan {id} agar eksplisit cocok dengan parameter $id di Controller
        Route::get('/{id}', [OrderController::class, 'show'])->name('order.show');
    });
});

require __DIR__.'/auth.php';