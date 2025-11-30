<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Chỉnh sửa thông tin cá nhân</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    body {
        background: #f0f4f8;
        /* Xanh xám nhạt hiện đại */
    }

    .edit-box {
        width: 100%;
        max-width: 80%;
        margin: 40px auto;
        padding: 25px;
        background: white;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.15);
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

<body>
    <?php
    include './Controller/loginController.php';
    include './Controller/profileController.php';
    $user = checkLogin();
    $maND = $_SESSION['MaND'];
    $message = '';

    // Lấy dữ liệu user
    $row = getUserInfo($con, $maND);
    $avatarPath = !empty($row['Anh']) ? './Image/' . $row['Anh'] : './Image/default_avatar.png';

    if (isset($_POST['btn-submit'])) {
        $hoTen = $_POST['hoTen'];
        $parts = explode(' ', $hoTen, 2);
        $Ho = $parts[0] ?? '';
        $Ten = $parts[1] ?? '';

        $avatarFile = uploadAvatar($_FILES['avatar']) ?? $row['Anh'] ?? 'default_avatar.png';

        $data = [
            'Ho' => $Ho,
            'Ten' => $Ten,
            'Email' => $_POST['email'] ?? '',
            'Sdt' => $_POST['sdt'] ?? '',
            'GioiTinh' => $_POST['gioiTinh'] ?? '',
            'NgaySinh' => $_POST['ngaySinh'] ?? '',
            'DiaChi' => $_POST['diaChi'] ?? '',
            'Anh' => $avatarFile,
            'MaKhoa' => $_POST['khoa'] ?? '',
            'Lop' => $_POST['lop'] ?? ''
        ];

        if (updateUserInfo($con, $maND, $data)) {
            $newInfo = getUserInfo($con, $maND);
            updateSession($newInfo);
            echo "<script>
                alert('Cập nhật thành công!');
                window.location.href = 'profile.php';
              </script>";
        } else {
            echo "<script>alert('Lỗi cập nhật: " . mysqli_error($con) . "');</script>";
        }
        exit();
    }
    ?>
    <?php include './header.php'; ?>
    <div class="edit-box">
        <div class="edit-header text-center">CHỈNH SỬA THÔNG TIN CÁ NHÂN</div>
        <form method="POST" enctype="multipart/form-data" class="p-4">
            <div class="row">
                <div class="col-md-4 d-flex flex-column align-items-center text-center mb-4">
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
                            <input type="text" name="maND" class="form-control" style="background-color: #f1f1f1;" value="<?= $row['MaND'] ?? '' ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Họ và tên</label>
                            <input type="text" name="hoTen" class="form-control" value="<?= ($row['Ho'] ?? '') . ' ' . ($row['Ten'] ?? '') ?>" placeholder="Nhập Họ Tên">
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
                            <label class="fw-bold d-block">Giới tính</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gioiTinh" id="gioiTinhNam" value="1" <?= ($row['GioiTinh'] == 1 ? 'checked' : '') ?>>
                                <label class="form-check-label" for="gioiTinhNam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gioiTinh" id="gioiTinhNu" value="0" <?= ($row['GioiTinh'] == 0 ? 'checked' : '') ?>>
                                <label class="form-check-label" for="gioiTinhNu">Nữ</label>
                            </div>
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
                            <label class="form-label"><i class="fa-solid fa-book"></i> Khoa viện</label>
                            <select name="khoa" class="form-select" required>
                                <?php
                                $defaultKhoaName = isset($row['TenKhoa']) ? $row['TenKhoa'] : "";
                                $defaultKhoaId = isset($row['MaKhoa']) ? $row['MaKhoa'] : "";
                                if ($defaultKhoaName) {
                                    echo "<option value='$defaultKhoaId' selected>$defaultKhoaName</option>";
                                } else {
                                    echo "<option value='' disabled selected>Chọn khoa</option>";
                                }
                                $sqlKhoa = "SELECT * FROM khoa ORDER BY TenKhoa ASC";
                                $resultKhoa = mysqli_query($con, $sqlKhoa);
                                while ($k = mysqli_fetch_assoc($resultKhoa)) {
                                    if ($k['MaKhoa'] == $defaultKhoaId) continue;
                                    echo "<option value='" . $k['MaKhoa'] . "'>" . $k['TenKhoa'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <?php if ($user['MaVT'] !== 'QTV' && $user['MaVT'] !== 'GV'): ?>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Lớp</label>
                                <input type="text" name="lop" class="form-control" value="<?= htmlspecialchars($row['Lop'] ?? '') ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <a href="profile.php" class="btn btn-primary px-4">Quay lại</a>
                <button type="submit" class="btn btn-save px-4" name="btn-submit">Lưu thay đổi</button>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>