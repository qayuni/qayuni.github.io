<?php
session_start();
require "koneksi.php";

date_default_timezone_set('Asia/Makassar');

$resetMessage = "";
$showModal = false;

if (isset($_POST['send_reset_link'])) {
    $email = $_POST['email'];

    $query = "SELECT * FROM akun WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $token = bin2hex(random_bytes(5));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $insertQuery = "INSERT INTO lupa (email, token, created_at, reset_token_expiry) VALUES ('$email', '$token', NOW(), '$expiry')
                        ON DUPLICATE KEY UPDATE token = '$token', created_at = NOW(), reset_token_expiry = '$expiry'";
        
        if (mysqli_query($conn, $insertQuery)) {
            $resetLink = "http://localhost/pgab/resetpassword.php?token=$token";
            $resetMessage = "Klik tautan untuk merubah kata sandi Anda <a href='$resetLink' target='_blank'>$resetLink</a>";
            $showModal = true;
        } else {
            echo "Error inserting token: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); document.location.href = 'lupapassword.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - klikPustaka</title>
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

        .forgot-password-container input[type="email"] {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        margin-bottom: 25px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-password-container input[type="email"]:focus {
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

        /* Style untuk modal */
        .modal {
            display: <?php echo $showModal ? 'flex' : 'none'; ?>;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s;
        }

        .modal-content a {
            color: #1E3A8A;
            text-decoration: none;
            font-weight: bold;
            word-wrap: break-word;
            display: block;
            margin: 10px 0;
        }

        .close-btn {
            margin-top: 20px;
            color: #fff;
            background-color: #1E3A8A;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .close-btn:hover {
            background-color: #142f6b;
        }

        /* Animasi untuk modal */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
    <link rel="stylesheet" href="responsive.css">
</head>
<body class="body-lupa">
    <div class="forgot-password-container">
        <h2>Lupa Kata Sandi</h2>
        <p>Masukkan email Anda untuk menerima link reset password.</p>
        <form action="lupapassword.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Masukkan email Anda" required>
            <button type="submit" name="send_reset_link" value="Kirim Tautan Reset">Kirim Tautan Reset</button>
        </form>
        <a href="login.php" class="back-to-login">Kembali ke Login</a>
    </div>

    <div class="modal" id="resetModal">
        <div class="modal-content">
            <p><?php echo $resetMessage; ?></p>
            <button class="close-btn" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('resetModal').style.display = 'none';
        }

        <?php if ($showModal): ?>
            document.getElementById('resetModal').style.display = 'flex';
        <?php endif; ?>
    </script>
</body>
</html>
