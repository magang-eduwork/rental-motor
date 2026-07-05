<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->string('nama_motor');
            $table->string('nama_pemesan')->nullable(); // Kolom yang tadinya Anda tambah terpisah
            $table->string('no_wa')->nullable();
            $table->date('tanggal_booking');
            $table->datetime('tanggal_sewa')->nullable();
            $table->datetime('tanggal_selesai')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};