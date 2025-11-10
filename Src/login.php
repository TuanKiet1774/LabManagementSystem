<!doctype html>
<html lang="en">

<head>
    <title>Đăng nhập</title>
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
        height: 100%;
        background: url('Image/background.jpg') center/cover no-repeat;
        filter: blur(5px);
        z-index: -1;
    }

    .login {
        width: 100%;
        max-width: fit-content;
        margin: 40px;
        padding: 20px 30px;
        background-color: #eeebebff;
        border-radius: 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        font-size: 15px;
    }

    .login-left {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .ntu-img {
        width: 500px;
        margin: 10px;
        border-radius: 15px;
    }

    form {
        align-items: center;
    }

    .welcome {
        color: #003569ff;
    }

    input[type='text'],
    input[type='password'] {
        padding: 5px;
        border: none;
        border-radius: 5px;
        width: 300px;
    }

    .btnDN {
        background-color: blue;
        color: white;
        border-radius: 10px;
        padding: 5px;
    }

    .btnDN:hover {
        background-color: white;
        color: blue;
    }

    .btnDK {
        background-color: green;
        color: white;
        padding: 7px;
        border-radius: 10px;
        border: 1px solid black;
        text-decoration: none;
    }

    .btnDK:hover {
        background-color: white;
        color: green;
    }

    tr,
    td {
        padding: 5px;
    }

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
</style>

<body>
    <div class="background"></div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark w-100">
            <div class="container-fluid">
                <a class="navbar-brand fs-6 mt-1" href="#">
                    <img src="./Image/Logo.png" class="logo-header" alt="Logo LAB MANAGEMENT">
                    HỆ THỐNG QUẢN LÝ PHÒNG THỰC HÀNH
                </a>
            </div>
        </nav>
    </header>
    <main>
        <div class="login container-fluid">
            <div class="login-right d-none d-md-block">
                <img src="./Image/ntu.jpg" class="ntu-img" alt="ntu" title="Trường đại học Nha Trang">
            </div>
            <div class="login-left mx-md-5 mx-0">
                <form action="" method="post">
                    <h3 class="welcome text-center mb-3"><b>WELCOME TO<br><i>LAB MANAGEMENT SYSTEM</i> </b></h3>
                    <table>
                        <tr>
                            <td>
                                <i class="fa-solid fa-user-tie"></i>
                                Tài khoản:
                            </td>
                            <td>
                                <input type="text" name="user" value="<?php echo isset($_POST['user']) ? $_POST['user'] : "" ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-unlock-keyhole"></i>
                                Mật khẩu:
                            </td>
                            <td>
                                <input type="password" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : "" ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="m-4" colspan="2" align="center">
                                <input type="submit" name="btnDN" class="btnDN me-3" value="Đăng nhập">
                                <a href="#" class="btnDK ms-3">Đăng ký</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
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