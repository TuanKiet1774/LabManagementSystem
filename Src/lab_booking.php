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
        background-color: #60a5fa !important;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-add:hover {
        background: #048ff9ff !important;
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
    $maPhong = isset($_GET['phong']) ? $_GET['phong'] : '';

    $tenPhong = '';
    if ($maPhong) {
        $sqlPhong = mysqli_query($con, "SELECT TenPhong FROM phong WHERE MaPhong = '$maPhong'");
        $rowPhong = mysqli_fetch_assoc($sqlPhong);
        if ($rowPhong) {
            $tenPhong = $rowPhong['TenPhong'];
        } else {
            $tenPhong = 'Không xác định';
            echo "<script>
            alert('Bạn chưa chọn phòng hoặc phòng không tồn tại!');
            window.location.href = 'lab_week_sched.php';
          </script>";
        }
    } else {
        $tenPhong = 'Chưa chọn phòng';
    }

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
            'maNgay'    => isset($_POST['maNgay']) ? $_POST['maNgay'] : [],
            'maTTT'     => $_POST['maTTT'],
            'maTietArr' => isset($_POST['maTiet']) ? $_POST['maTiet'] : []
        ];

        $result = labBookingForm($con, $data);

        if ($result['success']) {
            echo "<script>
        alert('Tạo phiếu mượn thành công!');
        window.location.href = 'history.php';
    </script>";
            exit();
        } else {
            $msg = addslashes($result['message']); 
            echo "<script>
        alert('Lỗi khi tạo phiếu: {$msg}');
    </script>";
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
                    <td id="checkboxContainer">
                    </td>
                </tr>

                <tr id="rowTuan">
                    <td>Trạng thái tuần:</td>
                    <td>
                        <select class="form-control" name="maTTT">
                            <?php while ($ttt = mysqli_fetch_assoc($listTTT)) { ?>
                                <option value="<?= $ttt['MaTTT'] ?>"
                                    <?= ($ttt['MaTTT'] == 'TUANXS') ? 'selected' : '' ?>>
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
        let savedNgayChecks = {}; // Lưu trạng thái checkboxes

        function updateForm() {
            const ngayBD = document.querySelector("input[name='ngayBD']").value;
            const ngayKT = document.querySelector("input[name='ngayKT']").value;
            const rowNgay = document.getElementById("rowNgay");
            const rowTuan = document.getElementById("rowTuan");
            const maTTT = document.querySelector("select[name='maTTT']");
            const checkboxContainer = document.getElementById("checkboxContainer");

            if (!ngayBD || !ngayKT) return;

            const d1 = new Date(ngayBD);
            const d2 = new Date(ngayKT);

            const dayCodes = ["CHUNHAT", "THUHAI", "THUBA", "THUTU", "THUNAM", "THUSAU", "THUBAY"];
            const dayNames = ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];

            rowNgay.style.display = ""; // luôn hiển thị row ngày
            rowTuan.style.display = ""; // hiển thị trạng thái tuần

            if (d1.getTime() === d2.getTime()) {
                // Chỉ 1 ngày -> tạo 1 checkbox, checked mặc định
                const dayOfWeek = d1.getDay(); // 0=CN, 1=Thứ2...
                checkboxContainer.innerHTML = `<label style="display:block;">
            <input type="checkbox" name="maNgay[]" value="${dayCodes[dayOfWeek]}" checked> ${dayNames[dayOfWeek]}
        </label>`;

                // maTTT mặc định TUANXS
                maTTT.value = "TUANXS";
            } else {
                // Nhiều ngày -> tạo checkbox nhiều ngày
                const daysInRange = new Set();
                for (let d = new Date(d1); d <= d2; d.setDate(d.getDate() + 1)) {
                    daysInRange.add(d.getDay());
                }

                checkboxContainer.innerHTML = ""; // xóa cũ
                daysInRange.forEach(day => {
                    const checkbox = document.createElement("label");
                    checkbox.style.display = "block";
                    checkbox.innerHTML = `<input type="checkbox" name="maNgay[]" value="${dayCodes[day]}"> ${dayNames[day]}`;
                    checkboxContainer.appendChild(checkbox);
                });

                // maTTT mặc định "Xuyên suốt"
                maTTT.value = "3"; // ID thực tế trong DB
            }
        }



        function validateForm(event) {
            const ngayBD = document.querySelector("input[name='ngayBD']").value;
            const ngayKT = document.querySelector("input[name='ngayKT']").value;

            if (!ngayBD || !ngayKT) {
                alert("Vui lòng chọn đầy đủ ngày bắt đầu và kết thúc!");
                event.preventDefault();
                return;
            }

            if (new Date(ngayBD) > new Date(ngayKT)) {
                alert("Ngày bắt đầu không được lớn hơn ngày kết thúc!");
                event.preventDefault();
                return;
            }

            // Kiểm tra checkboxes ngày trong tuần nếu hiện
            const checkboxesNgay = document.querySelectorAll("input[name='maNgay[]']");
            if (checkboxesNgay.length > 0) {
                let checked = false;
                checkboxesNgay.forEach(cb => {
                    if (cb.checked) checked = true;
                });
                if (!checked) {
                    alert("Vui lòng chọn ít nhất 1 ngày trong tuần!");
                    event.preventDefault();
                    return;
                }
            }

            // Kiểm tra chọn ít nhất 1 tiết học
            const checkboxesTiet = document.querySelectorAll("input[name='maTiet[]']");
            let checkedTiet = false;
            checkboxesTiet.forEach(cb => {
                if (cb.checked) checkedTiet = true;
            });
            if (!checkedTiet) {
                alert("Vui lòng chọn ít nhất 1 tiết học!");
                event.preventDefault();
                return;
            }
        }

        // Sự kiện
        document.querySelector("input[name='ngayBD']").addEventListener("change", updateForm);
        document.querySelector("input[name='ngayKT']").addEventListener("change", updateForm);
        document.querySelector("form").addEventListener("submit", validateForm);
        updateForm(); // Khởi tạo
    </script>


</body>

</html>