<?php

print_r($_POST);
exit;
/*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
composer require midtrans/midtrans-php

Alternatively, if you are not using **Composer**, you can download midtrans-php library 
(https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
the file manually.   

require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

//SAMPLE REQUEST START HERE

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-y-TYJXV0jl118ZnSg44Ncdqm';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

$item_details = [];
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $index => $product) {
        $item_details[] = [
            'id' => $index, // Bisa gunakan ID unik produk
            'price' => $product['price'],
            'quantity' => $product['quantity'],
            'name' => substr($product['name'], 0, 50), // Maksimal 50 karakter sesuai batas Midtrans
        ];
    }
}

// Tambahkan biaya ongkir dan admin fee ke item_details
$item_details[] = [
    'id' => 'shipping_fee',
    'price' => 50000,
    'quantity' => 1,
    'name' => 'Shipping Fee',
];

$item_details[] = [
    'id' => 'admin_fee',
    'price' => 5000,
    'quantity' => 1,
    'name' => 'Admin Fee',
];

// Hitung total belanja
$totalBelanja = $total_price + 50000 + 5000;

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $totalBelanja,
    ),
    'item_details' => $item_details, 

    'customer_details' => array(
        'first_name' => $_POST['username'],
        'email' => $_POST['email'],
        'phone' => $_POST['telepon'],
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
echo $snapToken;

?>
