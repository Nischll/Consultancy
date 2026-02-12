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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique(); // e.g., JAP101, ENG201
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->string('level')->nullable(); // Beginner, Intermediate, Advanced
            $table->integer('duration_hours')->nullable(); // Total course hours
            $table->decimal('fee', 10, 2)->nullable();
            $table->string('currency', 3)->default('NPR');
            $table->integer('max_students')->default(30);
            $table->integer('current_students')->default(0);
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('syllabus')->nullable();
            $table->text('materials')->nullable(); // Required materials
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
