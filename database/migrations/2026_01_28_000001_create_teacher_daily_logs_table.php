<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_daily_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('employees')->onDelete('cascade');
            $table->date('log_date');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('hours_taught', 5, 2)->default(0);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'log_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_daily_logs');
    }
};
