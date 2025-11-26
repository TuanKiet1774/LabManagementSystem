<?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/paginationController.php');
    include_once('./Controller/labschedController.php');    

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) die("Lỗi kết nối: " . $conn->connect_error);

    $user = checkLogin();

    $data = get_schedule_data($conn);
    
    // Phân tách dữ liệu ra các biến đơn giản để dùng trong HTML
    $selected_year = $data['selected_year'];
    $selected_week = $data['selected_week'];
    $selected_group = $data['selected_group'];
    $selected_room = $data['selected_room'];
    $start_date_display = $data['start_date_display'];
    $end_date_display = $data['end_date_display'];
    $prev_week_info = $data['prev_week_info'];
    $next_week_info = $data['next_week_info'];
    $groups = $data['groups'];
    $days_of_week = $data['days_of_week'];
    $all_rooms = $data['all_rooms'];
    $temp_rooms = $data['temp_rooms'];
    // $empty_slots_by_room = $data['empty_slots_by_room'];
    
    //Phân trang
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    $pagination_result = paginate_rooms($all_rooms, $page); 
    
    $rooms_to_display_paginated = $pagination_result['rooms_to_display']; // Danh sách 1 phòng duy nhất
    $maxPage = $pagination_result['maxPage'];
    $currentPage = $pagination_result['currentPage'];    
    
    // 1. Ghi đè $selected_room để hàm get_busy_slots/calculate_empty_slots chỉ truy vấn phòng hiện tại.
    // Lấy mã phòng duy nhất từ danh sách đã phân trang
    if (!empty($rooms_to_display_paginated)) {
        $room_code_for_query = $rooms_to_display_paginated[0]['MaPhong'];        
        
        $current_week_type = ($selected_week % 2 == 0) ? 'TUANCHAN' : 'TUANLE';
        $dto = new DateTime();
        $dto->setISODate($selected_year, $selected_week, 1);
        $start_date = $dto->format('Y-m-d');
        $dto->setISODate($selected_year, $selected_week, 7);
        $end_date = $dto->format('Y-m-d');
        
        $day_map_to_index = ['Thứ hai' => 1, 'Thứ ba' => 2, 'Thứ tư' => 3, 'Thứ năm' => 4, 'Thứ sáu' => 5, 'Thứ bảy' => 6, 'Chủ nhật' => 7];
        
        // Chỉ lấy busy slots cho phòng hiện tại
        $rooms_to_display_codes = array_column($rooms_to_display_paginated, 'MaPhong');
        $busy_slots_data = get_busy_slots($conn, $rooms_to_display_codes, $start_date, $end_date, $current_week_type, $day_map_to_index);

        // Tính toán trạng thái trống/bận (Dùng danh sách 1 phòng đã phân trang)
        $empty_slots_by_room = calculate_empty_slots($rooms_to_display_paginated, $data['lessons'], $day_map_to_index, $busy_slots_data);
        
    } else
        $empty_slots_by_room = [];
    

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Lịch Phòng Trống</title>

</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    .container {
        width: 95%;
        margin: 20px auto;
    }

    .main-layout {
        display: flex;
        gap: 20px;
    }

    .sidebar {
        width: 280px;
        padding: 20px;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        margin-top: 5px;
    }

    .main-content {
        flex: 1;
        min-width: 0;
    }

    .week-info {
        text-align: center;
        background: #fff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 6px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .timetable-wrapper {
        overflow-x: auto;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
    }

    .timetable {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    /* Bảng hiển thị theo Phòng/Tuần */
    .room-schedule h3 {
        background: #001f3e;
        color: white;
        padding: 10px 15px;
        margin-top: 20px;
        border-radius: 6px 6px 0 0;
        font-size: 1.5rem;
    }

    .room-schedule table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .room-schedule th {
        background: #2151a2;
        color: white;
        padding: 10px 8px;
        text-align: center;
        border: 1px solid #001f3e;
    }

    .room-schedule td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        vertical-align: top;
        font-size: 14px;
    }

    .room-schedule tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .status-header {
        font-weight: bold;
        background-color: #f0f0f0;
        color: #333;
    }

    .status-free {
        color: #155724;
        font-weight: 500;
        background-color: #d4edda;
    }

    .status-busy {
        color: #721c24;
        font-weight: bold;
        background-color: #f8d7da;
    }

    .empty-state {
        padding: 20px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        border-radius: 6px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 968px) {
        .main-layout {
            flex-direction: column;
            gap: 10px;
        }

        .sidebar {
            width: 100%;
            padding: 15px;
        }

        .btn,
        .btn-primary,
        .btn-secondary {
            margin-bottom: 5px;
        }

        .week-info h2 {
            font-size: 1.3rem;
        }

        .week-info p {
            font-size: 0.95rem;
        }

        .room-schedule th,
        .room-schedule td {
            min-width: 50px;
        }

        .timetable-wrapper {
            margin-top: 10px;
        }
    }
