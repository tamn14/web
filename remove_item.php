<?php
session_start();

// Kiểm tra nếu mã sản phẩm đã được gửi qua POST
if (isset($_POST['sp_ma'])) {
    $sp_ma = $_POST['sp_ma'];

    // Kiểm tra nếu giỏ hàng tồn tại và không rỗng
    if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
        // Duyệt qua các sản phẩm trong giỏ hàng
        foreach ($_SESSION['giohang'] as $key => $item) {
            // Nếu tìm thấy sản phẩm có mã tương ứng, xóa nó khỏi giỏ hàng
            if ($item['SP_MA'] == $sp_ma) {
                unset($_SESSION['giohang'][$key]);
                break;
            }
        }
    }
}

// Chuyển hướng về trang giỏ hàng sau khi xóa
header('Location: giohang.php');
exit();
?>
