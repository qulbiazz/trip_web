<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bookings', 'nama_anggota')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->json('nama_anggota')->nullable()->after('alamat_penjemputan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('bookings', 'nama_anggota')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('nama_anggota');
            });
        }
    }
};
