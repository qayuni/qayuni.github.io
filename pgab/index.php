<?php
session_start();

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasboard - klikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
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
        <section class="hero">
            <h2>Selamat Datang di Klik Pustaka </h2>
            <p class="p">Temukan berbagai koleksi buku menarik dan dapatkan ilmu baru!</p>
            <a href="buku.php" class="cta">Mulai Menjelajah</a>
        </section>
        
        <section class="description">
            <h3>Tentang Klik Pustaka</h3>
            <p>Klik Pustaka adalah platform digital yang dirancang untuk memberikan akses mudah dan cepat <br> 
                kepada pengguna dalam mencari, membaca, dan meminjam buku secara daring. <br>
                Dengan berbagai kategori buku yang lengkap dan fitur navigasi yang intuitif, <br>
                Klik Pustaka hadir untuk memenuhi kebutuhan literasi pembaca kapan saja dan di mana saja.</p>
            <p>Kami berkomitmen untuk menyediakan koleksi buku yang terus diperbarui, sehingga pembaca selalu dapat menemukan buku terbaru dan terpopuler. <br>
                Bergabunglah dengan komunitas pembaca kami dan nikmati pengalaman membaca yang menyenangkan dan bermanfaat!</p>
        </section>

        <section class="features">
            <div class="feature">
                <h3>Koleksi Lengkap</h3>
                <p>Beragam buku dari berbagai kategori tersedia untuk pembaca.</p>
            </div>
            <div class="feature">
                <h3>Akses Mudah</h3>
                <p>Temukan buku yang pembaca inginkan hanya dengan beberapa klik.</p>
            </div>
            <div class="feature">
                <h3>Member Gratis</h3>
                <p>Daftar dan nikmati akses penuh ke perpustakaan digital.</p>
            </div>
        </section>
        <section class="reviews">
            <div class="testimonial-container"><br>
                <h2>Apa Kata Anggota Kami?</h2>
                <div class="testimonial">
                  <button class="arrow left-arrow" onclick="prevSlide()">&#10094;</button>
                  <div class="testimonial-content">
                    <img src="https://images.pexels.com/photos/91227/pexels-photo-91227.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Reviewer" class="reviewer-photo">
                    <p class="message">Aplikasi klik pustaka ini sangat memudahkan saya dalam mencari buku yang saya butuhkan. Katalognya lengkap dan mudah dinavigasi!</p>
                    <h3 class="name">- Xavi</h3>
                    <div class="rating">★★★★★</div>
                  </div>
                  <button class="arrow right-arrow" onclick="nextSlide()">&#10095;</button>
                </div>
              </div>
          </section>
          <footer class="footer">
            <div class="footer-content">
                <p>&copy; 2024 Klik Pustaka | Fakutlas Teknik Universitas Mulawarman</p>
                <p>Jl. Sambaliung, Sempaja Sel., Kec. Samarinda Utara, Kota Samarinda, Kalimantan Timur</p>
                <div class="footer-social-icons">
                    <a href="https://www.facebook.com/Kemdikbud.RI" class="footer-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/Kemdikbud_RI" class="footer-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/kemdikbud.ri" class="footer-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@kemdikbudRI27" class="footer-icon"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.tiktok.com/@kemdikbud.ri" class="footer-icon"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </footer>
    </main>
    <script src="script.js"></script>
    <script>
        function confirmLogout() {
            return confirm("Apakah Anda Ingin Logout?");
        }

        let currentIndex = 0;

        const testimonials = [
            {
                name: "- Xavi",
                message: "Aplikasi klik pustaka ini sangat memudahkan saya dalam mencari buku yang saya butuhkan. Katalognya lengkap dan mudah dinavigasi!",
                image: "https://images.pexels.com/photos/91227/pexels-photo-91227.jpeg?auto=compress&cs=tinysrgb&w=600",
                rating: "★★★★☆"
            },
            {
                name: "- Andi",
                message: "Aplikasi klik pustaka ini sangat memudahkan saya dalam mencari buku yang saya butuhkan. Katalognya lengkap dan mudah dinavigasi!",
                image: "https://images.pexels.com/photos/6973088/pexels-photo-6973088.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                rating: "★★★★☆"
            },
            {
                name: "- Siti",
                message: "Saya sangat puas dengan keanggotaan di perpustakaan ini. Proses pendaftaran cepat dan akses ke buku digital sangat membantu.",
                image: "https://images.pexels.com/photos/17039054/pexels-photo-17039054/free-photo-of-woman-bringing-book-from-shelf.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
                rating: "★★★★★"
            },
            {
                name: "- Budi",
                message: "Aplikasi ini membantu saya menemukan buku-buku yang jarang tersedia di toko. Sangat direkomendasikan untuk semua pembaca!",
                image: "https://images.pexels.com/photos/4347475/pexels-photo-4347475.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                rating: "★★★☆☆"
            }
        ];

        function prevSlide() {
            currentIndex = (currentIndex === 0) ? testimonials.length - 1 : currentIndex - 1;
            updateSlide();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % testimonials.length;
            updateSlide();
        }

        function updateSlide() {
            document.querySelector(".testimonial-content .name").innerText = testimonials[currentIndex].name;
            document.querySelector(".testimonial-content .message").innerText = testimonials[currentIndex].message;
            document.querySelector(".testimonial-content .reviewer-photo").src = testimonials[currentIndex].image;
            document.querySelector(".testimonial-content .rating").innerText = testimonials[currentIndex].rating;
        }
    </script>
</body>
</html>
