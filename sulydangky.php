<?php
session_start();
include 'db.php';

// Xóa các thông báo lỗi cũ
unset($_SESSION['error_n'], $_SESSION['error_a'], $_SESSION['error_sdt'], $_SESSION['error_user'], $_SESSION['error_pass'], $_SESSION['error_e']);

// Kiểm tra các giá trị cần thiết
if (!isset($_POST['name'], $_POST['email'], $_POST['diachi'], $_POST['Sodienthoai'], $_POST['username'], $_POST['password'], $_POST['repeatPassword'])) {
    echo "Vui lòng điền đầy đủ thông tin!";
    exit;
}

// Lấy dữ liệu từ form
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['diachi'];
$phone = $_POST['Sodienthoai'];
$username = $_POST['username'];
$password = $_POST['password'];
$repeatPassword = $_POST['repeatPassword'];

// $check = 1;

// // Kiểm tra từng trường
// if (empty($name)) {
//     $_SESSION['error_n'] = "Bạn chưa nhập tên !!!!!!";
//     $check = 0;
// } else {
//     $_SESSION['form_data']['name'] = $name;
// }

// if (empty($address)) {
//     $_SESSION['error_a'] = "Bạn chưa nhập địa chỉ !!!!!!";
//     $check = 0;
// } else {
//     $_SESSION['form_data']['address'] = $address;
// }

// if (empty($phone)) {
//     $_SESSION['error_sdt'] = "Bạn chưa nhập SDT !!!";
//     $check = 0;
// } else {
//     if (!preg_match("/^[0-9]{10,11}$/", $phone)) {
//         $_SESSION['error_sdt'] = "Số điện thoại không hợp lệ!";
//         $check = 0;
//     } else {
//         $_SESSION['form_data']['sdt'] = $phone;
//     }
// }

// if (empty($username)) {
//     $_SESSION['error_user'] = "Bạn chưa nhập tên đăng nhập !!!!!!";
//     $check = 0;
// } else {
//     $_SESSION['form_data']['username'] = $username;
// }

// if (empty($password)) {
//     $_SESSION['error_pass'] = "Bạn chưa nhập mật khẩu !!!!!!";
//     $check = 0;
// } else {
//     $_SESSION['form_data']['password'] = $password;
// }

// if (empty($email)) {
//     $_SESSION['error_e'] = "Bạn chưa nhập email !!!!!!";
//     $check = 0;
// } else {
//     $emailPattern = "/^\S+@\S+\.\S+$/";
//     if (!preg_match($emailPattern, $email)) {
//         $_SESSION['error_e'] = "Email không hợp lệ. Vui lòng nhập đúng định dạng (ví dụ: abc@example.com)";
//         $check = 0;
//     } else {
//         $_SESSION['form_data']['email'] = $email;
//     }
// }
// 
// 
// if ($password !== $repeatPassword) {
//     $_SESSION['error_pass'] = "Mật khẩu và mật khẩu nhập lại không khớp !!!";
//     exit;
// }

// if ($check == 0) {
//     header("Location: DangKy.php");
//     exit();
// }

// Kiểm tra ảnh đại diện
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $avatar = $_FILES['avatar'];

    $uploadDir = 'avatar/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Kiểm tra định dạng và kích thước ảnh
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    if ($avatar['size'] > $maxFileSize) {
        echo "Ảnh đại diện không được lớn hơn 2MB!";
        exit;
    }
    $fileType = mime_content_type($avatar['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo "Chỉ hỗ trợ các loại ảnh JPEG, PNG và GIF!";
        exit;
    }

    $avatarName = $username . '.' . pathinfo($avatar['name'], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . $avatarName;

    if (move_uploaded_file($avatar['tmp_name'], $uploadFile)) {
        echo "Ảnh đại diện đã được tải lên thành công.";
    } else {
        echo "Có lỗi khi tải ảnh lên!";
        exit;
    }
} else {
    $avatarPath = "avatar/user.png" ; 
}

// Kiểm tra nếu tên đăng nhập đã tồn tại
$sql = "SELECT * FROM KhachHang WHERE KH_TDN = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.";
} else {
    // Tạo mã khách hàng mới
    $sql = "SELECT CONCAT('KH', LPAD(COUNT(*) + 1, 3, '0')) AS new_ma_kh FROM KhachHang";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $new_ma_kh = $row['new_ma_kh'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Lưu đường dẫn đầy đủ vào cơ sở dữ liệu
    $avatarPath = $uploadDir . $avatarName; // Lưu đường dẫn đầy đủ

    $sql2 = "INSERT INTO KhachHang (KH_MA, KH_TDN, KH_MK, KH_TEN, KH_DIACHI, KH_SDT, KH_EMAIL, KH_Avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ssssssss", $new_ma_kh, $username, $hashed_password, $name, $address, $phone, $email, $avatarPath);

    if ($stmt2->execute()) {
        header("Location: Login.php");
        exit;
    } else {
        error_log("Lỗi: " . $conn->error);
        echo "Đã có lỗi xảy ra, vui lòng thử lại sau!";
    }

    $stmt->close();
    $stmt2->close();
}

$conn->close();

?>
