<!doctype html>
<html lang="en">

<head>
    <title>Header</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>
<style>
    header {
        font-size: 15px;
    }

    .logo-header {
        width: 50px;
        border-radius: 50%;
    }

    .navbar {
        background-color: #001f3e !important;
    }

    .navbar a {
        color: white !important;
        font-weight: bold;
    }

    .dropdown-menu {
        background-color: #001f3e !important;
        border: 1px solid white;
    }

    .dropdown-menu li a:hover {
        color: #001f3e !important;
        background-color: white !important;
    }

    .user {
        width: 40px;
        border-radius: 50%;
    }
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark w-100">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand fs-6 mt-1" href="./index.php">
                    <img src="./Image/Logo.png" class="logo-header" alt="Logo LAB MANAGEMENT">
                    HỆ THỐNG QUẢN LÝ PHÒNG THỰC HÀNH
                </a>

                <!-- Button for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Main menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Left items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">
                                <i class="fa-solid fa-house"></i>
                                Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-calendar"></i>
                                Lịch phòng
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-book"></i>
                                Quản lý
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-house-laptop"></i>
                                        Phòng máy
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-computer"></i>
                                        Thiết bị
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./history.php">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        Lịch sử
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./statistic.php">
                                <i class="fa-solid fa-square-poll-vertical"></i>
                                Thống kê
                            </a>
                        </li>
                    </ul>

                    <!-- Right items (User) -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php 
                                $path = './Image/'.$_SESSION['Anh']; 
                                echo "<img src = '$path' class='user' alt=''>"; 
                                ?>
                                <span>
                                    <?php
                                    echo isset($_SESSION['HoTen']) ? $_SESSION['HoTen'] : "Người dùng";
                                    ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-window-restore"></i>
                                        Phòng mượn
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-address-card"></i>
                                        Thông tin cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./logout.php">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>
</body>

</html>