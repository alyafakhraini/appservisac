<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$id_jenis = isset($_GET['id_jenis']) ? $_GET['id_jenis'] : '';

$query_spes = mysqli_query($conn, "SELECT S.id_spes, T.nm_teknisi, T.wilayah_teknisi, J.nm_servis
                                                 FROM tbl_spesialisasi S, tbl_teknisi T, tbl_jenis_servis J
                                                 WHERE S.id_teknisi = T.id_teknisi
                                                 AND S.id_jenis = J.id_jenis
                                                 AND S.id_jenis = $id_jenis");
$result_spes = mysqli_num_rows($query_spes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Spesialisasi Teknis</title>
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
                                <h4 class="fw-semibold mb-8">Spesialisasi Teknis</h4>
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
                        <?php if ($result_spes == 0) { ?>
                            <div class="alert alert-warning" role="alert">
                                Data Spesialisasi Teknisi masih kosong silahkan menambahkan data pada tombol <b>Tambah Data</b> diatas...!
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table id="example2" class="table border table-bordered text-nowrap table-hover" style="width: 100%">
                                    <thead class="table-success">
                                        <tr>
                                            <th> No</th>
                                            <th> Nama Teknisi</th>
                                            <th> Wilayah</th>
                                            <th> Spesialisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_spes = mysqli_fetch_assoc($query_spes)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $row_spes["nm_teknisi"] ?></td>
                                                <td>
                                                    <?php
                                                    if ($row_spes["wilayah_teknisi"] == "1") {
                                                        echo "Banjarmasin Utara";
                                                    } else if ($row_spes["wilayah_teknisi"] == "2") {
                                                        echo "Banjarmasin Barat";
                                                    } else if ($row_spes["wilayah_teknisi"] == "3") {
                                                        echo "Banjarmasin Tengah";
                                                    } else if ($row_spes["wilayah_teknisi"] == "4") {
                                                        echo "Banjarmasin Timur";
                                                    } else if ($row_spes["wilayah_teknisi"] == "5") {
                                                        echo "Banjarmasin Selatan";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row_spes["nm_servis"] ?></td>
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