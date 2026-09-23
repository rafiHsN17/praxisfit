<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProteinSource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'protein_per_100g'];
}
