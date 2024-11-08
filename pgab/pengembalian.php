<?php
session_start();
if (!isset($_SESSION['login'])) {
    echo "<script>alert('Harap Login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit;
}

require "koneksi.php";

$username = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['admin'];
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

function generateUniqueId($conn, $prefix = 'KM') {
    do {
        $randomNumber = rand(100, 999);
        $id = $prefix . $randomNumber;
        $query = "SELECT * FROM pengembalian WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
    } while (mysqli_num_rows($result) > 0);

    return $id;
}

// Proses pengembalian buku
if (isset($_POST['return_book'])) {
    $id_kembali = generateUniqueId($conn);
    $id_pinjam = $_POST['id_pinjam'];

    // Ambil detail peminjaman dan buku berdasarkan id_pinjam
    $query = "SELECT p.id_buku, p.tanggal_pinjam, p.tanggal_kembali, b.gambar 
              FROM peminjaman p 
              JOIN buku b ON p.id_buku = b.id 
              WHERE p.id = '$id_pinjam' AND p.username = '$username' AND p.status = 'dipinjam'";  // Pastikan statusnya 'dipinjam'
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_buku = $row['id_buku'];
        $gambar = $row['gambar'];
        $tanggal_pinjam = new DateTime($row['tanggal_pinjam']);
        $estimasi_kembali = new DateTime($row['tanggal_kembali']);
        $tanggal_kembali = new DateTime();

        // $tanggal_kembali->modify('+15 days'); //uji coba terlambat

        // Hitung denda jika pengembalian terlambat
        $denda = 0;
        $status = "tepat waktu";
        if ($tanggal_kembali > $estimasi_kembali) {
            $interval = $tanggal_kembali->diff($estimasi_kembali);
            $terlambat = $interval->days; // Hitung hari terlambat
            $denda = $terlambat * 10000; // Denda Rp10.000 per hari
            $status = "telat"; // Status pengembalian terlambat
        }
        

        // Tambahkan data ke tabel pengembalian
        $query_pengembalian = "INSERT INTO pengembalian (id, username, id_pinjam, id_buku, tanggal_kembali, denda, status) 
                               VALUES ('$id_kembali', '$username','$id_pinjam', '$id_buku', NOW(), '$denda', '$status')";
        if (mysqli_query($conn, $query_pengembalian)) {
            echo "<script>alert('Buku berhasil dikembalikan. Denda: Rp " . number_format($denda, 0, ',', '.') . ". Status: " . $status . ".');</script>";
            
            // Update status peminjaman ke 'dikembalikan' hanya untuk peminjaman ini
            $query_update_peminjaman = "UPDATE peminjaman SET status = 'dikembalikan' WHERE id = '$id_pinjam' AND username = '$username'"; // Update berdasarkan id_pinjam
            mysqli_query($conn, $query_update_peminjaman);
        } else {
            echo "<script>alert('Gagal mengembalikan buku.');</script>";
        }

    } else {
        echo "<script>alert('Data peminjaman dengan ID tersebut tidak ditemukan atau buku tidak dalam status dipinjam.');</script>";
    }
}


// Ambil riwayat peminjaman pengguna
$query_pinjam = "SELECT p.id, p.id_buku, b.judul, b.penulis, b.gambar, p.tanggal_pinjam, p.tanggal_kembali 
                 FROM peminjaman p 
                 JOIN buku b ON p.id_buku = b.id 
                 WHERE p.username = '$username' AND p.status = 'dipinjam'";
$result_pinjam = mysqli_query($conn, $query_pinjam);

$query_riwayat = "SELECT p.id, p.id_buku, b.judul, b.penulis, b.gambar, p.tanggal_kembali, p.status, p.denda
                  FROM pengembalian p 
                  JOIN peminjaman pm ON p.id_pinjam = pm.id 
                  JOIN buku b ON p.id_buku = b.id 
                  WHERE p.username = '$username' AND pm.status = 'dikembalikan'";
