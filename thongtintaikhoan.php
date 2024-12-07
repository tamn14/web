<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';
$sql_nv = "SELECT * ,  SUM(HDCT.CTHD_SLB) AS TONG_SO_SAN_PHAM
FROM KHACHHANG KH
left JOIN HOADON HD ON KH.KH_MA = HD.KH_MA
left JOIN chitiethd HDCT ON HD.HD_MA = HDCT.HD_MA
WHERE KH.KH_MA = ?
GROUP BY KH.KH_TEN";
$tendangnhap = $_SESSION['username'];

$stmt = $conn->prepare($sql_nv);
if ($stmt === false) {
    die('Error preparing query: ' . $conn->error);
}

$user = $_SESSION['user_id'];
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$TongSP = $row['TONG_SO_SAN_PHAM'];
$Hoten = $row['KH_TEN'];
$diaChi = $row['KH_DIACHI'];
$sdt = $row['KH_SDT'];
$email = $row['KH_EMAIL'];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Thong tin tai khoan</title>
</head>


<div class="top-navbar mt-2 d-flex justify-content-between align-items-center px-4 py-2 shadow-sm"
    style="background-color: #f8f9fa;">
    <!-- Icon mạng xã hội -->
    <div class="top-icons d-flex gap-3">
        <img src="product/facebook.png" alt="Facebook" width="20px" style="cursor: pointer;">
        <img src="product/tiktok.png" alt="TikTok" width="20px" style="cursor: pointer;">
        <img src="product/youtube.png" alt="YouTube" width="20px" style="cursor: pointer;">
    </div>

    <!-- Logo trung tâm -->
    <div class="logo">
        <a href="trangchu.php"
            style="text-decoration: none; font-weight: bold; color: #333; font-size: 24px;">ShopHoaDaLat</a>
    </div>

    <div class="other-links d-flex align-items-center gap-3">
        <?php if (!isset($_SESSION['username'])): ?>
            <a href="login.php">
                <button id="btn-login" class="btn btn-success btn-sm">Login</button>
            </a>
        <?php endif; ?>

        <a href="giohang.php">
            <img src="product/shopping-card.png" alt="Giỏ hàng" width="25px" style="cursor: pointer;">
            <sub class="cart-count" id="cart-count">
                <?php
                // Kiểm tra xem session 'giohang' có tồn tại không, nếu có thì đếm số lượng sản phẩm
                echo isset($_SESSION['giohang']) ? count($_SESSION['giohang']) : 0;
                ?>
            </sub>
        </a>

        <div class="dropdown">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $_SESSION['avatar']; ?>" alt="Avatar" width="32" height="32"
                        class="rounded-circle" />
                </a>

                <ul class="dropdown-menu" style="background-color: white;">
                    <li><a class="dropdown-item" href="thongtintaikhoan.php">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item" href="dangxuat.php">Đăng xuất</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>

</div>


<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center">
            <div class="col col-lg-9 col-xl-8">
                <div class="card">
                    <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                            <img src="<?php echo $_SESSION['avatar']; ?>" alt="Generic placeholder image"
                                class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                           
                        </div>
                        <div class="ms-3" style="margin-top: 130px;">
                            <h5><?php echo $_SESSION['username']; ?></h5>

                        </div>
                    </div>
                    <div class="p-4 text-black bg-body-tertiary">
                        <div class="d-flex justify-content-end text-center py-1 text-body">
                            <div>
                                <p class="mb-1 h5"><?php echo $TongSP ?></p>
                                <p class="small text-muted mb-0">Số sản phẩm đã mua </p>
                            </div>

                        </div>
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5  text-body">
                            <p class="lead fw-normal mb-1">Thông tin tài khoản </p>
                            <div class="p-4 bg-body-tertiary">
                                <p class="font-italic mb-1">Tên Đăng Nhập : <?php echo $_SESSION['username']; ?> </p>
                                <p class="font-italic mb-0">Họ Tên : <?php echo $Hoten ?> </p>
                                <p class="font-italic mb-1">Địa Chỉ : <?php echo $diaChi ?> </p>
                                <p class="font-italic mb-1">Số Điện Thoại :<?php echo $sdt ?> </p>
                                <p class="font-italic mb-0">Email : <?php echo $email ?> </p>
                            </div>
                            <a href="chinhsuathongtin.php">
                                <button type="button" class="btn btn-success mt-3">Thay đổi thông tin</button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="JS.js"></script>
</body>

</html>