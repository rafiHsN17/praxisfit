<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class MuscleWikiSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            [
                'name' => 'Push Up',
                'target_muscle' => 'Dada',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Pemula',
                'instructions' => 'Posisikan tubuh tengkurap.|Angkat tubuh menggunakan lengan.|Turunkan kembali secara perlahan.',
                'video_male' => '[https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-pushup-front.mp4](https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-pushup-front.mp4)',
            ],
            [
                'name' => 'Pull Up',
                'target_muscle' => 'Lats',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Menengah',
                'instructions' => 'Gantungkan tubuh pada bar.|Tarik tubuh ke atas hingga dagu melewati bar.|Turunkan perlahan.',
                'video_male' => '[https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-pullup-front.mp4](https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-pullup-front.mp4)',
            ],
            [
                'name' => 'Squat',
                'target_muscle' => 'Paha Depan',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Pemula',
                'instructions' => 'Berdiri tegak selebar bahu.|Turunkan pinggul seperti ingin duduk.|Dorong kembali ke atas.',
                'video_male' => '[https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-squat-front.mp4](https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-squat-front.mp4)',
            ],
            [
                'name' => 'Crunches',
                'target_muscle' => 'Perut',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Pemula',
                'instructions' => 'Berbaring telentang dengan lutut ditekuk.|Angkat bahu dari lantai menggunakan otot perut.|Turunkan perlahan.',
                'video_male' => '[https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-crunch-front.mp4](https://media.musclewiki.com/media/uploads/videos/branded/male-bodyweight-crunch-front.mp4)',
            ],
            [
                'name' => 'Dumbbell Bicep Curl',
                'target_muscle' => 'Bisep',
                'equipment' => 'Dumbbell',
                'difficulty' => 'Pemula',
                'instructions' => 'Pegang dumbbell di kedua tangan.|Angkat dumbbell ke arah bahu.|Turunkan perlahan.',
                'alternative_equipment' => 'Dumbbell bisa diganti dengan ember berisi buku, jerigen air, atau tas yang diberi beban.',
                'video_male' => '[https://media.musclewiki.com/media/uploads/videos/branded/male-dumbbell-bicep-curl-front.mp4](https://media.musclewiki.com/media/uploads/videos/branded/male-dumbbell-bicep-curl-front.mp4)',
            ]
        ];

        foreach ($exercises as $data) {
            Exercise::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
