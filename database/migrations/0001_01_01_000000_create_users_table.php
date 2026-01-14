<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول المستخدمين
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // معلومات المستخدم
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();

            // كلمة المرور
            $table->string('password');
            // صلاحيات النظام
            $table->enum('role', ['admin', 'investor', 'borrower'])
                ->default('investor');
            // حالة الحساب
            $table->enum('status', ['active', 'inactive'])
                ->default('active');
            // تحقق KYC للمقترض
            $table->timestamp('kyc_verified_at')->nullable();

            // remember token
            $table->rememberToken();

            $table->timestamps();
        });

        // جدول إعادة تعيين كلمة المرور
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // جدول الجلسات Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
