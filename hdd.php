<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourPC.id - Best Seller</title>
    <link rel="stylesheet" href="category.css">
    <link rel="icon" href="images/yplogo.png"> 
    <script>
    // Fungsi untuk menampilkan alert jika ada parameter 'success'
    function showAlert() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success') && urlParams.get('success') === '1') {
        Swal.fire({
            title: "Berhasil ditambahkan!",
            icon: "success",
            draggable: true
            });
        }
    }
    </script>
</head>
<body onload="showAlert()">

<?php 
session_start();
include 'navbar/hddnav.php';
include 'koneksi.php'; // File koneksi database
?>
<div class="main-content">
    <div class="sidebar">
        <h1>Filter Produk</h1>
        <form method="GET" action="hdd.php">

            <!-- Dropdown Brand Processor -->
            <?php
            // Ambil nilai enum dari kolom tipe_barang
            $sql_enum_tipe = "SHOW COLUMNS FROM tbl_barang LIKE 'tipe_barang'";
            $result_enum_tipe = mysqli_query($con, $sql_enum_tipe);
            $values_tipe = [];
            if ($result_enum_tipe) {
                $row_enum_tipe = mysqli_fetch_assoc($result_enum_tipe);
                $enum_values_tipe = $row_enum_tipe['Type']; // Hasilnya: enum('Intel', 'AMD', ...)
                preg_match("/^enum\((.*)\)$/", $enum_values_tipe, $matches_tipe);
                $values_tipe = str_getcsv($matches_tipe[1], ',', "'");
            }
            ?>
            <label for="tipe_barang">Tipe Barang:</label>
            <select name="tipe_barang" id="tipe_barang">
                <option value="">Pilih</option>
                <?php foreach ($values_tipe as $value_tipe): ?>
                    <option value="<?= htmlspecialchars($value_tipe) ?>" <?= (isset($_GET['tipe_barang']) && $_GET['tipe_barang'] == $value_tipe) ? 'selected' : '' ?>><?= htmlspecialchars($value_tipe) ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Dropdown Brand Name (brand_barang) -->
            <?php
            // Ambil nilai enum dari kolom brand_barang
            $sql_enum_brand = "SHOW COLUMNS FROM tbl_barang LIKE 'brand_barang'";
            $result_enum_brand = mysqli_query($con, $sql_enum_brand);
            $values_brand = [];
            if ($result_enum_brand) {
                $row_enum_brand = mysqli_fetch_assoc($result_enum_brand);
                $enum_values_brand = $row_enum_brand['Type']; // Hasilnya: enum('ASUS', 'MSI', ...)
                preg_match("/^enum\((.*)\)$/", $enum_values_brand, $matches_brand);
                $values_brand = str_getcsv($matches_brand[1], ',', "'");
            }
            ?>
            <label for="brand_barang">Brand Barang:</label>
            <select name="brand_barang" id="brand_barang">
                <option value="">Pilih</option>
                <?php foreach ($values_brand as $value_brand): ?>
                    <option value="<?= htmlspecialchars($value_brand) ?>" <?= (isset($_GET['brand_barang']) && $_GET['brand_barang'] == $value_brand) ? 'selected' : '' ?>><?= htmlspecialchars($value_brand) ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Dropdown Processor Generation -->
            <?php
            // Ambil nilai enum dari kolom filter_barang
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
            <label for="filter_barang">Filter Barang:</label>
            <select name="filter_barang" id="filter_barang">
                <option value="">Pilih</option>
                <?php foreach ($values as $value): ?>
                    <option value="<?= htmlspecialchars($value) ?>" <?= (isset($_GET['filter_barang']) && $_GET['filter_barang'] == $value) ? 'selected' : '' ?>><?= htmlspecialchars($value) ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Filter Harga -->
            <label for="min_price">Harga Minimum:</label>
            <input type="number" name="min_price" id="min_price" value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '' ?>"><br>

            <label for="max_price">Harga Maksimum:</label>
            <input type="number" name="max_price" id="max_price" value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '' ?>"><br>

            <!-- Filter Kata Kunci -->
            <label for="search">Kata Kunci:</label>
            <input type="text" name="search" id="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"><br>

            <button type="submit">Cari</button>
        </form>
    </div>


    <div class="product-section">
        <div class="section-title">Best Seller</div>

        <?php
        // Mulai query dasar
        $sql = "SELECT id_barang, nama_barang, harga_barang, jumlah_barang, kategori_barang, tipe_barang, brand_barang, filter_barang, gambar_barang
                FROM tbl_barang 
                WHERE kategori_barang = 'HDD'";

        $conditions = [];

        // Kondisi wajib: kategori Pre-build
        $conditions[] = "kategori_barang = 'HDD'";

        // Filter berdasarkan brand  (tipe_barang)
        if (!empty($_GET['tipe_barang']) && $_GET['tipe_barang'] != 'Pilih') {
            $tipe_barang = mysqli_real_escape_string($con, $_GET['tipe_barang']);
            $conditions[] = "tipe_barang = '$tipe_barang'";
        }

        // Filter berdasarkan nama brand (brand_barang)
        if (!empty($_GET['brand_barang']) && $_GET['brand_barang'] != 'Pilih') {
            $brand_barang = mysqli_real_escape_string($con, $_GET['brand_barang']);
            $conditions[] = "brand_barang = '$brand_barang'";
        }

        // Filter berdasarkan tambahan (filter_barang)
        if (!empty($_GET['filter_barang']) && $_GET['filter_barang'] != 'Pilih') {
            $filter_barang = mysqli_real_escape_string($con, $_GET['filter_barang']);
            $conditions[] = "filter_barang = '$filter_barang'";
        }

        // Gabungkan kondisi untuk query akhir
        $sql = "SELECT * FROM tbl_barang WHERE " . implode(' AND ', $conditions);

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
                echo '<img src="display_image.php?id=' . htmlspecialchars($product['id_barang']) . '" alt="Product Image" style="width: 150px; height: auto;">';
                echo '<div class="product-info">';
                echo '<p class="product-name">' . htmlspecialchars($product['nama_barang']) . '</p>';
                echo '<p class="product-price">Rp' . number_format($product['harga_barang'], 0, ',', '.') . '</p>';
                echo '</div>';
            
                // Tombol "Add to Cart" hanya dengan ikon Bootstrap
                echo '<form method="POST" action="add-to-cart.php">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($product['id_barang']) . '">'; 
                echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($product['nama_barang']) . '">';
                echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($product['harga_barang']) . '">';
                echo '<input type="hidden" name="product_image" value="' . htmlspecialchars($product['gambar_barang']) . '">';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
