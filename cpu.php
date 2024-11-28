<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourPC.id - Best Seller Processors</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>

<?php include 'navbar/cpunav.php';
?>

<div class="main-content">
    <div class="sidebar">
    <h1>Filter Produk</h1>
    <form method="GET" action="test.php">
        <label><input type="checkbox" name="brand[]" value="Intel"> Intel</label><br>
        <label><input type="checkbox" name="brand[]" value="AMD"> AMD</label><br>
        
        <label for="min_price">Harga Minimum:</label>
        <input type="number" name="min_price" id="min_price"><br>
        
        <label for="max_price">Harga Maksimum:</label>
        <input type="number" name="max_price" id="max_price"><br>

        <label for="search">Kata Kunci:</label>
        <input type="text" name="search" id="search"><br>
        
        <button type="submit">Cari</button>
    </form>
    </div>

    <div class="product-section">
        <div class="section-title">Best Seller</div>

        <?php
include 'koneksi.php'; // File koneksi database

// Mulai query dasar
$sql = "SELECT image, name, price FROM products";

// Tambahkan kondisi filter jika ada input dari pengguna
$conditions = [];

// Filter berdasarkan merk
if (isset($_GET['brand']) && is_array($_GET['brand'])) {
    $brands = array_map(function ($brand) use ($con) {
        return mysqli_real_escape_string($con, $brand);
    }, $_GET['brand']);
    $brandConditions = [];
    foreach ($brands as $brand) {
        $brandConditions[] = "name LIKE '%$brand%'";
    }
    $conditions[] = '(' . implode(' OR ', $brandConditions) . ')';
}

// Gabungkan semua kondisi ke query jika ada
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Jalankan query
$result = mysqli_query($con, $sql);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($con));
}

// Tampilkan produk
echo '<div class="product-list">';
while ($product = mysqli_fetch_assoc($result)) {
    echo '<div class="product-item">';
    echo '<img src="' . htmlspecialchars($product['image']) . '" alt="Product">';
    echo '<div class="product-info">';
    echo '<p class="product-name">' . htmlspecialchars($product['name']) . '</p>';
    echo '<p class="product-price">Rp' . number_format((float)$product['price'], 0, ',', '.') . '</p>';
    echo '</div>';

    // Form untuk tombol keranjang
    echo '<form method="POST" action="add-to-cart.php">';
    echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($product['name']) . '">';
    echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($product['price']) . '">';
    echo '<input type="hidden" name="product_image" value="' . htmlspecialchars($product['image']) . '">';
    echo '<button type="submit" class="add-to-cart"><i class="bi bi-cart3"></i></button>';
    echo '</form>';
    
    echo '</div>';
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo '</div>';

// Tutup koneksi
mysqli_close($con);
?>


    </div>
</div>

</body>
</html>
