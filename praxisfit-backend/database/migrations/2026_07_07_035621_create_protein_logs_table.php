<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::create('protein_logs', function (Blueprint $table) {
            $table->id();
            // Tambahkan 4 baris ini:
            $table->integer('user_id');
            $table->integer('jumlah_protein');
            $table->string('sumber_makanan');
            $table->date('tanggal');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protein_logs');
    }
};