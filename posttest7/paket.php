<?php 
require "koneksi.php";

function generateRandomCode($length = 5) {
    return strtoupper(substr(bin2hex(random_bytes($length)), 0, $length));
}

$query = mysqli_query($conn, "SELECT max(resi) as resiakhir FROM paket");
$data = mysqli_fetch_assoc($query);
$resiakhir = $data['resiakhir'];

$urutan = (int) substr($resiakhir, 3,3);

$urutan++;

$huruf = "SCP";
$resiakhir = $huruf . sprintf("%03s",$urutan);

function getUniqueConfirmationCode($conn) {
    do {
        $kode_konfirmasi = generateRandomCode();
        $query_check = mysqli_query($conn, "SELECT * FROM paket WHERE konfirmasi='$kode_konfirmasi'");
    } while (mysqli_num_rows($query_check) > 0); // Ulangi jika kode konfirmasi sudah ada di database
    return $kode_konfirmasi;
}

if(isset($_POST["submit"])) {
    $resi = $_POST["resi"];
    $pengirim = $_POST["nama_pengirim"];
    $penerima = $_POST["nama_penerima"];
    $alamat = $_POST["alamat_penerima"];
    $hp = $_POST['telepon_penerima'];
    $jenis = $_POST["jenis_paket"];
    $berat = $_POST["berat_paket"];
    $status = "Pending";
    $konfirmasi = getUniqueConfirmationCode($conn);

    $sql = "INSERT INTO paket VALUES ('$resi', '$pengirim', '$penerima', '$alamat', '$hp', '$jenis', '$berat', '$status', '', '$konfirmasi')";

    $result = mysqli_query($conn,$sql);

    if ($result){
        echo"
        <script>
        alert('Data Berhasil Ditambahkan. KODE KONFIRMASI ANDA -> $konfirmasi <-');
        window.location.href='DATA.php';
        </script>";
    } else {
        echo "
        <script>
        alert('Data Gagal Ditambahkan');
        window.location.href='DATA.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INPUT PAKET</title>
    <link rel="icon" href="assets/head web.png" type="image/png">
    <link rel="stylesheet" href="paket.css">
</head>
<body>
    <div class="container">
        <form action="paket.php" method="post">
            <div class="brand"><img src="assets/sicepat_putih.png" alt="" style="width: 120px;"></div>
            <p class="text-brand">SICEPAT</p>
            <p class="put">Input Paket</p>
            

            <div class="deco"><img src="assets/sigesit_services.png" alt=""></div>

            <label for="resi">No.Resi</label><br>
            <input type="text" id="resi" name="resi" required value="<?php echo $resiakhir ?>" readonly><br>
            
            <label for="nama_pengirim">Nama Pengirim</label><br>
            <input type="text" id="nama_pengirim" name="nama_pengirim" required><br>
            
            <label for="nama_penerima">Nama Penerima</label><br>
            <input type="text" name="nama_penerima" id="nama_penerima" required><br>

            <label for="alamat_penerima">Alamat Penerima</label><br>
            <textarea id="alamat_penerima" name="alamat_penerima" rows="4" cols="50" required></textarea><br>

            <label for="telepon_penerima">Nomor Telepon Penerima</label><br>
            <input type="tel" id="telepon_penerima" name="telepon_penerima" required pattern="\d{10,15}" title="Masukkan nomor telepon yang valid"><br>

            <label for="jenis_paket">Jenis Paket</label><br>
            <select id="jenis_paket" name="jenis_paket" required>
                <option value="">Pilih Jenis Paket</option>
                <option value="Dokumen">Dokumen</option>
                <option value="Barang">Barang</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Makanan">Makanan</option>
            </select><br>

            <label for="berat_paket">Berat Paket (kg)</label><br>
            <input type="number" id="berat_paket" name="berat_paket" step="0.01" min="0" max="50" required><br><br>

            <button class="submit" type="submit" name="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
