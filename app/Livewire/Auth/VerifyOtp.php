<?php

namespace App\Livewire\Auth;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Verifikasi OTP - PraxisFit')]
class VerifyOtp extends Component
{
    public string $email = '';
    public array $otp = ['', '', '', '', '', ''];
    public string $resendNotice = '';

    public function mount()
    {
        $this->email = (string) request()->query('email', '');
        if ($this->email === '') {
            return redirect()->route('register');
        }
    }

    public function resendOtp(): void
    {
        $this->resetErrorBag();
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('otp', 'Akun dengan email ini tidak ditemukan.');
            return;
        }

        if ($user->email_verified_at !== null && $user->otp_code === null) {
            $this->resendNotice = 'Email ini sudah terverifikasi. Silakan langsung masuk.';
            return;
        }

        $newOtp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp_code' => $newOtp,
            'otp_expires_at' => now('Asia/Jakarta')->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($newOtp));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim ulang OTP ke ' . $user->email . ': ' . $e->getMessage());
        }

        $this->otp = ['', '', '', '', '', ''];
        $this->resendNotice = 'Kode OTP baru (6 digit) telah dikirim ulang ke ' . $this->email . '.';
    }

    public function verify()
    {
        $this->resendNotice = '';

        $this->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|numeric|digits:1',
        ], [
            'otp.*.required' => 'Mohon lengkapi seluruh 6 digit kode OTP.',
            'otp.*.numeric' => 'Kode OTP hanya boleh berisi angka.',
            'otp.*.digits' => 'Setiap kotak hanya berisi 1 digit angka.',
        ]);

        $code = implode('', $this->otp);

        $user = User::where('email', $this->email)
            ->where('otp_code', $code)
            ->first();

        if (!$user) {
            $this->addError('otp', 'Kode OTP tidak valid atau tidak sesuai.');
            return;
        }

        if ($user->otp_expires_at && now('Asia/Jakarta')->greaterThan($user->otp_expires_at)) {
            $this->addError('otp', 'Kode OTP sudah kedaluwarsa. Klik "Kirim Ulang OTP" untuk mendapatkan kode baru.');
            return;
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now('Asia/Jakarta'),
        ]);

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Akun berhasil diverifikasi. Selamat datang di PraxisFit!');
    }

    public function render()
    {
        return view('livewire.auth.verify-otp')->layout('components.layouts.auth');
    }
}
