<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_nv = $_POST['SP_TEN'];
    $diachi = $_POST['SP_DIACHI'];
    $sdt = $_POST['SP_SDT'];
    $email = $_POST['SP_EMAIL'];
    $avartar = $_FILES['SP_HINHANH'];
    $tdn = $_POST['tendangnhap'];
    $MK = $_POST['mk'];
    $check = 1;




   

    // Kiểm tra các trường bắt buộc
    if (empty($ten_nv)) {
        $_SESSION['error_name'] = "Bạn chưa nhập tên nhân viên !!!";
        $check = 0;
    }
    if (empty($diachi)) {
        $_SESSION['error_diachi'] = "Bạn chưa nhập địa chỉ nhân viên !!!";
        $check = 0;
    }

    if (empty($tdn)) {
        $_SESSION['error_tendangnhap'] = "Bạn chưa nhập tên đang nhập !!!";
        $check = 0;
    }
    if (empty($MK)) {
        $_SESSION['error_mk'] = "Bạn chưa nhập mật khẩu !!!";
        $check = 0;
    } elseif (strlen($MK) < 8) {
        $_SESSION['error_mk'] = "Mật khẩu phải có ít nhất 8 ký tự !!!";
        $check = 0;
    } elseif (!preg_match('/[A-Za-z]/', $MK) || !preg_match('/[0-9]/', $MK) || !preg_match('/[\W_]/', $MK)) {
        $_SESSION['error_mk'] = "Mật khẩu phải chứa ít nhất một chữ cái, một số và một ký tự đặc biệt !!!";
        $check = 0;
    } else {
        // Mật khẩu hợp lệ
        $check = 1;
    }



    if (empty($sdt)) {
        $_SESSION['error_sdt'] = "Bạn chưa nhập SDT !!!";
        $check = 0;



        
    } else {
        // Kiểm tra tính hợp lệ của số điện thoại
        if (!preg_match("/^[0-9]{10,11}$/", $sdt)) {
            $_SESSION['error_sdt'] = "Số điện thoại không hợp lệ!";
            $check = 0;
        }
    }
    if (empty($email)) {
        $_SESSION['error_email'] = "Bạn chưa nhập email !!!";
        $check = 0;
    } else {
        // Kiểm tra tính hợp lệ của email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_email'] = "Email không hợp lệ!";
            $check = 0;
        }
    }

    if ($check == 0) {
        header("Location: nhanvien-ad.php");
        exit();
    }

    


    // Xử lý tải lên hình ảnh
    $target_dir = "assets/images/faces/";
    $target_file = $target_dir . basename($avartar["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra loại tệp tin hình ảnh
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_hinh'] = "Chỉ cho phép hình ảnh định dạng JPG, JPEG, PNG, GIF.";
        header("Location: nhanvien-ad.php");
        exit();
    }

    // Di chuyển hình ảnh từ tạm thời đến thư mục
    if (!move_uploaded_file($avartar["tmp_name"], $target_file)) {
        $_SESSION['error_hinh'] = "Lỗi khi tải hình ảnh lên.";
        header("Location: nhanvien-ad.php");
        exit();
    }

    // Lấy mã nhân viên mới
    $sql_MaNV = "SELECT COUNT(*) AS max_ma_NV FROM NhanVien";
    $result = $conn->query($sql_MaNV);
    $row = $result->fetch_assoc();
    $new_ma_nv = 'NV' . str_pad($row['max_ma_NV'] + 1, 3, '0', STR_PAD_LEFT);

    // Thêm nhân viên vào bảng NhanVien
    $sql_NV = "INSERT INTO nhanvien (NV_MA, NV_TDN, NV_MK, NV_TEN, NV_DIACHI, NV_SDT, NV_EMAIL, CV_MA, NV_AVATAR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtNV = $conn->prepare($sql_NV);
    $chucvu = 'CV002'; // Mã chức vụ của nhân viên
    $stmtNV->bind_param("sssssssss", $new_ma_nv, $tdn, $MK, $ten_nv, $diachi, $sdt, $email, $chucvu, $target_file);

    if ($stmtNV === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }

    if (!$stmtNV->execute()) {
        die("Lỗi khi thêm nhân viên: " . $stmtNV->error);
    }

    $_SESSION['success'] = "Thêm nhân viên thành công!";
    header("Location: nhanvien-ad.php");
    exit();
}

$conn->close();
?>
