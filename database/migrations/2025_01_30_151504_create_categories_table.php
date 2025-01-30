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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Category Name
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('description')->nullable(); // Category Description
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent Category ID
            $table->timestamps(); // Created At and Updated At

            // Foreign Key Constraint for Parent Category
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
