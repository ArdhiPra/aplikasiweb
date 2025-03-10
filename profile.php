<?php
session_start();
include("koneksi.php");

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = "SELECT username, email, telepon, alamat FROM tbl_user WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Variabel untuk pesan
$success_message = "";
$error_message = "";

// Update data jika form disubmit
if (isset($_POST['update'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telepon = htmlspecialchars(trim($_POST['telepon']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));

    // Validasi data
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email tidak valid!";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $telepon)) {
        $error_message = "Nomor telepon harus terdiri dari 10-15 digit angka!";
    } elseif (empty($username) || empty($alamat)) {
        $error_message = "Nama dan alamat tidak boleh kosong!";
    } else {
        // Update data ke database
        $update_query = "UPDATE tbl_user SET username = ?, email = ?, telepon = ?, alamat = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $telepon, $alamat, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Informasi berhasil diperbarui!";
            // Ambil kembali data terbaru dari database
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
        } else {
            $error_message = "Terjadi kesalahan saat memperbarui data: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon" href="images/yplogo.png">
</head>
<body>
    <?php include 'navbar/profilenav.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="text-center">
                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 30px;">
                        <?= strtoupper(substr($user['username'], 0, 1)); ?>
                    </div>
                    <h5 class="mt-2">Hello, <strong><?= htmlspecialchars($user['username']); ?></strong></h5>
                </div>
                <ul class="list-group mt-4">
                    <li class="list-group-item list-group-item-action active">
                        <i class="bi bi-person me-2"></i> Informasi Akun
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        <a href="history-transaksi.php" class="text-decoration-none text-dark">Riwayat Transaksi</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <i class="bi bi-key me-2 text-purple"></i>
                        <a href="ubah-password.php" class="text-decoration-none text-dark">Ubah Password</a>
                    </li>
                    <li class="list-group-item list-group-item-action text-danger" onclick="confirmLogout()">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h3>Informasi Akun</h3>

                <!-- Pesan -->
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nama</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($user['telepon']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($user['alamat']); ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-success">Update Information</button>
                </form>
            </div>
        </div>
    </div>

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
