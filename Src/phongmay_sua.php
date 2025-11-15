    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cập nhật thông tin phòng máy</title>
        <style>
            body {
                font-family: "Segoe UI", Arial, sans-serif;
                background: #f7f5ff;
                padding-top: 20px;
            }

            h2 {
                text-align: center;
                color: #6a5acd;
                font-size: 28px;
                margin-bottom: 20px;
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
                background: #feffddff;
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

            input[type="text"] {
                width: 75%;
                padding: 10px;
                border-radius: 8px;
                border: 1px solid #c7d2fe;
                background: #f0f5ff;
                font-size: 15px;
                text-overflow: hidden;
            }

            input[type="text"]:focus {
                background: #e6f0ff;
                border-color: #93c5fd;
                outline: none;
            }

            .btn-submit {
                display: inline-block;
                width: 15%;
                padding: 12px;
                font-size: 16px;
                background-color: #1096fdff;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: 0.25s;
            }

            .btn-submit:hover {
                background: #60a5fa;
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

            // Lấy mã phòng
            if (isset($_GET['maPhong'])) {
                $maPhong = $_GET['maPhong'];
            }

            // Xử lý cập nhật
            if (isset($_POST['submit'])) {

                $maPhong = $_POST['maPhong'];
                $tenPhong = $_POST['tenPhong'];

                $maNhom = $_POST['maNhom'];
                $tenNhom = $_POST['tenNhom'];

                $sucChua = $_POST['sucChua'];

                $maTTP = $_POST['maTTP'];
                $tenTTP = $_POST['tenTTP'];

                // Cập nhật bảng phong
                $sql1 = "UPDATE phong SET 
                            TenPhong='$tenPhong',
                            SucChua='$sucChua',
                            MaNhom='$maNhom'
                        WHERE MaPhong='$maPhong'";

                // Cập nhật tên nhóm phòng
                $sql2 = "UPDATE nhomphong SET 
                            TenNhom='$tenNhom'
                        WHERE MaNhom='$maNhom'";

                // Cập nhật tên trạng thái phòng
                $sql3 = "UPDATE trangthaiphong SET 
                            TenTTP='$tenTTP'
                        WHERE MaTTP='$maTTP'";

                // Gán trạng thái cho phòng
                $sql4 = "UPDATE chitietttp SET
                            MaTTP='$maTTP'
                        WHERE MaPhong='$maPhong'";

                $ok = mysqli_query($con, $sql1)
                    && mysqli_query($con, $sql2)
                    && mysqli_query($con, $sql3)
                    && mysqli_query($con, $sql4);

                if ($ok) {
                    echo "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
                } else {
                    echo "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";
                }

                // Lấy lại dữ liệu sau khi cập nhật
                $sql = "SELECT p.*, np.TenNhom, tt.TenTTP, np.MaNhom, tt.MaTTP
                        FROM phong p
                        JOIN nhomphong np ON np.MaNhom = p.MaNhom
                        JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                        JOIN trangthaiphong tt ON tt.MaTTP = ct.MaTTP
                        WHERE p.MaPhong = '$maPhong'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);

            } 
            else if (isset($maPhong)) {

                // Lần đầu mở form
                $sql = "SELECT p.*, np.TenNhom, tt.TenTTP, np.MaNhom, tt.MaTTP
                        FROM phong p
                        JOIN nhomphong np ON np.MaNhom = p.MaNhom
                        JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                        JOIN trangthaiphong tt ON tt.MaTTP = ct.MaTTP
                        WHERE p.MaPhong = '$maPhong'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
            }

            if (!empty($row)) {
        ?>

        <form method="POST">
        <table>
            <tr><th colspan="2">CẬP NHẬT THÔNG TIN PHÒNG</th></tr>

            <tr>
                <td>Mã phòng:</td>
                <td><input type="text" name="maPhong" value="<?= $row['MaPhong'] ?>" readonly></td>
            </tr>

            <tr>
                <td>Tên phòng:</td>
                <td><input type="text" name="tenPhong" value="<?= $row['TenPhong'] ?>"></td>
            </tr>

            <tr>
                <td>Tên nhóm:</td>
                <td>
                    <input type="text" name="tenNhom" value="<?= $row['TenNhom'] ?>">
                    <input type="hidden" name="maNhom" value="<?= $row['MaNhom'] ?>">
                </td>
            </tr>

            <tr>
                <td>Sức chứa:</td>
                <td><input type="text" name="sucChua" value="<?= $row['SucChua'] ?>"></td>
            </tr>

            <tr>
                <td>Trạng thái:</td>
                <td>
                    <input type="text" name="tenTTP" value="<?= $row['TenTTP'] ?>">
                    <input type="hidden" name="maTTP" value="<?= $row['MaTTP'] ?>">
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center" style="background:#feffddff;">
                    <input type="submit" name="submit" value="Cập nhật" class='btn-submit'>
                </td>
            </tr>
        </table>
        </form>

        <?php
        } else {
            echo "<p style='text-align:center; color:red;'>Không tìm thấy phòng!</p>";
        }
        echo "<div style='text-align:center;'>
            <a class='back-btn' href='phongmay.php'>Quay lại</a>
            </div>";
        ?>
        <?php include("../Src/footer.php"); ?>
    </body>
    </html>
