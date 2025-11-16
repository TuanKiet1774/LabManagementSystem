<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thiết bị</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f5ff;
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
                tb.TenThietBi LIKE '%$keyword%' OR 
                loai.TenLoai LIKE '%$keyword%' OR 
                tttb.TenTTTB LIKE '%$keyword%'
            )";
        }
        $rowPerPage = 10;
        $offset=($_GET['page'] - 1) * $rowPerPage;
        // $sqlCount = "SELECT COUNT(*) as total from phong";
        $sqlCount = "SELECT COUNT(*) as total
             FROM thietbi tb
             JOIN loai ON loai.MaLoai = tb.MaLoai
             JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
             JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
             WHERE 1=1 $search";
        $resultCount = mysqli_query($con, $sqlCount); 
        $rowCount = mysqli_fetch_assoc($resultCount);
        $totalRow = $rowCount['total'];
        $maxPage = ceil($totalRow/$rowPerPage);
        

        $sql = "SELECT tb.*, tttb.TenTTTB, loai.*
        FROM thietbi tb
        JOIN loai ON loai.MaLoai = tb.MaLoai
        JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
        JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
        WHERE 1=1 $search
        Order by tb.MaThietBi asc
        LIMIT $offset, $rowPerPage";
        $result = mysqli_query($con, $sql);
        $n = mysqli_num_rows($result);
         if($n > 0) {
            echo"<h2 style='text-align: center;'>Danh sách thiết bị</h2>";
            $index = $offset + 1;
            echo "
            <div style='width:80%; margin:0 auto; display:flex; justify-content: space-between; align-items:center; margin-bottom:10px;'>
                <form method='GET' style='display:flex; gap:10px;'>
                    <input type='text' name='keyword' placeholder='Tìm theo tên thiết bị / loại / trạng thái' 
                        value='".($_GET['keyword'] ?? '')."'
                        style='padding:8px; width:260px; border-radius:6px; border:1px solid #aaa;'>
                    <button type='submit' style='padding:8px 15px; background:#6a5acd; color:white; border:none; border-radius:6px;'>Tìm</button>
                </form>
                <a href='thietbi_them.php' class='btn-add'>+ Thêm thiết bị</a>
            </div>";

            // echo "<div class='table-header'>
                
            // </div>";

            echo"<table>";
                echo"<tr>
                    <th>Số thứ tự</th>
                    <th>Mã thiết bị</th>
                    <th>Tên thiết bị</th>
                    <th>Tên loại</th>
                    <th>Số lượng</th>
                    <th>Trạng thái thiết bị</th>
                    <th>Chức năng</th>
                </tr>";
                for($i=0; $i<$n; $i++) {
                    echo"<tr>";
                    $row = mysqli_fetch_array($result);
                    echo"<td>".$index."</td>";
                    echo"<td>".$row['MaThietBi']."</td>";
                    echo"<td>".$row['TenThietBi']."</td>";
                    echo"<td>".$row['TenLoai']."</td>";  
                    echo"<td style='text-align: center;'>".$row['SoLuong']."</td>";
                    echo"<td>".$row['TenTTTB']."</td>";
                    echo"<td>
                    <a href='thietbi_xem.php?maThietBi=".$row['MaThietBi']."'>Xem</a>
                    <a href='thietbi_sua.php?maThietBi=".$row['MaThietBi']."'>Sửa</a>
                    <a href='thietbi_xoa.php?maThietBi=".$row['MaThietBi']."'>Xóa</a>
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