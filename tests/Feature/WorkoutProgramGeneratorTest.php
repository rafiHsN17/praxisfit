<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Livewire\ProgramGenerator;
use App\Models\Exercise;
use App\Models\User;
use App\Models\WorkoutProgram;
use App\Models\WorkoutSession;
use App\Services\WorkoutProgramGenerator;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WorkoutProgramGeneratorTest extends TestCase
{
    use RefreshDatabase;

    private function seedDiverseExercises(): array
    {
        $list = [
            ['name' => 'Push Up', 'target_muscle' => 'Dada', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Knee Push Up', 'target_muscle' => 'Dada', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Incline Push Up', 'target_muscle' => 'Dada', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Bodyweight Squat', 'target_muscle' => 'Paha Depan', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Reverse Lunge', 'target_muscle' => 'Paha Depan', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Glute Bridge', 'target_muscle' => 'Bokong', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Pike Push Up', 'target_muscle' => 'Bahu', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Plank', 'target_muscle' => 'Perut', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Crunch', 'target_muscle' => 'Perut', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Mountain Climbers', 'target_muscle' => 'Perut', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kardio & Daya Tahan'],
            ['name' => 'Superman Hold', 'target_muscle' => 'Punggung Bawah', 'equipment' => 'Bodyweight', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Pull-Up', 'target_muscle' => 'Lats', 'equipment' => 'Bodyweight', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Dumbbell Goblet Squat', 'target_muscle' => 'Paha Depan', 'equipment' => 'Dumbbell', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Dumbbell Shoulder Press', 'target_muscle' => 'Bahu', 'equipment' => 'Dumbbell', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Resistance Band Row', 'target_muscle' => 'Punggung', 'equipment' => 'Resistance Band', 'difficulty' => 'Pemula', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Barbell Bench Press', 'target_muscle' => 'Dada', 'equipment' => 'Barbell', 'difficulty' => 'Menengah', 'category' => 'Kekuatan & Hipertrofi'],
            ['name' => 'Barbell Deadlift', 'target_muscle' => 'Punggung Bawah', 'equipment' => 'Barbell', 'difficulty' => 'Lanjut', 'category' => 'Kekuatan & Hipertrofi'],
        ];

        $created = [];
        foreach ($list as $item) {
            $created[$item['name']] = Exercise::create(array_merge($item, [
                'instructions' => 'Lakukan gerakan dengan postur stabil dan tempo terkontrol.',
            ]));
        }

        return $created;
    }

    public function test_program_generator_page_renders_cleanly(): void
    {
        $this->seedDiverseExercises();

        $this->get('/program-generator')->assertOk();
    }

    public function test_bodyweight_mode_strictly_excludes_pullup_bar_and_weighted_exercises(): void
    {
        $this->seedDiverseExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 45,
            'program_duration' => '1_week',
            'start_date' => '2026-11-18',
        ]);

        $this->assertTrue($result['ok']);
        $this->assertCount(7, $result['days']);

        $allExerciseNames = collect($result['days'])
            ->flatMap(fn ($d) => collect($d['exercises'])->pluck('name'))
            ->all();

        $this->assertNotContains('Pull-Up', $allExerciseNames);
        $this->assertNotContains('Barbell Bench Press', $allExerciseNames);
        $this->assertNotContains('Dumbbell Goblet Squat', $allExerciseNames);
        $this->assertNotEmpty($allExerciseNames);
    }

    public function test_with_equipment_mode_only_uses_selected_equipment_or_bodyweight(): void
    {
        $this->seedDiverseExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_STRENGTH,
            'equipment_mode' => 'with_equipment',
            'selected_equipments' => ['Dumbbell', 'Resistance Band'],
            'level' => 'intermediate',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 4,
            'session_duration_minutes' => 45,
            'program_duration' => '1_month',
            'start_date' => '2026-11-18',
        ]);

        $this->assertTrue($result['ok']);
        $this->assertCount(28, $result['days']);

        $usedEquipments = collect($result['days'])
            ->flatMap(fn ($d) => collect($d['exercises'])->pluck('equipment'))
            ->unique()
            ->values()
            ->all();

        $this->assertNotContains('Barbell', $usedEquipments);
        foreach ($usedEquipments as $eq) {
            $this->assertContains($eq, ['Bodyweight', 'Dumbbell', 'Resistance Band']);
        }
    }

    public function test_one_month_program_generates_28_days_with_phases_and_duration_based_plank(): void
    {
        $this->seedDiverseExercises();
        $generator = app(WorkoutProgramGenerator::class);

        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_ENDURANCE,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Full Body'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 45,
            'program_duration' => '1_month',
            'start_date' => '2026-11-18',
        ]);

        $this->assertTrue($result['ok']);
        $this->assertCount(28, $result['days']);
        $this->assertEquals(12, $result['program']['total_workout_days']);
        $this->assertEquals(16, $result['program']['total_rest_days']);

        $phases = collect($result['days'])->pluck('week_phase')->unique()->values()->all();
        $this->assertEquals(['Adaptasi', 'Progression', 'Development', 'Consolidation'], $phases);

        // Verify duration-based exercise uses seconds ("detik")
        $plankEntry = collect($result['days'])
            ->flatMap(fn ($d) => $d['exercises'])
            ->firstWhere('name', 'Plank');

        if ($plankEntry) {
            $this->assertTrue($plankEntry['is_duration_based']);
            $this->assertStringContainsString('detik', $plankEntry['target_reps']);
        }
    }

    public function test_insufficient_database_exercises_returns_clear_message_without_fake_data(): void
    {
        // Seed only 1 exercise for Biceps
        Exercise::create([
            'name' => 'Dumbbell Curl',
            'target_muscle' => 'Bisep',
            'equipment' => 'Dumbbell',
            'difficulty' => 'Pemula',
            'category' => 'Kekuatan & Hipertrofi',
            'instructions' => 'Angkat dumbbell secara terkontrol.',
        ]);

        $generator = app(WorkoutProgramGenerator::class);
        $result = $generator->generatePreview([
            'training_method' => WorkoutProgram::METHOD_HYPERTROPHY,
            'equipment_mode' => 'bodyweight',
            'level' => 'beginner',
            'target_muscles' => ['Biceps'],
            'frequency_per_week' => 3,
            'session_duration_minutes' => 30,
            'program_duration' => '1_week',
            'start_date' => '2026-11-18',
        ]);

        $this->assertFalse($result['ok']);
        $this->assertEquals(0, $result['available_count']);
        $this->assertNotEmpty($result['suggestions']);
    }

    public function test_save_program_integrates_with_rutinku_dashboard_and_user_isolation(): void
    {
        $this->seedDiverseExercises();

        $userA = User::factory()->create(['email_verified_at' => now()]);
        $userB = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($userA);

        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $component = Livewire::test(ProgramGenerator::class)
            ->set('trainingMethod', WorkoutProgram::METHOD_HYPERTROPHY)
            ->set('equipmentMode', 'bodyweight')
            ->set('level', 'beginner')
            ->set('targetMuscles', ['Full Body'])
            ->set('frequencyPerWeek', 3)
            ->set('sessionDurationMinutes', 30)
            ->set('programDuration', '1_week')
            ->set('startDate', $today)
            ->call('generateProgram')
            ->assertSet('previewData.ok', true);

        // Test substitute modal & replacement on Day 0 Exercise 0
        $component->call('openSubstituteModal', 0, 0)
            ->assertSet('replaceDayIndex', 0);
        $subs = $component->get('substituteOptions');
        if (! empty($subs)) {
            $component->call('applySubstitute', $subs[0]['id'])
                ->assertSet('replaceDayIndex', null);
        } else {
            $component->call('closeSubstituteModal');
        }

        // Save program to Rutinku
        $component->call('attemptSaveProgram')
            ->assertRedirect(route('workout.planner'));

        $program = WorkoutProgram::where('user_id', $userA->id)->first();
        $this->assertNotNull($program);
        $this->assertEquals(WorkoutProgram::STATUS_ACTIVE, $program->status);
        $this->assertCount(7, $program->days);

        // Sessions created in Rutinku
        $sessions = WorkoutSession::where('user_id', $userA->id)
            ->where('workout_program_id', $program->id)
            ->get();
        $this->assertCount(3, $sessions);

        // Dashboard shows active program summary for User A
        Livewire::test(Dashboard::class)
            ->assertSet('activeProgramSummary.id', $program->id)
            ->assertSet('activeProgramSummary.total_weeks', 1);

        // User B must NOT see User A's active program
        $this->actingAs($userB);
        Livewire::test(Dashboard::class)
            ->assertSet('activeProgramSummary', null);
    }
}
