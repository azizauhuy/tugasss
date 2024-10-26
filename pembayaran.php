<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login dan memiliki role 'kasir'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
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

$error = ""; // Untuk menyimpan pesan error
$message = ""; // Untuk menyimpan pesan sukses
$resepObat = ""; // Untuk menyimpan resep obat

// Proses pembayaran jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPasien = $_POST['IdPasien'];

    // Query untuk mendapatkan status dan resep dari konsultasi terakhir pasien
    $sql = "SELECT Status, ResepObat FROM konsultasi WHERE IdPasien='$idPasien' ORDER BY Tanggal DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['Status'];
        $resepObat = $row['ResepObat'];

        // Menentukan biaya berdasarkan status
        $biaya = 0; // Default biaya
        if ($status == 'Mahasiswa' || $status == 'Umum') {
            $biaya = 50000; // Biaya untuk mahasiswa dan umum
        }

        // Proses pembayaran jika ada biaya
        if ($biaya > 0) {
            // Simpan data pembayaran ke database (buat tabel pembayaran jika belum ada)
            $sqlInsert = "INSERT INTO pembayaran (IdPasien, Biaya) VALUES ('$idPasien', '$biaya')";
            if ($conn->query($sqlInsert) === TRUE) {
                $message = "Pembayaran berhasil. Pasien dapat mengambil obat dengan resep: " . htmlspecialchars($resepObat);
            } else {
                $error = "Terjadi kesalahan saat menyimpan pembayaran: " . $conn->error;
            }
        } else {
            $message = "Pasien tidak dikenakan biaya dan dapat mengambil obat dengan resep: " . htmlspecialchars($resepObat);
        }
    } else {
        $error = "Data pasien tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Pembayaran</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($message): ?>
            <p style="color:green;"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($resepObat): ?>
            <h3>Resep Obat</h3>
            <p><?php echo htmlspecialchars($resepObat); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="IdPasien">ID Pasien:</label>
            <input type="text" id="IdPasien" name="IdPasien" required>

            <input type="submit" value="Proses Pembayaran">
        </form>

        <!-- Tombol Kembali -->
        <button onclick="window.location.href='kasir_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
