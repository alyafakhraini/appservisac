<?php
include "koneksi.php";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $jk_user = $_POST["jk_user"];
    $level = $_POST["level"];

    // Cek apakah username sudah ada di database
    $sql_check_user = "SELECT * FROM tbl_user WHERE username = '$username'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows == 0) {
        $status = ($level == '3') ? 'aktif' : 'pending';
        $simpan_user = "INSERT INTO tbl_user (username, password, jk_user, foto, level, status) VALUES ('$username', '$password', '$jk_user', '', '$level', '$status')";

        if ($conn->query($simpan_user) === TRUE) {
            $user_id = $conn->insert_id; // Mendapatkan id dari tbl_user yang baru saja dimasukkan

            if ($level == '2') {
                $nm_teknisi = $_POST["nm_teknisi"];
                $telp_teknisi = $_POST["telp_teknisi"];
                $alamat_teknisi = $_POST["alamat_teknisi"];
                $wilayah_teknisi = $_POST["wilayah_teknisi"];

                $simpan_teknisi = "INSERT INTO tbl_teknisi (id_user, nm_teknisi, alamat_teknisi, wilayah_teknisi, telp_teknisi) VALUES ('$user_id', '$nm_teknisi', '$alamat_teknisi', '$wilayah_teknisi', '$telp_teknisi')";
                if ($conn->query($simpan_teknisi) === TRUE) {
                    header("Location: index.php");
                    exit(); // Pastikan untuk keluar dari skrip setelah redirect
                } else {
                    $error = "Error: " . $simpan_teknisi . "<br>" . $conn->error;
                }
            } else if ($level == '3') {
                $nm_cust = $_POST["nm_cust"];
                $alamat_cust = $_POST["alamat_cust"];
                $wilayah_cust = $_POST["wilayah_cust"];
                $telp_cust = $_POST["telp_cust"];
                $email_cust = $_POST["email_cust"];

                $simpan_cust = "INSERT INTO tbl_customer (id_user, nm_cust, alamat_cust, wilayah_cust, telp_cust, email_cust) VALUES ('$user_id', '$nm_cust', '$alamat_cust', '$wilayah_cust', '$telp_cust', '$email_cust')";
                if ($conn->query($simpan_cust) === TRUE) {
                    header("Location: index.php");
                    exit(); // Pastikan untuk keluar dari skrip setelah redirect
                } else {
                    $error = "Error: " . $simpan_cust . "<br>" . $conn->error;
                }
            } else {
                header("Location: index.php");
                exit(); // Pastikan untuk keluar dari skrip setelah redirect
            }
        } else {
            $error = "Error: " . $simpan_user . "<br>" . $conn->error;
        }
    } else {
        $error = "Username sudah ada. Silakan pilih username lain.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>Serasi | Registrasi Akun</title>
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
                                <h5 class="mb-4 text-center">Registrasi Akun - Servis AC Banjarmasin (SERASI)</h5>
                                <form id="regisForm" action="" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="jk_user" class="form-label">Jenis Kelamin</label>
                                        <select name="jk_user" id="jk_user" class="form-control" onchange="showForm()" required>
                                            <option value="">--Pilih Jenis Kelamin--</option>
                                            <option value="lk">Laki-laki</option>
                                            <option value="pr">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="level" class="form-label">Anda Mendaftar Sebagai?</label>
                                        <select name="level" id="levelSelect" class="form-control" onchange="showForm()" required>
                                            <option value="">--Pilih Level--</option>
                                            <option value="3">Customer</option>
                                            <option value="2">Teknisi</option>
                                        </select>
                                    </div>
                                    <?php if (isset($error)) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Warning...!</strong> <?php echo $error ?>
                                        </div>
                                    <?php } ?>

                                    <div id="custForm" style="display: none;">
                                        <div class="mb-4">
                                            <label for="nm_cust" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nm_cust" class="form-control" id="nm_cust" placeholder="Masukkan Nama Lengkap anda" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="telp_cust" class="form-label">Nomor Telepon</label>
                                            <input type="number" name="telp_cust" class="form-control" id="telp_cust" placeholder="Masukkan Nomor Telepon anda" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email_cust" class="form-label">Email</label>
                                            <input type="email" name="email_cust" class="form-control" id="email_cust" placeholder="Masukkan Email anda yang aktif" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="alamat_cust" class="form-label">Alamat</label>
                                            <textarea name="alamat_cust" class="form-control" id="alamat_cust" rows="5" placeholder="Masukkan Alamat anda" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wilayah_cust" class="form-label">Wilayah :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="wilayah_cust" id="wilayah_cust" class="form-control">
                                                        <option value="">--Piih Kecamatan--</option>
                                                        <option value="1">Banjarmasin Utara</option>
                                                        <option value="2">Banjarmasin Barat</option>
                                                        <option value="3">Banjarmasin Tengah</option>
                                                        <option value="4">Banjarmasin Timur</option>
                                                        <option value="5">Banjarmasin Selatan</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="teknisiForm" style="display: none;">
                                        <div class="mb-4">
                                            <label for="nm_teknisi" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nm_teknisi" class="form-control" id="nm_teknisi" placeholder="Masukkan Nama Lengkap anda" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="telp_teknisi" class="form-label">Nomor Telepon</label>
                                            <input type="number" name="telp_teknisi" class="form-control" id="telp_teknisi" placeholder="Masukkan Nomor Telepon anda" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="alamat_teknisi" class="form-label">Alamat</label>
                                            <textarea name="alamat_teknisi" class="form-control" id="alamat_teknisi" rows="5" placeholder="Masukkan Alamat anda" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="wilayah_teknisi" class="form-label">Wilayah :</label>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="wilayah_teknisi" id="wilayah_teknisi" class="form-control">
                                                        <option value="">--Piih Kecamatan--</option>
                                                        <option value="1">Banjarmasin Utara</option>
                                                        <option value="2">Banjarmasin Barat</option>
                                                        <option value="3">Banjarmasin Tengah</option>
                                                        <option value="4">Banjarmasin Timur</option>
                                                        <option value="5">Banjarmasin Selatan</option>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Registrasi</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">Sudah memiliki akun? <a href="index.php" class="text-decoration-none">Log In!</a></p>
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

    <script>
        function showForm() {
            var level = document.getElementById('levelSelect').value;

            var teknisiForm = document.getElementById('teknisiForm');
            var custForm = document.getElementById('custForm');

            if (level === '2') {
                teknisiForm.style.display = 'block';
                custForm.style.display = 'none';
                setRequired(teknisiForm, true);
                setRequired(custForm, false);
            } else if (level === '3') {
                teknisiForm.style.display = 'none';
                custForm.style.display = 'block';
                setRequired(teknisiForm, false);
                setRequired(custForm, true);
            } else {
                teknisiForm.style.display = 'none';
                custForm.style.display = 'none';
                setRequired(teknisiForm, false);
                setRequired(custForm, false);
            }
        }

        function setRequired(formElement, isRequired) {
            var inputs = formElement.querySelectorAll('input, textarea');
            inputs.forEach(function(input) {
                if (isRequired) {
                    input.setAttribute('required', 'required');
                } else {
                    input.removeAttribute('required');
                }
            });
        }
    </script>

</body>

</html>