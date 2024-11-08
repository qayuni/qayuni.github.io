<?php
session_start();
include 'koneksi.php';

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

$admin_user = "admin";
$admin_pass = "klikPustaka";

if (!isset($_SESSION["admin"])) {
    echo "
    <script>
    alert('Akses ditolak! Pastikan Anda Admin');
    document.location.href = 'login.php';
    </script>";
    exit;
}

if (isset($_POST["action"]) && isset($_POST["email"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $action = $_POST["action"];

    if ($action === "ban") {
        $updateQuery = "UPDATE akun SET status = 'banned' WHERE email = '$email'";
    } elseif ($action === "unban") {
        $updateQuery = "UPDATE akun SET status = 'active' WHERE email = '$email'";
    }

    if (mysqli_query($conn, $updateQuery)) {
        echo "
        <script>
        alert('Status akun berhasil diperbarui!');
        document.location.href = 'dbakun.php'; // Kembali ke halaman ini
        </script>";
    } else {
        echo "
        <script>
        alert('Gagal memperbarui status akun!');
        document.location.href = 'dbakun.php'; // Kembali ke halaman ini
        </script>";
    }
}

$query = "SELECT email, username, status FROM akun";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Akun - klikPustaka</title>
    <link rel="icon" type="image/jpeg" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
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
        <h2 class="account-title">Daftar Akun</h2>
        <table class="account-table">
            <tr>
                <th class="account-header-cell">Email</th>
                <th class="account-header-cell">Username</th>
                <th class="account-header-cell">Aksi</th>
            </tr>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="account-row">
                        <td class="account-cell"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="account-cell"><?php echo htmlspecialchars($row['username']); ?></td>
                        <td class="account-cell">
                        <?php if ($row['username'] === 'admin' || empty($row['email'])): ?>
                                <span>-</span>
                            <?php else: ?>
                                <?php if ($row['status'] === 'active'): ?>
                                    <form action="dbakun.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin memban akun ini?');">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        <button type="submit" name="action" value="ban" class="ban-button">Ban</button>
                                    </form>
                                <?php else: ?>
                                    <form action="dbakun.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin unban akun ini?');">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        <button type="submit" name="action" value="unban" class="unban-button">Unban</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada data akun</td>
                </tr>
            <?php endif; ?>

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
