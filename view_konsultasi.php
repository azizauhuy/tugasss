<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login dan memiliki role 'dokter'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
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

// Query untuk mengambil data konsultasi
$sql = "SELECT * FROM konsultasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Konsultasi</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container2">
        <h2>Data Konsultasi</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Konsultasi</th>
                    <th>Tanggal</th>
                    <th>ID Pasien</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Status</th>
                    <th>Hasil Analisa</th>
                    <th>Resep Obat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Contoh query untuk mengambil data dari tabel konsultasi
                $sql = "SELECT * FROM konsultasi"; // Ganti dengan query yang sesuai
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['IdKonsultasi']}</td>
                                <td>{$row['Tanggal']}</td>
                                <td>{$row['IdPasien']}</td>
                                <td>{$row['NIK']}</td>
                                <td>{$row['Nama']}</td>
                                <td>{$row['NoHP']}</td>
                                <td>{$row['Status']}</td>
                                <td>{$row['HasilAnalisa']}</td>
                                <td>{$row['ResepObat']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data konsultasi ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol Kembali -->
        <button onclick="window.location.href='dokter_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
