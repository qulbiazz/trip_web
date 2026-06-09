<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destinasi extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'negara',
        'harga_dasar',
        'gambar',
        'kategori',
        'fasilitas',
        'is_aktif',
    ];

    protected $casts = [
        'harga_dasar' => 'decimal:2',
        'is_aktif'    => 'boolean',
    ];

    protected static function booted(): void
    {
        static::updated(function (Destinasi $destinasi): void {
            if ($destinasi->wasChanged('is_aktif') && ! $destinasi->is_aktif) {
                $destinasi->jadwals()
                    ->whereIn('status', ['tersedia', 'penuh'])
                    ->update(['status' => 'dibatalkan']);
            }
        });
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
