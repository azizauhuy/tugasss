<?php
session_start(); // Memulai session untuk menyimpan informasi login

// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect ke halaman login jika tidak memiliki akses
    exit();
}

// Koneksi ke database
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$pass = ""; // Ganti dengan password database Anda
$dbname = "klinik"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses pendaftaran pasien
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $idPasien = $_POST['IdPasien'];
    $nik = $_POST['NIK'];
    $nama = $_POST['Nama'];
    $ttl = $_POST['TTL'];
    $alamat = $_POST['Alamat'];
    $nohp = $_POST['NoHP'];
    $status = $_POST['Status'];

    // Query untuk menambahkan pasien
    $sql = "INSERT INTO pasien (IdPasien, NIK, Nama, TTL, Alamat, NoHP, Status) VALUES ('$idPasien', '$nik', '$nama', '$ttl', '$alamat', '$nohp', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "<div style='color: green;'>Pasien berhasil didaftarkan!</div>";
    } else {
        echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pendaftaran Pasien</h2>
        <form method="POST">
            <div class="form-group">
                <label for="IdPasien">ID Pasien:</label>
                <input type="text" id="IdPasien" name="IdPasien" required>
            </div>
            <div class="form-group">
                <label for="NIK">NIK:</label>
                <input type="text" id="NIK" name="NIK" required>
            </div>
            <div class="form-group">
                <label for="Nama">Nama:</label>
                <input type="text" id="Nama" name="Nama" required>
            </div>
            <div class="form-group">
                <label for="TTL">Tempat Tanggal Lahir:</label>
                <input type="text" id="TTL" name="TTL" placeholder="Contoh: Jakarta, 01-01-1990" required>
            </div>
            <div class="form-group">
                <label for="Alamat">Alamat Tempat Tinggal:</label>
                <input type="text" id="Alamat" name="Alamat" required>
            </div>
            <div class="form-group">
                <label for="NoHP">No HP:</label>
                <input type="text" id="NoHP" name="NoHP" required>
            </div>
            <div class="form-group">
                <label for="Status">Status Keterangan:</label>
                <select id="Status" name="Status" required>
                    <option value="Dosen">Dosen</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
            <input type="submit" value="Daftar Pasien">
        </form>
        <button onclick="window.location.href='admin_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
