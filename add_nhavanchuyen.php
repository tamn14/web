<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $ma_nvc = $_POST['ma_km'];
    $ten_nvc = $_POST['ma_sp'];
    $khuvuc = $_POST['khu_vuc'];
    $phi = $_POST['phi'];

    $check = 1;

    // Kiểm tra mã nhà vận chuyển
    if (empty($ma_nvc)) {
        $_SESSION['error_ma_km'] = "Bạn chưa nhập mã nhà vận chuyển!";
        $check = 0;
    }

    // Kiểm tra tên nhà vận chuyển
    if (empty($ten_nvc)) {
        $_SESSION['error_ma_sp'] = "Bạn chưa nhập tên nhà vận chuyển!";
        $check = 0;
    }

    // Kiểm tra khu vực
    if (empty($khuvuc)) {
        $_SESSION['error_khu_vuc'] = "Bạn chưa nhập khu vực!";
        $check = 0;
    }

    // Kiểm tra phí vận chuyển
    if (empty($phi)) {
        $_SESSION['error_phi'] = "Bạn chưa nhập phí vận chuyển!";
        $check = 0;
    }

    // Nếu có lỗi, quay lại trang form
    if ($check == 0) {
        header("Location: nhavanchuyen-ad.php");
        exit();
    }
    $sql1 = " select * from nhavanchuyen where NVC_MA = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $ma_nvc);
    
    if ($stmt1->execute()) {
        $_SESSION['success'] = " NVC da co ";
        header("Location: nhavanchuyen-ad.php");
        exit();
    } 
    

    // Thực hiện thêm nhà vận chuyển vào cơ sở dữ liệu
    $sql = "INSERT INTO nhavanchuyen (NVC_MA, NVC_TEN, NVC_KHUVUC, NVC_PHI) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $ma_nvc, $ten_nvc, $khuvuc, $phi);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thêm nhà vận chuyển thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi thêm nhà vận chuyển!";
    }

    // Quay lại trang danh sách nhà vận chuyển
    header("Location: nhavanchuyen-ad.php");
    exit();
}

$conn->close();
?>
