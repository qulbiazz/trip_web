<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimonis';

    protected $fillable = [
        'nama',
        'rating',
        'konten',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'rating' => 'integer',
    ];
}
