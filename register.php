<?php
session_start(); // Memulai session

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

$error = ""; // Variabel untuk menyimpan pesan error

// Proses pendaftaran jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi input
    if (empty($id) || empty($password) || empty($role)) {
        $error = "Semua field harus diisi.";
    } else {
        // Hash password sebelum menyimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data pengguna
        $sql = "INSERT INTO users (id, password, role) VALUES ('$id', '$hashedPassword', '$role')";

        if ($conn->query($sql) === TRUE) {
            // Redirect ke halaman login setelah berhasil registrasi
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Pendaftaran Akun</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required> <!-- Ganti 'name' menjadi 'id' -->

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Peran:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="dokter">Dokter</option>
                <option value="pasien">Pasien</option>
            </select>

            <input type="submit" value="Daftar">
        </form>

        <!-- Tombol Kembali -->
        <button onclick="window.location.href='login.php'">Kembali</button>
    </div>
</body>
</html>
