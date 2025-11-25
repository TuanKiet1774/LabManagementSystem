<?php
    include_once('../Database/config.php');
    include './Controller/loginController.php';
    $user = checkLogin();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: #f0f4f8; /* Xanh xám nhạt hiện đại */
    }
    .edit-box {
        max-width: 850px;
        margin: 40px auto;
        padding: 25px;
        background: white;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.15);
        border-top: 6px solid #b3a32fff; 
    }
    .edit-header {
        background: #fff9cc;
        color: black;
        padding: 18px;
        font-size: 20px;
        font-weight: bold;
        border-radius: 14px 14px 0 0;
    }
    .avatar-preview {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e7da7fff; 
    }
    .btn-save {
        background: #a4cbf1ff !important; 
        border: none !important;
    }
    .btn-save:hover {
        background: #77a9e7ff !important; 
    }
    </style>
</head>
<body>
<?php 
    include './header.php'; 
    $maND = $_SESSION['MaND'];
    $message = ''; // Biến để hiển thị thông báo

    if (isset($_POST['btn-submit'])) {
        $maND = mysqli_real_escape_string($con, $_POST['maND']);
        $hoTen = mysqli_real_escape_string($con, $_POST['hoTen']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $sdt = mysqli_real_escape_string($con, $_POST['sdt']);
        $gioiTinh = mysqli_real_escape_string($con, $_POST['gioiTinh']);
        $ngaySinh = mysqli_real_escape_string($con, $_POST['ngaySinh']);
        $diaChi = mysqli_real_escape_string($con, $_POST['diaChi']);
        $tenKhoa = mysqli_real_escape_string($con, $_POST['khoa']); 
        $lop = mysqli_real_escape_string($con, $_POST['lop']);

        $parts = explode(' ', $hoTen, 2);
        $Ho = mysqli_real_escape_string($con, $parts[0] ?? '');
        $Ten = mysqli_real_escape_string($con, $parts[1] ?? '');

        // Xử lý upload avatar
        $avatarFile = $row['Anh'] ?? $_SESSION['Anh'] ?? 'default_avatar.png';

        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] == 0) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (in_array($_FILES['avatar']['type'], $allowedTypes) && $_FILES['avatar']['size'] <= $maxSize) {

                $uploadDir = './Image/';
                $fileName = basename($_FILES['avatar']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                    $avatarFile = $fileName;
                    $avatarPath = './Image/' . $fileName;
                } else {
                    $message = "<p style='text-align:center; color:red;'>Lỗi upload ảnh.</p>";
                }

            } else {
                $message = "<p style='text-align:center; color:red;'>Ảnh không hợp lệ (chỉ JPG/PNG/GIF, tối đa 2MB).</p>";
            }
        }


        // Cập nhật bảng nguoidung
        $sql1 = "UPDATE nguoidung SET 
                    Ho='$Ho',
                    Ten='$Ten',
                    Email='$email',
                    Sdt='$sdt',
                    GioiTinh='$gioiTinh',
                    NgaySinh='$ngaySinh',
                    DiaChi='$diaChi',
                    Anh='$avatarFile',
                    MaKhoa=(SELECT MaKhoa FROM khoa WHERE TenKhoa='$tenKhoa' LIMIT 1),
                    Lop='$lop'
                WHERE MaND='$maND'";

        // Cập nhật bảng khoa (chỉ nếu cần, ví dụ: nếu TenKhoa thay đổi và MaKhoa không trùng)
        $sql2 = "UPDATE khoa SET
                    TenKhoa='$tenKhoa'
                WHERE MaKhoa=(SELECT MaKhoa FROM nguoidung WHERE MaND='$maND')";

        $ok = mysqli_query($con, $sql1) && mysqli_query($con, $sql2);

        if ($ok) {
            $reload = mysqli_query($con, 
            "SELECT nd.*, k.TenKhoa 
            FROM nguoidung nd 
            JOIN khoa k ON k.MaKhoa = nd.MaKhoa
            WHERE nd.MaND = '$maND'"
            );
            $newInfo = mysqli_fetch_assoc($reload);

            // Cập nhật SESSION
            $_SESSION['HoTen']   = $newInfo['Ho'] . " " . $newInfo['Ten'];
            $_SESSION['Email']   = $newInfo['Email'];
            $_SESSION['Anh']     = $avatarFile;
            $_SESSION['TenKhoa'] = $newInfo['TenKhoa'];
            $_SESSION['Sdt']     = $newInfo['Sdt'];
            $_SESSION['DiaChi']  = $newInfo['DiaChi'];
            $_SESSION['NgaySinh'] = $newInfo['NgaySinh'];
            $_SESSION['Lop']      = $newInfo['Lop'];
            $_SESSION['GioiTinh'] = $newInfo['GioiTinh'];
            $message = "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
        } else {
            $message = "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";
        }
    }

    // Luôn load dữ liệu (lần đầu hoặc sau cập nhật)
    if (isset($maND)) {
        $sql = "SELECT nd.*, k.*, nd.Anh
                FROM nguoidung nd
                JOIN khoa k ON k.MaKhoa = nd.MaKhoa
                WHERE nd.MaND = '$maND'";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            $message = "<p style='text-align:center; color:red;'>Không tìm thấy dữ liệu người dùng.</p>";
            $row = []; // Tránh lỗi nếu không có dữ liệu
        }
        // Xác định avatar để hiển thị
        if (!empty($row['Anh'])) {
            $avatarPath = './Image/' . basename($row['Anh']);
        } elseif (!empty($_SESSION['Anh'])) {
            $avatarPath = './Image/' . basename($_SESSION['Anh']);
        } else {
            $avatarPath = './Image/default_avatar.png';
        }

    }
