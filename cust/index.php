<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$query_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis");
$result_jenis = mysqli_num_rows($query_jenis);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Dashboard</title>
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
    <!-- Data Table -->
    <link rel="stylesheet" href="../dist/js/datatable/css/dataTables.bootstrap5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                                <h4 class="fw-semibold mb-8">SERASI's Service</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
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

                <!-- Dashboard Overview -->
                <div class="row">
                    <!-- Card Services -->
                    <?php while ($row_jenis = mysqli_fetch_assoc($query_jenis)) { ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <h3 class="card-title font-weight-bold text-primary"><?php echo $row_jenis["nm_servis"] ?></h3>
                                    <div class="my-3">
                                        <img src="../dist/images/services/<?php echo $row_jenis["gambar"] ?>" alt="<?php echo $row_jenis["nm_servis"] ?>" class="img-fluid rounded" style="height: 130px; object-fit: cover;">
                                    </div>
                                    <p class="text-muted small"><?php echo $row_jenis["deskripsi"] ?></p>
                                    <a href="pesan.php?id_jenis=<?php echo $row_jenis['id_jenis']; ?>"" class=" btn btn-sm btn-outline-primary mt-2">Book Service</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>



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
    <script src="../dist/js/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../dist/js/datatable/js/dataTables.bootstrap5.min.js"></script>

</body>

</html>