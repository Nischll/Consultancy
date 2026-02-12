<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();
            $table->string('visa_application_id')->unique(); // VISA-2026-001
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('counselor_id')->nullable()->constrained()->onDelete('set null');
            
            // Visa Details
            $table->string('visa_type')->default('Student'); // Student, Dependent, SSW
            $table->string('embassy_location')->nullable(); // Kathmandu
            
            // Status
            $table->enum('status', [
                'documents_preparing', 'documents_ready', 'submitted',
                'processing', 'interview_scheduled', 'interview_completed',
                'approved', 'rejected', 'additional_documents_required'
            ])->default('documents_preparing');
            
            // Important Dates
            $table->date('submission_date')->nullable();
            $table->datetime('interview_date')->nullable();
            $table->text('interview_notes')->nullable();
            $table->date('expected_result_date')->nullable();
            $table->date('result_date')->nullable();
            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();
            
            // Result
            $table->string('visa_number')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('visa_stamp_path')->nullable();
            
            // Travel
            $table->date('planned_departure_date')->nullable();
            $table->date('actual_departure_date')->nullable();
            $table->string('flight_details')->nullable();
            $table->string('arrival_airport')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visa_applications');
    }
};
