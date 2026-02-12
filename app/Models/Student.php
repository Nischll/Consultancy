<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'counselor_id', 'student_id',
        'first_name', 'last_name', 'first_name_japanese', 'last_name_japanese',
        'gender', 'date_of_birth', 'nationality', 'passport_number', 'passport_expiry', 'photo',
        'email', 'phone', 'alternate_phone', 'whatsapp', 'address', 'city', 'district', 'country',
        'emergency_contact_name', 'emergency_contact_relation', 'emergency_contact_phone',
        'highest_education', 'last_institution', 'graduation_year', 'gpa',
        'jlpt_level', 'jlpt_date', 'nat_level', 'nat_date', 'jft_level', 'jft_date',
        'ielts_score', 'ielts_date', 'toefl_score', 'toefl_date', 'pte_score', 'pte_date',
        'status', 'target_intake', 'target_course_type', 'target_university_id', 'target_country',
        'sponsor_type', 'sponsor_name', 'sponsor_relation', 'estimated_budget',
        'source', 'referred_by', 'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_expiry' => 'date',
        'jlpt_date' => 'date',
        'nat_date' => 'date',
        'jft_date' => 'date',
        'ielts_date' => 'date',
        'toefl_date' => 'date',
        'pte_date' => 'date',
        'gpa' => 'decimal:2',
        'estimated_budget' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $year = date('Y');
                $lastStudent = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
                $nextNumber = $lastStudent ? (int)substr($lastStudent->student_id, -4) + 1 : 1;
                $student->student_id = 'STU-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function targetUniversity()
    {
        return $this->belongsTo(University::class, 'target_university_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function visaApplications()
    {
        return $this->hasMany(VisaApplication::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withPivot('enrolled_at', 'status', 'notes')
            ->withTimestamps();
    }

    /** Enrollments where status is enrolled */
    public function enrolledCourses()
    {
        return $this->courses()->wherePivot('status', 'enrolled');
    }
}
