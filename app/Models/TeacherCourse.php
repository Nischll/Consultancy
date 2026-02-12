<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'course_id',
        'hourly_rate',
        'hours_per_week',
        'status',
        'assigned_date',
        'notes',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'hours_per_week' => 'integer',
        'assigned_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
