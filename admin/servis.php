<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$query_servis = mysqli_query($conn, "SELECT S.id_servis, S.tgl_servis, S.status, S.catatan, S.alasan, S.bukpem, S.status_pem, S.gagal_pem, S.batal_cust,
                                                        C.nm_cust, C.alamat_cust, C.telp_cust,
                                                        J.nm_servis, J.biaya,
                                                        T.id_teknisi, T.nm_teknisi
                                                    FROM tbl_servis S
                                                    LEFT JOIN tbl_customer C ON S.id_cust = C.id_cust
                                                    LEFT JOIN tbl_jenis_servis J ON S.id_jenis = J.id_jenis
                                                    LEFT JOIN tbl_teknisi T ON S.id_teknisi = T.id_teknisi
                                                    WHERE S.status != 4");
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
    <title>SERASI - Data Pesanan Servis</title>
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
                                <h4 class="fw-semibold mb-8">Data Pesanan Servis</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Data Pesanan Servis</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengelola <b>Data Pesanan Servis</b> dibawah ini...!</p>
                                    <?php if ($result_servis == 0) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            Data Pesanan Servis masih kosong.
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                            <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>Action</th>
                                                        <th> Nama Customer</th>
                                                        <th> Tanggal Servis</th>
                                                        <th> Alamat</th>
                                                        <th> Nomor Telepon</th>
                                                        <th> Jenis Servis</th>
                                                        <th> Biaya</th>
                                                        <th> Bukti Pembayaran</th>
                                                        <th> Status Pembayaran</th>
                                                        <th> Status Pengerjaan</th>
                                                        <th> Catatan</th>
                                                        <th> Nama Teknisi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_servis = mysqli_fetch_assoc($query_servis)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a href="servis-edit.php?id=<?php echo $row_servis["id_servis"] ?>" class="btn btn-sm btn-success"><i class="ti ti-pencil"></i> Edit</a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id_servis="<?php echo $row_servis["id_servis"]; ?>"><i class=" ti ti-trash"></i> Hapus</a>
                                                            </td>
                                                            <td><?php echo $row_servis["nm_cust"] ?></td>
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
                                                            <td><?php echo $row_servis["alamat_cust"] ?></td>
                                                            <td><?php echo $row_servis["telp_cust"] ?></td>
                                                            <td><?php echo $row_servis["nm_servis"] ?></td>
                                                            <td><?php echo 'Rp.' . number_format($row_servis["biaya"], 0, ',', '.'); ?></td>
                                                            <td class="text-center">
                                                                <img src="../bukpem/<?php echo $row_servis["bukpem"] ?>" style="max-height: 200px; object-fit: cover;" alt="" />
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row_servis["status_pem"] == "confirmed") { ?>
                                                                    <span class="btn btn-sm btn-success">Confirmed</span>
                                                                <?php } elseif ($row_servis["status_pem"] == "failed") { ?>
                                                                    <button class="btn btn-sm btn-outline-success btn-fw confirm-btn" data-id_servis="<?php echo $row_servis['id_servis']; ?>">Konfirmasi Sukses</button>
                                                                    <button class="btn btn-sm btn-outline-danger btn-fw fail-btn" data-id_servis="<?php echo $row_servis['id_servis']; ?>">Konfirmasi Gagal</button>
                                                                <?php } else { ?>
                                                                    <button class="btn btn-sm btn-outline-success btn-fw confirm-btn" data-id_servis="<?php echo $row_servis['id_servis']; ?>">Konfirmasi Sukses</button>
                                                                    <button class="btn btn-sm btn-outline-danger btn-fw fail-btn" data-id_servis="<?php echo $row_servis['id_servis']; ?>">Konfirmasi Gagal</button>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($row_servis["status"] == 1) {
                                                                    echo "<div class='btn btn-sm btn-secondary'>Order Diproses</div>";
                                                                } else if ($row_servis["status"] == 2) {
                                                                    echo "<div class='btn btn-sm btn-danger pending-btn' data-id_servis='{$row_servis['id_servis']}' data-alasan='{$row_servis['alasan']}' data-batal_cust='{$row_servis['batal_cust']}' data-id_teknisi='{$row_servis['id_teknisi']}'>Pending</div>";
                                                                } else if ($row_servis["status"] == 3) {
                                                                    echo "<div class='btn btn-sm btn-primary'>Booked</div>";
                                                                } else if ($row_servis["status"] == 4) {
                                                                    echo "<div class='btn btn-sm btn-success'>Done</div>";
                                                                } else if ($row_servis["status_pem"] == 'failed') {
                                                                    echo "<div class='btn btn-sm btn-warning'>Pembayaran Gagal</div>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row_servis["catatan"] ?></td>
                                                            <td><?php echo $row_servis["nm_teknisi"] ?></td>
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
                buttons: [{
                    text: 'Print',
                    action: function(e, dt, node, config) {
                        window.location.href = 'servis-print.php'; // Ganti dengan URL atau halaman lain
                    }
                }],
                order: [1, 'asc'],
                scrollX: true
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');

            // SweetAlert Confirm order berhasil
            $('.confirm-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Orderan Servis Diterima!",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location = `servis-sukses.php?id=${id_servis}`;
                });
            });

            // SweetAlert Confirm order gagal
            $('.fail-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Pembayaran orderan servis ini akan dikonfirmasi gagal!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Konfirmasi Gagal!",
                    cancelButtonText: "Tidak, Jangan Konfirmasi!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Masukkan alasan pembayaran gagal',
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'on'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            showLoaderOnConfirm: true,
                            preConfirm: (gagal_pem) => {
                                if (!gagal_pem) {
                                    Swal.showValidationMessage(`Alasan tidak boleh kosong`)
                                } else {
                                    return gagal_pem;
                                }
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = `servis-gagal.php?id=${id_servis}&gagal_pem=${encodeURIComponent(result.value)}`;
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: "Konfirmasi Gagal Dibatalkan",
                            text: "Orderan ini tetap aman dan tidak berubah.",
                            icon: "error"
                        });
                    }
                });
            });

            // SweetAlert Approve cancel
            $('.pending-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');
                var id_teknisi = $(this).data('id_teknisi');
                var alasan = $(this).data('alasan');
                var batal_cust = $(this).data('batal_cust');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                if (alasan === '') {
                    swalWithBootstrapButtons.fire({
                        title: "Teknisi tidak tersedia!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Cari Teknisi!",
                        cancelButtonText: "Batal",
                        reverseButtons: true
                    }).then((result) => {
                        window.location = `servis-cari.php?id_servis=${id_servis}&id_teknisi=${id_teknisi}`;
                    });
                } else if (id_teknisi === '') {
                    swalWithBootstrapButtons.fire({
                        title: "Teknisi tidak tersedia!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Cari Teknisi!",
                        cancelButtonText: "Batal",
                        reverseButtons: true
                    }).then((result) => {
                        window.location = `servis-cari1.php?id_servis=${id_servis}`;
                    });
                } else if (batal_cust !== '') {
                    swalWithBootstrapButtons.fire({
                        title: "Customer mengajukan pembatalan orderan ini!",
                        text: `Alasan pembatalan: ${batal_cust}. Setujui pembatalan order ini?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Setujui!",
                        cancelButtonText: "Tidak, Jangan Setujui!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swalWithBootstrapButtons.fire({
                                title: "Disetujui",
                                text: "Pembatalan order disetujui.",
                                icon: "success"
                            }).then(() => {
                                window.location = `servis-batal.php?id=${id_servis}`;
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swalWithBootstrapButtons.fire({
                                title: "Tidak disetujui",
                                text: "Pembatalan tidak disetujui.",
                                icon: "error"
                            });
                        }
                    });
                } else {
                    swalWithBootstrapButtons.fire({
                        title: "Teknisi mengajukan pembatalan orderan ini!",
                        text: `Alasan pembatalan: ${alasan}. Setujui pembatalan order ini?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Setujui!",
                        cancelButtonText: "Tidak, Jangan Setujui!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swalWithBootstrapButtons.fire({
                                title: "Disetujui",
                                text: "Pembatalan order disetujui.",
                                icon: "success"
                            }).then(() => {
                                window.location = `servis-approve.php?id_servis=${id_servis}&id_teknisi=${id_teknisi}`;
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swalWithBootstrapButtons.fire({
                                title: "Tidak disetujui",
                                text: "Pembatalan tidak disetujui.",
                                icon: "error"
                            });
                        }
                    });
                }
            });

            // SweetAlert Delete Confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_servis = $(this).data('id_servis');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Data ini akan dihapus dan tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Tidak, Batal!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Dihapus!",
                            text: "Data Anda berhasil dihapus.",
                            icon: "success"
                        }).then(() => {
                            window.location = `servis-hapus.php?id=${id_servis}`;
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: "Dibatalkan",
                            text: "Data Anda aman :)",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>