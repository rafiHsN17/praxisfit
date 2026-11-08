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
        Schema::table('protein_logs', function (Blueprint $table) {
            $table->float('user_weight')->nullable(); // in kg
            $table->float('user_height')->nullable(); // in cm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('protein_logs', function (Blueprint $table) {
            $table->dropColumn(['user_weight', 'user_height']);
        });
    }
};
