<?php
session_start();

// Hapus produk dari keranjang
if (isset($_POST['index'])) {
    $index = $_POST['index'];
    unset($_SESSION['cart'][$index]);

    // Reindex array setelah penghapusan
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Kembali ke halaman keranjang
header("Location: cart.php");
exit();
?>
