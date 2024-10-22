<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['username'] !== "admin") {
    header("Location: login.php");
    exit();
}

require "koneksi.php";

$sql = mysqli_query($conn, "SELECT * FROM paket");
$paket = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $paket[] = $row;
}

$error_message = "";

if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($conn, $_GET["search"]);

    $paket = [];

    $stmt = $conn->prepare("SELECT * FROM paket WHERE resi = ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $paket[] = $row;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA | PAKET</title>
    <link rel="stylesheet" href="DATA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <h1>Data Paket</h1>

        <form action="" method="GET">
            <div class="con">
                <label for="resi">No.Resi :</label>
                <input type="text" class="resi" name="search" placeholder="Masukkan No.Resi" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="cari">Cari</button>
            </div>
        </form>

        <a href="paket.php" class="tambah"><i class="fa-solid fa-plus" style="color: #ffffff;"></i></a>
        <a href="index.html" class="find"><i class="fa-solid fa-house-chimney" style="color: #ffffff;"></i></a>
        <a href="logout.php" class="log">Logout</a>

        <table border="1">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>RESI</th>
                    <th>PENGIRIM</th>
                    <th>PENERIMA</th>
                    <th>ALAMAT PENERIMA</th>
                    <th>TELEPON PENERIMA</th>
                    <th>JENIS</th>
                    <th>BERAT</th>
                    <th>STATUS</th>
                    <th>KODE KONFIRMASI</th>
                    <th>BUKTI</th>
                    <th>MODIFY</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($paket) > 0): ?>
                    <?php $i = 1; foreach ($paket as $pkt) : ?>
                        <tr>
                            <td><?= htmlspecialchars($i) ?></td>
                            <td><?= htmlspecialchars($pkt["resi"]) ?></td>
                            <td><?= htmlspecialchars($pkt["pengirim"]) ?></td>
                            <td><?= htmlspecialchars($pkt["penerima"]) ?></td>
                            <td><?= htmlspecialchars($pkt["alamat"]) ?></td>
                            <td><?= htmlspecialchars($pkt["hp"]) ?></td>
                            <td><?= htmlspecialchars($pkt["jenis"]) ?></td>
                            <td><?= htmlspecialchars($pkt["berat"]) ?> KG</td>
                            <td><?= htmlspecialchars($pkt["status_paket"]) ?></td>
                            <td><?= htmlspecialchars($pkt["konfirmasi"]) ?></td>
                            <td>
                                <?php $direktori = 'bukti/'.htmlspecialchars($pkt['bukti']); ?>
                                <?php if (empty($pkt['bukti'])): ?>
                                    Bukti belum di upload
                                <?php else: ?>
                                    <a href="<?=$direktori?>" target="_blank"><img src="<?= $direktori ?>" width="100" height="100"></a>
                                <?php endif; ?>
                            </td>
                            <td class="modify">
                                <a href="EDIT.php?id=<?= urlencode($pkt['resi']) ?>"><i class="fa-solid fa-pen-to-square fa-lg" style="color: #a52a2a;"></i></a> |
                                <a href="delete.php?id=<?= urlencode($pkt['resi']) ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class="fa-solid fa-trash fa-lg" style="color: #a52a2a;"></i></a>
                            </td>
                        </tr>
                    <?php $i++; endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" style="text-align:center;">Tidak ada data paket ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
