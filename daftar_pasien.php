<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "klinik";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPasien = $_POST['IdPasien'];
    $nik = $_POST['NIK'];
    $nama = $_POST['Nama'];
    $ttl = $_POST['TTL'];
    $alamat = $_POST['Alamat'];
    $noHp = $_POST['NoHP'];
    $status = $_POST['Status'];

    $sql = "INSERT INTO pasien (IdPasien, NIK, Nama, TTL, Alamat, NoHP, Status) VALUES ('$idPasien', '$nik', '$nama', '$ttl', '$alamat', '$noHp', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Pasien berhasil didaftarkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Daftarkan Pasien</h2>
    <form method="POST" action="">
        ID Pasien: <input type="text" name="IdPasien" required><br>
        NIK: <input type="text" name="NIK" required><br>
        Nama: <input type="text" name="Nama" required><br>
        Tempat Tanggal Lahir: <input type="text" name="TTL" required><br>
        Alamat: <input type="text" name="Alamat" required><br>
        No HP: <input type="text" name="NoHP" required><br>
        Status: 
        <select name="Status" required>
            <option value="Dosen">Dosen</option>
            <option value="Karyawan">Karyawan</option>
            <option value="Mahasiswa">Mahasiswa</option>
            <option value="Umum">Umum</option>
        </select><br>
        <input type="submit" value="Daftar">
    </form>
</body>
</html>
