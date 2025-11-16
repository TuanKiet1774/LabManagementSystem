<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thêm phòng máy</title>
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
        padding: 14px;
        font-size: 18px;
        color: #3f3d56;
    }

    td {
        padding: 15px;
        border: 1px solid #eee;
        font-size: 16px;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
        background: #f0f5ff;
        font-size: 15px;
        transition: 0.25s;
    }

    input[type="text"]:focus,
    select:focus {
        background: #e6f0ff;
        border-color: #93c5fd;
        outline: none;
    }

    .btn-add {
        display: inline-block;
        width: 20%;
        padding: 8px;
        font-size: 16px;
        background-color: #1096fdff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-add:hover {
        background: #60a5fa;
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

    <?php include("../Src/header.php"); ?>
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
        $maPhong = "P" . rand(1000, 9999);

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
    <table>
        <tr><th colspan="2">THÔNG TIN PHÒNG MỚI</th></tr>

        <tr>
            <td>Tên phòng:</td>
            <td><input type="text" name="tenPhong" required></td>
        </tr>

        <tr>
            <td>Sức chứa:</td>
            <td><input type="text" name="sucChua" required></td>
        </tr>

        <tr>
            <td>Nhóm phòng:</td>
            <td>
                <select name="maNhom" required>
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
                <select name="maTTP" required>
                    <option value="">-- Chọn trạng thái --</option>
                    <?php while ($t = mysqli_fetch_assoc($ttp)) { ?>
                        <option value="<?= $t['MaTTP'] ?>"><?= $t['TenTTP'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center" style="background:#fcfec7ff;">
                <button type="submit" name="submit" class="btn-add">Thêm phòng</button>
            </td>
        </tr>
    </table>
    </form>

    <a class="back-btn" href="phongmay.php">Quay lại</a>

    <?php include("../Src/footer.php"); ?>

</body>
</html>
