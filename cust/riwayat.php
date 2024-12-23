<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$id_user = $_SESSION["id_user"];
$query_cust = mysqli_query($conn, "SELECT id_cust FROM tbl_customer WHERE id_user = '$id_user'");
$id_cust = mysqli_fetch_assoc($query_cust)['id_cust'];

$result_servis = false;

if (isset($_GET["bulan"]) && isset($_GET["tahun"])) {

    $bulan = $_GET["bulan"];
    $tahun = $_GET["tahun"];
    $bulanan = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '%';

    $query_servis = mysqli_query($conn, "SELECT S.id_servis, S.tgl_servis, S.status, S.catatan, S.alasan,
                                                            C.nm_cust, C.alamat_cust, C.telp_cust,
                                                            J.id_jenis, J.biaya,
                                                            T.id_teknisi, T.nm_teknisi
                                                    FROM tbl_servis S
                                                    LEFT JOIN tbl_customer C ON S.id_cust = C.id_cust
                                                    LEFT JOIN tbl_jenis_servis J ON S.id_jenis = J.id_jenis
                                                    LEFT JOIN tbl_teknisi T ON S.id_teknisi = T.id_teknisi
                                                    WHERE C.id_cust = $id_cust
                                                    AND S.status = 4
                                                    AND S.tgl_servis LIKE '$bulanan'");
    $result_servis = mysqli_num_rows($query_servis);
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $bulanIndo[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Service History</title>
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
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
                                <h4 class="fw-semibold mb-8">Service History</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Service History</li>
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

                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3 form-inline">
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <select name="bulan" id="bulan" class="form-control" required>
                                                        <option value="">-- Pilih Bulan --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                            <option value="<?php echo $i; ?>" <?php if (isset($bulan) && $bulan == $i) echo "SELECTED"; ?>>
                                                                <?php echo getBulanIndonesia($i); ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <select name="tahun" id="tahun" class="form-control" required>
                                                        <option value="">-- Pilih Tahun --</option>
                                                        <?php
                                                        $start_year = 2023;
                                                        $end_year = date("Y", strtotime('+1 year'));
                                                        for ($i = $start_year; $i <= $end_year; $i++) : ?>
                                                            <option value="<?php echo $i; ?>" <?php if (isset($tahun) && $tahun == $i) echo "SELECTED"; ?>>
                                                                <?php echo $i; ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                <a href="riwayat.php" class="btn btn-sm btn-secondary ml-2">Reset</a>
                                            </div>
                                        </div>
                                    </form>

                                    <?php if ($result_servis == 0) { ?>
                                        <div class="alert alert-warning text-center" role="alert">
                                            Saat ini belum ada riwayat servis yang tercatat pada bulan ini. Anda dapat melihat data riwayat setelah proses servis selesai.
                                        </div>
                                </div>
                            <?php } else { ?>
                                <div class="table-responsive">
                                    <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                        <thead class="table-success">
                                            <tr>
                                                <th> No</th>
                                                <th> Tanggal Servis</th>
                                                <th> Jenis Servis</th>
                                                <th> Biaya</th>
                                                <th> Nama Customer</th>
                                                <th> Catatan</th>
                                                <th> Receipt</th>
                                                <th> Status Pengerjaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while ($row_servis = mysqli_fetch_assoc($query_servis)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td>
                                                        <?php
                                                        if (isset($row_servis["tgl_servis"])) {
                                                            $tgl_servis = $row_servis["tgl_servis"];
                                                            $timestamp = strtotime($tgl_servis);
                                                            $bulan = date("n", $timestamp);
                                                            $tahun = date("Y", $timestamp);
                                                            $tanggal = date("j", $timestamp);
                                                            echo sprintf("%02d %s %d", $tanggal, getBulanIndonesia($bulan), $tahun);
                                                        } else {
                                                            echo "Tanggal tidak tersedia";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row_servis["id_jenis"] == 1) {
                                                            echo "<div class='btn btn-sm btn-success'>Cleaning</div>";
                                                        } else if ($row_servis["status"] == 2) {
                                                            echo "<div class='btn btn-sm btn-danger'>Repair</div>";
                                                        } else if ($row_servis["status"] == 3) {
                                                            echo "<div class='btn btn-sm btn-warning'>Maintenance</div>";
                                                        } else if ($row_servis["status"] == 4) {
                                                            echo "<div class='btn btn-sm btn-primary'>Instalasi Baru</div>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo 'Rp.' . number_format($row_servis["biaya"], 0, ',', '.'); ?></td>
                                                    <td><?php echo $row_servis["nm_cust"] ?></td>
                                                    <td><?php echo $row_servis["catatan"] ?></td>
                                                    <td class="text-center">
                                                        <?php if (($row_servis["status"] == 4)) { ?>
                                                            <a href="receipt.php?id=<?php echo $row_servis["id_servis"] ?>" class="btn btn-sm btn-outline-success cat-btn" target="_blank"><i class="ti ti-print"></i>Lihat</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row_servis["status"] == 4) {
                                                            echo "<div class='btn btn-sm btn-success'>Selesai</div>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            <?php } ?>
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
    <script src="../dist/js/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../dist/js/datatable/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            var table = $('#example2').DataTable({
                lengthChange: false,
                pageLength: 20,
                order: [1, 'asc'],
                scrollX: true
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>

</body>

</html>