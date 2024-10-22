<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['username'] !== "user") {
        header("Location: DATA.php");
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
    <link rel="stylesheet" href="USER.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class ="container">
        <h1>Data Paket</h1>
        <br>
        <a href="paket.php" class="tambah"><i class="fa-solid fa-plus" style="color: #ffffff;"></i></a>
        <a href="index.html" class="find"><i class="fa-solid fa-house-chimney" style="color: #ffffff;"></i></a>
        <a href="find.php" class="find"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></a>
        <a href="logout.php" class="log">Logout</a>
        <table border = 1>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>RESI</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($paket as $pkt) : ?>
                    <tr>
                        <td><?= htmlspecialchars($i) ?></td>
                        <td><?= htmlspecialchars($pkt["resi"]) ?></td>
                        <td><?= htmlspecialchars($pkt["status_paket"]) ?></td>
                    </tr>
                <?php $i++; endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
