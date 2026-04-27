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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('OmniStock Travel');
            $table->string('hero_badge')->default('Eksplorasi Dunia Bersama Kami');
            $table->string('hero_title')->default('Jelajahi Destinasi');
            $table->string('hero_highlight')->default('Impian Anda');
            $table->text('hero_description')->nullable();
            $table->string('cta_primary_text')->default('Lihat Destinasi');
            $table->string('cta_secondary_text')->default('Cek Promo');
            $table->string('feature_title')->default('Kenapa Memilih Kami?');
            $table->text('feature_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
