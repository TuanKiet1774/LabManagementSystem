<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thiết bị</title>

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

        /* Table styling */
        .desktop-table {
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
        }

        .desktop-table thead th {
            border: 1px solid #cbd5e1;
        }

        .desktop-table td {
            border: 1px solid #e2e8f0;
        }

        .table.desktop-table tbody tr:nth-child(odd) {
            background-color: #e0f2fe !important;
        }

        .table.desktop-table tbody tr:nth-child(even) {
            background-color: #f0f9ff !important;
        }


        .desktop-table tbody tr:hover {
            background-color: #bae6fd !important;
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
            background: #6366f1;
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
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.25s;
            white-space: nowrap;
            display: inline-block;
        }

        .btn-add:hover {
            background: #60a5fa;
            color: white;
        }

        /* Responsive pagination */
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

        /* Mobile responsive table */
        @media (max-width: 768px) {
            .table-responsive {
                border: none;
            }

            /* Hide table on mobile, use cards instead */
            .desktop-table {
                display: none;
            }

            .mobile-cards {
                display: block;
            }

            .device-card {
                background: white;
                border-radius: 10px;
                padding: 15px;
                margin-bottom: 15px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }

            .device-card .card-row {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .device-card .card-row:last-child {
                border-bottom: none;
            }

            .device-card .label {
                font-weight: 600;
                color: #666;
            }

            .device-card .value {
                text-align: right;
                color: #333;
            }

            .action-links {
                justify-content: flex-end;
                margin-top: 10px;
            }
        }

        @media (min-width: 769px) {
            .mobile-cards {
                display: none;
            }

            .desktop-table {
                display: table;
            }
        }

        /* Responsive search bar */
        @media (max-width: 576px) {
            .search-form {
                flex-direction: column;
            }

            .search-form input {
                margin-bottom: 10px;
            }

            .btn-add {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include("./header.php"); ?>
    <?php include("../Database/config.php"); ?>

    <div class="container my-4">

    <?php
        if(!isset($_GET['page'])) $_GET['page'] = 1;

        $keyword = $_GET['keyword'] ?? '';
        $search = "";

        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($con, $keyword);
            $search = "AND (
                tb.TenThietBi LIKE '%$keyword%' OR 
                loai.TenLoai LIKE '%$keyword%' OR 
                tttb.TenTTTB LIKE '%$keyword%'
            )";
        }

        $rowPerPage = 10;
        $offset = ($_GET['page'] - 1) * $rowPerPage;

        $sqlCount = "SELECT COUNT(*) as total
            FROM thietbi tb
            JOIN loai ON loai.MaLoai = tb.MaLoai
            JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
            JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
            WHERE 1=1 $search";

        $resultCount = mysqli_query($con, $sqlCount);
        $rowCount = mysqli_fetch_assoc($resultCount);
        $totalRow = $rowCount['total'];
        $maxPage = ceil($totalRow / $rowPerPage);

        $sql = "SELECT tb.*, tttb.TenTTTB, loai.*
            FROM thietbi tb
            JOIN loai ON loai.MaLoai = tb.MaLoai
            JOIN chitiettttb cttttb ON tb.MaThietBi = cttttb.MaThietBi
            JOIN trangthaithietbi tttb ON cttttb.MaTTTB = tttb.MaTTTB
            WHERE 1=1 $search
            ORDER BY tb.MaThietBi ASC
            LIMIT $offset, $rowPerPage";

        $result = mysqli_query($con, $sql);
        $n = mysqli_num_rows($result);
        if ($n == 0) {
            echo "<h2>Danh sách thiết bị</h2>";

            echo '
            <div class="alert alert-danger text-center mt-4" style="font-size:18px; border-radius:10px;">
                <strong>Không tìm thấy kết quả.</strong><br>
                Từ khóa tìm kiếm: <span style="color:#d63384;">'.($keyword).'</span>
            </div>

            <div class="text-center mt-3">
                <a href="thietbi.php" class="btn btn-primary px-4">Quay lại</a>
            </div>
            ';
        }

        else {
            if($n > 0) {
            echo "<h2>Danh sách thiết bị</h2>";

            
            echo '
            <div class="row mb-3 align-items-center">
                <div class="col-lg-8 col-md-7 mb-2 mb-md-0">
                    <form method="GET" class="d-flex gap-2 search-form">
                        <input type="text" class="form-control" name="keyword"
                            placeholder="Tìm theo tên thiết bị / loại / trạng thái"
                            value="'.($_GET['keyword'] ?? '').'">
                        <button class="btn btn-search px-4">Tìm</button>
                    </form>
                </div>

                <div class="col-lg-4 col-md-5 text-md-end">
                    <a href="thietbi_them.php" class="btn-add">+ Thêm thiết bị</a>
                </div>
            </div>';

            echo '<div class="table-responsive">';
                echo '<table class="table table-hover align-middle text-center desktop-table">';
                    echo "
                    <thead class='table-primary'>
                        <tr>
                            <th>STT</th>
                            <th>Mã thiết bị</th>
                            <th>Tên thiết bị</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                    ";

                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }

                $index = $offset + 1;

                // DESKTOP TABLE
                foreach ($data as $row) {
                    echo "<tr>
                            <td>$index</td>
                            <td>{$row['MaThietBi']}</td>
                            <td>{$row['TenThietBi']}</td>
                            <td>{$row['TenLoai']}</td>
                            <td>{$row['TenTTTB']}</td>
                            <td class='action-links'>
                                <a href='thietbi_xem.php?maThietBi={$row['MaThietBi']}'>Xem</a>
                                <a href='thietbi_sua.php?maThietBi={$row['MaThietBi']}'>Sửa</a>
                                <a href='thietbi_xoa.php?maThietBi={$row['MaThietBi']}'>Xóa</a>
                            </td>
                        </tr>";
                    $index++;
                }

                echo "</tbody></table>";
                echo "</div>"; // table-responsive


                // MOBILE CARDS
                echo '<div class="mobile-cards">';

                $index = $offset + 1;
                foreach ($data as $row) {
                    echo "
                    <div class='device-card'>
                        <div class='card-row'><span class='label'>STT:</span> <span class='value'>$index</span></div>
                        <div class='card-row'><span class='label'>Mã thiết bị:</span> <span class='value'>{$row['MaThietBi']}</span></div>
                        <div class='card-row'><span class='label'>Tên thiết bị:</span> <span class='value'>{$row['TenThietBi']}</span></div>
                        <div class='card-row'><span class='label'>Loại:</span> <span class='value'>{$row['TenLoai']}</span></div>
                        <div class='card-row'><span class='label'>Trạng thái:</span> <span class='value'>{$row['TenTTTB']}</span></div>
                        <div class='action-links'>
                            <a href='thietbi_xem.php?maThietBi={$row['MaThietBi']}'>Xem</a>
                            <a href='thietbi_sua.php?maThietBi={$row['MaThietBi']}'>Sửa</a>
                            <a href='thietbi_xoa.php?maThietBi={$row['MaThietBi']}'>Xóa</a>
                        </div>
                    </div>";
                    $index++;
                }

                echo "</div>"; // mobile-cards



            // Pagination
            echo '<div class="pagination-wrapper">';

                if($_GET['page'] > 1)
                    echo "<a href='?page=".($_GET['page'] - 1)."&keyword=".urlencode($keyword)."'>«</a>";

                // Smart pagination for mobile
                $range = 2;
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == 1 || $i == $maxPage || ($i >= $_GET['page'] - $range && $i <= $_GET['page'] + $range)) {
                        if ($i == $_GET['page']) {
                            echo "<span class='current'>$i</span>";
                        } else {
                            echo "<a href='?page=$i&keyword=".urlencode($keyword)."'>$i</a>";
                        }
                    } elseif ($i == $_GET['page'] - $range - 1 || $i == $_GET['page'] + $range + 1) {
                        echo "<span>...</span>";
                    }
                }

                if ($_GET['page'] < $maxPage)
                    echo "<a href='?page=".($_GET['page'] + 1)."&keyword=".urlencode($keyword)."'>»</a>";

            echo '</div>';
        }
    }
    ?>
    </div>

    

    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>
<?php include("./footer.php"); ?>
</body>
</html>