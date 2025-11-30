<!doctype html>
<html lang="en">

<head>
    <title>Thống kê</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<style>
    body {
        font-size: 15px !important;
    }

    table {
        border-collapse: collapse !important;
        width: 80%;
        margin: auto;
    }

    table,
    th,
    td {
        border: 1px solid black !important;
    }

    th,
    td {
        padding: 6px 10px;
    }

    .btnExport:hover,
    .btnBack:hover {
        color: blue;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/statisticController.php');
    $db = mysqli_query($con, $sql);
    ?>
    <main>
        <div id="exportArea" class="container-fluid">
            <center>
                <h3><b>Số lần mượn phòng từ <?php echo date("d/m/Y", strtotime($startDate)) . " đến " . date("d/m/Y", strtotime($endDate)) ?></b></h3>
            </center>
            <table>
                <tr align="center">
                    <th>Phòng thực hành</th>
                    <th>Số lần mượn</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($db)) {
                    echo "<tr align='center'>";
                    echo "<td>" . $row['TenPhong'] . "</td>";
                    echo "<td>" . $row['SoLuongPhieuMuon'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div class="button-box">
            <a href="javascript:window.history.back();" class="btnBack btn ms-2 me-2">
                Quay lại
                <i class="fa-solid fa-arrow-rotate-left"></i>
            </a>
            <button id="btnPDF" class="btnExport btn ms-2 me-2">
                Xuất dữ liệu <i class="fa-solid fa-file-arrow-down"></i>
            </button>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById("btnPDF").addEventListener("click", function() {
            var element = document.getElementById("exportArea");
            html2pdf().from(element).save("report.pdf");
        });
    </script>

</body>

</html>