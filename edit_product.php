<?php
include 'db.php';
session_start();



// echo $_GET['id'];  
// Kiểm tra nếu ID sản phẩm hợp lệ
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * 
            FROM sanpham s 
             JOIN loaisp l ON l.LSP_MA = s.LSP_MA 
             JOIN giasp g ON g.SP_MA = s.SP_MA 
            LEFT JOIN khohang k ON k.SP_MA = s.SP_MA 
            left join phieunhap p ON p.SP_MA = s.SP_MA
            WHERE s.SP_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ten_sp = $row['SP_TEN'];
        $mota_sp = $row['SP_MOTA'];
        $LSP_MA = $row['LSP_MA'];
        $gia_sp = $row['GSP_DONGIA'];
        $sp_sl = $row['SLTHAYDOI'];
        $hinhanh_sp = $row['SP_HINHANH'];
        $npp = $row['NPP_MA'];
        $gianhap = $row['PN_PBGIA'];
    } else {
        $_SESSION['success'] = "Không tìm thấy sản phẩm.";
        header("Location: sanpham-ad.php");
        exit;
    }
    $stmt->close();

    
} else {
    $_SESSION['success'] = "ID sản phẩm không hợp lệ.";
    header("Location: sanpham-ad.php");
    exit;
}

// Xử lý form khi người dùng cập nhật thông tin sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SP_TEN'])) {
    $ten_sp = trim($_POST['SP_TEN']);
    $mota_sp = trim($_POST['SP_MOTA']);
    $loai_sp = $_POST['SP_loai'];
    $gia_sp = $_POST['SP_gia'];
    $sp_sl = $_POST['SP_sl'];
    $npp = $_POST['npp'];
    $gianhap = $_POST['gianhap'];

    // Kiểm tra nếu có file hình ảnh được upload
    if (isset($_FILES['SP_HINHANH']) && $_FILES['SP_HINHANH']['name'] != '') {
        $target_dir = "product/";
        $target_file = $target_dir . basename($_FILES["SP_HINHANH"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Kiểm tra định dạng file
        if (!in_array($imageFileType, $allowed_types)) {
            $_SESSION['success'] = "Chỉ cho phép hình ảnh định dạng JPG, JPEG, PNG, GIF.";
            header("Location: sanpham-ad.php?id=$id");
            exit;
        }

        // Kiểm tra kích thước file (tối đa 5MB)
        if ($_FILES['SP_HINHANH']['size'] > 5 * 1024 * 1024) {
            $_SESSION['success'] = "Kích thước file quá lớn. Vui lòng chọn file nhỏ hơn 5MB.";
            header("Location: sanpham-ad.php?id=$id");
            exit;
        }

        // Kiểm tra và di chuyển file upload
        if (move_uploaded_file($_FILES["SP_HINHANH"]["tmp_name"], $target_file)) {
            $hinhanh_sp = $target_file;
        } else {
            $_SESSION['success'] = "Lỗi khi tải hình ảnh lên.";
            header("Location: sanpham-ad.php?id=$id");
            exit;
        }
    }

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

    

    // láy tên nhà phân phân phối

    // $sql_NVC = "SELECT * FROM nhaphanphoi WHERE NPP_MA = ?";
    // $stmtNVC = $conn->prepare($sql_NVC);
    // if ($stmtNVC === false) {
    //     die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    // }
    // $stmtNVC->bind_param("s", $npp);
    // if (!$stmtNVC->execute()) {
    //     die("Lỗi khi truy vấn loại sản phẩm: " . $stmtNVC->error);
    // }
    // $resultNPP = $stmtNVC->get_result();
    // $npp_ten= $resultNPP->fetch_assoc()['NPP_TEN'] ; 



    // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
    $sql = "UPDATE sanpham SET SP_TEN = ?,   SP_MOTA = ?, SP_HINHANH = ?, LSP_MA = ? WHERE SP_MA = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['success'] = "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
        header("Location: sanpham-ad.php?id=$id");
        exit;
    }
    $stmt->bind_param("sssss", $ten_sp, $mota_sp, $hinhanh_sp, $LSP_MA, $id);
    $stmt->execute();
    $stmt->close();

    // Cập nhật kho hàng
    $sql_KHO = "UPDATE khohang SET slthaydoi = ? WHERE SP_MA = ?";
    $stmtKho = $conn->prepare($sql_KHO);
    $stmtKho->bind_param("is", $sp_sl, $id);
    $stmtKho->execute();
    $stmtKho->close();

    // Cập nhật giá sản phẩm
    $sql_spgia = "UPDATE giasp SET GSP_DONGIA = ? WHERE SP_MA = ?";
    $stmtGia = $conn->prepare($sql_spgia);
    $stmtGia->bind_param("is", $gia_sp , $id);
    if ($stmtGia === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    if (!$stmtGia->execute()) {
        die("Lỗi khi thêm giá sản phẩm: " . $stmtGia->error);
    }

    $_SESSION['success'] = "Cập nhật thành công.";
    header("Location: sanpham-ad.php");
    exit;

    $sql_spgia = "UPDATE giasp SET GSP_DONGIA = ? WHERE SP_MA = ?";
    $stmtGia = $conn->prepare($sql_spgia);
    $stmtGia->bind_param("is", $gia_sp , $id);
    if ($stmtGia === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    if (!$stmtGia->execute()) {
        die("Lỗi khi thêm giá sản phẩm: " . $stmtGia->error);
    }

    $_SESSION['success'] = "Cập nhật thành công.";
    header("Location: sanpham-ad.php");
    exit;

    ///

    $sql_PN = "UPDATE phieunhap SET   NPP_MA = ? , PN_SL = ?, PN_PBGIA = ? WHERE PN_MA = ?";
    $stmtPN = $conn->prepare($sql_PN);
    $stmtPN->bind_param("ssss", $PP_MA , $sp_sl , $gianhap ,$PP_MA );
    if ($stmtPN === false) {
        die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    if (!$stmtPN->execute()) {
        die("Lỗi khi thêm giá sản phẩm: " . $stmtPN->error);
    }

    $_SESSION['success'] = "Cập nhật thành công.";
    header("Location: sanpham-ad.php");
    exit;



}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Sản Phẩm</h4>
            </div>
            <div class="card-body">
                <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="SP_TEN" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="SP_TEN" name="SP_TEN" value="<?php echo htmlspecialchars($ten_sp); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="SP_MOTA" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="SP_MOTA" name="SP_MOTA" required><?php echo htmlspecialchars($mota_sp); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="SP_loai" class="form-label">Loại sản phẩm</label>
                        <select class="form-select" id="SP_loai" name="SP_loai">
                            <option value="Hoa tươi" <?php echo ($LSP_MA == 'Hoa tươi') ? 'selected' : ''; ?>>Hoa tươi</option>
                            <option value="Hoa handmade" <?php echo ($LSP_MA == 'Hoa handmade') ? 'selected' : ''; ?>>Hoa handmade</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="SP_gia" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="SP_gia" name="SP_gia" value="<?php echo htmlspecialchars($gia_sp); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="SP_sl" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="SP_sl" name="SP_sl" value="<?php echo htmlspecialchars($sp_sl); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="SP_HINHANH" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="SP_HINHANH" name="SP_HINHANH">
                        <img src="<?php echo $hinhanh_sp; ?>" alt="Hình ảnh sản phẩm" class="img-fluid mt-2" width="200">
                    </div>

                    <label for="npp" class="form-label">Cập nhật nhà phân phối</label>
                          <select class="form-control" id="npp" name="npp">
                            <option value="">Chọn nhà phân phối</option> <!-- Option mặc định khi không chọn -->
                            <?php
                            // Truy vấn để lấy danh sách nhà phân phối từ cơ sở dữ liệu
                            include 'db.php';
                            $sql = "SELECT NPP_MA, NPP_TEN FROM nhaphanphoi";
                            $result = $conn->query($sql);

                            // Kiểm tra và hiển thị các nhà phân phối
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                // Gán giá trị NPP_MA là giá trị của option, và NPP_TEN là nội dung hiển thị
                                echo '<option value="' . $row['NPP_MA'] . '">' . $row['NPP_TEN'] . '</option>';
                              }
                            } else {
                              echo '<option value="">Không có nhà phân phối nào</option>';
                            }
                            ?>
                          </select>
                    <div class="mb-3">
                        <label for="gianhap" class="form-label">Cập nhật giá nhập</label>
                        <input type="text" class="form-control" id="gianhap" name="gianhap" value="<?php echo htmlspecialchars($gianhap); ?>" required>
                    </div>


                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="sanpham-ad.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
