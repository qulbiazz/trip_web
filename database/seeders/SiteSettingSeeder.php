<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opsional: Kosongkan tabel terlebih dahulu agar tidak ada data ganda saat di-seed ulang
        DB::table('site_settings')->truncate();

        SiteSetting::create([
            'site_name' => 'Lokachara',
            'hero_badge' => 'PROMO SPESIAL LIBURAN',
            'hero_highlight' => 'Spesial',
            'hero_title' => 'Penawaran',
            'hero_description' => 'Dapatkan potongan harga khusus untuk perjalanan ke destinasi favoritmu bulan ini. Kuota sangat terbatas!',
            'hero_image' => null, 
            'cta_primary_text' => 'Pesan Sekarang',
            'cta_secondary_text' => 'Hubungi Kami',
            'is_active' => true,
        ]);
    }
}