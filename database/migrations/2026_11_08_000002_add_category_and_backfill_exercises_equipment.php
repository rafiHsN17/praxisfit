<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (!Schema::hasColumn('exercises', 'category')) {
                $table->string('category', 60)->nullable()->after('target_muscle');
            }
        });

        // Deterministic backfill of equipment & category on existing rows without altering IDs
        DB::table('exercises')
            ->select(['id', 'name', 'target_muscle', 'equipment', 'category', 'alternative_equipment', 'instructions'])
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    $nameLower = strtolower((string) $row->name);
                    $altLower = strtolower((string) ($row->alternative_equipment ?? ''));
                    $instLower = strtolower((string) ($row->instructions ?? ''));
                    $muscleLower = strtolower((string) ($row->target_muscle ?? ''));

                    $equipment = $row->equipment;
                    if (empty(trim((string) $equipment))) {
                        if (str_contains($nameLower, 'kettlebell') || str_contains($instLower, 'kettlebell')) {
                            $equipment = 'Kettlebell';
                        } elseif (str_contains($nameLower, 'resistance band') || str_contains($nameLower, 'band ') || str_ends_with($nameLower, ' band') || str_contains($nameLower, 'banded')) {
                            $equipment = 'Resistance Band';
                        } elseif (str_contains($nameLower, 'cable') || str_contains($altLower, 'mesin tali') || str_contains($altLower, 'cable')) {
                            $equipment = 'Cable';
                        } elseif (str_contains($nameLower, 'dumbbell') || str_contains($altLower, 'dumbbell')) {
                            $equipment = 'Dumbbell';
                        } elseif (str_contains($nameLower, 'barbell') || str_contains($nameLower, 'ez-bar') || str_contains($nameLower, 'ez bar') || str_contains($altLower, 'barbel')) {
                            $equipment = 'Barbell';
                        } elseif (str_contains($nameLower, 'machine') || str_contains($nameLower, 'smith machine') || str_contains($nameLower, 'leg press')) {
                            $equipment = 'Machine';
                        } elseif (str_contains($nameLower, 'medicine ball') || str_contains($nameLower, 'exercise ball') || str_contains($nameLower, 'stability ball') || str_contains($nameLower, 'swiss ball') || str_contains($nameLower, 'foam roll') || str_contains($nameLower, 'plate') || str_contains($nameLower, 'bosu')) {
                            $equipment = 'Alat Bantu Lainnya';
                        } else {
                            $equipment = 'Bodyweight';
                        }
                    }

                    $category = $row->category;
                    if (empty(trim((string) $category))) {
                        if (
                            str_contains($muscleLower, 'kardio') ||
                            str_contains($nameLower, 'jogging') ||
                            str_contains($nameLower, 'running') ||
                            str_contains($nameLower, 'bicycling') ||
                            str_contains($nameLower, 'burpee') ||
                            str_contains($nameLower, 'jump') ||
                            str_contains($nameLower, 'sprint') ||
                            str_contains($nameLower, 'skipping')
                        ) {
                            $category = 'Kardio & Daya Tahan';
                        } elseif (
                            str_contains($nameLower, 'stretch') ||
                            str_contains($nameLower, 'foam') ||
                            str_contains($nameLower, 'mobility') ||
                            str_contains($nameLower, 'smr') ||
                            str_contains($nameLower, 'yoga') ||
                            str_contains($nameLower, 'windmill') ||
                            str_contains($nameLower, 'roll')
                        ) {
                            $category = 'Mobilitas & Peregangan';
                        } else {
                            $category = 'Kekuatan & Hipertrofi';
                        }
                    }

                    DB::table('exercises')
                        ->where('id', $row->id)
                        ->update([
                            'equipment' => $equipment,
                            'category' => $category,
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (Schema::hasColumn('exercises', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};

