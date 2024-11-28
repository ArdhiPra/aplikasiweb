<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Periksa apakah email ada di database
    $result = mysqli_query($con, "SELECT * FROM tbl_user WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Buat token reset password
        $token = bin2hex(random_bytes(32));
        $user_id = $row['id'];
        $reset_url = "http://yourwebsite.com/reset_password.php?token=$token";

        // Simpan token dan waktu kadaluarsa ke database
        $query = "UPDATE tbl_user SET reset_token='$token', token_expiration=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id='$user_id'";
        if (mysqli_query($con, $query)) {
            // Kirim email reset password
            $to = $email;
            $subject = "Reset Password";
            $message = "Hi, klik tautan berikut untuk mereset password Anda: $reset_url \n\nTautan ini hanya berlaku selama 1 jam.";
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['success'] = "Tautan reset password telah dikirim ke email Anda.";
            } else {
                $_SESSION['error'] = "Gagal mengirim email.";
            }
        } else {
            $_SESSION['error'] = "Gagal menyimpan data token reset password.";
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; }
        .container { width: 100%; max-width: 400px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .container h2 { text-align: center; margin-bottom: 20px; }
        .field { margin-bottom: 15px; }
        .field label { display: block; margin-bottom: 5px; }
        .field input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { width: 100%; padding: 10px; background: #6c63ff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #4a4ae2; }
        .message { margin-top: 10px; color: red; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php elseif (isset($_SESSION['success'])): ?>
            <p class="message" style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" class="btn" name="submit">Kirim Tautan Reset</button>
        </form>
    </div>
</body>
</html>
