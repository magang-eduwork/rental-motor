<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create(Product $product)
    {
        return view('booking.checkout', compact('product'));
    }

    public function showVehicle(Product $product)
    {
        return view('order.vehicle-display', compact('product'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'product_id'    => ['required', 'exists:products,id'],
            'tanggal_sewa'  => ['required', 'date', 'after_or_equal:today'],
            'durasi'        => ['required', 'integer', 'min:1', 'max:30'],
            'no_ktp'        => ['required', 'string', 'max:20'],
            'no_sim'        => ['required', 'string', 'max:20'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user    = Auth::user();

        // 2. Kalkulasi Tanggal & Harga
        // Karena form tidak punya jam_sewa, kita gunakan default '08:00:00'
        $tanggalSewa    = $validated['tanggal_sewa'] . ' 08:00:00';
        $durasi         = (int) $validated['durasi'];
        $tanggalSelesai = date('Y-m-d H:i:s', strtotime($tanggalSewa . ' +' . $durasi . ' days'));
        $totalHarga     = $product->harga_per_hari * $durasi;

        // 3. Proses Transaksi Database
        $order = DB::transaction(function () use ($validated, $product, $user, $tanggalSewa, $tanggalSelesai, $totalHarga, $durasi) {
            
            $newOrder = Order::create([
                'user_id'         => $user->id,
                'product_id'      => $product->id,
                'kode_booking'    => 'BK-' . strtoupper(Str::random(8)),
                'nama_motor'      => $product->nama_motor,
                'nama_pemesan'    => $user->name,
                'no_wa'           => $user->phone ?? '-', // Pastikan nama kolom di DB sesuai (phone atau whatsapp)
                'no_ktp'          => $validated['no_ktp'],
                'no_sim'          => $validated['no_sim'],
                'tanggal_booking' => now(),
                'tanggal_sewa'    => $tanggalSewa,
                'tanggal_selesai' => $tanggalSelesai,
                'durasi_hari'     => $durasi,
                'status'          => 'pending',
                'harga'           => $totalHarga,
            ]);

            OrderItem::create([
                'order_id'        => $newOrder->id,
                'product_id'      => $product->id,
                'harga_saat_sewa' => $product->harga_per_hari,
            ]);

            return $newOrder;
        });

        return redirect()->route('order.index')
            ->with('success', "Booking berhasil! Kode booking Anda: {$order->kode_booking}");
    }
}