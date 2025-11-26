<?php
include_once('../Database/config.php');

function getUserInfo($con, $maND) {
    $maND = mysqli_real_escape_string($con, $maND);
    $sql = "SELECT nd.*, k.TenKhoa 
            FROM nguoidung nd 
            LEFT JOIN khoa k ON k.MaKhoa = nd.MaKhoa
            WHERE nd.MaND='$maND'";
    $result = mysqli_query($con, $sql);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : [];
}


function uploadAvatar($file) {
    if (!isset($file) || $file['error'] != 0) return null;

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowedTypes)) return null;
    if ($file['size'] > $maxSize) return null;

    $uploadDir = './Image/';
    $fileName = basename($file['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    return null;
}


function updateUserInfo($con, $maND, $data) {
    $maND = mysqli_real_escape_string($con, $maND);
    $Ho = mysqli_real_escape_string($con, $data['Ho']);
    $Ten = mysqli_real_escape_string($con, $data['Ten']);
    $Email = mysqli_real_escape_string($con, $data['Email']);
    $Sdt = mysqli_real_escape_string($con, $data['Sdt']);
    $GioiTinh = mysqli_real_escape_string($con, $data['GioiTinh']);
    $NgaySinh = mysqli_real_escape_string($con, $data['NgaySinh']);
    $DiaChi = mysqli_real_escape_string($con, $data['DiaChi']);
    $Anh = mysqli_real_escape_string($con, $data['Anh']);
    $MaKhoa = mysqli_real_escape_string($con, $data['MaKhoa']);
    $Lop = mysqli_real_escape_string($con, $data['Lop']);

    $sql = "UPDATE nguoidung SET 
                Ho='$Ho',
                Ten='$Ten',
                Email='$Email',
                Sdt='$Sdt',
                GioiTinh='$GioiTinh',
                NgaySinh='$NgaySinh',
                DiaChi='$DiaChi',
                Anh='$Anh',
                MaKhoa='$MaKhoa',
                Lop='$Lop'
            WHERE MaND='$maND'";

    return mysqli_query($con, $sql);
}


function updateSession($newInfo) {
    $_SESSION['HoTen']   = $newInfo['Ho'] . ' ' . $newInfo['Ten'];
    $_SESSION['Email']   = $newInfo['Email'];
    $_SESSION['Anh']     = $newInfo['Anh'];
    $_SESSION['TenKhoa'] = $newInfo['TenKhoa'];
    $_SESSION['Sdt']     = $newInfo['Sdt'];
    $_SESSION['DiaChi']  = $newInfo['DiaChi'];
    $_SESSION['NgaySinh'] = $newInfo['NgaySinh'];
    $_SESSION['Lop']      = $newInfo['Lop'];
    $_SESSION['GioiTinh'] = $newInfo['GioiTinh'];
}
?>
