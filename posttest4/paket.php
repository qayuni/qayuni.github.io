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
            <label for="nama_pengirim">Nama Pengirim</label><br>
            <input type="text" id="nama_pengirim" name="nama_pengirim" required><br>
            
            <label for="nama_penerima">Nama Penerima</label><br>
            <input type="text" name="nama_penerima" id="nama_penerima"><br>

            <label for="alamat_penerima">Alamat Penerima</label><br>
            <textarea id="alamat_penerima" name="alamat_penerima" rows="4" cols="50" required></textarea><br>

            <label for="telepon_penerima">Nomor Telepon Penerima</label><br>
            <input type="number" id="telepon_penerima" name="telepon_penerima" required><br>

            <label for="jenis_paket">Jenis Paket</label><br>
            <select id="jenis_paket" name="jenis_paket" required>
                <option value="">Pilih Jenis Paket</option>
                <option value="Dokumen">Dokumen</option>
                <option value="Barang">Barang</option>
                <option value="Elektronik">Elektronik</option>
            </select><br>

            <label for="berat_paket">Berat Paket (kg)</label><br>
            <input type="number" id="berat_paket" name="berat_paket" step="0.01" min="0" max="50" required><br><br>

            <button class="submit" type="submit">Kirim</button>
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pengirim = htmlspecialchars($_POST['nama_pengirim']);
        $penerima = htmlspecialchars($_POST['nama_penerima']);
        $alamat = htmlspecialchars($_POST['alamat_penerima']);
        $hp = htmlspecialchars($_POST['telepon_penerima']);
        $jenis = htmlspecialchars($_POST['jenis_paket']);
        $berat = htmlspecialchars($_POST['berat_paket']);
    ?>
    <h1>Data Terkirim:</h1>
    <p>Pengirim: <?= $pengirim ?></p>
    <p>Penerima: <?= $penerima ?></p>
    <p>Alamat Penerima: <?= $alamat ?></p>
    <p>No. HP Penerima: <?= $hp ?></p>
    <p>Jenis Paket: <?= $jenis ?></p>
    <p>Berat Paket (KG): <?= $berat ?></p>

    <?php
    }
    ?>
</body>
</html>
