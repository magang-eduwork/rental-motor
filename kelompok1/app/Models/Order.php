<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id', // Pastikan kolom ini ada di database jika ingin menggunakan relasi
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

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product (Ini yang menyebabkan error sebelumnya)
    // Pastikan foreign key 'product_id' sesuai dengan nama kolom di tabel orders Anda
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi ke OrderItems
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}