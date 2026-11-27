<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\FitnessGoal;
use App\Models\FitnessGoalRoutine;
use Illuminate\Database\Seeder;

class FitnessGoalSeeder extends Seeder
{
    /**
     * Sinkronisasi 4 Tujuan Latihan utama agar sejalan antara Halaman User (/profil, /program-generator) dan Admin.
     */
    public function run(): void
    {
        $goalsConfig = [
            [
                'match_keywords' => ['Hypertrophy', 'Bulking'],
                'name' => 'Hypertrophy / Pembentukan Massa Otot',
                'description' => 'Fokus pembentukan ukuran dan massa otot dengan volume terencana, pembagian Upper/Lower Split, dan jeda pemulihan 48–72 jam.',
                'split_type' => 'Upper/Lower Split',
                'routines' => [
                    ['keywords' => ['Push Up', 'Bench Press'], 'day' => 'Senin', 'sets' => 3, 'reps' => '8-12', 'notes' => 'Kontrol fase turun 2 detik untuk hipertrofi dada & trisep.'],
                    ['keywords' => ['Row', 'Pull', 'Superman'], 'day' => 'Senin', 'sets' => 3, 'reps' => '8-12', 'notes' => 'Tarik penuh dengan kontraksi otot punggung.'],
                    ['keywords' => ['Squat', 'Lunge'], 'day' => 'Selasa', 'sets' => 3, 'reps' => '8-12', 'notes' => 'Fokus kedalaman gerak dan kontrol paha depan.'],
                    ['keywords' => ['Plank', 'Crunch'], 'day' => 'Selasa', 'sets' => 3, 'reps' => '30 detik', 'notes' => 'Kencangkan core selama durasi tahan.'],
                    ['keywords' => ['Pike Push', 'Shoulder Press', 'Incline Push'], 'day' => 'Kamis', 'sets' => 3, 'reps' => '10-12', 'notes' => 'Jarak 72 jam dari sesi Upper Senin untuk pemulihan optimal.'],
                    ['keywords' => ['Glute Bridge', 'Deadlift'], 'day' => 'Jumat', 'sets' => 3, 'reps' => '10-12', 'notes' => 'Fokus aktivasi glutes dan paha belakang.'],
                ],
            ],
            [
                'match_keywords' => ['Strength'],
                'name' => 'Strength Training / Kekuatan Otot',
                'description' => 'Memprioritaskan gerakan utama (compound) dengan repetisi lebih rendah, teknik ketat, dan waktu istirahat cukup antar set.',
                'split_type' => 'Full Body Kekuatan',
                'routines' => [
                    ['keywords' => ['Push Up', 'Bench Press'], 'day' => 'Senin', 'sets' => 3, 'reps' => '5-8', 'notes' => 'Utamakan kualitas teknik dan kontrol penuh.'],
                    ['keywords' => ['Squat', 'Leg Press'], 'day' => 'Senin', 'sets' => 3, 'reps' => '5-8', 'notes' => 'Istirahat 90–120 detik antar set.'],
                    ['keywords' => ['Row', 'Pull', 'Superman'], 'day' => 'Rabu', 'sets' => 3, 'reps' => '6-8', 'notes' => 'Jeda minimal 48 jam dari sesi sebelumnya.'],
                    ['keywords' => ['Pike Push', 'Shoulder Press'], 'day' => 'Jumat', 'sets' => 3, 'reps' => '5-8', 'notes' => 'Jaga postur inti tetap stabil.'],
                ],
            ],
            [
                'match_keywords' => ['Endurance', 'Daya Tahan'],
                'name' => 'Endurance / Daya Tahan Otot',
                'description' => 'Meningkatkan kemampuan otot bekerja lebih lama dengan repetisi lebih tinggi, istirahat singkat terukur, dan kontrol napas.',
                'split_type' => 'Full Body Circuit',
                'routines' => [
                    ['keywords' => ['Squat', 'Lunge'], 'day' => 'Senin', 'sets' => 3, 'reps' => '15-20', 'notes' => 'Tempo stabil, istirahat 35–45 detik.'],
                    ['keywords' => ['Push Up', 'Knee Push'], 'day' => 'Rabu', 'sets' => 3, 'reps' => '15-20', 'notes' => 'Jaga ritme pernapasan konsisten.'],
                    ['keywords' => ['Plank', 'Mountain'], 'day' => 'Jumat', 'sets' => 3, 'reps' => '45 detik', 'notes' => 'Tahan postur netral tanpa menumpuk kelelahan.'],
                ],
            ],
            [
                'match_keywords' => ['Fat Loss', 'Cutting', 'Conditioning'],
                'name' => 'Fat Loss / Conditioning',
                'description' => 'Menggabungkan latihan resistensi dan conditioning untuk mendukung kebugaran menyeluruh tanpa membebani pemulihan kaki secara berlebihan.',
                'split_type' => 'Full Body Conditioning',
                'routines' => [
                    ['keywords' => ['Push Up', 'Incline Push'], 'day' => 'Senin', 'sets' => 3, 'reps' => '12-15', 'notes' => 'Istirahat antar set 35–45 detik.'],
                    ['keywords' => ['Squat', 'Lunge'], 'day' => 'Rabu', 'sets' => 3, 'reps' => '12-15', 'notes' => 'Dipisah dari sesi kaki berat agar pemulihan terjaga.'],
                    ['keywords' => ['Plank', 'Crunch'], 'day' => 'Jumat', 'sets' => 3, 'reps' => '35 detik', 'notes' => 'Fokus stabilitas inti dan pemulihan aktif.'],
                ],
            ],
        ];

        $allExercises = Exercise::orderBy('id')->get();

        foreach ($goalsConfig as $cfg) {
            $existing = FitnessGoal::where(function ($q) use ($cfg) {
                foreach ($cfg['match_keywords'] as $kw) {
                    $q->orWhere('name', 'like', "%{$kw}%");
                }
            })->first();

            if ($existing) {
                $existing->update([
                    'name' => $cfg['name'],
                    'description' => $cfg['description'],
                    'split_type' => $cfg['split_type'],
                ]);
                $goal = $existing;
            } else {
                $goal = FitnessGoal::create([
                    'name' => $cfg['name'],
                    'description' => $cfg['description'],
                    'split_type' => $cfg['split_type'],
                ]);
            }

            if ($allExercises->isEmpty() || $goal->routines()->count() > 0) {
                continue;
            }

            foreach ($cfg['routines'] as $r) {
                $matched = $allExercises->first(function ($ex) use ($r) {
                    $nameLower = strtolower($ex->name);
                    foreach ($r['keywords'] as $kw) {
                        if (str_contains($nameLower, strtolower($kw))) {
                            return true;
                        }
                    }

                    return false;
                }) ?? $allExercises->first();

                if ($matched) {
                    FitnessGoalRoutine::create([
                        'fitness_goal_id' => $goal->id,
                        'exercise_id' => $matched->id,
                        'day_of_week' => $r['day'],
                        'sets' => $r['sets'],
                        'reps' => $r['reps'],
                        'notes' => $r['notes'],
                    ]);
                }
            }
        }
    }
}
