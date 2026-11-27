<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (!Schema::hasColumn('exercises', 'recommended_methods')) {
                $table->json('recommended_methods')->nullable()->after('secondary_muscles');
            }
        });
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (Schema::hasColumn('exercises', 'recommended_methods')) {
                $table->dropColumn('recommended_methods');
            }
        });
    }
};

