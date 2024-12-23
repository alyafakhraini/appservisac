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
$result_teknisi = mysqli_query($conn, "SELECT * FROM tbl_teknisi WHERE id_teknisi = $id_teknisi");
$row_teknisi = mysqli_fetch_assoc($result_teknisi);

if (isset($_POST["submit"])) {
    $nm_teknisi = $_POST["nm_teknisi"];
    $telp_teknisi = $_POST["telp_teknisi"];
    $alamat_teknisi = $_POST["alamat_teknisi"];
    $wilayah_teknisi = $_POST["wilayah_teknisi"];

    $simpan = mysqli_query($conn, "UPDATE tbl_teknisi SET nm_teknisi = '$nm_teknisi', alamat_teknisi = '$alamat_teknisi', wilayah_teknisi = '$wilayah_teknisi', telp_teknisi = '$telp_teknisi' WHERE id_teknisi = $id_teknisi");

    if ($simpan) {
        header("Location: teknisi.php");
    } else {
        header("Location: teknisi-edit.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Data Teknisi</title>
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
                                <h4 class="fw-semibold mb-8">Edit Data Teknisi</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="teknisi.php">Teknisi</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Data Teknisi</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Data Teknisi</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nm_teknisi" class="form-label">Nama Teknisi :</label>
                                            <input type="text" class="form-control" name="nm_teknisi" id="nm_teknisi" value="<?php echo $row_teknisi["nm_teknisi"] ?>" placeholder="Masukkan Nama Teknisi" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telp_teknisi" class="form-label">Nomor Telepon :</label>
                                            <input type="number" class="form-control" name="telp_teknisi" id="telp_teknisi" value="<?php echo $row_teknisi["telp_teknisi"] ?>" placeholder="Masukkan Nomor Telepon Teknisi" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_teknisi" class="form-label">Alamat Lengkap :</label>
                                            <textarea class="form-control" name="alamat_teknisi" id="alamat_teknisi" rows="5" placeholder="Masukkan Alamat Teknisi" required><?php echo $row_teknisi["alamat_teknisi"] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wilayah_teknisi" class="form-label">Wilayah :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="wilayah_teknisi" id="wilayah_teknisi" class="form-control">
                                                        <option value="">--Piih Kecamatan--</option>
                                                        <option value="1" <?php if ($row_teknisi["wilayah_teknisi"] == 1) echo "SELECTED"; ?>>Banjarmasin Utara</option>
                                                        <option value="2" <?php if ($row_teknisi["wilayah_teknisi"] == 2) echo "SELECTED"; ?>>Banjarmasin Barat</option>
                                                        <option value="3" <?php if ($row_teknisi["wilayah_teknisi"] == 3) echo "SELECTED"; ?>>Banjarmasin Tengah</option>
                                                        <option value="4" <?php if ($row_teknisi["wilayah_teknisi"] == 4) echo "SELECTED"; ?>>Banjarmasin Timur</option>
                                                        <option value="5" <?php if ($row_teknisi["wilayah_teknisi"] == 5) echo "SELECTED"; ?>>Banjarmasin Selatan</option>
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