<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            $table->string('document_type'); // passport, photo, academic_transcript, jlpt_certificate, etc.
            $table->string('title');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // pdf, jpg, png
            $table->integer('file_size')->nullable(); // in KB
            
            $table->enum('status', ['pending', 'verified', 'rejected', 'expired'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Verification
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('verified_at')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Document checklist template
        Schema::create('document_checklists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document_type');
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(true);
            $table->string('applicable_for')->nullable(); // language_school, university, visa
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_checklists');
        Schema::dropIfExists('documents');
    }
};
