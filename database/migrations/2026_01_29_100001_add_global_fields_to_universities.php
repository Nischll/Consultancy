<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->string('country')->nullable()->after('name_japanese');
            $table->integer('number_of_international_students')->nullable()->after('number_of_nepali_students');
        });
    }

    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['country', 'number_of_international_students']);
        });
    }
};
