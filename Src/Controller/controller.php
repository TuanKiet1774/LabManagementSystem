<?php
// Phân trang
function pagination($con, $rowPerPage, $sqlData, $sqlCount, $page) {
    if ($page < 1) $page = 1;

    // Lấy tổng số dòng
    $resultCount = mysqli_query($con, $sqlCount);
    $totalRow = mysqli_fetch_assoc($resultCount)['total'];
    $maxPage = ceil($totalRow / $rowPerPage);

    // Tính offset
    $offset = ($page - 1) * $rowPerPage;
    
    // Thêm LIMIT vào query dữ liệu
    $sqlData .= " LIMIT $offset, $rowPerPage";
    $data = mysqli_query($con, $sqlData);

    return ['data' => $data, 'maxPage' => $maxPage];
}

?>