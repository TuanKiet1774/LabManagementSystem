<!doctype html>
<html lang="en">

<head>
    <title>Lịch sử phiểu mượn</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    main {
        font-size: 15px;
        margin: 40px;
    }

    table {
        margin: 0 auto;
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    }

    th {
        background: #c7d2fe;
        color: #3f3d56;
        padding: 12px;
        font-size: 16px;
    }

    td {
        padding: 10px;
        font-size: 15px;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    tr:nth-child(even) {
        background-color: #f0f5ff;
    }

    tr:hover {
        background-color: #e6f0ff;
        transition: 0.2s;
    }

    td a {
        display: inline-block;
        padding: 5px;
        margin: 2px;
        text-decoration: none;
        color: white;
        border-radius: 6px;
        font-size: 14px;
    }

    .detail {
        background: #93c5fd !important;
    }

    .detail:hover {
        background: #60a5fa !important;
    }


    .edit {
        background: #fda4af !important;
    }

    .edit:hover {
        background: #fb7185 !important;
    }

    .delete {
        background: #fbbf24 !important;
    }

    .delete:hover {
        background: #f59e0b !important;
    }

    .pagination,
    .search-box {
        margin: 10px auto 0 auto;
        display: flex;
        justify-content: center;
        gap: 10px;
        background-color: #c7d2ff;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    .pagination a {
        text-decoration: none;
    }

    input[type='text'] {
        padding: 5px;
        border: none;
        border-radius: 5px;
        width: 100%;
    }

    .btnSearch {
        width: 50%;
        color: white;
        padding: 5px;
        border-radius: 10px;
        border: none;
        text-decoration: none;
        background-color: orange;
    }

    .btnSearch:hover {
        background-color: white;
        color: orange;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/controller.php');
    include_once('./Controller/loginController.php');
    $user = checkLogin();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    if (isset($_GET['search']) && $_GET['search'] !== "") {
        $search = $_GET['search'];
        $sql = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, ttpm.TenTTPM, nd.Ho, nd.Ten
                FROM phieumuon pm
                INNER JOIN chitietttpm ctpm 
                ON pm.MaPhieu = ctpm.MaPhieu
                INNER JOIN trangthaiphieumuon ttpm
                ON ctpm.MaTTPM = ttpm.MaTTPM
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND
                WHERE pm.MucDich LIKE '%$search%' 
                OR ttpm.TenTTPM LIKE '%$search%'
                OR CONCAT(nd.Ho, ' ', nd.Ten) LIKE '%$search%'
                ORDER BY MaPhieu DESC";
    } else {
        $sql = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, ttpm.TenTTPM, nd.Ho, nd.Ten
                FROM phieumuon pm
                INNER JOIN chitietttpm ctpm 
                ON pm.MaPhieu = ctpm.MaPhieu
                INNER JOIN trangthaiphieumuon ttpm
                ON ctpm.MaTTPM = ttpm.MaTTPM
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND
                ORDER BY MaPhieu DESC";
    }
    $pagination = pagination($con, 3, $sql, $page);
    $db = $pagination['data'];
    $maxPage = $pagination['maxPage'];
    ?>

    <?php include './header.php'; ?>
    <main>
        <div class="container-fluid">
            <form method="GET" class="search-box mb-3">
                <h3 class="me-auto d-md-block d-none">
                    <b>Lịch sử tìm kiếm</b>
                </h3>
                <div class="d-flex justify-content-between">
                    <input type="text" name="search" placeholder="Mục đích, trạng thái, tên..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button type="submit" class="btnSearch ms-3">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>

            <table>
                <tr align="center">
                    <th>Mã phiếu</th>
                    <th>Người dùng</th>
                    <th>Mục đích</th>
                    <th class="d-none d-md-table-cell">Bắt đầu</th>
                    <th class="d-none d-md-table-cell">Kết thúc</th>
                    <th class="d-none d-md-table-cell">Thời gian tạo</th>
                    <th class="d-none d-md-table-cell">Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                <?php
                while ($col = mysqli_fetch_assoc($db)) {
                    echo "<tr>";
                    echo "<td align='center'>" . $col['MaPhieu'] . "</td>";
                    echo "<td align='center'>" . $col['Ho'] . " " . $col['Ten'] . "</td>";
                    echo "<td>" . $col['MucDich'] . "</td>";
                    echo "<td class='d-none d-md-table-cell' align='center'>" . date("d/m/Y", strtotime($col['NgayBD'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell' align='center'>" . date("d/m/Y", strtotime($col['NgayKT'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell' align='center'>" . date("d/m/Y H:i", strtotime($col['NgayTao'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell' align='center'>" . $col['TenTTPM'] . "</td>";
                    echo "<td align='center'>
                            <a class='detail' href='history_detail.php?maphieu=" . $col['MaPhieu'] . "'>Xem</a><br class='d-md-none'>
                            <a class='edit' href='history_edit.php?maphieu=" . $col['MaPhieu'] . "'>Sửa</a><br class='d-md-none'>
                            <a class= 'delete' href='history_delete.php?maphieu=" . $col['MaPhieu'] . "'>Xóa</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <div class="pagination mt-3">
                <?php
                if ($page > 1) {
                    echo "<a href = " . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "> <i class='fa-solid fa-circle-arrow-left'></i> </a>";
                }

                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($page == $i) {
                        echo "<b> $i </b>";
                    } else {
                        echo "<a href = " . $_SERVER['PHP_SELF'] . "?page=$i> $i </a>";
                    }
                }

                if ($page < $maxPage) {
                    echo "<a href = " . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . "> <i class='fa-solid fa-circle-arrow-right'></i> </a>";
                }
                ?>
            </div>
    </main>
    <?php include './footer.php'; ?>
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