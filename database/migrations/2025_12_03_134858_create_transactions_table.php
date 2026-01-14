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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // علاقة مع المحفظة
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');

            // نوع العملية
            $table->enum('type', [
                'deposit',
                'withdraw',
                'profit',
                'transfer_to_borrower'
            ]);

            // المبلغ
            $table->decimal('amount', 15, 2);

            // رقم العملية
            $table->string('reference')->unique();

            // حالة العملية
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');

            // وقت تنفيذ العملية
            $table->timestamp('processed_at')->nullable();

            // created_at + updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
