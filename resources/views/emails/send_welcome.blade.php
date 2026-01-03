<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di PastiFIX</title>
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
                        <td style="background:#bf3131; padding:26px; text-align:center;">
                            <h1 style="margin:0; font-size:24px; color:#ffffff; letter-spacing:0.5px;">
                                Selamat Datang di PastiFIX 🎉
                            </h1>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:34px 32px;">

                            <p style="margin:0 0 14px 0; font-size:15px;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6;">
                                Kabar baik! Akun Anda telah <strong>berhasil diverifikasi</strong> dan kini sudah aktif.
                                Anda sudah bisa login dan mulai menggunakan layanan <strong>PastiFIX</strong>.
                            </p>

                            <p style="margin:0 0 18px 0; font-size:14px; line-height:1.6;">
                                Di PastiFIX, Anda dapat dengan mudah mencari jasa perbaikan dan renovasi rumah,
                                memantau progres pekerjaan, serta berkomunikasi langsung dengan penyedia jasa
                                secara aman dan transparan.
                            </p>

                            <!-- CTA -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/login') }}"
                                    style="
                                   display:inline-block;
                                   background:#bf3131;
                                   color:#ffffff;
                                   text-decoration:none;
                                   padding:14px 28px;
                                   border-radius:10px;
                                   font-size:14px;
                                   font-weight:700;
                                   letter-spacing:0.3px;
                               ">
                                    Masuk ke Akun Saya
                                </a>
                            </div>

                            <p style="margin:0; font-size:13px; color:#666; text-align:center;">
                                Jika Anda memiliki pertanyaan atau membutuhkan bantuan,
                                tim kami siap membantu Anda.
                            </p>

                            <p style="margin:16px 0 0 0; font-size:14px; text-align:center;">
                                Selamat menggunakan PastiFIX,<br>
                                <strong>Tim PastiFIX</strong>
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
