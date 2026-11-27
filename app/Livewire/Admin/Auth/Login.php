<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Masuk Admin - PraxisFit')]
class Login extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public function login()
    {
        if ($this->name === '' && $this->email !== '') {
            $this->name = $this->email;
        }

        $this->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = trim($this->name);

        // Kredensial utama admin-praxisfit-1
        if ($loginInput === 'admin-praxisfit-1' && $this->password === 'tinju-kangguru-123') {
            $admin = Admin::updateOrCreate(
                ['email' => 'admin@praxisfit.com'],
                [
                    'name' => 'admin-praxisfit-1',
                    'password' => Hash::make('tinju-kangguru-123'),
                ]
            );

            Auth::guard('web')->logout();
            Auth::guard('admin')->login($admin);
            session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        // Cek tabel admins berdasarkan nama atau email
        $admin = Admin::where('name', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if ($admin && Hash::check($this->password, $admin->password)) {
            Auth::guard('web')->logout();
            Auth::guard('admin')->login($admin);
            session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        $this->addError('name', 'Nama admin atau kata sandi tidak valid.');
        $this->addError('email', 'Nama admin atau kata sandi tidak valid.');
    }

    public function render()
    {
        return view('livewire.admin.auth.login')->layout('components.layouts.guest');
    }
}
