<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Kiểm tra trong bảng Khachhang
    $sql = "SELECT * FROM Khachhang WHERE KH_TDN = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error);
    }

    $stmt->bind_param("s", $user); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu tìm thấy trong bảng Khachhang
        $row = $result->fetch_assoc();

        if (password_verify($pass, $row["KH_MK"])) {
            // Lưu thông tin khách hàng vào session
            $_SESSION['username'] = $user; 
            $_SESSION['name'] = $row['KH_TEN']; 
            $_SESSION['user_id'] = $row["KH_MA"]; 
            $_SESSION['avatar'] = $row["KH_Avatar"]; 
            $_SESSION['role'] = 'customer'; // Thêm role cho khách hàng
            header("Location: sanpham.php"); 
            exit();
        } else {
            // Mật khẩu sai
            $_SESSION['error_message'] = "Mật khẩu không đúng. Vui lòng kiểm tra lại.";
            header("Location: Login.php"); 
            exit();
        }
    } else {
        // Kiểm tra trong bảng Nhanvien
        $sql_nv = "SELECT * FROM Nhanvien 
                   INNER JOIN Chucvu ON Nhanvien.CV_MA = Chucvu.CV_MA
                   WHERE NV_TDN = ?";
        $stmt_nv = $conn->prepare($sql_nv);
        if ($stmt_nv === false) {
            die('Error preparing query: ' . $conn->error);
        }

        $stmt_nv->bind_param("s", $user); 
        $stmt_nv->execute();
        $result_nv = $stmt_nv->get_result();

        if ($result_nv->num_rows > 0) {
            $row_nv = $result_nv->fetch_assoc();

            if (password_verify($pass, $row_nv["NV_MK"])) {
                // Xác định vai trò của nhân viên
                $_SESSION['username'] = $user; 
                $_SESSION['user_id'] = $row_nv["NV_MA"]; 
                $_SESSION['avatar'] = $row_nv["NV_Avatar"]; 
                $_SESSION['email'] = $row_nv["NV_Email"];
              
                if ($row_nv['CV_ND'] == 'Quản lý') {
                    $_SESSION['role'] = 'admin'; // Role admin cho quản lý
                    header("Location: admin.php"); 
                    exit();
                } else {
                    $_SESSION['role'] = 'staff'; // Role staff cho nhân viên
                    header("Location: sanpham.php"); 
                    exit();
                }
            } else {
                // Mật khẩu sai
                $_SESSION['error_message'] = "Mật khẩu không đúng. Vui lòng kiểm tra lại.";
                header("Location: Login.php"); 
                exit();
            }
        } else {
            // Nếu không tìm thấy tên đăng nhập trong cả 2 bảng
            $_SESSION['error_message'] = "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại.";
            header("Location: Login.php"); 
            exit();
        }

        $stmt_nv->close();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Đã có lỗi xảy ra.";
}
?>