$result_riwayat = mysqli_query($conn, $query_riwayat);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku - KlikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
        h2 {
            font-size: 2rem;
            color: #1E3A8A;
            margin-bottom: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        h2 {
            display: block;
            font-size: 1.5em;
            margin-block-start: 0.83em;
            margin-block-end: 0.83em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }

        div {
            display: block;
            unicode-bidi: isolate;
        }

        /* PENGEMBALIAN BUKU */
        .returned-books {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 2000px;
            margin: 0 auto;
        }

        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 0px;
        }

        div {
            display: block;
            unicode-bidi: isolate;
        }

        .book-card {
            position: relative;
            width: 200px;
            height: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        body {
            display: flex;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            margin: 0;
        }

        .book-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .returned-books h1 {
            font-size: 1.5rem;
            word-wrap: break-word;
        }

        .book-card h1 {
            font-size: 1.2rem;
            word-wrap: break-word;
        }


        .book-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cart-book-image {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.3s;
        }

        .book-card:hover .cart-book-image {
            transform: scale(1.1);
        }

        .book-info {
            margin-top: 10px;
        }

        .rating {
            margin-top: 10px;
            color: #333; 
        }

        .rating-select {
            padding: 5px;
            color: #FFD700;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .rating label {
            font-weight: bold;
            color: #333;
        }


        .rating-select:hover {
            border-color: #aaa;
        }

        .rating-select option {
            font-size: 18px;
        }

        .action-buttons button {
            padding: 5px 10px;
            border: none;
            background-color: #3B82F6;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #1D4ED8;
        }

        .borrow-date {
            font-size: 14px;
        }

        .btn-return {
            background-color: #3B82F6;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-return:hover {
            background-color: #1E3A8A;
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
            <h1>Klik <br> Pustaka</h1>
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
    <!-- Cek apakah ada buku yang dipinjamkan -->
    <?php if (mysqli_num_rows($result_pinjam) > 0): ?>
        <!-- Div untuk Pengembalian Buku -->
        <section class="return-book">
            <h2>Kembalikan Buku</h2>
            <div class="book-container">
                <?php while ($row_pinjam = mysqli_fetch_assoc($result_pinjam)): ?>
                    <div class="book-card">
                        <div class="book-details">
                            <img src="img_buku/<?php echo htmlspecialchars($row_pinjam['gambar']); ?>" alt="<?php echo $row_pinjam['judul']; ?>" class="cart-book-image">
                            <div class="book-info">
                                <h3><?php echo $row_pinjam['judul']; ?></h3>
                                <p><strong>Penulis:</strong> <?php echo htmlspecialchars($row_pinjam['penulis']); ?></p>
                                <p><strong>Tanggal Peminjaman:</strong> <?php echo $row_pinjam['tanggal_pinjam']; ?></p>
                                <p><strong>Estimasi Kembali:</strong> <?php echo $row_pinjam['tanggal_kembali']; ?></p>
                            </div>
                        </div>
                        <form action="pengembalian.php" method="POST">
                            <input type="hidden" name="id_buku" value="<?php echo $row_pinjam['id_buku']; ?>">
                            <input type="hidden" name="id_pinjam" value="<?php echo $row_pinjam['id']; ?>">
                            <button type="submit" name="return_book" class="btn-return">Kembalikan</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <?php else: ?>
        <!-- Jangan tampilkan div pengembalian buku jika tidak ada buku yang dipinjam -->
        <style>
            .return-book {
                display: none;
            }
        </style>
    <?php endif; ?>

       <!-- Div untuk Riwayat Peminjaman Buku -->
    <section class="history-book">
        <h2>Riwayat Peminjaman Buku</h2>
        <div class="book-container">
            <?php while ($row_riwayat = mysqli_fetch_assoc($result_riwayat)): ?>
                <div class="book-card">
                    <div class="book-details">
                        <img src="img_buku/<?php echo htmlspecialchars($row_riwayat['gambar']); ?>" alt="<?php echo htmlspecialchars($row_riwayat['judul']); ?>" class="cart-book-image">
                        <div class="book-info">
                            <h3><?php echo htmlspecialchars($row_riwayat['judul']); ?></h3>
                            <p><strong>Penulis:</strong> <?php echo htmlspecialchars($row_riwayat['penulis']); ?></p>
                            <p><strong>Tanggal Pengembalian:</strong> <span class="borrow-date"><?php echo htmlspecialchars($row_riwayat['tanggal_kembali']); ?></span></p>
                            <p><strong>Status Pengembalian:</strong> <span class="borrow-date"><?php echo htmlspecialchars($row_riwayat['status']); ?></span></p>
            
                            <?php if ($row_riwayat['status'] == 'telat'): ?>
                                <p><strong>Denda:</strong> Rp <?php echo number_format($row_riwayat['denda'], 0, ',', '.'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="rating">
                        <label for="rating">Rating: </label>
                        <select id="rating" class="rating-select">
                            <option value="5">★ ★ ★ ★ ★</option>
                            <option value="4">★ ★ ★ ★</option>
                            <option value="3">★ ★ ★</option>
                            <option value="2">★ ★</option>
                            <option value="1">★</option>
                        </select>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
