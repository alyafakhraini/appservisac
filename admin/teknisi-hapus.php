<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_teknisi = $_GET["id"];
$query = mysqli_query($conn, "SELECT id_user FROM tbl_teknisi WHERE id_teknisi = '$id_teknisi'");
$id_user = mysqli_fetch_assoc($query)['id_user'];
$hapus_user = mysqli_query($conn, "DELETE FROM tbl_user WHERE id_user = $id_user");

$update = mysqli_query($conn, "UPDATE tbl_servis SET id_teknisi = '', status = '2', alasan ='Teknisi dihapus' WHERE id_teknisi = $id_teknisi");

$hapus_spes = mysqli_query($conn, "DELETE FROM tbl_spesialisasi WHERE id_teknisi = $id_teknisi");

$hapus_teknisi = mysqli_query($conn, "DELETE FROM tbl_teknisi WHERE id_teknisi = $id_teknisi");

if ($hapus_teknisi && $hapus_user && $update && $hapus_spes) {
    header("Location: teknisi.php");
} else {
    header("Location: teknisi.php");
}
