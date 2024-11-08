<?php
session_start();
require "koneksi.php";

$token = isset($_GET['token']) ? $_GET['token'] : null;

if ($token) {
    $query = "SELECT * FROM lupa WHERE token = '$token' AND reset_token_expiry > NOW()";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        if (isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $user = mysqli_fetch_assoc($result);
            $email = $user['email'];

            $updateQuery = "UPDATE akun SET password = '$hashed_password' WHERE email = '$email'";
            if (mysqli_query($conn, $updateQuery)) {
                $deleteQuery = "DELETE FROM lupa WHERE token = '$token'";
                mysqli_query($conn, $deleteQuery);

                echo "<script>alert('Kata sandi telah di reset!'); document.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui kata sandi.');</script>";
            }
        }
    } else {
        echo "<script>alert('Token tidak valid atau sudah kedaluwarsa!'); document.location.href = 'login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Token tidak disediakan!'); document.location.href = 'login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - klikPustaka</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .body-lupa {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6ec1e4 0%, #1e90ff 100%);
            color: #333;
        }

        .forgot-password-container {
        width: 100%;
        max-width: 400px;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-password-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .forgot-password-container h2 {
        margin-bottom: 15px;
        color: #333;
        font-size: 26px;
        font-weight: 600;
        }

        .forgot-password-container p {
        font-size: 15px;
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
        }

        .forgot-password-container label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
        text-align: left;
        }

        .forgot-password-container input[type="password"] {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        margin-bottom: 25px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-password-container input[type="password"]:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 8px rgba(30, 144, 255, 0.3);
        }

        .forgot-password-container button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        color: #fff;
        background: linear-gradient(135deg, #1e90ff, #4169e1);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.3s ease;
        }

        .forgot-password-container button:hover {
        background: linear-gradient(135deg, #4682b4, #1e90ff);
        }

        .forgot-password-container .back-to-login {
        display: inline-block;
        margin-top: 20px;
        font-size: 14px;
        color: #1e90ff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        }

        .forgot-password-container .back-to-login:hover {
        color: #4169e1;
        text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="responsive.css">
</head>
<body class="body-lupa">
    <div class="forgot-password-container">
        <h2>Reset Kata Sandi</h2>
        <p>Masukkan password baru Anda.</p>
        <form action="resetpassword.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
            <label for="password">Password Baru</label>
            <input type="password" name="new_password" placeholder="Masukkan kata sandi baru" required pattern=".{8,}" title="Masukkan password minimal 8 karakter">
            <button type="submit" name="reset_password" value="Reset Kata Sandi">Reset Kata Sandi</button>
        </form>
        <a href="lupapassword.php" class="back-to-login">Kembali</a>
    </div>
</body>
</html>
