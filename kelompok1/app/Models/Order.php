<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_booking',
        'nama_motor',
        'nama_pemesan',
        'no_wa',
        'tanggal_booking',
        'tanggal_sewa',
        'tanggal_selesai',
        'durasi_hari',
        'status',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'harga'           => 'decimal:2',
            'tanggal_booking' => 'date',
            'tanggal_sewa'    => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}