<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDailyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'log_date',
        'course_id',
        'hours_taught',
        'title',
        'description',
        'notes',
    ];

    protected $casts = [
        'log_date' => 'date',
        'hours_taught' => 'decimal:2',
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
