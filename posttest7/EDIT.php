<?php 
require "koneksi.php";

if (isset($_GET["id"])) {
    $resi = $_GET["id"];

    $stmt = $conn->prepare("SELECT * FROM paket WHERE resi = ?");
    $stmt->bind_param("s", $resi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0){
        $paket = $result->fetch_assoc();
    } else {
        echo "
        <script>
            alert('Data Tidak Ditemukan');
            window.location.href='DATA.php';
        </script>";
        exit();
    }
    $stmt->close();
} else {
    header("Location: DATA.php");
    exit();
}

if(isset($_POST["submit"])) {
    $resi = $_POST["resi"];
    $pengirim = $_POST["nama_pengirim"];
    $penerima = $_POST["nama_penerima"];
    $alamat = $_POST["alamat_penerima"];
    $hp = $_POST['telepon_penerima'];
    $jenis = $_POST["jenis_paket"];
    $berat = $_POST["berat_paket"];
    $status = $_POST["status_paket"];
    $bukti = $paket["bukti"]; 

    if ($_FILES["fileUpload"]["error"] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["fileUpload"]["tmp_name"];
        $file_name = $_FILES["fileUpload"]["name"];
        $file_size = $_FILES["fileUpload"]["size"];
        $file_type = $_FILES["fileUpload"]["type"];

        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($file_type, $allowed_types)) {
            echo "<script>
                    alert('File yang diupload tidak sesuai dengan format yang diharapkan (JPG, PNG).');
                    window.location.href='EDIT.php?id=" . htmlspecialchars($resi) . "';
                  </script>";
            exit();
        }

        $maxfile = 5 * 1024 * 1024;
        if($file_size > $maxfile){
            echo "<script>
                    alert('File yang diupload terlalu besar. Maksimal 5MB.');
                    window.location.href='EDIT.php?id=" . htmlspecialchars($resi) . "';
                  </script>";
            exit();
        }


        date_default_timezone_set("Asia/Makassar");
        $ekstensi = pathinfo($file_name, PATHINFO_EXTENSION);
        $ekstensi = strtolower($ekstensi);
        $newFileName = date("Y-m-d_h.i.s") . '.' . $ekstensi;

        $upload_dir = 'bukti/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($tmp_name, $upload_dir . $newFileName)){
            $bukti = $newFileName;

            if (!empty($paket["bukti"]) && file_exists($upload_dir . $paket["bukti"])) {
                unlink($upload_dir . $paket["bukti"]);
            }
        } else {
            echo "<script>
                    alert('Gagal mengupload file.');
                    window.location.href='EDIT.php?id=" . htmlspecialchars($resi) . "';
                  </script>";
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE paket SET pengirim = ?, penerima = ?, alamat = ?, hp = ?, jenis = ?, berat = ?, status_paket = ?, bukti = ? WHERE resi = ?");
    $stmt->bind_param("sssssdsss", $pengirim, $penerima, $alamat, $hp, $jenis, $berat, $status, $bukti, $resi);
    
    if ($stmt->execute()){
        echo "<script>
                alert('Data Berhasil Diupdate');
                window.location.href='DATA.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diupdate');
                window.location.href='DATA.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE PAKET</title>
    <link rel="icon" href="assets/head web.png" type="image/png">
    <link rel="stylesheet" href="paket.css">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="brand">
                <img src="assets/sicepat_putih.png" alt="SICEPAT" style="width: 120px;">
            </div>
            <p class="text-brand">SICEPAT</p>
            <p class="put">Update Paket</p>

            <div class="deco">
                <img src="assets/sigesit_services.png" alt="">
            </div>

            <label for="resi">No. Resi</label><br>
            <input type="text" id="resi" name="resi" required value="<?php echo htmlspecialchars($resi); ?>" readonly><br>
            
            <label for="nama_pengirim">Nama Pengirim</label><br>
            <input type="text" id="nama_pengirim" name="nama_pengirim" required value="<?php echo htmlspecialchars($paket["pengirim"]); ?>"><br>
            
            <label for="nama_penerima">Nama Penerima</label><br>
            <input type="text" name="nama_penerima" id="nama_penerima" required value="<?php echo htmlspecialchars($paket["penerima"]); ?>"><br>

            <label for="alamat_penerima">Alamat Penerima</label><br>
            <textarea id="alamat_penerima" name="alamat_penerima" rows="4" cols="50" required><?php echo htmlspecialchars($paket["alamat"]); ?></textarea><br>

            <label for="telepon_penerima">Nomor Telepon Penerima</label><br>
            <input type="tel" id="telepon_penerima" name="telepon_penerima" required pattern="\d{10,15}" title="Masukkan nomor telepon yang valid" value="<?php echo htmlspecialchars($paket["hp"]); ?>"><br>

            <label for="jenis_paket">Jenis Paket</label><br>
            <select id="jenis_paket" name="jenis_paket_display" disabled>
                <option value="">Pilih Jenis Paket</option>
                <option value="Dokumen" <?php if ($paket['jenis'] == 'Dokumen') echo 'selected'; ?>>Dokumen</option>
                <option value="Barang" <?php if ($paket['jenis'] == 'Barang') echo 'selected'; ?>>Barang</option>
                <option value="Elektronik" <?php if ($paket['jenis'] == 'Elektronik') echo 'selected'; ?>>Elektronik</option>
                <option value="Makanan" <?php if ($paket['jenis'] == 'Makanan') echo 'selected'; ?>>Makanan</option>
            </select><br>

            <input type="hidden" name="jenis_paket" value="<?php echo htmlspecialchars($paket['jenis']); ?>">

            <label for="berat_paket">Berat Paket (kg)</label><br>
            <input type="number" id="berat_paket" name="berat_paket" step="0.01" min="0" max="50" required value="<?php echo htmlspecialchars($paket["berat"]); ?>"><br>

            <label for="status_paket">Status</label><br>
            <select name="status_paket" id="status_paket" required>
                <option value="">Pilih Status Paket</option>
                <option value="Dikonfirmasi" <?php if ($paket['status_paket'] == 'Dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
                <option value="Pending" <?php if ($paket['status_paket'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Dikirim" <?php if ($paket['status_paket'] == 'Dikirim') echo 'selected'; ?>>Dikirim</option>
                <option value="Diterima" <?php if ($paket['status_paket'] == 'Diterima') echo 'selected'; ?>>Diterima</option>
            </select><br>

            <div id="uploadSection" style="display: <?php echo ($paket['status_paket'] == 'Diterima') ? 'block' : 'none'; ?>;">
                <label for="fileUpload">Upload Bukti (Opsional)</label><br>
                <input type="file" id="fileUpload" name="fileUpload" accept=".jpg, .jpeg, .png" class="aplot">
                <?php if (!empty($paket['bukti'])): ?>
                    <p class="bkt">Bukti Saat Ini: <a href="bukti/<?php echo htmlspecialchars($paket['bukti']); ?>" class="bukti" target="_blank">Lihat Bukti</a></p>
                <?php endif; ?>
            </div>

            <button class="submit" type="submit" name="submit">Kirim</button>
        </form>
    </div>

    <script>
    document.getElementById('status_paket').addEventListener('change', function() {
        var uploadSection = document.getElementById('uploadSection');
        if (this.value === 'Diterima') {
            uploadSection.style.display = 'block';
        } else {
            uploadSection.style.display = 'none';
        }
    });

    document.getElementById('status_paket').dispatchEvent(new Event('change'));
    </script>
</body>
</html>
