<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id', 'student_id', 'counselor_id',
        'name', 'email', 'phone',
        'subject', 'message', 'type', 'priority', 'status', 'source',
        'follow_up_date', 'follow_up_notes',
        'response', 'responded_at', 'responded_by'
    ];

    protected $casts = [
        'follow_up_date' => 'datetime',
        'responded_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($inquiry) {
            if (empty($inquiry->inquiry_id)) {
                $year = date('Y');
                $lastInquiry = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
                $nextNumber = $lastInquiry ? (int)substr($lastInquiry->inquiry_id, -4) + 1 : 1;
                $inquiry->inquiry_id = 'INQ-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
