<?php

use App\Livewire\Dashboard;
use App\Livewire\ExerciseCatalog;
use App\Livewire\FaqPage;
use App\Livewire\MyWorkoutPlanner;
use App\Livewire\ProteinCalculator;
use Illuminate\Support\Facades\Route;

// Rute Utama Aplikasi PraxisFit
Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/kalkulator', ProteinCalculator::class)->name('calculator');
Route::get('/katalog', ExerciseCatalog::class)->name('catalog');
Route::get('/faq', FaqPage::class)->name('faq');
Route::get('/rutinku', MyWorkoutPlanner::class)->name('workout.planner');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
    Route::get('/verify-otp', \App\Livewire\Auth\VerifyOtp::class)->name('verify-otp');
    Route::get('/lupa-kata-sandi', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-kata-sandi/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');

    // Socialite
    Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\SocialiteController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [\App\Http\Controllers\SocialiteController::class, 'callback'])->name('social.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', \App\Livewire\UserProfile::class)->name('profile.edit');

    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        \Illuminate\Support\Facades\Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    })->name('logout');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', \App\Livewire\Admin\Auth\Login::class)->name('admin.login');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::get('/exercises', \App\Livewire\Admin\ManageExercises::class)->name('admin.exercises');
        Route::get('/goals', \App\Livewire\Admin\ManageFitnessGoals::class)->name('admin.goals');
        Route::get('/faqs', \App\Livewire\Admin\ManageFaq::class)->name('admin.faqs');
        Route::get('/protein-sources', \App\Livewire\Admin\ManageProteinSources::class)->name('admin.protein-sources');

        Route::post('/logout', function (\Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Auth::guard('admin')->logout();
            \Illuminate\Support\Facades\Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Berhasil keluar dari panel admin.');
        })->name('admin.logout');
    });
});
