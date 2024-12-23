<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_spes = $_GET["id"];

$hapus = mysqli_query($conn, "DELETE FROM tbl_spesialisasi WHERE id_spes = '$id_spes'");

if ($hapus) {
    header("Location: spes.php");
} else {
    header("Location: spes.php");
}
