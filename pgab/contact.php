<?php
session_start();
require "koneksi.php";

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO pesan_kontak (nama_depan, nama_belakang, email, pesan) VALUES ('$first_name', '$last_name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Pesan berhasil dikirim dan disimpan!");</script>';
    } else {
        echo '<script>alert("Gagal mengirim pesan. Silakan coba lagi.");</script>';
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - klikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        .contact-content {
            width: 100%;
            max-width: 1200px;
            padding: 40px 50px;
            background-color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .contact-content h1 {
            font-size: 2.5em;
            color: #1E3A8A;
            margin-bottom: 20px;
        }

        .contact-section {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        .left-side,
        .right-side {
            width: 48%;
            min-width: 300px;
        }

        .left-side h2,
        .right-side h2 {
            font-size: 1.8em;
            color: #1E3A8A;
            margin-bottom: 20px;
        }

        .map {
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }

        .contact-details {
            margin-top: 20px;
        }

        .contact-details h3 {
            font-size: 1.4em;
            margin-bottom: 10px;
            color: #1E3A8A;
        }

        .contact-details p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            font-size: 1.6em;
            color: white;
            background-color: #3B82F6;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background-color: #1D4ED8;
            transform: scale(1.1);
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            font-size: 1.1em;
            width: 100%;
            max-width: 600px;
            text-align: left;
            margin-top: 20px;
        }

        .name-fields {
            display: flex;
            gap: 10px;
        }

        .name-fields input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1.1em;
            outline: none;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1.1em;
            outline: none;
        }

        .contact-form textarea {
            resize: none;
            height: 120px;
        }

        .contact-form p {
            color: #888;
            font-size: 0.95em;
            text-align: center;
        }

        button {
            padding: 14px;
            background-color: #3B82F6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1D4ED8;
        }

        @media (max-width: 767px) {
            .body{
                padding: 0;
            }

            .contact-content {
                padding: 10px;
                margin-left: 50px;
            }

            .contact-content h1 {
                font-size: 2em;
            }

            .contact-section {
                flex-direction: column;
                gap: 20px;
            }

            .left-side, .right-side {
                width: 100%;
            }

            .contact-form {
                font-size: 1em;
            }

            .contact-form input,
            .contact-form textarea,
            .name-fields input {
                padding: 10px;
                font-size: 1em;
            }

            .social-icons {
                gap: 10px;
            }

            .social-icon {
                width: 45px;
                height: 45px;
                font-size: 1.4em;
            }
        }
    </style>
</head>
<body class="body">
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

    <div class="contact-content">
        <h1>Contact Us</h1>
        <div class="contact-section">
            <!-- Left side for contact details and map -->
            <div class="left-side">
                <h2>Find Us Here</h2>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7584.558484665984!2d117.160532!3d-0.46741!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f4cd30823c3%3A0x22ec6237d9bbdba1!2sFakultas%20Teknik%20Universitas%20Mulawarman!5e1!3m2!1sid!2sid!4v1730938253639!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="contact-details">
                    <p><b>Fakultas Teknik Universitas Mulawarman</b></p>
                    <p>Jl. Sambaliung, Sempaja Sel., Kec. Samarinda Utara, Kota Samarinda, Kalimantan Timur</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/Kemdikbud.RI" class="social-icon fb"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/Kemdikbud_RI" class="social-icon tw"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/kemdikbud.ri" class="social-icon ig"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/c/KEMENDIKBUDRI" class="social-icon yt"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.tiktok.com/@kemdikbud.ri" class="social-icon tt"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right side for message form -->
            <div class="right-side">
                <h2>Send Us a Message</h2>
                <form class="contact-form" action="contact.php" method="post">
                    <div class="name-fields">
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <p>We value your feedback and will respond as soon as possible.</p>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
