<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique(); // APP-2026-001
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('university_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('counselor_id')->nullable()->constrained()->onDelete('set null');
            
            // Application Details
            $table->string('intake'); // April 2026, October 2026
            $table->string('course_name')->nullable();
            $table->string('course_type')->nullable(); // Language School, University, Vocational, Graduate School
            $table->string('course_duration')->nullable(); // 2 years, 4 years
            
            // Status Tracking
            $table->enum('status', [
                'draft', 'documents_preparing', 'documents_ready', 'submitted',
                'under_review', 'interview_scheduled', 'interview_completed',
                'accepted', 'rejected', 'waitlisted', 'withdrawn', 'enrolled'
            ])->default('draft');
            
            // Important Dates
            $table->date('application_date')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->date('submitted_at')->nullable();
            $table->datetime('interview_date')->nullable();
            $table->string('interview_mode')->nullable(); // Online, In-person
            $table->text('interview_notes')->nullable();
            $table->date('result_date')->nullable();
            $table->date('enrollment_deadline')->nullable();
            
            // Result
            $table->text('acceptance_letter_path')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // COE (Certificate of Eligibility)
            $table->enum('coe_status', ['not_applied', 'applied', 'processing', 'approved', 'rejected'])->default('not_applied');
            $table->date('coe_applied_date')->nullable();
            $table->date('coe_received_date')->nullable();
            $table->string('coe_document_path')->nullable();
            
            // Fees
            $table->decimal('application_fee', 10, 2)->nullable();
            $table->decimal('tuition_fee', 12, 2)->nullable();
            $table->boolean('application_fee_paid')->default(false);
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
