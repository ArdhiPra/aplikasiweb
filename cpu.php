<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourPC.id - Best Seller Processors</title>
    <link rel="stylesheet" href="category.css">
    <link rel="icon" href="images/yplogo.png"> 
    <script>
        // Fungsi untuk menampilkan alert jika ada parameter 'success'
        function showAlert() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') === '1') {
                alert("Added successfully");
            }
        }
    </script>
</head>
<body onload="showAlert()">

<?php 
session_start();
include 'navbar/cpunav.php';
include 'koneksi.php'; // File koneksi database
?>
<div class="main-content">
    <div class="sidebar">
        <h1>Product Filters</h1>
        <form method="GET" action="cpu.php">

            <!-- Checkbox Brand Processor -->
            <label><input type="checkbox" name="brand_processor[]" value="Intel"> Intel</label><br>
            <label><input type="checkbox" name="brand_processor[]" value="AMD"> AMD</label><br>

            <!-- Dropdown Generasi Processor -->
            <?php
            // Ambil nilai enum dari database untuk filter_barang
            $sql_enum = "SHOW COLUMNS FROM tbl_barang LIKE 'filter_barang'";
            $result_enum = mysqli_query($con, $sql_enum);
            $values = [];
            if ($result_enum) {
                $row_enum = mysqli_fetch_assoc($result_enum);
                $enum_values = $row_enum['Type']; // Hasilnya: enum('Gen 10', 'Gen 11', ...)
                preg_match("/^enum\((.*)\)$/", $enum_values, $matches);
                $values = str_getcsv($matches[1], ',', "'");
            }
            ?>
            <label for="filter_barang">Processor Generation :</label>
            <select name="filter_barang" id="filter_barang">
                <option value="">All Generations</option>
                <?php foreach ($values as $value): ?>
                    <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Filter Harga -->
            <label for="min_price">Harga Minimum:</label>
            <input type="number" name="min_price" id="min_price"><br>
            
            <label for="max_price">Harga Maksimum:</label>
            <input type="number" name="max_price" id="max_price"><br>

            <!-- Filter Kata Kunci -->
            <label for="search">Kata Kunci:</label>
            <input type="text" name="search" id="search"><br>
            
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="product-section">
        <div class="section-title">Best Seller</div>

        <?php
        // Mulai query dasar
        $sql = "SELECT id_barang, nama_barang, harga_barang, jumlah_barang, kategori_barang, tipe_barang, brand_barang, filter_barang 
                FROM tbl_barang 
                WHERE kategori_barang = 'Processor'";

        // Tambahkan kondisi filter jika ada input dari pengguna
        $conditions = [];
        
        // Filter berdasarkan brand processor (tipe_barang)
        if (isset($_GET['brand_processor']) && is_array($_GET['brand_processor'])) {
            $brands = array_map(function ($brand) use ($con) {
                return mysqli_real_escape_string($con, $brand);
            }, $_GET['brand_processor']);
            $brandConditions = [];
            foreach ($brands as $brand) {
                $brandConditions[] = "tipe_barang = '$brand'";
            }
            $conditions[] = '(' . implode(' OR ', $brandConditions) . ')';
        }

        // Filter berdasarkan generasi processor (filter_barang)
        if (!empty($_GET['filter_barang'])) {
            $filter_barang = mysqli_real_escape_string($con, $_GET['filter_barang']);
            $conditions[] = "filter_barang = '$filter_barang'";
        }

        // Filter berdasarkan harga
        if (!empty($_GET['min_price'])) {
            $min_price = mysqli_real_escape_string($con, $_GET['min_price']);
            $conditions[] = "CAST(REPLACE(REPLACE(harga_barang, 'Rp', ''), '.', '') AS UNSIGNED) >= $min_price";
        }
        if (!empty($_GET['max_price'])) {
            $max_price = mysqli_real_escape_string($con, $_GET['max_price']);
            $conditions[] = "CAST(REPLACE(REPLACE(harga_barang, 'Rp', ''), '.', '') AS UNSIGNED) <= $max_price";
        }

        // Filter berdasarkan kata kunci
        if (!empty($_GET['search'])) {
            $search = mysqli_real_escape_string($con, $_GET['search']);
            $conditions[] = "nama_barang LIKE '%$search%'";
        }

        // Gabungkan semua kondisi ke query jika ada
        if (!empty($conditions)) {
            $sql .= " AND " . implode(' AND ', $conditions);
        }

        // Debugging query
        echo "<!-- DEBUG: SQL Query = $sql -->";

        // Jalankan query
        $result = mysqli_query($con, $sql);

        // Periksa apakah query berhasil
        if (!$result) {
            die("Query gagal: " . mysqli_error($con));
        }

        // Tampilkan produk
        echo '<div class="product-list">';
        if (mysqli_num_rows($result) > 0) {
            while ($product = mysqli_fetch_assoc($result)) {
                echo '<div class="product-item">';
                // Ganti dengan gambar default jika kolom gambar tidak ada di database
                echo '<img src="images/default_product.png" alt="Product">';
                echo '<div class="product-info">';
                echo '<p class="product-name">' . htmlspecialchars($product['nama_barang']) . '</p>';
                echo '<p class="product-price">Rp' . number_format((float)str_replace(['Rp', '.'], '', $product['harga_barang']), 0, ',', '.') . '</p>';
                echo '</div>';

                // Form untuk tombol keranjang
                echo '<form method="POST" action="add-to-cart.php">';
                echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($product['nama_barang']) . '">';
                echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($product['harga_barang']) . '">';
                echo '<button type="submit" class="add-to-cart"><i class="bi bi-cart3"></i></button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo "<p>Product not found.</p>";
        }
        echo '</div>';

        // Tutup koneksi
        mysqli_close($con);
        ?>
    </div>
</div>

</body>
</html>
