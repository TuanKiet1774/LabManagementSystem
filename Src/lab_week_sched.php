<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Lịch Phòng Máy</title>
    
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
            width: calc(100% - 40px);
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-layout {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        /* Sidebar Form */
        .sidebar {
            width: 250px;
            flex-shrink: 0;
        }

        .filter-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .filter-section h3 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #2151a2;
            padding-bottom: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 15px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15 px;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #2151a2;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: #2151a2 !important;
            color: white;
        }

        .btn-primary:hover {
            background: #325096;
        }

        .btn-secondary {
            background: #2151a2;
            color: white;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-secondary:hover {
            background: #10285a;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            min-width: 0;
        }

        .week-info {
            background: #2151a2;
            color: white;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }

        .week-info h2 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .week-info p {
            font-size: 18px;
            margin: 0;
        }

        /* Room Section */
        .room-section {
            margin-bottom: 30px;
        }

        .room-title {
            background: #2151a2;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        /* Timetable */
        .timetable-wrapper {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .timetable {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed !important;
        }

        .timetable thead th {
            background: #2151a2;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            border: 1px solid #10285a;
        }

        .timetable thead th:first-child {
            width: 100px;
        }

        .timetable thead th:not(:first-child) {
            width: calc((100% - 100px) / 7);
        }

        .timetable tbody td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 15px;
            min-height: 60px;
        }

        .lesson-header {
            font-weight: bold;
            color: #333;
        }

        .lesson-header small {
            display: block;
            font-size: 11px;
            color: #666;
            margin-top: 3px;
            font-weight: normal;
        }

        .timetable tbody tr:nth-child(odd) {
            background-color: #f0f0f0;
        }

        /* Status Colors */
        .status-chua-duyet {
            background-color: #cce5ff;
        }

        .status-da-duyet {
            background-color: #d4edda;
        }

        .status-khong-chap-nhan {
            background-color: #f8d7da;
        }

        .lesson-info {
            line-height: 1.5;
        }

        .lesson-info strong {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .lesson-info small {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            color: #666;
        }

        /* Legend */
        .legend {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }

        .legend-color {
            width: 30px;
            height: 20px;
            border-radius: 3px;
            border: 1px solid #999;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .main-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .btn {
                margin-bottom: 5px;
            }
        }
    </style>
<body>
    <?php
    include './header.php';
    include('../Database/config.php');
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) die("Lỗi kết nối: " . $conn->connect_error);

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

    $selected_year = isset($_GET['year']) ? intval($_GET['year']) : $default_year;
    $selected_week = isset($_GET['week']) ? intval($_GET['week']) : $default_week;
    $selected_group = isset($_GET['nhomphong']) && $_GET['nhomphong'] !== 'TATCA' ? $conn->real_escape_string($_GET['nhomphong']) : 'TATCA';
    $selected_room = isset($_GET['phong']) && $_GET['phong'] !== 'TATCA' ? $conn->real_escape_string($_GET['phong']) : 'TATCA';
    $current_week_type = ($selected_week % 2 == 0) ? 'CHAN' : 'LE';

    if ($selected_room !== 'TATCA' && $selected_group !== 'TATCA') {
        $check_room_sql = "SELECT COUNT(*) FROM phong WHERE MaPhong = '$selected_room' AND MaNhom = '$selected_group'";
        $check_res = $conn->query($check_room_sql);
        if ($check_res && $check_res->fetch_row()[0] == 0) {
            $selected_room = 'TATCA';
        }
    }

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

    $lessons_res = $conn->query("SELECT * FROM tiethoc ORDER BY MaTiet");
    $lessons = $lessons_res->fetch_all(MYSQLI_ASSOC);

    $groups_res = $conn->query("SELECT * FROM nhomphong ORDER BY MaNhom");
    $groups = $groups_res->fetch_all(MYSQLI_ASSOC);

    $room_sql = "SELECT * FROM phong";
    if ($selected_group !== 'TATCA') {
        $room_sql .= " WHERE MaNhom = '$selected_group'";
    }
    $room_sql .= " ORDER BY MaPhong";
    $rooms_res = $conn->query($room_sql);
    $rooms = $rooms_res->fetch_all(MYSQLI_ASSOC);

    $days_of_week = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];

    $sql_where = "pm.NgayBD <= '$end_date' AND pm.NgayKT >= '$start_date'";

    $ma_ttt_current = ($current_week_type === 'LE') ? 'TUANLE' : 'TUANCHAN';
    $ma_ttt_xuyensuot = 'TUANXS';

    $sql_where .= " AND (tgm.MaTTT = '$ma_ttt_xuyensuot' OR tgm.MaTTT = '$ma_ttt_current')";

    if ($selected_group !== 'TATCA')
        $sql_where .= " AND p.MaNhom = '$selected_group'";
    if ($selected_room !== 'TATCA')
        $sql_where .= " AND p.MaPhong = '$selected_room'";

    $sql = "
            SELECT
                pm.MaPhieu, pm.MaPhong, pm.MucDich, pm.NgayBD, pm.NgayKT,
                p.TenPhong,
                nd.Ho, nd.Ten, nd.MaVT,
                tgm.MaTGM, t.MaTiet, t.TenTiet, t.GioBG, t.GioKT, nt.TenNgay,
                ttt.TenTTT AS TrangThaiTuan,
                ttp.TenTTPM AS TrangThaiPhieuMuon
            FROM phieumuon pm
            JOIN phong p ON pm.MaPhong = p.MaPhong
            JOIN nguoidung nd ON pm.MaND = nd.MaND
            JOIN thoigianmuon tgm ON pm.MaPhieu = tgm.MaPhieu
            JOIN tiethoc t ON tgm.MaTiet = t.MaTiet
            JOIN ngaytuan nt ON tgm.MaNgay = nt.MaNgay
            JOIN trangthaituan ttt ON tgm.MaTTT = ttt.MaTTT
            JOIN chitietttpm cttp ON pm.MaPhieu = cttp.MaPhieu
            JOIN trangthaiphieumuon ttp ON cttp.MaTTPM = ttp.MaTTPM
            WHERE $sql_where
            ORDER BY p.MaPhong, FIELD(nt.MaNgay, 'THUHAI', 'THUBA', 'THUTU', 'THUNAM', 'THUSAU', 'THUBAY', 'CHUNHAT'), t.MaTiet
        ";

    $result = $conn->query($sql);
    $raw_timetable_data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $day_sort_map = ['Thứ hai' => 1, 'Thứ ba' => 2, 'Thứ tư' => 3, 'Thứ năm' => 4, 'Thứ sáu' => 5, 'Thứ bảy' => 6, 'Chủ nhật' => 7];
            $day_index = $day_sort_map[$row['TenNgay']] ?? 0;
            $raw_timetable_data[$row['TenPhong']][$day_index][$row['MaTiet']][] = $row;
        }
    }

    $timetable_data = [];
    $lessons_map = array_column($lessons, 'TenTiet', 'MaTiet');
    $lessons_map_ten = array_column($lessons, 'MaTiet', 'TenTiet');

    foreach ($raw_timetable_data as $room_name => $days) {
        foreach ($days as $day_index => $lessons_by_id) {
            $grouped_events = [];
            $current_group_key = null;
            ksort($lessons_by_id);

            foreach ($lessons_by_id as $lesson_id => $events) {
                $event = $events[0];
                $group_key = $event['MucDich'] . '|' . $event['Ho'] . '|' . $event['Ten'] . '|' . $event['TrangThaiPhieuMuon'];

                if ($group_key === $current_group_key) {
                    $grouped_events[count($grouped_events) - 1]['rowspan']++;
                } else {
                    $event['rowspan'] = 1;
                    $event['start_lesson'] = $lessons_map[$lesson_id];
                    $grouped_events[] = $event;
                    $current_group_key = $group_key;
                }
            }
            $timetable_data[$room_name][$day_index] = $grouped_events;
        }
    }
    ?>

    <div class="container">
        <div class="main-layout">
            <!-- Sidebar Filter -->
            <div class="sidebar">
                <div class="filter-section">
                    <h3>🔍 Tìm kiếm</h3>
                    <form method="GET" action="lab_week_sched.php">
                        <div class="form-group">
                            <!-- Trường ẩn để đánh dấu đây là thao tác chỉ để tải lại phòng theo nhóm phòng chứ không xem lịch ngay-->
                            <input type="hidden" name="mode" id="mode" value="view_schedule">

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
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?php echo $room['MaPhong']; ?>" <?php echo $selected_room === $room['MaPhong'] ? 'selected' : ''; ?>>
                                        <?php echo $room['TenPhong']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="action" value="view" class="btn btn-primary">Xem Lịch</button>

                        <a href="?week=<?php echo $prev_week_info['week']; ?>&year=<?php echo $prev_week_info['year']; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>" class="btn btn-secondary">
                            ← Tuần Trước
                        </a>

                        <a href="?week=<?php echo $next_week_info['week']; ?>&year=<?php echo $next_week_info['year']; ?>&nhomphong=<?php echo $selected_group; ?>&phong=<?php echo $selected_room; ?>" class="btn btn-secondary">
                            Tuần Sau →
                        </a>
                    </form>
                </div>

                <!-- Legend -->
                <div class="legend" style="flex-direction: column; margin-top: 15px;">
                    <div style="font-weight: bold; margin-bottom: 8px; text-align: center;">Chú thích</div>
                    <div class="legend-item">
                        <div class="legend-color status-khong-chap-nhan"></div>
                        <span>Không chấp nhận</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color status-da-duyet"></div>
                        <span>Đã duyệt</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color status-chua-duyet"></div>
                        <span>Chưa duyệt</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="week-info">
                    <h2>Lịch Đăng Ký Phòng - Tuần <?php echo $selected_week; ?>/<?php echo $selected_year; ?></h2>
                    <p><?php echo $start_date_display; ?> - <?php echo $end_date_display; ?></p>
                </div>

                <?php
                $rooms_to_display = $rooms;
                if ($selected_group !== 'TATCA') {
                    $rooms_to_display = array_filter($rooms_to_display, function ($r) use ($selected_group) {
                        return isset($r['MaNhom']) && $r['MaNhom'] === $selected_group;
                    });
                }
                if ($selected_room !== 'TATCA') {
                    $rooms_to_display = array_filter($rooms_to_display, function ($r) use ($selected_room) {
                        return $r['MaPhong'] === $selected_room;
                    });
                }

                if (empty($rooms_to_display)):
                ?>
                    <div class="empty-state">
                        <p>Không tìm thấy phòng nào thỏa mãn tiêu chí tìm kiếm.</p>
                    </div>
                    <?php else:
                    foreach ($rooms_to_display as $room):
                        $current_room_name = $room['TenPhong'];
                        $current_room_schedule = $timetable_data[$current_room_name] ?? [];
                    ?>
                        <div class="room-section">
                            <div class="room-title">🏢 <?php echo $current_room_name; ?></div>

                            <div class="timetable-wrapper">
                                <table class="timetable">
                                    <thead>
                                        <tr>
                                            <th>Tiết</th>
                                            <?php foreach ($days_of_week as $day): ?>
                                                <th><?php echo $day; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $lesson_rows_to_skip_by_day = array_fill(1, 7, 0);

                                        foreach ($lessons as $lesson):
                                            $lesson_name = $lesson['TenTiet'];
                                            $lesson_time = substr($lesson['GioBG'], 0, 5) . " - " . substr($lesson['GioKT'], 0, 5);
                                            $lesson_id = $lesson['MaTiet'];
                                        ?>
                                            <tr>
                                                <td class="lesson-header">
                                                    <?php echo $lesson_name; ?>
                                                    <!-- <small><?php echo $lesson_time; ?></small> -->
                                                </td>

                                                <?php
                                                // Lặp qua 7 ngày trong tuần
                                                foreach ($days_of_week as $day_index => $day_name):
                                                    $day_key = $day_index + 1; // 1 (Thứ 2) đến 7 (CN)

                                                    // BƯỚC 1: Xử lý các ô đã bị gộp (skip)
                                                    if ($lesson_rows_to_skip_by_day[$day_key] > 0) {
                                                        $lesson_rows_to_skip_by_day[$day_key]--; // Giảm bộ đếm (đã bỏ qua 1 hàng)
                                                        continue;
                                                    }

                                                    $events = $current_room_schedule[$day_key] ?? [];
                                                    $found_event = null;

                                                    // BƯỚC 2: Tìm sự kiện BẮT ĐẦU từ tiết này
                                                    foreach ($events as $event) {
                                                        if ($event['start_lesson'] === $lesson_name) {
                                                            $found_event = $event;
                                                            break;
                                                        }
                                                    }

                                                    if ($found_event) {
                                                        $rowspan_value = $found_event['rowspan'];

                                                        // Thiết lập bộ đếm skip cho các hàng (tiết) tiếp theo
                                                        $lesson_rows_to_skip_by_day[$day_key] = $rowspan_value - 1;

                                                        // Xác định trạng thái
                                                        $status_class = '';
                                                        if ($found_event['TrangThaiPhieuMuon'] === 'Chưa duyệt')
                                                            $status_class = 'status-chua-duyet';
                                                        elseif ($found_event['TrangThaiPhieuMuon'] === 'Đã duyệt')
                                                            $status_class = 'status-da-duyet';
                                                        elseif ($found_event['TrangThaiPhieuMuon'] === 'Không chấp nhận')
                                                            $status_class = 'status-khong-chap-nhan';

                                                        $borrower = ($found_event['MaVT'] === 'GV') ? 'GV' : (($found_event['MaVT'] === 'SV') ? 'SV' : 'QTV');
                                                ?>
                                                        <td class="<?php echo $status_class; ?>" rowspan="<?php echo $rowspan_value; ?>">
                                                            <div class="lesson-info">
                                                                <strong style="font-size: 14px;"><?php echo substr($found_event['GioBG'], 0, 5); ?></strong>
                                                                <?php echo $found_event['MucDich']; ?>
                                                                <br>
                                                                <strong style="font-size: 14px;"><?php echo $borrower; ?>: <?php echo $found_event['Ho'] . ' ' . $found_event['Ten']; ?></strong>
                                                                <!-- <small>(<?php echo $found_event['TrangThaiTuan']; ?>)</small> -->
                                                                <small style="font-size: 14px;">(<?php echo $rowspan_value; ?> tiết)</small>
                                                            </div>
                                                        </td>
                                                    <?php
                                                    } else {
                                                        // Ô trống bình thường
                                                    ?>
                                                        <td></td>
                                                <?php
                                                    }
                                                endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>

    <?php include './footer.php'; ?>
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