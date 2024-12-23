<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$id_servis = $_GET["id_servis"];

$result_servis = mysqli_query($conn, "SELECT C.nm_cust, J.nm_servis, J.biaya, S.tgl_servis, S.bukpem
                                                    FROM tbl_servis S
                                                    LEFT JOIN tbl_customer C ON S.id_cust = C.id_cust
                                                    LEFT JOIN tbl_jenis_servis J ON S.id_jenis = J.id_jenis
                                                    WHERE id_servis = $id_servis");
$row_servis = mysqli_fetch_assoc($result_servis);
$bukpem_lama = $row_servis["bukpem"];

$simpan_script = "";

if (isset($_POST["submit"])) {
    if ($_FILES['bukpem']['error'] === 4) {
        $bukpem = $bukpem_lama;
    } else {
        $bukpem = $_FILES["bukpem"]["name"];
    }
    $upload = move_uploaded_file($_FILES['bukpem']['tmp_name'], '../bukpem/' . $bukpem);

    $simpan = mysqli_query($conn, "UPDATE tbl_servis SET bukpem = '$bukpem', status_pem = '' WHERE id_servis = $id_servis");

    if ($simpan) {
        $simpan_script =
            "<script>
                Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Pesanan berhasil diperbaharui!',
                        text: 'Anda akan diarahkan ke halaman Detail Pesanan',
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        window.location = `booked.php`;
                    });
            </script>";
    } else {
        $simpan_script =
            "<script>
                Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan, coba lagi!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'booked.php';
                        }
                    });
            </script>";
    }
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
    <title>SERASI - Edit Formulir Pemesanan Servis AC</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mangkost" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../dist/images/logos/favicon.png" />
    <!-- Core CSS -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <h4 class="fw-semibold mb-8">Edit Formulir Pemesanan Servis AC</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Formulir Pemesanan Servis AC</li>
                                        <li class="breadcrumb-item" aria-current="page">Edit Formulir</li>
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
                    <!-- Basic Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-subtitle mb-5">
                                        Silahkan edit formulir di bawah ini untuk pemesanan <b>Jasa Servis AC SERASI</b>!
                                    </p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="id_cust" class="col-2 col-form-label">Nama</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo $row_servis["nm_cust"] ?></strong></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="id_jenis" class="col-2 col-form-label">Jenis Servis</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo $row_servis["nm_servis"] ?></strong></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tgl_servis" class="col-2 col-form-label">Tanggal Servis</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong>
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
                                                    </strong></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="biaya" class="col-2 col-form-label">Biaya</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo 'Rp.' . number_format($row_servis["biaya"], 0, ',', '.'); ?></strong></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="biaya" class="col-2 col-form-label">Bukti Pembayaran Lama</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <img src="../bukpem/<?php echo $row_servis["bukpem"] ?>" style="max-height: 200px; object-fit: cover;" alt="" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="bukpem" class="col-2 col-form-label">Bukti Pembayaran Baru</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <input type="file" class="form-control" id="bukpem" name="bukpem" required>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div class="col-9 offset-3">
                                                <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                                <a href="booked.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Import JS Files -->
    <script src="../dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="../dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/app.horizontal.init.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.js"></script>

    <!-- SweetAlert Script -->
    <?= $simpan_script ?>

    <script>
        // Mendapatkan elemen input tanggal
        const tglServisInput = document.getElementById('tgl_servis');

        // Fungsi untuk mendapatkan tanggal besok
        function getTomorrowDate() {
            const today = new Date();
            today.setDate(today.getDate() + 1); // Tambahkan 1 hari
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Atur atribut `min` ke tanggal besok
        tglServisInput.min = getTomorrowDate();
    </script>
</body>

</html>