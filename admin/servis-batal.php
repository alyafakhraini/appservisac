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

$hapus = mysqli_query($conn, "DELETE FROM tbl_servis WHERE id_servis = $id_servis");

if ($hapus) {
    header("Location: servis.php");
} else {
    header("Location: servis-batal.php?id=$id_servis");
}
