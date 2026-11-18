<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'age')) {
                $table->unsignedSmallInteger('age')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'activity_level')) {
                $table->string('activity_level', 30)->nullable()->default('moderate')->after('age');
            }
            if (!Schema::hasColumn('users', 'calorie_target')) {
                $table->float('calorie_target')->nullable()->after('protein_target');
            }
            if (!Schema::hasColumn('users', 'fat_target')) {
                $table->float('fat_target')->nullable()->after('calorie_target');
            }
            if (!Schema::hasColumn('users', 'carb_target')) {
                $table->float('carb_target')->nullable()->after('fat_target');
            }
        });

        Schema::table('protein_sources', function (Blueprint $table) {
            if (!Schema::hasColumn('protein_sources', 'calories_per_100g')) {
                $table->decimal('calories_per_100g', 8, 2)->default(0)->after('protein_per_100g');
            }
            if (!Schema::hasColumn('protein_sources', 'fat_per_100g')) {
                $table->decimal('fat_per_100g', 8, 2)->default(0)->after('calories_per_100g');
            }
            if (!Schema::hasColumn('protein_sources', 'carbs_per_100g')) {
                $table->decimal('carbs_per_100g', 8, 2)->default(0)->after('fat_per_100g');
            }
        });

        Schema::table('protein_logs', function (Blueprint $table) {
            $table->decimal('jumlah_protein', 8, 2)->change();
            if (!Schema::hasColumn('protein_logs', 'berat_gram')) {
                $table->decimal('berat_gram', 8, 2)->nullable()->after('sumber_makanan');
            }
            if (!Schema::hasColumn('protein_logs', 'kalori')) {
                $table->decimal('kalori', 8, 2)->default(0)->after('jumlah_protein');
            }
            if (!Schema::hasColumn('protein_logs', 'lemak')) {
                $table->decimal('lemak', 8, 2)->default(0)->after('kalori');
            }
            if (!Schema::hasColumn('protein_logs', 'karbohidrat')) {
                $table->decimal('karbohidrat', 8, 2)->default(0)->after('lemak');
            }
            if (!Schema::hasColumn('protein_logs', 'waktu_makan')) {
                $table->string('waktu_makan', 30)->nullable()->default('Makan Utama')->after('tanggal');
            }
        });

        // Backfill TKPI macro defaults on existing protein_sources records without resetting IDs
        $macros = [
            'Dada Ayam Non-Fillet / Bone-in' => ['calories_per_100g' => 172.00, 'fat_per_100g' => 9.20, 'carbs_per_100g' => 0.00],
            'Dada Ayam Fillet / Boneless' => ['calories_per_100g' => 165.00, 'fat_per_100g' => 3.60, 'carbs_per_100g' => 0.00],
            'Telur Ayam Rebus' => ['calories_per_100g' => 155.00, 'fat_per_100g' => 11.00, 'carbs_per_100g' => 1.10],
            'Tempe Murni' => ['calories_per_100g' => 201.00, 'fat_per_100g' => 8.80, 'carbs_per_100g' => 13.50],
            'Whey Protein Concentrate' => ['calories_per_100g' => 400.00, 'fat_per_100g' => 5.00, 'carbs_per_100g' => 8.00],
            'Daging Sapi Tanpa Lemak' => ['calories_per_100g' => 185.00, 'fat_per_100g' => 8.00, 'carbs_per_100g' => 0.00],
            'Tahu' => ['calories_per_100g' => 80.00, 'fat_per_100g' => 4.70, 'carbs_per_100g' => 1.60],
        ];

        foreach ($macros as $name => $values) {
            DB::table('protein_sources')->where('name', $name)->update($values);
        }
    }

    public function down(): void
    {
        Schema::table('protein_logs', function (Blueprint $table) {
            foreach (['berat_gram', 'kalori', 'lemak', 'karbohidrat', 'waktu_makan'] as $col) {
                if (Schema::hasColumn('protein_logs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('protein_sources', function (Blueprint $table) {
            foreach (['calories_per_100g', 'fat_per_100g', 'carbs_per_100g'] as $col) {
                if (Schema::hasColumn('protein_sources', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['age', 'activity_level', 'calorie_target', 'fat_target', 'carb_target'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

