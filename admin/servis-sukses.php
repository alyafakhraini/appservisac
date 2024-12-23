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

$confirm = mysqli_query($conn, "UPDATE tbl_servis SET status = '1', status_pem = 'confirmed' WHERE id_servis = '$id_servis'");

if ($confirm) {
    header("Location: servis.php");
} else {
    header("Location: servis-sukses.php?id=$id_servis");
}
