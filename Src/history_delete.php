<!doctype html>
<html lang="en">

<head>
    <title>Xoá lịch sử phiếu mượn</title>
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
        color: white !important;
    }

    .btnBack:hover {
        background: #60a5fa !important;
    }


    .btnDelete {
        background: #fda4af !important;
        color: white !important;
    }

    .btnDelete:hover {
        background: #fb7185 !important;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/historyController.php');
    $user = checkLogin();

    $maphieu = isset($_GET['maphieu']) ? $_GET['maphieu'] : '';
    $db1 = mysqli_query($con, $sql1);
    $db2 = mysqli_query($con, $sql2);
    $db3 = mysqli_query($con, $sql2);

    $col1 = mysqli_fetch_assoc($db1);
    $col2 = mysqli_fetch_assoc($db2);
    if (isset($_GET['btnDelete'])) {
        if (deleteHistory($con, $maphieu)) {
            echo "<script>
                alert('Xoá phiếu mượn thành công!');
                window.location.href = 'history.php';
              </script>";
        } else {
            echo "<script>alert('Không thể xoá phiếu!');</script>";
        }
        exit();
    }


    ?>
    <?php include './header.php'; ?>
    <main>
        <div class="container-fluid">
            <div class="detail-box p-4">
                <center>
                    <h2 class="mb-4 text-danger"><b>Bạn có chắc chắn muốn xoá thông tin này</b></h2>
                </center>

                <div class="container-fluid bg-white p-3 rounded-3 shadow-sm">
                    <div class="row mb-2 pb-2 border-bottom">
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-user-tie"></i> Tài khoản: </b><?php echo $col1['Ho'] . " " . $col1['Ten']; ?>
                        </div>
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-envelope-open-text"></i> Email: </b><?php echo $col1['Email']; ?>
                        </div>
                    </div>

                    <div class="row mb-2 pb-2 border-bottom">
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-people-roof"></i> Phòng mượn: </b><?php echo $col1['TenPhong']; ?>
                        </div>
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-location-dot"></i> Vị trí phòng: </b><?php echo $col1['TenNhom']; ?>
                        </div>
                    </div>

                    <div class="row mb-2 pb-2 border-bottom">
                        <div class="col-12">
                            <b><i class="fa-solid fa-receipt"></i> Mục đích: </b><?php echo $col1['MucDich']; ?>
                        </div>
                    </div>

                    <div class="row mb-3 pb-2 border-bottom">
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-hourglass-start"></i> Bắt đầu từ: </b><?php echo date("d/m/Y", strtotime($col1['NgayBD'])); ?>
                        </div>
                        <div class="col-md-6">
                            <b><i class="fa-solid fa-hourglass-end"></i> Kết thúc vào: </b><?php echo date("d/m/Y", strtotime($col1['NgayKT'])); ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <b><i class="fa-solid fa-clock"></i> Thời gian mượn chi tiết:</b>
                        </div>
                    </div>

                    <div class="row mb-2 pb-2">
                        <div class="col-12">
                            <b>- Tuần học: </b><?php echo (!empty($col2['TrangThaiTuan']) ? $col2['TrangThaiTuan'] : "Chưa xếp"); ?>
                        </div>
                    </div>

                    <div class="row mb-2 pb-2">
                        <div class="col-12">
                            <b>- Ngày học: </b><?php echo (!empty($col2['NgayTrongTuan']) ? $col2['NgayTrongTuan'] : "Chưa xếp"); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 ps-4">
                            <?php
                            while ($col3 = mysqli_fetch_assoc($db3)) {
                                echo '<div class="mb-1">';
                                echo $col3['TenTiet'] . " (" . date("H:i", strtotime($col3['GioBG'])) . " - " . date("H:i", strtotime($col3['GioKT'])) . ")";
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <i class="text-muted">Phiếu mượn được tạo lúc <?php echo date("d/m/Y H:i", strtotime($col1['NgayTao'])); ?></i>
                        </div>
                    </div>

                    <div class="row mt-4 pt-3 border-top">
                        <form method="GET" class="col-12 text-center">
                            <input type="hidden" name="maphieu" value="<?php echo $maphieu; ?>">

                            <a href="javascript:window.history.back();" class="btnBack btn ms-2 me-2">Quay lại</a>
                            <button type="submit" name="btnDelete" class="btnDelete btn ms-2 me-2">
                                Xác nhận
                            </button>
                        </form>
                    </div>

                </div>
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