<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Faq;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Kelola FAQ - Admin PraxisFit')]
class ManageFaq extends Component
{
    // Filter & Pencarian Tabel
    public string $search = '';
    public string $filterKategori = '';

    // State Form Tambah / Edit FAQ
    public ?int $faq_id = null;
    public string $pertanyaan = '';
    public string $jawaban_singkat = '';
    public string $contoh = '';
    public string $sumber_nama = '';
    public string $sumber_url = '';
    public string $kategori = 'panduan_praxisfit';
    public string $kategori_baru = '';
    public bool $isEditMode = false;

    // State Form Ganti Nama Judul Kategori Sekaligus
    public string $renameTargetKey = '';
    public string $renameNewTitle = '';

    protected function rules(): array
    {
        return [
            'pertanyaan' => 'required|string|max:255',
            'jawaban_singkat' => 'required|string',
            'contoh' => 'nullable|string',
            'sumber_nama' => 'required|string|max:255',
            'sumber_url' => 'required|url|max:500',
            'kategori' => 'required|string|max:120',
            'kategori_baru' => $this->kategori === '__baru__' ? 'required|string|max:120' : 'nullable|string|max:120',
        ];
    }

    protected array $messages = [
        'pertanyaan.required' => 'Pertanyaan wajib diisi.',
        'jawaban_singkat.required' => 'Jawaban wajib diisi.',
        'sumber_nama.required' => 'Nama sumber referensi wajib diisi.',
        'sumber_url.required' => 'Link URL sumber referensi wajib diisi.',
        'sumber_url.url' => 'Format link URL tidak valid (gunakan awalan https://).',
        'kategori.required' => 'Judul kategori wajib dipilih.',
        'kategori_baru.required' => 'Ketik nama judul kategori baru terlebih dahulu.',
    ];

    /**
     * Menggabungkan daftar kategori bawaan dan kategori kustom yang sudah ada di database.
     */
    public function getAvailableCategoriesProperty(): array
    {
        $categories = Faq::DEFAULT_CATEGORIES;

        $dbCategories = Faq::query()
            ->select('kategori')
            ->distinct()
            ->pluck('kategori');

        foreach ($dbCategories as $cat) {
            if ($cat && !isset($categories[$cat])) {
                $categories[$cat] = Faq::categoryLabel($cat);
            }
        }

        return $categories;
    }

    private function resolveSelectedCategory(): string
    {
        if ($this->kategori === '__baru__') {
            return trim($this->kategori_baru);
        }

        return trim($this->kategori);
    }

    public function store(): void
    {
        $this->validate();

        Faq::create([
            'pertanyaan' => trim($this->pertanyaan),
            'jawaban_singkat' => trim($this->jawaban_singkat),
            'contoh' => trim($this->contoh) !== '' ? trim($this->contoh) : null,
            'sumber_nama' => trim($this->sumber_nama),
            'sumber_url' => trim($this->sumber_url),
            'kategori' => $this->resolveSelectedCategory(),
        ]);

        session()->flash('message', 'FAQ baru berhasil ditambahkan!');
        $this->cancelEdit();
    }

    public function edit(int $id): void
    {
        $faq = Faq::findOrFail($id);

        $this->faq_id = $faq->id;
        $this->pertanyaan = $faq->pertanyaan;
        $this->jawaban_singkat = $faq->jawaban_singkat;
        $this->contoh = (string) ($faq->contoh ?? '');
        $this->sumber_nama = $faq->sumber_nama;
        $this->sumber_url = $faq->sumber_url;
        $this->kategori = $faq->kategori;
        $this->kategori_baru = '';
        $this->isEditMode = true;
        $this->resetErrorBag();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->faq_id) {
            $faq = Faq::findOrFail($this->faq_id);
            $faq->update([
                'pertanyaan' => trim($this->pertanyaan),
                'jawaban_singkat' => trim($this->jawaban_singkat),
                'contoh' => trim($this->contoh) !== '' ? trim($this->contoh) : null,
                'sumber_nama' => trim($this->sumber_nama),
                'sumber_url' => trim($this->sumber_url),
                'kategori' => $this->resolveSelectedCategory(),
            ]);

            session()->flash('message', 'Data FAQ berhasil diperbarui!');
            $this->cancelEdit();
        }
    }

    /**
     * Mengganti nama judul kategori sekaligus untuk seluruh item FAQ di kategori tersebut.
     */
    public function renameCategory(): void
    {
        $this->validate([
            'renameTargetKey' => 'required|string',
            'renameNewTitle' => 'required|string|max:120',
        ], [
            'renameTargetKey.required' => 'Pilih judul kategori yang ingin diganti.',
            'renameNewTitle.required' => 'Masukkan nama judul kategori yang baru.',
        ]);

        $newTitle = trim($this->renameNewTitle);

        $updated = Faq::where('kategori', $this->renameTargetKey)
            ->update(['kategori' => $newTitle]);

        if ($this->filterKategori === $this->renameTargetKey) {
            $this->filterKategori = $newTitle;
        }

        $this->reset(['renameTargetKey', 'renameNewTitle']);

        session()->flash('message', "Judul kategori berhasil diganti menjadi \"{$newTitle}\" ({$updated} FAQ diperbarui)!");
    }

    public function delete(int $id): void
    {
        Faq::findOrFail($id)->delete();

        if ($this->faq_id === $id) {
            $this->cancelEdit();
        }

        session()->flash('message', 'FAQ berhasil dihapus!');
    }

    public function cancelEdit(): void
    {
        $this->reset([
            'faq_id',
            'pertanyaan',
            'jawaban_singkat',
            'contoh',
            'sumber_nama',
            'sumber_url',
            'kategori_baru',
            'isEditMode',
        ]);
        $this->kategori = 'panduan_praxisfit';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Faq::query();

        if ($this->filterKategori !== '') {
            $query->where('kategori', $this->filterKategori);
        }

        if (trim($this->search) !== '') {
            $keyword = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('pertanyaan', 'like', $keyword)
                  ->orWhere('jawaban_singkat', 'like', $keyword)
                  ->orWhere('contoh', 'like', $keyword)
                  ->orWhere('sumber_nama', 'like', $keyword);
            });
        }

        $faqs = $query->orderBy('id')->get();
        $categoryCounts = Faq::query()
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        return view('livewire.admin.manage-faq', [
            'faqs' => $faqs,
            'availableCategories' => $this->availableCategories,
            'categoryCounts' => $categoryCounts,
            'totalFaqs' => array_sum($categoryCounts),
        ]);
    }
}
