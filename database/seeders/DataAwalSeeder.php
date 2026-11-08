<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataAwalSeeder extends Seeder
{
    /**
     * Memuat data awal FAQ PraxisFit menggunakan FaqSeeder terbaru
     * yang seluruhnya bersumber dari pakar medis & kebugaran Indonesia.
     */
    public function run(): void
    {
        $this->call([
            FaqSeeder::class,
        ]);
    }
}
