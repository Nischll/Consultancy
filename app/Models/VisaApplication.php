<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'visa_application_id', 'student_id', 'application_id', 'counselor_id',
        'visa_type', 'embassy_location', 'status',
        'submission_date', 'interview_date', 'interview_notes',
        'expected_result_date', 'result_date', 'visa_issue_date', 'visa_expiry_date',
        'visa_number', 'rejection_reason', 'visa_stamp_path',
        'planned_departure_date', 'actual_departure_date', 'flight_details', 'arrival_airport',
        'notes'
    ];

    protected $casts = [
        'submission_date' => 'date',
        'interview_date' => 'datetime',
        'expected_result_date' => 'date',
        'result_date' => 'date',
        'visa_issue_date' => 'date',
        'visa_expiry_date' => 'date',
        'planned_departure_date' => 'date',
        'actual_departure_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($visa) {
            if (empty($visa->visa_application_id)) {
                $year = date('Y');
                $lastVisa = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
                $nextNumber = $lastVisa ? (int)substr($lastVisa->visa_application_id, -4) + 1 : 1;
                $visa->visa_application_id = 'VISA-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }
}
