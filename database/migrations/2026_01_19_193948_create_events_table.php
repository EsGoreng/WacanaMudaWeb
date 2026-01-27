<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->string('banner_image')->nullable();

            $table->string('image_credit')->nullable();
            $table->string('image_credit_url')->nullable();

            $table->string('unsplash_photo_id')->nullable();
            $table->text('unsplash_download_location')->nullable();

            $table->string('location_name');
            $table->string('location_address')->nullable();

            $table->boolean('is_online')->default(false);
            $table->string('meeting_link')->nullable();

            $table->string('register_link')->nullable();

            $table->enum('status', ['draft', 'published', 'ongoing', 'canceled', 'ended'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
