<?php
session_start();
include("koneksi.php");

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_message = "";
$error_message = "";

// Update password jika form disubmit
if (isset($_POST['ubah_password'])) {
    $password_lama = mysqli_real_escape_string($con, $_POST['password_lama']);
    $password_baru = mysqli_real_escape_string($con, $_POST['password_baru']);
    $konfirmasi_password = mysqli_real_escape_string($con, $_POST['konfirmasi_password']);

    // Hash password lama ke MD5
    $hashed_password_lama = md5($password_lama);

    // Ambil password dari database untuk verifikasi
    $query = "SELECT password FROM tbl_user WHERE id = '$user_id'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    if ($hashed_password_lama === $user['password']) {
        if ($password_baru === $konfirmasi_password) {
            $hashed_password_baru = md5($password_baru);
            $update_query = "UPDATE tbl_user SET password = '$hashed_password_baru' WHERE id = '$user_id'";
            if (mysqli_query($con, $update_query)) {
                $success_message = "Password berhasil diubah!";
            } else {
                $error_message = "Terjadi kesalahan saat mengubah password.";
            }
        } else {
            $error_message = "Konfirmasi password tidak cocok.";
        }
    } else {
        $error_message = "Password lama salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon" href="images/yplogo.png"> 
</head>
<body>
    <?php include 'navbar/profilenav.php';
    ?>

<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="text-center">
                <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 30px;">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
                <h5 class="mt-2">Hello, <strong><?php echo $_SESSION['username']; ?></strong></h5>
            </div>
                <ul class="list-group mt-4">
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="bi bi-person me-2"></i>
                        <a href="profile.php" class="text-decoration-none text-dark">Informasi Akun</a>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="bi bi-receipt me-2 text-primary"></i>Riwayat Transaksi
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center active">
                        <i class="bi bi-key me-2"></i> Ubah Password
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center text-danger" onclick="confirmLogout()">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </li>
                </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h3>Ubah Password</h3>

            <!-- Pesan Sukses atau Error -->
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form Ubah Password -->
            <form method="POST" action="">
                <!-- Password Lama -->
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" required>
                </div>
                <!-- Password Baru -->
                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" required>
                </div>
                <!-- Konfirmasi Password -->
                <div class="mb-3">
                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" class="form-control" required>
                </div>
                <!-- Submit Button -->
                <button type="submit" name="ubah_password" class="btn btn-success">Ubah Password</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda akan keluar dari sesi ini.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, logout!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        }
    </script>
</body>
</html>
