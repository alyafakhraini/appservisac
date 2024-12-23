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

$query_nmcust = mysqli_query($conn, "SELECT nm_cust FROM tbl_customer WHERE id_cust = '$id_cust'");
$nm_cust = mysqli_fetch_assoc($query_nmcust)['nm_cust'];

$query_servis = mysqli_query($conn, "SELECT S.id_servis, S.id_cust, S.tgl_servis, S.status, S.catatan, S.gagal_pem, S.status_pem,
                                                            J.nm_servis, J.biaya,
                                                            T.id_teknisi, T.nm_teknisi, T.telp_teknisi
                                                    FROM tbl_servis S
                                                    LEFT JOIN tbl_jenis_servis J ON S.id_jenis = J.id_jenis
                                                    LEFT JOIN tbl_teknisi T ON S.id_teknisi = T.id_teknisi
                                                    WHERE S.id_cust = $id_cust
                                                    AND S.status != 4");
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
    <title>SERASI - Detail Pesanan</title>
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
                                <h4 class="fw-semibold mb-8">Detail Pesanan - <?php echo $nm_cust; ?></h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Detail Pesanan</li>
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
                                    <p class="card-subtitle mb-3"><b>Jasa Servis yang sudah dipesan tidak bisa dibatalkan H-1 dari Tanggal Servis</b></p>
                                    <?php if ($result_servis == 0) { ?>
                                        <div class="alert alert-warning text-center" role="alert">
                                            Saat ini belum ada pemesanan Jasa Servis AC SERASI. Klik <a href="index.php" class="text-decoration-none">Pesan Sekarang!</a> untuk melakukan pemesanan Jasa Servis.
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                            <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th> Status Order</th>
                                                        <th> Tanggal Servis</th>
                                                        <th> Jenis Servis</th>
                                                        <th> Biaya</th>
                                                        <th> Nama Teknisi</th>
                                                        <th> Nomor Telepon Teknisi</th>
                                                        <th> Receipt</th>
                                                        <th> Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_servis = mysqli_fetch_assoc($query_servis)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php if ($row_servis["status"] == 1) { ?>
                                                                    <a href="#" class="btn btn-sm btn-primary"><i class="ti ti-calendar-event"></i> Booked</a>
                                                                    <a href="#" class="btn btn-sm btn-warning cancel-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>" data-tgl_servis="<?php echo $row_servis["tgl_servis"]; ?>"><i class="ti ti-close"></i> Cancel</a>
                                                                <?php } else if ($row_servis["status"] == 2) { ?>
                                                                    <a href="#" class="btn btn-sm btn-danger"><i class="ti ti-clock"></i> Pending</a>
                                                                    <a href="#" class="btn btn-sm btn-warning cancel-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>" data-tgl_servis="<?php echo $row_servis["tgl_servis"]; ?>"><i class="ti ti-close"></i> Cancel</a>
                                                                <?php } else if ($row_servis["status"] == 3) { ?>
                                                                    <a href="#" class="btn btn-sm btn-primary"><i class="ti ti-calendar-event"></i> Booked</a>
                                                                    <a href="#" class="btn btn-sm btn-warning cancel-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>" data-tgl_servis="<?php echo $row_servis["tgl_servis"]; ?>"><i class="ti ti-close"></i> Cancel</a>
                                                                <?php } else if ($row_servis["status"] == 4) { ?>
                                                                    <a href="#" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Selesai</a>
                                                                <?php } else if ($row_servis["status_pem"] == 'failed') { ?>
                                                                    <a href="#" class="btn btn-sm btn-danger failed-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>" data-gagal_pem="<?php echo $row_servis["gagal_pem"]; ?>"><i class="fas fa-times-circle"></i> Pembayaran Gagal</a>
                                                                <?php } else { ?>
                                                                    <a href="#" class="btn btn-sm btn-primary"><i class="ti ti-calendar-event"></i> Booked</a>
                                                                    <a href="#" class="btn btn-sm btn-warning cancel-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>" data-tgl_servis="<?php echo $row_servis["tgl_servis"]; ?>"><i class="ti ti-close"></i> Cancel</a>
                                                                <?php } ?>
                                                            </td>
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
                                                            <td><?php echo $row_servis["nm_servis"] ?></td>
                                                            <td><?php echo 'Rp.' . number_format($row_servis["biaya"], 0, ',', '.'); ?></td>
                                                            <td><?php echo $row_servis["nm_teknisi"] ?></td>
                                                            <td><?php echo $row_servis["telp_teknisi"] ?></td>
                                                            <td class="text-center">
                                                                <?php if (($row_servis["status_pem"] == "confirmed")) { ?>
                                                                    <a href="receipt.php?id=<?php echo $row_servis["id_servis"] ?>" class="btn btn-sm btn-outline-success cat-btn" target="_blank"><i class="ti ti-print"></i>Lihat</a>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $row_servis["catatan"] ?></td>
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

            // SweetAlert Cancel
            $('.cancel-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');
                var tgl_servis = $(this).data('tgl_servis'); // Ambil langsung dari data-tgl_servis

                var servisDate = new Date(tgl_servis);
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Hapus waktu dari tanggal hari ini

                var oneDay = 24 * 60 * 60 * 1000; // 1 hari dalam milidetik
                var diffDays = Math.round((servisDate - today) / oneDay);

                if (diffDays <= 1) {
                    Swal.fire({
                        icon: "error",
                        title: "Pembatalan Ditolak",
                        text: "Orderan tidak bisa dibatalkan di H-1 dari tanggal servis.",
                    });
                } else {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: "Apakah Anda Yakin?",
                        text: "Orderan ini akan dibatalkan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Batalkan Orderan!",
                        cancelButtonText: "Tidak, Jangan Batalkan!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Masukkan alasan pembatalan orderan servis',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'on'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Submit',
                                showLoaderOnConfirm: true,
                                preConfirm: (batal_cust) => {
                                    if (!batal_cust) {
                                        Swal.showValidationMessage(`Alasan tidak boleh kosong`)
                                    } else {
                                        return batal_cust;
                                    }
                                },
                                allowOutsideClick: () => !Swal.isLoading()
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = `booked-batal.php?id=${id_servis}&batal_cust=${encodeURIComponent(result.value)}`;
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swalWithBootstrapButtons.fire({
                                title: "Pembatalan Dibatalkan",
                                text: "Orderan ini tetap aman dan tidak berubah.",
                                icon: "error"
                            });
                        }
                    });
                }
            });

            // SweetAlert pembayaran gagal
            $('.failed-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');
                var gagal_pem = $(this).data('gagal_pem');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Pembayaran Gagal!",
                    text: `Keterangan: ${gagal_pem}. Periksa dan perbaharui formulir pesanan?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, perbaharui!",
                    cancelButtonText: "Batal",
                    reverseButtons: true
                }).then((result) => {
                    window.location = `pesan-edit.php?id_servis=${id_servis}`;
                });
            });

        });
    </script>

</body>

</html>