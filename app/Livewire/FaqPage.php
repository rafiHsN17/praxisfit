<?php

namespace App\Livewire;

use App\Models\Faq;
use App\Models\SupportMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('FAQ & Pusat Bantuan - PraxisFit')]
class FaqPage extends Component
{
    public string $search = '';

    public string $activeCategory = '';

    // Form Bantuan ("Masih Membutuhkan Bantuan?")
    public bool $showContactForm = false;

    public bool $contactSubmitted = false;

    public string $contactName = '';

    public string $contactEmail = '';

    public string $contactSubject = '';

    public string $contactMessage = '';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->contactName = Auth::user()->name ?? '';
            $this->contactEmail = Auth::user()->email ?? '';
        }
    }

    public function setCategory(string $category): void
    {
        $this->activeCategory = $category;
    }

    public function openContactForm(): void
    {
        $this->showContactForm = ! $this->showContactForm;
        $this->contactSubmitted = false;
    }

    public function submitSupportMessage(): void
    {
        $this->validate([
            'contactName' => 'required|string|max:120',
            'contactEmail' => 'required|email|max:160',
            'contactSubject' => 'required|string|max:150',
            'contactMessage' => 'required|string|min:10|max:2000',
        ], [
            'contactName.required' => 'Nama lengkap wajib diisi.',
            'contactEmail.required' => 'Alamat email wajib diisi.',
            'contactEmail.email' => 'Format email tidak valid.',
            'contactSubject.required' => 'Subjek pertanyaan wajib diisi.',
            'contactMessage.required' => 'Pesan pertanyaan wajib diisi.',
            'contactMessage.min' => 'Pesan minimal 10 karakter agar tim kami dapat memahami kendala Anda.',
        ]);

        SupportMessage::create([
            'user_id' => Auth::id(),
            'name' => trim($this->contactName),
            'email' => trim($this->contactEmail),
            'subject' => trim($this->contactSubject),
            'message' => trim($this->contactMessage),
            'status' => 'new',
        ]);

        $this->reset(['contactSubject', 'contactMessage']);
        if (! Auth::check()) {
            $this->reset(['contactName', 'contactEmail']);
        }
        $this->contactSubmitted = true;
        $this->showContactForm = true;
    }

    public function render()
    {
        $allCategories = Faq::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->mapWithKeys(fn ($cat) => [$cat => Faq::categoryLabel($cat)])
            ->all();

        $faqsQuery = Faq::query();

        if ($this->activeCategory !== '') {
            $faqsQuery->where('kategori', $this->activeCategory);
        }

        if (trim($this->search) !== '') {
            $term = '%'.trim($this->search).'%';
            $faqsQuery->where(function ($query) use ($term) {
                $query->where('pertanyaan', 'like', $term)
                    ->orWhere('jawaban_singkat', 'like', $term)
                    ->orWhere('contoh', 'like', $term)
                    ->orWhere('sumber_nama', 'like', $term)
                    ->orWhere('kategori', 'like', $term);
            });
        }

        $faqs = $faqsQuery->orderBy('id')->get();

        return view('livewire.faq-page', [
            'faqs' => $faqs,
            'allCategories' => $allCategories,
        ])->layout('components.layouts.app');
    }
}
