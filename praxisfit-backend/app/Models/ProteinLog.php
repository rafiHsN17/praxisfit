<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProteinLog extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar data boleh diisi
    protected $fillable = ['user_id', 'jumlah_protein', 'sumber_makanan', 'tanggal'];
}