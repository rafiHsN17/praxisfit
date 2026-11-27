<?php

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SocialiteController;
use App\Livewire\Admin\ManageExercises;
use App\Livewire\Admin\ManageFaq;
use App\Livewire\Admin\ManageFitnessGoals;
use App\Livewire\Admin\ManageProteinSources;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Dashboard;
use App\Livewire\ExerciseCatalog;
use App\Livewire\FaqPage;
use App\Livewire\MyWorkoutPlanner;
use App\Livewire\ProgramGenerator;
use App\Livewire\ProteinCalculator;
use App\Livewire\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute Utama Aplikasi PraxisFit (khusus pengguna/pengunjung, admin diarahkan ke Dasbor Admin)
Route::middleware('not.admin')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/kalkulator', ProteinCalculator::class)->name('calculator');
    Route::get('/katalog', ExerciseCatalog::class)->name('catalog');
    Route::get('/faq', FaqPage::class)->name('faq');
    Route::get('/rutinku', MyWorkoutPlanner::class)->name('workout.planner');
    Route::get('/program-generator', ProgramGenerator::class)->name('program.generator');
});

// Auth Routes
Route::middleware(['guest', 'not.admin'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/lupa-kata-sandi', ForgotPassword::class)->name('password.request');
    Route::get('/reset-kata-sandi/{token}', ResetPassword::class)->name('password.reset');

    // Socialite
    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('social.callback');
});

Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/profil', UserProfile::class)->name('profile.edit');

    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    })->name('logout');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', App\Livewire\Admin\Auth\Login::class)->name('admin.login');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::get('/exercises', ManageExercises::class)->name('admin.exercises');
        Route::get('/goals', ManageFitnessGoals::class)->name('admin.goals');
        Route::get('/faqs', ManageFaq::class)->name('admin.faqs');
        Route::get('/protein-sources', ManageProteinSources::class)->name('admin.protein-sources');

        Route::post('/logout', function (Request $request) {
            Auth::guard('admin')->logout();
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Berhasil keluar dari panel admin.');
        })->name('admin.logout');
    });
});

// Passwordless Customer Auth Routes (Email OTP + Google OAuth)
Route::prefix('customer')->name('customer.')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/send-otp', [CustomerAuthController::class, 'sendOtp'])->name('otp.send');
        Route::get('/verify-otp', [CustomerAuthController::class, 'showOtpForm'])->name('otp.form');
        Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp'])->name('otp.verify');

        Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback'])->name('google.callback');
    });

    Route::post('/logout', [CustomerAuthController::class, 'logout'])
        ->middleware('auth:customer')
        ->name('logout');
});
