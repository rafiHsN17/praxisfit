<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\ManageExercises;
use App\Livewire\Admin\ManageFaq;
use App\Livewire\Admin\ManageFitnessGoals;
use App\Livewire\Admin\ManageProteinSources;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\ExerciseCatalog;
use App\Livewire\FaqPage;
use App\Livewire\MyWorkoutPlanner;
use App\Livewire\ProteinCalculator;
use App\Mail\OtpMail;
use App\Models\Admin;
use App\Models\Exercise;
use App\Models\Faq;
use App\Models\FitnessGoal;
use App\Models\ProteinLog;
use App\Models\ProteinSource;
use App\Models\SupportMessage;
use App\Models\User;
use App\Models\WorkoutRoutine;
use App\Models\WorkoutSession;
use App\Models\WorkoutSessionItem;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class PraxisFitRedesignTest extends TestCase
{
    use RefreshDatabase;

    private function seedCoreCatalog(): array
    {
        $source = ProteinSource::create([
            'name' => 'Dada Ayam Fillet / Boneless',
            'protein_per_100g' => 23.0,
            'calories_per_100g' => 165.0,
            'fat_per_100g' => 3.6,
            'carbs_per_100g' => 0.0,
        ]);

        $exPush = Exercise::create([
            'name' => 'Push Up',
            'target_muscle' => 'Dada',
            'equipment' => 'Bodyweight',
            'category' => 'Kekuatan & Hipertrofi',
            'difficulty' => 'Pemula',
            'alternative_equipment' => 'Gunakan tumpuan dinding atau lutut sebagai alternatif lebih ringan.',
            'instructions' => 'Posisikan tubuh plank lalu turunkan dada dan dorong kembali dengan otot core terkunci.',
        ]);

        $exCurl = Exercise::create([
            'name' => 'Dumbbell Bicep Curl',
            'target_muscle' => 'Lengan',
            'equipment' => 'Dumbbell',
            'category' => 'Kekuatan & Hipertrofi',
            'difficulty' => 'Menengah',
            'instructions' => 'Angkat dumbbell secara terkontrol ke arah bahu.',
        ]);

        $goal = FitnessGoal::create([
            'name' => 'Kekuatan & Massa Otot',
            'description' => 'Program latihan terstruktur untuk meningkatkan massa otot.',
            'split_type' => 'Upper/Lower Split',
        ]);

        Faq::create([
            'kategori' => 'nutrisi',
            'pertanyaan' => 'Berapa kebutuhan protein harian?',
            'jawaban_singkat' => 'Sekitar 1.6 hingga 1.8 gram per kg berat badan.',
            'contoh' => 'Untuk berat 65 kg sekitar 104g protein.',
            'sumber_nama' => 'Kemenkes RI AKG',
            'sumber_url' => 'https://kesmas.kemkes.go.id',
        ]);

        return compact('source', 'exPush', 'exCurl', 'goal');
    }

    public function test_all_public_and_guest_auth_routes_render_cleanly(): void
    {
        $this->seedCoreCatalog();

        $this->get('/')->assertOk();
        $this->get('/kalkulator')->assertOk();
        $this->get('/katalog')->assertOk();
        $this->get('/faq')->assertOk();
        $this->get('/rutinku')->assertOk();
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
        $this->get('/lupa-kata-sandi')->assertOk();
        $this->get('/admin/login')->assertOk();
    }

    public function test_guest_sees_zero_private_stats_and_user_sees_own_data_only(): void
    {
        $this->seedCoreCatalog();

        $userA = User::factory()->create(['protein_target' => 140]);
        $userB = User::factory()->create(['protein_target' => 160]);

        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $logA = ProteinLog::create([
            'user_id' => $userA->id,
            'sumber_makanan' => 'Dada Ayam Fillet / Boneless',
            'berat_gram' => 200,
            'jumlah_protein' => 46,
            'kalori' => 330,
            'lemak' => 7.2,
            'karbohidrat' => 0,
            'tanggal' => $today,
            'waktu_makan' => 'Makan Siang',
        ]);

        $sessionA = WorkoutSession::create([
            'user_id' => $userA->id,
            'name' => 'Push Day User A',
            'category' => 'Calisthenics',
            'scheduled_date' => $today,
            'status' => WorkoutSession::STATUS_UPCOMING,
        ]);

        // Guest tidak boleh menyimpan log atau melihat log userA
        Livewire::test(ProteinCalculator::class)
            ->call('saveLog')
            ->assertViewHas('isGuest', fn () => true);

        $this->assertEquals(1, ProteinLog::count());

        // User B tidak boleh mengedit/menghapus log atau sesi User A
        $this->actingAs($userB);

        Livewire::test(ProteinCalculator::class)
            ->call('deleteLog', $logA->id);
        $this->assertDatabaseHas('protein_logs', ['id' => $logA->id]);

        Livewire::test(MyWorkoutPlanner::class)
            ->call('deleteSession', $sessionA->id);
        $this->assertDatabaseHas('workout_sessions', ['id' => $sessionA->id]);
    }

    public function test_nutrition_calculator_computes_mifflin_st_jeor_and_logs_4_macros(): void
    {
        $this->seedCoreCatalog();
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = Livewire::test(ProteinCalculator::class)
            ->set('user_gender', 'M')
            ->set('user_weight', 70)
            ->set('user_height', 175)
            ->set('user_age', 25)
            ->set('activity_level', 'moderate')
            ->set('fitness_goal', 'maintenance')
            ->call('confirmPhysicalData');

        $user->refresh();
        $this->assertNotNull($user->protein_target);
        $this->assertNotNull($user->calorie_target);
        $this->assertNotNull($user->fat_target);
        $this->assertNotNull($user->carb_target);
        $this->assertGreaterThan(100, $user->protein_target);
        $this->assertGreaterThan(1800, $user->calorie_target);

        // Log 200g Dada Ayam (23g P, 165 cal, 3.6g F per 100g => 46g P, 330 cal, 7.2g F)
        $component
            ->set('sumber_makanan', 'Dada Ayam Fillet / Boneless')
            ->set('berat', 200)
            ->set('waktu_makan', 'Makan Malam')
            ->call('saveLog');

        $this->assertDatabaseHas('protein_logs', [
            'user_id' => $user->id,
            'sumber_makanan' => 'Dada Ayam Fillet / Boneless',
            'berat_gram' => 200,
            'jumlah_protein' => 46.0,
            'kalori' => 330.0,
            'lemak' => 7.2,
            'waktu_makan' => 'Makan Malam',
        ]);

        // Ganti rentang & jenis grafik tidak error
        $component
            ->set('chartRange', 30)
            ->set('chartNutrient', 'kalori')
            ->set('chartType', 'bar')
            ->set('historyRange', '7')
            ->assertOk();
    }

    public function test_exercise_catalog_multi_filter_combination_and_detail_modal(): void
    {
        ['exPush' => $exPush, 'exCurl' => $exCurl] = $this->seedCoreCatalog();

        Livewire::test(ExerciseCatalog::class)
            ->set('filterEquipment', 'Dumbbell')
            ->set('filterDifficulty', 'Menengah')
            ->assertSee('Dumbbell Bicep Curl')
            ->assertDontSee('Push Up')
            ->call('resetFilters')
            ->assertSee('Push Up')
            ->assertSee('Dumbbell Bicep Curl')
            ->call('openExerciseDetail', $exPush->id)
            ->assertSet('selectedExercise.id', $exPush->id)
            ->assertSee('Alternatif')
            ->call('closeExerciseDetail')
            ->assertSet('selectedExercise', null);
    }

    public function test_workout_planner_date_mismatch_alert_and_history_persistence(): void
    {
        ['exPush' => $exPush] = $this->seedCoreCatalog();
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $yesterday = Carbon::now('Asia/Jakarta')->subDay()->toDateString();
        $tomorrow = Carbon::now('Asia/Jakarta')->addDay()->toDateString();

        // 1. Buat sesi untuk hari kemarin (off-schedule jika dijalankan hari ini)
        $pastSession = WorkoutSession::create([
            'user_id' => $user->id,
            'name' => 'Latihan Kemarin',
            'category' => 'Calisthenics',
            'scheduled_date' => $yesterday,
            'status' => WorkoutSession::STATUS_UPCOMING,
        ]);

        $item = WorkoutSessionItem::create([
            'workout_session_id' => $pastSession->id,
            'exercise_id' => $exPush->id,
            'exercise_name' => $exPush->name,
            'target_muscle' => 'Dada',
            'target_sets' => 3,
            'target_reps' => '10-12',
            'sort_order' => 1,
        ]);

        // Klik mulai pada tanggal berbeda -> harus memunculkan konfirmasi, status BELUM berubah
        $planner = Livewire::test(MyWorkoutPlanner::class)
            ->call('attemptStartSession', $pastSession->id)
            ->assertSet('mismatchSessionId', $pastSession->id)
            ->assertSet('mismatchIsFuture', false);

        $pastSession->refresh();
        $this->assertEquals(WorkoutSession::STATUS_UPCOMING, $pastSession->status);
        $this->assertNull($pastSession->actual_date);

        // Klik "Kembali ke Jadwal" -> status tetap unchanged
        $planner->call('cancelMismatchStart')
            ->assertSet('mismatchSessionId', null);
        $pastSession->refresh();
        $this->assertEquals(WorkoutSession::STATUS_UPCOMING, $pastSession->status);

        // Klik mulai lalu "Tetap Mulai Latihan" -> scheduled_date tetap kemarin, actual_date = hari ini, is_off_schedule = true
        $planner->call('attemptStartSession', $pastSession->id)
            ->call('confirmMismatchStart')
            ->assertSet('activeSessionId', $pastSession->id);

        $pastSession->refresh();
        $this->assertEquals($yesterday, $pastSession->scheduled_date->toDateString());
        $this->assertEquals($today, $pastSession->actual_date->toDateString());
        $this->assertTrue($pastSession->is_off_schedule);
        $this->assertEquals(WorkoutSession::STATUS_IN_PROGRESS, $pastSession->status);

        // Checklist item & selesaikan sesi
        $planner->call('toggleItemCompleted', $item->id)
            ->call('finishActiveSession');

        $pastSession->refresh();
        $this->assertEquals(WorkoutSession::STATUS_COMPLETED, $pastSession->status);
        $this->assertEquals(100, $pastSession->progress_percent);
        $this->assertNotNull($pastSession->completed_at);

        // Sesi tanggal mendatang harus menampilkan flag future notice
        $futureSession = WorkoutSession::create([
            'user_id' => $user->id,
            'name' => 'Latihan Besok',
            'category' => 'Kardio',
            'scheduled_date' => $tomorrow,
            'status' => WorkoutSession::STATUS_UPCOMING,
        ]);

        $planner->call('attemptStartSession', $futureSession->id)
            ->assertSet('mismatchSessionId', $futureSession->id)
            ->assertSet('mismatchIsFuture', true);
    }

    public function test_faq_filtering_and_support_message_submission(): void
    {
        $this->seedCoreCatalog();

        Livewire::test(FaqPage::class)
            ->set('search', 'protein')
            ->assertSee('Berapa kebutuhan protein harian?')
            ->call('openContactForm')
            ->set('contactName', 'Rafi Athlete')
            ->set('contactEmail', 'rafi@example.com')
            ->set('contactSubject', 'Pertanyaan Jadwal')
            ->set('contactMessage', 'Bagaimana cara menjadwalkan ulang latihan yang terlewat?')
            ->call('submitSupportMessage')
            ->assertSet('contactSubmitted', true);

        $this->assertDatabaseHas('support_messages', [
            'email' => 'rafi@example.com',
            'subject' => 'Pertanyaan Jadwal',
            'status' => 'new',
        ]);
    }

    public function test_register_without_otp_verification_then_logs_in_and_forgot_password_works(): void
    {
        Mail::fake();

        Livewire::test(Register::class)
            ->set('name', 'Budi Santoso')
            ->set('email', 'budi@bebas.com')
            ->set('phone', '081234567890')
            ->set('password', 'rahasia123')
            ->set('password_confirmation', 'rahasia123')
            ->call('register')
            ->assertRedirect(route('login'));

        $user = User::where('email', 'budi@bebas.com')->firstOrFail();
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->otp_code);
        $this->assertEquals('+6281234567890', $user->phone);
        $this->assertGuest();

        // Login menggunakan email yang didaftarkan
        Livewire::test(Login::class)
            ->set('email', 'budi@bebas.com')
            ->set('password', 'rahasia123')
            ->call('login')
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        // Logout lalu test Login menggunakan Nama Lengkap yang didaftarkan
        auth()->logout();
        Livewire::test(Login::class)
            ->set('email', 'Budi Santoso')
            ->set('password', 'rahasia123')
            ->call('login')
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        // Logout & test ForgotPassword
        auth()->logout();
        Livewire::test(ForgotPassword::class)
            ->set('email', 'budi@bebas.com')
            ->call('sendResetLink')
            ->assertSet('statusMessage', fn ($val) => !empty($val));

        $this->assertDatabaseHas('password_reset_tokens', ['email' => 'budi@bebas.com']);
    }

    public function test_admin_panel_components_and_user_profile_render_cleanly(): void
    {
        $this->seedCoreCatalog();

        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);
        $this->get('/profil')->assertOk();
        auth()->logout();

        // Test login admin menggunakan nama (admin-praxisfit-1) dan kata sandi (tinju-kangguru-123) tanpa email
        Livewire::test(Login::class)
            ->set('email', 'admin-praxisfit-1')
            ->set('password', 'tinju-kangguru-123')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));

        $this->assertTrue(auth()->guard('admin')->check());
        auth()->guard('admin')->logout();
        auth()->guard('web')->logout();

        // Test login dari portal khusus /admin/login menggunakan nama dan kata sandi
        Livewire::test(\App\Livewire\Admin\Auth\Login::class)
            ->set('name', 'admin-praxisfit-1')
            ->set('password', 'tinju-kangguru-123')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));

        $this->assertTrue(auth()->guard('admin')->check());

        $this->get('/admin/dashboard')->assertOk();
        $this->get('/admin/exercises')->assertOk();
        $this->get('/admin/goals')->assertOk();
        $this->get('/admin/protein-sources')->assertOk();
        $this->get('/admin/faqs')->assertOk();

        Livewire::test(AdminDashboard::class)->assertOk();
        Livewire::test(ManageExercises::class)->assertOk();
        Livewire::test(ManageFitnessGoals::class)->assertOk();
        Livewire::test(ManageFaq::class)->assertOk();

        // Admin kelola 4 makronutrien sumber makanan
        Livewire::test(ManageProteinSources::class)
            ->call('openModal')
            ->set('name', 'Ikan Bandeng')
            ->set('protein_per_100g', 20)
            ->set('calories_per_100g', 148)
            ->set('fat_per_100g', 4.8)
            ->set('carbs_per_100g', 0)
            ->call('save');

        $this->assertDatabaseHas('protein_sources', [
            'name' => 'Ikan Bandeng',
            'protein_per_100g' => 20,
            'calories_per_100g' => 148,
            'fat_per_100g' => 4.8,
        ]);
    }
}

