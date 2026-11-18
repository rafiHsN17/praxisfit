<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Daftar Akun - PraxisFit')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
        'password' => 'required|string|min:6|confirmed',
    ];

    protected array $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid (contoh: nama@email.com).',
        'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain atau Masuk.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.min' => 'Nomor telepon minimal 8 digit.',
        'phone.regex' => 'Format nomor telepon hanya boleh berisi angka atau tanda hubung.',
        'password.required' => 'Kata sandi wajib diisi.',
        'password.min' => 'Kata sandi minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
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

        $email = strtolower(trim($this->email));

        $userData = [
            'name' => trim($this->name),
            'email' => $email,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ];

        if (Schema::hasColumn('users', 'phone')) {
            $userData['phone'] = $formattedPhone;
        }

        $user = User::create($userData);

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan masuk sesuai email dan kata sandi yang baru Anda daftarkan.');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.auth');
    }
}
