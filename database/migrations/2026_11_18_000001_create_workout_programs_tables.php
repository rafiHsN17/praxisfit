<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('training_method', 40); // hypertrophy, strength, endurance, power, general_fitness, conditioning
            $table->string('equipment_mode', 30); // bodyweight, with_equipment
            $table->json('selected_equipments')->nullable();
            $table->string('level', 30); // beginner, intermediate, advanced
            $table->json('target_muscles');
            $table->unsignedTinyInteger('frequency_per_week')->default(3);
            $table->unsignedSmallInteger('session_duration_minutes')->default(45);
            $table->string('program_duration', 20); // 1_week, 1_month
            $table->unsignedTinyInteger('total_weeks')->default(1);
            $table->unsignedSmallInteger('total_days')->default(7);
            $table->date('start_date');
            $table->date('end_date');
            $table->json('preferences')->nullable();
            $table->string('status', 20)->default('active'); // active, completed, archived
            $table->text('safety_notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        Schema::create('workout_program_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_program_id')->constrained('workout_programs')->onDelete('cascade');
            $table->unsignedTinyInteger('week_number')->default(1);
            $table->unsignedSmallInteger('day_number');
            $table->string('day_name', 20);
            $table->date('scheduled_date');
            $table->string('day_type', 20)->default('workout'); // workout, rest
            $table->string('focus_label', 120)->nullable();
            $table->string('week_phase', 60)->nullable();
            $table->unsignedSmallInteger('estimated_duration_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['workout_program_id', 'scheduled_date']);
        });

        Schema::create('workout_program_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_program_day_id')->constrained('workout_program_days')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->unsignedSmallInteger('target_sets')->default(3);
            $table->string('target_reps', 50)->default('10-12');
            $table->boolean('is_duration_based')->default(false);
            $table->unsignedSmallInteger('rest_seconds')->default(60);
            $table->string('intensity_note', 160)->nullable();
            $table->string('progression_note', 160)->nullable();
            $table->timestamps();
        });

        Schema::table('workout_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('workout_sessions', 'workout_program_id')) {
                $table->foreignId('workout_program_id')->nullable()->after('user_id')->constrained('workout_programs')->nullOnDelete();
            }
            if (!Schema::hasColumn('workout_sessions', 'workout_program_day_id')) {
                $table->foreignId('workout_program_day_id')->nullable()->after('workout_program_id')->constrained('workout_program_days')->nullOnDelete();
            }
            if (!Schema::hasColumn('workout_sessions', 'training_method')) {
                $table->string('training_method', 60)->nullable()->after('category');
            }
            if (!Schema::hasColumn('workout_sessions', 'week_number')) {
                $table->unsignedTinyInteger('week_number')->nullable()->after('training_method');
            }
        });

        Schema::table('workout_session_items', function (Blueprint $table) {
            if (!Schema::hasColumn('workout_session_items', 'rest_seconds')) {
                $table->unsignedSmallInteger('rest_seconds')->nullable()->after('target_reps');
            }
            if (!Schema::hasColumn('workout_session_items', 'intensity_note')) {
                $table->string('intensity_note', 160)->nullable()->after('rest_seconds');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workout_session_items', function (Blueprint $table) {
            foreach (['intensity_note', 'rest_seconds'] as $col) {
                if (Schema::hasColumn('workout_session_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('workout_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('workout_sessions', 'workout_program_day_id')) {
                $table->dropConstrainedForeignId('workout_program_day_id');
            }
            if (Schema::hasColumn('workout_sessions', 'workout_program_id')) {
                $table->dropConstrainedForeignId('workout_program_id');
            }
            foreach (['week_number', 'training_method'] as $col) {
                if (Schema::hasColumn('workout_sessions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('workout_program_exercises');
        Schema::dropIfExists('workout_program_days');
        Schema::dropIfExists('workout_programs');
    }
};

