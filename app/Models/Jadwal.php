<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    protected $fillable = [
        'destinasi_id',
        'pendaftaran_mulai',
        'pendaftaran_tutup',
        'tanggal_berangkat',
        'tanggal_pulang',
        'kuota',
        'sisa_kursi',
        'harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'pendaftaran_mulai' => 'date',
        'pendaftaran_tutup' => 'date',
        'tanggal_berangkat' => 'date',
        'tanggal_pulang'    => 'date',
        'harga'             => 'decimal:2',
    ];

    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(Destinasi::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
