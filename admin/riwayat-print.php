<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$bulanan = isset($_GET['bulanan']) ? $_GET['bulanan'] : '';

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
                                                    WHERE S.status = 4
                                                    AND S.tgl_servis LIKE '$bulanan'");
$result_servis = mysqli_num_rows($query_servis);


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
    <title>SERASI - Data Servis Selesai</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="SERASI" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../dist/images/logos/favicon.png" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
    <style>
        .table-responsive {
            overflow: visible;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>

    <!-- Body Wrapper -->

    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <div class="container-fluid">

                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-1">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Data Servis Selesai</h4>
                            </div>
                            <div class="col-3">
                                <div class="text-center mb-n5">
                                    <img src="../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- basic table -->
                <div class="row">
                    <div class="col-12">

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
    </div>

</body>

</html>