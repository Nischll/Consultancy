<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('employee_id')->unique();
            $table->string('specialization')->nullable(); // Language School, University, Visa
            $table->string('phone')->nullable();
            $table->string('extension')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('max_students')->default(50); // Max students they can handle
            
            $table->timestamps();
        });

        // Activity log for audit trail
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('loggable_type'); // Model class
            $table->unsignedBigInteger('loggable_id');
            $table->string('action'); // created, updated, deleted, status_changed
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['loggable_type', 'loggable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('counselors');
    }
};
