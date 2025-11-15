<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Xóa phòng máy</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f7f5ff;
        padding-top: 30px;
    }

    h2 {
        text-align: center;
        color: #6a5acd;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .card {
        width: 50%;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        text-align: center;
    }

    .info {
        font-size: 16px;
        margin-bottom: 20px;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 12px 22px;
        font-size: 16px;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        transition: 0.25s;
        margin: 5px;
        border: none;
    }

    .btn-delete {
        background: #f87171;
        color: white;
    }

    .btn-delete:hover {
        background: #ef4444;
    }

    .btn-cancel {
        background: #a5b4fc;
        color: white;
    }

    .btn-cancel:hover {
        background: #818cf8;
    }
</style>
</head>
<body>

<?php
include("../Database/config.php");

if (!isset($_GET['maPhong'])) {
    echo "<p style='text-align:center; color:red;'>Không xác định được phòng!</p>";
    exit;
}

$maPhong = $_GET['maPhong'];

// Lấy thông tin phòng để hiển thị
$sql = "SELECT p.TenPhong, np.TenNhom, tt.TenTTP
        FROM phong p
        JOIN nhomphong np ON np.MaNhom = p.MaNhom
        JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
        JOIN trangthaiphong tt ON tt.MaTTP = ct.MaTTP
        WHERE p.MaPhong='$maPhong'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<p style='text-align:center; color:red;'>Phòng không tồn tại!</p>";
    exit;
}

// Xử lý xóa khi submit
if (isset($_POST['confirm_delete'])) {
    $sql1 = "DELETE FROM chitietttp WHERE MaPhong='$maPhong'";
    $sql2 = "DELETE FROM phong WHERE MaPhong='$maPhong'";
    
    $ok = mysqli_query($con, $sql1) && mysqli_query($con, $sql2);
    
    if ($ok) {
        echo "<p style='text-align:center; color:green;'>Xóa phòng thành công!</p>";
        echo "<div style='text-align:center; margin-top:20px;'>
                <a class='btn btn-cancel' href='phongmay.php'>Quay lại danh sách</a>
              </div>";
        exit;
    } else {
        echo "<p style='text-align:center; color:red;'>Lỗi khi xóa: " . mysqli_error($con) . "</p>";
    }
}
?>

<h2>Xóa phòng máy</h2>
<div class="card">
    <p class="info"><strong>Tên phòng:</strong> <?= $row['TenPhong'] ?></p>
    <p class="info"><strong>Tên nhóm:</strong> <?= $row['TenNhom'] ?></p>
    <p class="info"><strong>Trạng thái:</strong> <?= $row['TenTTP'] ?></p>

    <p style="color:#b91c1c; font-weight:bold;">Bạn có chắc chắn muốn xóa phòng này?</p>

    <form method="POST">
        <button type="submit" name="confirm_delete" class="btn btn-delete">Xóa phòng</button>
        <a href="phongmay.php" class="btn btn-cancel">Hủy</a>
    </form>
</div>

</body>
</html>
