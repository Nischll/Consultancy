<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Staff who communicated
            
            // Communication Details
            $table->enum('type', ['email', 'phone', 'whatsapp', 'sms', 'meeting', 'note'])->default('note');
            $table->enum('direction', ['incoming', 'outgoing'])->default('outgoing');
            $table->string('subject')->nullable();
            $table->text('content');
            
            // For emails
            $table->string('email_to')->nullable();
            $table->string('email_cc')->nullable();
            
            // For calls
            $table->string('phone_number')->nullable();
            $table->integer('call_duration')->nullable(); // in seconds
            
            // For meetings
            $table->datetime('meeting_date')->nullable();
            $table->string('meeting_location')->nullable();
            
            // Attachments
            $table->json('attachments')->nullable();
            
            // Follow-up
            $table->boolean('requires_follow_up')->default(false);
            $table->datetime('follow_up_date')->nullable();
            $table->boolean('follow_up_completed')->default(false);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communications');
    }
};
