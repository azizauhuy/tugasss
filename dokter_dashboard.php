<?php
session_start(); // Memulai session untuk menyimpan informasi login

// Cek apakah pengguna sudah login dan memiliki role 'dokter'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    header("Location: login.php"); // Redirect ke halaman login jika tidak memiliki akses
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h2>Dashboard Dokter</h2>
        <div class="navbar-links">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h3>Selamat Datang, Dokter!</h3>
        <div class="button-container">
            <button onclick="window.location.href='input_konsultasi.php'">Input Data Konsultasi</button>
            <!-- Tambahkan ini di dalam dokter_dashboard.php -->
            <button onclick="window.location.href='view_konsultasi.php'">Lihat Data Konsultasi</button>

        </div>
    </div>
</body>
</html>
