<?php

//Lấy danh sách tất cả các phòng để hiển thị trong dropdown.
function getAllRooms($conn) {
    $rooms = [];
    $sql = "SELECT MaPhong, TenPhong FROM phong ORDER BY TenPhong ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    return $rooms;
}

//Lấy danh sách phiếu mượn của người dùng hiện tại, có hỗ trợ tìm kiếm.
function getBorrowedLabs($conn, $ma_nguoi_dung, $search_data = []) {
    $search_conditions = [];
    $search_params = [];
    $param_types = [];
    $results = [];

    // Lấy dữ liệu tìm kiếm   
    $search_maphong = trim($search_data['search_maphong'] ?? ''); 
    $search_trangthai = trim($search_data['search_trangthai'] ?? '');
    $search_ngaytao = trim($search_data['search_ngaytao'] ?? '');

    $sql = "
        SELECT
            PM.NgayTao,
            P.TenPhong,
            PM.MucDich,
            PM.NgayBD,
            PM.NgayKT,
            TTPM.TenTTPM AS TrangThaiPhieuMuon
        FROM
            phieumuon PM
        JOIN
            phong P ON PM.MaPhong = P.MaPhong
        JOIN
            chitietttpm CTTM ON PM.MaPhieu = CTTM.MaPhieu
        JOIN
            trangthaiphieumuon TTPM ON CTTM.MaTTPM = TTPM.MaTTPM
        WHERE
            PM.MaND = ? 
    ";
    
    // Thêm Mã người dùng vào tham số truy vấn đầu tiên
    $param_types[] = "s"; 
    $search_params[] = $ma_nguoi_dung;

    // Tìm kiếm theo mã phòng (từ dropdown)
    if (!empty($search_maphong)) {
        $search_conditions[] = "PM.MaPhong = ?"; // Tìm kiếm chính xác theo Mã phòng
        $search_params[] = $search_maphong;
        $param_types[] = "s";
    }

    // Tìm kiếm theo Trạng thái duyệt
    if (!empty($search_trangthai)) {
        $search_conditions[] = "CTTM.MaTTPM = ?";
        $search_params[] = $search_trangthai;
        $param_types[] = "s";
    }

    // Tìm kiếm theo Thời gian mượn (NgayTao)
    if (!empty($search_ngaytao)) {
        $search_conditions[] = "DATE(PM.NgayTao) = ?";
        $search_params[] = $search_ngaytao;
        $param_types[] = "s";
    }

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search_conditions)) {
        $sql .= " AND " . implode(' AND ', $search_conditions);
    }

    $sql .= " ORDER BY PM.NgayTao DESC;";
    
    // Thực thi Prepared Statement
    if ($stmt = $conn->prepare($sql)) {
        $param_types_string = implode('', $param_types);
        
        // Bind các tham số
        $stmt->bind_param($param_types_string, ...$search_params);
        
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }
        $stmt->close();
    }

    return $results;
}