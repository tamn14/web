<?php
session_start();
include 'db.php';

if (!$conn) {
    die("Kết nối cơ sở dữ liệu không thành công");
}
    

if (isset($_SESSION['maHD'], $_SESSION['DVC_MA'], $_SESSION['maPTTT'], $_SESSION['ttthanhtoan'], $_SESSION['totalprice'], $_SESSION['user_id'])) {

    // echo $_SESSION['maHD']. "\n" ; 
    // echo $_SESSION['DVC_MA']. "\n" ; 
    // echo $_SESSION['maPTTT']. "\n" ;  
    // echo $_SESSION['ttthanhtoan']. "\n" ;  
    // echo $_SESSION['totalprice']. "\n" ;  
    // echo $_SESSION['user_id']. "\n" ; 
  
    



    $new_ma_hd = $_SESSION['maHD'];
    $new_ma_DVC = $_SESSION['DVC_MA'];
    $PTTT_MA = $_SESSION['maPTTT'];
    $khuyenmai = isset($_SESSION['KM_MA']) ? $_SESSION['KM_MA'] : null;
    $trangthai = $_SESSION['TT_MA'];
    $TONGTIEN = $_SESSION['totalprice'];
    $user_id = $_SESSION['user_id'];
    $DVC_Ma = $_SESSION['DVC_MA'];
    $NVC_MA = $_SESSION['maNVC'];
    $diaChi = $_SESSION['diachi'];

    // Thêm đơn vận chuyển
    $sql_insertDVC = "INSERT INTO DonVanChuyen (DVC_MA, NVC_MA, DVC_DiaChi, DVC_TGBD, DVC_TGHT) VALUES (?, ?, ?, NOW(), NULL)";

    $stmtDVC = $conn->prepare($sql_insertDVC);
    if ($stmtDVC === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    $stmtDVC->bind_param("sss", $DVC_Ma, $NVC_MA, $diaChi);
    if (!$stmtDVC->execute()) {
        die("Lỗi khi thêm đơn vận chuyển: " . $stmtDVC->error);
    }
    $stmtDVC->close();

    // Thêm hóa đơn
    $sql = "INSERT INTO hoadon (HD_MA, DVC_MA, PTTT_MA, KM_MA, TT_MA, KH_MA, HD_NGAYLAP, HD_TONGTIEN)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmtHD = $conn->prepare($sql);
    if ($stmtHD === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    $stmtHD->bind_param("ssssssd", $new_ma_hd, $new_ma_DVC, $PTTT_MA, $khuyenmai, $trangthai, $user_id, $TONGTIEN);

    // Kiểm tra giỏ hàng và cập nhật kho
    if (!empty($_SESSION['giohang'])) {
        foreach ($_SESSION['giohang'] as $key => $item) {
            
            $sql_updateStock = "INSERT INTO khohang(SP_MA, SLthaydoi, ngaythaydoi) VALUES (?, ?, NOW())";
            $stmtSto = $conn->prepare($sql_updateStock);
            if ($stmtSto === false) {
                die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
            }
    
            
            $soLuongThayDoi = -$item['soluong'];
            
            // Sử dụng biến này để bind_param
            $stmtSto->bind_param("si", $item['SP_MA'], $soLuongThayDoi);
            if (!$stmtSto->execute()) {
                die("Lỗi khi cập nhật kho hàng: " . $stmtSto->error);
            }
        }
    }
   
   



    // Thực thi câu lệnh hóa đơn
    if ($stmtHD->execute()) {
        echo "<script>alert('Đơn hàng của bạn đã được đặt thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi thực thi câu lệnh: " . $stmtHD->error . "');</script>";
    }



    if (!empty($_SESSION['giohang'])) {
        foreach ($_SESSION['giohang'] as $key => $item) {
          
            $discountedPrice = $item['GSP_DONGIA'] * (1 - $item['KM_GTRI'] / 100); 
            $totalAfterDiscount = $discountedPrice * $item['soluong']; 
            $_SESSION['totalprice'] =  $totalAfterDiscount + $_SESSION['NVCPhi'] ;  
            
            $sql_CTHD = "INSERT INTO chitiethd(SP_MA, HD_MA, CTHD_SLB , CTHD_DONGIA) VALUES (?, ?, ? ,?)";
            $stmtCTHD = $conn->prepare($sql_CTHD);
            if ($stmtCTHD === false) {
                die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
            }
    
            
            $totalBeforeDiscount = $item['GSP_DONGIA'] * $item['soluong'];
            
            // Sử dụng biến này để bind_param
            $stmtCTHD->bind_param("ssii", $item['SP_MA'],$new_ma_hd, $item['soluong'] , $totalAfterDiscount);
            if (!$stmtCTHD->execute()) {
                die("Lỗi khi cập nhật kho hàng: " . $stmtCTHD->error);
            }
        }
    }

    $_SESSION['success'] = "Thêm sản phẩm thành công!";
    $stmtHD->close();
} else {
    echo "<script>alert('Thông tin không đầy đủ để đặt đơn hàng!');</script>";

}

$conn->close();
?>
