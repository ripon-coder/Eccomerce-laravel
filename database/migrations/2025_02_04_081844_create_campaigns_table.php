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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name'); // Campaign name (e.g., "Summer Sale")
            $table->string('type'); // Discount type: percentage, fixed, BOGO, etc.
            $table->decimal('discount', 10, 2); // Discount value (e.g., 20% or $10)
            $table->timestamp('start_date')->nullable(); // Campaign start date
            $table->timestamp('end_date')->nullable(); // Campaign end date
            $table->boolean('is_active')->default(true); // Is the campaign active?
            $table->text('description')->nullable(); // Campaign details
            $table->integer('usage_limit')->nullable(); // Max total uses (optional)
            $table->integer('user_limit')->nullable(); // Max uses per user (optional)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
