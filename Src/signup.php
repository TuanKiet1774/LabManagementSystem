<!doctype html>
<html lang="en">

<head>
    <title>Đăng ký</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    .background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: url('Image/background.jpg') center/cover no-repeat;
        filter: blur(5px);
        z-index: -1;
    }

    .signup {
        width: 100%;
        max-width: 70%;
        margin: 40px auto;
        padding: 20px 30px;
        background-color: #eeebebff;
        border-radius: 20px;
        font-size: 15px;
    }

    form {
        align-items: center;
    }

    .welcome {
        color: #003569ff;
    }

    input[type='text'],
    input[type='password'],
    input[type='date'] {
        padding: 5px;
        border: none;
        border-radius: 5px;
        width: 100%;
    }

    .btnBack {
        background-color: orange;
    }

    .btnDK {
        background-color: green;
    }

    .btnDK,
    .btnBack {
        color: white;
        padding: 7px;
        border-radius: 10px;
        border: 1px solid black;
        text-decoration: none;
    }

    .btnBack:hover {
        background-color: white;
        color: orange;
    }

    .btnDK:hover {
        background-color: white;
        color: green;
    }

    tr,
    td {
        padding: 5px;
    }

    header {
        font-size: 15px;
    }

    .logo-header {
        width: 50px;
        border-radius: 50%;
    }

    .navbar {
        background-color: #001f3e !important;
    }

    .navbar a {
        color: white !important;
        font-weight: bold;
    }

    select {
        width: 100%;
        padding-block: 5px;
        padding-inline: 10px;
        background-color: white;
        border-radius: 5px;
        border: none;
    }
</style>

<body>
    <div class="background"></div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark w-100">
            <div class="container-fluid">
                <a class="navbar-brand fs-6 mt-1" href="#">
                    <img src="./Image/Logo.png" class="logo-header" alt="Logo LAB MANAGEMENT">
                    HỆ THỐNG QUẢN LÝ PHÒNG THỰC HÀNH
                </a>
            </div>
        </nav>
    </header>
    <main>
        <?php
        include_once('../Database/config.php');
        include_once('./Controller/signupController.php');
        insertUser($con);
        ?>
        <div class="signup">
            <h4 class="welcome text-center mb-4"><b>HÃY ĐĂNG KÝ ĐỂ SỬ DỤNG HỆ THỐNG</b></h4>
            <form action="" method="post">
                <!-- Họ và tên -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label"><i class="fa-solid fa-user"></i> Họ</label>
                        <input type="text" name="ho" class="form-control" placeholder="Nguyễn" value="<?php echo isset($_POST['ho']) ? $_POST['ho'] : "" ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-user"></i> Tên</label>
                        <input type="text" name="ten" class="form-control" placeholder="Hải Triều" value="<?php echo isset($_POST['ten']) ? $_POST['ten'] : "" ?>" required>
                    </div>
                </div>

                <!-- Email và mật khẩu -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label"><i class="fa-solid fa-at"></i> Email</label>
                        <input type="email" name="email" class="form-control" placeholder="trieu.nh.cntt@ntu.edu.vn" value="<?php echo isset($_POST['email']) ? $_POST['email'] : "" ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-unlock-keyhole"></i> Mật khẩu</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                </div>

                <!-- Ngày sinh và số điện thoại -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Ngày sinh</label>
                        <input type="date" name="ngsinh" class="form-control" value="<?php echo isset($_POST['ngsinh']) ? $_POST['ngsinh'] : "" ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-mobile-screen"></i> Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control" placeholder="0123456789" value="<?php echo isset($_POST['sdt']) ? $_POST['sdt'] : "" ?>" required>
                    </div>
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-map-location"></i> Địa chỉ</label>
                    <input type="text" style="width: 100%;" name="dchi" placeholder="02 Nguyễn Đình Chiểu, phường Bắc Nha Trang" value="<?php echo isset($_POST['dchi']) ? $_POST['dchi'] : "" ?>" required>
                </div>

                <!-- Giới tính -->
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-person-half-dress"></i> Giới tính</label>
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" name="gt" value="1" checked>
                        <label class="form-check-label">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gt" value="0">
                        <label class="form-check-label">Nữ</label>
                    </div>
                </div>

                <!-- Vai trò và lớp -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label"><i class="fa-solid fa-address-book"></i> Vai trò</label>
                        <select name="vaitro" class="form-select" required>
                            <option value="">-- Chọn vai trò --</option>
                            <option value="GV" <?php echo isset($vaitro) && $vaitro == "GV" ? "selected" : ""; ?>>Giảng viên</option>
                            <option value="SV" <?php echo isset($vaitro) && $vaitro == "SV" ? "selected" : ""; ?>>Sinh viên</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-chalkboard-user"></i> Lớp</label>
                        <input type="text" name="lop" class="form-control" placeholder="64.CNTT-1">
                    </div>
                </div>

                <!-- Khoa viện -->
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-book"></i> Khoa viện</label>
                    <select name="khoa" class="form-select" required>
                        <option value="">-- Chọn khoa --</option>
                        <?php
                        $sqlKhoa = "SELECT * FROM khoa ORDER BY TenKhoa ASC";
                        $resultKhoa = mysqli_query($con, $sqlKhoa);
                        while ($row = mysqli_fetch_assoc($resultKhoa)) {
                            $selected = (isset($khoa) && $khoa == $row['MaKhoa']) ? "selected" : "";
                            echo "<option value='" . $row['MaKhoa'] . "' $selected>" . $row['TenKhoa'] . "</option>";
                        } ?>
                    </select>
                </div>

                <!-- Nút -->
                <div class="text-center">
                    <a href="./login.php" class="btnBack me-3">Quay lại</a>
                    <button type="submit" name="btnDK" class="btnDK">Đăng ký</button>
                </div>
            </form>
        </div>
    </main>
    <?php include './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>