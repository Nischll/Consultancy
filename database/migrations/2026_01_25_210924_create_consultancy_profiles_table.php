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
        Schema::create('consultancy_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('about')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->json('images')->nullable(); // Array of image paths
            $table->text('advertisement')->nullable();
            $table->string('advertisement_image')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable(); // Facebook, Twitter, LinkedIn, etc.
            $table->text('services')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('consultancy_profiles');
    }
};
