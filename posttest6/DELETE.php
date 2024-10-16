<?php
    require "koneksi.php";

    $resi = $_GET["id"];

    $result = mysqli_query($conn, "DELETE FROM paket WHERE resi = '$resi'");

    if ($result){
        echo"
        <script>
        alert('Data Berhasil Dihapus');
        window.location.href='DATA.php';
        </script>";
    }
?>