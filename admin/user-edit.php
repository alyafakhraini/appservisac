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
$result_user = mysqli_query($conn, "SELECT * FROM tbl_user WHERE id_user = $id_user");
$row_user = mysqli_fetch_assoc($result_user);
$foto_lama = $row_user["foto"];

if (isset($_POST["submit"])) {
    $level = $_POST["level"];
    $status = $_POST["status"];

    $simpan = mysqli_query($conn, "UPDATE tbl_user SET level = '$level' WHERE id_user = $id_user");

    if ($simpan) {
        header("Location: user.php");
    } else {
        header("Location: user-edit.php?id=$id_user");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Data Pengguna</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="SERASI" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../dist/images/logos/favicon.png" />
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="../dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
</head>

<body style="background-color: #a8dadc;">

    <!-- Preloader -->
    <?php include "theme-preload.php" ?>
    <!-- Body Wrapper -->

    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Header Start -->
        <?php include "theme-header.php" ?>
        <!-- Header End -->

        <!-- Sidebar Start -->
        <?php include "theme-menu.php" ?>
        <!-- Sidebar End -->

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <div class="container-fluid">

                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-1">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Edit Data Pengguna</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="user.php">Manajemen Pengguna</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Data Pengguna</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-3">
                                <div class="text-center mb-n5">
                                    <img src="../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="datatables">
                    <!-- basic table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Data Pengguna</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="username" class="form-label mb-0 me-2">Username :</label>
                                            <span><strong><?php echo $row_user["username"] ?></strong></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="level" class="form-label">Level :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="level" id="level" class="form-control">
                                                        <option value="1" <?php if ($row_user["level"] == 1) echo "SELECTED"; ?>>Admin</option>
                                                        <option value="2" <?php if ($row_user["level"] == 2) echo "SELECTED"; ?>>Teknisi</option>
                                                        <option value="3" <?php if ($row_user["level"] == 3) echo "SELECTED"; ?>>Customer</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="aktif" <?php if ($row_user["status"] == "aktif") echo "SELECTED"; ?>>Aktif</option>
                                                        <option value="pending" <?php if ($row_user["status"] == "pending") echo "SELECTED"; ?>>Pending</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="user.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="dark-transparent sidebartoggler"></div>
    </div>

    <!-- theme setting -->

    <!-- end theme setting -->
    <!-- Import Js Files -->
    <script src="../dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="../dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- core files -->
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/app.horizontal.init.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.js"></script>
    <!-- current page js files -->
</body>

</html>