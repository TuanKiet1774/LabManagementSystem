<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng máy</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f5ff; /* tím pastel rất nhẹ */
            padding-top: 20px;
        }

        h2 {
            text-align: center;
            color: #6a5acd;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        }

        th {
            background: #c7d2fe; /* Pastel Indigo */
            color: #3f3d56;
            padding: 12px;
            font-size: 16px;
        }

        td {
            padding: 10px;
            font-size: 15px;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #f0f5ff; 
        }

        tr:hover {
            background-color: #e6f0ff;
            transition: 0.2s;
        }

        td a {
            display: inline-block;
            padding: 6px 10px;
            margin: 2px;
            text-decoration: none;
            color: white;
            background: #93c5fd; 
            border-radius: 6px;
            font-size: 14px;
        }

        td a:hover {
            background: #60a5fa;
        }


        td a:nth-child(3) {
            background: #fda4af;
        }

        td a:nth-child(3):hover {
            background: #fb7185;
        }


        td a:nth-child(2) {
            background: #fbbf24;
        }

        td a:nth-child(2):hover {
            background: #f59e0b;
        }

        /*btn add  */
        .table-header {
            width: 80%;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .btn-add {
            padding: 10px 20px;
            background: #1096fd;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.25s;
            float: right;
        }

        .btn-add:hover {
            background: #60a5fa;
        }

        /* page */
        .pagination {
            margin: 20px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            text-decoration: none;
            background: #e0e7ff;       
            color: #4338ca;
            border-radius: 6px;
            font-size: 15px;
            min-width: 35px;
        }

        .pagination a:hover {
            background: #c7d2fe;
        }

        .pagination .current {
            background: #6366f1;
            color: white;
        }
    </style>
</head>
<body>
    <?php include("../Src/header.php"); ?>
    <?php
        include("../Database/config.php");
        if(!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $keyword = $_GET['keyword'] ?? '';
        $search = "";
        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($con, $keyword);
            $search = "AND (
                p.TenPhong LIKE '%$keyword%' OR 
                np.TenNhom LIKE '%$keyword%' OR 
                tt.TenTTP LIKE '%$keyword%'
            )";
        }
        $rowPerPage = 10;
        $offset=($_GET['page'] - 1) * $rowPerPage;
        // $sqlCount = "SELECT COUNT(*) as total from phong";
        $sqlCount = "SELECT COUNT(*) as total
             FROM phong p
             JOIN nhomphong np ON np.MaNhom = p.MaNhom
             JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
             JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
             WHERE 1=1 $search";
        $resultCount = mysqli_query($con, $sqlCount); 
        $rowCount = mysqli_fetch_assoc($resultCount);
        $totalRow = $rowCount['total'];
        $maxPage = ceil($totalRow/$rowPerPage);
        

        $sql = "SELECT p.MaPhong, p.TenPhong, p.SucChua, np.TenNhom, tt.TenTTP
        FROM phong p
        JOIN nhomphong np ON np.MaNhom = p.MaNhom
        JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
        JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
        WHERE 1=1 $search
        LIMIT $offset, $rowPerPage";
        $result = mysqli_query($con, $sql);
        $n = mysqli_num_rows($result);
         if($n > 0) {
            echo"<h2 style='text-align: center;'>Danh sách phòng máy</h2>";
            $index = $offset + 1;
            echo "
            <div style='width:80%; margin:0 auto; display:flex; justify-content: space-between; align-items:center; margin-bottom:10px;'>
                <form method='GET' style='display:flex; gap:10px;'>
                    <input type='text' name='keyword' placeholder='Tìm theo tên phòng / nhóm / trạng thái' 
                        value='".($_GET['keyword'] ?? '')."'
                        style='padding:8px; width:260px; border-radius:6px; border:1px solid #aaa;'>
                    <button type='submit' style='padding:8px 15px; background:#6a5acd; color:white; border:none; border-radius:6px;'>Tìm</button>
                </form>
                <a href='phongmay_them.php' class='btn-add'>+ Thêm phòng</a>
            </div>";

            // echo "<div class='table-header'>
                
            // </div>";

            echo"<table>";
                echo"<tr>
                    <th>Số thứ tự</th>
                    <th>Tên phòng</th>
                    <th>Tên nhóm</th>
                    <th>Sức chứa</th>
                    <th>Trạng thái phòng</th>
                    <th>Chức năng</th>
                </tr>";
                for($i=0; $i<$n; $i++) {
                    echo"<tr>";
                    $row = mysqli_fetch_array($result);
                    echo"<td>".$index."</td>";
                    echo"<td>".$row['TenPhong']."</td>";
                    echo"<td>".$row['TenNhom']."</td>";  
                    echo"<td style='text-align: center;'>".$row['SucChua']."</td>";
                    echo"<td>".$row['TenTTP']."</td>";
                    echo"<td>
                    <a href='phongmay_xem.php?maPhong=".$row['MaPhong']."'>Xem</a>
                    <a href='phongmay_sua.php?maPhong=".$row['MaPhong']."'>Sửa</a>
                    <a href='phongmay_xoa.php?maPhong=".$row['MaPhong']."'>Xóa</a>
                    <a href='phongmay_muon.php?maPhong=".$row['MaPhong']."'>Mượn phòng</a>
                    </td>";
                    echo"</tr>";
                    $index++;
                }
            echo"</table>";
            echo '<div class="pagination">';

                // nut prev
                if($_GET['page'] > 1) {
                    echo "<a href='?page=".($_GET['page'] - 1)."&keyword=$keyword'>«</a>";
                }

                // số trang
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $_GET['page']) {
                        echo "<span class='current'>$i</span>";
                    } else {
                        echo "<a href='?page=$i&keyword=$keyword'>$i</a>";
                    }
                }

                // next
                if ($_GET['page'] < $maxPage) {
                    echo "<a href='?page=".($_GET['page'] + 1)."&keyword=$keyword'>»</a>";
                }

                echo '</div>';


         }
    ?>
     
</body>
</html>