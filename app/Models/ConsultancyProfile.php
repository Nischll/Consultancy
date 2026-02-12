<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultancyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'about',
        'logo',
        'banner',
        'images',
        'advertisement',
        'advertisement_image',
        'email',
        'phone',
        'address',
        'website',
        'social_links',
        'services',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];
}
