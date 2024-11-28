<?php
session_start();

// Periksa apakah sesi keranjang sudah ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ambil data produk dari POST
$product = [
    'name' => $_POST['product_name'],
    'price' => $_POST['product_price'],
    'image' => $_POST['product_image']
];

// Tambahkan produk ke sesi keranjang
$_SESSION['cart'][] = $product;

// Tampilkan pesan dan kembali ke halaman sebelumnya
echo "<script>
    alert('Ditambah ke keranjang');
    window.history.back();
</script>";
?>
