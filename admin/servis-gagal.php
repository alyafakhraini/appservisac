<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_servis = $_GET["id"];
$gagal_pem = $_GET["gagal_pem"];

$confirm = mysqli_query($conn, "UPDATE tbl_servis SET status_pem = 'failed', gagal_pem = '$gagal_pem' WHERE id_servis = '$id_servis'");

if ($confirm) {
    header("Location: servis.php");
} else {
    header("Location: servis-gagal.php?id=$id_servis");
}
