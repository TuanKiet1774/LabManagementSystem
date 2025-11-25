<?php
        include("../Database/config.php");
        include_once('./Controller/controller.php');
        include_once('./Controller/deviceController.php');
        include_once('./Controller/loginController.php');
        $user = checkLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thông tin thiết bị</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>

<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f7f5ff;
    }

    h2,
    th {
        font-family: "Segoe UI", Arial, sans-serif;
    }

    table {
        width: 55%;
        margin: 10px auto;
        border-collapse: collapse;
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    }

    th {
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

    .img-cell {
        width: 45%;
        text-align: center;
        background: #f0f5ff;
    }

    .img-cell img {
        width: 280px;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
    }

    .info-cell {
        background: #fafaff;
        padding-left: 20px;
    }

    .info-cell i {
        font-style: normal;
        font-weight: bold;
        color: #6a5acd;
        display: inline-block;
        margin-top: 6px;
    }

    span {
        color: #333;
        font-size: 17px;
        margin-left: 5px;
    }

    .back-btn {
        display: inline-block;
        margin: 20px auto;
        padding: 10px 18px;
        text-decoration: none;
        background: #a5b4fc;
        color: white;
        font-size: 16px;
        border-radius: 8px;
        text-align: center;
    }

    .back-btn:hover {
        background: #818cf8;
    }
</style>

<body>
    <?php include("./header.php"); ?>
    <div class="container my-4">
        <?php

        if (isset($_GET['maThietBi'])) {
            $maThietBi = $_GET['maThietBi'];

            $row = deviceDetail($maThietBi);

            echo "<table class='table mx-auto' style='max-width: 700px;'>";

            if ($row) {
                echo "<thead>";
                echo "<tr>";
                echo "<th colspan='2;' style='background: #c7d2fe; color: #3f3d56';>" . $row['TenThietBi'] . "</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo "<tr class='d-block d-md-table-row'>";
                echo "<td class='img-cell d-block d-md-table-cell text-center mb-3 mb-md-0'>";
                echo "<img src='" . $row['Image'] . "' alt='" . $row['TenThietBi'] . "' width='300'>";
                echo "</td>";

                echo "<td class='info-cell d-block d-md-table-cell'>";
                echo "<i>Trạng thái thiết bị: </i>";
                echo "<span>" . $row['TenTTTB'] . "</span>";
                echo "</td>";
                echo "</tr>";
                echo "</tbody>";
            }

            echo "</table>";
        }
        echo "<div style='text-align:center; class='text-center mt-4'>
                <a class='back-btn' href='device.php'>Quay lại</a>
            </div>";
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