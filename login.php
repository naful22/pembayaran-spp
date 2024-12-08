<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi database sudah benar

$error_message = ''; // Variabel untuk pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input username dan password dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk memeriksa kombinasi username dan password
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username; // Simpan username dalam sesi
        header("Location: dashboard.php"); // Arahkan ke dashboard jika login berhasil
        exit();
    } else {
        $error_message = "Username atau password salah!"; // Pesan kesalahan login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Web Pembayaran Syahriyah Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('image/sekolah.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .login-container {
            text-align: center;
            width: 260px;
            background: rgba(255, 255, 255, 0.9);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .login-container img {
            width: 120px;
            margin-bottom: 1rem;
        }
        h2 {
            color: #555;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.4rem;
            margin: 0.4rem 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
        }
        button {
            width: 100%;
            padding: 0.5rem;
            background-color: #00a3a8;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #006269;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="image/tpq.png" alt="PEMBAYARAN SPP TPQ AL-MA'ARIF">
        <h2>Silahkan Login</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
