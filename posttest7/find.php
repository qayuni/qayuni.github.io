<?php
    require "koneksi.php";

    $paket = [];
    $error_message = "";

    if (isset($_GET["search"]) && isset($_GET["konfir"])) {
        $search = $_GET["search"];
        $konfir = $_GET["konfir"];

        $sql = mysqli_query($conn, "SELECT * FROM paket WHERE resi = '$search' AND konfirmasi = '$konfir'");

        while ($row = mysqli_fetch_assoc($sql)) {
            $paket[] = $row;
        }

        if (count($paket) === 0) {
            $error_message = "Nomor resi atau kode konfirmasi tidak sesuai.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEK RESI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap');
        body {
            font-family: Saira, Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .cek{
            margin : 0 0 5px 5px;
            font-weight : 600;
            color : brown;
        }
        .finded{
            width: 80%;
            background-color : rgb(228, 103, 103);
            border-radius : 18px;
            margin-left : auto;
            margin-right : auto;
            padding : 10px;
            justify-content : center;
            align-content : center;
        }
        .nofin {
            color : white;
            font-weight : 600;
        }
        .container {
            width: 20%;
            margin: 5% auto;
            padding: 10px 0 10px 20px;
            display : flex;
            background-color : white;
            border-radius: 12px;
        }
        .resi{
            width: 50%;
            padding : 5px 10px;
            border-radius : 8px;
            box-shadow : 0 0 0 3px rgba(0,0,0,0.1);
            color : brown;
            font-weight : 600;
            border-color : wheat;
            background-color: rbga (0,0,0,0.1);
        }
        .find{
            padding : 5px 10px;
            border-radius : 8px;
            color : brown;
            background-color : white;
            font-weight :600;
            border-color : wheat;
            margin-top : 10px;
        }
        .balik {
            display: inline-block;
            padding: 0px 8px;
            background-color: brown;
            border-radius: 50px;
            margin-left: 5px;
            margin-right: auto;
            margin-left : 50%
        }
        .balik:hover{
            background-color: rgb(227, 40, 40);
        }
        label {
            font-size: 12px;
            color : brown;
            font-weight : 600;
        }
        table {
            border-color: brown;
            background-color: white;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            margin-bottom : 5%;
        }
        th {
            padding: 8px;
            color: white;
            background-color: brown;
        }
        td {
            padding: 5px;
            color: brown;
            font-weight: 500;
        }
    </style>
    <script>
        <?php if (!empty($error_message)): ?>
            alert("<?= $error_message ?>");
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="finded">
        <div class ="container">
            <form action="" method ="get">
                <p class="cek">CEK RESI</p>
                <label for="resi">No.Resi :</label><br>
                <input type="text" class="resi" name="search" placeholder="Masukkan No.Resi" required><br>
                <label for="konfir">Kode Konfirmasi :</label><br>
                <input type="text" class="resi" name="konfir" placeholder="Masukkan Kode Konfirmasi" required><br>
                <button type="submit" name="submit" class="find">Cari</button>
                <a href="index.html" class="balik"><i class="fa-solid fa-house-chimney" style="color: #ffffff;"></i></a>
            </form>
        </div>
    <?php if (isset($_GET["search"]) && count($paket) > 0): ?>
        <div class="finded">
            <table border = 1>
                <tbody>
                    <?php foreach ($paket as $pkt): ?>
                        <tr>
                            <th>RESI</th>
                            <td><?= htmlspecialchars($pkt["resi"]) ?></td>
                        </tr>
                        <tr>
                            <th>PENGIRIM</th>
                            <td><?= htmlspecialchars($pkt["pengirim"]) ?></td>
                        </tr>
                        <tr>
                            <th>PENERIMA</th>
                            <td><?= htmlspecialchars($pkt["penerima"]) ?></td>
                        </tr>
                        <tr>
                            <th>ALAMAT PENERIMA</th>
                            <td><?= htmlspecialchars($pkt["alamat"]) ?></td>
                        </tr>
                        <tr>
                            <th>TELEPON PENERIMA</th>
                            <td><?= htmlspecialchars($pkt["hp"]) ?></td>
                        </tr>
                        <tr>
                            <th>JENIS</th>
                            <td><?= htmlspecialchars($pkt["jenis"]) ?></td>
                        </tr>
                        <tr>
                            <th>BERAT</th>
                            <td><?= htmlspecialchars($pkt["berat"]) ?> KG</td>
                        </tr>
                        <tr>
                            <th>STATUS</th>
                            <td><?= htmlspecialchars($pkt["status_paket"]) ?></td>
                        </tr>
                        <tr>
                            <th>BUKTI</th>
                            <td>
                                <?php $direktori = 'bukti/' . $pkt['bukti']; ?>
                                <?php if ($pkt['bukti'] == ""): ?>
                                    Bukti belum diupload
                                <?php else: ?>
                                    <a href="<?= $direktori ?>" target ="_blank">
                                        <img src="<?= $direktori ?>" width="100" height="100">
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    </div>
</body>
</html>