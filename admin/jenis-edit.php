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
$result_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis WHERE id_jenis = $id_jenis");
$row_jenis = mysqli_fetch_assoc($result_jenis);
$gambar_lama = $row_jenis["gambar"];

if (isset($_POST["submit"])) {
    $nm_servis = $_POST["nm_servis"];
    $deskripsi = $_POST["deskripsi"];
    $biaya = $_POST["biaya"];
    $durasi = $_POST["durasi"];
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = $_FILES["gambar"]["name"];
    }
    $upload = move_uploaded_file($_FILES['gambar']['tmp_name'], '../dist/images/services/' . $gambar);

    $simpan = mysqli_query($conn, "UPDATE tbl_jenis_servis SET nm_servis = '$nm_servis', deskripsi = '$deskripsi', biaya = '$biaya', durasi = '$durasi', gambar = '$gambar' WHERE id_jenis = $id_jenis");

    if ($simpan) {
        header("Location: jenis.php");
    } else {
        header("Location: jenis-edit.php?id=$id_jenis");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Jenis Servis</title>
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
                                <h4 class="fw-semibold mb-8">Edit Jenis Servis</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="jenis.php">Jenis Servis</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Jenis Servis</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Jenis Servis</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nm_servis" class="form-label">Servis :</label>
                                            <input type="text" class="form-control" name="nm_servis" id="nm_servis" value="<?php echo $row_jenis["nm_servis"] ?>" placeholder="Masukkan Jenis Servis" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi :</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" placeholder="Masukkan deskripsi singkat mengenai servis"><?php echo $row_jenis["deskripsi"] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="biaya" class="form-label">Biaya :</label>
                                            <input type="number" class="form-control" name="biaya" id="biaya" value="<?php echo $row_jenis["biaya"] ?>" placeholder="Masukkan biaya servis" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="durasi" class="form-label">Durasi Pengerjaan :</label>
                                            <input type="text" class="form-control" name="durasi" id="durasi" value="<?php echo $row_jenis["durasi"] ?>" placeholder="Masukkan durasi pengerjaan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar_lama" class="form-label">Image Lama :</label><br>
                                            <img src="../dist/images/services/<?php echo $row_jenis["gambar"] ?>" width="200" height="130" alt="" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label">Upload Image Baru :</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar">
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="jenis.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
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