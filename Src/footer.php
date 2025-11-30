<!doctype html>
<html lang="en">

<head>
    <title>Footer</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
</head>

<style>
    footer {
        background-color: #001f3e !important;
        color: white;
        padding-block: 40px;
        font-size: 15px;
    }

    .logo-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .logo-footer {
        width: 200px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.25);
        margin-bottom: 10px;
    }

    .logo:hover {
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.7),
            0 0 40px rgba(255, 255, 255, 0.5);
    }

    ul {
        list-style: none;
    }

    li {
        padding: 10px;
    }

    iframe {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    <footer>
        <div class="container-fluid !direction !spacing d-flex justify-content-around align-content-center">
            <div class="row">
                <div class="logo-box col-md-3 my-3">
                    <img src="./Image/Logo.png" class="logo-footer d-md-block d-none" alt="">
                    <span class="text-white fw-bold d-md-block d-none">
                        Lab Management System
                    </span>
                </div>
                <div class="col-md-3">
                    <ul>
                        <li>
                            <b>
                                <i class="fa-solid fa-users"></i>
                                THÀNH VIÊN
                            </b>
                        </li>
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <i>Phạm Tuấn Kiệt - 64131060</i>
                        </li>
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <i>Cao Linh Hà - 64130493</i>
                        </li>
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <i>Nguyễn Hồ Thanh Bình - 64130152</i>
                        </li>
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <i>Nguyễn Hiểu Quyên - 64131973</i>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul>
                        <li>
                            <i class="fa-solid fa-school-flag"></i>
                            <b>THÔNG TIN</b>
                        </li>
                        <li><i>TRƯỜNG ĐẠI HỌC NHA TRANG - NTU</i></li>
                        <li>
                            <i class="fa-solid fa-map-location-dot"></i>
                            <i>Địa chỉ: 02 Nguyễn Đình Chiểu, phường Bắc Nha Trang</i>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone-volume"></i>
                            <i>Điện thoại: 02583831149</i>
                        </li>
                        <li>
                            <i class="fa-solid fa-globe"></i>
                            <i>Website: <a href="http://ntu.edu.vn" class="text-decoration-none text-light">http://ntu.edu.vn</a></i>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 d-md-block d-none">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1073.641962748613!2d109.19945962858982!3d12.267173677710973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31706704a7a0e575%3A0x56736037aa0143e0!2zR2nhuqNuZyDEkcaw4budbmcgRzc!5e1!3m2!1svi!2s!4v1763123757824!5m2!1svi!2s"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>