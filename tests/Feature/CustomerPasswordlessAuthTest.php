<?php

namespace Tests\Feature;

use App\Mail\CustomerOtpMail;
use App\Models\Customer;
use App\Models\OtpCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class CustomerPasswordlessAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_login_page_renders_with_expected_elements(): void
    {
        $this->get('/customer/login')
            ->assertOk()
            ->assertSee('Alamat Email')
            ->assertSee('Lanjutkan dengan Google')
            ->assertSee('Mengirim OTP...');
    }

    public function test_email_otp_auto_registers_customer_and_verifies_within_5_minutes(): void
    {
        Mail::fake();

        $this->post('/customer/send-otp', [
            'email' => 'pelanggan.baru@example.com',
        ])->assertRedirect('/customer/verify-otp?email=pelanggan.baru%40example.com');

        Mail::assertSent(CustomerOtpMail::class);

        $customer = Customer::where('email', 'pelanggan.baru@example.com')->first();
        $this->assertNotNull($customer);
        $this->assertEquals('Pelanggan Baru', $customer->nama);

        $otp = OtpCode::where('email', 'pelanggan.baru@example.com')->first();
        $this->assertNotNull($otp);
        $this->assertEquals(6, strlen($otp->otp_code));
        $this->assertFalse($otp->isExpired());

        // Salah kode OTP harus ditolak
        $this->post('/customer/verify-otp', [
            'email' => 'pelanggan.baru@example.com',
            'otp_code' => $otp->otp_code === '000000' ? '111111' : '000000',
        ])->assertSessionHasErrors('otp_code');

        $this->assertFalse(Auth::guard('customer')->check());

        // Kode OTP benar -> login via guard customer
        $this->post('/customer/verify-otp', [
            'email' => 'pelanggan.baru@example.com',
            'otp_code' => $otp->otp_code,
        ])->assertRedirect('/');

        $this->assertTrue(Auth::guard('customer')->check());
        $this->assertEquals($customer->id, Auth::guard('customer')->id());
        $this->assertDatabaseMissing('otp_codes', ['email' => 'pelanggan.baru@example.com']);
    }

    public function test_expired_otp_is_rejected(): void
    {
        Customer::create([
            'nama' => 'Tamu Lama',
            'email' => 'lama@example.com',
        ]);

        OtpCode::create([
            'email' => 'lama@example.com',
            'otp_code' => '654321',
            'expires_at' => now()->subMinute(),
        ]);

        $this->post('/customer/verify-otp', [
            'email' => 'lama@example.com',
            'otp_code' => '654321',
        ])->assertSessionHasErrors('otp_code');

        $this->assertFalse(Auth::guard('customer')->check());
    }

    public function test_google_oauth_callback_creates_and_updates_customer_and_logs_in(): void
    {
        $socialUser = new SocialiteUser;
        $socialUser->map([
            'id' => 'google-uid-999',
            'name' => 'Rafi Google',
            'email' => 'rafi.google@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
        ]);

        $providerMock = Mockery::mock();
        $providerMock->shouldReceive('redirectUrl')->andReturnSelf();
        $providerMock->shouldReceive('user')->andReturn($socialUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($providerMock);

        $this->get('/customer/auth/google/callback')->assertRedirect('/');

        $this->assertTrue(Auth::guard('customer')->check());
        $this->assertDatabaseHas('customers', [
            'email' => 'rafi.google@example.com',
            'nama' => 'Rafi Google',
            'google_id' => 'google-uid-999',
            'avatar' => 'https://example.com/avatar.jpg',
        ]);
    }
}
