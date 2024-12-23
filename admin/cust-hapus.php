<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_cust = $_GET["id"];

$hapus = mysqli_query($conn, "DELETE FROM tbl_customer WHERE id_cust = $id_cust");

if ($hapus) {
    header("Location: cust.php");
} else {
    header("Location: cust-hapus.php?id=$id_cust");
}
