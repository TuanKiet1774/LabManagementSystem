<?php
### List
function infoHistory($search, $user)
{
    $sql = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao,
                    ttpm.MaTTPM, ttpm.TenTTPM,
                    nd.Ho, nd.Ten
            FROM phieumuon pm
            INNER JOIN chitietttpm ctpm ON pm.MaPhieu = ctpm.MaPhieu
            INNER JOIN trangthaiphieumuon ttpm ON ctpm.MaTTPM = ttpm.MaTTPM
            INNER JOIN nguoidung nd ON pm.MaND = nd.MaND";

    $where = [];

    if ($search !== "") {
        $where[] = "(pm.MucDich LIKE '%$search%' 
                    OR ttpm.TenTTPM LIKE '%$search%'
                    OR CONCAT(nd.Ho, ' ', nd.Ten) LIKE '%$search%')";
    }

    if ($user['MaVT'] !== 'QTV') {
        $MaND = $user['MaND'];
        $where[] = "pm.MaND = '$MaND'";
    }

    if (count($where) > 0) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " ORDER BY pm.MaPhieu DESC";

    return $sql;
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

### Send Email on Edit

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMailNotification($fromEmail, $toEmail, $tenPhong, $maPhieu, $mucDich, $trangthai)
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    try {
        // Cấu hình SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $fromEmail;
        $mail->Password   = 'inwf mpad thax aqma';  // App password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Người gửi - người nhận
        $mail->setFrom($fromEmail, 'Hệ thống Lab Management');
        $mail->addAddress($toEmail);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = "Yêu cầu mượn phòng $tenPhong";
        $mail->Body    = "
            <h3>Thông báo cập nhật trạng thái phiếu mượn</h3>
            <p><b>Mã phiếu:</b> $maPhieu</p>
            <p><b>Mục đích:</b> $mucDich</p>
            <p><b>Trạng thái mới:</b> 
                <span style='color:blue; font-weight:bold;'>$trangthai</span>
            </p>
        ";

        $mail->send();
        return true; // thành công

    } catch (Exception $e) {
        error_log("Email error: " . $mail->ErrorInfo);
        return false; // thất bại
    }
}
