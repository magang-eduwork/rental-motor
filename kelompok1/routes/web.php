<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// --- Rute Publik ---
// Menggunakan sintaks ringkas untuk route sederhana
Route::get('/', fn() => view('welcome'));

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

    // Cek booking kendaraan untuk tanggal sewa yang dipilih
    $tanggalSewa = request('tanggal_sewa', date('Y-m-d', strtotime('+1 day')));
    $jamSewa = request('jam_sewa', '08:00');
    $durasi = (int) request('durasi', 1);

    try {
        $reqStart = \Illuminate\Support\Carbon::parse($tanggalSewa . ' ' . $jamSewa);
        $reqEnd = $reqStart->copy()->addDays($durasi);
    } catch (\Exception $e) {
        $reqStart = \Illuminate\Support\Carbon::tomorrow()->setTime(8, 0);
        $reqEnd = $reqStart->copy()->addDays(1);
    }

    $bookedProductIds = \App\Models\Order::whereNotIn('status', ['Batal', 'batal'])
        ->where(function ($q) use ($reqStart, $reqEnd) {
            $q->where('tanggal_sewa', '<', $reqEnd)
              ->where('tanggal_selesai', '>', $reqStart);
        })
        ->pluck('product_id')
        ->filter()
        ->unique()
        ->toArray();

    return view('kendaraan', compact('products', 'tipes', 'bookedProductIds'));
})->name('kendaraan');

// --- Rute Terproteksi (Login Required) ---
Route::middleware('auth')->group(function () {
    
    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    
    // Booking & Checkout Flow
    Route::prefix('booking')->group(function () {
        // Halaman Checkout: Menggunakan route model binding otomatis
        Route::get('/checkout/{product}', [BookingController::class, 'create'])->name('booking.checkout');
        
        // Memproses Pesanan: Tetap gunakan .store sebagai nama standar
        Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
    });

    // Order Management
    Route::prefix('daftar-pesanan')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::post('/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');
        Route::get('/{id}', [OrderController::class, 'show'])->name('order.show');
    });
});

require __DIR__.'/auth.php';