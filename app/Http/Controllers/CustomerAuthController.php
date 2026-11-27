<?php

namespace App\Http\Controllers;

use App\Mail\CustomerOtpMail;
use App\Models\Customer;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = strtolower(trim($validated['email']));

        // Jika email belum ada, otomatis daftarkan Customer tanpa password
        $defaultName = Str::title(str_replace(['.', '_', '-'], ' ', Str::before($email, '@')));
        Customer::firstOrCreate(
            ['email' => $email],
            ['nama' => $defaultName ?: 'Pelanggan']
        );

        // Hapus OTP sebelumnya & generate 6 digit OTP baru (berlaku 5 menit)
        OtpCode::where('email', $email)->delete();

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::create([
            'email' => $email,
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        try {
            Mail::to($email)->send(new CustomerOtpMail($otp));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email OTP pelanggan ke '.$email.': '.$e->getMessage());
        }

        return redirect()
            ->route('customer.otp.form', ['email' => $email])
            ->with('status', 'Kode OTP 6 digit telah dikirim ke email Anda (berlaku 5 menit).');
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        if (! $email) {
            return redirect()->route('customer.login');
        }

        return view('customer.auth.verify-otp', ['email' => $email]);
    }

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp_code' => ['required', 'digits:6'],
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi.',
            'otp_code.digits' => 'Kode OTP harus terdiri dari 6 digit angka.',
        ]);

        $email = strtolower(trim($validated['email']));

        $record = OtpCode::where('email', $email)
            ->where('otp_code', $validated['otp_code'])
            ->latest()
            ->first();

        if (! $record) {
            return back()
                ->withInput()
                ->withErrors(['otp_code' => 'Kode OTP tidak sesuai.']);
        }

        if ($record->isExpired()) {
            $record->delete();

            return back()
                ->withInput()
                ->withErrors(['otp_code' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode baru.']);
        }

        $customer = Customer::where('email', $email)->firstOrFail();

        OtpCode::where('email', $email)->delete();
        Auth::guard('customer')->login($customer, true);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Berhasil masuk sebagai '.$customer->nama);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(route('customer.google.callback'))
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('customer.google.callback'))
                ->user();
        } catch (\Throwable $e) {
            return redirect()->route('customer.login')
                ->withErrors(['email' => 'Gagal terhubung dengan Google. Silakan coba lagi.']);
        }

        $email = strtolower(trim((string) $googleUser->getEmail()));
        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            $customer->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            $customer = Customer::create([
                'nama' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Pelanggan'),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        }

        Auth::guard('customer')->login($customer, true);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Selamat datang, '.$customer->nama);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
