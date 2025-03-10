<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ambil data dari form
if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_image'])) {
    $product_id = $_POST['product_id']; // ID barang dari database
    $product_name = $_POST['product_name'];
    $product_price = (float) $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Periksa apakah produk sudah ada di keranjang
    $product_exists = false;
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] === $product_id) { // Periksa berdasarkan ID barang
            $_SESSION['cart'][$index]['quantity']++;
            $product_exists = true;
            break;
        }
    }

    // Jika produk belum ada, tambahkan ke keranjang
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'id' => $product_id, // Gunakan ID barang dari database
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1,
            'image' => $product_image
        ];
    }

    // Redirect kembali ke halaman asal menggunakan HTTP_REFERER
    if (!empty($_SERVER['HTTP_REFERER'])) {
        // Tambahkan parameter success ke URL
        $redirect_url = $_SERVER['HTTP_REFERER'];
        $redirect_url .= (strpos($redirect_url, '?') !== false ? '&' : '?') . 'success=1';
        header("Location: $redirect_url");
    } else {
        // Jika HTTP_REFERER tidak tersedia, redirect ke halaman default
        header("Location: home.php?success=1");
    }
    exit;
} else {
    // Jika data tidak valid, redirect kembali tanpa success
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $redirect_url = $_SERVER['HTTP_REFERER'];
        $redirect_url .= (strpos($redirect_url, '?') !== false ? '&' : '?') . 'error=1';
        header("Location: $redirect_url");
    } else {
        header("Location: index.php?error=1");
    }
    exit;
}
?>
