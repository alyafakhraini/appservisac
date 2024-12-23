<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_servis = $_GET["id"];
$result_servis = mysqli_query($conn, "SELECT * FROM tbl_servis WHERE id_servis = $id_servis");
$row_servis = mysqli_fetch_assoc($result_servis);
$bukpem_lama = $row_servis["bukpem"];

if (isset($_POST["submit"])) {
    $id_cust = $_POST["id_cust"];
    $id_jenis = $_POST["id_jenis"];
    $tgl_servis = $_POST["tgl_servis"];
    $status = $_POST["status"];
    $catatan = $_POST["catatan"];
    if ($_FILES['bukpem']['error'] === 4) {
        $bukpem = $bukpem_lama;
    } else {
        $bukpem = $_FILES["bukpem"]["name"];
    }
    $upload = move_uploaded_file($_FILES['bukpem']['tmp_name'], '../bukpem/' . $bukpem);

    $simpan = mysqli_query($conn, "UPDATE tbl_servis SET id_cust = '$id_cust', id_jenis = '$id_jenis', id_servis = '$id_servis', tgl_servis = '$tgl_servis', bukpem = '$bukpem', status = '$status', catatan = '$catatan' WHERE id_servis = $id_servis");

    if ($simpan) {
        header("Location: servis.php");
    } else {
        header("Location: servis-edit.php?id=$id_servis");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Data Servis</title>
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
                                <h4 class="fw-semibold mb-8">Edit Data Servis</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a class="text-muted " href="servis.php">Data Servis</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Data Servis</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Data Servis</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="id_cust" class="form-label">Nama Customer :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <?php
                                                    $selected_cust = $row_servis["id_cust"];
                                                    ?>
                                                    <select name="id_cust" id="id_cust" class="form-control" required>
                                                        <option value="">-- Pilih Customer --</option>
                                                        <?php
                                                        $result_cust = mysqli_query($conn, "SELECT * FROM tbl_customer");
                                                        while ($row_cust = mysqli_fetch_assoc($result_cust)) {
                                                            $selected = ($row_cust["id_cust"] == $selected_cust) ? "selected" : "";
                                                        ?>
                                                            <option value="<?php echo $row_cust["id_cust"] ?>" <?php echo $selected; ?>>
                                                                <?php echo $row_cust["nm_cust"] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="tgl_servis" class="form_label">Tanggal Servis :</label>
                                            <input type="date" class="form-control" id="tgl_servis" value="<?php echo $row_servis["tgl_servis"] ?>" name="tgl_servis" rows="3" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_jenis" class="form-label">Jenis Servis :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <?php
                                                    $selected_jenis = $row_servis["id_jenis"];
                                                    ?>
                                                    <select name="id_jenis" id="id_jenis" class="form-control" required>
                                                        <option value="">-- Pilih Jenis Servis --</option>
                                                        <?php
                                                        $result_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis");
                                                        while ($row_jenis = mysqli_fetch_assoc($result_jenis)) {
                                                            $selected = ($row_jenis["id_jenis"] == $selected_jenis) ? "selected" : "";
                                                        ?>
                                                            <option value="<?php echo $row_jenis["id_jenis"] ?>" <?php echo $selected; ?>>
                                                                <?php echo $row_jenis["nm_servis"] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bukpem_lama" class="form-label">Bukti Pembayaran Lama :</label><br>
                                            <img src="../bukpem/<?php echo $row_servis["bukpem"] ?>" style="max-height: 200px; object-fit: cover;" alt="" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="bukpem" class="form-label">Upload Bukti Pembayaran Baru :</label>
                                            <input type="file" class="form-control" name="bukpem" id="bukpem">
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status Pengerjaan :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="status" id="status" class="form-control" required>
                                                        <option value="">--Piih Status Pengerjaan--</option>
                                                        <option value="1" <?php if ($row_servis["status"] == 1) echo "SELECTED"; ?>>Order Diproses</option>
                                                        <option value="2" <?php if ($row_servis["status"] == 2) echo "SELECTED"; ?>>Pending</option>
                                                        <option value="3" <?php if ($row_servis["status"] == 3) echo "SELECTED"; ?>>Booked</option>
                                                        <option value="4" <?php if ($row_servis["status"] == 4) echo "SELECTED"; ?>>Selesai</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="catatan" class="form-label">Catatan :</label>
                                            <textarea name="catatan" id="catatan" class="form-control" rows="5"><?php echo $row_servis["catatan"] ?></textarea>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="servis.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
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