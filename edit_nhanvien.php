<?php
include 'db.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin nhân viên từ cơ sở dữ liệu
    $sql = "SELECT * 
                FROM nhanvien s
                JOIN chucvu g ON g.CV_MA = s.CV_MA
                WHERE g.CV_ND <> 'Quản lý'
                AND s.NV_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ten_nv = $row['NV_TEN'];
        $diachi = $row['NV_DIACHI'];
        $sdt = $row['NV_SDT'];
        $email = $row['NV_EMAIL'];
        $tdn = $row['NV_TDN'];
        $hinhanh_sp = $row['NV_Avatar'];
        $mk = $row['NV_MK'];
    } else {
        $_SESSION['success'] = "Không tìm thấy nhân viên.";
        header("Location: nhanvien-ad.php");
        exit;
    }
    $stmt->close();
} else {
    $_SESSION['success'] = "ID nhân viên không hợp lệ.";
    header("Location: nhanvien-ad.php");
    exit;
}

// Xử lý form khi người dùng cập nhật thông tin nhân viên
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_nv = trim($_POST['SP_TEN']);
    $diachi_nv = trim($_POST['SP_DIACHI']);
    $sdt_nv = $_POST['SP_SDT'];
    $email_nv = $_POST['SP_EMAIL'];
    $tdn_nv = $_POST['tendangnhap'];
    $mk_nv = $_POST['mk'];

    // Kiểm tra nếu có file hình ảnh được upload
    if (isset($_FILES['SP_HINHANH']) && $_FILES['SP_HINHANH']['name'] != '') {
        $target_dir = "assets/images/faces/";
        $target_file = $target_dir . basename($_FILES["SP_HINHANH"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Kiểm tra định dạng file
        if (!in_array($imageFileType, $allowed_types)) {
            $_SESSION['error_hinh'] = "Chỉ cho phép hình ảnh định dạng JPG, JPEG, PNG, GIF.";
            header("Location: nhanvien-ad.php?id=$id");
            exit;
        }

        // Kiểm tra kích thước file (tối đa 5MB)
        if ($_FILES['SP_HINHANH']['size'] > 5 * 1024 * 1024) {
            $_SESSION['error_hinh'] = "Kích thước file quá lớn. Vui lòng chọn file nhỏ hơn 5MB.";
            header("Location: nhanvien-ad.php?id=$id");
            exit;
        }

        // Kiểm tra và di chuyển file upload
        if (move_uploaded_file($_FILES["SP_HINHANH"]["tmp_name"], $target_file)) {
            $hinhanh_sp = $target_file;
        } else {
            $_SESSION['error_hinh'] = "Lỗi khi tải hình ảnh lên.";
            header("Location: nhanvien-ad.php?id=$id");
            exit;
        }
    }

    // Cập nhật thông tin nhân viên
    $sql = "UPDATE nhanvien 
            SET NV_TEN = ?, NV_DIACHI = ?, NV_SDT = ?, NV_EMAIL = ?, NV_TDN = ?, NV_MK = ?, NV_Avatar = ? 
            WHERE NV_MA = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error_sql'] = "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
        header("Location: nhanvien-ad.php?id=$id");
        exit;
    }

    $stmt->bind_param("ssssssss", $ten_nv, $diachi_nv, $sdt_nv, $email_nv, $tdn_nv, $mk_nv, $hinhanh_sp, $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Cập nhật nhân viên thành công!";
        header("Location: nhanvien-ad.php");
    } else {
        $_SESSION['error_sql'] = "Lỗi khi cập nhật dữ liệu: " . $stmt->error;
        header("Location: nhanvien-ad.php?id=$id");
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Sửa Nhân Viên</h4>
            </div>
            <div class="card-body">
                <form action="edit_nhanvien.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ten_nv" class="form-label">Tên Nhân Viên</label>
                        <input type="text" class="form-control" id="ten_nv" name="SP_TEN" value="<?php echo $ten_nv; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="diachi" class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control" id="diachi" name="SP_DIACHI" value="<?php echo $diachi; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="sdt" class="form-label">Số Điện Thoại</label>
                        <input type="tel" class="form-control" id="sdt" name="SP_SDT" value="<?php echo $sdt; ?>" pattern="[0-9]{10}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="SP_EMAIL" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="hinhanh_sp" class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinhanh_sp" name="SP_HINHANH" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="tendangnhap" class="form-label">Tên Đăng Nhập</label>
                        <input type="text" class="form-control" id="tendangnhap" name="tendangnhap" value="<?php echo $tdn; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mk" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control" id="mk" name="mk" value="<?php echo $mk; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="nhanvien-ad.php" class="btn btn-secondary">Quay Lại</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
