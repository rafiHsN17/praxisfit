<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // [AUTO-MIGRATION FAILSAFE]: Ubah tipe kolom dari ENUM ke VARCHAR(100) agar mendukung target otot spesifik
        try {
            DB::statement("ALTER TABLE exercises MODIFY COLUMN target_muscle VARCHAR(100) NOT NULL");
        } catch (\Exception $e) {
            // Abaikan jika database bukan MySQL atau kolom sudah bertipe string
        }

        $this->command->info('Mengunduh data dari GitHub Yuhonas (Gratis, tanpa API Key)...');

        // Menggunakan withoutVerifying() dan timeout agar lancar di Windows/XAMPP tanpa error SSL
        $response = Http::withoutVerifying()
            ->timeout(60)
            ->get('https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/dist/exercises.json');

        if ($response->failed()) {
            $this->command->error('Gagal mengambil data dari GitHub. Pastikan koneksi internet lancar.');
            return;
        }

        $exercises = $response->json();
        
        // Membersihkan data katalog lama agar database segar dan terstruktur rapi
        Exercise::query()->delete();

        $count = 0;
        $this->command->info('Memproses filter Bodyweight, memetakan otot spesifik ke Bahasa Indonesia, & menyinkronkan animasi...');

        foreach ($exercises as $ex) {
            // FILTER KRUSIAL: Ambil gerakan 'body weight', 'assisted', 'none', serta dumbbell, barbell, dan cable/band
            $equipment = strtolower(trim((string) ($ex['equipment'] ?? 'none')));
            $allowedEquipments = ['body only', 'body weight', 'bodyweight', 'assisted', 'none', 'body-only', 'calisthenics', 'other', '', 'dumbbell', 'barbell', 'cable', 'band'];

            if (!in_array($equipment, $allowedEquipments)) {
                continue; // Lewati jika menggunakan mesin gym kompleks lainnya
            }

            // Memproses target otot spesifik dari Yuhonas & menerjemahkan secara presisi ke Bahasa Indonesia
            $rawMuscles = $ex['primaryMuscles'] ?? $ex['secondaryMuscles'] ?? [];
            $rawBodyPart = (string) ($ex['bodyPart'] ?? '');
            $rawTarget = (string) ($ex['target'] ?? $ex['category'] ?? '');
            $target = $this->mapTarget((array) $rawMuscles, $rawBodyPart, $rawTarget, (string) ($ex['name'] ?? ''));

            // Memproses tingkat kesulitan
            $difficulty = $this->mapDifficulty($ex['level'] ?? '');

            // Merapikan instruksi asli
            $rawInstructions = '';
            if (isset($ex['instructions']) && is_array($ex['instructions'])) {
                $rawInstructions = implode(" ", $ex['instructions']);
            } elseif (isset($ex['instructions']) && is_string($ex['instructions'])) {
                $rawInstructions = $ex['instructions'];
            }
            
            if (empty(trim($rawInstructions))) {
                $rawInstructions = 'Lakukan gerakan ini dengan postur tubuh yang benar, jaga keseimbangan, dan atur tempo serta pernapasan dengan baik.';
            }

            // Overrides untuk gerakan yang instruksinya tidak lengkap/kosong dari sumber aslinya
            $overrides = [
                'Bicycling' => "Untuk memulai, duduklah di atas sepeda dan sesuaikan tempat duduk dengan tinggi badan Anda. Pastikan posisi lutut sedikit menekuk saat pedal berada di titik terendah. Pegang stang sepeda dengan posisi nyaman dan jaga punggung Anda agar tetap lurus atau sedikit condong ke depan. Mulailah mengayuh pedal dengan kecepatan stabil, pastikan gerakan memutar penuh dari atas ke bawah. Lakukan selama durasi yang ditentukan sambil mengatur napas secara teratur.",
                'Side Bridge' => "Berbaringlah miring dengan tubuh ditopang oleh satu siku dan sisi luar kaki bawah Anda. Angkat pinggul hingga tubuh membentuk garis lurus dari kepala hingga kaki. Tahan posisi ini selama durasi yang ditentukan sambil menahan otot inti (core) tetap kencang. Atur napas dan pastikan pinggul tidak turun.",
                'Side Jackknife' => "Berbaring miring di lantai dengan kaki lurus ditumpuk. Letakkan tangan atas di belakang kepala. Angkat kaki atas dan batang tubuh secara bersamaan sehingga siku mendekati pinggul, mengontraksikan otot obliques (perut samping). Turunkan perlahan secara terkontrol dan ulangi sebelum berganti sisi.",
                'Shoulder Raise' => "Berdirilah tegak dengan lengan rileks di samping tubuh. Angkat kedua bahu Anda lurus ke atas menuju telinga (shrug). Tahan puncak kontraksi sejenak, lalu turunkan perlahan kembali ke posisi awal. Lakukan dengan gerakan terkontrol tanpa menyentak.",
                'Shoulder Stretch' => "Berdiri atau duduk tegak. Bawa satu lengan melintasi dada Anda dan jaga agar tetap lurus. Gunakan lengan satunya untuk menahan dan menariknya perlahan lebih dekat ke dada hingga terasa regangan di bahu. Tahan peregangan selama 15-30 detik lalu ganti sisi.",
                'Triceps Stretch' => "Angkat satu lengan ke atas dan tekuk siku sehingga tangan Anda berada di belakang leher. Gunakan tangan yang lain untuk memegang siku tersebut dan tarik perlahan ke belakang/dalam. Tahan posisi regangan ini selama 15-30 detik lalu ganti dengan lengan yang lain.",
                'Upper Back Stretch' => "Tautkan jari-jari kedua tangan di depan dada Anda. Luruskan lengan ke depan sambil memutar telapak tangan ke luar. Dorong lengan ke depan sejauh mungkin sambil sedikit membulatkan punggung atas dan menundukkan kepala. Tahan selama 15-30 detik untuk meregangkan punggung bagian atas.",
                'Side Neck Stretch' => "Duduk atau berdiri tegak dengan bahu rileks. Miringkan kepala perlahan ke satu sisi, mendekatkan telinga ke arah bahu. Anda bisa menggunakan tangan untuk memberi tarikan ekstra yang sangat lembut di sisi kepala. Tahan peregangan 15-30 detik lalu ulangi untuk sisi lainnya."
            ];

            $exName = ucwords($ex['name']);
            if (array_key_exists($exName, $overrides)) {
                $indoInstructions = $overrides[$exName];
            } else {
                // Format rincian ke Bahasa Indonesia berstandar kebugaran profesional
                $indoInstructions = $this->formatIndonesianInstructions($rawInstructions, $target);
            }

            // Menambahkan alternatif alat sesuai instruksi pengguna (Kecuali untuk otot Dada)
            $alternativeEquipmentText = null;
            if ($target !== 'Dada') {
                if (str_contains($equipment, 'dumbbell')) {
                    $alternativeEquipmentText = "Dumbbell bisa diganti dengan ember berisi buku, jerigen air, atau tas yang diberi beban.";
                } elseif (str_contains($equipment, 'barbell')) {
                    $alternativeEquipmentText = "Barbel bisa diganti dengan gagang kayu, tongkat besi, atau pull up bar yang sebelahnya dipakaikan beban dengan seimbang.";
                } elseif (str_contains($equipment, 'cable') || str_contains($equipment, 'band')) {
                    $alternativeEquipmentText = "Mesin tali (cable) bisa diganti dengan resistance band atau resistance band versi yoga.";
                }
            } 
            
            // Tautan animasi online
            $icon = '🏋️';
            $image_1 = null;
            $image_2 = null;

            if (!empty($ex['gifUrl']) && (str_starts_with($ex['gifUrl'], 'http://') || str_starts_with($ex['gifUrl'], 'https://'))) {
                $icon = $ex['gifUrl'];
            } elseif (!empty($ex['images']) && is_array($ex['images']) && count($ex['images']) > 0) {
                // Populate images array
                foreach ([0, 1] as $idx) {
                    if (isset($ex['images'][$idx])) {
                        $imgPath = $ex['images'][$idx];
                        $fullPath = $imgPath;
                        if (!str_starts_with($imgPath, 'http://') && !str_starts_with($imgPath, 'https://')) {
                            if (str_contains($imgPath, '/')) {
                                $fullPath = "https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/" . $imgPath;
                            } elseif (!empty($ex['id'])) {
                                $fullPath = "https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/" . $ex['id'] . "/" . $imgPath;
                            } else {
                                $fullPath = "https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/" . $imgPath;
                            }
                        }
                        
                        if ($idx === 0) {
                            $image_1 = $fullPath;
                            $icon = $fullPath; // Use first image as icon fallback
                        } else {
                            $image_2 = $fullPath;
                        }
                    }
                }
            } elseif (!empty($ex['gif_url'])) {
                $icon = $ex['gif_url'];
            }

            // Gunakan updateOrCreate untuk mencegah duplikasi data
            Exercise::updateOrCreate(
                ['name' => ucwords($ex['name'])],
                [
                    'target_muscle' => $target,
                    'difficulty'    => $difficulty,
                    'instructions'  => $indoInstructions,
                    'icon'          => $icon,
                    'image_1'       => $image_1,
                    'image_2'       => $image_2,
                    'alternative_equipment' => $alternativeEquipmentText
                ]
            );

            $count++;
        }

        $this->command->newLine();
        $this->command->info("Sukses! Berhasil memetakan dan menyimpan {$count} gerakan spesifik ke database.");
    }

    /**
     * Memetakan kelompok otot spesifik dari bahasa Inggris ke bahasa Indonesia yang akurat.
     */
    private function mapTarget(array $muscles, string $bodyPart, string $target, string $exerciseName): string
    {
        $combined = strtolower(implode(' ', $muscles) . ' ' . $bodyPart . ' ' . $target . ' ' . $exerciseName);

        $mapping = [
            'tricep' => 'Trisep',
            'bicep' => 'Bisep',
            'glute' => 'Bokong',
            'calv' => 'Betis',
            'calf' => 'Betis',
            'quad' => 'Paha Depan',
            'hamstring' => 'Paha Belakang',
            'abdomin' => 'Perut',
            'abs' => 'Perut',
            'pector' => 'Dada',
            'chest' => 'Dada',
            'latissimus' => 'Lats',
            'lats' => 'Lats',
            'deltoid' => 'Bahu',
            'delt' => 'Bahu',
            'shoulder' => 'Bahu',
            'cardio' => 'Kardio',
            'aerobic' => 'Kardio',
            'trapezius' => 'Trapezius',
            'traps' => 'Trapezius',
            'forearm' => 'Lengan Bawah',
            'lower back' => 'Punggung Bawah',
            'upper back' => 'Punggung Atas',
            'middle back' => 'Punggung Tengah',
            'back' => 'Punggung',
            'adduct' => 'Adduktor (Paha Dalam)',
            'abduct' => 'Abduktor (Paha Luar)',
            'neck' => 'Leher',
            'hip' => 'Pinggul',
        ];

        foreach ($mapping as $key => $indo) {
            if (str_contains($combined, $key)) {
                return $indo;
            }
        }

        return 'Lainnya';
    }

    /**
     * Menerjemahkan instruksi Yuhonas ke Bahasa Indonesia profesional menggunakan API Translate gratis.
     */
    private function formatIndonesianInstructions(string $rawText, string $target): string
    {
        // Gunakan Google Translate API (Gratis, tanpa key) untuk menerjemahkan teks mentah
        $translated = $rawText;
        try {
            $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=id&dt=t&q=' . urlencode($rawText);
            $response = Http::withoutVerifying()->timeout(10)->get($url);
            if ($response->successful()) {
                $json = $response->json();
                $result = '';
                if (isset($json[0]) && is_array($json[0])) {
                    foreach ($json[0] as $segment) {
                        if (isset($segment[0])) {
                            $result .= $segment[0];
                        }
                    }
                }
                if (!empty(trim($result))) {
                    $translated = $result;
                }
            }
        } catch (\Exception $e) {
            // Jika API gagal (rate limit/timeout), gunakan teks asli
            $translated = $rawText;
        }

        return trim($translated);
    }

    /**
     * Memetakan level kesulitan.
     */
    private function mapDifficulty($rawLevel): string
    {
        $level = strtolower((string) $rawLevel);
        if (str_contains($level, 'begin')) return 'Pemula';
        if (str_contains($level, 'inter')) return 'Menengah';
        if (str_contains($level, 'adv') || str_contains($level, 'expe')) return 'Lanjut';
        return 'Menengah';
    }
}
