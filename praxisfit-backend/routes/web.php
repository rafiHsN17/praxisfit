<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\ProteinCalculator;
use App\Livewire\ExerciseCatalog;
use App\Livewire\MyWorkoutPlanner;
use App\Livewire\FaqPage;

// Rute Utama Aplikasi PraxisFit (Calisthenics & Home Workout)
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
    
    // Socialite
    Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\SocialiteController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [\App\Http\Controllers\SocialiteController::class, 'callback'])->name('social.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    })->name('logout');
    
    // Admin Routes
    Route::get('/admin/exercise/create', \App\Livewire\Admin\CreateExercise::class)->name('exercise.create');
    Route::get('/admin/faqs', \App\Livewire\Admin\ManageFaq::class)->name('admin.faqs');
});