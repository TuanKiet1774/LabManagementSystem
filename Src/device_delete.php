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
    <title>Xoá thiết bị</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    body {
        font-family: "Inter", "Segoe UI", Arial, sans-serif;
        min-height: 100vh;
    }

    h2 {
        text-align: center;
        color: #ffffff;
        font-size: 32px;
        margin-bottom: 30px;
        font-weight: 700;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

    .info {
        font-size: 16px;
        margin-bottom: 15px;
        color: #1e293b;
        background: #eff6ffff;
        padding: 15px 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        border-right: 4px solid #667eea;
        text-align: left;
    }

    .btn {
        display: inline-block;
        padding: 14px 28px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        cursor: pointer;
        margin: 8px;
        border: none;
        overflow: hidden;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-delete:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(100, 116, 139, 0.4);
    }

    .btn-cancel:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.4);
    }

    .info-box {
        background: #eff6ff;
        padding: 15px 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        border-right: 4px solid #667eea;
    }
</style>
<body>
    <?php
    include("./header.php");
    if (!isset($_GET['maThietBi'])) {
        echo "<p style='text-align:center; color:red;'>Không xác định được phòng!</p>";
        exit;
    }

    $maThietBi = $_GET['maThietBi'];
    // Lấy thông tin phòng để hiển thị
    $row = deviceDelete($con, $maThietBi);

    if (!$row) {
        echo "
                <div class='container d-flex justify-content-center' 
                    style='min-height: calc(100vh - 200px);'>
                    <div class='text-center'>
                        <p class='text-danger fw-bold mt-1'>Thiết bị không tồn tại!</p>
                        <a href='thietbi.php' class='btn btn-secondary mt-2'>Quay lại</a>
                    </div>
                </div>
                ";
        include("./footer.php");
        exit;
    }

    // Xử lý xóa khi submit
    if (isset($_POST['confirm_delete'])) {


        $ok = deviceDeleteConfirm($con, $maThietBi);

        if ($ok) {
            echo "<p style='text-align:center; color:green;'>Xóa thiết bị thành công!</p>";
            echo "<div style='text-align:center; margin-top:20px;'>
                        <a class='btn btn-cancel' href='device.php' style='color: white;'>Quay lại danh sách</a>
                    </div>";
        } else {
            echo "<p style='text-align:center; color:red;'>Lỗi khi xóa: " . mysqli_error($con) . "</p>";
        }
    }
    ?>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h2>Xóa thiết bị</h2>
                <div class="bg-white p-4 p-md-5 shadow rounded-4" style='background-color: #f2f4fcff;'>
                    <div class="info-box mb-3"><strong>Mã thiết bị:</strong> <?= $row['MaThietBi'] ?></div>
                    <div class="info-box mb-3"><strong>Tên thiết bị:</strong> <?= $row['TenThietBi'] ?></div>
                    <div class="info-box mb-3"><strong>Tên loại:</strong> <?= $row['TenLoai'] ?></div>
                    <div class="info-box mb-3"><strong>Trạng thái:</strong> <?= $row['TenTTTB'] ?></div>

                    <p style="color:#b91c1c; font-weight:bold;">Bạn có chắc chắn muốn xóa thiết bị này?</p>

                    <form method="POST" class="text-center">
                        <button type="submit" name="confirm_delete" class="btn btn-delete" style='color: white;'>Xóa thiết bị</button>
                        <a href="device.php" class="btn btn-cancel" style='color: white;'>Hủy</a>
                    </form>
                </div>
            </div>
        </div>
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