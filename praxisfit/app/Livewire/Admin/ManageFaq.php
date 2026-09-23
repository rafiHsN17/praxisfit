<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Faq;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ManageFaq extends Component
{
    public $faqs;
    public $faq_id;
    public $question;
    public $answer;
    public $isEditMode = false;

    public function render()
    {
        $this->faqs = Faq::latest()->get();
        return view('livewire.admin.manage-faq');
    }

    public function store()
    {
        $this->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);

        session()->flash('message', 'FAQ berhasil ditambahkan!');
        $this->cancelEdit();
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faq_id = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        if ($this->faq_id) {
            $faq = Faq::find($this->faq_id);
            $faq->update([
                'question' => $this->question,
                'answer' => $this->answer,
            ]);

            session()->flash('message', 'FAQ berhasil diperbarui!');
            $this->cancelEdit();
        }
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();
        session()->flash('message', 'FAQ berhasil dihapus!');
    }

    public function cancelEdit()
    {
        $this->reset(['faq_id', 'question', 'answer', 'isEditMode']);
    }
}
