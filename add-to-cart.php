<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ambil data dari form
$product_name = $_POST['product_name'];
$product_price = (float) $_POST['product_price'];
$product_image = $_POST['product_image'];

// Periksa apakah produk sudah ada di keranjang
$product_exists = false;
foreach ($_SESSION['cart'] as $index => $item) {
    if ($item['name'] === $product_name) {
        // Jika produk sudah ada, tambahkan jumlahnya
        $_SESSION['cart'][$index]['quantity']++;
        $product_exists = true;
        break;
    }
}

// Jika produk belum ada, tambahkan ke keranjang
if (!$product_exists) {
    $_SESSION['cart'][] = [
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => 1,
        'image' => $product_image // Simpan gambar
    ];
}

// Redirect kembali ke halaman CPU dengan pesan sukses
header("Location: cpu.php?success=1");
exit;
?>
