<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    <link rel="icon" href="images/yplogo.png"> 
    <title>Daftar</title>
    <!-- Tambahkan SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <div class="box form-box">

    <?php
    include("koneksi.php");
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $telepon = $_POST['telepon'];

        $hashed_password = md5($password);

        // Check email
        $verift_query = mysqli_query($con, "SELECT email FROM tbl_user WHERE email='$email'");
        
        if (mysqli_num_rows($verift_query) != 0) {
            echo "<script>
                    Swal.fire({
                        title: 'Email Sudah Terdaftar',
                        text: 'Email ini sudah digunakan. Silakan gunakan email lain.',
                        icon: 'error',
                        confirmButtonText: 'Kembali'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
        } else {
            // Tambahkan data
            $insert_query = "INSERT INTO tbl_user (email, username, password, telepon) 
                            VALUES ('$email', '$username', '$hashed_password', '$telepon')";

            // Pesan
            if (mysqli_query($con, $insert_query)) {
                echo "<script>
                        Swal.fire({
                            title: 'Registrasi Berhasil',
                            text: 'Anda telah berhasil mendaftar. Silakan login.',
                            icon: 'success',
                            confirmButtonText: 'Login Sekarang'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan: " . mysqli_error($con) . "',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    </script>";
            }
        }
    } else {
    ?>
        <header>Daftar</header>
        <form action="" method="post">
            <!-- Email -->
            <div class="field input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukan email anda" autocomplete="off" required>
            </div>
            <!-- Username -->
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukan username anda" autocomplete="off" required>
            </div>
            <!-- Password -->
            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukan password anda" autocomplete="off" required>
            </div>
            <!-- Telepon -->
            <div class="field input">
                <label for="telepon">Telepon</label>
                <input type="text" name="telepon" id="telepon" placeholder="Masukan telepon anda" autocomplete="off" required >
            </div>
            <!-- Submit -->
            <div class="field">
                <input type="submit" class="btn" name="submit" value="Daftarkan">
            </div>
            <div class="link">
                Sudah memiliki akun? <a href="index.php">Log in</a>
            </div>
        </form>
    <?php } ?>
    </div>
</div>

</body>
</html>
