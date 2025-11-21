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

        table {
            width: 55%;
            margin: 10px auto;
            background: white;
            border-radius: 14px;
            overflow: hidden;
        }

        thead th {
            background: #c7d2fe; 
            color: #3f3d56;
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

                <div class="text-center mt-3" style="min-height: calc(100vh - 200px);">
                    <a href="thietbi.php" class="btn btn-primary px-4">Quay lại</a>
                </div>
                ';
            }

            else {
                if($n > 0) {
                    echo "<h2>Danh sách thiết bị</h2>";
                    echo '
                    <div class="row mb-3 align-items-center">
                        <div class="">
                            <div class="col-lg-4 col-md-7 mb-2 mb-md-0">
                                <form method="GET" class="d-flex flex-column flex-md-row gap-2 search-form">
                                    <input type="text" class="form-control flex-grow-1" name="keyword"
                                        placeholder="Tìm theo tên thiết bị / loại / trạng thái"
                                        value="'.($_GET['keyword'] ?? '').'">
                                    <button class="btn btn-search px-3 py-1 px-md-4 py-md-2 text-sm text-md-base">Tìm</button>
                                </form>
                            </div>

                            <div class="col-lg-4 col-md-5 mt-2">
                                <a href="thietbi_them.php" class="btn-add w-auto px-3 py-1 px-md-4 py-md-2 text-sm text-md-base">+ Thêm</a>
                            </div>
                        </div>
                    </div>';

                    echo '<div class="table-responsive">';
                        echo '<table class="table table-hover align-middle text-center">';
                            echo "
                            <thead class='table-primary'>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã thiết bị</th>
                                    <th>Tên thiết bị</th>
                                    <th class='d-none d-md-table-cell'>Loại</th>
                                    <th class='d-none d-md-table-cell'>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                            ";


                        $index = $offset + 1;

                        for($i=0; $i<$n; $i++) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<tr>
                                    <td>$index</td>
                                    <td>{$row['MaThietBi']}</td>
                                    <td>{$row['TenThietBi']}</td>
                                    <td class='d-none d-md-table-cell'>{$row['TenLoai']}</td>
                                    <td class='d-none d-md-table-cell'>{$row['TenTTTB']}</td>
                                    <td class='action-links flex-column flex-md-row'>
                                        <a href='thietbi_xem.php?maThietBi={$row['MaThietBi']}'>Xem</a>
                                        <a href='thietbi_sua.php?maThietBi={$row['MaThietBi']}'>Sửa</a>
                                        <a href='thietbi_xoa.php?maThietBi={$row['MaThietBi']}'>Xóa</a>
                                    </td>
                                </tr>";
                            $index++;
                        }

                        echo "</tbody></table>";
                    echo "</div>"; // table-responsive

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
        crossorigin="anonymous"></script>
<?php include("./footer.php"); ?>
</body>
</html>
