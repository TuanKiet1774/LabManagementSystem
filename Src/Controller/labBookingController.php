<?php
    function labBookingForm($con, $data) {
        $maPhong = $data['maPhong'];
        $maND = $data['maND'];
        $mucDich = $data['mucDich'];
        $ngayBD = $data['ngayBD'];
        $ngayKT = $data['ngayKT'];
        $maNgay = $data['maNgay'];
        $maTietArr = $data['maTietArr'];
        $maTTT = $data['maTTT'];

        // Lấy mã phiếu lớn nhất
        $sqlGetMax = mysqli_query($con, "SELECT MaPhieu FROM phieumuon ORDER BY MaPhieu DESC LIMIT 1");
        $rowMax = mysqli_fetch_assoc($sqlGetMax);

        if ($rowMax) {
            $so = intval(substr($rowMax['MaPhieu'], 2)) + 1;
            $maPhieu = "PH" . str_pad($so, 3, "0", STR_PAD_LEFT);
        } else {
            $maPhieu = "PH001";
        }

        // 1. Tạo phiếu
        $sql1 = "INSERT INTO phieumuon (MaPhieu, MaPhong, MaND, MucDich, NgayBD, NgayKT, NgayTao)
                VALUES ('$maPhieu', '$maPhong', '$maND', '$mucDich', '$ngayBD', '$ngayKT', NOW())";

        if (!mysqli_query($con, $sql1)) {
            return ["success" => false, "message" => mysqli_error($con)];
        }

        // 2. Trạng thái ban đầu
        $sql2 = "INSERT INTO chitietttpm(MaPhieu, MaTTPM)
                VALUES ('$maPhieu', 'TTPM001')";
        mysqli_query($con, $sql2);

        // 3. Lưu thời gian mượn
        foreach ($maTietArr as $maTiet) {
            $sql3 = "INSERT INTO thoigianmuon (MaPhieu, MaTiet, MaTTT, MaNgay)
                    VALUES ('$maPhieu', '$maTiet', '$maTTT', '$maNgay')";
            mysqli_query($con, $sql3);
        }

        return ["success" => true, "maPhieu" => $maPhieu];
    }   

?>