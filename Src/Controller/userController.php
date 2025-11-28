<?php
### List 
function infoUser($search)
{
    $sql = "SELECT nd.MaND, nd.Ho, nd.Ten, nd.NgaySinh, nd.Email, vt.TenVT, k.TenKhoa
            FROM nguoidung nd
            INNER JOIN vaitro vt ON nd.MaVT = vt.MaVT
            INNER JOIN khoa k ON nd.MaKhoa = k.MaKhoa";

    $where = [];
    $where[] = "nd.MaVT <> 'QTV'";

    if ($search !== "") {
        $where[] = "(nd.MaND LIKE '%$search%' 
                    OR CONCAT(nd.Ho, ' ', nd.Ten) LIKE '%$search%'
                    OR vt.TenVT LIKE '%$search%')";
    }

    $sql .= " WHERE " . implode(" AND ", $where);
    $sql .= " ORDER BY nd.MaND ASC";

    return $sql;
}

### Detail
$maND = isset($_GET['maND']) ? $_GET['maND'] : '';
$sql1 = "SELECT nd.Anh, nd.MaND, nd.Ho, nd.Ten, nd.NgaySinh, nd.GioiTinh, nd.Email, nd.DiaChi, nd.sdt, nd.Lop, nd.NgayTao, vt.TenVT, k.TenKhoa
            FROM nguoidung nd
            INNER JOIN vaitro vt ON nd.MaVT = vt.MaVT
            INNER JOIN khoa k ON nd.MaKhoa = k.MaKhoa
            WHERE nd.MaND = '$maND'";


### Edit
function getUserInfo($con, $maND)
{
    $sql = "SELECT nd.MaVT ,nd.Anh, nd.MaND, nd.Ho, nd.Ten, nd.NgaySinh, nd.GioiTinh, nd.Email, nd.DiaChi, nd.sdt, nd.Lop, nd.NgayTao, vt.TenVT, k.TenKhoa, k.MaKhoa
            FROM nguoidung nd
            INNER JOIN vaitro vt ON nd.MaVT = vt.MaVT
            INNER JOIN khoa k ON nd.MaKhoa = k.MaKhoa
            WHERE nd.MaND = '$maND'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

### Delete
function deleteUser($con, $maND)
{
    $maND = mysqli_real_escape_string($con, $maND);
    $sql = "DELETE FROM nguoidung WHERE MaND = '$maND'";
    $result = mysqli_query($con, $sql);
    return $result;
}

### Insert 
function updateUserInfo($con, $maND, $data)
{
    $hoTen = trim($data['hoTen'] ?? '');
    $email = trim($data['email'] ?? '');
    $sdt = trim($data['sdt'] ?? '');
    $gioiTinh = isset($data['gioiTinh']) ? intval($data['gioiTinh']) : null;
    $ngaySinh = $data['ngaySinh'] ?? '';
    $diaChi = trim($data['diaChi'] ?? '');
    $maKhoa = $data['khoa'] ?? '';
    $lop = trim($data['lop'] ?? '');

    $ho = '';
    $ten = '';
    if ($hoTen !== '') {
        $parts = explode(' ', $hoTen);
        $ho = array_shift($parts);
        $ten = implode(' ', $parts);
    }

    $ho = mysqli_real_escape_string($con, $ho);
    $ten = mysqli_real_escape_string($con, $ten);
    $email = mysqli_real_escape_string($con, $email);
    $diaChi = mysqli_real_escape_string($con, $diaChi);
    $lop = mysqli_real_escape_string($con, $lop);
    $maKhoa = mysqli_real_escape_string($con, $maKhoa);
    $ngaySinh = mysqli_real_escape_string($con, $ngaySinh);
    $maND = mysqli_real_escape_string($con, $maND);

    $sql = "UPDATE nguoidung SET 
                Ho = '$ho', 
                Ten = '$ten', 
                Email = '$email', 
                sdt = '$sdt', 
                GioiTinh = $gioiTinh, 
                NgaySinh = '$ngaySinh', 
                DiaChi = '$diaChi', 
                MaKhoa = '$maKhoa', 
                Lop = '$lop'
            WHERE MaND = '$maND'";

    return mysqli_query($con, $sql);
}
