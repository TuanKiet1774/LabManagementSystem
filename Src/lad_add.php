<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Thêm phòng máy</title>

</head>
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
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    }

    th {
        background: #feffddff;
        padding: 14px;
        font-size: 18px;
        color: #3f3d56;
    }

    td {
        padding: 15px;
        border: 1px solid #eee;
        font-size: 16px;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
        background: #f0f5ff;
        font-size: 15px;
        transition: 0.25s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus {
        background: #e6f0ff;
        border-color: #93c5fd;
        outline: none;
    }

    .btn-add {
        display: inline-block;
        padding: 8px;
        font-size: 16px;
        background-color: #60a5fa;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-add:hover {
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

<body>

    <?php include("./header.php"); ?>
    <?php include("../Database/config.php"); ?>
    <h2>Thêm phòng máy</h2>

    <?php
    // Lấy danh sách nhóm
    $nhom = mysqli_query($con, "SELECT * FROM nhomphong");

    // Lấy danh sách trạng thái phòng
    $ttp = mysqli_query($con, "SELECT * FROM trangthaiphong");

    // Xử lý thêm phòng
    if (isset($_POST['submit'])) {
        $tenPhong = $_POST['tenPhong'];
        $sucChua = $_POST['sucChua'];
        $maNhom = $_POST['maNhom'];
        $maTTP = $_POST['maTTP'];

        // Tạo mã phòng tự động
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
            echo "<p style='text-align:center; color:green;'>Thêm phòng thành công!</p>";
        } else {
            echo "<p style='text-align:center; color:red;'>Lỗi: " . mysqli_error($con) . "</p>";
        }
    }
    ?>

    <form method="POST">
        <div class="table-responsive">
            <table>
                <tr>
                    <th colspan="2">THÔNG TIN PHÒNG MỚI</th>
                </tr>

                <tr>
                    <td>Tên phòng:</td>
                    <td><input type="text" class="form-control" name="tenPhong" required></td>
                </tr>

                <tr>
                    <td>Sức chứa:</td>
                    <td><input type="number" class="form-control" name="sucChua" min="1" required></td>
                </tr>

                <tr>
                    <td>Nhóm phòng:</td>
                    <td>
                        <select class="form-control" name="maNhom" required>
                            <option value="">-- Chọn nhóm phòng --</option>
                            <?php while ($r = mysqli_fetch_assoc($nhom)) { ?>
                                <option value="<?= $r['MaNhom'] ?>"><?= $r['TenNhom'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <select class="form-control" name="maTTP" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <?php while ($t = mysqli_fetch_assoc($ttp)) { ?>
                                <option value="<?= $t['MaTTP'] ?>"><?= $t['TenTTP'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center" style="background:#feffddff;">
                        <input type="submit" name="submit" value="Thêm phòng" class='btn-add w-md-auto'>
                    </td>
                </tr>
            </table>
        </div>
    </form>

    <div style='text-align:center;'>
        <a class='back-btn w-md-auto d-inline-block' href='phongmay.php'>Quay lại</a>
    </div>

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