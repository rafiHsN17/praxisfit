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
        Schema::table('users', function (Blueprint $table) {
            $table->float('weight')->nullable(); // in kg
            $table->float('height')->nullable(); // in cm
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->float('protein_target')->nullable(); // in grams
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['weight', 'height', 'gender', 'protein_target']);
        });
    }
};
