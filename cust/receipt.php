<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
}

if ($_SESSION["level"] != 3) {
    header("Location: logout.php");
}

$id_servis = $_GET["id"];
$query_servis = mysqli_query($conn, "SELECT S.id_servis, S.id_cust, S.tgl_servis,
                                                            J.nm_servis, J.biaya,
                                                            T.id_teknisi, T.nm_teknisi,
                                                            C.nm_cust
                                                    FROM tbl_servis S
                                                    LEFT JOIN tbl_jenis_servis J ON S.id_jenis = J.id_jenis
                                                    LEFT JOIN tbl_teknisi T ON S.id_teknisi = T.id_teknisi
                                                    LEFT JOIN tbl_customer C ON S.id_cust = C.id_cust
                                                    WHERE S.id_servis = $id_servis");
$result_servis = mysqli_num_rows($query_servis);

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
    <title>SERASI - Service Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Service Receipt" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" type="image/png" href="../dist/images/logos/favicon.png" />
    <link rel="stylesheet" href="../dist/css/style.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .receipt-header h1 {
            font-size: 24px;
            color: #007bff;
            margin: 0;
        }

        .receipt-header img {
            max-width: 80px;
            margin: 10px 0;
        }

        .receipt-details {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .receipt-details .row {
            display: flex;
            margin-bottom: 10px;
        }

        .receipt-details .label {
            flex: 1;
            font-weight: bold;
            color: #555;
        }

        .receipt-details .value {
            flex: 2;
            text-align: right;
            color: #333;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            color: #888;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Service Receipt</h1>
            <img src="../dist/images/logos/logo.png" alt="Logo">
        </div>

        <div class="receipt-details">
            <?php while ($row_servis = mysqli_fetch_assoc($query_servis)) { ?>
                <div class="row">
                    <div class="label">Customer Name</div>
                    <div class="value"><?php echo $row_servis["nm_cust"] ?></div>
                </div>
                <div class="row">
                    <div class="label">Service Type</div>
                    <div class="value"><?php echo $row_servis["nm_servis"] ?></div>
                </div>
                <div class="row">
                    <div class="label">Service Date</div>
                    <div class="value">
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
                    </div>
                </div>
                <div class="row">
                    <div class="label">Technician Name</div>
                    <div class="value"><?php echo $row_servis["nm_teknisi"] ?></div>
                </div>
                <div class="row">
                    <div class="label">Cost</div>
                    <div class="value">Rp. <?php echo number_format($row_servis["biaya"], 0, ',', '.'); ?></div>
                </div>
            <?php } ?>
        </div>

        <div class="footer">
            Thank you for using our service!<br>
            <em>For questions, contact our support team.</em>
        </div>
    </div>
</body>

</html>