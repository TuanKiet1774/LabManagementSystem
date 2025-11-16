<!doctype html>
<html lang="en">

<head>
    <title>Chi tiết lịch sử phiếu mượn</title>
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

    .detail-box {
        margin: 10px auto 0 auto;
        background-color: #c7d2ff;
        width: 90%;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    table {
        width: 95%;
        margin: auto;
        margin-block: 10px;
        background-color: aliceblue;
        border-radius: 12px;
    }

    tr,
    td {
        padding: 8px 12px;
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

    .btnBack {
        background: #93c5fd !important;
    }

    .btnBack:hover {
        background: #60a5fa !important;
    }


    .btnEdit {
        background: #fda4af !important;
    }

    .btnEdit:hover {
        background: #fb7185 !important;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    $user = checkLogin();

    $maphieu = isset($_GET['maphieu']) ? $_GET['maphieu'] : '';
    $sql1 = "SELECT pm.MaPhieu, pm.MucDich, pm.NgayBD, pm.NgayKT, pm.NgayTao, p.TenPhong, nd.Ho, nd.Ten, nd.Email, np.TenNhom
                FROM phieumuon pm
                INNER JOIN nguoidung nd
                ON pm.MaND = nd.MaND
                INNER JOIN phong p
                ON pm.MaPhong = p.MaPhong
                INNER JOIN nhomphong np
                ON p.MaNhom = np.MaNhom
                WHERE pm.MaPhieu = '$maphieu'";

    $db1 = mysqli_query($con, $sql1);

    $sql2 = "SELECT tgm.MaTGM, tt.TenTTT AS TrangThaiTuan, nt.TenNgay AS NgayTrongTuan, th.TenTiet, th.GioBG, th.GioKT
            FROM thoigianmuon tgm
            JOIN tiethoc th ON tgm.MaTiet = th.MaTiet
            JOIN trangthaituan tt ON tgm.MaTTT = tt.MaTTT
            JOIN ngaytuan nt ON tgm.MaNgay = nt.MaNgay
            WHERE tgm.MaPhieu = '$maphieu'
            ORDER BY th.GioBG;";
    $db2 = mysqli_query($con, $sql2);
    ?>
    <?php include './header.php'; ?>
    <main>
        <div class="container-fluid">
            <div class="detail-box">
                <center>
                    <h2><b>Chi tiết phiếu mượn</b></h2>
                </center>
                <table>
                    <?php
                    $col1 = mysqli_fetch_assoc($db1);
                    $col2 = mysqli_fetch_assoc($db2);
                    echo "<tr>";
                    echo "<td><b><i class='fa-solid fa-user-tie'></i> Tài khoản: </b>" . $col1['Ho'] . " " . $col1['Ten'] . "</td>";
                    echo "<td><b><i class='fa-solid fa-envelope-open-text'></i> Email: </b>" . $col1['Email'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td><b><i class='fa-solid fa-people-roof'></i> Phòng mượn: </b>" . $col1['TenPhong'] . "</td>";
                    echo "<td><b><i class='fa-solid fa-location-dot'></i> Vị trí phòng: </b>" . $col1['TenNhom'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td colspan='2'><b><i class='fa-solid fa-receipt'></i> Mục đích: </b>" . $col1['MucDich'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td><b><i class='fa-solid fa-hourglass-start'></i> Bắt đầu từ: </b>" . date("d/m/Y", strtotime($col1['NgayBD'])) . "</td>";
                    echo "<td><b><i class='fa-solid fa-hourglass-end'></i> Kết thúc vào: </b>" . date("d/m/Y", strtotime($col1['NgayKT'])) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td colspan='2'><b><i class='fa-solid fa-clock'></i> Thời gian mượn chi tiết:</b></td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<tr>";
                    echo "<td colspan='2'><b>- Tuần học: </b>" . (!empty($col2['TrangThaiTuan']) ? $col2['TrangThaiTuan'] : "Chưa xếp") . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td colspan='2'><b>- Ngày học: </b>" . (!empty($col2['NgayTrongTuan']) ? $col2['NgayTrongTuan'] : "Chưa xếp") . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td colspan='2'><i>Phiếu mượn được tạo lúc " . date("d/m/Y", strtotime($col1['NgayTao'])) . "</i></td>";
                    echo "</tr>";

                    ?>
                    <tr>
                        <td class="m-4" colspan="2" align="center">
                            <a href="javascript:window.history.back(); window.location.href='./signup.php';" class="btnBack ms-3">Quay lại</a>
                            <a href="./history_delete.php" class="btnEdit ms-3">Xoá</a>
                        </td>
                    </tr>
                </table>
            </div>
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