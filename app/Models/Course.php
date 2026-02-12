<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'level',
        'duration_hours',
        'fee',
        'currency',
        'max_students',
        'current_students',
        'status',
        'start_date',
        'end_date',
        'syllabus',
        'materials',
    ];

    protected $casts = [
        'duration_hours' => 'integer',
        'fee' => 'decimal:2',
        'max_students' => 'integer',
        'current_students' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function teachers()
    {
        return $this->belongsToMany(Employee::class, 'teacher_courses', 'course_id', 'teacher_id')
                    ->withPivot('hourly_rate', 'hours_per_week', 'status', 'assigned_date', 'notes')
                    ->withTimestamps();
    }

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')
            ->withPivot('enrolled_at', 'status', 'notes')
            ->withTimestamps();
    }

    /** Number of students currently enrolled (status = enrolled) */
    public function enrolledStudentsCount(): int
    {
        return $this->students()->wherePivot('status', 'enrolled')->count();
    }

    /** Whether the course has capacity for more enrollments */
    public function hasCapacity(): bool
    {
        return $this->enrolledStudentsCount() < $this->max_students;
    }
}
