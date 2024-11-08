<?php
    session_start();
    require "koneksi.php";

    $isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

    if (isset($_POST["signup"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $checkQuery = "SELECT * FROM akun WHERE email = '$email' OR username = '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);

        $password = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_num_rows($checkResult) > 0){
            echo "
            <script>
            alert('Email atau username tersebut telah terdaftar!');
            document.location.href = 'login.php';
            </script>";
        } else {

            $query = "INSERT INTO akun (email, username, password, status) VALUES ('$email', '$username', '$password', 'active')";

            if(mysqli_query($conn, $query)) {
                echo "
                <script>
                alert('Akun berhasil dibuat!');
                document.location.href = 'login.php';
                </script>";
            } else {
                echo "
                <script>
                alert('Gagal membuat akun!');
                document.location.href = 'login.php';
                </script>";
            }
        }
    }

    if(isset($_POST["login"])){
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = $_POST["password"];
    
        $admin_user = "admin";
        $admin_pass = "klikPustaka";
    
        $query = "SELECT * FROM akun WHERE (username = '$username' OR email = '$username')";
        $result = mysqli_query($conn, $query);
    
        if(mysqli_num_rows($result) === 1){
            $user = mysqli_fetch_assoc($result);
    
            if ($user['status'] === 'banned') {
                echo "
                <script>
                alert('Akun Anda telah dibanned oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.');
                document.location.href = 'login.php';
                </script>";
            } elseif(password_verify($password, $user['password'])) {
                $_SESSION["login"] = true;
    
                if($username === $admin_user && $password === $admin_pass){
                    $_SESSION["admin"] = true;
                    echo "
                    <script>
                    alert('Welcome admin!');
                    document.location.href = 'bukuadmin.php';
                    </script>";
                } else {
                    $_SESSION['username'] = $username;
                    echo "
                    <script>
                    alert('Selamat datang {$user['username']}!');
                    document.location.href = 'index.php';
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
    <title>Login - klikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="posisi">
    <aside class="sidebar">
        <div class="header">
            <div class="hamburger" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <h1>KLIK <br> PUSTAKA</h1>
        </div>
        <nav>
            <ul>
            <li><a href="index.php"><i class="fas fa-home"></i><span class="text">Beranda</span></a></li>
                <li><a href="buku.php"><i class="fas fa-book"></i><span class="text">Koleksi Buku</span></a></li>
                <?php if ($isAdmin): ?>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-user-cog"></i><span class="text">Database</span></a>
                    <ul class="dropdown-content">
                        <li><a href="bukuadmin.php"><i class="fas fa-plus"></i>Tambah Buku</a></li>
                        <li><a href="dbakun.php"><i class="fas fa-users-cog"></i>Kelola Akun</a></li>
                        <li><a href="dbpinjam.php"><i class="fas fa-file-alt"></i>Data Pinjam</a></li>
                        <li><a href="dbkembali.php"><i class="fa-solid fa-database"></i>Data Kembali</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <li><a href="aboutus.php"><i class="fas fa-info-circle"></i><span class="text">About Us</span></a></li>
                <li><a href="contact.php"><i class="fas fa-phone-alt"></i><span class="text">Kontak</span></a></li>
                <li><a href="peminjaman.php"><i class="fas fa-book-reader"></i><span class="text">Peminjaman</span></a></li>
                <li><a href="pengembalian.php"><i class="fas fa-book-open"></i><span class="text">Pengembalian</span></a></li>
                <?php if (isset($_SESSION['login'])): ?>
                    <li><a href="logout.php" onclick="return confirmLogout();"><i class="fa-solid fa-right-from-bracket"></i><span class="text">Log Out</span></a></li>
                <?php else: ?>
                    <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i><span class="text">Log In</span></a></li>
                <?php endif; ?>      
            </ul>
        </nav>
    </aside>

    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="img/bg6.jpg" alt="">
                <div class="text-login">
                    <span class="text-1">Membaca adalah jalan <br> membuka dunia</span>
                    <span class="text-2">Mari temukan ilmu tanpa jeda</span>
                </div>
            </div>
            <div class="back">
                <img class="backImg" src="img/bg7.jpg" alt="">
                <div class="text-login">
                    <span class="text-1">Selamat datang <br> di dunia literasi</span>
                    <span class="text-2">Mari jelajahi pengetahuan tanpa batas</span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <form action="#" method="POST">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" id="username" name="username" placeholder="Enter your email or username" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="text-login"><a href="lupapassword.php">Forgot password?</a></div>
                            <div class="button input-box">
                                <input type="submit" name="login" value="Login">
                            </div>
                            <div class="text-login sign-up-text">Don't have an account? <label for="flip">Sign up now</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="#" method="POST">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="Enter your password" required pattern=".{8,}" title="Masukkan password minimal 8 karakter">
                            </div>
                            <div class="button input-box">
                                <input type="submit" name="signup" value="Sign Up">
                            </div>
                            <div class="text-login sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="script.js"></script>
<script>
    function confirmLogout() {
        return confirm("Apakah Anda Ingin Logout?");
    }
</script>
</html>