<?php 
require "koneksi.php";

$resi = $_GET["id"];

$result = mysqli_query($conn, "SELECT * FROM paket WHERE resi = '$resi'");

while ($row = mysqli_fetch_assoc($result)){
    $paket[] = $row;
}

$paket = $paket[0];

if(isset($_POST["submit"])) {
    $resi = $_POST["resi"];
    $pengirim = $_POST["nama_pengirim"];
    $penerima = $_POST["nama_penerima"];
    $alamat = $_POST["alamat_penerima"];
    $hp = $_POST['telepon_penerima'];
    $jenis = $_POST["jenis_paket"];
    $berat = $_POST["berat_paket"];
    $status = $_POST["status_paket"];

    $sql = "UPDATE paket SET  pengirim = '$pengirim', penerima = '$penerima', alamat = '$alamat', hp = '$hp', jenis = '$jenis', berat = '$berat', status_paket = '$status' WHERE resi = '$resi'";

    $result = mysqli_query($conn,$sql);

    if ($result){
        echo"
        <script>
        alert('Data Berhasil Diupdate');
        window.location.href='DATA.php';
        </script>";
    } else {
        echo "
        <script>
        alert('Data Gagal Diupdate');
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
    <title>UPDATE PAKET</title>
    <link rel="icon" href="assets/head web.png" type="image/png">
    <link rel="stylesheet" href="paket.css">
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <div class="brand"><img src="assets/sicepat_putih.png" alt="" style="width: 120px;"></div>
            <p class="text-brand">SICEPAT</p>
            <p class="put">Update Paket</p>
            

            <div class="deco"><img src="assets/sigesit_services.png" alt=""></div>

            <label for="resi">No.Resi</label><br>
            <input type="text" id="resi" name="resi" required value="<?php echo $resi ?>" readonly><br>
            
            <label for="nama_pengirim">Nama Pengirim</label><br>
            <input type="text" id="nama_pengirim" name="nama_pengirim" required value="<?php echo $paket["pengirim"] ?>"><br>
            
            <label for="nama_penerima">Nama Penerima</label><br>
            <input type="text" name="nama_penerima" id="nama_penerima" required value="<?php echo $paket["penerima"] ?>"><br>

            <label for="alamat_penerima">Alamat Penerima</label><br>
            <textarea id="alamat_penerima" name="alamat_penerima" rows="4" cols="50" required><?php echo $paket["alamat"] ?></textarea><br>

            <label for="telepon_penerima">Nomor Telepon Penerima</label><br>
            <input type="number" id="telepon_penerima" name="telepon_penerima" required value="<?php echo $paket["hp"] ?>"><br>

            <label for="jenis_paket">Jenis Paket</label><br>
            <select id="jenis_paket" name="jenis_paket" disable>
                <option value="">Pilih Jenis Paket</option>
                <option value="Dokumen" <?php if ($paket['jenis'] == 'Dokumen') echo 'selected'; ?>>Dokumen</option>
                <option value="Barang" <?php if ($paket['jenis'] == 'Barang') echo 'selected'; ?>>Barang</option>
                <option value="Elektronik" <?php if ($paket['jenis'] == 'Elektronik') echo 'selected'; ?>>Elektronik</option>
                <option value="Makanan" <?php if ($paket['jenis'] == 'Makanan') echo 'selected'; ?>>Makanan</option>
            </select><br>

            <input type="hidden" name="jenis_paket" value="<?php echo $paket['jenis']; ?>">

            <label for="berat_paket">Berat Paket (kg)</label><br>
            <input type="number" id="berat_paket" name="berat_paket" step="0.01" min="0" max="50" required value="<?php echo $paket["berat"] ?>"><br><br>

            <label for="status_paket">Status</label><br>
            <select name="status_paket" id="status_paket" require>
                <option value="-">Status paket</option>
                <option value="Dikonfirmasi">Dikonfirmasi</option>
                <option value="Pending">Pending</option>
                <option value="Dikirim">Dikirim</option>
                <option value="Diterima">Diterima</option>
            </select><br><br>

            <button class="submit" type="submit" name="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
