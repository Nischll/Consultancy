<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'user_id', 'type', 'direction',
        'subject', 'content',
        'email_to', 'email_cc',
        'phone_number', 'call_duration',
        'meeting_date', 'meeting_location',
        'attachments',
        'requires_follow_up', 'follow_up_date', 'follow_up_completed'
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'follow_up_date' => 'datetime',
        'attachments' => 'array',
        'requires_follow_up' => 'boolean',
        'follow_up_completed' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
