<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #FEC81A; text-align: center;">Permintaan Reset Password</h2>
        
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        
        <p>Kami menerima permintaan untuk mereset kata sandi akun PastiFIX Anda. Gunakan kode verifikasi berikut untuk melanjutkan proses:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #000; background: #f5f5f5; padding: 10px 20px; border-radius: 5px; border: 2px dashed #FEC81A;">
                {{ $code }}
            </span>
        </div>
        
        <p>Kode ini akan kadaluarsa dalam 15 menit.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin-top: 30px;">
        
        <p style="font-size: 12px; color: #999; text-align: center;">
            &copy; {{ date('Y') }} PastiFIX Indonesia. All rights reserved.
        </p>
    </div>

</body>
</html>