<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_japanese', 'country', 'established', 'number_of_nepali_students', 'number_of_international_students',
        'banner_image', 'images', 'video_url', 'description', 'description_japanese',
        'address', 'city', 'prefecture', 'website', 'email', 'phone', 'type',
        'institution_type', 'programs_offered', 'admission_requirements', 'tuition_fee',
        'currency', 'scholarships', 'logo', 'is_featured', 'view_count',
    ];

    protected $casts = [
        'images' => 'array',
        'programs_offered' => 'array',
        'is_featured' => 'boolean',
        'number_of_nepali_students' => 'integer',
        'number_of_international_students' => 'integer',
        'established' => 'integer',
        'view_count' => 'integer',
        'tuition_fee' => 'decimal:2',
    ];

    /** Display count of international students (prefer new column, fallback to legacy) */
    public function getInternationalStudentsCountAttribute(): int
    {
        return (int) ($this->number_of_international_students ?? $this->number_of_nepali_students ?? 0);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'target_university_id');
    }
}
