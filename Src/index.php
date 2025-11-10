<!doctype html>
<html lang="en">

<head>
    <title>Trang chủ</title>
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

    .background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('Image/background.jpg') center/cover no-repeat;
        filter: blur(5px);
        z-index: -1;
    }

    .data-status {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .room,
    .device,
    .maintenance {
        width: 30%;
        height: fit-content;
        margin-block: 5px;
        padding: 10px;
        font-weight: bold;
        font-size: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .room {
        background-color: #00ffa2ff;
    }

    .device {
        background-color: #00f2ffff;
    }

    .maintenance {
        background-color: #ffd900ff;
    }

    #myChart {
        margin-top: 50px !important;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 90%;
        margin: auto;
        border-radius: 10px;
    }
</style>

<body>
    <div class="background"></div>
    <?php include './header.php'; ?>
    <main>
        <div class="container-fluid bg-light p-5 rounded-5">
            <div class="row data-status">
                <div class="room col-md-3 col-12">
                    <i class="fa-solid fa-house-laptop"></i>
                    <b>Phòng thực hành</b>
                    <div class="room-status">
                        <div class="empty">Phòng trống: <span>0</span></div>
                        <div class="busy">Phòng bận: <span>0</span></div>
                    </div>
                </div>
                <div class="device col-md-3 col-12">
                    <i class="fa-solid fa-print"></i>
                    <b>Thiết bị</b>
                    <div class="device-status">
                        <div class="yes">Chưa mượn: <span>0</span></div>
                        <div class="no">Đã mượn: <span>0</span></div>
                    </div>
                </div>
                <div class="maintenance col-md-3 col-12">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <b>Bảo trì</b>
                    <div class="maintenance-status">
                        <div class="main-room">Phòng: <span>0</span></div>
                        <div class="main-device">Thiết bị: <span>0</span></div>
                    </div>
                </div>
            </div>
            <div class="chart d-md-block d-none">
                <!-- Biều đồ -->
                <canvas id="myChart"></canvas>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth(); // 0 = tháng 1
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const labels = Array.from({
            length: daysInMonth
        }, (_, i) => i + 1);

        const data = Array.from({
            length: daysInMonth
        }, () => Math.floor(Math.random() * 20));

        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: `Thống kê tháng ${month + 1}/${year}`,
                    data: data,
                    backgroundColor: 'rgba(0, 242, 255, 0.7)',
                    borderColor: 'rgba(0,0,0,0.3)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Biểu đồ mượn phòng từ ngày 1 đến ${daysInMonth} tháng ${month + 1}`,
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
                            text: 'Ngày trong tháng'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Giá trị thống kê'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>