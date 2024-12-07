<?php
include 'db.php';
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT * FROM nhavanchuyen WHERE NVC_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ma_nvc = $row['NVC_MA'];
        $ten_nvc = $row['NVC_TEN'];
        $khuvuc = $row['NVC_KHUVUC'];
        $phi = $row['NVC_PHI'];
    } else {
        $_SESSION['error_message'] = "Không tìm thấy nhà vận chuyển.";
        header("Location: nhavanchuyen-ad.php");
        exit;
    }
    $stmt->close();
} else {
    $_SESSION['error_message'] = "Mã nhà vận chuyển không hợp lệ.";
    header("Location: nhavanchuyen-ad.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_nvc = $_POST['NVC_MA'];
    $ten_nvc = $_POST['NVC_TEN'];
    $khuvuc = $_POST['NVC_KHUVUC'];
    $phi = $_POST['NVC_PHI'];

    // Cập nhật thông tin nhà vận chuyển trong cơ sở dữ liệu
    $sql_spgia = "UPDATE nhavanchuyen SET NVC_TEN = ?, NVC_KHUVUC = ?, NVC_PHI = ? WHERE NVC_MA = ?";
    $stmtGia = $conn->prepare($sql_spgia);
    $stmtGia->bind_param("ssss", $ten_nvc, $khuvuc, $phi, $ma_nvc);
    if ($stmtGia->execute()) {
        $_SESSION['success'] = "Cập nhật thành công.";
        header("Location: nhavanchuyen-ad.php");
        exit;
    } else {
        die("Lỗi khi cập nhật nhà vận chuyển: " . $stmtGia->error);
    }
    $stmtGia->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhà Vận Chuyển</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Nhà Vận Chuyển</h4>
            </div>
            <div class="card-body">
                <form action="edit_NVC.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="NVC_MA" class="form-label">Mã Nhà Vận Chuyển</label>
                        <input type="text" class="form-control" id="NVC_MA" name="NVC_MA" value="<?php echo htmlspecialchars($ma_nvc); ?>" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="NVC_TEN" class="form-label">Tên Nhà Vận Chuyển</label>
                        <input type="text" class="form-control" id="NVC_TEN" name="NVC_TEN" value="<?php echo htmlspecialchars($ten_nvc); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="NVC_KHUVUC" class="form-label">Khu Vực</label>
                        <input type="text" class="form-control" id="NVC_KHUVUC" name="NVC_KHUVUC" value="<?php echo htmlspecialchars($khuvuc); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="NVC_PHI" class="form-label">Phí</label>
                        <input type="number" class="form-control" id="NVC_PHI" name="NVC_PHI" value="<?php echo htmlspecialchars($phi); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật Nhà Vận Chuyển</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
