<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $guarded = ['id'];

    /**
     * Daftar kategori bawaan beserta judul tampilannya.
     */
    public const DEFAULT_CATEGORIES = [
        'panduan_praxisfit' => 'Panduan Fitur PraxisFit',
        'latihan' => 'Seputar Latihan',
        'latihan_di_rumah' => 'Latihan di Rumah (Home Workout)',
        'nutrisi' => 'Protein & Nutrisi',
        'pola_tidur' => 'Pola Tidur & Recovery',
        'suplemen_mitos' => 'Suplemen & Mitos',
        'keamanan' => 'Cedera & Keamanan',
        'mindset' => 'Mindset & Konsistensi',
    ];

    /**
     * Mengembalikan label judul kategori yang rapi untuk ditampilkan di halaman user maupun admin.
     */
    public static function categoryLabel(?string $kategori): string
    {
        if (!$kategori) {
            return 'Umum';
        }

        if (isset(self::DEFAULT_CATEGORIES[$kategori])) {
            return self::DEFAULT_CATEGORIES[$kategori];
        }

        return str_contains($kategori, '_')
            ? ucwords(str_replace('_', ' ', $kategori))
            : $kategori;
    }
}
