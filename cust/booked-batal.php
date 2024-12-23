<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$id_servis = $_GET["id"];
$batal_cust = $_GET["batal_cust"];

$confirm = mysqli_query($conn, "UPDATE tbl_servis SET status = '2', batal_cust = '$batal_cust', alasan = 'Customer membatalkan pesanan' WHERE id_servis = '$id_servis'");

if ($confirm) {
    header("Location: booked.php");
} else {
    header("Location: servis-batal.php?id=$id_servis");
}
