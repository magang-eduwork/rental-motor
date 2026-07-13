<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_motor',
        'tipe',
        'harga_per_hari',
        'status',
        'image_url',
        'plat_nomor',
    ];
}
