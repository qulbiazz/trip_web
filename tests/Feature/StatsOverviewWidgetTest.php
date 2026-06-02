<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Destinasi;
use App\Models\Jadwal;
use App\Models\Promo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsOverviewWidgetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test query counts for destinations and schedules that have been run.
     */
    public function test_stats_overview_queries_are_correct(): void
    {
        // 1. Create a destinasi that has run (has past active schedule)
        $destinasiRun = Destinasi::create([
            'nama' => 'Destinasi Sudah Jalan',
            'deskripsi' => 'Deskripsi',
            'lokasi' => 'Lokasi',
            'negara' => 'Indonesia',
            'harga_dasar' => 100000.00,
            'gambar' => null,
            'kategori' => 'domestik',
            'is_aktif' => true,
        ]);

        // Past schedule (active)
        Jadwal::create([
            'destinasi_id' => $destinasiRun->id,
            'tanggal_berangkat' => now()->subDays(5)->toDateString(),
            'tanggal_pulang' => now()->subDays(1)->toDateString(),
            'kuota' => 10,
            'sisa_kursi' => 10,
            'harga' => 100000.00,
            'status' => 'tersedia',
        ]);

        // 2. Create another destinasi with only a future schedule (not run yet)
        $destinasiFuture = Destinasi::create([
            'nama' => 'Destinasi Belum Jalan',
            'deskripsi' => 'Deskripsi',
            'lokasi' => 'Lokasi',
            'negara' => 'Indonesia',
            'harga_dasar' => 200000.00,
            'gambar' => null,
            'kategori' => 'domestik',
            'is_aktif' => true,
        ]);

        // Future schedule
        Jadwal::create([
            'destinasi_id' => $destinasiFuture->id,
            'tanggal_berangkat' => now()->addDays(5)->toDateString(),
            'tanggal_pulang' => now()->addDays(10)->toDateString(),
            'kuota' => 10,
            'sisa_kursi' => 10,
            'harga' => 200000.00,
            'status' => 'tersedia',
        ]);

        // 3. Create a cancelled past schedule on a third destinasi (should not count as run)
        $destinasiCancelled = Destinasi::create([
            'nama' => 'Destinasi Batal',
            'deskripsi' => 'Deskripsi',
            'lokasi' => 'Lokasi',
            'negara' => 'Indonesia',
            'harga_dasar' => 300000.00,
            'gambar' => null,
            'kategori' => 'domestik',
            'is_aktif' => true,
        ]);

        Jadwal::create([
            'destinasi_id' => $destinasiCancelled->id,
            'tanggal_berangkat' => now()->subDays(2)->toDateString(),
            'tanggal_pulang' => now()->subDays(1)->toDateString(),
            'kuota' => 10,
            'sisa_kursi' => 10,
            'harga' => 300000.00,
            'status' => 'dibatalkan',
        ]);

        // Query the logic for "Destinasi Dijalankan"
        $destinasiRunCount = Destinasi::whereHas('jadwals', fn ($q) => $q->whereIn('status', ['tersedia', 'penuh'])->where('tanggal_berangkat', '<=', now()->toDateString()))->count();

        // Query the logic for "Trip Dijalankan"
        $tripRunCount = Jadwal::whereIn('status', ['tersedia', 'penuh'])->where('tanggal_berangkat', '<=', now()->toDateString())->count();

        // Assertions
        $this->assertEquals(1, $destinasiRunCount, 'Destinasi yang sudah dijalankan harusnya bernilai 1');
        $this->assertEquals(1, $tripRunCount, 'Trip/Jadwal yang sudah dijalankan harusnya bernilai 1');
    }
}
