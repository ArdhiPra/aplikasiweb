<?php
session_start();

// Hapus semua data sesi
session_unset();
session_destroy();

// Redirect ke halaman index dengan pesan sukses
header("Location: index.php?message=logout_success");
exit;
?>
