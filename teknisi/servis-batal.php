<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 2) {
    header("Location: logout.php");
}

$id_servis = $_GET["id"];
$alasan = $_GET["alasan"];

$confirm = mysqli_query($conn, "UPDATE tbl_servis SET status = '2', alasan = '$alasan' WHERE id_servis = '$id_servis'");

if ($confirm) {
    header("Location: index.php");
} else {
    header("Location: servis-batal.php?id=$id_servis");
}
