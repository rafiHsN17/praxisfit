<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|string',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        $fieldType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$fieldType => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            if (Auth::user()->name === 'admin-praxisfit-1') {
                return redirect()->route('exercise.create')->with('success', 'Selamat datang di Admin Panel!');
            }
            
            return redirect()->intended('/')->with('success', 'Selamat datang kembali di PraxisFit!');
        }

        $this->addError('email', 'Email/Username atau kata sandi tidak cocok dengan data kami.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}
