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
</head>

<style>
    main {
        font-size: 15px !important;
        margin: 40px;
    }

    #myChart {
        margin-top: 30px !important;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 80%;
        height: 50%;
        margin: auto;
        border-radius: 10px;
    }

    form {
        margin: auto;
        display: flex;
        justify-content: center;
        gap: 10px;
        background-color: #c7d2ff;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    .btn-statstic {
        background: #fbbf24 !important;
        border: none !important;
        color: white !important;
    }

    .btn-statstic:hover {
        background: #f59e0b !important;
    }

    .statistic-box {
        width: 100%;
    }

    a {
        display: inline-block;
        padding: 5px;
        margin: 2px;
        text-decoration: none !important;
        color: white !important;
        border-radius: 6px;
        font-size: 14px;
    }

    .btn-print {
        background: #fda4af !important;
        color: white !important;
    }

    .btn-print:hover {
        background: #fb7185 !important;
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include_once('./Controller/loginController.php');
    include_once('./Controller/statisticController.php');
    $user = checkLogin();
    $db = mysqli_query($con, $sql);

    $labels = [];
    $data = [];
    while ($row = mysqli_fetch_assoc($db)) {
        $labels[] = $row['TenPhong'];
        $data[] = intval($row['SoLuongPhieuMuon']);
    }
    ?>

    <?php include './header.php'; ?>

    <main>
        <div class="container-fluid">
            <div class="statistic-box">
                <form method="GET">
                    <div class="d-flex">
                        <div class="date w-100 p-2"><b>Từ ngày: </b></div>
                        <input type="date" id="startDate" name="startDate" class="form-control"
                            value="<?php echo $startDate; ?>">
                    </div>
                    <div class="d-flex">
                        <div class="date w-100 p-2"><b>Đến ngày: </b></div>
                        <input type="date" id="endDate" name="endDate" class="form-control"
                            value="<?php echo $endDate; ?>">
                    </div>
                    <button type="submit" class="btn-statstic btn">Thống kê</button>
                    <?php 
                    echo "<a href='./statictic_print.php?startDate=".$startDate."&endDate=".$endDate."' class='btn-print btn'>In thống kê</a>";
                    ?>
                </form>
            </div>

            <!-- Biểu đồ -->
            <div class="chart d-md-block d-none">
                <canvas id="myChart"></canvas>
            </div>

        </div>
    </main>

    <?php include './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dữ liệu từ PHP
        const labels = <?php echo json_encode($labels); ?>;
        const data = <?php echo json_encode($data); ?>;

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượt mượn phòng',
                    data: data,
                    backgroundColor: 'rgba(0, 242, 255, 0.7)',
                    borderColor: 'rgba(0,0,0,0.3)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Thống kê số lần mượn từng phòng',
                        font: {
                            size: 18,
                            weight: 'bold'
                        },
                        color: '#003569'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tên phòng'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Số lần mượn'
                        }
                    }
                },
                ticks: {
                    // Chỉ hiện số nguyên
                    precision: 0
                }
            }
        });
    </script>

</body>

</html>