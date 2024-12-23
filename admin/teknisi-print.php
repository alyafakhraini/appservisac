<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

$wilayah_teknisi = isset($_GET['wilayah_teknisi']) ? $_GET['wilayah_teknisi'] : '';

$query_teknisi = mysqli_query(
    $conn,
    "SELECT T.id_teknisi, T.nm_teknisi, T.telp_teknisi, T.alamat_teknisi, T.wilayah_teknisi, U.jk_user
                                                    FROM tbl_teknisi T, tbl_user U
                                                    WHERE T.id_user = U.id_user
                                                    AND wilayah_teknisi = $wilayah_teknisi"
);
$result_teknisi = mysqli_num_rows($query_teknisi);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Data Teknisi</title>
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
                                <h4 class="fw-semibold mb-8">Data Teknisi</h4>
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

                        <?php if ($result_teknisi == 0) { ?>
                            <div class="alert alert-warning" role="alert">
                                Data Teknisi masih kosong
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table id="example2" class="table border table-bordered table-hover" style="width: 100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th> No</th>
                                            <th> Nama Teknisi</th>
                                            <th> Jenis Kelamin</th>
                                            <th> Nomor Telepon</th>
                                            <th> Wilayah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_teknisi = mysqli_fetch_assoc($query_teknisi)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
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
    </div>

</body>

</html>