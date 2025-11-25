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

        $sql = "SELECT * FROM nguoidung WHERE Email = '$user' LIMIT 1";
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
            $_SESSION['Anh']     = $col['Anh'];
            $_SESSION['NgaySinh'] = $col['NgaySinh'] ?? "";
            $_SESSION['GioiTinh'] = $col['GioiTinh'] ?? "";
            $_SESSION['Sdt']      = $col['Sdt'] ?? "";
            $_SESSION['DiaChi']   = $col['DiaChi'] ?? "";

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
        'MaND'      => $_SESSION['MaND'],
        'HoTen'     => $_SESSION['HoTen'],
        'Email'     => $_SESSION['Email'],
        'MaVT'      => $_SESSION['MaVT'],
        'MaKhoa'    => $_SESSION['MaKhoa'],
        'Lop'       => $_SESSION['Lop'],
        'Anh'       => $_SESSION['Anh'],
        'NgaySinh'  => $_SESSION['NgaySinh'] ?? "",
        'GioiTinh'  => $_SESSION['GioiTinh'] ?? "",
        'sdt'       => $_SESSION['Sdt'] ?? "",
        'DiaChi'    => $_SESSION['DiaChi'] ?? ""
    ];
}

function logout($page = "login.php")
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: $page");
    exit();
}
