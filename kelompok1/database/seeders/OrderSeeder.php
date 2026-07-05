<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'kode_booking'    => 'ED.000001',
            'nama_motor'      => 'Supra X - 125cc',
            'nama_pemesan'    => 'Valentino Rossi',
            'no_wa'           => '089675435567',
            'tanggal_booking' => '2026-11-12',
            'tanggal_sewa'    => '2026-12-23 17:00:00',
            'tanggal_selesai' => '2026-12-24 17:00:00',
            'status'          => 'Belum bayar',
            'harga'           => 80000.00,
        ]);

        Order::create([
            'kode_booking'    => 'ED.000002',
            'nama_motor'      => 'Vega Force',
            'nama_pemesan'    => 'Marc Marquez',
            'no_wa'           => '081234567890',
            'tanggal_booking' => '2026-11-13',
            'tanggal_sewa'    => '2026-12-25 09:00:00',
            'tanggal_selesai' => '2026-12-26 09:00:00',
            'status'          => 'Sedang dibawa',
            'harga'           => 75000.00,
        ]);
    }
}