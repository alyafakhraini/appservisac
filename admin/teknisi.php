<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$result_teknisi = false;

if (isset($_GET["wilayah_teknisi"])) {
    $wilayah_teknisi = $_GET["wilayah_teknisi"];

    $query_teknisi = mysqli_query($conn, "SELECT T.id_teknisi, T.nm_teknisi, T.telp_teknisi, T.alamat_teknisi, T.wilayah_teknisi, U.jk_user
                                                    FROM tbl_teknisi T, tbl_user U
                                                    WHERE T.id_user = U.id_user
                                                    AND wilayah_teknisi = $wilayah_teknisi");
    $result_teknisi = mysqli_num_rows($query_teknisi);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Data Teknisi</title>
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
                                <h4 class="fw-semibold mb-8">Data Teknisi</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Data Teknisi</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengelola <b>Data Teknisi</b> dibawah ini...!</p>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3 form-inline">
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <select name="wilayah_teknisi" id="wilayah_teknisi" class="form-control" required>
                                                        <option value="">-- Pilih Wilayah Teknisi --</option>
                                                        <option value="1" <?php if (isset($wilayah_teknisi) && $wilayah_teknisi == '1') echo "SELECTED"; ?>>Banjarmasin Utara</option>
                                                        <option value="2" <?php if (isset($wilayah_teknisi) && $wilayah_teknisi == '2') echo "SELECTED"; ?>>Banjarmasin Barat</option>
                                                        <option value="3" <?php if (isset($wilayah_teknisi) && $wilayah_teknisi == '3') echo "SELECTED"; ?>>Banjarmasin Tengah</option>
                                                        <option value="3" <?php if (isset($wilayah_teknisi) && $wilayah_teknisi == '4') echo "SELECTED"; ?>>Banjarmasin Timur</option>
                                                        <option value="3" <?php if (isset($wilayah_teknisi) && $wilayah_teknisi == '5') echo "SELECTED"; ?>>Banjarmasin Selatan</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                <a href="teknisi.php" class="btn btn-sm btn-secondary ml-2">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                    <?php if ($result_teknisi == 0) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            Data Teknisi masih kosong.
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                            <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>Action</th>
                                                        <th> Nama Teknisi</th>
                                                        <th> Jenis Kelamin</th>
                                                        <th> Nomor Telepon</th>
                                                        <th> Alamat</th>
                                                        <th> Wilayah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_teknisi = mysqli_fetch_assoc($query_teknisi)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a href="teknisi-edit.php?id=<?php echo $row_teknisi["id_teknisi"] ?>" class="btn btn-sm btn-success"><i class="ti ti-pencil"></i> Edit</a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id_teknisi="<?php echo $row_teknisi["id_teknisi"]; ?>"><i class=" ti ti-trash"></i> Hapus</a>
                                                            </td>
                                                            <td><?php echo $row_teknisi["nm_teknisi"] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row_teknisi["jk_user"] == "lk") {
                                                                    echo "Laki-laki";
                                                                } else if ($row_teknisi["jk_user"] == "pr") {
                                                                    echo "Perempuan";
                                                                } else {
                                                                    echo "Belum Diisi";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row_teknisi["telp_teknisi"] ?></td>
                                                            <td><?php echo $row_teknisi["alamat_teknisi"] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row_teknisi["wilayah_teknisi"] == "1") {
                                                                    echo "Banjarmasin Utara";
                                                                } else if ($row_teknisi["wilayah_teknisi"] == "2") {
                                                                    echo "Banjarmasin Barat";
                                                                } else if ($row_teknisi["wilayah_teknisi"] == "3") {
                                                                    echo "Banjarmasin Tengah";
                                                                } else if ($row_teknisi["wilayah_teknisi"] == "4") {
                                                                    echo "Banjarmasin Timur";
                                                                } else if ($row_teknisi["wilayah_teknisi"] == "5") {
                                                                    echo "Banjarmasin Selatan";
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
            const urlParams = new URLSearchParams(window.location.search);
            const wilayah_teknisi = urlParams.get('wilayah_teknisi');

            var table = $('#example2').DataTable({
                lengthChange: false,
                pageLength: 50,
                buttons: [{
                    text: 'Print',
                    action: function(e, dt, node, config) {
                        window.location.href = `teknisi-print.php?wilayah_teknisi=${wilayah_teknisi}`;
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
                var id_teknisi = $(this).data('id_teknisi');

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
                            window.location = `teknisi-hapus.php?id=${id_teknisi}`;
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