<?php

function get_current_week_info()
{
    $current_date = new DateTime();
    $year = $current_date->format("Y");
    $week = $current_date->format("W");
    return ['year' => $year, 'week' => $week];
}

function get_prev_next_week(int $year, int $week, int $offset)
{
    $dto = new DateTime();    
    $week_str = str_pad((string)$week, 2, '0', STR_PAD_LEFT);
    
    $dto->setISODate($year, $week, 1);
    $dto->modify("$offset week");
    return ['year' => $dto->format("Y"), 'week' => $dto->format("W")];
}

function get_static_data(mysqli $conn)
{
    $lessons_res = $conn->query("SELECT * FROM tiethoc ORDER BY MaTiet");
    $lessons = $lessons_res ? $lessons_res->fetch_all(MYSQLI_ASSOC) : [];

    $groups_res = $conn->query("SELECT * FROM nhomphong ORDER BY MaNhom");
    $groups = $groups_res ? $groups_res->fetch_all(MYSQLI_ASSOC) : [];

    return [
        'lessons' => $lessons,
        'groups' => $groups,
        'days_of_week' => ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
        'day_map_to_index' => ['Thứ hai' => 1, 'Thứ ba' => 2, 'Thứ tư' => 3, 'Thứ năm' => 4, 'Thứ sáu' => 5, 'Thứ bảy' => 6, 'Chủ nhật' => 7]
    ];
}

function get_filtered_rooms(mysqli $conn, string $selected_group, string $selected_room)
{
    $all_rooms_sql = "SELECT MaPhong, TenPhong, MaNhom FROM phong";
    $conditions = [];

    if ($selected_group !== 'TATCA') 
        $conditions[] = "MaNhom = '$selected_group'";

    if ($selected_room !== 'TATCA')
        $conditions[] = "MaPhong = '$selected_room'";

    if (!empty($conditions))
        $all_rooms_sql .= " WHERE " . implode(" AND ", $conditions);
    
    $all_rooms_sql .= " ORDER BY TenPhong ASC";

    $all_rooms_res = $conn->query($all_rooms_sql);
    $all_rooms = $all_rooms_res ? $all_rooms_res->fetch_all(MYSQLI_ASSOC) : [];
    
    $all_room_codes = array_column($all_rooms, 'MaPhong');
    $all_room_names = array_column($all_rooms, 'TenPhong', 'MaPhong');

    return [
        'all_rooms' => $all_rooms,
        'all_room_codes' => $all_room_codes,
        'all_room_names' => $all_room_names
    ];
}

function get_busy_slots(mysqli $conn, array $all_room_codes, string $start_date, string $end_date, string $current_week_type, array $day_map_to_index)
{
    $busy_rooms_by_room_day_lesson = [];

    if (empty($all_room_codes))
        return $busy_rooms_by_room_day_lesson;

    $room_codes_list = "'" . implode("','", $all_room_codes) . "'";
    $ma_ttt_xuyensuot = 'TUANXS';

    $sql_where = "pm.NgayBD <= '$end_date' AND pm.NgayKT >= '$start_date'";
    $sql_where .= " AND (tgm.MaTTT = '$ma_ttt_xuyensuot' OR tgm.MaTTT = '$current_week_type')";
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
            $busy_rooms_by_room_day_lesson[$ma_phong][$day_index][$ma_tiet] = true;
        }
    }
    return $busy_rooms_by_room_day_lesson;
}

function map_lesson_to_char(string $ma_tiet)
{
    if (preg_match('/^T0*(\d+)$/i', $ma_tiet, $matches)) {
        $number = intval($matches[1]);
        if ($number >= 1 && $number <= 9) {
            return (string)$number;
        } elseif ($number >= 10 && $number <= 19) {
            return (string)($number % 10);
        }
    }
    return '?';
}

function calculate_empty_slots(array $all_rooms, array $lessons, array $day_map_to_index, array $busy_rooms_by_room_day_lesson)
{
    $empty_slots_by_room = [];
    $lessons_map = array_column($lessons, 'MaTiet');

    foreach ($all_rooms as $room) {
        $ma_phong = $room['MaPhong'];
        $empty_slots_by_room[$ma_phong] = [];

        foreach ($day_map_to_index as $day_name_db => $day_index) {

            $busy_lessons_for_slot = $busy_rooms_by_room_day_lesson[$ma_phong][$day_index] ?? [];
            $slot_string = '';

            foreach ($lessons_map as $ma_tiet) {
                if (isset($busy_lessons_for_slot[$ma_tiet]))
                    $slot_string .= '-';
                else
                    $slot_string .= map_lesson_to_char($ma_tiet);
    
            }
            $empty_slots_by_room[$ma_phong][$day_index] = $slot_string;
        }
    }
    return $empty_slots_by_room;
}

