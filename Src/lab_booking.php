<?php
include("../Database/config.php");
include_once('./Controller/controller.php');
include_once('./Controller/labBookingController.php');
include_once('./Controller/loginController.php');
$user = checkLogin();
$vaiTro = $user['MaVT'] ?? '';
if ($vaiTro !== 'QTV' && $vaiTro !== 'GV' && $vaiTro !== 'SV') {
    header("Location: lab.php?error=permission");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="icon" href="./Image/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css" />
    <title>Tạo phiếu mượn</title>
</head>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f7f5ff;
    }

    h2 {
        text-align: center;
        color: #6a5acd;
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 32px;
        font-weight: 700;
        margin: 30px 0;
        letter-spacing: 1px;
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

    td {
        padding: 14px;
        border: 1px solid #eee;
        font-size: 16px;
    }

    th {
        background: #feffddff;
        padding: 14px;
        font-size: 18px;
        color: #3f3d56;
    }

    input[type="text"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
        background: #f0f5ff;
        font-size: 15px;
        transition: 0.25s;
    }

    input:focus,
    select:focus {
        background: #e6f0ff;
        border-color: #93c5fd;
        outline: none;
    }

    .btn-add {
        display: inline-block;
        padding: 8px;
        font-size: 16px;
        background-color: #60a5fa;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-add:hover {
        background: #048ff9ff;
    }

    .back-btn {
        display: block;
        width: 140px;
        margin: 20px auto;
        padding: 12px;
        background: #a5b4fc;
        color: white;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
    }

    .back-btn:hover {
        background: #818cf8;
    }
</style>

<body>
    <?php
    $maPhong = $_GET['maPhong'];
    $sqlPhong = mysqli_query($con, "SELECT TenPhong FROM phong WHERE MaPhong = '$maPhong'");
    $tenPhong = mysqli_fetch_assoc($sqlPhong)['TenPhong'];

    $listTiet = mysqli_query($con, "SELECT * FROM tiethoc");
    $listNgay = mysqli_query($con, "SELECT * FROM ngaytuan");
    $listTTT = mysqli_query($con, "SELECT * FROM trangthaituan");

    if (isset($_POST['submit'])) {
        $data = [
            'maPhong'   => $_POST['maPhong'],
            'maND'      => $user['MaND'],   
            'mucDich'   => $_POST['mucDich'],
            'ngayBD'    => $_POST['ngayBD'],
            'ngayKT'    => $_POST['ngayKT'],
            'maNgay'    => $_POST['maNgay'],
            'maTTT'     => $_POST['maTTT'],
            'maTietArr' => isset($_POST['maTiet']) ? $_POST['maTiet'] : []
        ];

        $maPhieu = labBookingForm($con, $data);

        if ($maPhieu) {
            echo "<p style='text-align:center; color:green;'>Tạo phiếu mượn thành công!</p>";
        } else {
            echo "<p style='text-align:center; color:red;'>Lỗi khi tạo phiếu!</p>";
        }
    }
    ?>
    <?php include_once("./header.php"); ?>
    <form method="POST">
        <div class="table-responsive">
            <h2 style="text-align:center;">Tạo phiếu mượn phòng</h2>
            <table>
                <tr>
                    <td>Phòng:</td>
                    <td>
                        <input type="text" class="form-control" value="<?= $tenPhong ?>" readonly>
                        <input type="hidden" name="maPhong" value="<?= $maPhong ?>">
                    </td>
                </tr>


                <tr>
                    <td>Mục đích:</td>
                    <td><input type="text" class="form-control" name="mucDich" required></td>
                </tr>

                <tr>
                    <td>Ngày bắt đầu:</td>
                    <td><input type="date" class="form-control" name="ngayBD" required></td>
                </tr>

                <tr>
                    <td>Ngày kết thúc:</td>
                    <td><input type="date" class="form-control" name="ngayKT" required></td>
                </tr>

                <tr id="rowNgay">
                    <td>Ngày trong tuần:</td>
                    <td>
                        <select class="form-control" name="maNgay" required>
                            <option value="">-- Chọn ngày --</option>
                            <?php while ($n = mysqli_fetch_assoc($listNgay)) { ?>
                                <option value="<?= $n['MaNgay'] ?>"><?= $n['TenNgay'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr id="rowTuan">
                    <td>Trạng thái tuần:</td>
                    <td>
                        <select class="form-control" name="maTTT">
                            <option value="">-- Chọn trạng thái --</option>
                            <?php while ($ttt = mysqli_fetch_assoc($listTTT)) { ?>
                                <option value="<?= $ttt['MaTTT'] ?>">
                                    <?= $ttt['TenTTT'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Tiết học:</td>
                    <td>
                        <?php while ($t = mysqli_fetch_assoc($listTiet)) { ?>
                            <label style="display:block;">
                                <input type="checkbox" name="maTiet[]" value="<?= $t['MaTiet'] ?>">
                                <?= $t['TenTiet'] ?> (<?= $t['GioBG'] ?> - <?= $t['GioKT'] ?>)
                            </label>
                        <?php } ?>
                    </td>
                </tr>


                <tr>
                    <td colspan="2" align="center" style="background:#feffddff;">
                        <input type="submit" name="submit" value="Tạo phiếu" class='btn-add w-md-auto'>
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <a class="back-btn" href="lab.php">Quay lại</a>

    <?php include("./footer.php"); ?>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script>
        function updateForm() {
            const ngayBD = document.querySelector("input[name='ngayBD']").value;
            const ngayKT = document.querySelector("input[name='ngayKT']").value;

            const rowNgay = document.getElementById("rowNgay");
            const rowTuan = document.getElementById("rowTuan");
            const maNgay = document.querySelector("select[name='maNgay']");
            const maTTT = document.querySelector("select[name='maTTT']");

            if (!ngayBD || !ngayKT) return;

            const d1 = new Date(ngayBD);
            const d2 = new Date(ngayKT);

            if (d1.getTime() === d2.getTime()) {
                // Mượn 1 ngày → ẩn ngày tuần + trạng thái tuần
                rowNgay.style.display = "none";
                rowTuan.style.display = "none";
                maNgay.required = false;
                maTTT.required = false;
            } else {
                // Mượn nhiều ngày → hiện
                rowNgay.style.display = "";
                rowTuan.style.display = "";
                maNgay.required = true;
                maTTT.required = true;
            }
        }

        // Kiểm tra người dùng chọn thứ hợp lệ
        function validateForm(event) {
            const ngayBD = document.querySelector("input[name='ngayBD']").value;
            const ngayKT = document.querySelector("input[name='ngayKT']").value;
            const maNgay = document.querySelector("select[name='maNgay']").value;

            if (!maNgay) return; // không kiểm tra nếu không cần thứ

            const start = new Date(ngayBD);
            const end = new Date(ngayKT);

            let found = false;

            // Lặp từ ngàyBD đến ngàyKT
            for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                const jsThu = d.getDay(); // 0=CN → 1=Thứ 2
                const maNgayInt = parseInt(maNgay); // DB của bạn: 1=Thứ2, 7=CN

                if (jsThu === (maNgayInt % 7)) {
                    found = true;
                    break;
                }
            }

            if (!found) {
                alert("Khoảng ngày không chứa ngày bạn đã chọn trong tuần!");
                event.preventDefault();
            }
        }

        // Gọi update khi đổi ngày
        document.querySelector("input[name='ngayBD']").addEventListener("change", updateForm);
        document.querySelector("input[name='ngayKT']").addEventListener("change", updateForm);

        // Bắt submit form
        document.querySelector("form").addEventListener("submit", validateForm);

        // Khởi tạo ban đầu
        updateForm();
    </script>

</body>

</html>