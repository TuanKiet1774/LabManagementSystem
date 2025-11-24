<?php
session_start();
if (!isset($_SESSION['MaVT']) || $_SESSION['MaVT'] !== 'QTV') {
    header("Location: ./index.php");
    exit();
}

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date('Y-m-01');
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date('Y-m-t');

$sql = "SELECT p.MaPhong, p.TenPhong, COUNT(pm.MaPhieu) AS SoLuongPhieuMuon
        FROM phong p 
        LEFT JOIN phieumuon pm 
        ON p.MaPhong = pm.MaPhong
        AND (pm.NgayBD <= '$endDate' AND pm.NgayKT >= '$startDate')
        GROUP BY p.MaPhong, p.TenPhong 
        ORDER BY SoLuongPhieuMuon DESC, p.MaPhong ASC;";
