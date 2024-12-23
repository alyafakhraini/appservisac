<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$id_user = $_SESSION["id_user"];

$query_cust = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE id_user = '$id_user'");
$row_cust = mysqli_fetch_assoc($query_cust);
$id_cust = $row_cust["id_cust"];

$id_jenis = $_GET["id_jenis"];
$query_jenis = mysqli_query($conn, "SELECT * FROM tbl_jenis_servis WHERE id_jenis = '$id_jenis'");
$row_jenis = mysqli_fetch_assoc($query_jenis);

$swal_script = ""; // Inisialisasi script SweetAlert kosong
$simpan_script = "";

if (isset($_POST["submit"])) {
    $id_cust = $_POST["id_cust"];
    $id_jenis = $_POST["id_jenis"];
    $tgl_servis = $_POST["tgl_servis"];
    $bukpem = $_FILES["bukpem"]["name"];
    $upload = move_uploaded_file($_FILES['bukpem']['tmp_name'], '../bukpem/' . $bukpem);

    // Cari wilayah_cust
    $result_wilayah_cust = mysqli_query($conn, "SELECT wilayah_cust FROM tbl_customer WHERE id_cust = '$id_cust'");
    $row_wilayah_cust = mysqli_fetch_assoc($result_wilayah_cust);
    $wilayah_cust = $row_wilayah_cust['wilayah_cust'];

    // Cari teknisi berdasarkan wilayah_cust
    $result_teknisi = mysqli_query($conn, "SELECT T.id_teknisi
                                                         FROM tbl_teknisi T
                                                         LEFT JOIN tbl_spesialisasi S ON T.id_teknisi = S.id_teknisi
                                                         WHERE T.wilayah_teknisi = '$wilayah_cust'
                                                         AND S.id_jenis = '$id_jenis'
                                                         AND T.id_teknisi NOT IN (
                                                                SELECT id_teknisi 
                                                                FROM tbl_servis 
                                                                WHERE tgl_servis = '$tgl_servis'
                                                            )
                                                         ORDER BY RAND()
                                                         LIMIT 1");
    $row_teknisi = mysqli_fetch_assoc($result_teknisi);

    // Validasi teknisi
    if ($row_teknisi) {
        $id_teknisi = $row_teknisi['id_teknisi'];
    } else {
        // Cek apakah ada teknisi yang tersedia untuk wilayah
        $result_teknisi_wilayah = mysqli_query($conn, "SELECT id_teknisi 
                                                   FROM tbl_teknisi 
                                                   WHERE wilayah_teknisi = '$wilayah_cust'");
        $row_teknisi_wilayah = mysqli_fetch_assoc($result_teknisi_wilayah);

        // Cek apakah ada spesialisasi teknisi untuk jenis servis
        $result_teknisi_spesialisasi = mysqli_query($conn, "SELECT id_teknisi 
                                                        FROM tbl_spesialisasi 
                                                        WHERE id_jenis = '$id_jenis'");
        $row_teknisi_spesialisasi = mysqli_fetch_assoc($result_teknisi_spesialisasi);

        // Tidak ada teknisi untuk jenis servis
        $result_jenis_servis = mysqli_query($conn, "SELECT nm_servis 
                                                    FROM tbl_jenis_servis 
                                                    WHERE id_jenis = '$id_jenis'");
        $row_jenis_servis = mysqli_fetch_assoc($result_jenis_servis);
        $nm_servis = $row_jenis_servis['nm_servis'];

        $result_tgl = mysqli_query($conn, "SELECT id_teknisi FROM tbl_servis WHERE tgl_servis = '$tgl_servis' AND id_jenis = '$id_jenis'");
        $row_tgl = mysqli_fetch_assoc($result_tgl);

        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $timestamp = strtotime($tgl_servis);
        $bulan = date("n", $timestamp);
        $tahun = date("Y", $timestamp);
        $tanggal = date("j", $timestamp);
        $tgl_servis_terformat = sprintf("%02d %s %d", $tanggal, getBulanIndonesia($bulan), $tahun);

        if (!$row_teknisi_wilayah && !$row_teknisi_spesialisasi) {
            // Tidak ada teknisi untuk wilayah dan spesialisasi
            $swal_script =
                "
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Mohon Maaf!',
                    text: 'Saat ini, kami belum dapat menyediakan teknisi untuk jenis servis: $nm_servis dan wilayah: " . getFormattedWilayahCust($wilayah_cust) . ".',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redirect ke halaman form
                    }
                });
            </script>
        ";
        } elseif (!$row_teknisi_wilayah) {
            // Tidak ada teknisi untuk wilayah
            $swal_script =
                "
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Mohon Maaf!',
                    text: 'Saat ini, kami belum dapat menyediakan teknisi untuk wilayah: " . getFormattedWilayahCust($wilayah_cust) . ".',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redirect ke halaman form
                    }
                });
            </script>
        ";
        } elseif (!$row_teknisi_spesialisasi) {
            $swal_script =
                "
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Mohon Maaf!',
                    text: 'Saat ini, kami belum dapat menyediakan teknisi untuk jenis servis: $nm_servis.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redirect ke halaman form
                    }
                });
            </script>
        ";
        } elseif ($row_tgl) {

            $swal_script =
                "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Pemesanan tidak bisa dilakukan di hari H',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'pesan.php?id_jenis=$id_jenis'; // Redirect ke halaman form
                        }
                    });
                </script>";
        } elseif ($tgl_servis < $tomorrow) {

            $swal_script =
                "
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Mohon Maaf!',
                        text: 'Saat ini, teknisi untuk jenis servis: $nm_servis di tanggal $tgl_servis_terformat belum tersedia. Silahkan ganti tanggal servis anda :D',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'pesan.php?id_jenis=$id_jenis'; // Redirect ke halaman form
                        }
                    });
                </script>
                ";
        }
    }

    // Jika tidak ada error teknisi, simpan data ke database
    if (empty($swal_script)) {
        $simpan = mysqli_query($conn, "INSERT INTO tbl_servis (id_cust, id_jenis, id_teknisi, tgl_servis, bukpem) VALUES ('$id_cust', '$id_jenis', '$id_teknisi', '$tgl_servis', '$bukpem')");

        if ($simpan) {
            $simpan_script =
                "<script>
                Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Pesanan berhasil diproses!',
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
                            window.location.href = 'index.php';
                        }
                    });
            </script>";
        }
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

