<?php
function generateNextMaND($conn)
{
    $sql = "SELECT MaND FROM nguoidung ORDER BY MaND DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastMaND = $row['MaND'];
        $number = intval(substr($lastMaND, 2));
        $nextNumber = $number + 1;
        $newMaND = 'ND' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    } else {
        $newMaND = "ND001";
    }

    return $newMaND;
}


function insertUser($con)
{
    if (isset($_POST['btnDK'])) {
        $ma = generateNextMaND($con);
        $ho = trim($_POST['ho']);
        $ten = trim($_POST['ten']);
        $email = trim($_POST['email']);
        $pass = $_POST['pass'];
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $ngsinh = $_POST['ngsinh'];
        $sdt = trim($_POST['sdt']);
        $gt = $_POST['gt'];
        $diaChi = trim($_POST['dchi']);
        $vaitro = $_POST['vaitro'];
        $khoa = $_POST['khoa'];
        $lop = $vaitro == 'GV' ? NULL : trim($_POST['lop']);
        $anh = $gt == 1 ? "male.jpg" : "female.jpg";

        $sql = "INSERT INTO nguoidung (MaND, MaVT, Ho, Ten, Email, MatKhau, Anh, Sdt, NgaySinh, GioiTinh, DiaChi, MaKhoa, Lop, NgayTao)VALUES ('$ma', '$vaitro', '$ho', '$ten', '$email', '$passHash', '$anh', '$sdt', '$ngsinh', '$gt', '$diaChi', '$khoa', '$lop', NOW())";

        if (empty($ma) || empty($ho) || empty($ten) || empty($email) || empty($pass) || empty($ngsinh) || empty($sdt) || empty($diaChi) || empty($vaitro) || empty($khoa)) {
            echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
        } else {
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location.href = './login.php';</script>";
            } else {
                echo "<script>alert('Đăng ký thất bại! Vui lòng thử lại.');</script>";
            }
        }
    }
}

?>