<?php
session_start();
include 'db.php';


// Logic thêm sản phẩm vào cơ sở dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $ten_sp = $_POST['SP_TEN'];
    $mota_sp = $_POST['SP_MOTA'];
    $loai_sp = $_POST['SP_loai'];
    $gia_sp = $_POST['SP_gia'];
    $sp_sl = $_POST['SP_sl'];
    $npp = $_POST['npp'];

    $gianhap = $_POST['gianhap'];


    $check = 1;
    // Kiểm tra họ tên
    if (empty($ten_sp)) {
        $_SESSION['error_name'] = "Bạn chưa nhập tên sản phẩm!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }
    if (empty($mota_sp)) {
        $_SESSION['error_mota'] = "Bạn chưa nhập mô tả sản phẩm!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }
    if (empty($sp_sl)) {
        $_SESSION['error_sl'] = "Bạn chưa nhập số lượng sản phẩm!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }
    if (empty($gia_sp)) {
        $_SESSION['error_gia'] = "Bạn chưa nhập giá sản phẩm!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }

    if (empty($gia_sp)) {
        $_SESSION['error_hinh'] = "Bạn chưa chọn hinh sản phẩm!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }

    if (empty($npp)) {
        $_SESSION['error_NPP'] = "Bạn chưa chọn nhà phân phối!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }

    if (empty($gianhap)) {
        $_SESSION['error_gianhap'] = "Bạn chưa chọn giá nhập!!!!!!";
        $check = 0;
        header("Location: sanpham-ad.php");

    }

    if($check == 0) {
        header("Location: sanpham-ad.php");
        exit();
    }
    

    


    // Xử lý hình ảnh
    $target_dir = "product/"; // Thư mục lưu trữ hình ảnh
    $target_file = $target_dir . basename($_FILES["SP_HINHANH"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra loại tệp tin hình ảnh
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error_hinh'] = "Chỉ cho phép hình ảnh định dạng JPG, JPEG, PNG, GIF.";
        exit;
    }

    // Di chuyển hình ảnh từ tạm thời đến thư mục
    if (move_uploaded_file($_FILES["SP_HINHANH"]["tmp_name"], $target_file)) {

        // Lấy mã sản phẩm mới
        $sql_MaSP = "SELECT COUNT(*) AS max_ma_HD FROM SANPHAM";
        $result = $conn->query($sql_MaSP);
        $row = $result->fetch_assoc();
        $new_ma_hd = 'SP' . str_pad($row['max_ma_HD'] + 5, 3, '0', STR_PAD_LEFT);

        // Lấy mã phiếu nhập
        $sql_MaPN = "SELECT COUNT(*) AS max_ma_HD FROM PhieuNHap";
        $result = $conn->query($sql_MaPN);
        $row = $result->fetch_assoc();
        $new_ma_PN = 'PN' . str_pad($row['max_ma_HD'] + 1, 3, '0', STR_PAD_LEFT);

        // Lấy LSP_MA từ bảng loaisp
        $sql_LSP = "SELECT * FROM loaisp WHERE LSP_TEN = ?";
        $stmtLSP = $conn->prepare($sql_LSP);
        if ($stmtLSP === false) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        
        $stmtLSP->bind_param("s", $loai_sp);
        if (!$stmtLSP->execute()) {
            die("Lỗi khi truy vấn loại sản phẩm: " . $stmtLSP->error);
        }
        $resultLSP = $stmtLSP->get_result();
        $LSP_MA = $resultLSP->fetch_assoc()['LSP_MA'];


        // lay nha phan phoi  
        // $sql_NPP = "SELECT * FROM nhaphanphoi WHERE NPP_TEN = ?";
        // $stmtNPP = $conn->prepare($sql_NPP);
        // if ($stmtNPP === false) {
        //     die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        // }
        // $stmtNPP->bind_param("s", $npp);
        // if (!$stmtNPP->execute()) {
        //     die("Lỗi khi truy vấn loại sản phẩm: " . $stmtNPP->error);
        // }
        // $resultPN = $stmtNPP->get_result();
        // $NPP_MA = $resultPN->fetch_assoc()['NPP_MA'];





        // Thêm sản phẩm vào bảng SanPham
        $sql_SP = "INSERT INTO SanPham (SP_MA, LSP_MA, SP_TEN, SP_MOTA, SP_HINHANH) VALUES (?, ?, ?, ?, ?)";
        $stmtSP = $conn->prepare($sql_SP);
        $stmtSP->bind_param("sssss", $new_ma_hd, $LSP_MA, $ten_sp, $mota_sp, $target_file);
        if ($stmtSP === false) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        if (!$stmtSP->execute()) {
            die("Lỗi khi thêm sản phẩm: " . $stmtSP->error);
        }

        // Thêm vào kho hàng
        $sql_KHO = "INSERT INTO khohang (SP_MA, SLThayDoi, NGAYTHAYDOI) VALUES (?, ?, NOW())";
        $stmtKho = $conn->prepare($sql_KHO);
        $stmtKho->bind_param("si", $new_ma_hd, $sp_sl);
        if ($stmtKho === false) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        if (!$stmtKho->execute()) {
            die("Lỗi khi thêm vào kho hàng: " . $stmtKho->error);
        }

        // Thêm giá sản phẩm
        $sql_spgia = "INSERT INTO giasp (SP_MA, GSP_DONGIA) VALUES (?, ?)";
        $stmtGia = $conn->prepare($sql_spgia);
        $stmtGia->bind_param("si", $new_ma_hd, $gia_sp);
        if ($stmtGia === false) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        if (!$stmtGia->execute()) {
            die("Lỗi khi thêm giá sản phẩm: " . $stmtGia->error);
        }

        // thêm vào phiếu nhập  
        $sql_PN = "INSERT INTO phieunhap  (PN_MA , NV_MA , NPP_MA, SP_MA, PN_NGAYNHAP, PN_SL , PN_PBGIA) VALUES (?, ? , ? , ? , NOW(), ?, ?)";
        $stmtPN = $conn->prepare($sql_PN);
        $stmtPN->bind_param("ssssss", $new_ma_PN, $_SESSION['user_id'] , $npp , $new_ma_hd, $sp_sl , $gianhap );
        if ($stmtPN === false) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        if (!$stmtPN->execute()) {
            die("Lỗi khi thêm giá sản phẩm: " . $stmtPN->error);
        }

        $_SESSION['success'] = "Thêm thành công";
        header("Location: sanpham-ad.php");
        exit();
       
    } else {
        $_SESSION['error_hinh'] =  "Lỗi khi tải hình ảnh lên.";
    }

    $conn->close();
}
?>
