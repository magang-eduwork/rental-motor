<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Halaman Utama Dashboard Admin
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Menampilkan Halaman Daftar Pesanan dengan Fitur Filter & Pencarian
     */
    public function pesanan(Request $request)
    {
        $query = Order::query();

        // 1. Filter Berdasarkan Status (Pending, Lunas, Batal, Sedang dibawa, Sudah kembali)
        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        // 2. Filter Berdasarkan Nama/Tipe Kendaraan
        if ($request->filled('tipe_kendaraan') && $request->tipe_kendaraan !== 'Semua') {
            $query->where('nama_motor', 'like', '%' . $request->tipe_kendaraan . '%');
        }

        // 3. Filter Berdasarkan Tanggal Booking
        if ($request->filled('tanggal_booking')) {
            $query->whereDate('tanggal_booking', $request->tanggal_booking);
        }

        // 4. Pencarian Berdasarkan Kata Kunci (Nama Motor, Kode Booking, atau Nama Pemesan)
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_motor', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode_booking', 'like', '%' . $request->cari . '%')
                  ->orWhere('nama_pemesan', 'like', '%' . $request->cari . '%');
            });
        }

        // Mengambil data pesanan terbaru dengan pagination (10 data per halaman)
        $orders = $query->latest()->paginate(10)->withQueryString();
        
        // Mengambil daftar nama motor yang unik untuk mengisi opsi pilihan di Dropdown Tipe Kendaraan
        $motorOptions = Order::select('nama_motor')->distinct()->pluck('nama_motor');

        return view('admin.pesanan.index', compact('orders', 'motorOptions'));
    }

    /**
     * Mengubah Status Pembayaran/Operasional Pesanan dari Sisi Admin (Terintegrasi AJAX)
     */
    public function updateStatusPesanan(Request $request, $id)
    {
        // Validasi input status agar sesuai dengan opsi yang ada di sistem
        $request->validate([
            'status' => 'required|string|in:Pending,Lunas,Batal,Sedang dibawa,Sudah kembali'
        ]);

        try {
            // Cari data order berdasarkan ID
            $order = Order::findOrFail($id);
            
            // Perbarui status dan simpan ke database
            $order->status = $request->status;
            $order->save();

            // Kembalikan respons JSON sukses untuk ditangkap oleh JavaScript di View
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan ' . $order->kode_booking . ' berhasil diperbarui menjadi ' . $request->status
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan respons gagal
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan Halaman Kelola Kendaraan
     */
    public function kendaraan()
    {
        return view('admin.kendaraan.index');
    }
}