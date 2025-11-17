<?php 
include("../Database/config.php");
include("../Src/header.php");

// Lấy mã phòng từ URL
$maPhong = $_GET['maPhong'];

// Lấy danh sách tiết học
$listTiet = mysqli_query($con, "SELECT * FROM tiethoc");

// Lấy danh sách ngày trong tuần
$listNgay = mysqli_query($con, "SELECT * FROM ngaytuan");

// Khi submit
if (isset($_POST['submit'])) {
    $maPhong = $_POST['maPhong'];
    $maND = $_SESSION['MaND']; // Người dùng đang đăng nhập
    $mucDich = $_POST['mucDich'];
    $ngayBD = $_POST['ngayBD'];
    $ngayKT = $_POST['ngayKT'];
    $maNgay = $_POST['maNgay'];
    $maTiet = $_POST['maTiet'];

    // ---------- 1. Tạo phiếu mượn ----------
    $sql1 = "INSERT INTO phieumuon(MaPhong, MaND, MucDich, NgayBD, NgayKT, NgayTao)
             VALUES ('$maPhong', '$maND', '$mucDich', '$ngayBD', '$ngayKT', NOW())";

    if (mysqli_query($con, $sql1)) {
        $maPhieu = mysqli_insert_id($con);

        // ---------- 2. Gắn trạng thái phiếu ban đầu ----------
        // Giả sử 1 = "Chờ duyệt"
        $sql2 = "INSERT INTO chitietttom(MaPhieu, MaTTPM)
                 VALUES ('$maPhieu', '1')";

        mysqli_query($con, $sql2);

        // ---------- 3. Lưu thời gian mượn ----------
        $sql3 = "INSERT INTO thoigianmuon(MaPhieu, MaTiet, MaTTT, MaNgay)
                 VALUES ('$maPhieu', '$maTiet', '1', '$maNgay')"; 
                 // MaTTT = 1 (trạng thái tuần mặc định)

        mysqli_query($con, $sql3);

        echo "<p style='text-align:center; color:green;'>Tạo phiếu mượn thành công!</p>";
    } else {
        echo "<p style='text-align:center; color:red;'>Lỗi: " . mysqli_error($con) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tạo phiếu mượn</title>
    <style>
        table{
            width:60%;
            margin:20px auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px #bbb;
        }
        td{
            padding:10px;
        }
        input, select{
            width:100%;
            padding:8px;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Tạo phiếu mượn phòng</h2>

<form method="POST">
<table>
    <tr>
        <td>Mã phòng:</td>
        <td><input type="text" name="maPhong" value="<?= $maPhong ?>" readonly></td>
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
        <td>Tiết học:</td>
        <td>
            <select name="maTiet" required>
                <option value="">-- Chọn tiết --</option>
                <?php while($t = mysqli_fetch_assoc($listTiet)) { ?>
                    <option value="<?= $t['MaTiet'] ?>">
                        <?= $t['TenTiet'] ?> (<?= $t['GioBG'] ?> - <?= $t['GioKT'] ?>)
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="center">
            <button type="submit" name="submit">Tạo phiếu</button>
        </td>
    </tr>
</table>
</form>

</body>
</html>

<?php include("../Src/footer.php"); ?>
