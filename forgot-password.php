<?php
session_start();
include 'koneksi.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = ''; // Untuk menyimpan pesan alert

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Periksa apakah email ada di database
    $result = mysqli_query($con, "SELECT * FROM tbl_user WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Buat token reset password 
        $token = bin2hex(random_bytes(32));
        $user_id = $row['id'];
        $reset_url = "http://localhost:8080/yourpc/reset-password.php?token=$token";

        // Simpan token dan waktu kedaluwarsa ke database
        $query = "UPDATE tbl_user SET reset_token='$token', token_expiration=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id='$user_id'";
        if (mysqli_query($con, $query)) {
            $mail = new PHPMailer(true);
            try {
                // Konfigurasi PHPMailer
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'yourpcid@gmail.com'; // Ganti dengan email Anda
                $mail->Password = 'nmyb bryg fbda poge'; // Ganti dengan sandi aplikasi
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Informasi email
                $mail->setFrom('no-reply@yourwebsite.com', 'YourPC.id');
                $mail->addAddress($email); // Email penerima

                // Konten email
                $mail->isHTML(true);
                $mail->Subject = "Reset Password";
                $mail->Body = "Hi, klik tautan berikut untuk mereset password Anda: 
                            <a href='$reset_url'>Klik di sini untuk mereset password Anda</a><br><br>
                            Tautan ini hanya berlaku selama 1 jam.";
                $mail->AltBody = "Hi, klik tautan berikut untuk mereset password Anda: $reset_url\n\nTautan ini hanya berlaku selama 1 jam.";

                $mail->send();
                $message = "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Terkirim!',
                            text: 'Tautan reset password telah dikirim ke email anda.',
                            icon: 'success',
                            confirmButtonText: 'Oke'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    });
                </script>";
            } catch (Exception $e) {
                $message = "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal mengirim email. Error: {$mail->ErrorInfo}',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    });
                </script>";
            }
        } else {
            $message = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menyimpan token reset password.',
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi'
                    });
                });
            </script>";
        }
    } else {
        $message = "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Email Tidak Ditemukan',
                    text: 'Email yang anda masukkan tidak terdaftar.',
                    icon: 'error',
                    confirmButtonText: 'Kembali'
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/yplogo.png"> 
    <title>Lupa Password</title>
    <!-- Tambahkan SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Lupa Password</header>
            <form action="" method="post">
                <!-- Email -->
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email Anda" required>
                </div>
                <!-- Submit -->
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Kirim Tautan Reset">
                </div>
                <div class="link">
                    <a href="index.php">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
    <?= $message; ?>
</body>
</html>
