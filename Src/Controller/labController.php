<?php
    function labAdd($con, $tenPhong, $sucChua, $maNhom, $maTTP) {
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

        // Chống SQL Injection
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
    function getEdit_Detail($con, $maPhong)
    {
        $sql = "SELECT p.*, np.*, tt.*, ct.*
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE p.MaPhong = '$maPhong'";

        return mysqli_query($con, $sql);
    }

    //delete 
    function labDelete($con, $maPhong) {
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

        return mysqli_query($con, $sql1) && mysqli_query($con, $sql2);
    }

?>