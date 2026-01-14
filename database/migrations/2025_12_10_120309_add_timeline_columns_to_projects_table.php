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
        Schema::table('projects', function (Blueprint $table) {
            $table->timestamp('reviewed_at')->nullable()->after('status');
            $table->timestamp('pre_approved_at')->nullable()->after('reviewed_at');
            $table->timestamp('open_for_investment_at')->nullable()->after('pre_approved_at');
            $table->timestamp('funded_at')->nullable()->after('open_for_investment_at');
            $table->timestamp('repayment_started_at')->nullable()->after('funded_at');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'reviewed_at',
                'pre_approved_at',
                'open_for_investment_at',
                'funded_at',
                'repayment_started_at',
            ]);
        });
    }
};
