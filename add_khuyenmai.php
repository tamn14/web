<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_km = $_POST['ma_km'];
    $ma_sp = $_POST['ma_sp'];
    $tgbd = $_POST['tgbd'];
    $tgkt = $_POST['tgkt'];
    $gtkm = $_POST['gtkm'];

    $check = 1;

    if (empty($ma_km)) {
        $_SESSION['error_ma_km'] = "Bạn chưa nhập mã khuyến mãi !!!";
        $check = 0;
    }

    if (empty($ma_sp)) {
        $_SESSION['error_ma_sp'] = "Bạn chưa nhập mã sản phẩm !!!";
        $check = 0;
    } else {
        $sql_SP = "SELECT * FROM sanpham WHERE SP_MA = ?";
        $stmtSP = $conn->prepare($sql_SP);
        if ($stmtSP) {
            $stmtSP->bind_param("s", $ma_sp);
            $stmtSP->execute();
            $resultSP = $stmtSP->get_result();
            if ($resultSP->num_rows === 0) {
                $_SESSION['error_ma_sp'] = "Sản phẩm không tồn tại !!!";
                $check = 0;
            }
            $stmtSP->close();
        } else {
            $_SESSION['error_ma_sp'] = "Có lỗi xảy ra khi kiểm tra sản phẩm!";
            $check = 0;
        }
    }

    if (empty($tgbd)) {
        $_SESSION['error_tgbd'] = "Bạn chưa nhập thời gian bắt đầu !!!";
        $check = 0;
    }

    if (empty($tgkt)) {
        $_SESSION['error_tgkt'] = "Bạn chưa nhập thời gian kết thúc !!!";
        $check = 0;
    } elseif (strtotime($tgkt) < strtotime($tgbd)) {
        $_SESSION['error_tgkt'] = "Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu !!!";
        $check = 0;
    }

    if (empty($gtkm)) {
        $_SESSION['error_gtkm'] = "Bạn chưa nhập giá trị khuyến mãi !!!";
        $check = 0;
    } elseif ($gtkm < 0 || $gtkm > 100) {
        $_SESSION['error_gtkm'] = "Giá trị khuyến mãi phải trong khoảng 0-100 !!!";
        $check = 0;
    }

    if ($check == 0) {
        header("Location: khuyenmai-ad.php");
        exit();
    }
    $sql1 = " select * from khuyenmai where KM_MA = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $ma_km);
    
    if ($stmt1->execute()) {
        $_SESSION['success'] = " Khuyen mai da co ";
        header("Location: khuyenmai-ad.php");
        exit();
    } 

    $sql = "INSERT INTO khuyenmai (KM_MA, KM_TGBD, KM_TGKT, KM_GTRI) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $ma_km, $tgbd, $tgkt, $gtkm);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thêm khuyến mãi thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi thêm khuyến mãi!";
    }

    $sql = "INSERT INTO KM_SP (KM_MA, SP_MA) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ma_km, $ma_sp);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thêm  khuyến mãi thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi thêm sản phẩm khuyến mãi!";
    }

    $conn->close();
    header("Location: khuyenmai-ad.php");
    exit();
}
?>
