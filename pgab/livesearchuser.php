<?php
include 'koneksi.php';
session_start();

if (isset($_POST['search'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM buku 
                WHERE judul LIKE '%$keyword%' 
                ORDER BY 
                    CASE
                        WHEN judul LIKE '$keyword%' THEN 1
                        WHEN judul LIKE '%$keyword%' THEN 2
                        WHEN judul LIKE '%$keyword' THEN 3
                        ELSE 4
                    END, 
                    judul ASC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="book-card">';
            echo '<div class="book-front">';
            echo '<img src="img_buku/' . htmlspecialchars($row['gambar']) . '" alt="Buku ' . htmlspecialchars($row['judul']) . '">';
            echo '<div class="book-info">';
            echo '<h3>' . htmlspecialchars($row['judul']) . '</h3>';
            echo '<p>Penulis: ' . htmlspecialchars($row['penulis']) . '</p>';
            echo '</div>';
            echo '<div class="button-group">';
            echo '<button class="btn" onclick="toggleDetail(this)">Detail</button>';

            echo '<form action="peminjaman.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="gambar" value="' . htmlspecialchars($row['gambar']) . '">';
            echo '<input type="hidden" name="judul" value="' . htmlspecialchars($row['judul']) . '">';
            echo '<input type="hidden" name="penulis" value="' . htmlspecialchars($row['penulis']) . '">';
            echo '<input type="hidden" name="penerbit" value="' . htmlspecialchars($row['penerbit']) . '">';
            echo '<input type="hidden" name="tahun_terbit" value="' . htmlspecialchars($row['tahun_terbit']) . '">';
            echo '<input type="hidden" name="ISBN" value="' . htmlspecialchars($row['ISBN']) . '">';
            echo '<input type="hidden" name="kuantitas" value="' . htmlspecialchars($row['kuantitas']) . '">';
            echo '<input type="hidden" name="id_buku" value="' . htmlspecialchars($row['id']) . '">';
            echo '<input type="hidden" name="deskripsi" value="' . htmlspecialchars($row['deskripsi']) . '">';
            echo '<button type="submit" name="add_to_cart" class="add-book-btn"';
            if ($row['kuantitas'] == 0) echo ' disabled';
            if (!isset($_SESSION['login'])) { 
                echo ' onclick="alert(\'Login dulu guys, baru pinjam buku.\'); window.location.href=\'login.php\'; return false;"';
            }
            echo '>+</button>';
            echo '</form>';

            echo '<span class="stock-info">Stok: <strong>' . htmlspecialchars($row['kuantitas']) . '</strong></span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="book-back">';
            echo '<p>Penerbit: ' . htmlspecialchars($row['penerbit']) . '</p>';
            echo '<p>Tahun: ' . htmlspecialchars($row['tahun_terbit']) . '</p>';
            echo '<p>ISBN: ' . htmlspecialchars($row['ISBN']) . '</p>';
            echo '<p>Deskripsi: ' . htmlspecialchars($row['deskripsi']) . '</p>';
            echo '<button class="btn-kembali" onclick="toggleDetail(this.parentElement.parentElement)">Kembali</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="no-result-message">Tidak ada buku yang ditemukan.</p>';
    }
} else {
    echo '<p class="invalid-search-message">Pencarian tidak valid.</p>';
}

mysqli_close($conn);
?>
