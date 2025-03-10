<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    <link rel="icon" href="images/yplogo.png"> 
    <title>Login</title>
    <!-- Tambahkan SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk menampilkan SweetAlert2 jika parameter error tersedia
        function showAlert() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error') && urlParams.get('error') === '1') {
                Swal.fire({
                    title: "Username atau Password salah!",
                    icon: "error",
                    confirmButtonText: "Coba Lagi",
                });
            }
        }
    </script>
</head>
<body onload="showAlert()">
        <div class="container">
            <div class="box form-box">
                <?php
                include("koneksi.php");
                if (isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                
                    if (isset($_GET['message']) && $_GET['message'] == 'logout_success') {
                        echo "<div style='color: green; text-align: center; padding: 10px; background-color: #d4edda;'>
                                Anda berhasil logout.
                            </div>";
                    }
                    
                    // Hash ke MD5
                    $hashed_password = md5($password);
                    
                    $result = mysqli_query($con, "SELECT * FROM tbl_user WHERE email='$email' AND password='$hashed_password'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if (is_array($row) && !empty($row)) {
                        $_SESSION['valid'] = $row['email'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['telepon'] = $row['telepon'];
                        $_SESSION['id'] = $row['id']; 
                        $_SESSION['user_id'] = $row['id']; // Simpan user_id ke sesi
                        header("Location: home.php");
                        exit();
                    } else {
                        // Arahkan kembali dengan parameter error
                        header("Location: index.php?error=1");
                        exit();
                    }
                } else {
                ?>

            <header>Login</header>
                <form action="" method="post">
                    <!-- Email -->
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email anda" required autocomplete="email">
                    </div>

                    <!-- Password -->
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password anda" required autocomplete="current-password">

                        <!-- Lupa Password -->
                        <div style="text-align: right; margin-top: 5px;">
                            <a href="forgot-password.php" style="font-size: 0.9em; text-decoration: none; color: #6c63ff;">Lupa password?</a>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login">
                    </div>

                    <div class="link">
                        Tidak memiliki akun? <a href="register.php">Daftar</a>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
</body>
</html>
