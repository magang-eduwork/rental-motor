<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product; // Pastikan Model Product di-import
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan filter & pagination untuk Admin (Read).
     */
    public function index(Request $request)
    {
        $query = Order::with(['product', 'payment']);

        // 1. Filter berdasarkan Status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        // 2. Filter berdasarkan Tipe Kendaraan / Nama Motor (Disesuaikan dengan relasi product)
        if ($request->filled('tipe_kendaraan') && $request->tipe_kendaraan !== 'Semua') {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('tipe', $request->tipe_kendaraan)
                  ->orWhere('nama_motor', 'like', '%' . $request->tipe_kendaraan . '%');
            });
        }

        // 3. Filter berdasarkan Tanggal Booking
        if ($request->filled('tanggal_booking')) {
            $query->whereDate('tanggal_booking', $request->tanggal_booking);
        }

        // 4. Pencarian Umum (Nama motor, Kode Booking, atau Nama Pemesan)
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nama_motor', 'like', "%{$cari}%")
                  ->orWhere('kode_booking', 'like', "%{$cari}%")
                  ->orWhere('nama_pemesan', 'like', "%{$cari}%");
            });
        }

        // Ambil data dengan pagination (10 data per halaman) diurutkan dari terbaru
        $orders = $query->latest()->paginate(7)->withQueryString();

        // Ambil daftar unik tipe/nama motor dari tabel Product agar sinkron dengan dropdown view
        $motorOptions = Product::pluck('tipe')->unique()->filter();
        if ($motorOptions->isEmpty()) {
            $motorOptions = Order::select('nama_motor')->distinct()->pluck('nama_motor');
        }

        return view('admin.pesanan.index', compact('orders', 'motorOptions'));
    }

    /**
     * Memperbarui status, tanggal sewa, dan tanggal selesai pesanan dari modal pop-up (Update & Edit).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required|string|in:Pending,Lunas,Sedang dibawa,Sudah kembali,Batal',
            'tanggal_sewa'    => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        $order = Order::findOrFail($id);
        
        // Memperbarui data pesanan ke database secara aman
        $order->status = $request->status;
        $order->tanggal_sewa = $request->tanggal_sewa;
        $order->tanggal_selesai = $request->tanggal_selesai;
        $order->save();

        // Sinkronkan status pembayaran untuk metode Tunai
        if ($order->payment && $order->payment->metode_pembayaran === 'Tunai') {

            if ($request->status === 'Pending') {
                $order->payment->update([
                    'status_pembayaran' => 'pending'
                ]);
            }

            if ($request->status === 'Lunas') {
                $order->payment->update([
                    'status_pembayaran' => 'success'
                ]);
            }
        }

        if ($request->status === 'Sedang dibawa') {
            if ($order->product) {
                $order->product->update([
                    'status' => 'tidak_tersedia'
                ]);
            }
        }

        if ($request->status === 'Sudah kembali' || $request->status === 'Batal') {
            if ($order->product) {
                $order->product->update([
                    'status' => 'tersedia'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pemesanan berhasil diperbarui.'
        ]);
    }
}