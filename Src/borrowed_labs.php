<?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/controller.php');
    include_once('./Controller/borrowedLabController.php'); 
    
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) die("Lỗi kết nối: " . $conn->connect_error);

    $user = checkLogin();

    $userID = $user['MaND']; 
    // Lấy dữ liệu tìm kiếm từ POST (nếu có)
    $search_data = $_POST;

    // Lấy danh sách phòng cho dropdown
    $rooms_list = getAllRooms($conn);

    // Lấy danh sách phiếu mượn
    $borrowed_labs = getBorrowedLabs($conn, $userID, $search_data);

    $conn->close();

    // Lấy giá trị tìm kiếm để hiển thị lại trong form
    $search_maphong = htmlspecialchars($search_data['search_maphong'] ?? ''); 
    $search_trangthai = htmlspecialchars($search_data['search_trangthai'] ?? '');
    $search_ngaytao = htmlspecialchars($search_data['search_ngaytao'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Phòng mượn</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html, body {
        height: 100%;
    }
    body { 
        font-family: Arial, sans-serif; 
        margin: 0; 
        display: flex;
        flex-direction: column; 
    }
    main {
        flex: 1 0 auto; 
        padding: 20px 0;
    }
    .container { 
        max-width: 1200px; 
        margin: 0 auto; 
    }
    h2{ 
        padding: 10px 0; 
        color: #333; 
        text-align: center;
    } 
    b{
        font-size: 18px;    
    }    
    .search-form { 
        background: #f4f4f4; 
        padding: 15px;
        border-radius: 8px; 
        margin-bottom: 20px; 
        display: flex; 
        gap: 10px; 
        flex-wrap: wrap;
        justify-content: center; 
    }
    .search-form input, .search-form select, .search-form button {
        padding: 8px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }
    .data-table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
    }
    .data-table th, .data-table td { 
        border: 1px solid #ddd; 
        padding: 10px; 
        text-align: left;    
    }
    .data-table th { 
        background-color: #001f3e; 
        color: white;
        text-align: center; 
    }
    .status-chua-duyet { 
        color: #0000cd; 
        font-weight: bold; 
    }
    .status-da-duyet { 
        color: green; 
        font-weight: bold; 
    }
    .status-khong-chap-nhan { 
        color: red; 
        font-weight: bold; 
    }
</style>

<body>
    <?php include './header.php'; ?>

    <main>
        <div class="container">
            <h2>LỊCH SỬ CÁC PHÒNG ĐÃ MƯỢN</h2>            

            <form class="search-form" method="POST" action="">
                <input type="date" name="search_ngaytao" value="<?php echo $search_ngaytao; ?>" title="Tìm theo thời gian tạo phiếu">

                <select name="search_maphong" title="Chọn phòng đã mượn">
                    <option value="">-- Chọn Tên phòng --</option>
                    <?php foreach ($rooms_list as $room): ?>
                        <option 
                            value="<?php echo htmlspecialchars($room['MaPhong']); ?>"
                            <?php echo ($search_maphong === $room['MaPhong'] ? 'selected' : ''); ?>
                        >
                        <?php echo htmlspecialchars($room['TenPhong']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="search_trangthai" title="Tìm theo trạng thái duyệt">
                    <option value="">-- Trạng thái duyệt --</option>
                    <option value="TTPM001" <?php echo ($search_trangthai === 'TTPM001' ? 'selected' : ''); ?>>Chưa duyệt</option>
                    <option value="TTPM002" <?php echo ($search_trangthai === 'TTPM002' ? 'selected' : ''); ?>>Đã duyệt</option>
                    <option value="TTPM003" <?php echo ($search_trangthai === 'TTPM003' ? 'selected' : ''); ?>>Không chấp nhận</option>
                </select>
                <button type="submit">🔍 Tìm kiếm</button>
                <button type="button" onclick="window.location.href='borrowed_labs.php'">🔄 Đặt lại</button>
            </form>

            <hr>            
            
            <?php if (empty($borrowed_labs)): ?>
                <b><center>Không tìm thấy phiếu mượn nào khớp với điều kiện tìm kiếm hoặc bạn chưa có phiếu mượn nào.</b>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời gian mượn</th>
                            <th>Tên phòng</th>
                            <th>Mục đích mượn</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái duyệt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1; ?>
                        <?php foreach ($borrowed_labs as $row): ?>
                        <tr>
                            <td><center><?php echo $stt++;?></td>
                            <td><?php echo date('H:i:s d/m/Y', strtotime($row['NgayTao'])); ?></td>
                            <td><?php echo htmlspecialchars($row['TenPhong']); ?></td>
                            <td><?php echo htmlspecialchars($row['MucDich']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['NgayBD'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['NgayKT'])); ?></td>
                            <td>
                                <?php 
                                    $status = htmlspecialchars($row['TrangThaiPhieuMuon']);
                                    $class = '';
                                    if ($status == 'Chưa duyệt') {
                                        $class = 'status-chua-duyet';
                                    } elseif ($status == 'Đã duyệt') {
                                        $class = 'status-da-duyet';
                                    } elseif ($status == 'Không chấp nhận') {
                                        $class = 'status-khong-chap-nhan';
                                    }
                                ?>
                                <span class="<?php echo $class; ?>"><?php echo $status; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <?php include './footer.php'; ?>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>
</body>
</html>