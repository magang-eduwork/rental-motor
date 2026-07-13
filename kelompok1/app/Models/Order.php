<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'kode_booking',
        'nama_motor',
        'nama_pemesan',
        'no_wa',
        'no_ktp',       // Ditambahkan untuk mendukung fitur Checkout
        'no_sim',       // Ditambahkan untuk mendukung fitur Checkout
        'tanggal_booking',
        'tanggal_sewa',
        'tanggal_selesai',
        'durasi_hari',
        'status',
        'harga',
    ];

    /**
     * Get the attributes that should be cast.
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

    /**
     * Relasi ke User (Pemesan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Product (Kendaraan yang disewa)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relasi ke OrderItems (Detail item pesanan)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}