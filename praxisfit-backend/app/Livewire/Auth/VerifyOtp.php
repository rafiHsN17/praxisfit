<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyOtp extends Component
{
    public $email;
    public $otp = ['', '', '', '', '', ''];

    public function mount()
    {
        $this->email = request()->query('email');
        if (!$this->email) {
            return redirect()->route('register');
        }
    }

    public function verify()
    {
        $code = implode('', $this->otp);
        
        $this->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|numeric|digits:1',
        ], [
            'otp.*.required' => 'Mohon lengkapi 6 digit kode OTP.',
            'otp.*.numeric' => 'Kode harus berupa angka.',
        ]);

        $user = User::where('email', $this->email)
                    ->where('otp_code', $code)
                    ->first();

        if (!$user) {
            $this->addError('otp', 'Kode OTP tidak valid atau salah.');
            return;
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            $this->addError('otp', 'Kode OTP sudah kadaluarsa. Silakan daftar ulang atau minta kode baru.');
            return;
        }

        // Sukses
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(), // Opsional jika butuh verifikasi built-in
        ]);

        Auth::login($user);

        return redirect()->to('/dashboard')->with('success', 'Akun berhasil diverifikasi. Selamat datang!');
    }

    public function render()
    {
        return view('livewire.auth.verify-otp')->layout('components.layouts.app');
    }
}
