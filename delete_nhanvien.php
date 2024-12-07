<?php
include 'db.php';
session_start();

if (isset($_GET['id']) ) {
    $NV_MA = $_GET['id'];
   

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa khuyến mãi liên kết với sản phẩm
        $sql_khohang = "DELETE FROM nhanvien WHERE  NV_MA = ?";
        $stmt_khohang = $conn->prepare($sql_khohang);
        $stmt_khohang->bind_param("s",  $NV_MA );
        $stmt_khohang->execute();
        $stmt_khohang->close();

      
        // Commit giao dịch nếu mọi thứ thành công
        $conn->commit();

        // Thông báo thành công và chuyển hướng
        $_SESSION['success'] = "Nhân Viên đã được xóa thành công.";
        header("Location: nhanvien-ad.php");
        exit;

    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();

        // Thông báo lỗi và chuyển hướng
        $_SESSION['error'] = "Đã có lỗi xảy ra. Khuyến mãi không thể xóa.";
        header("Location: nhanvien-ad.php");
        exit;
    }
} else {
    // Trường hợp không có KM_MA hoặc SP_MA
    $_SESSION['error'] = "Mã khuyến mãi không hợp lệ.";
    header("Location: nhanvien-ad.php");
    exit;
}

$conn->close();
?>
