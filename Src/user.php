<!doctype html>
<html lang="en">

<head>
    <title>Danh sách người dùng</title>
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

    .btnSearch,
    .btnAdd {
        color: white;
        padding: 5px;
        border-radius: 10px;
        border: none;
        text-decoration: none;
    }

    .btnSearch {
        width: 60%;
        background-color: orange;
    }

    .btnAdd {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 50%;
        background-color: green;
    }

    .btnSearch:hover {
        background-color: white;
        color: orange;
    }

    .btnAdd:hover {
        background-color: white;
        color: green;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/controller.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/userController.php');

    $user = checkLogin();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
    $sql = infoUser($search);
    $pagination = pagination($con, 10, $sql, $page);
    $db = $pagination['data'];
    $maxPage = $pagination['maxPage'];
    ?>

    <?php include './header.php'; ?>
    <main>
        <div class="container-fluid">
            <form method="GET" class="search-box mb-3">
                <h3 class="me-auto d-md-block d-none">
                    <b>Danh sách người dùng</b>
                </h3>
                <div class="d-flex justify-content-between">
                    <input type="text" name="search" placeholder="Mã số, họ tên, vai trò,..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button type="submit" class="btnSearch ms-3">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <a href="./user_add.php" class="btnAdd ms-3">
                        Thêm
                        <i class="fa-solid fa-user-plus"></i>
                    </a>
                </div>
            </form>

            <table>
                <tr align="center">
                    <th>Mã số</th>
                    <th>Họ tên</th>
                    <th class="d-none d-md-table-cell">Ngày sinh</th>
                    <th class="d-none d-md-table-cell">Email</th>
                    <th>Vai trò</th>
                    <th>Chức năng</th>
                </tr>
                <?php
                while ($col = mysqli_fetch_assoc($db)) {
                    echo "<tr>";
                    echo "<td align='center'>" . $col['MaND'] . "</td>";
                    echo "<td align='center'>" . $col['Ho'] . " " . $col['Ten'] . "</td>";
                    echo "<td class='d-none d-md-table-cell' align='center'>" . date("d/m/Y", strtotime($col['NgaySinh'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell' >" . $col['Email'] . "</td>";
                    echo "<td align='center'>" . $col['TenVT'] . "</td>";
                    if ($user['MaVT'] === 'QTV') {
                        echo "<td align='center'>";
                        echo "<a class='detail' href='user_detail.php?maND=" . $col['MaND'] . "'>Xem</a><br class='d-md-none'>";
                        echo "<br class='d-md-none'>";
                        echo "<a class='edit' href='user_edit.php?maND=" . $col['MaND'] . "'>Sửa</a>";
                        echo "<br class='d-md-none'>";
                        echo "<a class='delete' href='user_delete.php?maND=" . $col['MaND'] . "'>Xóa</a>";
                        echo "</td>";
                    }
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