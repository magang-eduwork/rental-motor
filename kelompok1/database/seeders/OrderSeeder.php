<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order; // Pastikan model Order sudah diimpor

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'kode_booking' => 'ED.000001',
            'nama_motor' => 'Supra X - 125cc',
            'tanggal_booking' => '2026-11-12',
            'status' => 'Belum bayar',
            'harga' => 80000.00,
        ]);

        Order::create([
            'kode_booking' => 'ED.000002',
            'nama_motor' => 'Vega Force',
            'tanggal_booking' => '2026-11-13',
            'status' => 'Sedang dibawa',
            'harga' => 75000.00,
        ]);
    }
}