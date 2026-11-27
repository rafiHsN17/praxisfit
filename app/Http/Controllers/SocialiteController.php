<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                if ($provider === 'google' && ! $user->google_id) {
                    $user->update(['google_id' => $socialUser->getId()]);
                } elseif ($provider === 'facebook' && ! $user->facebook_id) {
                    $user->update(['facebook_id' => $socialUser->getId()]);
                }
            } else {
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => null,
                    'email_verified_at' => now('Asia/Jakarta'),
                    $provider.'_id' => $socialUser->getId(),
                ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Berhasil masuk melalui '.ucfirst($provider));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk melalui '.ucfirst($provider).'. Silakan coba lagi.');
        }
    }
}
