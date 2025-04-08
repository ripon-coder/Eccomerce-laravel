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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index(); // Foreign key to products
            $table->string('sku')->unique(); // Unique SKU for the variant
            $table->decimal('price', 10, 2); // Price for the variant
            $table->decimal('discount_price', 10, 2)->nullable(); // Price for the variant
            $table->integer('quantity')->default(0); // Stock quantity
            $table->string('image')->nullable(); // Stock quantity
            $table->string("weight")->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
