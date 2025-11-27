<?php
include("../Database/config.php");
include_once('./Controller/controller.php');
include_once('./Controller/deviceController.php');
include_once('./Controller/loginController.php');
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
$user = checkLogin();
$vaiTro = $user['MaVT'] ?? '';
$suaTT = ($vaiTro === 'GV');
$laQTV = ($vaiTro === 'QTV');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Cập nhật thông tin thiết bị</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f5ff;
        }

        h2 {
            text-align: center;
            color: #6a5acd;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 55%;
            margin: 10px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #feffddff;
            color: #3f3d56;
            padding: 12px;
            font-size: 18px;
            text-align: center;
        }

        td {
            padding: 15px;
            border: 1px solid #eee;
            vertical-align: top;
            font-size: 16px;
            color: #333;
        }

        input[type="text"],
        select.form-control  {
            width: 75%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #c7d2fe;
            background: #f0f5ff;
            font-size: 15px;
            text-overflow: hidden;
        }

        select.form-control:disabled, input[type="text"][readonly] {
            background: #e2e2e2ff; 
            color: #333;
            cursor: not-allowed;
        }

        select.form-control:disabled:hover,
        input[type="text"][readonly]:hover,
        select.form-control:disabled:focus,
        input[type="text"][readonly]:focus {
            background: #e2e2e2; 
            outline: none;
        }

        input[readonly]:focus,
        input[disabled],
        input[disabled]:focus,
        select.form-control:disabled,
        select.form-control:disabled:focus {
            background: #e2e2e2;
            color: #333;
            cursor: not-allowed;
            outline: none;
            box-shadow: none; 
        }

        input[type="text"]:focus,
        select.form-control:focus {
            background: #e6f0ff;
            border-color: #93c5fd;
            outline: none;
        }

        .btn-submit {
            display: inline-block;
            padding: 12px;
            font-size: 16px;
            background-color: #60a5fa;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-submit:hover {
            background: #048ff9ff;
        }

        .back-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 18px;
            text-decoration: none;
            background: #a5b4fc;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            text-align: center;
        }

        .back-btn:hover {
            background: #818cf8;
        }
    </style>
</head>


<body>
    <?php
    include("./header.php");
    // Lấy mã tb
    if (isset($_GET['maThietBi'])) {
        $maThietBi = $_GET['maThietBi'];
    }

    $dsLoai = mysqli_query($con, "SELECT * FROM loai");
    $dsTTTB = mysqli_query($con, "SELECT * FROM trangthaithietbi");


    if (isset($_POST['submit'])) {

        $maThietBi = $_POST['maThietBi'];
        $tenThietBi = $_POST['tenThietBi'];
        $maLoai = $_POST['maLoai'];
        $maTTTB = $_POST['maTTTB'];

        if ($maTTTB == "TTTB001") {
            $trangThai = "Hoạt động tốt";
        } elseif ($maTTTB == "TTTB002") {
            $trangThai = "Đang bảo trì";
        } elseif ($maTTTB == "TTTB003") {
            $trangThai = "Cần kiểm tra lại";
        } else {
            $trangThai = "Hỏng";
        }


        $ok = deviceEdit($con, $maThietBi, $tenThietBi, $maLoai, $maTTTB);

        if ($ok) {
            echo "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
            $fromEmail = $_SESSION['Email'];
            $toEmail = 'binh.nht.64cntt@ntu.edu.vn';
            $mailSent = deviceSendMailNotification($fromEmail, $toEmail, $tenThietBi, $maThietBi, $trangThai);
            if ($mailSent) {
                echo "<p style='text-align:center; color:blue;'>Email thông báo đã được gửi!</p>";
            } else {
                echo "<p style='text-align:center; color:red;'>Gửi email thất bại. Kiểm tra cấu hình SMTP.</p>";
            }



            $ok = deviceEdit($con, $maThietBi, $tenThietBi, $maLoai, $maTTTB);

            if ($ok) {
                echo "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
                if($vaiTro === 'GV') {
                    $queryQTV = mysqli_query($con, "SELECT Email FROM nguoidung WHERE MaVT = 'QTV' LIMIT 1");
                    $rowQTV = mysqli_fetch_assoc($queryQTV);
                    $toEmail = $rowQTV['Email'];
                    $fromEmail = $_SESSION['Email'];
                    $mailSent = deviceSendMailNotification($fromEmail, $toEmail, $tenThietBi, $maThietBi, $trangThai);
                    if ($mailSent) {
                        echo "<p style='text-align:center; color:blue;'>Email thông báo đã được gửi!</p>";
                    } else {
                        echo "<p style='text-align:center; color:red;'>Gửi email thất bại. Kiểm tra cấu hình SMTP.</p>";
                    }
                }
            } 
            else {
                echo "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";
            }

            $result = getEdit_Detail_Device($con, $maThietBi);
            $row = mysqli_fetch_assoc($result);
        } else if (isset($maThietBi)) {
            $result = getEdit_Detail_Device($con, $maThietBi);
            $row = mysqli_fetch_assoc($result);

        } else {
            echo "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";

        }

        $result = getEdit_Detail_Device($con, $maThietBi);
        $row = mysqli_fetch_assoc($result);
    } else if (isset($maThietBi)) {
        $result = getEdit_Detail_Device($con, $maThietBi);
        $row = mysqli_fetch_assoc($result);
    }

    if (!empty($row)) {
    ?>
        <form method="POST">
            <div class="table-responsive">
                <table>
                    <tr>
                        <th colspan="2">CẬP NHẬT THÔNG TIN THIẾT BỊ</th>
                    </tr>

                    <tr>
                        <td>Mã thiết bị:</td>
                        <td><input type="text" class="form-control" name="maThietBi" value="<?= $row['MaThietBi'] ?>" readonly></td>
                    </tr>

                    <tr>
                        <td>Tên thiết bị:</td>
                        <td><input type="text" class="form-control" name="tenThietBi" value="<?= $row['TenThietBi'] ?>" <?= $laQTV ? '' : 'readonly' ?>></td>
                    </tr>
                    <tr>
                        <td>Tên loại:</td>
                        <td>
                            <select class="form-control" name="maLoai" <?= $laQTV ? '' : 'disabled' ?> required
                                style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe;">
                                <?php while ($l = mysqli_fetch_assoc($dsLoai)) { ?>
                                    <option value="<?= $l['MaLoai'] ?>"
                                        <?= $l['MaLoai'] == $row['MaLoai'] ? 'selected' : '' ?>>
                                        <?= $l['TenLoai'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php if (!$laQTV) { ?>
                                <input type="hidden" name="maLoai" value="<?= $row['MaLoai'] ?>">
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select class="form-control" name="maTTTB" required
                                style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe; background:#f0f5ff;">
                                <?php while ($t = mysqli_fetch_assoc($dsTTTB)) { ?>
                                    <option value="<?= $t['MaTTTB'] ?>"
                                        <?= $t['MaTTTB'] == $row['MaTTTB'] ? 'selected' : '' ?>>
                                        <?= $t['TenTTTB'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" style="background:#feffddff;">
                            <input type="submit" name="submit" value="Cập nhật" class='btn-submit w-md-auto'>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    <?php
        // }: đóng if (!empty($row))
    } else {
        echo "<p style='text-align:center; color:red;'>Không tìm thấy phòng!</p>";
    }
    echo "<div style='text-align:center;'>
            <a class='back-btn w-md-auto d-inline-block' href='device.php'>Quay lại</a>
            </div>";
    ?>
    <?php include("./footer.php"); ?>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>