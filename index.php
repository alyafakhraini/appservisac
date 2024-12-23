<?php
session_start();
include "koneksi.php";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $login = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password'");
    $jml = mysqli_num_rows($login);

    if ($jml > 0) {
        $row = mysqli_fetch_assoc($login);

        if ($row["status"] == 'aktif') {
            $_SESSION["login"] = true;
            $_SESSION["id_user"] = $row["id_user"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["jk_user"] = $row["jk_user"];
            $_SESSION["foto"] = $row["foto"];
            $_SESSION["level"] = $row["level"];

            if ($row["level"] == 1) {
                header("Location: admin/index.php");
            } else if ($row["level"] == 2) {
                header("Location: teknisi/index.php");
            } else if ($row["level"] == 3) {
                header("Location: cust/index.php");
            }
        } else {
            $error = "Akun Anda belum aktif.Silahkan hubungi Administrator.";
        }
    } else {
        $error = "Username atau Password SALAH.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>Serasi | Login</title>
    <!-- Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="SERASI" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="dist/images/logos/favicon.png" />
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="dist/css/style.min.css" />
</head>

<body style="background-color: #a8dadc;">
    <!-- Preloader -->
    <div class="preloader">
        <img src="dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.php" class="text-nowrap logo-img text-center mb-2 d-block w-100">
                                    <img src="dist/images/logos/logo.png" width="180" alt="logo">
                                </a>
                                <hr>
                                <h5 class="mb-4 text-center">Login Aplikasi - Servis AC Banjarmasin (SERASI)</h5>
                                <form target="" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>
                                    <?php if (isset($error)) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Warning...!</strong> <?php echo $error ?>
                                        </div>
                                    <?php } ?>
                                    <button type="submit" name="login" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Log In</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">Belum memiliki akun? <a href="register.php" class="text-decoration-none">Daftar Sekarang!</a></p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mt-4">
                                        <p class="fs-3 mb-0 fw-medium">Copyright &copy; Serasi | 2024</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Js Files -->
    <script src="dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- core files -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/app.horizontal.init.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.js"></script>
    <!-- current page js files -->
    <script src="dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>
</body>

</html>