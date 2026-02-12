<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id', 'student_id', 'application_id',
        'payment_type', 'description', 'amount', 'currency',
        'exchange_rate', 'amount_jpy',
        'payment_method', 'transaction_id', 'bank_name', 'receipt_number',
        'status', 'paid_amount', 'due_amount', 'due_date', 'paid_date',
        'receipt_path', 'received_by', 'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'amount_jpy' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (empty($payment->payment_id)) {
                $year = date('Y');
                $lastPayment = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
                $nextNumber = $lastPayment ? (int)substr($lastPayment->payment_id, -4) + 1 : 1;
                $payment->payment_id = 'PAY-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
            
            if (is_null($payment->due_amount)) {
                $payment->due_amount = $payment->amount - $payment->paid_amount;
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

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function installments()
    {
        return $this->hasMany(PaymentInstallment::class);
    }
}
