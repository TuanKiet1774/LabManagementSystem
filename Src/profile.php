<?php
    include_once('../Database/config.php');
    include './Controller/loginController.php';
    $user = checkLogin();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin cá nhân</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    
</style>
</head>

<body>

    <?php 
    include './header.php'; 
    $gioiTinhText = ($user['GioiTinh'] == 1) ? 'Nam' : 'Nữ';
    $user['GioiTinh'] = $gioiTinhText;
    if (!empty($user['NgaySinh'])) {
        $user['NgaySinh'] = date('d/m/Y', strtotime($user['NgaySinh']));
    } else {
        $user['NgaySinh'] = ''; // hoặc hiển thị "Chưa cập nhật"
    }
    ?>

<div class="container mt-5 mb-5">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-lg border-0" style="background: #fffbe6; border-radius: 15px;">

            <div class="card-header text-center fw-bold fs-4" style="background: #fff9cc; border-radius: 15px 15px 0 0;">
                THÔNG TIN CÁ NHÂN
            </div>

            <div class="card-body p-4">
                <div class="row align-items-center justify-content-center">

                    <!-- Ảnh đại diện -->
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <?php 
                            $avatarFile = basename($_SESSION['Anh'] ?? 'default_avatar.png'); 
                            $path = './Image/' . $avatarFile;
                            echo "<img src='$path' class='rounded-circle shadow' width='180' height='180'>";
                        ?>
                    </div>

                    <!-- Thông tin -->
                    <div class="col-md-8">
                        <table class="table table-borderless fs-5">
                            <tr>
                                <th><i class="bi bi-person-badge"></i> Mã người dùng: <?= $user['MaND']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-person"></i> Họ tên: <?= $user['HoTen']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-envelope"></i> Email: <?= $user['Email']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-building"></i> Khoa: <?= $user['TenKhoa']; ?></th>
                            </tr>

                            <?php if (!empty($user['Lop'])): ?>
                                <tr><th><i class="bi bi-collection"></i> Lớp: <?= $user['Lop']; ?></th></tr>
                            <?php endif; ?>

                            <tr>
                                <th><i class="bi bi-gender-ambiguous"></i> Giới tính: <?= $user['GioiTinh']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-telephone"></i> Số điện thoại: <?= $user['Sdt']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-calendar"></i> Ngày sinh: <?= $user['NgaySinh']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-geo-alt"></i> Địa chỉ: <?= $user['DiaChi']; ?></th>
                            </tr>
                            <tr>
                                <th><i class="bi bi-clock-history"></i> Ngày tạo: <?= $user['NgayTao']; ?></th>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="card-footer text-center" style="background: #fff9cc; border-radius: 0 0 15px 15px;">
                <a href="index.php" class="btn btn-secondary px-4 mx-2">Về trang chủ</a>
                <a href="edit_profile.php" class="btn btn-primary px-4 mx-2">Chỉnh sửa</a>
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