</style>

<body>
    <?php include './header.php'; ?>

    <main>
        <div class="container">
            <div class="main-layout">
                <div class="sidebar">
                    <div class="filter-section">
                        <h3>🔍 Tìm kiếm</h3>
                        <form method="GET" action="lab_sched.php">
                            <input type="hidden" name="mode" id="mode" value="view_schedule">

                            <div class="form-group">
                                <label for="year">Năm</label>
                                <input type="number" name="year" id="year" value="<?php echo $selected_year; ?>" min="2020" required>
                            </div>

                            <div class="form-group">
                                <label for="week">Tuần</label>
                                <input type="number" name="week" id="week" value="<?php echo $selected_week; ?>" min="1" max="53" required>
                            </div>

                            <div class="form-group">
                                <label for="nhomphong">Nhóm Phòng</label>
                                <select name="nhomphong" id="nhomphong" onchange="this.form.submit()">
                                    <option value="TATCA">Tất cả</option>
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group['MaNhom']; ?>" <?php echo $selected_group === $group['MaNhom'] ? 'selected' : ''; ?>>
                                            <?php echo $group['TenNhom']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="phong">Phòng</label>
                                <select name="phong" id="phong">
                                    <option value="TATCA">Tất cả</option>
                                    <?php foreach ($temp_rooms as $room): ?>
                                        <option value="<?php echo $room['MaPhong']; ?>" <?php echo $selected_room === $room['MaPhong'] ? 'selected' : ''; ?>>
                                        <?php echo $room['TenPhong']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" name="action" value="view" class="btn btn-primary">Xem Lịch Trống</button>

                            <a href="?week=<?php echo $prev_week_info['week']; ?>&year=<?php echo $prev_week_info['year']; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>" class="btn btn-secondary">
                                ← Tuần Trước
                            </a>
                            <a href="?week=<?php echo $next_week_info['week']; ?>&year=<?php echo $next_week_info['year']; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>" class="btn btn-secondary">
                                Tuần Sau →
                            </a>
                        </form>
                    </div>
                </div>

                <div class="main-content">
                    <div class="week-info">
                        <h2>Lịch Phòng Trống Tuần <?php echo $selected_week; ?>/<?php echo $selected_year; ?></h2>
                        <p>Thời gian: <?php echo $start_date_display; ?> - <?php echo $end_date_display; ?></p>
                        <b>Chú thích: - tiết bận | 0..9 tiết trống</b>
                    </div>

                    <?php if (empty($all_rooms)): // Dùng $all_rooms để kiểm tra nếu không có phòng nào thỏa mãn bộ lọc ?>
                        <div class="empty-state">
                            <p>Không có phòng nào trong nhóm đã chọn để hiển thị.</p>
                        </div>
                    <?php else: ?>

                    <div class="timetable-wrapper">
                        <?php
                            // Hiển thị lịch (CHỈ LẶP QUA 1 PHÒNG ĐÃ PHÂN TRANG)
                            foreach ($rooms_to_display_paginated as $room):
                            $ma_phong = $room['MaPhong'];
                            $ten_phong = $room['TenPhong'];
                        ?>
                            <div class="room-schedule">
                                <h3>Phòng <?php echo $ten_phong; ?></h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Trạng Thái</th>
                                            <?php foreach ($days_of_week as $day): ?>
                                            <th><?php echo $day; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="status-header">Tiết Trống</td>
                                            <?php
                                                for ($day_index = 1; $day_index <= 7; $day_index++):
                                                $empty_slots = $empty_slots_by_room[$ma_phong][$day_index] ?? 'Không xác định';
                                            ?>
                                            <td class="<?php echo ($empty_slots === 'Đã kín') ? 'status-busy' : 'status-free'; ?>">
                                                <?php echo $empty_slots; ?>
                                            </td>
                                            <?php endfor; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($maxPage > 1): ?>
                        <div class="text-center my-4">
                            <nav aria-label="Room Page navigation">
                                <ul class="pagination justify-content-center">
                                    
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" 
                                            href="?page=<?php echo $currentPage - 1; ?>&year=<?php echo $selected_year; ?>&week=<?php echo $selected_week; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>&action=view" 
                                            aria-label="Previous">
                                                <span aria-hidden="true">←</span> 
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                            <a class="page-link" 
                                            href="?page=<?php echo $i; ?>&year=<?php echo $selected_year; ?>&week=<?php echo $selected_week; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>&action=view">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $maxPage): ?>
                                        <li class="page-item">
                                            <a class="page-link" 
                                            href="?page=<?php echo $currentPage + 1; ?>&year=<?php echo $selected_year; ?>&week=<?php echo $selected_week; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>&action=view" 
                                            aria-label="Next">
                                                <span aria-hidden="true">→</span>
                                            </a>
                                        </li>
                                    <?php endif; ?> 
                                                                       
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
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