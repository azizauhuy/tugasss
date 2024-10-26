<?php
session_start(); // Memulai session untuk menyimpan informasi login

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

// Proses login jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Query untuk memeriksa kredensial pengguna
    $sql = "SELECT * FROM users WHERE id='$id' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login sukses
        $_SESSION['role'] = $role;
        $_SESSION['id'] = $id;

        // Redirect berdasarkan role
        if ($role == 'admin') {
            header("Location: admin_dashboard.php"); // Ganti dengan halaman dashboard admin
        } elseif ($role == 'kasir') {
            header("Location: kasir_dashboard.php"); // Ganti dengan halaman dashboard kasir
        } elseif ($role == 'dokter') {
            header("Location: dokter_dashboard.php"); // Ganti dengan halaman dashboard dokter
        }
        exit();
    } else {
        // Jika login gagal
        $error = "ID, Password, atau Role tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="role-buttons">
                <input type="radio" id="admin" name="role" value="admin" required>
                <label for="admin" class="role-button">Admin</label>
                
                <input type="radio" id="kasir" name="role" value="kasir">
                <label for="kasir" class="role-button">Kasir</label>
                
                <input type="radio" id="dokter" name="role" value="dokter">
                <label for="dokter" class="role-button">Dokter</label>
            </div>

            <label for="id">ID (10 digit angka):</label>
            <input type="text" id="id" name="id" pattern="\d{10}" title="Harus terdiri dari 10 digit angka." required>

            <label for="password">Password (5-10 karakter):</label>
            <input type="password" id="password" name="password" minlength="5" maxlength="10" required>

            <input type="submit" value="Login">
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar Akun</a></p>
    </div>
</body>
</html>
