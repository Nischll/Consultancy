<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'student_id', 'university_id', 'counselor_id',
        'intake', 'course_name', 'course_type', 'course_duration', 'status',
        'application_date', 'submission_deadline', 'submitted_at',
        'interview_date', 'interview_mode', 'interview_notes',
        'result_date', 'enrollment_deadline',
        'acceptance_letter_path', 'rejection_reason',
        'coe_status', 'coe_applied_date', 'coe_received_date', 'coe_document_path',
        'application_fee', 'tuition_fee', 'application_fee_paid', 'notes'
    ];

    protected $casts = [
        'application_date' => 'date',
        'submission_deadline' => 'date',
        'submitted_at' => 'date',
        'interview_date' => 'datetime',
        'result_date' => 'date',
        'enrollment_deadline' => 'date',
        'coe_applied_date' => 'date',
        'coe_received_date' => 'date',
        'application_fee' => 'decimal:2',
        'tuition_fee' => 'decimal:2',
        'application_fee_paid' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($application) {
            if (empty($application->application_id)) {
                $year = date('Y');
                $lastApp = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
                $nextNumber = $lastApp ? (int)substr($lastApp->application_id, -4) + 1 : 1;
                $application->application_id = 'APP-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function visaApplication()
    {
        return $this->hasOne(VisaApplication::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
