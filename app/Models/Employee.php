<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'position',
        'department',
        'hire_date',
        'employment_type',
        'salary',
        'status',
        'notes',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }

    public function tasks()
    {
        if ($this->user_id) {
            return $this->user->tasks();
        }
        return collect();
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_courses', 'teacher_id', 'course_id')
                    ->withPivot('hourly_rate', 'hours_per_week', 'status', 'assigned_date', 'notes')
                    ->withTimestamps();
    }

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, 'teacher_id');
    }
}
