<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Simpan pesanan baru dari halaman Daftar Kendaraan.
     * Route ini dilindungi middleware 'auth'.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => ['required', 'exists:products,id'],
            'tanggal_sewa'  => ['required', 'date', 'after_or_equal:today'],
            'jam_sewa'      => ['required', 'string'],
            'durasi'        => ['required', 'integer', 'min:1', 'max:30'],
        ]);

        $product = Product::findOrFail($request->product_id);
        $user    = $request->user();

        $tanggalSewa    = $request->tanggal_sewa . ' ' . $request->jam_sewa . ':00';
        $tanggalSelesai = date(
            'Y-m-d H:i:s',
            strtotime($tanggalSewa . ' +' . $request->durasi . ' days')
        );

        $totalHarga = $product->harga_per_hari * $request->durasi;

        // Buat order
        $order = Order::create([
            'user_id'          => $user->id,
            'kode_booking'     => 'BK-' . strtoupper(Str::random(8)),
            'nama_motor'       => $product->nama_motor,
            'nama_pemesan'     => $user->name,
            'no_wa'            => $user->whatsapp,
            'tanggal_booking'  => now(),
            'tanggal_sewa'     => $tanggalSewa,
            'tanggal_selesai'  => $tanggalSelesai,
            'durasi_hari'      => $request->durasi,
            'status'           => 'pending',
            'harga'            => $totalHarga,
        ]);

        // Buat order item
        OrderItem::create([
            'order_id'       => $order->id,
            'product_id'     => $product->id,
            'harga_saat_sewa'=> $product->harga_per_hari,
        ]);

        return redirect()->route('order.index')
            ->with('success', "Booking berhasil! Kode booking Anda: {$order->kode_booking}");
    }
}
