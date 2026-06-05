<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Destinasi;
use App\Models\Jadwal;
use App\Models\Promo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private Destinasi $destinasi;
    private Jadwal $jadwal;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat Destinasi
        $this->destinasi = Destinasi::create([
            'nama' => 'Pantai Kuta',
            'deskripsi' => 'Pantai indah di Bali',
            'lokasi' => 'Badung, Bali',
            'negara' => 'Indonesia',
            'harga_dasar' => 500000.00,
            'gambar' => null,
            'kategori' => 'domestik',
            'is_aktif' => true,
        ]);

        // 2. Buat Jadwal untuk Destinasi tersebut
        $this->jadwal = Jadwal::create([
            'destinasi_id' => $this->destinasi->id,
            'tanggal_berangkat' => now()->addDays(5)->toDateString(),
            'tanggal_pulang' => now()->addDays(10)->toDateString(),
            'kuota' => 10,
            'sisa_kursi' => 10,
            'harga' => 500000.00,
            'status' => 'tersedia',
        ]);
    }

    /**
     * Test pembuatan booking baru berhasil memotong sisa kursi.
     */
    public function test_booking_creation_decrements_seats(): void
    {
        $response = $this->post(route('booking.store', $this->jadwal->id), [
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 3,
        ]);

        // Cek redirect ke invoice
        $booking = Booking::first();
        $this->assertNotNull($booking);
        $response->assertRedirect(route('bookings.invoice.show', $booking->id));

        // Cek database booking tersimpan benar
        $this->assertDatabaseHas('bookings', [
            'nama_pelanggan' => 'Budi Santoso',
            'jumlah_peserta' => 3,
            'status' => 'pending',
            'total_bayar' => 1500000.00, // 500k * 3
        ]);

        // Cek sisa kursi berkurang dari 10 menjadi 7
        $this->jadwal->refresh();
        $this->assertEquals(7, $this->jadwal->sisa_kursi);
        $this->assertEquals('tersedia', $this->jadwal->status);
    }

    /**
     * Test booking dengan promo diskon persentase.
     */
    public function test_booking_creation_with_percentage_promo(): void
    {
        $promo = Promo::create([
            'kode' => 'DISKON10',
            'nama' => 'Diskon Pembukaan 10%',
            'tipe_diskon' => 'persentase',
            'nilai_diskon' => 10.00,
            'is_aktif' => true,
            'expired_at' => now()->addDays(1)->toDateString(),
        ]);

        $this->post(route('booking.store', $this->jadwal->id), [
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 2,
            'promo_id' => $promo->id,
        ]);

        $booking = Booking::first();
        $this->assertNotNull($booking);

        // Harga dasar: 500k * 2 = 1.000k. Diskon 10% = 100k. Total Bayar = 900k.
        $this->assertEquals(900000.00, floatval($booking->total_bayar));
    }

    /**
     * Test simulasi pembayaran tidak merubah jumlah sisa kursi.
     */
    public function test_simulated_payment_does_not_change_seats(): void
    {
        // 1. Buat Booking
        $booking = Booking::create([
            'jadwal_id' => $this->jadwal->id,
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 2,
            'total_bayar' => 1000000.00,
            'status' => 'pending',
        ]);

        // Sisa kursi awal terpotong saat booking dibuat (dalam setup nyata lewat controller / event)
        // Karena di test kita buat Booking menggunakan ::create, event 'creating' di Booking.php otomatis memotong kursi.
        $this->jadwal->refresh();
        $this->assertEquals(8, $this->jadwal->sisa_kursi);

        // 2. Jalankan simulasi pembayaran
        $response = $this->post(route('bookings.simulate-payment', $booking->id));
        $response->assertSessionHas('success', 'Pembayaran berhasil disimulasikan!');

        // 3. Status booking berubah menjadi 'dibayar'
        $booking->refresh();
        $this->assertEquals('dibayar', $booking->status);

        // 4. Sisa kursi HARUS tetap 8 (tidak terpotong lagi)
        $this->jadwal->refresh();
        $this->assertEquals(8, $this->jadwal->sisa_kursi);
    }

    /**
     * Test pembatalan pesanan mengembalikan sisa kursi ke jadwal semula.
     */
    public function test_cancelled_booking_restores_seats(): void
    {
        $booking = Booking::create([
            'jadwal_id' => $this->jadwal->id,
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 2,
            'total_bayar' => 1000000.00,
            'status' => 'pending',
        ]);

        $this->jadwal->refresh();
        $this->assertEquals(8, $this->jadwal->sisa_kursi);

        // Ubah status menjadi dibatalkan
        $booking->update(['status' => 'dibatalkan']);

        // Sisa kursi harus dikembalikan menjadi 10
        $this->jadwal->refresh();
        $this->assertEquals(10, $this->jadwal->sisa_kursi);
    }

    /**
     * Test pemblokiran pemesanan jika status jadwal tidak tersedia (dibatalkan).
     */
    public function test_cannot_book_cancelled_schedule(): void
    {
        // Ubah status jadwal menjadi dibatalkan
        $this->jadwal->update(['status' => 'dibatalkan']);

        $response = $this->post(route('booking.store', $this->jadwal->id), [
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 1,
        ]);

        $response->assertRedirect(route('destinasi.show', $this->destinasi->id));
        $response->assertSessionHas('error', 'Maaf, jadwal ini sudah penuh atau tidak tersedia.');

        // Booking tidak tersimpan di DB
        $this->assertEquals(0, Booking::count());
    }

    /**
     * Test pemblokiran pemesanan jika sisa kursi tidak cukup.
     */
    public function test_cannot_book_exceeding_seats(): void
    {
        // Mencoba memesan 11 kursi padahal kuota hanya 10
        $response = $this->post(route('booking.store', $this->jadwal->id), [
            'nama_pelanggan' => 'Budi Santoso',
            'email_pelanggan' => 'budi@example.com',
            'nomor_handphone' => '08123456789',
            'jumlah_peserta' => 11,
        ]);

        $response->assertSessionHasErrors('jumlah_peserta');
        $this->assertEquals(0, Booking::count());
    }
}
