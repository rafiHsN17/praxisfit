<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FitnessGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bulkingGoal = \App\Models\FitnessGoal::create([
            'name' => 'Hypertrophy / Bulking (Upper/Lower Split)',
            'description' => 'Fokus pada pembentukan otot dengan membagi hari latihan Upper Body dan Lower Body.',
            'split_type' => 'Upper/Lower',
        ]);

        $cuttingGoal = \App\Models\FitnessGoal::create([
            'name' => 'Fat Loss / Cutting (Full Body HIIT)',
            'description' => 'Fokus membakar lemak dengan latihan Full Body sirkuit intensitas tinggi.',
            'split_type' => 'Full Body',
        ]);

        // Get Exercises
        $reverseAngels = \App\Models\Exercise::where('name', 'Reverse Angels')->first();
        $pushUp = \App\Models\Exercise::where('name', 'Push Up')->first();
        $plankHold = \App\Models\Exercise::where('name', 'Plank Hold')->first();
        $diamondPushUp = \App\Models\Exercise::where('name', 'Diamond Push Up')->first();
        $pistolSquat = \App\Models\Exercise::where('name', 'Pistol Squat')->first();

        if ($bulkingGoal && $reverseAngels && $pushUp && $pistolSquat && $diamondPushUp && $plankHold) {
            // BULKING (Upper/Lower) Routines
            // Senin: Upper Body
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $pushUp->id,
                'day_of_week' => 'Senin',
                'sets' => 4,
                'reps' => '10-12',
                'notes' => 'Fokus pada kontraksi dada.',
            ]);
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $reverseAngels->id,
                'day_of_week' => 'Senin',
                'sets' => 3,
                'reps' => '12-15',
                'notes' => 'Tahan di puncak gerakan.',
            ]);
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $diamondPushUp->id,
                'day_of_week' => 'Senin',
                'sets' => 3,
                'reps' => '8-10',
                'notes' => 'Isolasi trisep.',
            ]);

            // Selasa: Lower Body & Core
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $pistolSquat->id,
                'day_of_week' => 'Selasa',
                'sets' => 4,
                'reps' => '5-8 (per kaki)',
                'notes' => 'Gunakan pegangan jika perlu keseimbangan.',
            ]);
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $plankHold->id,
                'day_of_week' => 'Selasa',
                'sets' => 3,
                'reps' => '60 detik',
                'notes' => 'Kencangkan otot perut.',
            ]);

            // Kamis: Upper Body
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $pushUp->id,
                'day_of_week' => 'Kamis',
                'sets' => 4,
                'reps' => 'Failure',
                'notes' => 'Amrap pada set terakhir.',
            ]);
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $reverseAngels->id,
                'day_of_week' => 'Kamis',
                'sets' => 4,
                'reps' => '15',
                'notes' => 'Gerakan perlahan.',
            ]);

            // Jumat: Lower Body
            \App\Models\FitnessGoalRoutine::create([
                'fitness_goal_id' => $bulkingGoal->id,
                'exercise_id' => $pistolSquat->id,
                'day_of_week' => 'Jumat',
                'sets' => 3,
                'reps' => '10 (per kaki)',
                'notes' => 'Fokus pada kedalaman.',
            ]);
            
            // CUTTING (Full Body HIIT) Routines
            // Senin, Rabu, Jumat (Full Body)
            foreach (['Senin', 'Rabu', 'Jumat'] as $day) {
                \App\Models\FitnessGoalRoutine::create([
                    'fitness_goal_id' => $cuttingGoal->id,
                    'exercise_id' => $pushUp->id,
                    'day_of_week' => $day,
                    'sets' => 3,
                    'reps' => '15',
                    'notes' => 'Istirahat antar set hanya 30 detik.',
                ]);
                \App\Models\FitnessGoalRoutine::create([
                    'fitness_goal_id' => $cuttingGoal->id,
                    'exercise_id' => $pistolSquat->id,
                    'day_of_week' => $day,
                    'sets' => 3,
                    'reps' => '12',
                    'notes' => 'Bisa diganti dengan bodyweight squat cepat.',
                ]);
                \App\Models\FitnessGoalRoutine::create([
                    'fitness_goal_id' => $cuttingGoal->id,
                    'exercise_id' => $plankHold->id,
                    'day_of_week' => $day,
                    'sets' => 3,
                    'reps' => '45 detik',
                    'notes' => 'Fokus pada pernapasan.',
                ]);
            }
        }
    }
}
