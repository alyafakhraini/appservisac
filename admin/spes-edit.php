<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_spes = $_GET["id"];
$result_spes = mysqli_query($conn, "SELECT * FROM tbl_spesialisasi WHERE id_spes = $id_spes");
$row_spes = mysqli_fetch_assoc($result_spes);

if (isset($_POST["submit"])) {
    $id_teknisi = $_POST["id_teknisi"];
    $id_jenis = $_POST["id_jenis"];

    $simpan = mysqli_query($conn, "UPDATE tbl_spesialisasi SET id_teknisi = '$id_teknisi', id_jenis = '$id_jenis' WHERE id_spes = $id_spes");

    if ($simpan) {
        header("Location: spes.php");
    } else {
        header("Location: spes-edit.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Spesialisasi Teknisi</title>
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
                                <h4 class="fw-semibold mb-8">Edit Spesialisasi Teknisi</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="spes.php">Spesialisasi Teknisi</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Spesialisasi Teknisi</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Spesialisasi Teknisi</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="id_spes" class="form-label">Nama Teknisi :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="id_teknisi" id="id_teknisi" class="form-control" required>
                                                        <option value="">-- Pilih Teknisi --</option>
                                                        <?php
                                                        $result_teknisi = mysqli_query($conn, "SELECT * FROM tbl_teknisi");
                                                        while ($row_teknisi = mysqli_fetch_assoc($result_teknisi)) {
                                                            $selected = ($row_spes['id_teknisi'] == $row_teknisi['id_teknisi']) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $row_teknisi["id_teknisi"]; ?>" <?php echo $selected; ?>>
                                                                <?php echo $row_teknisi["nm_teknisi"]; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_jenis" class="form-label">Spesialisasi :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="id_jenis" id="id_jenis" class="form-control" required>
                                                        <option value="">-- Pilih Spesialisasi --</option>
                                                        <?php
                                                        $result_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis");
                                                        while ($row_jenis = mysqli_fetch_assoc($result_jenis)) {
                                                            $selected = ($row_spes['id_jenis'] == $row_jenis['id_jenis']) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $row_jenis["id_jenis"]; ?>" <?php echo $selected; ?>>
                                                                <?php echo $row_jenis["nm_servis"]; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="spes.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
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