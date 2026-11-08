<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|string',
        'password' => 'required|string',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi.',
        'password.required' => 'Password wajib diisi.',
    ];

    public function login()
    {
        $this->validate();

        $loginInput = trim($this->email);
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$fieldType => $loginInput, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            if (Auth::user()->name === 'admin-praxisfit-1') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Admin Panel!');
            }

            return redirect()->intended('/')->with('success', 'Selamat datang kembali di PraxisFit!');
        }

        $this->addError('email', 'Email atau password tidak sesuai dengan data akun kami.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.auth');
    }
}
