<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_jenis = $_GET["id"];

$hapus = mysqli_query($conn, "DELETE FROM tbl_jenis_servis WHERE id_jenis = $id_jenis");

if ($hapus) {
    header("Location: jenis.php");
} else {
    header("Location: jenis-hapus.php?id=$id_jenis");
}
