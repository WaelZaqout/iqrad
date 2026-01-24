<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('borrower_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');

            $table->string('title_en', 255);
            $table->string('title_ar', 255);
            $table->string('slug')->unique();
            $table->text('summary_en')->nullable();
            $table->text('summary_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->decimal('funding_goal', 15, 2);
            $table->decimal('funded_amount', 15, 2)->default(0);
            $table->float('interest_rate', 5, 2);
            $table->integer('term_months');

            $table->decimal('min_investment', 12, 2)->default(1000); // الحد الأدنى 1000

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'funding',
                'active',
                'completed',
                'defaulted'
            ])->default('pending');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
