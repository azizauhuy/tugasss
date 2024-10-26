<?php
session_start(); // Memulai session untuk menyimpan informasi login

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

// Proses input data konsultasi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idkonsultasi = $_POST['IdKonsultasi'];
    $tanggal = $_POST['Tanggal']; // DDMMYY
    $idPasien = $_POST['IdPasien'];
    $nik = $_POST['NIK'];
    $nama = $_POST['Nama'];
    $noHp = $_POST['NoHP'];
    $status = $_POST['Status'];
    $hasilAnalisa = $_POST['HasilAnalisa'];
    $resepObat = $_POST['ResepObat'];

    // Validasi format tanggal DDMMYY
    if (preg_match('/^\d{6}$/', $tanggal)) {
        // Format tanggal menjadi YYYY-MM-DD
        $formattedDate = DateTime::createFromFormat('dmy', $tanggal);
        if ($formattedDate) {
            $tanggal = $formattedDate->format('Y-m-d');
        } else {
            echo "Format tanggal tidak valid.";
            exit();
        }
    } else {
        echo "Format tanggal harus berupa 6 digit angka (DDMMYY).";
        exit();
    }

    // Query untuk menyimpan data konsultasi
    $sql = "INSERT INTO konsultasi (IdKonsultasi, Tanggal, IdPasien, NIK, Nama, NoHP, Status, HasilAnalisa, ResepObat) 
            VALUES ('$idkonsultasi', '$tanggal', '$idPasien', '$nik', '$nama', '$noHp', '$status', '$hasilAnalisa', '$resepObat')";

    if ($conn->query($sql) === TRUE) {
        echo "Data konsultasi berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Konsultasi</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Input Data Konsultasi</h2>

        <form method="POST" action="">
            <label for="IdKonsultasi">ID Konsultasi:</label>
            <input type="text" id="IdKonsultasi" name="IdKonsultasi" required>

            <label for="Tanggal">Tanggal (DDMMYY):</label>
            <input type="text" id="Tanggal" name="Tanggal" placeholder="DDMMYY" required>

            <label for="IdPasien">ID Pasien:</label>
            <input type="text" id="IdPasien" name="IdPasien" required>

            <label for="NIK">NIK:</label>
            <input type="text" id="NIK" name="NIK" required>

            <label for="Nama">Nama:</label>
            <input type="text" id="Nama" name="Nama" required>

            <label for="NoHP">No HP:</label>
            <input type="text" id="NoHP" name="NoHP" required>

            <label for="Status">Status:</label>
            <select id="Status" name="Status" required>
                <option value="Dosen">Dosen</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Umum">Umum</option>
            </select>

            <label for="HasilAnalisa">Hasil Analisa:</label>
            <textarea id="HasilAnalisa" name="HasilAnalisa" required></textarea>

            <label for="ResepObat">Resep Obat:</label>
            <textarea id="ResepObat" name="ResepObat" required></textarea>

            <input type="submit" value="Simpan Konsultasi">
        </form>

        <!-- Tombol Kembali -->
        <button onclick="window.location.href='dokter_dashboard.php'">Kembali</button>
    </div>
</body>
</html>
