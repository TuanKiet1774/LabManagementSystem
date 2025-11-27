<?php

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

    //search
    function deviceSearch($con, $keyword)  {
        if (empty($keyword)) return "";

        $keyword = mysqli_real_escape_string($con, $keyword);

        return "AND (
            tb.TenThietBi LIKE '%$keyword%' OR 
            loai.TenLoai LIKE '%$keyword%' OR 
            tttb.TenTTTB LIKE '%$keyword%'
        )";
    }

    //them tb
    function deviceAdd($con, $tenThietBi, $maLoai, $maTTTB) {
        $loaiQuery = mysqli_query($con, "SELECT TenLoai FROM loai WHERE MaLoai='$maLoai'");
        $loaiRow = mysqli_fetch_assoc($loaiQuery);
        $tenLoai = $loaiRow['TenLoai'];

        // Tạo prefix theo tên loại
        switch ($tenLoai) {
            case "Ghế":
                $prefix = "GHE";
                break;
            case "Bàn phím":
                $prefix = "BP";
                break;
            case "Ti vi":
                $prefix = "TV";
                break;
            case "Dây cáp":
                $prefix = "DC";
                break;
            case "Bàn":
                $prefix = "BAN";
                break;
            case "Máy tính bàn":
                $prefix = "MTB";
                break;
            case "Chuột":
                $prefix = "CH";
                break;
            default:
                $prefix = "TB";
        }

        // Lấy mã lớn nhất theo prefix
        $maxQuery = mysqli_query(
            $con,
            "SELECT MaThietBi FROM thietbi 
                WHERE MaThietBi LIKE '$prefix%' 
                ORDER BY MaThietBi DESC 
                LIMIT 1"
        );

        if (mysqli_num_rows($maxQuery) > 0) {
            $rowMax = mysqli_fetch_assoc($maxQuery);

            $num = (int) filter_var($rowMax['MaThietBi'], FILTER_SANITIZE_NUMBER_INT);
            $num++;
        } else {
            $num = 1;
        }

        // Tạo mã mới
        $maThietBi = $prefix . sprintf("%03d", $num);


        $sql1 = "INSERT INTO thietbi(MaThietBi, TenThietBi, MaLoai)
                    VALUES('$maThietBi', '$tenThietBi', '$maLoai')";

        $sql2 = "INSERT INTO chitiettttb(MaThietBi, MaTTTB)
                    VALUES('$maThietBi', '$maTTTB')";

        if (mysqli_query($con, $sql1) && mysqli_query($con, $sql2)) {
            return ['success' => true, 'maPhong' => $maThietBi];
        } else {
            return ['success' => false, 'error' => mysqli_error($con)];
        }
    }

    //detail 
    function deviceDetail($maThietBi) {
        include("../Database/config.php");
        $maThietBi = mysqli_real_escape_string($con, $maThietBi);
        // Câu truy vấn lấy chi tiết thiết bị
        $sql = "SELECT tb.*, tttb.TenTTTB, loai.*
                FROM thietbi tb
                JOIN loai ON loai.MaLoai = tb.MaLoai
                JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
                JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
                WHERE tb.MaThietBi = '$maThietBi'
                ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$result || mysqli_num_rows($result) == 0) {
            return null; // Không có thiết bị
        }
        // Xử lý ảnh
        $imagePath = "Image/" . $row['MaLoai'] . ".jpg";
        if (!file_exists($imagePath)) {
            $imagePath = "Image/noimage.png";
        }
        // Thêm đường dẫn ảnh vào kết quả trả về
        $row['Image'] = $imagePath;
        return $row;
    }

    //edit
    function deviceEdit($con, $maThietBi, $tenThietBi, $maLoai, $maTTTB) {
        // Cập nhật bảng thietbi
        $sql1 = "UPDATE thietbi SET 
                        TenThietBi='$tenThietBi',
                        MaLoai='$maLoai'
                    WHERE MaThietBi='$maThietBi'";

        // Cập nhật tên trạng thái thiết bị
        $sql2 = "UPDATE chitiettttb SET 
                        MaTTTB='$maTTTB'
                    WHERE MaThietBi='$maThietBi'";

        $ok = mysqli_query($con, $sql1)
            && mysqli_query($con, $sql2);
        return $ok;
    }

    //get detail(edit): lấy lại thông tin thiết bị sau khi chỉnh sửa:
    function getEdit_Detail_Device($con, $maThietBi) {
        $sql = "SELECT tb.*, tttb.*, loai.*, cttttb.MaTTTB
            FROM thietbi tb
            JOIN loai ON loai.MaLoai = tb.MaLoai
            JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
            JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
            WHERE tb.MaThietBi= '$maThietBi'";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function deviceSendMailNotification($fromEmail, $toEmail, $tenThietBi, $maThietBi, $trangThai)
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
            $mail->Password   = 'qefi dapq qqxp onpw';  // App password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Người gửi - người nhận
            $mail->setFrom($fromEmail, 'Hệ thống Lab Management');
            $mail->addAddress($toEmail);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = "Cập nhật trạng thái thiết bị $tenThietBi";
            $mail->Body    = "
                <h3>Thông báo cập nhật trạng thái thiết bị</h3>
                <p><b>Mã thiết bị:</b> $maThietBi</p>
                <p><b>Tên thiết bị:</b> $tenThietBi</p>
                <p><b>Trạng thái mới:</b> 
                    <span style='color:blue; font-weight:bold;'>$trangThai</span>
                </p>
            ";

            $mail->send();
            return true; // thành công

        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return false; // thất bại
        }
    }

    //delete confirm
    function deviceDeleteConfirm($con, $maThietBi) {
        $sql1 = "DELETE FROM chitiettttb WHERE MaThietBi='$maThietBi'";
        $sql2 = "DELETE FROM thietbi WHERE MaThietBi='$maThietBi'";

        $ok = mysqli_query($con, $sql1) && mysqli_query($con, $sql2);
        return $ok;
    }

    //delete
    function deviceDelete($con, $maThietBi) {
        $sql = "SELECT tb.*, tttb.TenTTTB, loai.*
                FROM thietbi tb
                JOIN loai ON loai.MaLoai = tb.MaLoai
                JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
                JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
                WHERE tb.MaThietBi= '$maThietBi'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

?>
