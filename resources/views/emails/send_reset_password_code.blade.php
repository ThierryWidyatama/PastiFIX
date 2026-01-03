<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password PastiFIX</title>
</head>

<body style="margin:0; padding:0; background-color:#f6f7f9; font-family:Arial, Helvetica, sans-serif; color:#333;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f7f9; padding:30px 0;">
        <tr>
            <td align="center">

                <!-- CARD -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.06);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#bf3131; padding:24px; text-align:center;">
                            <h1 style="margin:0; font-size:22px; color:#ffffff; letter-spacing:0.5px;">
                                Reset Password
                            </h1>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:30px 32px;">

                            <p style="margin:0 0 12px 0; font-size:15px;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin:0 0 18px 0; font-size:14px; line-height:1.6;">
                                Kami menerima permintaan untuk mereset kata sandi akun <strong>PastiFIX</strong> Anda.
                                Gunakan kode verifikasi di bawah ini untuk melanjutkan proses reset password.
                            </p>

                            <!-- CODE -->
                            <div style="text-align:center; margin:30px 0;">
                                <span
                                    style="
                                display:inline-block;
                                font-size:32px;
                                font-weight:700;
                                letter-spacing:6px;
                                color:#bf3131;
                                background:#fff5f5;
                                padding:14px 26px;
                                border-radius:10px;
                                border:2px dashed #bf3131;
                            ">
                                    {{ $code }}
                                </span>
                            </div>

                            <p style="margin:0; font-size:13px; color:#555; text-align:center;">
                                Kode ini berlaku selama <strong>15 menit</strong>.
                            </p>

                            <p style="margin:16px 0 0 0; font-size:13px; color:#777; text-align:center;">
                                Jika Anda tidak merasa meminta reset password, abaikan email ini.
                                Akun Anda tetap aman.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#fafafa; padding:18px; text-align:center;">
                            <p style="margin:0; font-size:12px; color:#999;">
                                © {{ date('Y') }} PastiFIX Indonesia. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- END CARD -->

            </td>
        </tr>
    </table>

</body>

</html>
