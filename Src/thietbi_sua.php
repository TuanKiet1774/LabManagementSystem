    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cập nhật thông tin thiết bị</title>
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
            if (isset($_GET['maThietBi'])) {
                $maThietBi = $_GET['maThietBi'];
            }

            $dsLoai = mysqli_query($con, "SELECT * FROM loai");
            $dsTTTB = mysqli_query($con, "SELECT * FROM trangthaithietbi");


            // Xử lý cập nhật
            if (isset($_POST['submit'])) {

                $maThietBi = $_POST['maThietBi'];
                $tenThietBi= $_POST['tenThietBi'];
                $maLoai = $_POST['maLoai'];
                $maTTTB = $_POST['maTTTB'];

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

                if ($ok) {
                    echo "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
                } else {
                    echo "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";
                }

                // Lấy lại dữ liệu sau khi cập nhật
                $sql = "SELECT tb.*, tttb.*, loai.*, cttttb.MaTTTB
                FROM thietbi tb
                JOIN loai ON loai.MaLoai = tb.MaLoai
                JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
                JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
                WHERE tb.MaThietBi= '$maThietBi'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);

            } 
            else if (isset($maThietBi)) {

                // Lần đầu mở form
                $sql = "SELECT tb.*, tttb.*, loai.*, cttttb.MaTTTB
                FROM thietbi tb
                JOIN loai ON loai.MaLoai = tb.MaLoai
                JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
                JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
                WHERE tb.MaThietBi= '$maThietBi'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
            }

            if (!empty($row)) {
        ?>

        <form method="POST">
        <table>
            <tr><th colspan="2">CẬP NHẬT THÔNG TIN THIẾT BỊ</th></tr>

            <tr>
                <td>Mã thiết bị:</td>
                <td><input type="text" name="maThietBi" value="<?= $row['MaThietBi'] ?>" readonly></td>
            </tr>

            <tr>
                <td>Tên thiết bị:</td>
                <td><input type="text" name="tenThietBi" value="<?= $row['TenThietBi'] ?>"></td>
            </tr>
            <tr>
                <td>Tên loại:</td>
                <td>
                    <select name="maLoai" required
                    style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe; background:#f0f5ff;">
                        <?php while ($l = mysqli_fetch_assoc($dsLoai)) { ?>
                            <option value="<?= $l['MaLoai'] ?>"
                                <?= $l['MaLoai'] == $row['MaLoai'] ? 'selected' : '' ?>>
                                <?= $l['TenLoai'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Trạng thái:</td>
                <td>
                    <select name="maTTTB" required
                    style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe; background:#f0f5ff;">
                        <?php while ($t = mysqli_fetch_assoc($dsTTTB)) { ?>
                            <option value="<?= $t['MaTTTB'] ?>"
                                <?= $t['MaTTTB'] == $row['MaTTTB'] ? 'selected' : '' ?>>
                                <?= $t['TenTTTB'] ?>
                            </option>
                        <?php } ?>
                    </select>
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
            <a class='back-btn' href='thietbi.php'>Quay lại</a>
            </div>";
        ?>
        <?php include("../Src/footer.php"); ?>
    </body>
    </html>
