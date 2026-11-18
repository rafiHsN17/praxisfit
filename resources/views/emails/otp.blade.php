<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi PraxisFit</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background-color: #100809; color: #F5F5F5; padding: 40px 20px; margin: 0; text-align: center;">
    <div style="max-width: 480px; margin: 0 auto; background-color: #1A1012; padding: 36px 28px; border-radius: 20px; border: 1px solid #342427;">
        <h1 style="color: #F5F5F5; margin: 0 0 6px 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;">
            Praxis<span style="color: #E54855;">Fit</span>
        </h1>
        <p style="color: #AAA0A2; font-size: 13px; margin: 0 0 28px 0;">
            Kelola Latihan, Nutrisi, &amp; Progres Anda Secara Terstruktur
        </p>

        <h2 style="font-size: 18px; color: #F5F5F5; margin: 0 0 12px 0;">Verifikasi Alamat Email Anda</h2>

        <p style="color: #AAA0A2; line-height: 1.6; margin: 0 0 26px 0; font-size: 14px;">
            Gunakan kode verifikasi 6 digit di bawah ini untuk mengaktifkan akun PraxisFit Anda.
        </p>

        <div style="background-color: #251518; padding: 18px 28px; border-radius: 14px; border: 1px solid #E54855; display: inline-block; margin-bottom: 26px;">
            <span style="font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #E54855;">{{ $otpCode }}</span>
        </div>

        <p style="color: #AAA0A2; font-size: 12px; line-height: 1.5; margin: 0;">
            Kode ini berlaku selama 10 menit. Abaikan email ini jika Anda tidak merasa melakukan pendaftaran akun.
        </p>

        <div style="margin-top: 32px; padding-top: 18px; border-top: 1px solid #342427; font-size: 12px; color: #777777;">
            &copy; {{ date('Y') }} PraxisFit Platform Indonesia
        </div>
    </div>
</body>
</html>
