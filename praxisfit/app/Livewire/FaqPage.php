<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Faq;
use Livewire\Attributes\Title;

#[Title('FAQ - PraxisFit')]
class FaqPage extends Component
{
    public $search = '';

    public function render()
    {
        $faqsQuery = Faq::query();

        if (!empty($this->search)) {
            $faqsQuery->where('pertanyaan', 'like', '%' . $this->search . '%')
                      ->orWhere('jawaban_singkat', 'like', '%' . $this->search . '%')
                      ->orWhere('contoh', 'like', '%' . $this->search . '%');
        }

        $faqsByCategory = $faqsQuery->get()->groupBy('kategori');
        
        $categoryNames = [
            'latihan' => 'Seputar Latihan',
            'latihan_di_rumah' => 'Latihan di Rumah (Home Workout)',
            'nutrisi' => 'Protein & Nutrisi',
            'pola_tidur' => 'Pola Tidur & Recovery',
            'suplemen_mitos' => 'Suplemen & Mitos',
            'keamanan' => 'Cedera & Keamanan',
            'mindset' => 'Mindset & Konsistensi',
        ];

        return view('livewire.faq-page', [
            'faqsByCategory' => $faqsByCategory,
            'categoryNames' => $categoryNames,
        ])->layout('components.layouts.app');
    }
}