?>
<div class="edit-box">
    <div class="edit-header text-center">
        CHỈNH SỬA THÔNG TIN CÁ NHÂN
    </div>
    <?= $message ?> <!-- Hiển thị thông báo -->
    <form method="POST" enctype="multipart/form-data" class="p-4">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <img src="<?= $avatarPath ?>" id="previewImg" class="avatar-preview mb-3">
                <input type="file" name="avatar" id="avatarInput" accept="image/*" hidden>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('avatarInput').click();">
                    Chọn ảnh
                </button>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Mã người dùng</label>
                        <input type="text" name="maND" class="form-control" value="<?= $row['MaND'] ?? '' ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Họ và tên</label>
                        <input type="text" name="hoTen" class="form-control" value="<?= ($row['Ho'] ?? '') . ' ' . ($row['Ten'] ?? '') ?>" placeholder="Nhập Họ Tên (vd: Nguyễn Văn A)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $row['Email'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control" value="<?= $row['Sdt'] ?? '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Giới tính</label>
                        <select name="gioiTinh" class="form-select">
                            <option value="1" <?= ($row['GioiTinh'] == 1 ? 'selected' : '') ?>>Nam</option>
                            <option value="0" <?= ($row['GioiTinh'] == 0 ? 'selected' : '') ?>>Nữ</option>
                        </select>

                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Ngày sinh</label>
                        <input type="date" name="ngaySinh" class="form-control" value="<?= $row['NgaySinh'] ?? '' ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Địa chỉ</label>
                    <input type="text" name="diaChi" class="form-control" value="<?= $row['DiaChi'] ?? '' ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Khoa</label>
                        <input type="text" name="khoa" class="form-control" value="<?= $row['TenKhoa'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Lớp</label>
                        <input type="text" name="lop" class="form-control" value="<?= $row['Lop'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-save px-4" name="btn-submit">Lưu thay đổi</button>
            <a href="profile.php" class="btn btn-primary px-4">Quay lại</a>
        </div>
    </form>
</div>
<?php include './footer.php'; ?>
<script>
    document.getElementById("avatarInput").addEventListener("change", function(e) {
        let file = e.target.files[0];
        if (file) {
            document.getElementById("previewImg").src = URL.createObjectURL(file);
        }
    });
</script>
</body>
</html>
