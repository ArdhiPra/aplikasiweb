<?php
require 'koneksi.php'; // Ganti dengan file koneksi database Anda

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan gambar
    $query = "SELECT gambar_barang FROM tbl_barang WHERE id_barang = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($gambar_barang);
    $stmt->fetch();

    if ($gambar_barang) {
        header("Content-Type: image/jpeg");
        echo $gambar_barang;
    } else {
        // Debug jika gambar tidak ditemukan
        header("Content-Type: text/plain");
        echo "Gambar tidak ditemukan untuk ID: $id";
    }

    $stmt->close();
} else {
    // Debug jika parameter ID tidak ada
    header("Content-Type: text/plain");
    echo "Parameter ID tidak ada.";
}
?>
