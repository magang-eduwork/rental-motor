<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Middleware\IsAdmin; 
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===================================================================
// --- 1. RUTE PUBLIK (Bisa Diakses Semua Tanpa Login)              ---
// ===================================================================
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

    $products = $query->paginate(12)->withQueryString();
    $tipes = Product::select('tipe')->distinct()->pluck('tipe');

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


    return view('kendaraan', compact('products', 'tipes'));
})->name('kendaraan');

Route::get('/kendaraan/{product}/detail', [BookingController::class, 'showVehicle'])->name('vehicle.display');

// --- Rute Webhook Midtrans (Bebas CSRF & Wajib di Luar Auth) ---
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handleNotification'])->name('midtrans.webhook');


// ===================================================================
// --- 2. RUTE PELANGGAN / USER BIASA (Wajib Login)                ---
// ===================================================================
Route::middleware('auth')->group(function () {
    
    // Kelola Profil Pelanggan
        Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    
    // Alur Transaksi & Pemesanan Kendaraan
        Route::prefix('booking')->group(function () {
        Route::get('/checkout/{product}', [BookingController::class, 'create'])->name('booking.checkout');
        Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
    });

    // Manajemen Order Sisi Pelanggan
        Route::prefix('daftar-pesanan')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');
        
        // Fitur Pembaruan Status Lokal Khusus Sisi User
        Route::post('/{id}/update-status-lokal', [OrderController::class, 'updateStatusLokal'])->name('order.update-status-lokal');
    });
});


// ===================================================================
// --- 3. RUTE KHUSUS ADMIN (Wajib Login & Wajib Lolos IsAdmin)     ---
// ===================================================================
// KOREKSI: Memanggil langsung IsAdmin::class untuk memotong error akibat alias tidak terdaftar
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Halaman Kelola Daftar Pesanan Versi Admin (Menampilkan Kartu & Filter)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    
    // API Perubahan Status Admin via AJAX Modal
    Route::patch('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    
    // Halaman Kelola Data Armada Kendaraan
    Route::get('/kendaraan', [AdminController::class, 'kendaraan'])->name('kendaraan.index');
});

require __DIR__.'/auth.php';
