<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'hero_badge',
        'hero_title',
        'hero_highlight',
        'hero_description',
        'cta_primary_text',
        'cta_secondary_text',
        'feature_title',
        'feature_description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
