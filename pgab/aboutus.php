<?php
session_start();

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - klikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .social-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .social-icons a {
        color: #333;
        font-size: 24px;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .social-icons a:hover {
        color: #3B82F6;
        transform: scale(1.2);
    }
</style>
<body class="bg">
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
    <main>
        <div class="container-about">
            <h1>ooouuR TeaM. KeLoMPoK WoW WeB </h1>
            <div class="profile-cards">
                <div class="card">
                    <div class="profile-img">
                        <img src="img/fotoayun.jpeg" alt="Profile Image">
                    </div>
                    <h2>QuRTaTa A'YuNi</h2>
                    <p>2309106001</p>
                    <p>A1'23 iNFoRMaTiKa</p>
                    <p>Sometimes you just have to let's go, because action speaks louder than speaker.</p>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/qrrtayuni_/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:youremail@example.com"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
        
                <div class="card">
                    <div class="profile-img">
                        <img src="img/fotosan.jpg" alt="Profile Image">
                    </div>
                    <h2>SaNiYYaH iNTaN</h2>
                    <p>2309106004</p>
                    <p>A1'23 iNFoRMaTiKa</p>
                    <!-- <p>YOLO</p> -->
                    <p>وَقَالَ رَبُّكُمُ ادْعُونِي أَسْتَجِبْ لَكُمْ ۚ إِنَّ الَّذِينَ يَسْتَكْبِرُونَ عَنْ عِبَادَتِي سَيَدْخُلُونَ جَهَنَّمَ دَاخِرِينَ</p>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/evanescent12_/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:saniyyah585@gmail.com"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
        
                <div class="card">
                    <div class="profile-img">
                        <img src="img/fotoputri.jpg" alt="Profile Image">
                    </div>
                    <h2>RaiHaN PuTRi</h2>
                    <p>2309106008</p>
                    <p>A1'23 iNFoRMaTiKa </p>
                    <p>Life is too short <br> just say "KOCAK" and drop table</p>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/rhanputrii/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/yourprofile" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:raihanrahmadiniputri148@gmail.com"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
    <script>
        function confirmLogout() {
            return confirm("Apakah Anda Ingin Logout?");
        }
    </script>
</body>
</html>
