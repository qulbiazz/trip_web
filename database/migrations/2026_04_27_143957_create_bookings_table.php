<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->string('nomor_invoice')->nullable()->unique();
            $table->foreignId('jadwal_id')->constrained('jadwals')->cascadeOnDelete();
            $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete();
            $table->string('nama_pelanggan');
            $table->string('email_pelanggan')->nullable();
            $table->string('nomor_handphone', 50)->nullable();
            $table->text('alamat_penjemputan')->nullable();
            $table->json('nama_anggota')->nullable();
            $table->integer('jumlah_peserta');
            $table->decimal('total_bayar', 12, 2);
            $table->enum('status', ['pending', 'dikonfirmasi', 'dibayar', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
