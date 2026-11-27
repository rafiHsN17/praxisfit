<?php

namespace App\Livewire\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Masuk - PraxisFit')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|string',
        'password' => 'required|string',
    ];

    protected array $messages = [
        'email.required' => 'Email atau nama akun wajib diisi.',
        'password.required' => 'Kata sandi wajib diisi.',
    ];

    public function login()
    {
        $this->validate();

        $loginInput = trim($this->email);

        // Login langsung untuk Admin utama menggunakan Nama & Kata Sandi tanpa Gmail
        if ($loginInput === 'admin-praxisfit-1' && $this->password === 'tinju-kangguru-123') {
            $admin = Admin::updateOrCreate(
                ['email' => 'admin@praxisfit.com'],
                [
                    'name' => 'admin-praxisfit-1',
                    'password' => Hash::make('tinju-kangguru-123'),
                ]
            );

            Auth::guard('web')->logout();
            Auth::guard('admin')->login($admin, $this->remember);
            session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Panel Admin!');
        }

        // Cek juga jika yang masuk adalah akun di tabel admins (berdasarkan nama atau email)
        $adminAccount = Admin::where('name', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if ($adminAccount && Hash::check($this->password, $adminAccount->password)) {
            Auth::guard('web')->logout();
            Auth::guard('admin')->login($adminAccount, $this->remember);
            session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Panel Admin!');
        }

        // Cari user berdasarkan email (lowercase) atau nama lengkap sesuai data pendaftaran
        $user = User::where('email', strtolower($loginInput))
            ->orWhere('name', $loginInput)
            ->first();

        if ($user && Hash::check($this->password, $user->password)) {
            // Pastikan akun lama yang sempat tertahan OTP langsung dianggap aktif
            if (is_null($user->email_verified_at) || $user->otp_code !== null) {
                $user->update([
                    'email_verified_at' => $user->email_verified_at ?? now(),
                    'otp_code' => null,
                    'otp_expires_at' => null,
                ]);
            }

            Auth::login($user, $this->remember);
            session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali di PraxisFit!');
        }

        $this->addError('email', 'Email/nama akun atau kata sandi tidak sesuai dengan data pendaftaran.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.auth');
    }
}
