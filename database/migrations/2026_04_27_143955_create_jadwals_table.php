<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destinasi_id')->constrained('destinasis')->cascadeOnDelete();
            $table->date('tanggal_berangkat');
            $table->date('tanggal_pulang');
            $table->date('pendaftaran_mulai');
            $table->date('pendaftaran_tutup');
            $table->integer('kuota');
            $table->integer('sisa_kursi');
            $table->decimal('harga', 12, 2);
            $table->enum('status', ['tersedia', 'penuh', 'dibatalkan'])->default('tersedia');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
