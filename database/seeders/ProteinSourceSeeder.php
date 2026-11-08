<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProteinSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodDatabase = [
            "Dada Ayam Non-Fillet / Bone-in" => 21,
            "Dada Ayam Fillet / Boneless" => 31,
            "Telur Ayam Rebus" => 13,
            "Tempe Murni" => 19,
            "Whey Protein Concentrate" => 80,
            "Daging Sapi Tanpa Lemak" => 26,
            "Tahu" => 8
        ];

        foreach ($foodDatabase as $name => $protein) {
            \App\Models\ProteinSource::updateOrCreate(
                ['name' => $name],
                ['protein_per_100g' => $protein]
            );
        }
    }
}
