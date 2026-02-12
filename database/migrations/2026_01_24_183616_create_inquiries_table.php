<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_id')->unique(); // INQ-2026-001
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('counselor_id')->nullable()->constrained()->onDelete('set null');
            
            // For new inquiries (before student record exists)
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // Inquiry Details
            $table->string('subject');
            $table->text('message');
            $table->enum('type', ['general', 'admission', 'visa', 'language', 'scholarship', 'accommodation', 'other'])->default('general');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['new', 'in_progress', 'responded', 'follow_up', 'converted', 'closed'])->default('new');
            
            // Source
            $table->string('source')->nullable(); // Website, Phone, Walk-in, Email, Social Media
            
            // Follow-up
            $table->datetime('follow_up_date')->nullable();
            $table->text('follow_up_notes')->nullable();
            
            // Response
            $table->text('response')->nullable();
            $table->datetime('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
};
