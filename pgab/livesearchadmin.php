<?php
include 'koneksi.php';

$keyword = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

    if ($keyword !== '') {
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
    } else {
        $query = "SELECT * FROM buku ORDER BY id DESC";
    }

    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="book-card-admin">';
            echo '<div class="book-front">';
            echo '<img src="img_buku/' . htmlspecialchars($row['gambar']) . '" alt="Buku ' . htmlspecialchars($row['judul']) . '">';
            echo '<div class="book-info">';
            echo '<h3>' . htmlspecialchars($row['judul']) . '</h3>';
            echo '<p>Penulis: ' . htmlspecialchars($row['penulis']) . '</p>';
            echo '</div>';
            echo '<div class="button-group">';
            echo '<button class="btn" onclick="toggleDetail(this)">Detail</button>';
            echo '<button class="btn-update" onclick="window.location.href=\'updatebukuadmin.php?id=' . $row['id'] . '\'">Update</button>';
            echo '<button class="btn-delete" onclick="if(confirm(\'Apakah Anda yakin ingin menghapus buku ini?\')) window.location.href=\'deletebukuadmin.php?id=' . $row['id'] . '&isbn=' . $row['ISBN'] . '\'">Hapus</button>';
            echo '<button type="submit" name="add_to_cart" class="add-book-btn">+</button>';
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
mysqli_close($conn);
?>
