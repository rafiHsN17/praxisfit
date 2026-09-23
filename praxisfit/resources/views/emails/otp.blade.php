<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP PraxisFit</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #09090b; color: #f4f4f5; padding: 40px 20px; margin: 0; text-align: center;">
    <div style="max-w-md; margin: 0 auto; background-color: #18181b; padding: 40px; border-radius: 20px; border: 1px solid #27272a; max-width: 500px;">
        
        <h1 style="color: #f4f4f5; margin-bottom: 5px; font-size: 28px;">
            Praxis<span style="color: #a3e635;">Fit</span>
        </h1>
        <p style="color: #a1a1aa; font-size: 14px; margin-bottom: 30px;">Konsistensi Hari Ini Adalah Kekuatan Besok.</p>
        
        <h2 style="font-size: 20px; color: #f4f4f5; margin-bottom: 15px;">Verifikasi Email Anda</h2>
        
        <p style="color: #d4d4d8; line-height: 1.6; margin-bottom: 30px; font-size: 15px;">
            Anda menerima email ini karena ada permintaan pendaftaran akun di PraxisFit. Masukkan kode 6-digit berikut untuk melanjutkan.
        </p>
        
        <div style="background-color: #09090b; padding: 20px; border-radius: 12px; border: 1px dashed #a3e635; display: inline-block; margin-bottom: 30px;">
            <span style="font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #a3e635;">{{ $otpCode }}</span>
        </div>
        
        <p style="color: #a1a1aa; font-size: 13px;">
            Kode ini hanya berlaku selama 10 menit. Jika Anda tidak pernah meminta kode ini, abaikan email ini.
        </p>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #27272a; font-size: 12px; color: #71717a;">
            &copy; {{ date('Y') }} PraxisFit Platform &bull; Built For Champions
        </div>
    </div>
</body>
</html>
