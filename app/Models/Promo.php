<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'tipe_diskon',
        'nilai_diskon',
        'expired_at',
        'is_aktif',
    ];

    protected $casts = [
        'nilai_diskon'     => 'decimal:2',
        'expired_at'       => 'date',
        'is_aktif'         => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Promo $promo): void {
            if (static::isExpired($promo)) {
                $promo->is_aktif = false;
            }
        });

        static::retrieved(function (Promo $promo): void {
            if (! $promo->is_aktif || ! static::isExpired($promo)) {
                return;
            }

            $promo->is_aktif = false;
            $promo->saveQuietly();
        });
    }

    protected static function isExpired(Promo $promo): bool
    {
        return $promo->expired_at && \Carbon\Carbon::parse($promo->expired_at)->endOfDay()->isPast();
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
