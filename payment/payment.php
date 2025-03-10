<?php
// Load library Midtrans
require_once __DIR__ . '/midtrans-php-master/Midtrans.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-y-TYJXV0jl118ZnSg44Ncdqm';
\Midtrans\Config::$isProduction = false; // Ubah ke true jika sudah di production
\Midtrans\Config::$is3ds = true;

// Ambil data keranjang dari session
$cart = $_SESSION['cart'] ?? []; // Jika tidak ada, buat array kosong

// Pastikan $cart adalah array
if (!is_array($cart) || empty($cart)) {
    die('Keranjang kosong atau data keranjang tidak valid.');
}

$total_price = 0;
$item_details = [];

// Loop untuk setiap item di keranjang
foreach ($cart as $product) {
    if (!is_array($product)) {
        die('Data produk tidak valid di keranjang.');
    }

    $item_details[] = [
        'id' => $product['id'] ?? 'UNKNOWN',
        'price' => $product['price'] ?? 0,
        'quantity' => $product['quantity'] ?? 1,
        'name' => $product['name'] ?? 'Unnamed Product'
    ];

    $total_price += ($product['price'] ?? 0) * ($product['quantity'] ?? 1);
}

// Tambahkan biaya pengiriman dan biaya admin
$item_details[] = [
    'id' => 'SHIPPING',
    'price' => 50000, // Biaya pengiriman
    'quantity' => 1,
    'name' => 'Shipping Fee'
];

$item_details[] = [
    'id' => 'ADMIN',
    'price' => 5000, // Biaya admin
    'quantity' => 1,
    'name' => 'Admin Fee'
];

// Tambahkan biaya pengiriman dan biaya admin ke total harga
$total_price += 50000 + 5000;

// Buat order_id unik untuk setiap transaksi
$order_id = uniqid('ORDER-'); 

// Detail transaksi
$transaction_details = [
    'order_id' => $order_id,
    'gross_amount' => $total_price
];

// Detail customer (ambil dari session atau set default)
$customer_details = [
    'name' => $_SESSION['username'] ?? '',
    'email' => $_SESSION['valid'] ?? 'guest@.com',
    'phone' => $_SESSION['telepon'] ?? '081234567890',
    'address' => $_SESSION['alamat'] ?? 'No Address'
];

// Parameter yang dikirim ke Midtrans
$params = [
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details
];

// Dapatkan token transaksi dari Midtrans
try {
    $snapToken = \Midtrans\Snap::getSnapToken([
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details
    ]);
} catch (Exception $e) {
    die($e->getMessage());
}
?>
