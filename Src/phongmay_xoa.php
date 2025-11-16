<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa phòng máy</title>
    <style>
        body {
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #ffffff;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .card {
            width: 50%;
            max-width: 600px;
            margin: 10px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.09);
            text-align: center;
        }


        .info {
            font-size: 16px;
            margin-bottom: 15px;
            color: #1e293b;
            background: #eff6ffff;
            padding: 15px 20px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            border-right: 4px solid #667eea;
            text-align: left;
        }


        .btn {
            display: inline-block;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            margin: 8px;
            border: none;
            overflow: hidden;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        .btn-delete:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(100, 116, 139, 0.4);
        }

        .btn-cancel:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card {
                width: 90%;
                padding: 30px 20px;
            }

            h2 {
                font-size: 26px;
            }

            .btn {
                display: block;
                width: 100%;
                margin: 8px 0;
            }

            .info strong {
                display: block;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding-top: 20px;
            }

            .card {
                padding: 25px 15px;
            }

            h2 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .card::before {
                font-size: 50px;
            }

            .info {
                font-size: 14px;
                padding: 12px 15px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <?php include("../Src/header.php"); ?>

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
    <div class="card" style='background-color: #f2f4fcff;'>
        <p class="info"><strong>Tên phòng:</strong> <?= $row['TenPhong'] ?></p>
        <p class="info"><strong>Tên nhóm:</strong> <?= $row['TenNhom'] ?></p>
        <p class="info"><strong>Trạng thái:</strong> <?= $row['TenTTP'] ?></p>

        <p style="color:#b91c1c; font-weight:bold;">Bạn có chắc chắn muốn xóa phòng này?</p>

        <form method="POST">
            <button type="submit" name="confirm_delete" class="btn btn-delete" style='color: white;'>Xóa phòng</button>
            <a href="phongmay.php" class="btn btn-cancel" style='color: white;'>Hủy</a>
        </form>
    </div>
    <?php include("../Src/footer.php"); ?>
</body>
</html>
