<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
        'password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid (contoh: contoh@gmail.com).',
        'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain atau Masuk.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.min' => 'Nomor telepon minimal 8 digit.',
        'phone.regex' => 'Format nomor telepon hanya boleh berisi angka atau tanda hubung.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'phone', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    public function register()
    {
        $this->validate();

        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($cleanPhone, '62')) {
            $formattedPhone = '+' . $cleanPhone;
        } elseif (str_starts_with($cleanPhone, '0')) {
            $formattedPhone = '+62' . substr($cleanPhone, 1);
        } else {
            $formattedPhone = '+62' . $cleanPhone;
        }

        $userData = [
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ];

        if (Schema::hasColumn('users', 'phone')) {
            $userData['phone'] = $formattedPhone;
        }

        $user = User::create($userData);

        Auth::login($user);
        session()->regenerate();

        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang di PraxisFit.');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.auth');
    }
}
