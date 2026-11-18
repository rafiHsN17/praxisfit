<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category', 60)->nullable()->default('Kekuatan');
            $table->date('scheduled_date');
            $table->string('scheduled_time', 10)->nullable();
            $table->date('actual_date')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->string('status', 20)->default('upcoming'); // upcoming, in_progress, completed, missed
            $table->boolean('is_off_schedule')->default(false);
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'scheduled_date']);
            $table->index(['user_id', 'status']);
        });

        Schema::create('workout_session_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_session_id')->constrained('workout_sessions')->onDelete('cascade');
            $table->foreignId('exercise_id')->nullable()->constrained('exercises')->nullOnDelete();
            $table->string('exercise_name');
            $table->string('target_muscle', 100)->nullable();
            $table->unsignedSmallInteger('target_sets')->default(3);
            $table->unsignedSmallInteger('completed_sets')->default(0);
            $table->string('target_reps', 50)->default('10-12');
            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->boolean('is_completed')->default(false);
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_session_items');
        Schema::dropIfExists('workout_sessions');
    }
};

