<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->integer('hours_per_week')->default(0);
            $table->enum('status', ['assigned', 'active', 'completed', 'cancelled'])->default('assigned');
            $table->date('assigned_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure a teacher can only be assigned to a course once
            $table->unique(['teacher_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_courses');
    }
};
