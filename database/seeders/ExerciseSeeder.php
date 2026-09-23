<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            [
                'name' => 'Reverse Angels',
                'target_muscle' => 'Back',
                'equipment' => 'Matras',
                'difficulty' => 'Beginner',
                'instructions' => '1. Siapkan matras sebagai alas. Jangan lakukan di lantai keras. 2. Posisikan tengkurap, tarik bahu ke belakang dan bawah. 3. Kencangkan otot perut (core) secara aktif. 4. Lakukan gerakan lengan mengayun, posisi kaki tetap menempel di lantai.',
                'video_reference' => 'https://youtu.be/d1WqUM51Gw0'
            ],
            [
                'name' => 'Push Up',
                'target_muscle' => 'Chest',
                'equipment' => 'Tanpa Alat',
                'difficulty' => 'Beginner',
                'instructions' => '1. Posisikan tubuh tengkurap dengan tangan diletakkan sedikit lebih lebar dari bahu. 2. Jaga punggung tetap lurus dan core diaktifkan. 3. Turunkan badan perlahan hingga dada hampir menyentuh lantai. 4. Dorong kembali tubuh ke atas hingga lengan lurus.',
                'video_reference' => null
            ],
            [
                'name' => 'Plank Hold',
                'target_muscle' => 'Core',
                'equipment' => 'Matras',
                'difficulty' => 'Beginner',
                'instructions' => '1. Posisikan siku di atas matras sejajar dengan bahu. 2. Angkat tubuh hingga membentuk garis lurus dari kepala hingga tumit. 3. Tahan posisi tersebut sambil mengencangkan otot perut dan glutes. Jangan biarkan pinggul turun.',
                'video_reference' => null
            ],
            [
                'name' => 'Diamond Push Up',
                'target_muscle' => 'Triceps',
                'equipment' => 'Tanpa Alat',
                'difficulty' => 'Intermediate',
                'instructions' => '1. Ambil posisi push up, namun dekatkan kedua tangan hingga telunjuk dan ibu jari saling bersentuhan membentuk wajik (diamond) tepat di bawah dada. 2. Turunkan badan secara perlahan. 3. Dorong kembali ke posisi semula.',
                'video_reference' => null
            ],
            [
                'name' => 'Pistol Squat',
                'target_muscle' => 'Legs',
                'equipment' => 'Tanpa Alat',
                'difficulty' => 'Advanced',
                'instructions' => '1. Berdiri dengan satu kaki, sementara kaki lainnya diluruskan ke depan. 2. Turunkan badan secara perlahan seperti gerakan jongkok namun hanya menggunakan satu kaki penyangga. 3. Jaga keseimbangan dan dorong kembali tubuh ke posisi berdiri tegak.',
                'video_reference' => null
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}