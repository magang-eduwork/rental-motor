<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Rute Halaman Utama & Publik
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    $products = \App\Models\Product::take(4)->get();
    return view('home', compact('products'));
})->name('home');

Route::get('/kendaraan', function () {
    $query = \App\Models\Product::query();

    if (request('tipe') && request('tipe') !== 'Semua') {
        $query->where('tipe', request('tipe'));
    }
    if (request('cari')) {
        $query->where('nama_motor', 'like', '%' . request('cari') . '%');
    }

    $products = $query->get();
    $tipes = \App\Models\Product::select('tipe')->distinct()->pluck('tipe');

    return view('kendaraan', compact('products', 'tipes'));
})->name('kendaraan');

// User sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Booking
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
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

require __DIR__.'/auth.php';
