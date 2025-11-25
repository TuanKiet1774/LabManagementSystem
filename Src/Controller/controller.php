<?php
// Phân trang
function pagination($con, $rowPerPage, $sqlCount, $page)
{
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $rowPerPage;
    $dbCount = mysqli_query($con, $sqlCount);
    $count = mysqli_num_rows($dbCount);
    $maxPage = ceil($count / $rowPerPage);

    $sql = $sqlCount . " LIMIT $offset, $rowPerPage";
    $data = mysqli_query($con, $sql);
    return ['data' => $data, 'maxPage' => $maxPage];
}
?>