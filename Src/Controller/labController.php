<?php
//search
function labSearch($con, $keyword)
{
    if (empty($keyword)) return "";

    $keyword = mysqli_real_escape_string($con, $keyword);

    return "AND (
            p.TenPhong LIKE '%$keyword%' OR 
            np.TenNhom LIKE '%$keyword%' OR 
            tt.TenTTP LIKE '%$keyword%'
        )";
}



//Add
function labAdd($con, $tenPhong, $sucChua, $maNhom, $maTTP)
{
    $sqlGetMax = mysqli_query(
        $con,
        "SELECT MaPhong FROM phong ORDER BY MaPhong DESC LIMIT 1"
    );
    $rowMax = mysqli_fetch_assoc($sqlGetMax);

    if ($rowMax) {
        $so = intval(substr($rowMax['MaPhong'], 1));
        $so++;
        $maPhong = "P" . str_pad($so, 3, "0", STR_PAD_LEFT);
    } else {
        $maPhong = "P001";
    }


    $sql1 = "INSERT INTO phong(MaPhong, TenPhong, SucChua, MaNhom)
                VALUES('$maPhong', '$tenPhong', '$sucChua', '$maNhom')";

    $sql2 = "INSERT INTO chitietttp(MaPhong, MaTTP)
                VALUES('$maPhong', '$maTTP')";

    if (mysqli_query($con, $sql1) && mysqli_query($con, $sql2)) {
        return ['success' => true, 'maPhong' => $maPhong];
    } else {
        return ['success' => false, 'error' => mysqli_error($con)];
    }
}

//detail 
function labDetail($maPhong)
{
    include("../Database/config.php");
    $maPhong = mysqli_real_escape_string($con, $maPhong);

    // Câu truy vấn lấy chi tiết phòng
    $sql = "SELECT p.MaPhong, p.TenPhong, p.SucChua, np.*, tt.TenTTP
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE p.MaPhong = '$maPhong'";

    $result = mysqli_query($con, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        return null; // Không có phòng
    }

    $row = mysqli_fetch_assoc($result);

    // --- Lấy danh sách thiết bị ---
    $sqlTb = "SELECT tb.MaThietBi, tb.TenThietBi, l.TenLoai
                FROM thietbi_phong tp
                JOIN thietbi tb ON tb.MaThietBi = tp.MaThietBi
                JOIN loai l ON tb.MaLoai = l.MaLoai
                WHERE tp.MaPhong = '$maPhong'";

    $resultTb = mysqli_query($con, $sqlTb);

    $dsThietBi = [];
    while ($tb = mysqli_fetch_assoc($resultTb)) {
        $dsThietBi[] = $tb;
    }

    $row['ThietBi'] = $dsThietBi;

    // Xử lý ảnh
    $imagePath = "Image/" . $row['MaNhom'] . ".jpg";
    if (!file_exists($imagePath)) {
        $imagePath = "Image/noimage.jpg";
    }

    // Thêm đường dẫn ảnh vào kết quả trả về
    $row['Image'] = $imagePath;

    return $row;
}

//edit 
function labEdit($con, $maPhong, $tenPhong, $sucChua, $maNhom, $maTTP)
{
    // Cập nhật bảng phong
    $sql1 = "UPDATE phong SET 
                        TenPhong='$tenPhong',
                        SucChua='$sucChua',
                        MaNhom='$maNhom'
                    WHERE MaPhong='$maPhong'";

    // Gán trạng thái cho phòng
    $sql2 = "UPDATE chitietttp SET
                        MaTTP='$maTTP'
                    WHERE MaPhong='$maPhong'";

    $ok = mysqli_query($con, $sql1)
        && mysqli_query($con, $sql2);
    return $ok;
}

//get detail(edit): lấy lại thông tin phòng sau khi chỉnh sửa: 
function getEdit_Detail_Lab($con, $maPhong)
{
    $sql = "SELECT p.*, np.*, tt.*, ct.*
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE p.MaPhong = '$maPhong'";

    return mysqli_query($con, $sql);
}


// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// function labSendMailNotification($fromEmail, $toEmail, $tenPhong, $maPhong, $trangThai)
// {
//     $mail = new PHPMailer(true);
//     $mail->CharSet = 'UTF-8';
//     $mail->Encoding = 'base64';

//     try {
//         // Cấu hình SMTP Gmail
//         $mail->isSMTP();
//         $mail->Host       = 'smtp.gmail.com';
//         $mail->SMTPAuth   = true;
//         $mail->Username   = $fromEmail;
//         $mail->Password   = 'qefi dapq qqxp onpw';  // App password
//         $mail->SMTPSecure = 'ssl';
//         $mail->Port       = 465;

//         // Người gửi - người nhận
//         $mail->setFrom($fromEmail, 'Hệ thống Lab Management');
//         $mail->addAddress($toEmail);

//         // Nội dung email
//         $mail->isHTML(true);
//         $mail->Subject = "Cập nhật trạng thái phòng $tenPhong";
//         $mail->Body    = "
//                 <h3>Thông báo cập nhật trạng thái phòng</h3>
//                 <p><b>Mã phòng:</b> $maPhong</p>
//                 <p><b>Tên phòng:</b> $tenPhong</p>
//                 <p><b>Trạng thái mới:</b> 
//                     <span style='color:blue; font-weight:bold;'>$trangThai</span>
//                 </p>
//             ";

//         $mail->send();
//         return true; // thành công

//     } catch (Exception $e) {
//         error_log("Email error: " . $mail->ErrorInfo);
//         return false; // thất bại
//     }
// }

//delete 
function labDelete($con, $maPhong)
{
    $sql = "SELECT p.TenPhong, p.MaPhong, np.TenNhom, tt.TenTTP
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON tt.MaTTP = ct.MaTTP
                WHERE p.MaPhong='$maPhong'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

//delete confirm
function labDeleteConfirm($con, $maPhong)
{
    $sql1 = "DELETE FROM chitietttp WHERE MaPhong='$maPhong'";
    $sql2 = "DELETE FROM phong WHERE MaPhong='$maPhong'";

    $ok = mysqli_query($con, $sql1) && mysqli_query($con, $sql2);
    return $ok;
}
