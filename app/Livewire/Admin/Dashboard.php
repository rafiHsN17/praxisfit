<?php

namespace App\Livewire\Admin;

use App\Models\Exercise;
use App\Models\Faq;
use App\Models\FitnessGoal;
use App\Models\ProteinSource;
use App\Models\SupportMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Dasbor Admin - PraxisFit')]
class Dashboard extends Component
{
    public function markSupportRead(int $id): void
    {
        $msg = SupportMessage::find($id);
        if ($msg) {
            $msg->update(['status' => $msg->status === 'resolved' ? 'new' : 'resolved']);
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'exerciseCount' => Exercise::count(),
            'faqCount' => Faq::count(),
            'proteinSourceCount' => ProteinSource::count(),
            'goalCount' => FitnessGoal::count(),
            'newSupportCount' => SupportMessage::where('status', 'new')->count(),
            'recentSupportMessages' => SupportMessage::latest()->take(6)->get(),
        ]);
    }
}
