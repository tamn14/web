<?php
include 'db.php';
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT 
                * 
            FROM 
                HOADON hd
            JOIN 
                PTTHANHTOAN pttt ON hd.PTTT_MA = pttt.PTTT_MA
            JOIN 
                TRANGTHAI tt ON hd.TT_MA = tt.TT_MA
            JOIN 
                KHACHHANG kh ON hd.KH_MA = kh.KH_MA
            WHERE hd.HD_MA= ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maHD = $row['HD_MA'];
        $maPT = $row['PTTT_MA'];
        $maTT = $row['TT_TEN'];
        $makH = $row['KH_MA'];
        $DVC = $row['DVC_MA'];
        $ngay = $row['HD_NGAYLAP'] ; 
    } else {
        $_SESSION['error_message'] = "Không tìm thấy hóa đơn.";
        header("Location: hoadon-ad.php");
        exit;
    }
    $stmt->close();
} else {
    $_SESSION['error_message'] = "Mã hóa đơn không hợp lệ.";
    header("Location: hoadon-ad.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_hd = $_POST['ma_HD'];
    $ma_PT = $_POST['ma_PT'];
    $TT_ten = $_POST['TT_TEN'];
    $makH = $_POST['ma_KH'];

    // Cập nhật trạng thái hóa đơn
    $sql = "UPDATE HOADON 
            SET TT_MA = ? 
            WHERE HD_MA = ?";
    $stmtUpdate = $conn->prepare($sql);
    $stmtUpdate->bind_param("ss", $TT_ten, $ma_hd);
    
    if (!$stmtUpdate->execute()) {
        die("Lỗi khi cập nhật hóa đơn: " . $stmtUpdate->error);
    }

    $sql = "UPDATE donvanchuyen 
    SET DVC_TGHT = ? 
    WHERE DVC_MA = ?";
    $stmtUpdate = $conn->prepare($sql);
    $stmtUpdate->bind_param("ss", $ngay, $DVC);

    if (!$stmtUpdate->execute()) {
    die("Lỗi khi cập nhật hóa đơn: " . $stmtUpdate->error);
    }





    $_SESSION['success'] = "Cập nhật thành công.";
    header("Location: hoadon-ad.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Hóa Đơn</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Hóa Đơn</h4>
            </div>
            <div class="card-body">
                <form action="edit_hoadon.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ma_HD" class="form-label">Mã Hóa Đơn</label>
                        <input type="text" class="form-control" id="ma_HD" name="ma_HD" value="<?php echo $maHD; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="ma_PT" class="form-label">Mã Phương Thức Thanh Toán</label>
                        <input type="text" class="form-control" id="ma_PT" name="ma_PT" value="<?php echo $maPT; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="TT_TEN" class="form-label">Trạng Thái</label>
                        <select class="form-select" name="TT_TEN">
                            <?php
                            // Query trạng thái hiện tại
                            include 'db.php';
                            $sqlTrangThai = "SELECT * FROM TRANGTHAI";
                            $resultTrangThai = $conn->query($sqlTrangThai);
                            if ($resultTrangThai->num_rows > 0) {
                                while ($trangthai = $resultTrangThai->fetch_assoc()) {
                                    $selected = ($row["TT_TEN"] == $trangthai["TT_TEN"]) ? "selected" : "";
                                    echo "<option value='" . $trangthai["TT_MA"] . "' $selected>" . $trangthai["TT_TEN"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
