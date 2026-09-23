<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('hari');
            $table->string('nama_gerakan');
            $table->integer('set');
            $table->integer('repetisi');
            $table->float('berat_beban');
            $table->string('satuan_beban')->default('kg'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_schedules');
    }
};