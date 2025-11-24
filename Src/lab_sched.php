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
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    $user = checkLogin();

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) die("Lỗi kết nối: " . $conn->connect_error);

    // Lấy thông tin tuần/năm hiện tại (giá trị mặc định)
    function get_current_week_info()
    {
        $current_date = new DateTime();
        $year = $current_date->format("Y");
        $week = $current_date->format("W");
        return ['year' => $year, 'week' => $week];
    }

    $current_week_info = get_current_week_info();
    $default_year = $current_week_info['year'];
    $default_week = $current_week_info['week'];

    // Lấy giá trị đã chọn/mặc định
    $selected_year = isset($_GET['year']) ? intval($_GET['year']) : $default_year;
    $selected_week = isset($_GET['week']) ? intval($_GET['week']) : $default_week;

    $selected_group = isset($_GET['nhomphong']) && $_GET['nhomphong'] !== 'TATCA' ? $conn->real_escape_string($_GET['nhomphong']) : 'TATCA';
    // Phòng 
    $selected_room = isset($_GET['phong']) && $_GET['phong'] !== 'TATCA' ? $conn->real_escape_string($_GET['phong']) : 'TATCA';
    $current_week_type = ($selected_week % 2 == 0) ? 'TUANCHAN' : 'TUANLE';

    // Xử lý logic thời gian tuần
    $dto = new DateTime();
    $dto->setISODate($selected_year, $selected_week, 1);
    $start_date = $dto->format('Y-m-d');
    $start_date_display = $dto->format('d/m/Y');
    $dto->setISODate($selected_year, $selected_week, 7);
    $end_date = $dto->format('Y-m-d');
    $end_date_display = $dto->format('d/m/Y');

    function get_prev_next_week($year, $week, $offset)
    {
        $dto = new DateTime();
        $dto->setISODate($year, $week, 1);
        $dto->modify("$offset week");
        return ['year' => $dto->format("Y"), 'week' => $dto->format("W")];
    }

    $prev_week_info = get_prev_next_week($selected_year, $selected_week, -1);
    $next_week_info = get_prev_next_week($selected_year, $selected_week, 1);

    // Lấy dữ liệu tĩnh cho bộ lọc
    $lessons_res = $conn->query("SELECT * FROM tiethoc ORDER BY MaTiet");
    $lessons = $lessons_res->fetch_all(MYSQLI_ASSOC);
    $groups_res = $conn->query("SELECT * FROM nhomphong ORDER BY MaNhom");
    $groups = $groups_res->fetch_all(MYSQLI_ASSOC);
    // Tên ngày cho Header (Thứ 2 đến Chủ Nhật)
    $days_of_week = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'];
    // Map tên ngày CSDL
    $day_map_to_index = ['Thứ hai' => 1, 'Thứ ba' => 2, 'Thứ tư' => 3, 'Thứ năm' => 4, 'Thứ sáu' => 5, 'Thứ bảy' => 6, 'Chủ nhật' => 7];
    // Map index (1-7) sang tên ngày (Thứ 2, Thứ 3,...)
    $index_to_day_name_display = array_combine(array_values($day_map_to_index), $days_of_week);

    // 1. Lấy danh sách TẤT CẢ các phòng có thể lọc (Dựa trên nhóm phòng đã chọn)
    $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong";
    if ($selected_group !== 'TATCA') {
        $all_rooms_sql .= " WHERE MaNhom = '$selected_group'";
    }

    if ($selected_room !== 'TATCA') {
        if ($selected_group !== 'TATCA') {
            $all_rooms_sql .= " AND MaPhong = '$selected_room'";
        } else
            $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaPhong = '$selected_room'";
    }
    // Đảm bảo $all_rooms_sql luôn đúng
    if ($selected_group !== 'TATCA' && $selected_room !== 'TATCA')
        $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaNhom = '$selected_group' AND MaPhong = '$selected_room'";
    elseif ($selected_group !== 'TATCA')
        $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaNhom = '$selected_group'";
    elseif ($selected_room !== 'TATCA')
        $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong WHERE MaPhong = '$selected_room'";
    else
        $all_rooms_sql = "SELECT MaPhong, TenPhong FROM phong";

    $all_rooms_sql .= " ORDER BY TenPhong ASC"; // Sắp xếp theo tên phòng
    $all_rooms_res = $conn->query($all_rooms_sql);
    $all_rooms = $all_rooms_res->fetch_all(MYSQLI_ASSOC);
    $all_room_codes = array_column($all_rooms, 'MaPhong');
    $all_room_names = array_column($all_rooms, 'TenPhong', 'MaPhong');


    // 2. Lấy danh sách các phòng BẬN (đã được đăng ký) trong tuần
    $busy_rooms_by_room_day_lesson = [];

    if (!empty($all_room_codes)) {
        $room_codes_list = "'" . implode("','", $all_room_codes) . "'";

        // Điều kiện lọc theo ngày bắt đầu/kết thúc phiếu mượn
        $sql_where = "pm.NgayBD <= '$end_date' AND pm.NgayKT >= '$start_date'";

        $ma_ttt_xuyensuot = 'TUANXS';

        // Lọc theo tuần chẵn/lẻ hoặc xuyên suốt
        $sql_where .= " AND (tgm.MaTTT = '$ma_ttt_xuyensuot' OR tgm.MaTTT = '$current_week_type')";

        // Chỉ lấy các phòng trong danh sách đã lọc theo nhóm
        $sql_where .= " AND p.MaPhong IN ($room_codes_list)";

        $sql = "
                SELECT
                    p.MaPhong, 
                    tgm.MaTiet, 
                    nt.TenNgay,
                    nt.MaNgay
                FROM phieumuon pm
                JOIN phong p ON pm.MaPhong = p.MaPhong
                JOIN thoigianmuon tgm ON pm.MaPhieu = tgm.MaPhieu
                JOIN ngaytuan nt ON tgm.MaNgay = nt.MaNgay
                JOIN trangthaiphieumuon ttp ON (
                    SELECT MaTTPM FROM chitietttpm WHERE MaPhieu = pm.MaPhieu GROUP BY MaPhieu
                ) = ttp.MaTTPM 
                WHERE $sql_where AND ttp.TenTTPM IN ('Đã duyệt', 'Chưa duyệt')
            ";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $day_index = $day_map_to_index[$row['TenNgay']] ?? 0;
                $ma_phong = $row['MaPhong'];
                $ma_tiet = $row['MaTiet'];

                // Lưu MaTiet vào mảng bận theo Phòng và Ngày
                $busy_rooms_by_room_day_lesson[$ma_phong][$day_index][$ma_tiet] = true;
            }
        }
    }

    // Hàm chuyển đổi MaTiet sang ký tự hiển thị rút gọn
    function map_lesson_to_char($ma_tiet)
    {
        if (preg_match('/^T0*(\d+)$/i', $ma_tiet, $matches)) {
            $number = intval($matches[1]);

            if ($number >= 1 && $number <= 9) {
                return (string)$number; // 1 -> "1", 9 -> "9"
            } elseif ($number >= 10 && $number <= 19) {
                // 10 -> 0, 11 -> 1, 12 -> 2, ...
                return (string)($number % 10);
            }
        }
        return '?'; // Mặc định nếu không khớp
    }

    // 3. Xử lý logic hiển thị (Tìm phòng trống)
    $empty_slots_by_room = [];

    foreach ($all_rooms as $room) {
        $ma_phong = $room['MaPhong'];
        $empty_slots_by_room[$ma_phong] = [];

        // Duyệt qua tất cả 7 ngày (1-7)
        foreach ($day_map_to_index as $day_name_db => $day_index) {

            $busy_lessons_for_slot = $busy_rooms_by_room_day_lesson[$ma_phong][$day_index] ?? [];

            $slot_string = '';

            // Lặp qua tất cả các tiết theo đúng thứ tự của $lessons
            foreach ($lessons as $lesson) {
                $ma_tiet = $lesson['MaTiet'];

                if (isset($busy_lessons_for_slot[$ma_tiet])) {
                    // Tiết BẬN -> Dấu gạch ngang "-"
                    $slot_string .= '-';
                } else {
                    // Tiết TRỐNG -> Ký tự rút gọn
                    $slot_string .= map_lesson_to_char($ma_tiet);
                }
            }

            // Gán chuỗi kết quả (ví dụ: "123----890123")
            $empty_slots_by_room[$ma_phong][$day_index] = $slot_string;
        }
    }
    ?>
    <?php include './header.php'; ?>
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
                                <?php
                                $temp_rooms_sql = "SELECT MaPhong, TenPhong FROM phong";
                                if ($selected_group !== 'TATCA') {
                                    $temp_rooms_sql .= " WHERE MaNhom = '$selected_group'";
                                }
                                $temp_rooms_sql .= " ORDER BY TenPhong ASC";
                                $temp_rooms_res = $conn->query($temp_rooms_sql);
                                $temp_rooms = $temp_rooms_res->fetch_all(MYSQLI_ASSOC);
                                ?>

                                <!-- Duyệt qua danh sách phòng đã được lọc -->
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
                </div>

                <?php if (empty($all_rooms)): ?>
                    <div class="empty-state">
                        <p>Không có phòng nào trong nhóm đã chọn để hiển thị.</p>
                    </div>
                <?php else: ?>

                    <div class="timetable-wrapper">
                        <?php
                        // Hiển thị lịch từng phòng
                        foreach ($all_rooms as $room):
                            $ma_phong = $room['MaPhong'];
                            $ten_phong = $room['TenPhong'];
                        ?>
                            <div class="room-schedule">
                                <h3>Phòng <?php echo $ten_phong; ?></h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Trạng Thái</th>
                                            <?php
                                            // Header Ngày (Thứ 2 - Chủ Nhật)
                                            foreach ($days_of_week as $day): ?>
                                                <th><?php echo $day; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="status-header">Tiết Trống</td>
                                            <?php
                                            // Duyệt qua 7 ngày trong tuần
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

                <?php endif; ?>

            </div>
        </div>
    </div>

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