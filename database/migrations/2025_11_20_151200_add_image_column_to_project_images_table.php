<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            if (!Schema::hasColumn('project_images', 'image')) {
                $table->string('image')->nullable()->after('project_id');
            }
        });

        if (Schema::hasColumn('project_images', 'path')) {
            DB::table('project_images')
                ->whereNull('image')
                ->update(['image' => DB::raw('path')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            if (Schema::hasColumn('project_images', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

