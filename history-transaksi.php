<?php
session_start();
include("koneksi.php");

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user untuk sidebar
$query_user = "SELECT username FROM tbl_user WHERE id = ?";
$stmt_user = mysqli_prepare($con, $query_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);

// Ambil data transaksi berdasarkan user_id
$query_transaksi = "SELECT order_id, nama_barang, jumlah_pembelian, harga_barang, tanggal_terjual 
                    FROM tbl_penjualan 
                    WHERE user_id = ? 
                    ORDER BY tanggal_terjual ASC";

$stmt_transaksi = mysqli_prepare($con, $query_transaksi);
mysqli_stmt_bind_param($stmt_transaksi, "i", $user_id);
mysqli_stmt_execute($stmt_transaksi);
$result_transaksi = mysqli_stmt_get_result($stmt_transaksi);

// Buat array untuk mengelompokkan data berdasarkan order_id
$transactions = [];
while ($row = mysqli_fetch_assoc($result_transaksi)) {
    $transactions[$row['order_id']][] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
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
                    <li class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i> 
                        <a href="profile.php" class="text-decoration-none text-dark">Informasi Akun</a>
                    </li>
                    <li class="list-group-item list-group-item-action active">
                        <i class="bi bi-receipt me-2"></i> Riwayat Transaksi
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <i class="bi bi-key me-2"></i> 
                        <a href="ubah-password.php" class="text-decoration-none text-dark">Ubah Password</a>
                    </li>
                    <li class="list-group-item list-group-item-action text-danger" onclick="confirmLogout()">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h3>Riwayat Transaksi</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Pembelian</th>
                            <th>Harga/Pcs</th>
                            <th>Total Harga</th>
                            <th>Tanggal Beli</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)): ?>
                                <?php 
                                $no = 1; 
                                $colors = ['#f9f9f9', '#ffffff']; // Warna belang
                                $groupIndex = 0; // Indeks warna
                                ?>
                                <?php foreach ($transactions as $order_id => $items): ?>
                                    <?php $currentColor = $colors[$groupIndex % 2]; $groupIndex++; ?>
                                    <tr style="background-color: <?= $currentColor; ?>;">
                                        <td rowspan="<?= count($items); ?>" class="align-middle"><?= $no++; ?></td>
                                        <td rowspan="<?= count($items); ?>" class="align-middle"><?= htmlspecialchars($order_id); ?></td>
                                        <td><?= htmlspecialchars($items[0]['nama_barang']); ?></td>
                                        <td><?= $items[0]['jumlah_pembelian']; ?></td>
                                        <td>Rp<?= number_format($items[0]['harga_barang'], 0, ',', '.'); ?></td>
                                        <td>Rp<?= number_format($items[0]['jumlah_pembelian'] * $items[0]['harga_barang'], 0, ',', '.'); ?></td>
                                        <td><?= date("d M Y H:i", strtotime($items[0]['tanggal_terjual'])); ?></td>
                                    </tr>
                                    <?php for ($i = 1; $i < count($items); $i++): ?>
                                        <tr style="background-color: <?= $currentColor; ?>;">
                                            <td><?= htmlspecialchars($items[$i]['nama_barang']); ?></td>
                                            <td><?= $items[$i]['jumlah_pembelian']; ?></td>
                                            <td>Rp<?= number_format($items[$i]['harga_barang'], 0, ',', '.'); ?></td>
                                            <td>Rp<?= number_format($items[$i]['jumlah_pembelian'] * $items[$i]['harga_barang'], 0, ',', '.'); ?></td>
                                            <td><?= date("d M Y H:i", strtotime($items[$i]['tanggal_terjual'])); ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada riwayat transaksi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>



                    </table>
                </div>
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
