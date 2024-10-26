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

$pasienData = null; // Variabel untuk menyimpan data pasien
$error = ""; // Variabel untuk menyimpan pesan error

// Proses cek data pasien jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPasien = $_POST['IdPasien'];

    // Query untuk mengecek data pasien
    $sql = "SELECT * FROM pasien WHERE IdPasien='$idPasien'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Jika data pasien ditemukan
        $pasienData = $result->fetch_assoc();
    } else {
        // Jika data pasien tidak ditemukan
        $error = "Data pasien dengan ID $idPasien tidak ditemukan. Silakan lakukan pendaftaran.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Data Pasien</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Cek Data Pasien</h2>
        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="IdPasien">ID Pasien:</label>
            <input type="text" id="IdPasien" name="IdPasien" required>
            <input type="submit" value="Cek Data">
        </form>

        <?php if ($pasienData): ?>
            <h3>Data Pasien</h3>
            <table>
                <tr>
                    <th>ID Pasien</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>TTL</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><?php echo $pasienData['IdPasien']; ?></td>
                    <td><?php echo $pasienData['NIK']; ?></td>
                    <td><?php echo $pasienData['Nama']; ?></td>
                    <td><?php echo $pasienData['TTL']; ?></td>
                    <td><?php echo $pasienData['Alamat']; ?></td>
                    <td><?php echo $pasienData['NoHP']; ?></td>
                    <td><?php echo $pasienData['Status']; ?></td>
                </tr>
            </table>
        <?php endif; ?>
        
        <!-- Tombol Kembali -->
        <button onclick="window.location.href='admin_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
