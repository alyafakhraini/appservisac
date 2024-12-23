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

// Cari id_cust
$result_cust = mysqli_query($conn, "SELECT id_cust, id_jenis FROM tbl_servis WHERE id_servis = '$id_servis'");
$row_cust = mysqli_fetch_assoc($result_cust);
$id_cust = $row_cust['id_cust'];
$id_jenis = $row_cust['id_jenis'];

// Cari wilayah_cust
$result_wilayah_cust = mysqli_query($conn, "SELECT wilayah_cust FROM tbl_customer WHERE id_cust = '$id_cust'");
$row_wilayah_cust = mysqli_fetch_assoc($result_wilayah_cust);
$wilayah_cust = $row_wilayah_cust['wilayah_cust'];

// Cari teknisi berdasarkan wilayah_cust
$result_teknisi = mysqli_query($conn, "SELECT T.id_teknisi
                                                     FROM tbl_teknisi T
                                                     LEFT JOIN tbl_spesialisasi S ON T.id_teknisi = S.id_teknisi
                                                     WHERE T.wilayah_teknisi = '$wilayah_cust'
                                                     AND S.id_jenis = '$id_jenis'");
$row_teknisi = mysqli_fetch_assoc($result_teknisi);
$id_teknisi_baru = $row_teknisi['id_teknisi'];

if ($id_teknisi_baru == 0) {
    // Update status jika id_teknisi_baru adalah 0
    $confirm = mysqli_query($conn, "UPDATE tbl_servis SET status = '2' WHERE id_servis = '$id_servis'");
} else {
    // Update teknisi jika id_teknisi_baru tidak 0
    $confirm = mysqli_query($conn, "UPDATE tbl_servis SET id_teknisi = '$id_teknisi_baru', status = '', alasan = '' WHERE id_servis = '$id_servis'");
}
if ($confirm) {
    header("Location: servis.php");
} else {
    header("Location: servis.php");
}
