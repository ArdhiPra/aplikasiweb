<?php
session_start();
include 'navbar/paynav.php';
require_once 'koneksi.php'; // Koneksi ke database

// Periksa apakah pengguna sudah login dan memiliki sesi
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Ambil data pembeli berdasarkan ID pengguna
$user_id = $_SESSION['user_id'];
$query = "SELECT username, telepon, alamat FROM tbl_user WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
} else {
    // Nilai default jika tidak ada data
    $customer = [
        'username' => 'Guest',
        'telepon' => 'No Phone',
        'alamat' => 'No Address'
    ];
}

// Siapkan data lainnya (contoh: Midtrans)
require_once 'payment/payment.php';
if (!isset($_SESSION['total_price']) || $_SESSION['total_price'] <= 0) {
    header("Location: cart.php");
    exit();
}
$transaction_details = [
    'order_id' => 'ORDER-' . rand(),
    'gross_amount' => $_SESSION['total_price']
];
$item_details = [];
foreach ($_SESSION['cart'] as $product) {
    $item_details[] = [
        'id' => $product['id'],
        'price' => $product['price'],
        'quantity' => $product['quantity'],
        'name' => $product['name']
    ];
}
$item_details[] = ['id' => 'SHIPPING', 'price' => 50000, 'quantity' => 1, 'name' => 'Shipping Fee'];
$item_details[] = ['id' => 'ADMIN', 'price' => 5000, 'quantity' => 1, 'name' => 'Admin Fee'];
$customer_details = [
    'first_name' => $customer['username'],
    'email' => $_SESSION['valid'] ?? 'No Email',
    'phone' => $customer['telepon'],
    'address' => $customer['alamat']
];
try {
    $params = [
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details
    ];
    $snapToken = \Midtrans\Snap::getSnapToken($params);
} catch (Exception $e) {
    die('Gagal mendapatkan token: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - YourPC.id</title>
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="icon" href="images/yplogo.png">
    <script type="text/javascript" 
            src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="SB-Mid-client-YkL6n8wMmOnFsYbw"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="checkout-container">
        <!-- Section Alamat Pengiriman -->
        <div class="shipping-section">
            <h3>
                <i class="bi bi-geo-alt-fill me-1"></i>
                Alamat Pengiriman
            </h3>
            <div class="customer-info">
                <p><strong><?= htmlspecialchars($customer['username']) ?> (+62)</strong></p>
                <p><?= htmlspecialchars($customer['telepon']) ?></p>
                <p><?= htmlspecialchars($customer['alamat']) ?></p>
            </div>
        </div>

        <!-- Section Ringkasan Pembayaran -->
        <div class="summary-container">
            <h3>Ringkasan Pembayaran</h3>
            <p>Subtotal         : <span>Rp<?= number_format($_SESSION['total_price'], 0, ',', '.') ?></span></p>
            <p>Biaya Pengiriman : <span>Rp50.000</span></p>
            <p>Biaya Admin      : <span>Rp5.000</span></p>
            <hr>
            <p class="total">Total: Rp<?= number_format($_SESSION['total_price'], 0, ',', '.') ?></p>
        </div>

        <!-- Tombol Checkout -->
        <button id="pay-button" class="checkout-button">Proceed to Payment</button>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            const snapToken = '<?= $snapToken ?>';
            snap.pay(snapToken, {
                onSuccess: function (result) {
                    Swal.fire({
                        title: 'Pembayaran berhasil!',
                        text: 'Pembayaran Anda telah berhasil diproses.',
                        icon: 'success',
                        confirmButtonText: 'Oke'
                    }).then(() => {
                        fetch('save-sales.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                user_id: <?= json_encode($_SESSION['user_id']) ?>,
                                order_id: result.order_id,
                                items: <?= json_encode($_SESSION['cart']) ?>
                            })
                        }).then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: 'Simpan Transaksi!',
                                    text: 'Transaksi Anda berhasil disimpan.',
                                    icon: 'success',
                                    confirmButtonText: 'Pergi'
                                }).then(() => {
                                    window.location.href = 'history-transaksi.php';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to save sales data.',
                                    icon: 'error',
                                    confirmButtonText: 'Ulang'
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while saving your data. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'Ulang'
                            });
                        });
                    });
                },
                onPending: function (result) {
                    Swal.fire({
                        title: 'Pembayaran tertunda!',
                        text: 'Mohon selesaikan transaksi.',
                        icon: 'warning',
                        confirmButtonText: 'Oke'
                    });
                },
                onError: function (result) {
                    Swal.fire({
                        title: 'Gagal melakukan pembayaran!',
                        text: 'Silahkan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    });
                },
                onClose: function () {
                    Swal.fire({
                        title: 'Pembayaran dibatalkan!',
                        text: 'Anda menutup pop up pembayaran tanpa menyelesaikan pembayaran.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
</body>
</html>
