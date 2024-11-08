<?php
session_start();

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

if (!isset($_SESSION['login'])) {
    echo "<script>alert('Harap Login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit;
}

require "koneksi.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {

    var_dump($_POST);

    $id_buku = $_POST['id_buku'];

    $query_stok = "SELECT kuantitas FROM buku WHERE id = '$id_buku'";
    $result_stok = mysqli_query($conn, $query_stok);
    $data_stok = mysqli_fetch_assoc($result_stok);

    if ($data_stok && $data_stok['kuantitas'] > 0) {
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $deskripsi = $_POST['deskripsi'];
        $gambar = $_POST['gambar'];

        $_SESSION['keranjang'][] = [
            'id_buku' => $id_buku,
            'judul' => $judul,
            'penulis' => $penulis,
            'deskripsi' => $deskripsi,
            'gambar' => $gambar
        ];
        header("Location: peminjaman.php");
        exit;
    } else {
        echo "<script>alert('Stok buku tidak mencukupi.');</script>";
    }
}

function generateUniqueId($conn, $prefix = 'PJ') {
    do {
        $randomNumber = rand(100, 999);
        $id = $prefix . $randomNumber;
        $query = "SELECT * FROM peminjaman WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
    } while (mysqli_num_rows($result) > 0);

    return $id;
}

if (isset($_POST['confirm_peminjaman'])) {
    if (!empty($_SESSION['keranjang']) && (isset($_SESSION['username']) || isset($_SESSION['admin']))) {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['admin'];
        $tanggal_pinjam = date('Y-m-d');
        $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

        // Begin transaction
        mysqli_begin_transaction($conn);
        $all_items_available = true;

        try {
            foreach ($_SESSION['keranjang'] as $buku) {
                $id_buku = $buku['id_buku'];

                // Cek stok buku terbaru
                $query_stok = "SELECT kuantitas FROM buku WHERE id = '$id_buku'";
                $result_stok = mysqli_query($conn, $query_stok);
                $data_stok = mysqli_fetch_assoc($result_stok);

                if ($data_stok['kuantitas'] <= 0) {
                    echo "<script>alert('Stok buku \"{$buku['judul']}\" tidak mencukupi.');</script>";
                    $all_items_available = false;
                    continue;
                }

                $id_pinjam = generateUniqueId($conn);

                $query = "INSERT INTO peminjaman (id, id_buku, username, tanggal_pinjam, tanggal_kembali) 
                          VALUES ('$id_pinjam', '$id_buku', '$username', '$tanggal_pinjam', '$tanggal_kembali')";
                if (!mysqli_query($conn, $query)) {
                    throw new Exception("Gagal menambahkan peminjaman untuk buku ID: $id_buku");
                }
            }

            if ($all_items_available) {
                mysqli_commit($conn);
                unset($_SESSION['keranjang']);
                header("Location: peminjaman.php?status=success");
                exit;
            } else {
                mysqli_rollback($conn);
            }

        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>alert('".$e->getMessage()."');</script>";
        }
    } else {
        echo "<script>alert('Keranjang peminjaman kosong atau pengguna belum login.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku - KlikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        display: flex;
        color: #333;
        line-height: 1.6;
        background-color: #f4f6f9;
        padding: 20px;
        justify-content: center;
    }

    /* Judul */
    h2 {
        font-size: 2rem;
        color: #1E3A8A;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    /* Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    table thead tr {
        background-color: #3B82F6;
        color: #fff;
    }

    table td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        color: white;
    }

    table tbody tr:hover {
        background-color: #f1faff;
    }

    /* Kart Buku */
    .cart {
        background: #f5faff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        margin-bottom: 20px;
        text-align: center;
    }

    .cart-book-image {
        width: 80px;
        height: auto;
        margin-bottom: 10px;
        transition: transform 0.3s;
        border-radius: 5px;
    }

    .cart-book-image:hover {
        transform: scale(1.05);
    }

    /* Detail Buku */
    .book-info {
        flex-grow: 1;
        margin-left: 10px;
        text-align: left;
    }

    .book-info h3 {
        font-size: 1.4em;
        color: #1E3A8A;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .book-info p {
        margin: 5px 0;
        color: #555;
        font-size: 0.9em;
    }

    /* Tombol Aksi */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-detail, .btn-remove, .btn-confirm {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-remove {
        background-color: #E74C3C;
    }

    .btn-remove:hover {
        background-color: #B91C1C;
    }

    .btn-confirm {
        background: #3498DB;
        padding: 10px 15px;
    }

    .btn-confirm:hover {
        background: #2980B9;
    }

    .quantity {
        font-size: 16px;
        color: #121212;
        font-weight: bold;
        padding: 0 8px;
    }

    /* Total Keranjang */
    .cart-totals {
        margin-top: 20px;
        text-align: center;
        font-size: 1.2rem;
        color: #1E3A8A;
    }

    @media (max-width: 767px) {
        main {
        flex: 1;
        padding: 10px;
        margin-left: 20px;
        transition: margin-left 0.3s;
        width: calc(100% - 80px);
    }

    .cart {
        padding: 10px;
        margin-top: 20px;
        margin-right:30px;
        width: 1000px;
    }

    .cart-book-image {
        width: 50px;
        height: auto;
    }

    .book-info h3 {
        font-size: 1.1em;
    }

    .book-info p {
        font-size: 0.85em;
    }

    .action-buttons {
        flex-direction: column;
    }

    /* Cart Totals */
    .cart-totals {
        margin-top: 15px;
        font-size: 1em;
    }
    h2 {
        font-size: 1.5em;
    }

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
        <section class="cart">
            <h2>Keranjang Peminjaman Buku</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Batas Waktu Pengembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($_SESSION['keranjang'])): ?>
                        <?php foreach ($_SESSION['keranjang'] as $index => $buku): ?>
                            <tr>
                                <td>
                                    <div class="book-details">
                                        <img src="img_buku/<?php echo htmlspecialchars($buku['gambar']); ?>" alt="Gambar Buku" class="cart-book-image">

                                        <div class="book-info">
                                            <h3><?php echo htmlspecialchars($buku['judul']); ?></h3>
                                            <p>Penulis: <?php echo htmlspecialchars($buku['penulis']); ?></p>
                                            <p>Deskripsi: <?php echo htmlspecialchars($buku['deskripsi']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo date('d-m-Y'); ?></td>
                                <td><?php echo date('d-m-Y', strtotime('+7 days')); ?></td>
                                <td>
                                    <form action="hapuspinjam.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <button type="submit" class="btn-remove">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Keranjang kosong.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="cart-totals">
                <form action="peminjaman.php" method="POST">
                    <button type="submit" name="confirm_peminjaman" class="btn-confirm">Konfirmasi Peminjaman</button>
                </form>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
