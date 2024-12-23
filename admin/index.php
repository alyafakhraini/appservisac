<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 1) {
    header("Location: logout.php");
}

// Hitung servis booked
$query_booked = "SELECT COUNT(*) AS total_booked FROM tbl_servis WHERE status = '3'";
$result_booked = mysqli_query($conn, $query_booked);
$row_booked = mysqli_fetch_assoc($result_booked);
$total_booked = $row_booked['total_booked'];

// Hitung servis pending
$query_pending = "SELECT COUNT(*) AS total_pending FROM tbl_servis WHERE status = '2'";
$result_pending = mysqli_query($conn, $query_pending);
$row_pending = mysqli_fetch_assoc($result_pending);
$total_pending = $row_pending['total_pending'];

// Hitung servis selesai
$query_servis_selesai = "SELECT COUNT(*) AS total_selesai FROM tbl_servis WHERE status = '4'";
$result_servis_selesai = mysqli_query($conn, $query_servis_selesai);
$data_servis_selesai = mysqli_fetch_assoc($result_servis_selesai);
$total_selesai = $data_servis_selesai['total_selesai'];

// Hitung total pelanggan
$query_total_cust = "SELECT COUNT(*) AS total_cust FROM tbl_customer";
$result_total_cust = mysqli_query($conn, $query_total_cust);
$data_total_cust = mysqli_fetch_assoc($result_total_cust);
$total_cust = $data_total_cust['total_cust'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Monitoring</title>
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
                                <h4 class="fw-semibold mb-8">Monitoring SERASI's Service</h4>
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
                    <!-- Card Statistik -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Servis Booked</h4>
                                <div class="d-flex align-items-center">
                                    <h2 class="fw-bold mb-0"><?php echo $total_booked; ?></h2>
                                    <div class="ms-auto">
                                        <i class="fas fa-wrench text-info fs-4"></i>
                                    </div>
                                </div>
                                <p class="text-muted mb-0">Jumlah servis di booking.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Servis Pending</h4>
                                <div class="d-flex align-items-center">
                                    <h2 class="fw-bold mb-0"><?php echo $total_pending; ?></h2>
                                    <div class="ms-auto">
                                        <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                                    </div>
                                </div>
                                <p class="text-muted mb-0">Teknisi belum ditemukan</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Servis Selesai</h4>
                                <div class="d-flex align-items-center">
                                    <h2 class="fw-bold mb-0"><?php echo $total_selesai; ?></h2>
                                    <div class="ms-auto">
                                        <i class="fas fa-check-circle text-success fs-4"></i>
                                    </div>
                                </div>
                                <p class="text-muted mb-0">Proses servis selesai</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Pelanggan</h4>
                                <div class="d-flex align-items-center">
                                    <h2 class="fw-bold mb-0"><?php echo $total_cust; ?></h2>
                                    <div class="ms-auto">
                                        <i class="fas fa-user text-primary fs-4"></i>
                                    </div>
                                </div>
                                <p class="text-muted mb-0">Pelanggan terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik dan Tabel -->
                <div class="row">
                    <!-- Grafik Statistik -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Statistik Servis Bulanan</h4>
                                <canvas id="servisChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Servis Terbaru</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pelanggan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_recent_servis = "SELECT S.id_servis, C.nm_cust, S.status
                                                                FROM tbl_servis S, tbl_customer C
                                                                WHERE S.id_cust = C.id_cust
                                                                AND S.status != 4
                                                                ORDER BY S.id_servis DESC
                                                                LIMIT 5";
                                        $result_recent_servis = mysqli_query($conn, $query_recent_servis);
                                        $no = 1;
                                        while ($data = mysqli_fetch_assoc($result_recent_servis)) {
                                            echo "<tr>
                                                    <td>{$no}</td>
                                                    <td>{$data['nm_cust']}</td>
                                                <td>";
                                            if ($data['status'] == '1') {
                                                echo "<span class='badge bg-warning'>Order Diproses</span>";
                                            } elseif ($data['status'] == '2') {
                                                echo "<span class='badge bg-danger'>Pending</span>";
                                            } elseif ($data['status'] == '3') {
                                                echo "<span class='badge bg-primary'>Booked</span>";
                                            } elseif ($data['status'] == '4') {
                                                echo "<span class='badge bg-success'>Done</span>";
                                            }
                                            echo "</td>
                                            </tr>";
                                            $no++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Inisialisasi array data kosong untuk 12 bulan
        $data_proses = array_fill(1, 12, 0);
        $data_pending = array_fill(1, 12, 0);
        $data_booked = array_fill(1, 12, 0);
        $data_done = array_fill(1, 12, 0);

        // Query untuk menghitung jumlah servis berdasarkan status dan bulan
        $query = "SELECT MONTH(tgl_servis) AS bulan, status, COUNT(*) AS jumlah
                  FROM tbl_servis 
                  GROUP BY MONTH(tgl_servis), status";
        $result = mysqli_query($conn, $query);

        // Memproses hasil query ke dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            $bulan = (int)$row['bulan'];
            $status = $row['status'];
            $jumlah = (int)$row['jumlah'];

            if ($status == '1') {
                $data_proses[$bulan] = $jumlah;
            } elseif ($status == '2') {
                $data_pending[$bulan] = $jumlah;
            } elseif ($status == '3') {
                $data_booked[$bulan] = $jumlah;
            } elseif ($status == '4') {
                $data_done[$bulan] = $jumlah;
            }
        }

        // Kirim data dalam bentuk JSON ke script JavaScript
        echo "<script>
                const dataProses = " . json_encode(array_values($data_proses)) . ";
                const dataPending = " . json_encode(array_values($data_pending)) . ";
                const dataBooked = " . json_encode(array_values($data_booked)) . ";
                const dataDone = " . json_encode(array_values($data_done)) . ";
              </script>";
        ?>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('servisChart').getContext('2d');
                const servisChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                                label: 'Order Diproses',
                                data: dataProses,
                                borderColor: '#FFC300 ',
                                backgroundColor: 'rgba(255, 245, 58, 0.6)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                            },
                            {
                                label: 'Servis Pending',
                                data: dataPending, // Data dari PHP
                                borderColor: '#C70039',
                                backgroundColor: 'rgba(255, 7, 7, 0.41)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                            },
                            {
                                label: 'Booked',
                                data: dataBooked,
                                borderColor: '#004bc7 ',
                                backgroundColor: 'rgba(58, 104, 255, 0.42)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                            },
                            {
                                label: 'Servis Selesai',
                                data: dataDone, // Data dari PHP
                                borderColor: '#4CAF50',
                                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Statistik Servis Bulanan'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
        </script>

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