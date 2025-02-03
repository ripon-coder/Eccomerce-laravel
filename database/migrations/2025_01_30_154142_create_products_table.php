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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id'); // Foreign Key to Categories Table
            $table->unsignedBigInteger('brand_id')->nullable(); // Foreign Key to Brand Table
            $table->string('thumbnail')->nullable();
            $table->text('images')->nullable();
            $table->string("slug")->unique();
            $table->string('meta_title')->nullable(); // SEO Meta Title
            $table->text('meta_description')->nullable(); // SEO Meta Description
            $table->text('meta_keywords')->nullable(); // SEO Meta Keywords
            $table->boolean("is_published")->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key for category
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
