<?php
session_start();
include 'db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập để đặt hàng.'); window.location.href = 'Login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hoTen = $_POST['inputName'] ?? '';
    $soDienThoai = $_POST['inputPhone'] ?? '';
    $email = $_POST['inputEmail'] ?? '';
    $diaChi = $_POST['inputAddress'] ?? '';
    $city = $_POST['CiTy'] ?? '';
    $phuongThucThanhToan = $_POST['paymentMethod'] ?? '';
    $donViVanChuyen = $_POST['shippingMethod'] ?? '';

    $_SESSION['DVVC'] =  $donViVanChuyen;

    echo $donViVanChuyen ;  


    // $check = 1;
    // // Kiểm tra họ tên
    // if (empty($hoTen)) {
    //     $_SESSION['error_n'] = "Bạn chưa nhập tên !!!!!!";
    //     $check = 0;
    //     header("Location: dathang.php");
        


    // }

    // // Kiểm tra địa chỉ
    // if (empty($diaChi)) {
    //     $_SESSION['error_a'] = "Bạn chưa nhập địa chỉ !!!!!!";
    //     $check = 0;
    //     header("Location: dathang.php");

    // }

    // // Kiểm tra số điện thoại
    // if (empty($soDienThoai)) {
    //     $_SESSION['error_s'] = "Bạn chưa nhập số điện thoại !!!!!!";
    //     $check = 0;
    //     header("Location: dathang.php");

    // }

    // // Kiểm tra email
    // if (empty($email)) {
    //     $_SESSION['error_e'] = "Bạn chưa nhập email !!!!!!";
    //     $check = 0;
    //     header("Location: dathang.php");

    // } else {
    //     $emailPattern = "/^\S+@\S+\.\S+$/";
    //     if (!preg_match($emailPattern, $email)) {
    //         $_SESSION['error_e'] = "Email không hợp lệ. Vui lòng nhập đúng định dạng (ví dụ: abc@example.com)";
    //         $check = 0;
    //         header("Location: dathang.php");

    //     }
    // }

    // if ($check == 0) {
    //     header("Location: dathang.php");
    //     exit();
    // }


    





    // Lưu vào session
    $_SESSION['name'] = $hoTen;
    $_SESSION['sdt'] = $soDienThoai;
    $_SESSION['diachi'] = $diaChi;
    $_SESSION['email'] = $email;
    $_SESSION['donvvc'] = $donViVanChuyen;
    $_SESSION['pttt'] = $phuongThucThanhToan;
    $_SESSION['CiTy'] = $city;

    // Tạo mã đơn hàng tự động
    $sql_MaHD = "SELECT COUNT(*) AS max_ma_HD FROM HOADON";
    $result = $conn->query($sql_MaHD);
    $row = $result->fetch_assoc();
    $new_ma_hd = 'HD' . str_pad($row['max_ma_HD'] + 1, 3, '0', STR_PAD_LEFT);
    $_SESSION['maHD'] = $new_ma_hd;

    // Tạo mã DVC
    $sql_MaDVC = "SELECT DVC_MA FROM DonVanChuyen ORDER BY DVC_MA DESC LIMIT 1";
    $result = $conn->query($sql_MaDVC);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_number = (int) substr($row['DVC_MA'], 3);
        $new_ma_DVC = 'DVC' . str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $new_ma_DVC = 'DVC001';
    }

    $_SESSION['DVC_MA'] = $new_ma_DVC;

    // Lấy mã nhà vận chuyển
    // $sql_MaNVC = " SELECT NVC_MA FROM NhaVanChuyen WHERE NVC_Ten = ?";
    // $stmt = $conn->prepare($sql_MaNVC);
    // $stmt->bind_param("s", $donViVanChuyen);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $ma_NVC = ($result->num_rows > 0) ? $result->fetch_assoc()['NVC_MA'] : null;
    
    $_SESSION['maNVC'] = $donViVanChuyen;

    // Lấy mã phương thức thanh toán
    $sql_MaPTTT = " SELECT PTTT_MA FROM PTTHANHTOAN WHERE PTTT_TEN = ?";
    $stmt = $conn->prepare($sql_MaPTTT);
    $stmt->bind_param("s", $phuongThucThanhToan);
    $stmt->execute();
    $result = $stmt->get_result();
    $PTTT_MA = ($result->num_rows > 0) ? $result->fetch_assoc()['PTTT_MA'] : null;
    $_SESSION['maPTTT'] = $PTTT_MA;



    // Tính tiền khuyến mãi
    $khuyenmai = 0;
    $km_ma = null;

    // Truy vấn lấy khuyến mãi
    $sql_km = "SELECT KM_GTRi, KM_MA FROM khuyenmai WHERE NOW() BETWEEN KM_TGBD AND KM_TGKT LIMIT 1";
    $result_km = $conn->query($sql_km);

    if ($result_km && $result_km->num_rows > 0) {
        $row_km = $result_km->fetch_assoc();
        // Gán giá trị khuyến mãi nếu có kết quả
        $khuyenmai = isset($row_km['KM_GTRi']) ? $row_km['KM_GTRi'] : 0;
        $km_ma = isset($row_km['KM_MA']) ? $row_km['KM_MA'] : null;
    }

    // Lưu khuyến mãi vào session
    $_SESSION['khuyenmai'] = $khuyenmai;
    $_SESSION['KM_MA'] = $km_ma;


    // Tính phí vận chuyển
    $sql_nvcPhi = " SELECT NVC_Phi FROM NhaVanChuyen WHERE NVC_MA = ? AND NVC_KHUVUC = ?";
    $stmt = $conn->prepare($sql_nvcPhi);
    $stmt->bind_param("ss", $donViVanChuyen, $city);
    $stmt->execute();
    $result = $stmt->get_result();
    $NVC_phi = ($result->num_rows > 0) ? $result->fetch_assoc()['NVC_Phi'] : 0;
    $_SESSION['NVCPhi'] = $NVC_phi;

    // Tính tổng tiền đơn hàng
    if (!isset($_SESSION['total'])) {
        $_SESSION['total'] = 0;
    }

   
    $TONGTIEN = $_SESSION['total'] ; 

    $_SESSION['Tong'] = $TONGTIEN;

   
    if ($phuongThucThanhToan === 'Thanh toán khi nhận hàng') {
        $trangThai = "Đang giao hàng";
        // lay ma thanh toan 
        $sql_MaTT = " SELECT TT_MA FROM TrangThai WHERE TT_TEN = ?";
        $stmt = $conn->prepare($sql_MaTT);
        $stmt->bind_param("s", $trangThai);
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $TT_MA = ($result->num_rows > 0) ? $result->fetch_assoc()['TT_MA'] : null;
        } else {
            die("Lỗi truy vấn: " . $conn->error);
        }
        $_SESSION['TT_MA'] = $TT_MA;
        $_SESSION['ttthanhtoan'] = $trangThai;
        header('Location: submit.php');
        exit();
    } 


}

$conn->close();
?>