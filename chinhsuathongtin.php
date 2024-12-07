<?php
session_start();
include 'db.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin người dùng từ CSDL
$username = $_SESSION['username'];
$sql = "SELECT * FROM khachhang WHERE KH_TDN = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chỉnh sửa thông tin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 col-8">
        <h2>Chỉnh sửa thông tin cá nhân</h2>
        <form id="editForm" action="update_info.php" method="POST">
            <div class="mb-3">
                <div id="error_name" class="text-danger fst-italic">
                    <?php
                    if (isset($_SESSION['error_name'])) {
                        echo $_SESSION['error_name'];
                        unset($_SESSION['error_name']);
                    }
                    ?>
                </div>
                <label for="hoten" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="hoten" value="<?php echo $user['KH_TEN']; ?>">
            </div>
            <div class="mb-3">
                <div id="error_address" class="text-danger fst-italic">
                    <?php
                    if (isset($_SESSION['error_address'])) {
                        echo $_SESSION['error_address'];
                        unset($_SESSION['error_address']);
                    }
                    ?>
                </div>
                <label for="diachi" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="diachi" name="diachi"
                    value="<?php echo $user['KH_DIACHI']; ?>">
            </div>
            <div class="mb-3">
                <div id="error_sdt" class="text-danger fst-italic">
                    <?php
                    if (isset($_SESSION['error_sdt'])) {
                        echo $_SESSION['error_sdt'];
                        unset($_SESSION['error_sdt']);
                    }
                    ?>
                </div>
                <label for="sdt" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="sdt" name="sdt" value="<?php echo $user['KH_SDT']; ?>">
            </div>
            <div class="mb-3">
                <div id="error_email" class="text-danger fst-italic">
                    <?php
                    if (isset($_SESSION['error_email'])) {
                        echo $_SESSION['error_email'];
                        unset($_SESSION['error_email']);
                    }
                    ?>
                </div>
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email"
                    value="<?php echo $user['KH_EMAIL']; ?>">
            </div>



            <hr>

            <h4>Thay đổi mật khẩu</h4>
            <div class="m-3 text-danger">
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <div class="mb-3">
                <div id="error_password" class="text-danger fst-italic"></div>
                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="password" name="current_password">
            </div>
            <div class="mb-3">
                <div id="error_newpassword" class="text-danger fst-italic"></div>
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-3">
                <div id="error_repeatPassword" class="text-danger fst-italic"></div>
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="repeatPassword" name="confirm_password">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="thongtintaikhoan.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <!-- <script>
        document.getElementById("editForm").addEventListener("submit", function (event) {
            let isValid = true;

            // Kiểm tra họ và tên
            const name = document.getElementById("name").value.trim();
            if (name === "") {
                document.getElementById("error_name").textContent = "Vui lòng nhập họ và tên.";
                isValid = false;
            } else {
                document.getElementById("error_name").textContent = "";
            }

            // Kiểm tra địa chỉ
            const address = document.getElementById("diachi").value.trim();
            if (address === "") {
                document.getElementById("error_address").textContent = "Vui lòng nhập địa chỉ.";
                isValid = false;
            } else {
                document.getElementById("error_address").textContent = "";
            }

            // Kiểm tra số điện thoại
            const phone = document.getElementById("sdt").value.trim();
            if (phone === "") {
                document.getElementById("error_sdt").textContent = "Vui lòng nhập số điện thoại.";
                isValid = false;
            } else if (!/^\d{10,11}$/.test(phone)) {
                document.getElementById("error_sdt").textContent = "Số điện thoại không hợp lệ.";
                isValid = false;
            } else {
                document.getElementById("error_sdt").textContent = "";
            }

            // Kiểm tra email
            const email = document.getElementById("email").value.trim();
            if (email === "") {
                document.getElementById("error_email").textContent = "Vui lòng nhập email.";
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                document.getElementById("error_email").textContent = "Email không hợp lệ.";
                isValid = false;
            } else {
                document.getElementById("error_email").textContent = "";
            }

            // Nếu có lỗi, ngăn form gửi đi
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script> -->
</body>

</html>