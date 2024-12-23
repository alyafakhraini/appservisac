<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 2) {
    header("Location: logout.php");
}

$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

$result_user = mysqli_query($conn, "SELECT T.nm_teknisi, T.telp_teknisi, T.alamat_teknisi, T.wilayah_teknisi, U.username, U.password, U.jk_user, U.foto
                                                  FROM tbl_teknisi T
                                                  LEFT JOIN tbl_user U ON T.id_user = U.id_user
                                                  WHERE T.id_user = $id_user");
$row_user = mysqli_fetch_assoc($result_user);
$foto_lama = $row_user["foto"];

if (isset($_POST["submit"])) {
    $nm_teknisi = $_POST["nm_teknisi"];
    $telp_teknisi = $_POST["telp_teknisi"];
    $alamat_teknisi = $_POST["alamat_teknisi"];
    $wilayah_teknisi = $_POST["wilayah_teknisi"];

    $username = $_POST["username"];
    $password = $_POST["password"];
    $jk_user = $_POST["jk_user"];
    if ($_FILES['foto']['error'] === 4) {
        $foto = $foto_lama;
    } else {
        $foto = $_FILES["foto"]["name"];
    }
    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], '../profil/' . $foto);

    $simpan_user = mysqli_query($conn, "UPDATE tbl_user SET username = '$username', password = '$password', jk_user = '$jk_user', foto = '$foto' WHERE id_user = $id_user");
    $simpan_teknisi = mysqli_query($conn, "UPDATE tbl_teknisi SET nm_teknisi = '$nm_teknisi', telp_teknisi = '$telp_teknisi', alamat_teknisi = '$alamat_teknisi', wilayah_teknisi = '$wilayah_teknisi' WHERE id_user = $id_user");

    if ($simpan_user && $simpan_cust) {
        header("Location: profile.php");
    } else {
        header("Location: profile.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>SERASI - Edit Profile</title>
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
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="../dist/css/style.min.css" />
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
                                <h4 class="fw-semibold mb-8">Edit Profile</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted " href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Profile</li>
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
                                    <p class="card-subtitle mb-3">Silahkan mengedit <b>Profile</b> pada form dibawah ini...!</p>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nm_teknisi" class="form-label">Nama Lengkap :</label>
                                            <input type="text" class="form-control" name="nm_teknisi" id="nm_teknisi" value="<?php echo $row_user["nm_teknisi"] ?>" placeholder="Masukkan Nama Lengkap Anda" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username :</label>
                                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $row_user["username"] ?>" placeholder="Masukkan Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password :</label>
                                            <input type="text" class="form-control" name="password" id="password" value="<?php echo $row_user["password"] ?>" placeholder="Masukkan Password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jk_user" class="form-label">Jenis Kelamin :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="jk_user" id="jk_user" class="form-control">
                                                        <option value="lk" <?php if ($row_user["jk_user"] == 'lk') echo "SELECTED"; ?>>Laki-laki</option>
                                                        <option value="pr" <?php if ($row_user["jk_user"] == 'pr') echo "SELECTED"; ?>>Perempuan</option>
                                                        <option value="" <?php if ($row_user["jk_user"] == '') echo "SELECTED"; ?>>Tidak memilih</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telp_teknisi" class="form-label">Nomor Telepon :</label>
                                            <input type="text" class="form-control" name="telp_teknisi" id="telp_teknisi" value="<?php echo $row_user["telp_teknisi"] ?>" placeholder="Masukkan Nomor Telepon Anda" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_teknisi" class="form-label">Alamat :</label>
                                            <textarea class="form-control" name="alamat_teknisi" id="alamat_teknisi" rows="5" placeholder="Masukkan Alamat Lengkap Anda" required><?php echo $row_user["alamat_teknisi"] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wilayah_teknisi" class="form-label">Wilayah :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="wilayah_teknisi" id="wilayah_teknisi" class="form-control">
                                                        <option value="">--Piih Kecamatan--</option>
                                                        <option value="1" <?php if ($row_user["wilayah_teknisi"] == 1) echo "SELECTED"; ?>>Banjarmasin Utara</option>
                                                        <option value="2" <?php if ($row_user["wilayah_teknisi"] == 2) echo "SELECTED"; ?>>Banjarmasin Barat</option>
                                                        <option value="3" <?php if ($row_user["wilayah_teknisi"] == 3) echo "SELECTED"; ?>>Banjarmasin Tengah</option>
                                                        <option value="4" <?php if ($row_user["wilayah_teknisi"] == 4) echo "SELECTED"; ?>>Banjarmasin Timur</option>
                                                        <option value="5" <?php if ($row_user["wilayah_teknisi"] == 5) echo "SELECTED"; ?>>Banjarmasin Selatan</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_lama" class="form-label">Foto Profil Lama :</label><br>
                                            <img src="../profil/<?php echo $row_user["foto"] ?>" class="rounded-circle" width="80" height="80" alt="user" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Upload Foto Profil Baru :</label>
                                            <input type="file" class="form-control" name="foto" id="foto">
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-1" name="submit"><i class="ti ti-device-floppy"></i> Simpan</button>
                                            <a href="index.php" class="btn btn-secondary"><i class="ti ti-arrow-left"></i> Cancel</a><br>
                                        </div>
                                    </form>
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
</body>

</html>