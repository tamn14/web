<?php
session_start(); 
include 'db.php'; 
 

if (isset($_GET['sp_ma']) && isset($_GET['action'])) {
    $sp_ma = $_GET['sp_ma'];
    $action = $_GET['action'];

    // Kiểm tra tính hợp lệ của tham số
    if (empty($sp_ma) || !in_array($action, ['buy_now', 'add_to_cart'])) {
        echo "Tham số không hợp lệ!";
        exit();
    }

    // Lấy thông tin sản phẩm từ database
    $sql = "SELECT * FROM sanpham sp 
            LEFT JOIN KM_SP km ON sp.SP_MA = km.SP_MA 
            LEFT JOIN khuyenmai k ON k.KM_MA = km.KM_MA
            LEFT JOIN giasp g ON g.SP_MA = sp.SP_MA 
            WHERE sp.SP_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sp_ma);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
       
        $ngaybatdau  = $row['KM_TGBD'];  
        $ngaykt  = $row['KM_TGKT']; 

        $current_date = date('Y-m-d H:i:s');
        if ($current_date >= $ngaybatdau && $current_date <= $ngaykt) {
            $khuyenmai = $row['KM_GTRI']; 
        } else {
            $khuyenmai = 0;  
        }
        // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng
        if (!isset($_SESSION['giohang'])) {
            $_SESSION['giohang'] = array();
        }

        $found = false;
        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
        foreach ($_SESSION['giohang'] as $key => $item) {
            if ($item['SP_MA'] == $sp_ma) {
                $_SESSION['giohang'][$key]['soluong'] += 1;
                $found = true;
                break;
            }
        }

        // Nếu chưa có sản phẩm trong giỏ, thêm sản phẩm vào giỏ hàng
        if (!$found) {
            $item = array(
                'SP_MA' => $row['SP_MA'],
                'SP_TEN' => $row['SP_TEN'],
                'GSP_DONGIA' => $row['GSP_DONGIA'],
                'SP_HINHANH' => $row['SP_HINHANH'],
                'KM_GTRI' => $khuyenmai , 
                'soluong' => 1
            );
            $_SESSION['giohang'][] = $item;
        }

        // Lấy khuyến mãi hiện tại
        // $khuyenmai = 0;
        // $sql_km = "SELECT KM_GTRi 
        //            FROM khuyenmai 
        //            WHERE NOW() BETWEEN KM_TGBD AND KM_TGKT 
        //            LIMIT 1";
        // $result_km = $conn->query($sql_km);
        // if ($result_km->num_rows > 0) {
        //     $row_km = $result_km->fetch_assoc();
        //     $khuyenmai = $row_km['KM_GTRi'];
        // }

        // Lấy tên nhà vận chuyển
        // $sql_nv = "SELECT NVC_TEN 
        //            FROM nhavanchuyen 
        //            LIMIT 1";
        // $result_nv = $conn->query($sql_nv);
        // $nvc_ten = '';
        // if ($result_nv->num_rows > 0) {
        //     $row_nv = $result_nv->fetch_assoc();
        //     $nvc_ten = $row_nv['NVC_TEN'];
        // }

        // Chỉ lưu tên nhà vận chuyển vào session
        // $_SESSION['nhavanchuyen'] = $nvc_ten;

        // Tính toán tổng số tiền và các khoản phí
        // $_SESSION['total'] = 0;
        // foreach ($_SESSION['giohang'] as $item) {
        //     $_SESSION['total'] += $item['GSP_DONGIA'] * $item['soluong'];
        // }

        // Tính tổng tiền phải trả
        // $vat = 0.03; // VAT = 3%
        // $_SESSION['khuyenmai'] = $khuyenmai;
        // $_SESSION['tong_tien_phai_tra'] = $_SESSION['tongtien'] * (1 - $khuyenmai / 100) * (1 + $vat);

        // Điều hướng
        if ($action == 'buy_now') {
            header("Location: giohang.php");
            exit();
        } elseif ($action == 'add_to_cart') {
            header("Location: " . $_SERVER['HTTP_REFERER']); 
            exit();
        }
    } else {
        echo "Sản phẩm không tồn tại!";
    }
} else {
    echo "Không có sản phẩm được chọn!";
}
?>
