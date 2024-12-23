<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 2) {
    header("Location: logout.php");
}

$id_servis = $_GET["id_servis"];
$catatan = $_GET["catatan"];

$confirm = mysqli_query($conn, "UPDATE tbl_servis SET status = '4', catatan = '$catatan' WHERE id_servis = '$id_servis'");

if ($confirm) {
    header("Location: index.php");
} else {
    header("Location: servis-catatan.php?id=$id_servis");
}