function getFormattedWilayahCust($wilayah)
{
    switch ($wilayah) {
        case "1":
            return "Banjarmasin Utara";
        case "2":
            return "Banjarmasin Barat";
        case "3":
            return "Banjarmasin Tengah";
        case "4":
            return "Banjarmasin Timur";
        case "5":
            return "Banjarmasin Selatan";
        default:
            return "Wilayah Tidak Diketahui";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Formulir Pemesanan Servis AC</title>
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
                                <h4 class="fw-semibold mb-8">Formulir Pemesanan Servis AC</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Formulir Pemesanan Servis AC</li>
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
                                        Silahkan isi formulir di bawah ini untuk pemesanan <b>Jasa Servis AC SERASI</b>!<br>
                                        Pemesanan hanya dapat dilakkukan paling lambat satu hari sebelum tanggal servis.
                                    </p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="id_cust" class="col-2 col-form-label">Nama</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo $row_cust["nm_cust"] ?></strong></span>
                                                <input type="hidden" name="id_cust" value="<?php echo $row_cust["id_cust"] ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="id_jenis" class="col-2 col-form-label">Jenis Servis</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo $row_jenis["nm_servis"] ?></strong></span>
                                                <input type="hidden" name="id_jenis" value="<?php echo $id_jenis; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tgl_servis" class="col-2 col-form-label">Tanggal Servis</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <input type="date" class="form-control" id="tgl_servis" value="<?php echo date('Y-m-d', strtotime('+1 day')) ?>" name="tgl_servis" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="biaya" class="col-2 col-form-label">Biaya</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <span><strong><?php echo 'Rp.' . number_format($row_jenis["biaya"], 0, ',', '.'); ?></strong></span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="bukpem" class="col-2 col-form-label">Bukti Pembayaran</label>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-9">
                                                <input type="file" class="form-control" id="bukpem" name="bukpem" required>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div class="col-9 offset-3">
                                                <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                                <a href="index.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a>
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
    <?= $swal_script ?>
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