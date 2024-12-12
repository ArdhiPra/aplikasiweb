
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - YourPC.id</title>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="icon" href="images/yplogo.png">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-YkL6n8wMmOnFsYbw"></script>
    <script src="app.js" async></script>
</head>

<body>

<?php
    session_start();
    include 'navbar/cartnav.php';

    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Tambah jumlah produk
    if (isset($_POST['increase_quantity'])) {
        $index = $_POST['increase_quantity'];
        $_SESSION['cart'][$index]['quantity']++;
    }

    // Kurangi jumlah produk
    if (isset($_POST['decrease_quantity'])) {
        $index = $_POST['decrease_quantity'];
        if ($_SESSION['cart'][$index]['quantity'] > 1) {
            $_SESSION['cart'][$index]['quantity']--;
        }
    }

    // Hapus produk
    if (isset($_POST['remove_product'])) {
        $index = $_POST['remove_product'];
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset indeks
    }

    // Hitung total harga
    $total_price = 0;
    foreach ($_SESSION['cart'] as $index => $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Simpan total belanja ke dalam session
    $_SESSION['total_price'] = $total_price + 50000 + 5000; // Total belanja + ongkir + admin
    ?>

    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $index => $product): ?>
                        <tr>
                        <td class="product-cell">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product" style="width: 100px; height: auto; margin-right: 10px;">
                            <span><?= htmlspecialchars($product['name']) ?></span>
                        </td>
                        <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                        <td>
                        <div class="quantity-controls">
                            <form method="POST" style="display: inline;">
                                <button type="submit" name="decrease_quantity" value="<?= $index ?>">-</button>
                            </form>
                            <span><?= htmlspecialchars($product['quantity']) ?></span>
                            <form method="POST" style="display: inline;">
                                <button type="submit" name="increase_quantity" value="<?= $index ?>">+</button>
                            </form>
                        </div>
                            </td>
                            <td>Rp<?= number_format($product['price'] * $product['quantity'], 0, ',', '.') ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <button type="submit" class="remove-button" name="remove_product" value="<?= $index ?>">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Your cart is empty.</td>
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
                    <span>Rp<?= number_format($total_price + 50000 + 5000, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
        <div class="order-button">
    <button id="pay-button" class="checkout-button">Buy</button>
</div>

</body> 
</html>