<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "nama_database";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM transaksi WHERE MONTH(tanggal) = MONTH(CURRENT_DATE())";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
</head>
<body>
    <h2>Laporan Transaksi Bulanan</h2>
    <table border="1">
        <tr>
            <th>ID Transaksi</th>
            <th>ID Pasien</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Biaya</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['idtransaksi']}</td>
                        <td>{$row['idpasien']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['biaya']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada transaksi untuk bulan ini.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