function get_full_busy_schedule_data(mysqli $conn, int $selected_year, int $selected_week, string $selected_group, string $selected_room, array $lessons_map) {
    
    $dto = new DateTime();
    $dto->setISODate($selected_year, $selected_week, 1);
    $start_date = $dto->format('Y-m-d');
    $dto->setISODate($selected_year, $selected_week, 7);
    $end_date = $dto->format('Y-m-d');
    
    $current_week_type = ($selected_week % 2 == 0) ? 'CHAN' : 'LE';
    $ma_ttt_current = ($current_week_type === 'LE') ? 'TUANLE' : 'TUANCHAN';
    $ma_ttt_xuyensuot = 'TUANXS';

    $sql_where = "pm.NgayBD <= '$end_date' AND pm.NgayKT >= '$start_date'";
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
        -- Lấy trạng thái phiếu mượn mới nhất
        JOIN trangthaiphieumuon ttp ON (
             SELECT MaTTPM FROM chitietttpm WHERE MaPhieu = pm.MaPhieu GROUP BY MaPhieu
        ) = ttp.MaTTPM
        WHERE $sql_where
        ORDER BY p.MaPhong, FIELD(nt.MaNgay, 'THUHAI', 'THUBA', 'THUTU', 'THUNAM', 'THUSAU', 'THUBAY', 'CHUNHAT'), t.MaTiet
    ";

    $result = $conn->query($sql);
    $raw_timetable_data = [];
    $day_sort_map = ['Thứ hai' => 1, 'Thứ ba' => 2, 'Thứ tư' => 3, 'Thứ năm' => 4, 'Thứ sáu' => 5, 'Thứ bảy' => 6, 'Chủ nhật' => 7];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $day_index = $day_sort_map[$row['TenNgay']] ?? 0;
            $raw_timetable_data[$row['TenPhong']][$day_index][$row['MaTiet']][] = $row;
        }
    }

    $timetable_data = [];
    
    foreach ($raw_timetable_data as $room_name => $days) {
        foreach ($days as $day_index => $lessons_by_id) {
            $grouped_events = [];
            $current_group_key = null;
            ksort($lessons_by_id); 
            foreach ($lessons_by_id as $lesson_id => $events) {
                $event = $events[0]; 
                $group_key = $event['MaPhieu'] . '|' . $event['TrangThaiPhieuMuon'];

                if ($group_key === $current_group_key) {
                    $grouped_events[count($grouped_events) - 1]['rowspan']++;
                } else {
                    $event['rowspan'] = 1;
                    $event['start_lesson'] = $lessons_map[$lesson_id] ?? $lesson_id;
                    $grouped_events[] = $event;
                    $current_group_key = $group_key;
                }
            }
            $timetable_data[$room_name][$day_index] = $grouped_events;
        }
    }
    return $timetable_data;
}

function get_schedule_data(mysqli $conn)
{
    $current_week_info = get_current_week_info();
    $default_year = $current_week_info['year'];
    $default_week = $current_week_info['week'];

    $selected_year = isset($_GET['year']) ? intval($_GET['year']) : $default_year;
    $selected_week = isset($_GET['week']) ? intval($_GET['week']) : $default_week;
    $selected_group = isset($_GET['nhomphong']) && $_GET['nhomphong'] !== 'TATCA' ? $conn->real_escape_string($_GET['nhomphong']) : 'TATCA';
    
    $selected_room = isset($_GET['phong']) && $_GET['phong'] !== 'TATCA' ? $conn->real_escape_string($_GET['phong']) : 'TATCA';
   
    $submit_source = $_GET['submit_source'] ?? '';
    
    if ($submit_source === 'group-submit') {        
        $selected_room = 'TATCA';
    } else {        
        $selected_room = $selected_room;
    }

    $current_week_type = ($selected_week % 2 == 0) ? 'TUANCHAN' : 'TUANLE';

    $dto = new DateTime();
    $dto->setISODate($selected_year, $selected_week, 1);
    $start_date = $dto->format('Y-m-d');
    $start_date_display = $dto->format('d/m/Y');
    $dto->setISODate($selected_year, $selected_week, 7);
    $end_date = $dto->format('Y-m-d');
    $end_date_display = $dto->format('d/m/Y');

    $prev_week_info = get_prev_next_week($selected_year, $selected_week, -1);
    $next_week_info = get_prev_next_week($selected_year, $selected_week, 1);

    $static_data = get_static_data($conn);
    $lessons = $static_data['lessons'];
    $groups = $static_data['groups'];
    $days_of_week = $static_data['days_of_week'];
    $day_map_to_index = $static_data['day_map_to_index'];
    
    $room_data = get_filtered_rooms($conn, $selected_group, $selected_room);
    $all_rooms = $room_data['all_rooms'];
    $all_room_codes = $room_data['all_room_codes'];

    $busy_slots_data = get_busy_slots($conn, $all_room_codes, $start_date, $end_date, $current_week_type, $day_map_to_index);

    $empty_slots_by_room = calculate_empty_slots($all_rooms, $lessons, $day_map_to_index, $busy_slots_data);
    
    $temp_rooms_sql = "SELECT MaPhong, TenPhong FROM phong";
    if ($selected_group !== 'TATCA') {
        $temp_rooms_sql .= " WHERE MaNhom = '$selected_group'";
    }
    $temp_rooms_sql .= " ORDER BY TenPhong ASC";
    $temp_rooms_res = $conn->query($temp_rooms_sql);
    $temp_rooms = $temp_rooms_res ? $temp_rooms_res->fetch_all(MYSQLI_ASSOC) : [];    

    return [
        'selected_year' => $selected_year,
        'selected_week' => $selected_week,
        'selected_group' => $selected_group,
        'selected_room' => $selected_room,
        'start_date_display' => $start_date_display,
        'end_date_display' => $end_date_display,
        'prev_week_info' => $prev_week_info,
        'next_week_info' => $next_week_info,
        'groups' => $groups,
        'days_of_week' => $days_of_week,
        'all_rooms' => $all_rooms,
        'temp_rooms' => $temp_rooms, 
        'lessons' => $lessons,
        'empty_slots_by_room' => $empty_slots_by_room,
    ];
}