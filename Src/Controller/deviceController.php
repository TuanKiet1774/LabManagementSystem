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

?>
