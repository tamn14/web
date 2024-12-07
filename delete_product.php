<?php
include 'db.php';
session_start();



if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        
        $sql_pn = "DELETE FROM phieunhap WHERE SP_MA = ?";
        $stmt_pn = $conn->prepare($sql_pn);
        $stmt_pn->bind_param("s", $id);
        $stmt_pn->execute();
        $stmt_pn->close();

        $sql_khohang = "DELETE FROM khohang WHERE SP_MA = ?";
        $stmt_khohang = $conn->prepare($sql_khohang);
        $stmt_khohang->bind_param("s", $id);
        $stmt_khohang->execute();
        $stmt_khohang->close();

        $sql_giasp = "DELETE FROM giasp WHERE SP_MA = ?";
        $stmt_giasp = $conn->prepare($sql_giasp);
        $stmt_giasp->bind_param("s", $id);
        $stmt_giasp->execute();
        $stmt_giasp->close();

        $sql_sanpham = "DELETE FROM sanpham WHERE SP_MA = ?";
        $stmt_sanpham = $conn->prepare($sql_sanpham);
        $stmt_sanpham->bind_param("s", $id);
        $stmt_sanpham->execute();
        $stmt_sanpham->close();

        // Cam kết giao dịch
        $conn->commit();

        // Thông báo thành công và chuyển hướng về trang danh sách sản phẩm
        $_SESSION['success'] = "Sản phẩm đã được xóa thành công.";
        header("Location: sanpham-ad.php");
        exit;
    } catch (Exception $e) {
        // Nếu có lỗi, hủy bỏ giao dịch và thông báo lỗi
        $conn->rollback();
        $_SESSION['success'] = "Đã có lỗi xảy ra. Sản phẩm không thể xóa.";
        header("Location: sanpham-ad.php");
        exit;
    }
} else {
    $_SESSION['success'] = "ID sản phẩm không hợp lệ.";
    header("Location: sanpham-ad.php");
    exit;
}

$conn->close();
?>
