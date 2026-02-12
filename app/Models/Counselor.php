<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'employee_id', 'specialization', 'phone', 'extension',
        'is_active', 'max_students'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function visaApplications()
    {
        return $this->hasMany(VisaApplication::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }
}
