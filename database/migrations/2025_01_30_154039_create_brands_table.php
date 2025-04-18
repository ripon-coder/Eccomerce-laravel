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
        Schema::create('brands', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Brand Name
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('description')->nullable(); // Brand Description
            $table->boolean("is_published")->default(true);
            $table->timestamps(); // Created At and Updated At
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
