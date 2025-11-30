<?php
include("../Database/config.php");
include_once('./Controller/controller.php');
include_once('./Controller/deviceController.php');
include_once('./Controller/loginController.php');
$user = checkLogin();
$vaiTro = $user['MaVT'] ?? '';
if ($vaiTro !== 'QTV') {
    header("Location: device.php?error=permission");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Thêm thiết bị</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
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
        text-align: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 32px;
        font-weight: 700;
        margin: 30px 0;
        letter-spacing: 1px;
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
        padding: 14px;
        font-size: 18px;
        color: #3f3d56;
    }

    td {
        padding: 15px;
        border: 1px solid #eee;
        font-size: 16px;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
        background: #f0f5ff;
        font-size: 15px;
        transition: 0.25s;
    }

    input[type="text"]:focus,
    select:focus {
        background: #e6f0ff;
        border-color: #93c5fd;
        outline: none;
    }

    .btn-add {
        display: inline-block;
        padding: 8px;
        font-size: 16px;
        background-color: #60a5fa;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-add:hover {
        background: #048ff9ff;
    }

    .back-btn {
        display: block;
        width: 140px;
        margin: 20px auto;
        padding: 12px;
        background: #a5b4fc;
        color: white;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
    }

    .back-btn:hover {
        background: #818cf8;
    }
</style>

<body>
    <?php
    include_once("./header.php");
    $loai = mysqli_query($con, "SELECT * FROM loai");
    $tttb = mysqli_query($con, "SELECT * FROM trangthaithietbi");

    if (isset($_POST['submit'])) {
        $tenThietBi = $_POST['tenThietBi'];
        $maLoai = $_POST['maLoai'];
        $maTTTB = $_POST['maTTTB'];

        $result = deviceAdd($con, $tenThietBi, $maLoai, $maTTTB);


        if ($result['success']) {
            echo "<script>
            alert('Thêm thiết bị thành công!');
            window.location.href = 'device.php';
          </script>";
        } else {
            echo "<script>
            alert('Lỗi cập nhật: " . mysqli_error($con) . "');
          </script>";
        }
    }
    ?>

    <h2>Thêm thiết bị</h2>
    <form method="POST">
        <div class="table-responsive">
            <table>
                <tr>
                    <th colspan="2">THÔNG TIN THIẾT BỊ MỚI</th>
                </tr>
                <tr>
                    <td>Tên thiết bị:</td>
                    <td><input type="text" class="form-control" name="tenThietBi" required></td>
                </tr>


                <tr>
                    <td>Tên loại:</td>
                    <td>
                        <select class="form-control" name="maLoai" required>
                            <option value="">-- Chọn loại thiết bị --</option>
                            <?php while ($r = mysqli_fetch_assoc($loai)) { ?>
                                <option value="<?= $r['MaLoai'] ?>"><?= $r['TenLoai'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>


                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <select class="form-control" name="maTTTB" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <?php while ($t = mysqli_fetch_assoc($tttb)) { ?>
                                <option value="<?= $t['MaTTTB'] ?>"><?= $t['TenTTTB'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center" style="background:#fcfec7ff;">
                        <button type="submit" name="submit" class="btn-add w-md-auto">Thêm thiết bị</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>

    <div style='text-align:center;'>
        <a class='back-btn w-md-auto d-inline-block' href='device.php'>Quay lại</a>
    </div>

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