<?php
include("../Database/config.php");
include_once('./Controller/controller.php');
include_once('./Controller/labController.php');
include_once('./Controller/loginController.php');
$user = checkLogin();
$vaiTro = $user['MaVT'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Danh sách phòng máy</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f5ff;
        }

        h2 {
            text-align: center;
            color: #6a5acd;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            margin: 20px 0;
        }

        table {
            width: 55%;
            margin: 10px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 14px;
            overflow: hidden;
        }

        thead th {
            background: #c7d2fe !important;
            color: #3f3d56 !important;
            padding: 12px;
            font-size: 18px;
            text-align: center;
        }

        td {
            padding: 15px;
            border: 1px solid #eee;
            vertical-align: top;
            font-size: 16px;
            color: #333;
        }

        .stripe td,
        .stripe th {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
            line-height: 1.6;
        }

        .stripe tbody tr:nth-child(even) td {
            background-color: #f0f5ff !important;
        }

        .stripe tbody tr:hover td {
            background-color: #e6f0ff !important;
        }

        /* Responsive table actions */
        .action-links {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
        }

        .action-links a {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            white-space: nowrap;
        }

        .action-links a:first-child {
            background: #93c5fd;
        }

        .action-links a:first-child:hover {
            background: #60a5fa;
        }

        .action-links a:nth-child(2) {
            background: #fbbf24;
        }

        .action-links a:nth-child(2):hover {
            background: #f59e0b;
        }

        .action-links a:nth-child(3) {
            background: #fda4af;
        }

        .action-links a:nth-child(3):hover {
            background: #fb7185;
        }

        button.btn-search {
            background: #6a5acd;
            color: white;
        }

        button.btn-search:hover {
            background: #6366f1;
            color: white;
        }

        .btn-add {
            padding: 10px 20px;
            background: #67c5ffff;
            color: white;
            width: 40%;
            text-align: center;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.25s;
            white-space: nowrap;
            display: inline-block;
        }

        .btn-add:hover {
            background: #1096fd;
            color: white;
        }

        /* Responsive pagination */
        /* page */
        .pagination {
            margin: 20px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            text-decoration: none;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 6px;
            font-size: 15px;
            min-width: 35px;
        }

        .pagination a:hover {
            background: #c7d2fe;
        }

        .pagination .current {
            background: #6366f1;
            color: white;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination-wrapper a,
        .pagination-wrapper span {
            padding: 8px 12px;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 6px;
            min-width: 35px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .pagination-wrapper .current {
            background: #6366f1;
            color: white;
        }

        .action-links a.muon-phong {
            background-color: #4aa8ffff;
            color: white;
            pointer-events: auto;
            transition: 0.3s;
        }

        .action-links a.muon-phong:hover {
            background-color: #259dffff;
        }

        .action-links a.muon-phong.disabled {
            background-color: #d1d5db;
            color: #6b7280;
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>


<body>
    <?php
    include("./header.php");
    if (!isset($_GET['page'])) $_GET['page'] = 1;
    $keyword = $_GET['keyword'] ?? '';
    $search = labSearch($con, $keyword);

    $page = $_GET['page'] ?? 1;
    $rowPerPage = 10;
    $offset = ($_GET['page'] - 1) * $rowPerPage;
    // $sqlCount = "SELECT COUNT(*) as total from phong";
    $sqlCount = "SELECT COUNT(*) as total
                FROM phong p
                JOIN nhomphong np ON np.MaNhom = p.MaNhom
                JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
                JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
                WHERE 1=1 $search";
    $resultCount = mysqli_query($con, $sqlCount);
    $rowCount = mysqli_fetch_assoc($resultCount);
    $totalRow = $rowCount['total'];
    $maxPage = ceil($totalRow / $rowPerPage);

    $sqlData = "SELECT p.MaPhong, p.TenPhong, p.SucChua, np.TenNhom, tt.TenTTP
            FROM phong p
            JOIN nhomphong np ON np.MaNhom = p.MaNhom
            JOIN chitietttp ct ON ct.MaPhong = p.MaPhong
            JOIN trangthaiphong tt ON ct.MaTTP = tt.MaTTP
            WHERE 1=1 $search
            Order by p.MaPhong asc";

    // Gọi hàm pagination
    $pagination = pagination($con, $rowPerPage, $sqlData, $sqlCount, $page);
    $result = $pagination['data'];
    $maxPage = $pagination['maxPage'];
    $offset = ($page - 1) * $rowPerPage;
    $n = mysqli_num_rows($result);

    ?>
    <div class="container my-4">
        <?php
        if ($n == 0) {
            echo "<h2>Danh sách phòng máy</h2>";
            echo '
                    <div class="alert alert-danger text-center mt-4" style="font-size:18px; border-radius:10px;">
                        <strong>Không tìm thấy kết quả.</strong><br>
                        Từ khóa tìm kiếm: <span style="color:#d63384;">' . ($keyword) . '</span>
                    </div>

                    <div class="text-center mt-3" style="min-height: calc(100vh - 200px);">
                        <a href="lab.php" class="btn btn-primary px-4">Quay lại</a>
                    </div>
                    ';
        } else {
            if ($n > 0) {
                echo "<h2 style='text-align: center;'>Danh sách phòng máy</h2>";
                $index = $offset + 1;
                echo '<div class="row mb-3 align-items-center">
                        <div class="">
                            <div class="col-lg-4 col-md-7 mb-2 mb-md-0">
                                <form method="GET" class="d-flex flex-column flex-md-row gap-2 search-form">
                                    <input type="text" class="form-control flex-grow-1" name="keyword"
                                        placeholder="Tìm theo tên phòng / nhóm / trạng thái"
                                        value="' . ($_GET['keyword'] ?? '') . '">
                                    <button class="btn btn-search px-3 py-1 px-md-4 py-md-2 text-sm text-md-base">Tìm</button>
                                </form>
                            </div>

                            <div class="col-lg-4 col-md-5 mt-2">';
                if ($vaiTro === 'QTV') {
                    echo '<a href="lab_add.php" class="btn-add w-auto px-3 py-1 px-md-4 py-md-2 text-sm text-md-base">+ Thêm</a>';
                }
                echo '</div>
                        </div>
                    </div>';

                echo '<div class="table-responsive">';
                echo '<table class="table align-middle text-center stripe">';
                echo "<thead class='table-primary'>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phòng</th>
                                    <th>Tên phòng</th>
                                    <th>Tên nhóm</th>
                                    <th class='d-none d-md-table-cell'>Sức chứa</th>
                                    <th class='d-none d-md-table-cell'>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>";
                $index = $offset + 1;
                for ($i = 0; $i < $n; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    $trangThai = $row['TenTTP'];
                    $disabledClass = ($trangThai != 'Hoạt động') ? 'disabled' : '';
                    $muonPhongLink = ($trangThai == 'Hoạt động')
                        ? "lab_booking.php?maPhong=" . $row['MaPhong']
                        : "#";
                    echo "<tr>
                                        <td>$index</td>
                                        <td>{$row['MaPhong']}</td>
                                        <td>{$row['TenPhong']}</td>
                                        <td>{$row['TenNhom']}</td>
                                        <td class='d-none d-md-table-cell'>{$row['SucChua']}</td>
                                        <td class='d-none d-md-table-cell'>{$row['TenTTP']}</td>
                                        <td class='action-links flex-column flex-md-row'>
                                            <a href='lab_detail.php?maPhong={$row['MaPhong']}'>Xem</a>";
                    if ($vaiTro === 'QTV' || $vaiTro === 'GV') {
                        echo "<a href='lab_edit.php?maPhong={$row['MaPhong']}'>Sửa</a>";
                    }
                    if ($vaiTro === 'QTV') {
                        echo "<a href='lab_delete.php?maPhong={$row['MaPhong']}'>Xóa</a>";
                    }
                    echo "<a href='$muonPhongLink' class='$disabledClass muon-phong'>Mượn phòng</a>
                                        </td>
                                    </tr>";
                    $index++;
                }
                echo "</tbody>
                        </table>";
                echo "</div>"; // table-responsive
                echo '<div class="pagination">';
                // nut prev
                if ($_GET['page'] > 1) {
                    echo "<a href='?page=" . ($_GET['page'] - 1) . "&keyword=$keyword'>«</a>";
                }

                // số trang
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $_GET['page']) {
                        echo "<span class='current'>$i</span>";
                    } else {
                        echo "<a href='?page=$i&keyword=$keyword'>$i</a>";
                    }
                }

                // next
                if ($_GET['page'] < $maxPage) {
                    echo "<a href='?page=" . ($_GET['page'] + 1) . "&keyword=$keyword'>»</a>";
                }

                echo '</div>';
            }
        }
        ?>
    </div>
    <?php include("./footer.php"); ?>

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