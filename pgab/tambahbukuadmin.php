<?php
include 'koneksi.php';
session_start();

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

if (isset($_POST['tambah'])) {
    $judul_buku = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kuantitas = intval($_POST['stok']);
    $isbn = $_POST['ISBN'];
    $deskripsi = $_POST['deskripsi'];

    $gambar_baru = $_FILES['gambar']['name'] ?? '';
    $tmp_name = $_FILES['gambar']['tmp_name'] ?? '';
    $fileSize = $_FILES['gambar']['size'] ?? 0;

    $maxFileSize = 2 * 1024 * 1024;

    if ($gambar_baru != "" && $fileSize > $maxFileSize) {
        echo "File terlalu besar. Batas maksimal adalah 2MB.";
        exit;
    }

    $tanggal_upload = date('Y-m-d H.i.s');
    $ekstensi = pathinfo($gambar_baru, PATHINFO_EXTENSION);
    $newFileName = $tanggal_upload . '.' . $ekstensi;

    if ($gambar_baru != "") {
        if (move_uploaded_file($tmp_name, 'img_buku/' . $newFileName)) {
        } else {
            echo "Gagal mengupload gambar.";
            exit;
        }
    } else {
        echo "Harap unggah gambar buku.";
        exit;
    }

    $sql = "INSERT INTO buku (gambar, judul, penulis, penerbit, tahun_terbit, kuantitas, ISBN, deskripsi) 
            VALUES ('$newFileName','$judul_buku', '$penulis', '$penerbit', '$tahun_terbit', '$kuantitas', '$isbn', '$deskripsi')";

    if (mysqli_query($conn, $sql)) {
        echo "Buku berhasil ditambahkan!";
        header("Location: bukuadmin.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Koleksi Buku - klikPustaka</title>
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

    <main class="main-content">
        <section class="admin-section">
            <h2>Kelola Koleksi Buku</h2>

            <div class="form-container">
                <form id="bookForm" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" id="bookId" name="book_id">

                    <div class="image-upload">
                        <label for="gambar">Upload Gambar</label>
                        <div class="upload-area" id="upload-area" onclick="document.getElementById('gambar').click();">
                            <p id="drag-text">Drag and drop image here or click to select</p>
                            <img class="preview-image" id="preview" src="" alt="Preview Gambar" style="display: none;" />
                        </div>
                        <input type="file" name="gambar" id="gambar" accept="image/*" required style="display:none;" onchange="previewImage(event)">
                    </div>                    
                    
                    <label for="judul"><b>Judul Buku</b></label>
                    <input type="text" id="judul" name="judul" required>
                    
                    <label for="penulis"><b>Penulis</b></label>
                    <input type="text" id="penulis" name="penulis" required>
                    
                    <label for="penerbit"><b>Penerbit</b></label>
                    <input type="text" id="penerbit" name="penerbit" required>
                    
                    <label for="tahun_terbit"><b>Tahun Terbit</b></label>
                    <input type="date" id="tahun_terbit" name="tahun_terbit" required>
            
                    <label for="stok"><b>Kuantitas</b></label>
                    <input type="number" id="stok" name="stok" required min="1">

                    <label for="ISBN"><b>ISBN</b></label>
                    <input type="text" id="ISBN" name="ISBN" required>
            
                    <label for="deskripsi"><b>Deskripsi</b></label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
            
                    <button type="submit" name="tambah">Tambah</button>
                    <button type="button" onclick="resetForm()">Batal</button>
                </form>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
    <script>
        const uploadArea = document.getElementById('upload-area');
        const preview = document.getElementById('preview');
        const fileInput = document.getElementById('gambar');
        const dragText = document.getElementById('drag-text');

        fileInput.addEventListener('change', function(event) {
            previewImage(event);
        });

        uploadArea.addEventListener('dragover', function(event) {
            event.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', function() {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', function(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                previewImage({ target: fileInput });
            }
            uploadArea.classList.remove('drag-over');
        });

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                    dragText.style.display = 'none';
                    uploadArea.style.border = 'none';
                    uploadArea.style.backgroundColor = 'transparent';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                dragText.style.display = 'block';
                uploadArea.style.border = '2px dashed #3B82F6';
                uploadArea.style.backgroundColor = '#f8f8f8';
            }
        }

        function resetForm() {
            window.history.back();
        }

        function confirmLogout() {
            return confirm("Apakah Anda Ingin Logout?");
        }
    </script>    
</body>
</html>
