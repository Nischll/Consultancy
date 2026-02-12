<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('counselor_id')->nullable()->constrained()->onDelete('set null');
            
            // Personal Information
            $table->string('student_id')->unique(); // Auto-generated ID like STU-2026-001
            $table->string('first_name');
            $table->string('last_name');
            $table->string('first_name_japanese')->nullable();
            $table->string('last_name_japanese')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->default('Nepali');
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('photo')->nullable();
            
            // Contact Information
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('country')->default('Nepal');
            
            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            // Educational Background
            $table->string('highest_education')->nullable(); // SLC, +2, Bachelor, Master
            $table->string('last_institution')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            
            // Japanese Language Proficiency
            $table->string('jlpt_level')->nullable(); // N5, N4, N3, N2, N1
            $table->date('jlpt_date')->nullable();
            $table->string('nat_level')->nullable();
            $table->date('nat_date')->nullable();
            $table->string('jft_level')->nullable();
            $table->date('jft_date')->nullable();
            
            // Application Status
            $table->enum('status', [
                'inquiry', 'registered', 'documents_pending', 'documents_submitted',
                'applied', 'interview_scheduled', 'accepted', 'visa_processing',
                'visa_approved', 'visa_rejected', 'departed', 'enrolled', 'completed', 'cancelled'
            ])->default('inquiry');
            
            // Target Information
            $table->string('target_intake')->nullable(); // April 2026, October 2026
            $table->string('target_course_type')->nullable(); // Language School, University, Vocational
            $table->foreignId('target_university_id')->nullable()->constrained('universities')->onDelete('set null');
            
            // Financial Information
            $table->string('sponsor_type')->nullable(); // Self, Parents, Scholarship
            $table->string('sponsor_name')->nullable();
            $table->string('sponsor_relation')->nullable();
            $table->decimal('estimated_budget', 12, 2)->nullable();
            
            // Source & Notes
            $table->string('source')->nullable(); // Walk-in, Referral, Social Media, Website
            $table->string('referred_by')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
