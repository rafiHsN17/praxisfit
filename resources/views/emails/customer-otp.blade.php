<!DOCTYPE html>
<html lang="id">
<body style="font-family: Arial, sans-serif; background:#f7f7f8; padding:24px; color:#202124;">
    <div style="max-width:480px; margin:auto; background:#ffffff; border-radius:16px; padding:32px; border:1px solid #e9e9ec;">
        <h2 style="margin-top:0; font-size:20px;">Kode Masuk Pelanggan</h2>
        <p style="font-size:14px; color:#555;">Gunakan 6 digit kode OTP berikut untuk masuk ke akun Anda. Kode ini berlaku selama <strong>5 menit</strong>.</p>
        <div style="margin:24px 0; padding:16px; background:#f7f7f8; border-radius:12px; text-align:center; font-size:32px; font-weight:bold; letter-spacing:8px; color:#e54855;">
            {{ $otpCode }}
        </div>
        <p style="font-size:12px; color:#888; margin-bottom:0;">Jika Anda tidak meminta kode ini, silakan abaikan email ini.</p>
    </div>
</body>
</html>

