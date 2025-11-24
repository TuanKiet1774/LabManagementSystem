<!doctype html>
<html lang="en">

<head>
    <title>Chỉnh sữa thông tin trạng thái phiếu mượn</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    .background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: url('Image/background.jpg') center/cover no-repeat;
        filter: blur(5px);
        z-index: -1;
    }

    .static {
        width: 100%;
        max-width: 50%;
        margin: 40px auto;
        padding: 20px 30px;
        background-color: #eeebebff;
        border-radius: 20px;
        font-size: 15px;
    }

    .btnSave {
        background-color: orange;
        border: none !important;
        color: white;
        padding: 7px;
        border-radius: 10px;
        text-decoration: none;
    }

    .btnSave:hover {
        background-color: white;
        color: orange;
    }

    table {
        width: 70%;
        border-collapse: collapse;
    }
    tr,
    td {
        padding: 5px;
    }

    .btnBack {
        background: #49fb5eff !important;
        color: white !important;
    }

    .btnBack:hover {
        background: white !important;
        color: #49fb5eff !important;
    }


    select {
        width: 100%;
        padding-block: 5px;
        padding-inline: 10px;
        background-color: white;
        border-radius: 5px;
        border: none;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/historyController.php');
    $user = checkLogin();
    $db1 = mysqli_query($con, $sql1);
    $col1 = mysqli_fetch_assoc($db1);

    if (isset($_POST['btnSave'])) {
        $mattpm = $_POST['mattpm'];
        editHistory($con, $col1['MaPhieu'], $mattpm);
        header("Location: history.php");
    }
    ?>

    <?php include './header.php'; ?>
    <main>
        <div class="static">
            <h3 class="text-center mb-4"><b>Chỉnh sửa trạng thái phiếu mượn</b></h3>
            <form action="history_edit.php?maphieu=<?php echo $col1['MaPhieu']; ?>" method="POST">
                <table>
                    <tr>
                        <td><b>Mã phiếu mượn:</b></td>
                        <td><?php echo $col1['MaPhieu']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Người tạo:</b></td>
                        <td><?php echo $col1['Ho'] . " " . $col1['Ten'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Mục đích:</b></td>
                        <td><?php echo $col1['MucDich'] ?></td>
                    </tr>
                    <tr>
                        <td><b>Trạng thái:</b></td>
                        <td>
                            <select name="mattpm" id="mattpm" required>
                                <option value="" disabled>-- Chọn vai trò --</option>
                                <option value="TTPM001" <?php echo isset($mattpm) && $mattpm == "TTPM001" ? "selected" : ""; ?>>Chưa duyệt</option>
                                <option value="TTPM002" <?php echo isset($mattpm) && $mattpm == "TTPM002" ? "selected" : ""; ?>>Đã duyệt</option>
                                <option value="TTPM003" <?php echo isset($mattpm) && $mattpm == "TTPM003" ? "selected" : ""; ?>>Không chấp nhận</option>
                            </select>
                        </td>
                    </tr>

                </table>
                <div class="text-center mt-4">
                    <a href="javascript:window.history.back();" class="btnBack btn ms-2 me-2">Quay lại</a>
                    <button type="submit" name="btnSave" class="btnSave">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </main>
    <?php include './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>