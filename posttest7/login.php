<?php
    session_start();
    require "koneksi.php"; // Tambahkan koneksi ke database

    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $admin_username = "admin"; 
        $admin_password = "2309106001"; 

        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        // Perbaikan: Tambahkan parameter pada mysqli_num_rows untuk $result
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi password dengan password hash
            if (password_verify($password, $user['password'])) {
                $_SESSION["login"] = true;

                // Cek apakah login sebagai admin atau user biasa
                if ($username === $admin_username && $password === $admin_password) {
                    $_SESSION['username'] = "admin";
                    echo "
                    <script>
                    alert('Welcome Admin');
                    document.location.href = 'DATA.php';
                    </script>";
                } else {
                    $_SESSION['username'] = "user";
                    echo "
                    <script>
                    alert('Welcome $username');
                    document.location.href = 'USER.php';
                    </script>";
                }
            } else {
                echo "
                <script>
                alert('Password salah!');
                document.location.href = 'login.php';
                </script>";
            }
        } else {
            echo "
            <script>
            alert('Username tidak ditemukan!');
            document.location.href = 'login.php';
            </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            font-family: Saira, Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: rgb(230, 67, 67);
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color : white;
        }
        .login-container h2 {
            margin-bottom: 15px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius : 15px;
            background-color : brown;
            border-color : white;
            color : white;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: white;
            color: brown;
            border: none;
            cursor: pointer;
            border-radius : 8px;
            margin-top : 8px;
        }
        .login-container button:hover {
            background-color: brown;
            color : white;
        }
        .error {
            color: black;
            margin-bottom: 10px;
        }
        .home{
            padding : 5px;
            border-radius : 8px;
            background-color : brown;
            text-decoration : none;
        }

        .home:hover {
            background-color : white;
        }

        .belum{
            margin-top: 0px;
            color: white;
            font-size: small;
            margin-top : 8px;
            margin-left: 8px;
        }
        .sinup {
            margin-top: 0px;
            color: rgba(0, 0, 0, 0.656);
        }

        .sinup:hover{
            color : white;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required autofocus>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit" name="submit">Login</button>
            <p class="belum">Belum ada akun? <a href="registrasi.php" class="sinup">Sign Up</a></p>
            <a href="index.html" class="home">🏠</a>
        </form>
    </div>
</body>
</html>
