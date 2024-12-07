<?php
include 'db.php';
session_start();

if (isset($_GET['KM_MA']) && isset($_GET['SP_MA'])) {
    $KM_MA = $_GET['KM_MA'];
    $SP_MA = $_GET['SP_MA'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa khuyến mãi liên kết với sản phẩm
        $sql_khohang = "DELETE FROM KM_SP WHERE SP_MA = ? AND KM_MA = ?";
        $stmt_khohang = $conn->prepare($sql_khohang);
        $stmt_khohang->bind_param("ss", $SP_MA, $KM_MA);
        $stmt_khohang->execute();
        $stmt_khohang->close();

        // Xóa khuyến mãi
        $sql_giasp = "DELETE FROM Khuyenmai WHERE KM_MA = ?";
        $stmt_giasp = $conn->prepare($sql_giasp);
        $stmt_giasp->bind_param("s", $KM_MA);
        $stmt_giasp->execute();
        $stmt_giasp->close();

        // Commit giao dịch nếu mọi thứ thành công
        $conn->commit();

        // Thông báo thành công và chuyển hướng
        $_SESSION['success'] = "Khuyến mãi đã được xóa thành công.";
        header("Location: khuyenmai-ad.php");
        exit;

    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();

        // Thông báo lỗi và chuyển hướng
        $_SESSION['error'] = "Đã có lỗi xảy ra. Khuyến mãi không thể xóa.";
        header("Location: khuyenmai-ad.php");
        exit;
    }
} else {
    // Trường hợp không có KM_MA hoặc SP_MA
    $_SESSION['error'] = "Mã khuyến mãi không hợp lệ.";
    header("Location: khuyenmai-ad.php");
    exit;
}

$conn->close();
?>
