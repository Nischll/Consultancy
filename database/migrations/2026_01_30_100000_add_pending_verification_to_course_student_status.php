<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE course_student MODIFY COLUMN status ENUM('pending_verification', 'enrolled', 'completed', 'withdrawn') NOT NULL DEFAULT 'enrolled'");
    }

    public function down()
    {
        // Move any pending_verification rows to withdrawn so we can revert enum
        DB::table('course_student')->where('status', 'pending_verification')->update(['status' => 'withdrawn']);
        DB::statement("ALTER TABLE course_student MODIFY COLUMN status ENUM('enrolled', 'completed', 'withdrawn') NOT NULL DEFAULT 'enrolled'");
    }
};
