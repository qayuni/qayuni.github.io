<?php
include 'koneksi.php';

if (isset($_GET['id']) || isset($_GET['ISBN'])) {
    $condition = isset($_GET['id']) ? "id = " . intval($_GET['id']) : "ISBN = '" . mysqli_real_escape_string($conn, $_GET['ISBN']) . "'";
    $query = "DELETE FROM buku WHERE $condition";
    mysqli_query($conn, $query);
}

header("Location: bukuadmin.php");
exit();
?>
