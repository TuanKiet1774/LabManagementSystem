<!DOCTYPE html>
<html>
<head>
    <title>Tạo phiếu mượn</title>
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
                text-align: center;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-size: 32px;
                font-weight: 700;
                margin: 30px 0;
                letter-spacing: 1px;
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

        td {
            padding: 14px;
            border: 1px solid #eee;
            font-size: 16px;
        }

        th {
            background: #feffddff;
            padding: 14px;
            font-size: 18px;
            color: #3f3d56;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #c7d2fe;
            background: #f0f5ff;
            font-size: 15px;
            transition: 0.25s;
        }

        input:focus, select:focus {
            background: #e6f0ff;
            border-color: #93c5fd;
            outline: none;
        }

        .btn-submit {
            display: inline-block;
            width: 15%;
            padding: 8px;
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
            display: block;
            width: 140px;
            margin: 20px auto;
            padding: 12px;
            background: #a5b4fc;
            color: white;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #818cf8;
        }
    </style>
</head>
<body>


    <?php 
        include("../Database/config.php");
        include("./header.php");
        

        // Lấy mã phòng từ URL
        $maPhong = $_GET['maPhong'];
        $sqlPhong = mysqli_query($con, "SELECT TenPhong FROM phong WHERE MaPhong = '$maPhong'");
        $tenPhong = mysqli_fetch_assoc($sqlPhong)['TenPhong'];


        // Lấy danh sách tiết học
        $listTiet = mysqli_query($con, "SELECT * FROM tiethoc");

        // Lấy danh sách ngày trong tuần
        $listNgay = mysqli_query($con, "SELECT * FROM ngaytuan");

        $listTTT = mysqli_query($con, "SELECT * FROM trangthaituan");

        // Khi submit
        if (isset($_POST['submit'])) {
            $maPhong = $_POST['maPhong'];
            $maND = 'ND001'; // Người dùng đang đăng nhập
            $mucDich = $_POST['mucDich'];
            $ngayBD = $_POST['ngayBD'];
            $ngayKT = $_POST['ngayKT'];
            $maNgay = $_POST['maNgay'];
            // $maTiet = $_POST['maTiet'];
            $maTietArr = isset($_POST['maTiet']) ? $_POST['maTiet'] : [];
            $maTTT = $_POST['maTTT'];

            // ---------- 1. Tạo phiếu mượn ----------
            $maPhieu = "PM" . time();
            $sql1 = "INSERT INTO phieumuon(MaPhieu, MaPhong, MaND, MucDich, NgayBD, NgayKT, NgayTao)
                    VALUES ('$maPhieu', '$maPhong', '$maND', '$mucDich', '$ngayBD', '$ngayKT', NOW())";

            if (mysqli_query($con, $sql1)) {

                // ---------- 2. Gắn trạng thái phiếu ban đầu ----------
                // Giả sử 1 = "Chờ duyệt"
                $sql2 = "INSERT INTO chitietttpm(MaPhieu, MaTTPM)
                        VALUES ('$maPhieu', 'TTPM001')";
                mysqli_query($con, $sql2);

                // ---------- 3. Lưu thời gian mượn ----------
                foreach ($maTietArr as $maTiet) {
                    $sql3 = "INSERT INTO thoigianmuon(MaPhieu, MaTiet, MaTTT, MaNgay)
                            VALUES ('$maPhieu', '$maTiet', '$maTTT', '$maNgay')";
                    mysqli_query($con, $sql3);
                }

                echo "<p style='text-align:center; color:green;'>Tạo phiếu mượn thành công!</p>";
            } else {
                echo "<p style='text-align:center; color:red;'>Lỗi: " . mysqli_error($con) . "</p>";
            }
        }
    ?>

    <form method="POST">
        <h2 style="text-align:center;">Tạo phiếu mượn phòng</h2>
        <table>
            <tr>
                <td>Phòng:</td>
                <td>
                    <input type="text" value="<?= $tenPhong ?>" readonly>
                    <input type="hidden" name="maPhong" value="<?= $maPhong ?>">
                </td>
            </tr>


            <tr>
                <td>Mục đích:</td>
                <td><input type="text" name="mucDich" required></td>
            </tr>

            <tr>
                <td>Ngày bắt đầu:</td>
                <td><input type="date" name="ngayBD" required></td>
            </tr>

            <tr>
                <td>Ngày kết thúc:</td>
                <td><input type="date" name="ngayKT" required></td>
            </tr>

            <tr>
                <td>Ngày trong tuần:</td>
                <td>
                    <select name="maNgay" required>
                        <option value="">-- Chọn ngày --</option>
                        <?php while($n = mysqli_fetch_assoc($listNgay)) { ?>
                            <option value="<?= $n['MaNgay'] ?>"><?= $n['TenNgay'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Trạng thái tuần:</td>
                <td>
                    <select name="maTTT" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <?php while($ttt = mysqli_fetch_assoc($listTTT)) { ?>
                            <option value="<?= $ttt['MaTTT'] ?>">
                                <?= $ttt['TenTTT'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>   

            <tr>
                <td>Tiết học:</td>
                <td>
                    <?php while($t = mysqli_fetch_assoc($listTiet)) { ?>
                        <label style="display:block;">
                            <input type="checkbox" name="maTiet[]" value="<?= $t['MaTiet'] ?>">
                            <?= $t['TenTiet'] ?> (<?= $t['GioBG'] ?> - <?= $t['GioKT'] ?>)
                        </label>
                    <?php } ?>
                </td>
            </tr>


            <tr>
                <td colspan="2" align="center" style="background:#feffddff;">
                    <input type="submit" name="submit" value="Tạo phiếu" class="btn-submit">
                </td>
            </tr>
        </table>
    </form>
    <a class="back-btn" href="phongmay.php">Quay lại</a>

    <?php include("./footer.php"); ?>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>

