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
    .news-card {
        transition: all 0.35s ease;
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
    }

    .news-card img {
        transition: transform 0.4s ease;
    }


    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 12px 28px rgba(0, 0, 0, 0.20) !important;
    }

    .news-card:hover img {
        transform: scale(1.08);
    }


    .news-card:hover h6 {
        color: #005baa !important;
    }

    .feature-card {
        transition: all 0.35s ease;
        cursor: pointer;
        background: white;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0px 12px 28px rgba(0, 0, 0, 0.18) !important;
    }

    .feature-card img {
        transition: transform 0.35s ease;
    }

    .feature-card:hover img {
        transform: scale(1.12);
    }

    .feature-card:hover h5 {
        color: #005baa;/
    }
</style>

<body>
    <?php
    include_once('../Database/config.php');
    include './Controller/loginController.php';
    $user = checkLogin();
    ?>
    <?php include './header.php'; ?>
    <main>
        <!-- Carousel Banner -->
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="./Image/cntt.jpg" class="d-block w-100" style="height:450px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Khoa Công Nghệ Thông Tin – Đại học Nha Trang</h3>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="./Image/phongmay.jpg" class="d-block w-100" style="height:450px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Phòng máy – Thiết bị – Thực hành</h3>
                        <p>Quản lý tập trung – Trực quan – Dễ sử dụng</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="./Image/sinhvien.jpg" class="d-block w-100" style="height: 450px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Giảng viên & Sinh viên CNTT</h3>
                        <p>Ứng dụng công nghệ trong đào tạo và thực hành</p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>



        <!-- CHỨC NĂNG CHÍNH -->
        <section class="container py-5">
            <h2 class="fw-bold text-center mb-4">Chức năng hệ thống</h2>
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="p-4 text-center shadow rounded feature-card">
                        <img src="./Image/icon_room.png" width="60" class="mb-3">
                        <h5 class="fw-bold">Phòng máy</h5>
                        <p>Theo dõi tình trạng, số lượng máy, lịch sử hoạt động…</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 text-center shadow rounded feature-card">
                        <img src="./Image/icon_device.png" width="60" class="mb-3">
                        <h5 class="fw-bold">Thiết bị</h5>
                        <p>Kiểm kê thiết bị, cấu hình chi tiết, trạng thái và bảo trì.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 text-center shadow rounded feature-card">
                        <img src="./Image/icon_calendar.jpg" width="60" class="mb-3">
                        <h5 class="fw-bold">Lịch trình</h5>
                        <p>Xem lịch thực hành của phòng máy theo ngày/tuần/tháng.</p>
                    </div>
                </div>

            </div>
        </section>


        <!-- GIỚI THIỆU KHOA CNTT -->
        <section class="py-5" style="background: #eef5ff;">
            <div class="container">
                <h2 class="fw-bold text-center mb-4 text-primary">Giới thiệu Khoa Công Nghệ Thông Tin</h2>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="ratio ratio-16x9 shadow-lg rounded overflow-hidden">
                            <iframe
                                src="https://www.youtube.com/embed/Bghe7YpChXI"
                                title="Giới thiệu Khoa CNTT Đại học Nha Trang"
                                allowfullscreen
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- TIN TỨC -->
        <section class="container py-5">
            <h2 class="fw-bold text-center mb-4">Tin nổi bật</h2>
            <div class="row g-4">

                <!-- Bài 1 -->
                <div class="col-md-4">
                    <a href="https://khoacntt.ntu.edu.vn/tin-tuc/k-niem-20-nam-thanh-lap-khoa-cong-nghe-thong-tin" class="text-decoration-none text-dark">
                        <div class="shadow rounded overflow-hidden news-card">
                            <img src="./Image/news20nam.jpg" class="w-100" style="height:180px; object-fit:cover;">
                            <div class="p-3">
                                <h6 class="fw-bold">Kỷ niệm 20 năm thành lập Khoa Công nghệ Thông tin</h6>
                                <p class="small text-muted">Khoa Công nghệ Thông tin – Đại học Nha Trang điểm lại quá trình phát triển từ 2003 đến 2023.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Bài 2 -->
                <div class="col-md-4">
                    <a href="https://ntu.edu.vn/tin-tuc/phong-trao-nghien-cuu-khoa-hoc-sinh-vien-khoa-cong-nghe-thong-tin-%E2%80%93-truong-dai-hoc-nha-trang--buoc-chuyen-minh-va-trien-vong-tuong-lai" class="text-decoration-none text-dark">
                        <div class="shadow rounded overflow-hidden news-card">
                            <img src="./Image/news_nckh.jpg" class="w-100" style="height:180px; object-fit:cover;">
                            <div class="p-3">
                                <h6 class="fw-bold">Phong trào nghiên cứu khoa học sinh viên Khoa Công nghệ Thông tin</h6>
                                <p class="small text-muted">Sinh viên CNTT NTU ngày càng tích cực trong nghiên cứu, phát triển ý tưởng và đề tài khoa học.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Bài 3 -->
                <div class="col-md-4">
                    <a href="https://ntu.edu.vn/tin-tuc/sinh-vien-truong-dh-nha-trang-dat-thanh-tich-cao-tai-ky-thi-olympic-toan-hoc-sinh-vien-va-hoc-sinh-toan-quoc-lan-thu-30" class="text-decoration-none text-dark">
                        <div class="shadow rounded overflow-hidden news-card">
                            <img src="./Image/news_olympic.jpg" class="w-100" style="height:180px; object-fit:cover;">
                            <div class="p-3">
                                <h6 class="fw-bold">Sinh viên NTU đoạt giải Olympic Toán quốc gia</h6>
                                <p class="small text-muted">Thành tích nổi bật của sinh viên Khoa CNTT tại kỳ thi Olympic Toán học toàn quốc.</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </section>
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