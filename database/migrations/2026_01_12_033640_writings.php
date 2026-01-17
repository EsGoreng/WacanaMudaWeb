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
        Schema::create('writings', function (Blueprint $table) {
            $table->id('writing_id');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('series_id')->nullable()->constrained('series', 'series_id')->onDelete('set null');

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('description')->nullable();
            $table->string('featured_image')->nullable();

            $table->string('image_credit')->nullable();
            $table->string('image_credit_url')->nullable();

            $table->string('unsplash_photo_id')->nullable();
            $table->text('unsplash_download_location')->nullable();

            $table->integer('reading_time')->default(0);
            $table->boolean('is_anonymous')->default(false);

            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
