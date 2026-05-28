<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('konten');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // Seed initial static data from welcome.blade.php
        DB::table('testimonis')->insert([
            [
                'nama' => 'Ahmad Budi',
                'rating' => 5,
                'konten' => 'Pengalaman liburan ke Bali bersama Lokachara sangat luar biasa. Tour guide-nya ramah, itinerary sangat rapi, dan fasilitas hotelnya di luar ekspektasi. Sangat direkomendasikan!',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Rahmawati',
                'rating' => 5,
                'konten' => 'Pertama kali pakai Lokachara buat honeymoon ke Lombok. Harga paketnya transparan, gak ada hidden fee. Pelayanannya benar-benar VIP. Makasih Lokachara!',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dimas Pratama',
                'rating' => 5,
                'konten' => 'Customer service responsif banget. Sempet ada kendala pas mau reschedule tiket, tapi tim Lokachara ngebantu urusin semuanya dengan cepat dan gampang.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
