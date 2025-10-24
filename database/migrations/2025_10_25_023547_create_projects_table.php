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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('additional_content')->nullable();
            $table->text('conclusion')->nullable();
            $table->string('category');
            $table->string('featured_image_path');
            $table->string('secondary_image_path')->nullable();
            $table->json('gallery_images')->nullable(); // Store array of image paths
            $table->json('features')->nullable(); // Store array of features
            $table->json('progress_data')->nullable(); // Store array of progress items
            $table->string('client_name')->nullable();
            $table->string('project_location')->nullable();
            $table->date('project_date')->nullable();
            $table->string('project_duration')->nullable();
            $table->decimal('project_value', 15, 2)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};