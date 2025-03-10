<?php
session_start();
include("koneksi.php"); // Koneksi ke database

// Periksa apakah token valid
if (!isset($_GET['token']) || empty($_GET['token'])) {
    echo "Token tidak valid.";
    exit();
}

$token = mysqli_real_escape_string($con, $_GET['token']);

// Validasi token di database
$result = mysqli_query($con, "SELECT * FROM tbl_user WHERE reset_token='$token' AND token_expiration > NOW()");
if (mysqli_num_rows($result) === 0) {
    echo "Token tidak valid atau telah kadaluarsa.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$user_id = $row['id'];

// Jika form disubmit
if (isset($_POST['submit'])) {
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Validasi password
    if ($password !== $confirm_password) {
        $error_message = "Password dan Konfirmasi Password tidak cocok.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password harus memiliki minimal 6 karakter.";
    } else {
        // Hash password baru menggunakan md5
        $hashed_password = md5($password);

        // Update password di database
        $update_query = "UPDATE tbl_user SET password='$hashed_password', reset_token=NULL, token_expiration=NULL WHERE id='$user_id'";
        if (mysqli_query($con, $update_query)) {
            $_SESSION['success'] = "Password berhasil diubah. Silakan login.";
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan password baru.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Reset Password</header>
            <?php if (isset($error_message)): ?>
                <div style="color: red; text-align: center; margin-bottom: 15px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password baru anda" required>
                </div>
                <div class="field input">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Ulangi password baru anda" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Reset Password">
                </div>
                <div class="link">
                    <a href="index.php">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
