<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn(['video_male', 'video_female', 'youtube_url']);
            $table->string('image_1')->nullable()->after('icon');
            $table->string('image_2')->nullable()->after('image_1');
            $table->string('image_3')->nullable()->after('image_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->string('video_male')->nullable();
            $table->string('video_female')->nullable();
            $table->string('youtube_url')->nullable();
            $table->dropColumn(['image_1', 'image_2', 'image_3']);
        });
    }
};
