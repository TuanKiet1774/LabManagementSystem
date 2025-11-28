<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Thông tin cá nhân</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>

<style>
    .btnBack {
        background: #93c5fd !important;
        color: white !important;
    }

    .btnBack:hover {
        background: #60a5fa !important;
    }


    .btnDelete {
        background: #fda4af !important;
        color: white !important;
    }

    .btnDelete:hover {
        background: #fb7185 !important;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once './Controller/loginController.php';
    include_once './Controller/userController.php';
    $user = checkLogin();
    $db1 = mysqli_query($con, $sql1);
    $col1 = mysqli_fetch_assoc($db1);
    $maND1 = isset($_GET['maND']) ? $_GET['maND'] : '';

    if (isset($_GET['btnDelete'])) {
        if (deleteUser($con, $maND1)) {
            echo "<script>
                alert('Xoá người dùng thành công!');
                window.location.href = 'user.php';
              </script>";
        } else {
            echo "<script>alert('Lỗi cập nhật: " . mysqli_error($con) . "');</script>";
        }
        exit();
    }
    ?>
    <?php include './header.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg border-0" style="background: #fffbe6; border-radius: 15px;">

                <div class="card-header text-danger text-center fw-bold fs-4" style="background: #fff9cc; border-radius: 15px 15px 0 0;">
                    BẠN CÓ CHẮC MUỐN XOÁ THÔNG TIN NÀY ?
                </div>

                <div class="card-body p-4">
                    <div class="row align-items-center justify-content-center">

                        <!-- Ảnh đại diện -->
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <?php
                            $avatarFile = basename($col1['Anh'] ?? 'default_avatar.png');
                            $path = './Image/' . $avatarFile;
                            echo "<img src='$path' class='rounded-circle shadow' width='180' height='180'>";
                            ?>
                        </div>

                        <!-- Thông tin -->
                        <div class="col-md-8">
                            <table class="table table-borderless fs-5">
                                <tr>
                                    <th><i class="bi bi-person"></i> Họ tên: <?= $col1['Ho'] . " " . $col1['Ten']; ?></th>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-envelope"></i> Email: <?= $col1['Email']; ?></th>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-building"></i> Khoa: <?= $col1['TenKhoa'] ?? ''; ?></th>
                                </tr>

                                <?php if (!empty($col1['Lop'])): ?>
                                    <tr>
                                        <th><i class="bi bi-collection"></i> Lớp: <?= $col1['Lop']; ?></th>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <th><i class="bi bi-gender-ambiguous"></i> Giới tính: <?= $col1['GioiTinh'] == 1 ? 'Nam' : 'Nữ'; ?></th>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-telephone"></i> Số điện thoại: <?= $col1['sdt']; ?></th>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-calendar"></i> Ngày sinh: <?= date('d/m/Y', strtotime($col1['NgaySinh'])) ?></th>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-geo-alt"></i> Địa chỉ: <?= $col1['DiaChi']; ?></th>
                                </tr>
                            </table>
                            <div class="col-12 text-end">
                                <i class="text-muted">Tài khoản được tạo lúc <?php echo date("d/m/Y H:i", strtotime($col1['NgayTao'])); ?></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center" style="background: #fff9cc; border-radius: 0 0 15px 15px;">
                    <form method="GET" class="col-12 text-center">
                        <input type="hidden" name="maND" value="<?php echo $maND1; ?>">

                        <a href="javascript:window.history.back();" class="btnBack btn ms-2 me-2">Quay lại</a>
                        <button type="submit" name="btnDelete" class="btnDelete btn ms-2 me-2">
                            Xác nhận
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <?php include './footer.php'; ?>

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