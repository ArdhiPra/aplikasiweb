<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <h1>Keranjang Belanja</h1>

    <?php
    // Periksa apakah keranjang kosong
    if (empty($_SESSION['cart'])) {
        echo "<p>Keranjang Anda kosong!</p>";
    } else {
        echo '<table border="1" cellpadding="10">';
        echo '<tr><th>Gambar</th><th>Nama Produk</th><th>Harga</th><th>Aksi</th></tr>';

        foreach ($_SESSION['cart'] as $index => $item) {
            echo '<tr>';
            echo '<td><img src="' . htmlspecialchars($item['image']) . '" alt="Product" width="100"></td>';
            echo '<td>' . htmlspecialchars($item['name']) . '</td>';
            echo '<td>Rp' . number_format((float)$item['price'], 0, ',', '.') . '</td>';
            echo '<td>
                <form method="POST" action="remove-from-cart.php">
                    <input type="hidden" name="index" value="' . $index . '">
                    <button type="submit">Hapus</button>
                </form>
                </td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    ?>

    <a href="test.php">Lanjut Belanja</a>
</body>
</html>
