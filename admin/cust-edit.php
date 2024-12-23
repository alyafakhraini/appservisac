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
$result_cust = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE id_cust = $id_cust");
$row_cust = mysqli_fetch_assoc($result_cust);

if (isset($_POST["submit"])) {
    $nm_cust = $_POST["nm_cust"];
    $alamat_cust = $_POST["alamat_cust"];
    $wilayah_cust = $_POST["wilayah_cust"];
    $telp_cust = $_POST["telp_cust"];
    $email_cust = $_POST["email_cust"];

    $simpan = mysqli_query($conn, "UPDATE tbl_customer SET nm_cust = '$nm_cust', alamat_cust = '$alamat_cust', wilayah_cust = '$wilayah_cust', telp_cust = '$telp_cust', email_cust = '$email_cust' WHERE id_cust = $id_cust");

    if ($simpan) {
        header("Location: cust.php");
    } else {
        header("Location: cust-edit.php?id=$id_cust");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Data Customer</title>
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
                                <h4 class="fw-semibold mb-8">Edit Data Customer</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="cust.php">Customer</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Data Customer</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit Data Customer pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nm_cust" class="form-label">Nama Customer :</label>
                                            <input type="text" class="form-control" name="nm_cust" id="nm_cust" value="<?php echo $row_cust["nm_cust"] ?>" placeholder="Masukkan Nama Pengguna" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_cust" class="form-label">Alamat Lengkap :</label>
                                            <input type="text" class="form-control" name="alamat_cust" id="alamat_cust" value="<?php echo $row_cust["alamat_cust"] ?>" placeholder="Masukkan Alamat Customer" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wilayah_cust" class="form-label">Wilayah :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="wilayah_cust" id="wilayah_cust" class="form-control">
                                                        <option value="">--Piih Kecamatan--</option>
                                                        <option value="1" <?php if ($row_cust["wilayah_cust"] == 1) echo "SELECTED"; ?>>Banjarmasin Utara</option>
                                                        <option value="2" <?php if ($row_cust["wilayah_cust"] == 2) echo "SELECTED"; ?>>Banjarmasin Barat</option>
                                                        <option value="3" <?php if ($row_cust["wilayah_cust"] == 3) echo "SELECTED"; ?>>Banjarmasin Tengah</option>
                                                        <option value="4" <?php if ($row_cust["wilayah_cust"] == 4) echo "SELECTED"; ?>>Banjarmasin Timur</option>
                                                        <option value="5" <?php if ($row_cust["wilayah_cust"] == 5) echo "SELECTED"; ?>>Banjarmasin Selatan</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telp_cust" class="form-label">Nomor Telepon :</label>
                                            <input type="number" class="form-control" name="telp_cust" id="telp_cust" value="<?php echo $row_cust["telp_cust"] ?>" placeholder="Masukkan Nomor Telepon Customer" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_cust" class="form-label">Email :</label>
                                            <input type="text" class="form-control" name="email_cust" id="email_cust" value="<?php echo $row_cust["email_cust"] ?>" placeholder="Masukkan Email Customer" required>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="cust.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
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