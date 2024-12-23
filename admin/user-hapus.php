<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_user = $_GET["id"];

// Cek apakah ada id_teknisi terkait dengan id_user
$query = mysqli_query($conn, "SELECT id_teknisi FROM tbl_teknisi WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($query);
$id_teknisi = mysqli_fetch_assoc($query)['id_teknisi'];

if ($row) {
    // Jika ada, hapus dari tbl_teknisi terlebih dahulu
    $hapus_teknisi = mysqli_query($conn, "DELETE FROM tbl_teknisi WHERE id_user = '$id_user'");

    $update = mysqli_query($conn, "UPDATE tbl_servis SET id_teknisi = '', status = '2', alasan ='Teknisi dihapus' WHERE id_teknisi = $id_teknisi");

    $hapus_spes = mysqli_query($conn, "DELETE FROM tbl_spesialisasi WHERE id_teknisi = $id_teknisi");
}

// Hapus dari tbl_user
$hapus_user = mysqli_query($conn, "DELETE FROM tbl_user WHERE id_user = '$id_user'");

if ($hapus_user) {
    header("Location: user.php");
} else {
    header("Location: user.php");
}
