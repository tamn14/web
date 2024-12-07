<?php
include 'db.php';
session_start();

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
 
    

    try {
        // Xóa dữ liệu từ bảng nhavanchuyen
        $sql_khohang = "DELETE FROM nhavanchuyen WHERE NVC_MA = ?";
        $stmt_khohang = $conn->prepare($sql_khohang);
        $stmt_khohang->bind_param("s", $id);
        $stmt_khohang->execute();
        $stmt_khohang->close();

        // Cam kết giao dịch
        $conn->commit();

        // Thông báo thành công và chuyển hướng về trang danh sách
        $_SESSION['success'] = "NVC đã được xóa thành công.";
        header("Location: nhavanchuyen-ad.php");
        exit;
    } catch (Exception $e) {
        // Nếu có lỗi, hủy bỏ giao dịch và thông báo lỗi
        $conn->rollback();
        $_SESSION['error'] = "Đã có lỗi xảy ra. NVC không thể xóa.";
        header("Location: nhavanchuyen-ad.php");
        exit;
    }
} else {
    $_SESSION['error'] = "ID NVC không hợp lệ.";
    header("Location: nhavanchuyen-ad.php");
    exit;
}

$conn->close();
?>
