<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if ($user) {
                // Link provider if not linked yet
                if ($provider === 'google' && !$user->google_id) {
                    $user->update(['google_id' => $socialUser->getId()]);
                } elseif ($provider === 'facebook' && !$user->facebook_id) {
                    $user->update(['facebook_id' => $socialUser->getId()]);
                }
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => null, // No password for social login
                    $provider . '_id' => $socialUser->getId(),
                ]);
            }

            Auth::login($user);
            
            return redirect('/dashboard')->with('success', 'Berhasil masuk melalui ' . ucfirst($provider));
        } catch (\Exception $e) {
            return redirect('/login')->with('message', 'Gagal masuk melalui ' . ucfirst($provider) . '. Silakan coba lagi.');
        }
    }
}
