<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat atas Kelulusan Kursus Anda</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Source Sans Pro', Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 30px 20px; text-align: center;">
                            <img src="https://eduapi.senikita.my.id/storage/Logo.png" alt="Logo Widya Senikita" style="max-width: 150px; height: auto;" />
                        </td>
                    </tr>
                    <!-- Konten -->
                    <tr>
                        <td style="padding: 20px 30px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <h1 style="font-size: 24px; color: #3e0e0e; margin: 0 0 20px; text-align: center;">Selamat, {{ $data['nama'] }}!</h1>
                            <p style="margin: 0 0 15px;">Kami dengan bangga mengucapkan selamat atas keberhasilan Anda menyelesaikan kursus <strong>{{ $data['course'] }}</strong> bersama Widya Senikita! Dedikasi dan kerja keras Anda telah membuahkan hasil.</p>
                            <p style="margin: 0 0 15px;">Terlampir pada email ini, Anda akan menemukan sertifikat kelulusan resmi sebagai bukti pencapaian Anda. Anda juga dapat mengunduh sertifikat Anda langsung melalui tombol di bawah ini:</p>
                            <!-- Tombol Download -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin: 20px 0; text-align: center;">
                                <tr>
                                    <td>
                                        <a href="{{ $data['certificate_url'] }}" style="display: inline-block; padding: 12px 24px; background-color: #A8412A; color: #ffffff; font-size: 16px; font-weight: bold; text-decoration: none; border-radius: 4px; text-align: center;">Download Sertifikat</a>
                                    </td>
                                </tr>
                            </table>
                            <!-- Detail Sertifikat -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin: 20px 0; font-size: 14px;">
                                <tr>
                                    <td style="padding: 8px 0; color: #555555;"><strong>Nama:</strong></td>
                                    <td style="padding: 8px 0; color: #333333;">{{ $data['nama'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #555555;"><strong>Kursus:</strong></td>
                                    <td style="padding: 8px 0; color: #333333;">{{ $data['course'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #555555;"><strong>Tanggal Penyelesaian:</strong></td>
                                    <td style="padding: 8px 0; color: #333333;">{{ $data['tanggal_penyelesaian'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #555555;"><strong>ID Sertifikat:</strong></td>
                                    <td style="padding: 8px 0; color: #333333;">{{ $data['certificate_id'] }}</td>
                                </tr>
                            </table>
                            <p style="margin: 0 0 15px;">Silakan unduh dan simpan sertifikat PDF yang terlampir untuk keperluan Anda.</p>
                            <p style="margin: 0 0 15px;">Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami di <a href="mailto:support@senikita.my.id" style="color: #A8412A; text-decoration: none;">support@senikita.my.id</a>.</p>
                            <p style="margin: 0;">Terima kasih telah memilih Widya Senikita untuk perjalanan belajar Anda. Kami berharap dapat mendukung Anda di kursus berikutnya!</p>
                        </td>
                    </tr>
                    <!-- Tanda Tangan -->
                    <tr>
                        <td style="padding: 20px 30px; text-align: center; color: #333333; font-size: 14px; line-height: 1.5;">
                            <p style="margin: 0 0 5px; font-weight: bold;">Mario Aprilnino Prasetyo</p>
                            <p style="margin: 0 0 5px;">Chief Technology Officer</p>
                            <p style="margin: 0;"><a href="https://senikita.my.id" style="color: #A8412A; text-decoration: none;">Widya Senikita</a></p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 30px; text-align: center; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            <p style="margin: 0;">© 2025 Widya Senikita. Hak cipta dilindungi.</p>
                            <p style="margin: 5px 0 0;">Anda menerima email ini karena telah menyelesaikan kursus dengan Widya Senikita.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>