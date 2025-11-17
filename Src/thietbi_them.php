<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thêm thiết bị</title>
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
</head>

<body>

    <?php include("../Src/header.php"); ?>
    <?php include("../Database/config.php"); ?>
    <h2>Thêm thiết bị</h2>

    <?php
    // Lấy danh sách loại
    $loai = mysqli_query($con, "SELECT * FROM loai");

    // Lấy danh sách trạng thái thiết bị
    $tttb = mysqli_query($con, "SELECT * FROM trangthaithietbi");

    // Xử lý thêm phòng
    if (isset($_POST['submit'])) {
        $maThietBi = $_POST['maThietBi'];
        $tenThietBi = $_POST['tenThietBi'];
        $maLoai = $_POST['maLoai'];
        $maTTTB = $_POST['maTTTB'];


        $sql1 = "INSERT INTO thietbi(MaThietBi, TenThietBi, MaLoai)
                VALUES('$maThietBi', '$tenThietBi', '$maLoai')";

        $sql2 = "INSERT INTO chitiettttb(MaThietBi, MaTTTB)
                VALUES('$maThietBi', '$maTTTB')";

        if (mysqli_query($con, $sql1) && mysqli_query($con, $sql2)) {
            echo "<p style='text-align:center; color:green;'>Thêm thiết bị thành công!</p>";
        } else {
            echo "<p style='text-align:center; color:red;'>Lỗi: " . mysqli_error($con) . "</p>";
        }
    }
    ?>

    <form method="POST">
    <table>
        <tr><th colspan="2">THÔNG TIN THIẾT BỊ MỚI</th></tr>   
        <tr>
            <td>Mã thiết bị:</td>
            <td><input type="text" name="maThietBi" required></td>
        </tr>
        <tr>
            <td>Tên thiết bị:</td>
            <td><input type="text" name="tenThietBi" required></td>
        </tr>


        <tr>
            <td>Tên loại:</td>
            <td>
                <select name="maLoai" required>
                    <option value="">-- Chọn loại thiết bị --</option>
                    <?php while ($r = mysqli_fetch_assoc($loai)) { ?>
                        <option value="<?= $r['MaLoai'] ?>"><?= $r['TenLoai'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>


        <tr>
            <td>Trạng thái:</td>
            <td>
                <select name="maTTTB" required>
                    <option value="">-- Chọn trạng thái --</option>
                    <?php while ($t = mysqli_fetch_assoc($tttb)) { ?>
                        <option value="<?= $t['MaTTTB'] ?>"><?= $t['TenTTTB'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center" style="background:#fcfec7ff;">
                <button type="submit" name="submit" class="btn-add">Thêm thiết bị</button>
            </td>
        </tr>
    </table>
    </form>

    <a class="back-btn" href="thietbi.php">Quay lại</a>

    <?php include("../Src/footer.php"); ?>

</body>
</html>
