<?php
session_start();
include 'koneksi.php';

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

// Query untuk menampilkan data peminjaman
$sqlPinjam = "SELECT id, id_buku, username, tanggal_pinjam, tanggal_kembali, status FROM peminjaman ORDER BY tanggal_pinjam DESC";
$resultPinjam = $conn->query($sqlPinjam);

// Query untuk menampilkan data pengembalian
$sqlKembali = "SELECT id, username, id_pinjam, id_buku, tanggal_kembali, denda, status FROM pengembalian ORDER BY tanggal_kembali DESC";
$resultKembali = $conn->query($sqlKembali);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman & Pengembalian</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f9f9f9;
}

.h1 {
    text-align: center;
    color: #333;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #007bff; /* Biru */
    color: white;
    font-weight: bold;
    font-size: 18px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #EFF6FF;
}

tr td {
    font-size: 16px;
    color: #333;
}

table td[colspan="6"] {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
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
    <main class="account-section">
    <h1 class="h1">Data Pengembalian</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>ID Pengembalian</th>
                <th>Username</th>
                <th>ID Peminjaman</th>
                <th>ID Buku</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Cek apakah ada data pengembalian yang ditemukan
            if ($resultKembali->num_rows > 0) {
                while($row = $resultKembali->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["username"] . "</td>
                            <td>" . $row["id_pinjam"] . "</td>
                            <td>" . $row["id_buku"] . "</td>
                            <td>" . $row["tanggal_kembali"] . "</td>
                            <td>" . $row["denda"] . "</td>
                            <td>" . $row["status"] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data pengembalian</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </main>
    <script src="script.js"></script>
    <script>
        function confirmLogout() {
            return confirm("Apakah Anda Ingin Logout?");
        }
    </script>
</body>
</html>

<?php
    $conn->close();
?>
