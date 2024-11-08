<?php
session_start();
include 'koneksi.php'; 

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM buku" . ($search ? " WHERE judul LIKE '%$search%'" : "") . " ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Koleksi Buku - klikPustaka</title>
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

    <main>
        <section class="book-collection">
            <div class="header-collection">
                <h2>Koleksi Buku</h2>
                <button class="add-book-btn-admin" onclick="window.location.href='tambahbukuadmin.php'">Tambah Buku</button>
                <div>
                    <form class="search-bar" method="POST" action="">
                        <input type="text" name="search" id="searchInput" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="book-container" id="search-results">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="book-card-admin">
                        <div class="book-front">
                            <img src="img_buku/<?php echo $row['gambar']; ?>" alt="Buku <?php echo htmlspecialchars($row['judul']); ?>">
                            <div class="book-info">
                                <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                                <p>Penulis: <?php echo htmlspecialchars($row['penulis']); ?></p>
                            </div>
                            <div class="button-group">
                                <button class="btn" onclick="toggleDetail(this)">Detail</button>
                                <button class="btn-update" onclick="window.location.href='updatebukuadmin.php?id=<?php echo $row['id']; ?>'">Update</button>
                                <button class="btn-delete" onclick="if(confirm('Apakah Anda yakin ingin menghapus buku ini?')) window.location.href='deletebukuadmin.php?id=<?php echo $row['id']; ?>&isbn=<?php echo $row['ISBN']; ?>'">Hapus</button>
                                <button type="submit" name="add_to_cart" class="add-book-btn">+</button>                            
                                <span class="stock-info">Stok: <strong><?php echo $row['kuantitas']; ?></strong></span>
                            </div>
                        </div>
                        <div class="book-back">
                            <p>Penerbit: <?php echo htmlspecialchars($row['penerbit']); ?></p>
                            <p>Tahun: <?php echo htmlspecialchars($row['tahun_terbit']); ?></p>
                            <p>ISBN: <?php echo htmlspecialchars($row['ISBN']); ?></p>
                            <p>Deskripsi: <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                            <button class="btn-kembali" onclick="toggleDetail(this.parentElement.parentElement)">Kembali</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function toggleDetail(button) {
            const card = button.closest('.book-card-admin');
            card.classList.toggle('show-back');
        }

        function confirmLogout() {
            return confirm("Apakah Anda Ingin Logout?");
        }
        
        $(document).ready(function(){
            $('#searchInput').on('keyup', function() {
                var keyword = $(this).val();
                $.ajax({
                    url: 'livesearchadmin.php',
                    method: 'POST',
                    data: {search: keyword},
                    success: function(data) {
                        $('#search-results').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>

