<?php

function logIn($con)
{
    if (isset($_POST['btnDN'])) {
        $user = trim($_POST['user']);
        $pass = trim($_POST['pass']);

        if (empty($user) || empty($pass)) {
            echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
            return;
        }

        $sql = "SELECT nd.*, k.*, vt.*
                FROM nguoidung nd
                JOIN khoa k ON nd.MaKhoa = k.MaKhoa
                JOIN vaitro vt ON vt.MaVT = nd.MaVT
         WHERE Email = '$user' LIMIT 1";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 0) {
            echo "<script>alert('Email không tồn tại!');</script>";
            return;
        }

        $col = mysqli_fetch_assoc($result);

        if (password_verify($pass, $col['MatKhau'])) {
            // Khởi tạo session
            $_SESSION['MaND']    = $col['MaND'];
            $_SESSION['HoTen']   = $col['Ho'] . ' ' . $col['Ten'];
            $_SESSION['Email']   = $col['Email'];
            $_SESSION['MaVT']    = $col['MaVT'];
            $_SESSION['MaKhoa']  = $col['MaKhoa'];
            $_SESSION['Lop']     = $col['Lop'];
            $_SESSION['Sdt']     = $col['Sdt'];
            $_SESSION['NgaySinh']     = $col['NgaySinh'];
            $_SESSION['GioiTinh']     = $col['GioiTinh'];
            $_SESSION['NgayTao']     = $col['NgayTao'];
            $_SESSION['DiaChi']     = $col['DiaChi'];
            $_SESSION['Anh']     = $col['Anh'];
            $_SESSION['TenVT']     = $col['TenVT'];
            $_SESSION['TenKhoa']     = $col['TenKhoa'];

            // Chuyển hướng theo vai trò
            if ($col['MaVT'] == 'QTV') {
                header("Location: ./index.php?mavt=QTV");
                exit();
            } elseif ($col['MaVT'] == 'GV') {
                header("Location: ./index.php?mavt=GV");
                exit();
            } else {
                header("Location: ./index.php?mavt=SV");
                exit();
            }
        } else {
            echo "<script>alert('Mật khẩu không đúng!');</script>";
        }
    }
}

function checkLogin()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['MaND'])) {
        // Chuyển hướng về login
        header("Location: login.php");
        exit();
    }

    return [
        'MaND'      => $_SESSION['MaND'] ?? '',
        'HoTen'     => $_SESSION['HoTen'] ?? '',
        'Email'     => $_SESSION['Email'] ?? '',
        'MaVT'      => $_SESSION['MaVT'] ?? '',
        'MaKhoa'    => $_SESSION['MaKhoa'] ?? '',
        'Lop'       => $_SESSION['Lop'] ?? '',
        'Anh'       => $_SESSION['Anh'] ?? '',
        'Sdt'       => $_SESSION['Sdt'] ?? '',
        'GioiTinh'  => $_SESSION['GioiTinh'] ?? '',
        'NgaySinh'  => $_SESSION['NgaySinh'] ?? '',
        'DiaChi'    => $_SESSION['DiaChi'] ?? '',
        'TenKhoa'   => $_SESSION['TenKhoa'] ?? '',
        'NgayTao'   => $_SESSION['NgayTao'] ?? ''
    ];
}

function logout($page = "login.php")
{
    // Bắt đầu session nếu chưa bắt đầu
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Hủy session
    session_destroy();

    // Chuyển hướng về trang login
    header("Location: $page");
    exit();
}
?>