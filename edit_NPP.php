<?php
include 'db.php';
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT * FROM nhaphanphoi n WHERE n.NPP_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ma_np = $row['NPP_MA'];
        $ten_npp = $row['NPP_TEN'];



    } else {
        $_SESSION['error_message'] = "Không tìm thấy NPP.";
        header("Location: nhaphanphoi-ad.php");
        exit;
    }
    $stmt->close();
} else {
    $_SESSION['error_message'] = " Mã nhà phân phối không hợp lệ.";
    header("Location: nhaphanphoi-ad.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Vhh_npp = $_POST['NPP_VOHH'];
    $ten_npp = $_POST['NPP_TEN'];

    


    if ($Vhh_npp == 1) {
        $check =  0 ; 
        $sql_spgia = "UPDATE nhaphanphoi SET NPP_TEN = ?, NPP_VOHH = ? WHERE NPP_MA = ?";
        $stmtGia = $conn->prepare($sql_spgia);
        $stmtGia->bind_param("sis", $ten_npp, $check, $ma_np);
    } else {
        $sql_spgia = "UPDATE nhaphanphoi SET NPP_TEN = ? WHERE NPP_MA = ?";
        $stmtGia = $conn->prepare($sql_spgia);
        $stmtGia->bind_param("ss", $ten_npp, $ma_np);
    }

    if ($stmtGia->execute()) {
        $_SESSION['success'] = "Cập nhật thành công.";
        header("Location: nhaphanphoi-ad.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Lỗi khi cập nhật nhà phân phối: " . $stmtGia->error;
        header("Location: nhaphanphoi-ad.php");
        exit;
    }
   
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhà Phân Phối</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Nhà Phân Phối</h4>
            </div>
            <div class="card-body">
                <form action="edit_NPP.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="NPP_TEN" class="form-label">Tên nhà phân phối</label>
                        <input type="text" class="form-control" id="NPP_TEN" name="NPP_TEN"
                            value="<?php echo htmlspecialchars($ten_npp); ?>" required>
                    </div>
                    <div class="form-check mt-5 mb-5">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate" name="NPP_VOHH">
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            Vô hiệu hóa
                        </label>
                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>