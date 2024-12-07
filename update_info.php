<?php
session_start();
include 'db.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $hoten = $_POST['hoten'];
    $diachi = $_POST['diachi'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];


    $check = 1;
    // Kiểm tra họ tên
    if (empty($hoten)) {
        $_SESSION['error_name'] = "Bạn chưa nhập tên !!!!!!";
        $check = 0;
        header("Location: chinhsuathongtin.php");

    }

    // Kiểm tra địa chỉ
    if (empty($diachi)) {
        $_SESSION['error_address'] = "Bạn chưa nhập địa chỉ !!!!!!";
        $check = 0;
        header("Location: chinhsuathongtin.php");

    }

    // Kiểm tra số điện thoại
    if (empty($sdt)) {
        $_SESSION['error_sdt'] = "Bạn chưa nhập số điện thoại !!!!!!";
        $check = 0;
        header("Location: chinhsuathongtin.php");

    }

    // Kiểm tra email
    if (empty($email)) {
        $_SESSION['error_email'] = "Bạn chưa nhập email !!!!!!";
        $check = 0;
        header("Location: chinhsuathongtin.php");

    } else {
        $emailPattern = "/^\S+@\S+\.\S+$/";
        if (!preg_match($emailPattern, $email)) {
            $_SESSION['error_email'] = "Email không hợp lệ. Vui lòng nhập đúng định dạng (ví dụ: abc@example.com)";
            $check = 0;
            header("Location: chinhsuathongtin.php");

        }
    }
    if($check == 0) {
        header("Location: chinhsuathongtin.php");
        exit();
    }




    // Cập nhật thông tin cá nhân
    $sql = "UPDATE khachhang SET KH_TEN = ?, KH_DIACHI = ?, KH_SDT = ?, KH_EMAIL = ? WHERE KH_TDN = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error);
    }
    $stmt->bind_param("sssss", $hoten, $diachi, $sdt, $email, $username);

    if (!$stmt->execute()) {
        $_SESSION['message'] = "Cập nhật thông tin cá nhân không thành công.";
        header("Location: chinhsuathongtin.php");
        exit;
    }

    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        $sql = "SELECT KH_MK FROM khachhang WHERE KH_TDN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($current_password, $user['KH_MK'])) {
                $passwordPattern = "/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?\":{}|<>])[A-Za-z0-9!@#$%^&*(),.?\":{}|<>]{8,}$/";
                if (!preg_match($passwordPattern, $new_password)) {
                    $_SESSION['message'] = "Mật khẩu mới phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt.";
                    header("Location: chinhsuathongtin.php");
                    exit;
                }

                if ($new_password === $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $sql = "UPDATE khachhang SET KH_MK = ? WHERE KH_TDN = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $hashed_password, $username);
                    $stmt->execute();

                    $_SESSION['message'] = "Cập nhật mật khẩu thành công! Bạn cần đăng nhập lại.";

                    session_unset();
                    session_destroy();

                    header("Location: login.php");
                    exit;
                } else {
                    $_SESSION['message'] = " Mật khẩu mới và xác nhận mật khẩu không khớp.";
                    header("Location: chinhsuathongtin.php");
                    exit;
                }
            } else {
                $_SESSION['message'] = "Mật khẩu hiện tại không đúng.";
                header("Location: chinhsuathongtin.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "Không tìm thấy người dùng.";
            header("Location: chinhsuathongtin.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Thông tin cá nhân đã được cập nhật.";
        header("Location: chinhsuathongtin.php");
        exit;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>