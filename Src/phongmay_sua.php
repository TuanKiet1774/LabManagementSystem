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

            input[type="text"], input[type="number"] {
                width: 75%;
                padding: 10px;
                border-radius: 8px;
                border: 1px solid #c7d2fe;
                background: #f0f5ff;
                font-size: 15px;
                text-overflow: hidden;
            }

            input[type="text"]:focus, input[type="number"]:focus {
                background: #e6f0ff;
                border-color: #93c5fd;
                outline: none;
            }

            .btn-submit {
                display: inline-block;
                padding: 12px;
                font-size: 16px;
                background-color: #60a5fa;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: 0.25s;
            }

            .btn-submit:hover {
                background: #048ff9ff;
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
        <?php include("./header.php"); ?>
        <?php
            include("../Database/config.php");

            // Lấy mã phòng
            if (isset($_GET['maPhong'])) {
                $maPhong = $_GET['maPhong'];
            }

            $dsNhom = mysqli_query($con, "SELECT * FROM nhomphong");
            $dsTrangThai = mysqli_query($con, "SELECT * FROM trangthaiphong");

            // Xử lý cập nhật
            if (isset($_POST['submit'])) {
                $maPhong = $_POST['maPhong'];
                $tenPhong = $_POST['tenPhong'];
                $maNhom = $_POST['maNhom'];
                $sucChua = ($_POST['sucChua']);
                $maTTP = $_POST['maTTP'];
                

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
                    

                if ($ok) {
                    echo "<p style='text-align:center; color:green;'>Cập nhật thành công!</p>";
                } else {
                    echo "<p style='text-align:center; color:red;'>Lỗi cập nhật: " . mysqli_error($con) . "</p>";
                }

                // Lấy lại dữ liệu sau khi cập nhật
               $sql = "SELECT p.*, np.*, tt.*, ct.*
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE p.MaPhong = '$maPhong'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);

                

            } 
            else if (isset($maPhong)) {

                // Lần đầu mở form
                $sql = "SELECT p.*, np.*, tt.*, ct.*
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE p.MaPhong = '$maPhong'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                
            }

            if (!empty($row)) {
        ?>

        <form method="POST">
            <div class="table-responsive">
                <table>
                    <tr><th colspan="2">CẬP NHẬT THÔNG TIN PHÒNG</th></tr>

                    <tr>
                        <td>Mã phòng:</td>
                        <td><input type="text" class="form-control" name="maPhong" value="<?= $row['MaPhong'] ?>" readonly></td>
                    </tr>

                    <tr>
                        <td>Tên phòng:</td>
                        <td><input type="text" class="form-control" name="tenPhong" value="<?= $row['TenPhong'] ?>"></td>
                    </tr>

                    <tr>
                        <td>Tên nhóm:</td>
                        <td>
                            <select class="form-control" name="maNhom" required
                            style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe; background:#f0f5ff;">
                                <?php while ($nhom = mysqli_fetch_assoc($dsNhom)) { ?>
                                    <option value="<?= $nhom['MaNhom'] ?>"
                                        <?= $nhom['MaNhom'] == $row['MaNhom'] ? 'selected' : '' ?>>
                                        <?= $nhom['TenNhom'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>



                    <tr>
                        <td>Sức chứa:</td>
                        <td>
                            <input type="number" class="form-control" name="sucChua" value="<?= $row['SucChua'] ?>" min="1">
                            <span id="errSucChua" style="color:red; font-size:14px;"></span>
                        </td>
                    </tr>

                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select class="form-control" name="maTTP" required style="width:75%; padding:10px; border-radius:8px; border:1px solid #c7d2fe; background:#f0f5ff;">
                                <?php
                                while ($tt = mysqli_fetch_assoc($dsTrangThai)) { ?>
                                    <option value="<?= $tt['MaTTP'] ?>" <?= $tt['MaTTP']==$row['MaTTP']?'selected':'' ?>>
                                        <?= $tt['TenTTP'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" style="background:#feffddff;">
                            <input type="submit" name="submit" value="Cập nhật" class='btn-submit w-md-auto'>
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <?php
        //Đóng if(!empty($row))
        } 
        else {
            echo "
            <div class='container d-flex justify-content-center' 
                style='min-height: calc(100vh - 200px);'>
                <div class='text-center'>
                    <p class='text-danger fw-bold mt-1'>Phòng không tồn tại!</p>
                    <a href='phongmay.php' class='btn btn-secondary mt-2'>Quay lại</a>
                </div>
            </div>
            ";
            include("./footer.php");
            exit;
        }
        echo "<div style='text-align:center;'>
            <a class='back-btn w-md-auto d-inline-block' href='phongmay.php'>Quay lại</a>
        </div>";
        ?>
        <?php include("./footer.php"); ?>

        <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>
</body>
</html>