<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'document_type', 'description', 'is_required', 'applicable_for', 'order'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];
}
