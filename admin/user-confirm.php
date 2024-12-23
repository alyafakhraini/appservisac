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

$confirm = mysqli_query($conn, "UPDATE tbl_user SET status = 'aktif' WHERE id_user = '$id_user'");

if ($confirm) {
    header("Location: user.php");
} else {
    header("Location: user-hapus.php?id=$id_user");
}
