<?php

function infoHistory($search)
{
    $sql = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, ttpm.MaTTPM, ttpm.TenTTPM, nd.Ho, nd.Ten
                FROM phieumuon pm
                INNER JOIN chitietttpm ctpm 
                ON pm.MaPhieu = ctpm.MaPhieu
                INNER JOIN trangthaiphieumuon ttpm
                ON ctpm.MaTTPM = ttpm.MaTTPM
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND";
    $condition = "WHERE pm.MucDich LIKE '%$search%' 
                OR ttpm.TenTTPM LIKE '%$search%'
                OR CONCAT(nd.Ho, ' ', nd.Ten) LIKE '%$search%'";
    $sort = "ORDER BY MaPhieu DESC";

    if (isset($search) && $search !== "") {
        $sqlfull = $sql . " " . $condition . " " . $sort;
    } else {
        $sqlfull = $sql . " " . $sort;
    }

    return $sqlfull;
}
