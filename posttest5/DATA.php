<?php
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }

    require "koneksi.php";
    $sql = mysqli_query($conn, "SELECT * FROM paket");

    $paket = [];

    while ($row = mysqli_fetch_assoc($sql)) {
        $paket[] = $row;
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
    <h1>Data Paket</h1>
    <br><br>
    <a href="paket.php" class="tambah">+</a>
    <a href="logout.php" class="logout">Logout</a>
    <table border = 1>
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
                <th>MODIFY</th>
            </tr>
        </thead>
        <tbody>
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
                    <td class="modify">
                        <a href="EDIT.php?id=<?= urlencode($pkt['resi']) ?>"><i class="fa-solid fa-pen-to-square fa-lg" style="color: #ffffff;"></i></a> |
                        <a href="delete.php?id=<?= urlencode($pkt['resi']) ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class="fa-solid fa-trash fa-lg" style="color: #ffffff;"></i></a>
                    </td>
                </tr>
            <?php $i++; endforeach ?>
        </tbody>
    </table>
</body>
</html>
