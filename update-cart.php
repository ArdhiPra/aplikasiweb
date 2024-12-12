<?php
session_start();

// Periksa apakah data dikirim melalui POST
if (isset($_POST['product_index']) && isset($_POST['quantity'])) {
    $index = intval($_POST['product_index']);
    $quantity = intval($_POST['quantity']);

    // Validasi data
    if ($quantity > 0 && isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}

// Redirect kembali ke keranjang
header('Location: cart.php');
exit;
?>
