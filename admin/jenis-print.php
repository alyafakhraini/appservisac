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
                                <h4 class="fw-semibold mb-8">Jenis Servis</h4>
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

                        <?php if ($result_jenis == 0) { ?>
                            <div class="alert alert-warning" role="alert">
                                Data masih kosong
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table id="example2" class="table border table-bordered table-hover" style="width: 100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th> No</th>
                                            <th> Servis</th>
                                            <th> Deskripsi</th>
                                            <th> Biaya</th>
                                            <th> Durasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_jenis = mysqli_fetch_assoc($query_jenis)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $row_jenis["nm_servis"] ?></td>
                                                <td><?php echo $row_jenis["deskripsi"] ?></td>
                                                <td><?php echo 'Rp.' . number_format($row_jenis["biaya"], 0, ',', '.'); ?></td>
                                                <td><?php echo $row_jenis["durasi"] ?></td>
                                            </tr>
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