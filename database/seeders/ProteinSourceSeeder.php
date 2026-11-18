<?php

namespace Database\Seeders;

use App\Models\ProteinSource;
use Illuminate\Database\Seeder;

class ProteinSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Nilai gizi mengacu pada Tabel Komposisi Pangan Indonesia (TKPI) Kemenkes RI per 100 gram bahan pangan.
     */
    public function run(): void
    {
        $foodDatabase = [
            'Dada Ayam Non-Fillet / Bone-in' => [
                'protein_per_100g' => 21.0,
                'calories_per_100g' => 172.0,
                'fat_per_100g' => 9.2,
                'carbs_per_100g' => 0.0,
            ],
            'Dada Ayam Fillet / Boneless' => [
                'protein_per_100g' => 31.0,
                'calories_per_100g' => 165.0,
                'fat_per_100g' => 3.6,
                'carbs_per_100g' => 0.0,
            ],
            'Telur Ayam Rebus' => [
                'protein_per_100g' => 13.0,
                'calories_per_100g' => 155.0,
                'fat_per_100g' => 11.0,
                'carbs_per_100g' => 1.1,
            ],
            'Tempe Murni' => [
                'protein_per_100g' => 19.0,
                'calories_per_100g' => 201.0,
                'fat_per_100g' => 8.8,
                'carbs_per_100g' => 13.5,
            ],
            'Whey Protein Concentrate' => [
                'protein_per_100g' => 80.0,
                'calories_per_100g' => 400.0,
                'fat_per_100g' => 5.0,
                'carbs_per_100g' => 8.0,
            ],
            'Daging Sapi Tanpa Lemak' => [
                'protein_per_100g' => 26.0,
                'calories_per_100g' => 185.0,
                'fat_per_100g' => 8.0,
                'carbs_per_100g' => 0.0,
            ],
            'Tahu' => [
                'protein_per_100g' => 8.0,
                'calories_per_100g' => 80.0,
                'fat_per_100g' => 4.7,
                'carbs_per_100g' => 1.6,
            ],
            'Ikan Tongkol / Tuna Segar' => [
                'protein_per_100g' => 24.0,
                'calories_per_100g' => 111.0,
                'fat_per_100g' => 1.5,
                'carbs_per_100g' => 0.0,
            ],
            'Ikan Kembung Segar' => [
                'protein_per_100g' => 21.3,
                'calories_per_100g' => 125.0,
                'fat_per_100g' => 3.4,
                'carbs_per_100g' => 0.0,
            ],
            'Nasi Putih' => [
                'protein_per_100g' => 2.7,
                'calories_per_100g' => 130.0,
                'fat_per_100g' => 0.3,
                'carbs_per_100g' => 28.6,
            ],
            'Nasi Merah' => [
                'protein_per_100g' => 2.8,
                'calories_per_100g' => 110.0,
                'fat_per_100g' => 0.4,
                'carbs_per_100g' => 23.0,
            ],
            'Oatmeal / Havermut' => [
                'protein_per_100g' => 13.5,
                'calories_per_100g' => 379.0,
                'fat_per_100g' => 6.5,
                'carbs_per_100g' => 67.7,
            ],
            'Kentang Rebus' => [
                'protein_per_100g' => 2.1,
                'calories_per_100g' => 87.0,
                'fat_per_100g' => 0.1,
                'carbs_per_100g' => 20.1,
            ],
        ];

        foreach ($foodDatabase as $name => $macros) {
            ProteinSource::updateOrCreate(
                ['name' => $name],
                $macros
            );
        }
    }
}
