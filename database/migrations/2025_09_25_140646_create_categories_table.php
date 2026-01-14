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
            $table->id(); // BIGINT pk
            $table->unsignedBigInteger('parent_id')->nullable(); // for subcategories
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            // Optional: لو بدك تعمل علاقة على نفس الجدول
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
