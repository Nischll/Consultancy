<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('target_country')->nullable()->after('target_university_id');
            $table->string('ielts_score')->nullable()->after('jft_date');
            $table->date('ielts_date')->nullable()->after('ielts_score');
            $table->string('toefl_score')->nullable()->after('ielts_date');
            $table->date('toefl_date')->nullable()->after('toefl_score');
            $table->string('pte_score')->nullable()->after('toefl_date');
            $table->date('pte_date')->nullable()->after('pte_score');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['target_country', 'ielts_score', 'ielts_date', 'toefl_score', 'toefl_date', 'pte_score', 'pte_date']);
        });
    }
};
