<?php
### List
function infoHistory($search)
{
    $sql = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, ttpm.MaTTPM, ttpm.TenTTPM, nd.Ho, nd.Ten
                FROM phieumuon pm
                INNER JOIN chitietttpm ctpm 
                ON pm.MaPhieu = ctpm.MaPhieu
                INNER JOIN trangthaiphieumuon ttpm
                ON ctpm.MaTTPM = ttpm.MaTTPM
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND";
    $condition = "WHERE pm.MucDich LIKE '%$search%' 
                OR ttpm.TenTTPM LIKE '%$search%'
                OR CONCAT(nd.Ho, ' ', nd.Ten) LIKE '%$search%'";
    $sort = "ORDER BY MaPhieu DESC";

    if (isset($search) && $search !== "") {
        $sqlfull = $sql . " " . $condition . " " . $sort;
    } else {
        $sqlfull = $sql . " " . $sort;
    }

    return $sqlfull;
}

### Detail
$maphieu = isset($_GET['maphieu']) ? $_GET['maphieu'] : '';
$sql1 = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, p.TenPhong, nd.Ho, nd.Ten, nd.Email, np.TenNhom
                FROM phieumuon pm
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND
                INNER JOIN phong p
                ON pm.MaPhong = p.MaPhong
                INNER JOIN nhomphong np
                ON p.MaNhom = np.MaNhom
                WHERE pm.MaPhieu = '$maphieu'";

$sql2 = "SELECT tgm.MaTGM, tt.TenTTT AS TrangThaiTuan, nt.TenNgay AS NgayTrongTuan, th.TenTiet, th.GioBG, th.GioKT
            FROM thoigianmuon tgm
            INNER JOIN tiethoc th 
            ON tgm.MaTiet = th.MaTiet
            INNER JOIN trangthaituan tt 
            ON tgm.MaTTT = tt.MaTTT
            INNER JOIN ngaytuan nt 
            ON tgm.MaNgay = nt.MaNgay
            WHERE tgm.MaPhieu = '$maphieu'
            ORDER BY th.GioBG";

### Eidt
function editHistory($con, $maphieu, $mattpm)
{
    $sql = "UPDATE chitietttpm 
            SET MaTTPM = '$mattpm' 
            WHERE MaPhieu = '$maphieu'";
    mysqli_query($con, $sql);
}

### Delete
function deleteHistory($con, $maphieu)
{
    $sqlDeleteTG = "DELETE FROM thoigianmuon WHERE MaPhieu = '$maphieu'";
    mysqli_query($con, $sqlDeleteTG);

    $sqlDeleteCTTPM = "DELETE FROM chitietttpm WHERE MaPhieu = '$maphieu'";
    mysqli_query($con, $sqlDeleteCTTPM);

    $sqlDeletePM = "DELETE FROM phieumuon WHERE MaPhieu = '$maphieu'";
    mysqli_query($con, $sqlDeletePM);
}
