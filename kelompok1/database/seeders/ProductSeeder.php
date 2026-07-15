<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * https://ibb.co.com/5xf0FhHv
     */

    public function run(): void
    {
        $motors = [
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9001 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9002 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9003 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9004 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9005 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Vega Force', 'tipe' => 'Motor Bebek', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9006 DE', 'image_url' => 'https://i.ibb.co.com/VYfhgqm4/image-44.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9007 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9008 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9009 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9010 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9011 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
            ['nama_motor' => 'Scoopy', 'tipe' => 'Matic', 'harga_per_hari' => 75000, 'status' => 'tersedia', 'plat_nomor' => 'AB 9012 DE', 'image_url' => 'https://i.ibb.co.com/FqjrV4TJ/image-15.png'],
        ];
        foreach ($motors as $motor) {
            \App\Models\Product::create($motor);
        }
    }
}
