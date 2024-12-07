<?php
session_start();
include 'db.php';

// echo $_POST['ma_sp'] . "\n";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $ma_km = $_POST['ma_km'];
    $ma_sp = $_POST['ma_sp'];
   

    $check = 1;

    // Kiểm tra mã khuyến mãi
    if (empty($ma_km)) {
        $_SESSION['error_ma_km'] = "Bạn chưa nhập mã nha phân phối !!!";
        $check = 0;
    }

    


    // Kiểm tra thời gian bắt đầu và kết thúc
    if (empty($ma_sp)) {
        $_SESSION['error_ma_sp'] = "Bạn chưa nhập tên nhà phân phối !!!";
        $check = 0;
    }

    
    // Nếu có lỗi, quay lại trang form
    if ($check == 0) {
        header("Location: nhaphanphoi-ad.php");
        exit();
    }



    $sql1 = " select * from nhaphanphoi where NPP_MA = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $ma_km);
    
    if ($stmt1->execute()) {
        $_SESSION['success'] = " NPP da co ";
        header("Location: nhaphanphoi-ad.php");
        exit();
    } 

    $sql = "INSERT INTO nhaphanphoi (npp_ma , npp_ten) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ma_km, $ma_sp);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thêm nhà phân phối thành công thành công!";
    } else {
        $_SESSION['success'] = "Lỗi khi thêm nhà phân phối!";
    }

    header("Location: nhaphanphoi-ad.php");
    exit();





    

        $_SESSION['success'] = "Thêm thành công";

    } 

    $conn->close();

?>