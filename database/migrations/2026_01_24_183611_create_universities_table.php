<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_japanese')->nullable();
            $table->integer('established')->nullable();
            $table->integer('number_of_nepali_students')->default(0);
            $table->string('banner_image')->nullable();
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();
            $table->text('description')->nullable();
            $table->text('description_japanese')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('prefecture')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('type', ['university', 'college', 'school', 'vocational'])->default('university');
            $table->string('institution_type')->nullable();
            $table->text('programs_offered')->nullable();
            $table->text('admission_requirements')->nullable();
            $table->decimal('tuition_fee', 10, 2)->nullable();
            $table->string('currency', 3)->default('JPY');
            $table->text('scholarships')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('universities');
    }
};
