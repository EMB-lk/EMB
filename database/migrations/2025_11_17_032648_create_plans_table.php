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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('billing_period')->default('monthly'); // monthly, yearly, lifetime
            $table->boolean('is_free')->default(false);
            $table->boolean('custom_domain')->default(false);
            $table->integer('max_photos')->default(5);
            $table->boolean('analytics')->default(false);
            $table->boolean('priority_support')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
