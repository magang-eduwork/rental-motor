<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan Halaman Utama Dashboard Admin secara Dinamis
     */
    public function dashboard(Request $request)
    {
        // 1. Jumlah Kendaraan (Menyesuaikan status dari migration products)
        $totalKendaraan = Product::count();
        $kendaraanTersedia = Product::where('status', 'tersedia')->count();
        $kendaraanDisewa = Product::where('status', 'tidak_tersedia')->count();
        $jumlahBookingan = Payment::whereIn('status_pembayaran', ['success'])->count();

        // Jumlah kendaraan per tipe untuk diagram
        $kendaraanPerTipe = Product::select('tipe', DB::raw('count(*) as total'))
                            ->groupBy('tipe')
                            ->orderByDesc('total')
                            ->get();

        // 2. Pendapatan (Berdasarkan filter Tipe Kendaraan & Rentang Tanggal)
        $queryPendapatan = Payment::where('status_pembayaran', 'success');

        if ($request->filled('tipe_kendaraan') && $request->tipe_kendaraan !== 'Semua') {
            $queryPendapatan->whereHas('order.product', function($q) use ($request) {
                $q->where('nama_motor', $request->tipe_kendaraan);
            });
        }
        if ($request->filled('tanggal_awal')) {
            $queryPendapatan->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $queryPendapatan->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $totalPendapatan = $queryPendapatan->sum('jumlah_bayar');

        // 3. Pesanan Terakhir
        $pesananTerakhir = Order::with(['product', 'payment'])
                            ->latest()
                            ->take(9)
                            ->get();

        // 4. 5 Top Orderan Rental (Menggunakan relasi product agar akurat berdasarkan nama motor)
        $topOrderan = Order::select('product_id', DB::raw('count(*) as total'))
                        ->with('product')
                        ->whereNotNull('product_id')
                        ->groupBy('product_id')
                        ->orderByDesc('total')
                        ->take(5)
                        ->get()
                        ->map(function ($order) {
                            return [
                                'nama_motor' => $order->product->nama_motor ?? 'Unknown',
                                'total' => $order->total
                            ];
                        });

        $totalSemuaOrder = Order::count();
        
        // Opsi Tipe Kendaraan diambil dari master data products
        $tipeKendaraanOptions = Product::select('nama_motor')->distinct()->pluck('nama_motor');

        return view('admin.dashboard', compact(
            'totalKendaraan',
            'kendaraanTersedia',
            'kendaraanDisewa',
            'kendaraanPerTipe',
            'jumlahBookingan',
            'totalPendapatan',
            'pesananTerakhir',
            'topOrderan',
            'totalSemuaOrder',
            'tipeKendaraanOptions'
        ));
    }

    /**
     * Menampilkan Halaman Kelola Kendaraan
     */
    public function kendaraan()
    {
        return view('admin.kendaraan.index');
    }
}