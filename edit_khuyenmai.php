<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_km = $_POST['ma_km'];
    $ma_sp = $_POST['ma_sp'];
    $tgbd = $_POST['tgbd'];
    $tgkt = $_POST['tgkt'];
    $gtkm = $_POST['gtkm'];

    // Kiểm tra mã sản phẩm có tồn tại
    $sql_check_sp = "SELECT * FROM sanpham WHERE SP_MA = ?";
    $stmtCheckSP = $conn->prepare($sql_check_sp);
    $stmtCheckSP->bind_param("s", $ma_sp);
    $stmtCheckSP->execute();
    $resultCheckSP = $stmtCheckSP->get_result();

    if ($resultCheckSP->num_rows === 0) {
        $_SESSION['error_ma_sp'] = "Mã sản phẩm không tồn tại.";
        header("Location: edit_khuyenmai.php?id=$ma_km");
        exit;
    }

    // Kiểm tra thời gian
    if (strtotime($tgkt) < strtotime($tgbd)) {
        $_SESSION['error_tgkt'] = "Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu.";
        header("Location: edit_khuyenmai.php?id=$ma_km");
        exit;
    }

    // Kiểm tra giá trị khuyến mãi hợp lệ
    if ($gtkm < 0 || $gtkm > 100) {
        $_SESSION['error_gtkm'] = "Giá trị khuyến mãi phải trong khoảng từ 0 đến 100.";
        header("Location: edit_khuyenmai.php?id=$ma_km");
        exit;
    }

    // Cập nhật bảng KhuyenMai
    $sql_spgia = "UPDATE KhuyenMai SET KM_TGBD = ?, KM_TGKT = ?, KM_GTRI = ? WHERE KM_MA = ?";
    $stmtGia = $conn->prepare($sql_spgia);
    $stmtGia->bind_param("ssss", $tgbd, $tgkt, $gtkm, $ma_km);
    if (!$stmtGia->execute()) {
        die("Lỗi khi cập nhật khuyến mãi: " . $stmtGia->error);
    }

    // Cập nhật bảng KM_SP
    $sql_spgia_km = "UPDATE KM_SP SET SP_MA = ? WHERE KM_MA = ?";
    $stmtGiaKM = $conn->prepare($sql_spgia_km);
    $stmtGiaKM->bind_param("ss", $ma_sp, $ma_km);
    if (!$stmtGiaKM->execute()) {
        die("Lỗi khi cập nhật sản phẩm trong KM_SP: " . $stmtGiaKM->error);
        
    }

    // Điều hướng sau khi cập nhật thành công
    $_SESSION['success'] = "Cập nhật thành công.";
    header("Location: khuyenmai-ad.php");
    exit;
}

// Lấy dữ liệu khuyến mãi hiện tại để hiển thị trong form
if (isset($_GET['id'])) {
    $ma_km = $_GET['id'];
    $sql_get_km = "SELECT KM_TGBD, KM_TGKT, KM_GTRI, SP_MA FROM KhuyenMai 
                   LEFT JOIN KM_SP ON KhuyenMai.KM_MA = KM_SP.KM_MA 
                   WHERE KhuyenMai.KM_MA = ?";
    $stmtGetKM = $conn->prepare($sql_get_km);
    $stmtGetKM->bind_param("s", $ma_km);
    $stmtGetKM->execute();
    $resultKM = $stmtGetKM->get_result();
    $khuyenmai = $resultKM->fetch_assoc();


    $khuyenmai['KM_TGBD'] = isset($khuyenmai['KM_TGBD']) ? date('Y-m-d', strtotime($khuyenmai['KM_TGBD'])) : '';
    $khuyenmai['KM_TGKT'] = isset($khuyenmai['KM_TGKT']) ? date('Y-m-d', strtotime($khuyenmai['KM_TGKT'])) : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Khuyến Mãi</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Khuyến Mãi</h4>
            </div>
            <div class="card-body">
                <form action="edit_khuyenmai.php?id=<?php echo $ma_km; ?>" method="POST">
                    <input type="hidden" name="ma_km" value="<?php echo htmlspecialchars($ma_km); ?>">

                    <div class="mb-3">
                        <label for="ma_sp" class="form-label">Mã sản phẩm</label>
                        <input type="text" class="form-control" id="ma_sp" name="ma_sp"
                            value="<?php echo htmlspecialchars($khuyenmai['SP_MA'] ?? ''); ?>" required>
                        <div class="text-danger fst-italic">
                            <?php echo $_SESSION['error_ma_sp'] ?? '';
                            unset($_SESSION['error_ma_sp']); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tgbd" class="form-label">Thời gian bắt đầu</label>
                        <input type="date" class="form-control" id="tgbd" name="tgbd"
                            value="<?php echo htmlspecialchars($khuyenmai['KM_TGBD'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tgkt" class="form-label">Thời gian kết thúc</label>
                        <input type="date" class="form-control" id="tgkt" name="tgkt"
                            value="<?php echo htmlspecialchars($khuyenmai['KM_TGKT'] ?? ''); ?>" required>
                    </div>


                    <div class="mb-3">
                        <label for="gtkm" class="form-label">Giá trị khuyến mãi</label>
                        <input type="number" class="form-control" id="gtkm" name="gtkm"
                            value="<?php echo htmlspecialchars($khuyenmai['KM_GTRI'] ?? ''); ?>" required>
                        <div class="text-danger fst-italic">
                            <?php echo $_SESSION['error_gtkm'] ?? '';
                            unset($_SESSION['error_gtkm']); ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Cập Nhật Khuyến Mãi</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>