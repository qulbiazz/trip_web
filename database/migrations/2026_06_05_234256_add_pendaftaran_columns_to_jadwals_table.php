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
        Schema::table('jadwals', function (Blueprint $table) {
            $table->date('pendaftaran_mulai')
                ->nullable()
                ->after('destinasi_id');

            $table->date('pendaftaran_tutup')
                ->nullable()
                ->after('pendaftaran_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn([
                'pendaftaran_mulai',
                'pendaftaran_tutup',
            ]);
        });
    }
};
