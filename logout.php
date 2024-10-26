<?php
session_start(); // Memulai sesi
session_destroy(); // Menghancurkan semua data sesi

// Redirect ke halaman login setelah logout
header("Location: login.php"); // Ganti dengan nama file halaman login Anda
exit();
?>
