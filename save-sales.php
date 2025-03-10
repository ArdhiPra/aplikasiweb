<?php
session_start();
require_once 'koneksi.php'; // Pastikan koneksi database benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data JSON dari request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi data input
    if (!isset($data['user_id'], $data['order_id'], $data['items']) || !is_array($data['items']) || empty($data['items'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid request data.']);
        exit();
    }

    $user_id = $data['user_id'];
    $order_id = $data['order_id'];
    $items = $data['items'];

    // Mulai transaksi
    $con->begin_transaction();
    try {
        // Query untuk menyisipkan data
        $query = "INSERT INTO tbl_penjualan (user_id, order_id, id_barang, nama_barang, jumlah_pembelian, harga_barang, tanggal_terjual) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $con->prepare($query);

        if (!$stmt) {
            throw new Exception("Database preparation error: " . $con->error);
        }

        // Loop untuk menyimpan semua item
        foreach ($items as $item) {
            if (!isset($item['id'], $item['name'], $item['quantity'], $item['price'])) {
                throw new Exception("Invalid item data: " . print_r($item, true));
            }

            $id_barang = $item['id'];
            $nama_barang = $item['name'];
            $jumlah_pembelian = $item['quantity'];
            $harga_barang = $item['price'];

            // Bind parameter
            $stmt->bind_param('isisii', $user_id, $order_id, $id_barang, $nama_barang, $jumlah_pembelian, $harga_barang);
            if (!$stmt->execute()) {
                throw new Exception("Failed to save item: " . $stmt->error);
            }
        }

        // Commit transaksi
        $con->commit();
        http_response_code(200);
        echo json_encode(['message' => 'Transaction saved successfully.']);
    } catch (Exception $e) {
        // Rollback jika terjadi error
        $con->rollback();
        http_response_code(500);
        echo json_encode(['message' => 'Transaction failed: ' . $e->getMessage()]);
    } finally {
        $stmt->close();
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
}
?>
