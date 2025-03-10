<?php
session_start();
require_once 'navbar/cartnav.php';
require_once 'koneksi.php'; // Pastikan file ini menginisialisasi koneksi database ke $con

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Ambil data sesi pengguna
$id = $_SESSION['id'];

// Ambil data pengguna dari database
$query = "SELECT alamat FROM tbl_user WHERE id = '$id'";
$result = mysqli_query($con, $query);

if (!$result) {
    // Jika query gagal, tampilkan pesan error
    die("Query gagal: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

// Validasi apakah alamat kosong
if (empty($user['alamat'])) {
    echo "<script>
        Swal.fire({
            title: 'Alamat Belum Diisi!',
            text: 'Silakan lengkapi alamat Anda terlebih dahulu.',
            icon: 'warning',
            draggable: true
        }).then(() => {
            window.location.href = 'profile.php';
        });
    </script>";
    exit();
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah jumlah produk
if (isset($_POST['increase_quantity']) && is_numeric($_POST['increase_quantity'])) {
    $index = (int)$_POST['increase_quantity'];
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity']++;
    }
}

// Kurangi jumlah produk
if (isset($_POST['decrease_quantity']) && is_numeric($_POST['decrease_quantity'])) {
    $index = (int)$_POST['decrease_quantity'];
    if ($_SESSION['cart'][$index]['quantity'] > 1) {
        $_SESSION['cart'][$index]['quantity']--;
    }
}

// Hapus produk
if (isset($_POST['remove_product']) && is_numeric($_POST['remove_product'])) {
    $index = (int)$_POST['remove_product'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset indeks
}

// Hitung total harga
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Simpan total belanja ke dalam session
$_SESSION['total_price'] = $total_price + 50000 + 5000; // Total belanja + ongkir + admin
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - YourPC.id</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="images/yplogo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $index => $product): ?>
                        <tr>
                            <td class="product-cell">
                                <img src="display_image.php?id=<?= htmlspecialchars($product['id']) ?>" alt="Product Image" style="width: 5%; height: auto;">
                                <span><?= htmlspecialchars($product['name']) ?></span>
                            </td>
                            <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td>
                                <div class="qty-container">
                                    <button type="submit" name="decrease_quantity" value="<?= $index ?>">-</button>
                                    <span><?= htmlspecialchars($product['quantity']) ?></span>
                                    <button type="submit" name="increase_quantity" value="<?= $index ?>">+</button>
                                </div>
                            </td>
                            <td>Rp<?= number_format($product['price'] * $product['quantity'], 0, ',', '.') ?></td>
                            <td>
                                <button type="submit" class="remove-button" name="remove_product" value="<?= $index ?>">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-cart">Keranjang Anda kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>

    <div class="order-container">
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-details">
                <div class="summary-item">
                    <span>Subtotal (<?= count($_SESSION['cart']) ?> item):</span>
                    <span>Rp<?= number_format($total_price, 0, ',', '.') ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping fee:</span>
                    <span>Rp50.000</span>
                </div>
                <div class="summary-item">
                    <span>Admin fee:</span>
                    <span>Rp5.000</span>
                </div>
                <hr class="divider">
                <div class="summary-total">
                    <span>Total:</span>
                    <span>Rp<?= number_format($_SESSION['total_price'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
        <div class="order-button">
            <form method="POST" action="checkout.php">
                <button type="submit" name="checkout" class="checkout-button">Checkout</button>
            </form>
        </div>
    </div>
</body>
</html>
