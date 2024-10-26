<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login dan memiliki role 'kasir'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: login.php"); // Redirect ke halaman login jika tidak memiliki akses
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Kasir</h2>
        
        <!-- Tombol untuk melakukan pembayaran -->
        <button onclick="window.location.href='pembayaran.php'">Pembayaran</button>
        <button onclick="window.location.href='laporan_transaksi.php'">Laporan</button>

        <!-- Tombol Logout -->
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
