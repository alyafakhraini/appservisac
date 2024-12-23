<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$query_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis");
$result_jenis = mysqli_num_rows($query_jenis);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Jenis Servis</title>
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
                                <h4 class="fw-semibold mb-8">Jenis Servis</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Jenis Servis</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengelola <b>Data Jenis Servis</b> dibawah ini...!</p>
                                    <div class="mb-3">
                                        <a href="jenis-tambah.php" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah Data</a>
                                    </div>
                                    <?php if ($result_jenis == 0) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            Data masih kosong, silahkan menambahkan data pada tombol <b>Tambah Data</b> diatas...!
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                            <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>Action</th>
                                                        <th> Servis</th>
                                                        <th> Deskripsi</th>
                                                        <th> Biaya</th>
                                                        <th> Durasi</th>
                                                        <th> Image</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_jenis = mysqli_fetch_assoc($query_jenis)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a href="jenis-edit.php?id=<?php echo $row_jenis["id_jenis"] ?>" class="btn btn-sm btn-success"><i class="ti ti-pencil"></i> Edit</a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id_jenis="<?php echo $row_jenis["id_jenis"]; ?>"><i class=" ti ti-trash"></i> Hapus</a>
                                                            </td>
                                                            <td><?php echo $row_jenis["nm_servis"] ?></td>
                                                            <td><?php echo $row_jenis["deskripsi"] ?></td>
                                                            <td><?php echo 'Rp.' . number_format($row_jenis["biaya"], 0, ',', '.'); ?></td>
                                                            <td><?php echo $row_jenis["durasi"] ?></td>
                                                            <td><img src="../dist/images/services/<?php echo $row_jenis["gambar"] ?>" width="200" height="130" alt="" /></td>
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
                        window.location.href = 'jenis-print.php'; // Ganti dengan URL atau halaman lain
                    }
                }],
                order: [1, 'asc'],
                scrollX: true
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');

            // SweetAlert Delete Confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol
                var id_jenis = $(this).data('id_jenis');

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
                            window.location = `jenis-hapus.php?id=${id_jenis}`;
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