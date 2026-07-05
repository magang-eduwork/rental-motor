<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_booking',
        'nama_motor',
        'nama_pemesan',
        'no_wa',
        'tanggal_booking',
        'tanggal_sewa',
        'tanggal_selesai',
        'status',
        'harga',
    ];

    /**
     * Konversi tipe data otomatis.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga'           => 'decimal:2',
            'tanggal_booking' => 'date',
            'tanggal_sewa'    => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }
}