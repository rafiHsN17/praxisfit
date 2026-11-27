<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\MuscleRecoveryLog;
use App\Models\User;
use App\Models\WorkoutProgram;
use App\Services\MuscleRecoveryService;
use App\Services\WorkoutProgramGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuscleRecoverySystemTest extends TestCase
{
    use RefreshDatabase;

    private function seedScientificExercises(): void
    {
        $items = [
            ['name' => 'Barbell Bench Press', 'target_muscle' => 'Dada', 'equipment' => 'Barbell', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Push Up', 'target_muscle' => 'Dada', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Incline Push Up', 'target_muscle' => 'Dada', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Barbell Bent-Over Row', 'target_muscle' => 'Punggung Tengah', 'equipment' => 'Barbell', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Pull-Up', 'target_muscle' => 'Lats', 'equipment' => 'Bodyweight', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Dumbbell Row', 'target_muscle' => 'Punggung', 'equipment' => 'Dumbbell', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Superman Hold', 'target_muscle' => 'Punggung Bawah', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Bodyweight Squat', 'target_muscle' => 'Paha Depan', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Reverse Lunge', 'target_muscle' => 'Paha Depan', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Romanian Deadlift', 'target_muscle' => 'Paha Belakang', 'equipment' => 'Dumbbell', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Glute Bridge', 'target_muscle' => 'Bokong', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Standing Calf Raise', 'target_muscle' => 'Betis', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Pike Push Up', 'target_muscle' => 'Bahu', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Dumbbell Shoulder Press', 'target_muscle' => 'Bahu', 'equipment' => 'Dumbbell', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Dumbbell Bicep Curl', 'target_muscle' => 'Bisep', 'equipment' => 'Dumbbell', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Tricep Pushdown', 'target_muscle' => 'Trisep', 'equipment' => 'Cable', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Plank', 'target_muscle' => 'Perut', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Crunch', 'target_muscle' => 'Perut', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
        ];

        foreach ($items as $item) {
            Exercise::create(array_merge($item, [
                'instructions' => 'Lakukan gerakan dengan postur tubuh stabil dan teknik terkontrol.',
            ]));
        }
    }

    public function test_1_back_monday_then_tuesday_is_rejected(): void
    {
        $recovery = app(MuscleRecoveryService::class);
        $history = [
            'Back' => [
                'trained_date' => '2026-11-16', // Senin
                'stimulus' => 'high',
                'total_sets' => 4,
                'intensity' => 'moderate',
                'source_label' => 'latihan utama',
            ],
        ];

        $eval = $recovery->evaluateMuscleRecovery('Back', '2026-11-17', $history, true); // Selasa (24 jam)

        $this->assertFalse($eval['valid']);
        $this->assertEquals('Jadwal bertabrakan', $eval['status']);
        $this->assertEquals(24, $eval['hours_elapsed']);
    }

    public function test_2_back_monday_then_wednesday_after_48_hours_is_accepted_for_moderate_load(): void
    {
        $recovery = app(MuscleRecoveryService::class);
        $history = [
            'Back' => [
                'trained_date' => '2026-11-16', // Senin
                'stimulus' => 'high',
                'total_sets' => 3, // Volume moderat (< 5 sets)
                'intensity' => 'moderate',
                'source_label' => 'latihan utama',
            ],
        ];

        $eval = $recovery->evaluateMuscleRecovery('Back', '2026-11-18', $history, true); // Rabu (48 jam)

        $this->assertTrue($eval['valid']);
        $this->assertEquals('Recovery cukup', $eval['status']);
        $this->assertEquals(48, $eval['hours_elapsed']);
    }

    public function test_3_legs_monday_high_volume_then_wednesday_requires_72_hours(): void
    {
        $recovery = app(MuscleRecoveryService::class);
        $history = [
            'Legs' => [
                'trained_date' => '2026-11-16', // Senin
                'stimulus' => 'high',
                'total_sets' => 6, // High volume (>= 5 sets)
                'intensity' => 'high',
                'source_label' => 'latihan utama',
            ],
        ];

        $wednesday = $recovery->evaluateMuscleRecovery('Legs', '2026-11-18', $history, true); // Rabu (48 jam)
        $this->assertFalse($wednesday['valid']);
        $this->assertEquals('Perlu pemulihan tambahan', $wednesday['status']);
        $this->assertEquals(72, $wednesday['required_hours']);

        $thursday = $recovery->evaluateMuscleRecovery('Legs', '2026-11-19', $history, true); // Kamis (72 jam)
        $this->assertTrue($thursday['valid']);
        $this->assertEquals('Recovery cukup', $thursday['status']);
        $this->assertEquals(72, $thursday['hours_elapsed']);
    }

    public function test_4_chest_monday_prevents_heavy_triceps_tuesday_via_secondary_stimulus(): void
    {
        $this->seedScientificExercises();
        $recovery = app(MuscleRecoveryService::class);

        $bench = Exercise::where('name', 'Barbell Bench Press')->firstOrFail();
        $tricep = Exercise::where('name', 'Tricep Pushdown')->firstOrFail();
        $benchAnalysis = $recovery->analyzeExercise($bench);
        $tricepAnalysis = $recovery->analyzeExercise($tricep);

        $days = [
            [
                'day_number' => 1,
                'day_name' => 'Senin',
                'scheduled_date' => '2026-11-16',
                'day_type' => 'workout',
                'exercises' => [[
                    'exercise_id' => $bench->id,
                    'name' => $bench->name,
                    'primary_group' => $benchAnalysis['primary_group'],
                    'primary_muscle' => $benchAnalysis['primary_sub_muscle'],
                    'secondary_muscles' => $benchAnalysis['secondary_muscles'],
                    'stimulus_level' => $benchAnalysis['primary_stimulus'],
                    'target_sets' => 4,
                ]],
            ],
            [
                'day_number' => 2,
                'day_name' => 'Selasa',
                'scheduled_date' => '2026-11-17',
                'day_type' => 'workout',
                'exercises' => [[
                    'exercise_id' => $tricep->id,
                    'name' => $tricep->name,
                    'primary_group' => $tricepAnalysis['primary_group'],
                    'primary_muscle' => $tricepAnalysis['primary_sub_muscle'],
                    'secondary_muscles' => $tricepAnalysis['secondary_muscles'],
                    'stimulus_level' => $tricepAnalysis['primary_stimulus'],
                    'target_sets' => 4,
                ]],
            ],
        ];

        $validation = $recovery->validateSchedule($days, 'hypertrophy');

        $this->assertFalse($validation['valid']);
        $this->assertNotEmpty($validation['conflicts']);
        $this->assertEquals('Triceps', $validation['conflicts'][0]['muscle']);
        $this->assertEquals('Jadwal bertabrakan', $validation['conflicts'][0]['status']);
    }

    public function test_5_six_day_split_provides_72h_recovery_for_each_muscle_group(): void
    {
        $this->seedScientificExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'with_equipment',
            'selected_equipments' => ['Dumbbell', 'Barbell', 'Cable Machine', 'Bench'],
            'level' => 'intermediate',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 6,
            'session_duration_minutes' => 45,
            'program_duration' => '1_week',
            'start_date' => '2026-11-16',
        ]);

        $this->assertTrue($result['ok']);
        $this->assertTrue($result['program']['recovery_valid']);
        $this->assertEquals(6, $result['program']['total_workout_days']);
        $this->assertEquals(1, $result['program']['total_rest_days']);
    }

    public function test_6_bodyweight_mode_contains_zero_equipment_exercises(): void
    {
        $this->seedScientificExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 45,
            'program_duration' => '1_week',
            'start_date' => '2026-11-16',
        ]);

        $this->assertTrue($result['ok']);
        foreach ($result['days'] as $day) {
            foreach ($day['exercises'] as $ex) {
                $this->assertEquals('Bodyweight', $ex['equipment']);
                $this->assertNotEquals('Pull-Up', $ex['name']);
            }
        }
    }

    public function test_7_and_8_one_month_schedule_recalculates_on_start_date_change(): void
    {
        $this->seedScientificExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $runA = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'intermediate',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 4,
            'session_duration_minutes' => 45,
            'program_duration' => '1_month',
            'start_date' => '2026-11-16',
        ]);

        $runB = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'intermediate',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 4,
            'session_duration_minutes' => 45,
            'program_duration' => '1_month',
            'start_date' => '2026-12-01',
        ]);

        $this->assertTrue($runA['ok']);
        $this->assertTrue($runB['ok']);
        $this->assertCount(28, $runA['days']);
        $this->assertCount(28, $runB['days']);
        $this->assertEquals('2026-11-16', $runA['days'][0]['scheduled_date']);
        $this->assertEquals('2026-12-01', $runB['days'][0]['scheduled_date']);
        $this->assertEquals('2026-12-28', $runB['days'][27]['scheduled_date']);
        $this->assertTrue($runB['program']['recovery_valid']);
    }

    public function test_9_prior_active_recovery_log_triggers_auto_conflict_resolution(): void
    {
        $this->seedScientificExercises();
        $user = User::factory()->create(['email_verified_at' => now()]);

        // User already trained Chest & Back yesterday (2026-11-17)
        MuscleRecoveryLog::create([
            'user_id' => $user->id,
            'muscle_group' => 'Chest',
            'sub_muscle' => 'Middle Chest',
            'role' => 'primary',
            'stimulus_level' => 'high',
            'total_sets' => 4,
            'intensity_level' => 'high',
            'trained_date' => '2026-11-17',
            'required_recovery_hours' => 72,
            'completion_status' => 'completed',
        ]);

        $generator = app(WorkoutProgramGenerator::class);
        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 30,
            'program_duration' => '1_week',
            'start_date' => '2026-11-18',
        ], null, $user->id);

        $this->assertTrue($result['ok']);
        $this->assertNotEmpty($result['program']['adjustments']);
        $this->assertTrue($result['program']['recovery_valid']);
    }

    public function test_10_two_users_have_isolated_recovery_logs_and_programs(): void
    {
        $this->seedScientificExercises();
        $userA = User::factory()->create(['email_verified_at' => now()]);
        $userB = User::factory()->create(['email_verified_at' => now()]);

        $generator = app(WorkoutProgramGenerator::class);
        $preview = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_ENDURANCE,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 30,
            'program_duration' => '1_week',
            'start_date' => '2026-11-18',
        ], null, $userA->id);

        $programA = $generator->saveProgramToRutinku($userA->id, $preview, true);

        $this->assertDatabaseHas('muscle_recovery_logs', [
            'user_id' => $userA->id,
            'workout_program_id' => $programA->id,
        ]);

        $this->assertEquals(0, MuscleRecoveryLog::where('user_id', $userB->id)->count());
        $this->assertEquals(0, WorkoutProgram::where('user_id', $userB->id)->count());
    }
}
