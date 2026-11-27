<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 60)->unique();
            $table->string('name', 100);
            $table->string('parent_group', 40); // Back, Legs, Chest, Shoulders, Arms, Core
            $table->boolean('is_large_muscle')->default(true);
            $table->unsignedSmallInteger('min_recovery_hours')->default(48);
            $table->unsignedSmallInteger('high_volume_recovery_hours')->default(72);
            $table->timestamps();
        });

        Schema::create('exercise_muscle_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscle_group_id')->constrained('muscle_groups')->onDelete('cascade');
            $table->string('role', 20)->default('primary'); // primary, secondary
            $table->string('stimulus_level', 20)->default('high'); // high, moderate, low
            $table->timestamps();

            $table->unique(['exercise_id', 'muscle_group_id', 'role'], 'ex_muscle_role_unique');
        });

        Schema::create('muscle_recovery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('workout_program_id')->nullable()->constrained('workout_programs')->nullOnDelete();
            $table->foreignId('workout_session_id')->nullable()->constrained('workout_sessions')->nullOnDelete();
            $table->string('muscle_group', 60); // Back, Legs, Chest, Shoulders, Arms, Core
            $table->string('sub_muscle', 100)->nullable();
            $table->string('role', 20)->default('primary'); // primary, secondary
            $table->string('stimulus_level', 20)->default('high'); // high, moderate, low
            $table->unsignedSmallInteger('total_sets')->default(3);
            $table->string('intensity_level', 20)->default('moderate'); // low, moderate, high
            $table->string('training_method', 40)->nullable();
            $table->date('trained_date');
            $table->unsignedSmallInteger('required_recovery_hours')->default(48);
            $table->string('completion_status', 20)->default('planned'); // planned, completed
            $table->timestamps();

            $table->index(['user_id', 'muscle_group', 'trained_date'], 'mrl_user_muscle_date_idx');
        });

        Schema::table('exercises', function (Blueprint $table) {
            if (!Schema::hasColumn('exercises', 'secondary_muscles')) {
                $table->json('secondary_muscles')->nullable()->after('target_muscle');
            }
        });

        Schema::table('workout_program_days', function (Blueprint $table) {
            if (!Schema::hasColumn('workout_program_days', 'placement_reason')) {
                $table->text('placement_reason')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('workout_program_days', 'recovery_status')) {
                $table->string('recovery_status', 60)->nullable()->after('placement_reason');
            }
            if (!Schema::hasColumn('workout_program_days', 'recovery_summary')) {
                $table->json('recovery_summary')->nullable()->after('recovery_status');
            }
        });

        Schema::table('workout_program_exercises', function (Blueprint $table) {
            if (!Schema::hasColumn('workout_program_exercises', 'primary_muscle')) {
                $table->string('primary_muscle', 100)->nullable()->after('exercise_id');
            }
            if (!Schema::hasColumn('workout_program_exercises', 'secondary_muscles')) {
                $table->json('secondary_muscles')->nullable()->after('primary_muscle');
            }
            if (!Schema::hasColumn('workout_program_exercises', 'stimulus_level')) {
                $table->string('stimulus_level', 20)->nullable()->after('secondary_muscles');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workout_program_exercises', function (Blueprint $table) {
            foreach (['stimulus_level', 'secondary_muscles', 'primary_muscle'] as $col) {
                if (Schema::hasColumn('workout_program_exercises', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('workout_program_days', function (Blueprint $table) {
            foreach (['recovery_summary', 'recovery_status', 'placement_reason'] as $col) {
                if (Schema::hasColumn('workout_program_days', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('exercises', function (Blueprint $table) {
            if (Schema::hasColumn('exercises', 'secondary_muscles')) {
                $table->dropColumn('secondary_muscles');
            }
        });

        Schema::dropIfExists('muscle_recovery_logs');
        Schema::dropIfExists('exercise_muscle_mappings');
        Schema::dropIfExists('muscle_groups');
    }
};

