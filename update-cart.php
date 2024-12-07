<?php
session_start();
include 'db.php';

if (isset($_POST['sp_ma']) && isset($_POST['action'])) {
    $sp_ma = $_POST['sp_ma'];
    $action = $_POST['action'];

    // Lấy số lượng tồn kho từ cơ sở dữ liệu
    $sql = "SELECT s.SP_MA, 
                   s.SP_TEN, 
                   COALESCE(SUM(k.SLthaydoi), 0) AS current_quantity,
                   COALESCE(SUM(CASE WHEN k.SLthaydoi > 0 THEN k.SLthaydoi ELSE 0 END), 0) AS total_received,
                   COALESCE(SUM(CASE WHEN k.SLthaydoi < 0 THEN k.SLthaydoi ELSE 0 END), 0) AS total_sold
            FROM sanpham s
            LEFT JOIN khohang k ON s.SP_MA = k.SP_MA
            WHERE s.SP_MA = ?  
            GROUP BY s.SP_MA";
    
    // Prepare statement và bind tham số
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sp_ma);
    $stmt->execute();
    $stmt->bind_result($sp_ma_result, $sp_ten_result, $soluong_kho, $total_received, $total_sold);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra nếu không có sản phẩm nào trong kho
    if (!$sp_ma_result) {
        echo "Sản phẩm không tồn tại trong kho.";
        exit();
    }

    // Duyệt qua giỏ hàng để tìm sản phẩm cần cập nhật
    foreach ($_SESSION['giohang'] as $key => $item) {
        if ($item['SP_MA'] == $sp_ma) {
            if ($action == 'increase' && $item['soluong'] < $soluong_kho) {  // Kiểm tra số lượng tồn kho
                $_SESSION['giohang'][$key]['soluong'] += 1;  // Tăng số lượng trong giỏ hàng
            } elseif ($action == 'decrease' && $_SESSION['giohang'][$key]['soluong'] > 1) {
                $_SESSION['giohang'][$key]['soluong'] -= 1;  // Giảm số lượng trong giỏ hàng
            }
            break;
        }
    }

    
    $_SESSION['total'] = 0;  
    foreach ($_SESSION['giohang'] as $item) {
        $_SESSION['total'] += $item['GSP_DONGIA'] * $item['soluong'];  
    }
}

// Quay lại trang giỏ hàng
header("Location: giohang.php");
exit();
?>
