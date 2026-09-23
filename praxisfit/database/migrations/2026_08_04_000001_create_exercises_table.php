<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('target_muscle'); // (Dada, Punggung, dll)
            $table->string('equipment')->nullable(); // (Barbell, Dumbbell, Bodyweight)
            $table->string('difficulty')->default('Pemula');
            $table->text('instructions')->nullable();
            
            // MuscleWiki biasanya memisahkan aset berdasarkan gender
            $table->string('video_male')->nullable(); 
            $table->string('video_female')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
