<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique(); // PAY-2026-001
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->nullable()->constrained()->onDelete('set null');
            
            // Payment Details
            $table->string('payment_type'); // consultation_fee, application_fee, visa_fee, tuition_fee, accommodation, etc.
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('NPR'); // NPR, JPY, USD
            $table->decimal('exchange_rate', 10, 4)->nullable();
            $table->decimal('amount_jpy', 12, 2)->nullable();
            
            // Payment Method
            $table->string('payment_method')->nullable(); // Cash, Bank Transfer, eSewa, Khalti, Card
            $table->string('transaction_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('receipt_number')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'partial', 'completed', 'refunded', 'cancelled'])->default('pending');
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            
            // Receipt
            $table->string('receipt_path')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Payment installments for partial payments
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_installments');
        Schema::dropIfExists('payments');
    }
};
