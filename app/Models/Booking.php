<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking',
        'nomor_invoice',
        'jadwal_id',
        'promo_id',
        'nama_pelanggan',
        'email_pelanggan',
        'nomor_handphone',
        'alamat_penjemputan',
        'nama_anggota',
        'jumlah_peserta',
        'total_bayar',
        'status',
    ];

    protected $casts = [
        'total_bayar' => 'decimal:2',
        'nama_anggota' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($booking) {
            if (blank($booking->kode_booking)) {
                $booking->kode_booking = 'BK-' . strtoupper(Str::random(8));
            }

            if (blank($booking->nomor_invoice)) {
                do {
                    $inv = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
                } while (static::query()->where('nomor_invoice', $inv)->exists());

                $booking->nomor_invoice = $inv;
            }

            if (blank($booking->status)) {
                $booking->status = 'pending';
            }

            // kursi kepotong kalau bukan batal & sudah pilih jadwal
            if ($booking->status !== 'dibatalkan' && $booking->jadwal_id) {
                static::applySeatChangesAtomic([
                    (int) $booking->jadwal_id => -((int) $booking->jumlah_peserta),
                ]);
            }
        });

        static::updating(function ($booking) {
            $jLama = (int) ($booking->getOriginal('jadwal_id') ?? 0);
            $jBaru = (int) ($booking->jadwal_id ?? 0);
            $qtyLama = (int) ($booking->getOriginal('jumlah_peserta') ?? 0);
            $qtyBaru = (int) ($booking->jumlah_peserta ?? 0);

            $pakaiLama = ($booking->getOriginal('status') ?? '') !== 'dibatalkan' ? $qtyLama : 0;
            $pakaiBaru = $booking->status !== 'dibatalkan' ? $qtyBaru : 0;

            if ($jLama !== $jBaru) {
                $changes = [];
                if ($jLama !== 0 && $pakaiLama !== 0) {
                    $changes[$jLama] = $pakaiLama; // kembalikan kursi ke jadwal lama
                }
                if ($jBaru !== 0 && $pakaiBaru !== 0) {
                    $changes[$jBaru] = -$pakaiBaru; // kurangi kursi di jadwal baru
                }
                if (!empty($changes)) {
                    static::applySeatChangesAtomic($changes);
                }
            } else {
                $delta = $pakaiLama - $pakaiBaru;
                if ($jLama !== 0 && $delta !== 0) {
                    static::applySeatChangesAtomic([
                        $jLama => $delta,
                    ]);
                }
            }
        });

        static::deleting(function ($booking) {
            if ($booking->status !== 'dibatalkan' && $booking->jadwal_id) {
                static::applySeatChangesAtomic([
                    (int) $booking->jadwal_id => (int) $booking->jumlah_peserta,
                ]);
            }
        });
    }

    protected static function applySeatChangesAtomic(array $seatChanges): void
    {
        DB::transaction(function () use ($seatChanges): void {
            $ids = array_map('intval', array_keys($seatChanges));
            sort($ids);

            $rows = Jadwal::query()
                ->whereIn('id', $ids)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($seatChanges as $jadwalId => $delta) {
                $j = $rows->get((int) $jadwalId);
                if (! $j) {
                    throw ValidationException::withMessages([
                        'jadwal_id' => 'Jadwal tidak ditemukan.',
                    ]);
                }

                $sisa = (int) $j->sisa_kursi;
                $kuota = (int) $j->kuota;
                $setelah = $sisa + (int) $delta;

                if ($setelah < 0) {
                    throw ValidationException::withMessages([
                        'jumlah_peserta' => 'Kursi tidak mencukupi. Silakan kurangi jumlah peserta.',
                    ]);
                }

                $j->sisa_kursi = min($kuota, $setelah);

                if ($j->status !== 'dibatalkan') {
                    $j->status = $j->sisa_kursi <= 0 ? 'penuh' : 'tersedia';
                }

                $j->save();
            }
        });
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
