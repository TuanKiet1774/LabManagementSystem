<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin phòng máy</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f5ff;
        }

        h2, th {
            font-family: "Segoe UI", Arial, sans-serif;
        }

        table {
            width: 55%;
            margin: 10px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        }

        th {
            background: #c7d2fe; 
            color: #3f3d56;
            padding: 12px;
            font-size: 18px;
            text-align: center;
        }

        td {
            padding: 15px;
            border: 1px solid #eee;
            vertical-align: top;
            font-size: 16px;
            color: #333;
        }

        .img-cell {
            width: 45%;
            text-align: center;
            background: #f0f5ff;
        }

        .img-cell img {
            width: 280px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        }

        .info-cell {
            background: #fafaff;
            padding-left: 20px;
        }

        i {
            font-style: normal;
            font-weight: bold;
            color: #6a5acd;
            display: inline-block;
            margin-top: 6px;
        }

        span {
            color: #333;
            font-size: 17px;
            margin-left: 5px;
        }

        .back-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 18px;
            text-decoration: none;
            background: #a5b4fc; 
            color: white;
            font-size: 16px;
            border-radius: 8px;
            text-align: center;
        }

        .back-btn:hover {
            background: #818cf8;
        }


    </style>
</head>
<body>
    <?php include("../Src/header.php"); ?>
    <?php
        include("../Database/config.php");

        if (isset($_GET['maPhong'])) {
            $ma_phong = $_GET['maPhong'];

            $sql = "SELECT p.MaPhong, p.TenPhong, p.SucChua, np.*, tt.TenTTP
            FROM phong p
            JOIN nhomphong np ON np.MaNhom = p.MaNhom
            JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
            JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
            WHERE p.MaPhong = '$ma_phong'
            ";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);

            echo "<table>";
            $imagePath = "Image/" . $row['MaNhom'] . ".jpg";
            if(!file_exists($imagePath)) {
                $imagePath = "Image/noimage.png"; 
            }
            if($row) {
                echo"<tr>";
                    echo "<th colspan='2';>" . $row['TenPhong'] . " - " . $row['TenNhom'] . "</th>";
                echo"</tr>";
                echo "<tr>";
                    echo "<td class='img-cell'>";
                        echo"<img src='" . $imagePath . "' alt='" . $row['TenPhong'] . "' width='300'>";
                    echo "</td>";

                    echo "<td class='info-cell'>";
                        
                        echo "<i>Sức chứa:</i>";                           
                        echo "<span>" . $row['SucChua'] . "</span><br>";

                        echo "<i>Trạng thái phòng: </i>";
                        echo "<span>" . $row['TenTTP'] . "</span>";
                    echo "</td>";
                echo "</tr>";
            }

        echo "</table>";
        }
        echo "<div style='text-align:center;'>
        <a class='back-btn' href='phongmay.php'>Quay lại</a>
        </div>";

    ?>
    <?php include("../Src/footer.php"); ?>
</body>
</html>