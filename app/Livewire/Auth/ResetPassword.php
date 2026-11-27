<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Atur Ulang Kata Sandi - PraxisFit')]
class ResetPassword extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = (string) request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $email = strtolower(trim($this->email));
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        // Terima token baik dari Password::broker maupun token custom yang ter-hash
        $user = User::where('email', $email)->first();
        if (! $user || ! $record || ! Hash::check($this->token, $record->token)) {
            $status = Password::reset(
                [
                    'email' => $email,
                    'password' => $this->password,
                    'password_confirmation' => $this->password_confirmation,
                    'token' => $this->token,
                ],
                function (User $u, string $newPassword) {
                    $u->forceFill(['password' => Hash::make($newPassword)])->save();
                }
            );

            if ($status !== Password::PASSWORD_RESET) {
                $this->addError('email', 'Token atur ulang kata sandi tidak valid atau sudah kedaluwarsa.');

                return;
            }

            return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui. Silakan masuk dengan kata sandi baru Anda.');
        }

        $user->forceFill(['password' => Hash::make($this->password)])->save();
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui. Silakan masuk dengan kata sandi baru Anda.');
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('components.layouts.auth');
    }
}
