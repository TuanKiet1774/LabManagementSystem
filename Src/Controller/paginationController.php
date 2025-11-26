<?php

//Phân trang cho danh sách phòng
function paginate_rooms(array $all_rooms, int $page)
{
    $rowPerPage = 1; // 1 phòng mỗi trang
    $count = count($all_rooms);
    
    // Đảm bảo trang hợp lệ
    $maxPage = ceil($count / $rowPerPage);
    if ($page < 1) $page = 1;
    if ($maxPage > 0 && $page > $maxPage) $page = $maxPage;
    if ($maxPage === 0) $page = 1; // Trường hợp không có phòng nào
    
    $offset = ($page - 1) * $rowPerPage;

    // Lấy 1 phòng tương ứng với trang hiện tại
    $room_to_display = array_slice($all_rooms, $offset, $rowPerPage);

    return [
        'rooms_to_display' => $room_to_display,
        'maxPage' => (int)$maxPage,
        'currentPage' => (int)$page,
    ];
}