<?php
function labBookingForm($con, $data)
{
    $maPhong   = $data['maPhong'];
    $maND      = $data['maND'];
    $mucDich   = $data['mucDich'];
    $ngayBD    = $data['ngayBD'];
    $ngayKT    = $data['ngayKT'];
    $maNgayArr = $data['maNgay'];    // array: CHUNHAT, THUBA...
    $maTietArr = $data['maTietArr']; // array: MaTiet
    $maTTT     = $data['maTTT'];

    mysqli_begin_transaction($con);

    try {
        // ------------------------------
        // 1. Kiểm tra trùng lặp
        // ------------------------------
        foreach ($maNgayArr as $maNgay) {
            foreach ($maTietArr as $maTiet) {
                if (empty($maNgay) || empty($maTiet)) continue;

                $sqlCheck = "
                    SELECT p.MaPhieu, p.MaPhong, t.MaTiet, t.MaNgay, p.NgayBD, p.NgayKT
                    FROM thoigianmuon t
                    INNER JOIN phieumuon p ON t.MaPhieu = p.MaPhieu
                    WHERE p.MaPhong = '$maPhong'
                    AND t.MaTiet = '$maTiet'
                    AND t.MaNgay = '$maNgay'
                    AND (
                        ('$ngayBD' BETWEEN p.NgayBD AND p.NgayKT)
                        OR ('$ngayKT' BETWEEN p.NgayBD AND p.NgayKT)
                        OR (p.NgayBD BETWEEN '$ngayBD' AND '$ngayKT')
                        OR (p.NgayKT BETWEEN '$ngayBD' AND '$ngayKT')
                    )
                ";

                $resCheck = mysqli_query($con, $sqlCheck);
                if (!$resCheck) throw new Exception("Lỗi kiểm tra trùng: " . mysqli_error($con));

                if (mysqli_num_rows($resCheck) > 0) {
                    $row = mysqli_fetch_assoc($resCheck);
                    throw new Exception("Không thể tạo phiếu mượn! Phòng '{$maPhong}', Tiết '{$maTiet}', Ngày '{$maNgay}' đã được đặt từ {$row['NgayBD']} đến {$row['NgayKT']}.");
                }
            }
        }

        // ------------------------------
        // 2. Tạo mã phiếu mới
        // ------------------------------
        $sqlGetMax = mysqli_query($con, "SELECT MaPhieu FROM phieumuon ORDER BY MaPhieu DESC LIMIT 1");
        $rowMax = mysqli_fetch_assoc($sqlGetMax);
        $maPhieu = $rowMax ? "PH" . str_pad(intval(substr($rowMax['MaPhieu'], 2)) + 1, 3, "0", STR_PAD_LEFT) : "PH001";

        // ------------------------------
        // 3. Insert bảng phieumuon
        // ------------------------------
        $sql1 = "INSERT INTO phieumuon (MaPhieu, MaPhong, MaND, MucDich, NgayBD, NgayKT, NgayTao)
                 VALUES ('$maPhieu', '$maPhong', '$maND', '$mucDich', '$ngayBD', '$ngayKT', NOW())";
        if (!mysqli_query($con, $sql1)) throw new Exception("Lỗi tạo phiếu: " . mysqli_error($con));

        // ------------------------------
        // 4. Trạng thái ban đầu
        // ------------------------------
        $sql2 = "INSERT INTO chitietttpm (MaPhieu, MaTTPM) VALUES ('$maPhieu', 'TTPM001')";
        if (!mysqli_query($con, $sql2)) throw new Exception("Lỗi tạo trạng thái phiếu: " . mysqli_error($con));

        // ------------------------------
        // 5. Insert thời gian mượn
        // ------------------------------
        $inserted = false;
        foreach ($maTietArr as $maTiet) {
            foreach ($maNgayArr as $maNgay) {
                $sql3 = "INSERT INTO thoigianmuon (MaPhieu, MaTiet, MaTTT, MaNgay)
                         VALUES ('$maPhieu', '$maTiet', '$maTTT', '$maNgay')";
                if (!mysqli_query($con, $sql3)) {
                    throw new Exception("Lỗi insert thời gian mượn: " . mysqli_error($con) . " | SQL: $sql3");
                }
                $inserted = true;
            }
        }

        if (!$inserted) throw new Exception("Không có ngày hợp lệ để insert.");

        mysqli_commit($con);
        return ["success" => true, "maPhieu" => $maPhieu];
    } catch (Exception $e) {
        mysqli_rollback($con);
        return ["success" => false, "message" => $e->getMessage()];
    }
}
