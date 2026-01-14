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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('investor_id');

            // Amount of investment
            $table->decimal('amount', 15, 2);

            // Status: pending, paid, refunded
            $table->enum('status', ['pending', 'paid', 'refunded'])->default('pending');

            // Payment timestamp
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Relations
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('investor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
