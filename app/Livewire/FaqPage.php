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
            $faqsQuery->where(function ($query) {
                $query->where('pertanyaan', 'like', '%' . $this->search . '%')
                      ->orWhere('jawaban_singkat', 'like', '%' . $this->search . '%')
                      ->orWhere('contoh', 'like', '%' . $this->search . '%')
                      ->orWhere('sumber_nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kategori', 'like', '%' . $this->search . '%');
            });
        }

        $faqsByCategory = $faqsQuery->orderBy('id')->get()->groupBy('kategori');

        $categoryNames = [];
        foreach ($faqsByCategory->keys() as $kategori) {
            $categoryNames[$kategori] = Faq::categoryLabel($kategori);
        }

        return view('livewire.faq-page', [
            'faqsByCategory' => $faqsByCategory,
            'categoryNames' => $categoryNames,
        ])->layout('components.layouts.app');
    }
}
