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
            if (!Schema::hasColumn('jadwals', 'pendaftaran_mulai')) {
                $table->date('pendaftaran_mulai')
                    ->nullable()
                    ->after('destinasi_id');
            }

            if (!Schema::hasColumn('jadwals', 'pendaftaran_tutup')) {
                $table->date('pendaftaran_tutup')
                    ->nullable()
                    ->after('pendaftaran_mulai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('jadwals', 'pendaftaran_mulai')) {
                $columns[] = 'pendaftaran_mulai';
            }
            if (Schema::hasColumn('jadwals', 'pendaftaran_tutup')) {
                $columns[] = 'pendaftaran_tutup';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
