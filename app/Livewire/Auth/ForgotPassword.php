<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Lupa Kata Sandi - PraxisFit')]
class ForgotPassword extends Component
{
    public string $email = '';

    public ?string $statusMessage = null;

    public function sendResetLink(): void
    {
        $this->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Masukkan alamat email akun Anda.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = strtolower(trim($this->email));
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now('Asia/Jakarta'),
                ]
            );

            try {
                Password::broker()->sendResetLink(['email' => $email]);
            } catch (\Throwable $e) {
                Log::info('Tautan reset kata sandi untuk '.$email.' tercatat di log: '.route('password.reset', ['token' => $token, 'email' => $email]));
            }
        }

        // Pesan netral aman agar tidak membocorkan enumerasi akun
        $this->statusMessage = 'Jika email terdaftar di sistem kami, instruksi pengaturan ulang kata sandi telah dikirimkan ke alamat email tersebut.';
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.auth');
    }
}
