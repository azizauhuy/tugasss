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

$error = "";
$transactions = [];

// Proses jika form bulan dipilih
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    // Validasi input bulan dan tahun
    if (is_numeric($bulan) && is_numeric($tahun)) {
        // Ambil transaksi pada bulan dan tahun yang dipilih
        $sql = "SELECT IdPasien, Tanggal, Biaya 
                FROM pembayaran 
                WHERE MONTH(Tanggal) = ? AND YEAR(Tanggal) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $bulan, $tahun);
        $stmt->execute();
        $result = $stmt->get_result();

        // Menyimpan data transaksi
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }

        // Hitung total biaya transaksi bulanan
        $sqlTotal = "SELECT SUM(Biaya) AS totalBiaya 
                     FROM pembayaran 
                     WHERE MONTH(Tanggal) = ? AND YEAR(Tanggal) = ?";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bind_param("ii", $bulan, $tahun);
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();
        $totalBiaya = $resultTotal->fetch_assoc()['totalBiaya'];
    } else {
        $error = "Bulan dan Tahun tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Bulanan</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Laporan Transaksi Bulanan</h2>

        <!-- Form Pilih Bulan dan Tahun -->
        <form method="POST" action="">
            <label for="bulan">Bulan:</label>
            <input type="number" id="bulan" name="bulan" min="1" max="12" required>

            <label for="tahun">Tahun:</label>
            <input type="number" id="tahun" name="tahun" min="2000" max="2100" required>

            <input type="submit" value="Tampilkan Laporan">
        </form>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Tabel Laporan Transaksi -->
        <?php if (!empty($transactions)): ?>
            <h3>Laporan Transaksi untuk Bulan <?php echo $bulan; ?> Tahun <?php echo $tahun; ?></h3>
            <table>
                <tr>
                    <th>ID Pasien</th>
                    <th>Tanggal</th>
                    <th>Biaya</th>
                </tr>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['IdPasien']; ?></td>
                        <td><?php echo $transaction['Tanggal']; ?></td>
                        <td><?php echo number_format($transaction['Biaya'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <h4>Total Transaksi Bulanan: <?php echo number_format($totalBiaya, 0, ',', '.'); ?></h4>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>Tidak ada transaksi untuk bulan dan tahun yang dipilih.</p>
        <?php endif; ?>

        <!-- Tombol Kembali -->
        <button onclick="window.location.href='kasir_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
