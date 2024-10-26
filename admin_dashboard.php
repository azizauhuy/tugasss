<?php
session_start(); 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            text-align: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dashboard Admin</h2>
        <button onclick="window.location.href='cek_pasien.php'">Cek Pasien</button>
        <button onclick="window.location.href='pendaftaran_pasien.php'">Pendaftaran Pasien</button>
        </form>
        <button onclick="window.location.href='login.php'">Kembali</button>
    </div>
</body>
</html>
</body>
</html>
