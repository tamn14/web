<?php
session_start();
$total = 0;

// $shipping_cost = 0;
// $discount = 0;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Giohang</title>
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

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="TrangChu.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="VeChungToi.php">Về chúng tôi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sanpham.php">Sản Phẩm</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" aria-disabled="true" href="Lienhe.php">Liên Hệ</a>
                </li>
            </ul>
            <form class="d-flex" role="search" action="search.php" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="card shadow-lg" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h3 class="fw-bold text-center text-uppercase mb-4" style="color: #5e72e4;">Giỏ hàng</h3>
            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá Bán (VND)</th>
                            <th>Thành Tiền (VND)</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Hiển thị sản phẩm trong giỏ hàng -->
                        <?php if (!empty($_SESSION['giohang'])): ?>
                            <?php foreach ($_SESSION['giohang'] as $key => $item): ?>
                                <?php $total += $item['GSP_DONGIA'] * $item['soluong']; ?>
                                <tr class="border-bottom">
                                    <td>
                                        <img src="<?php echo $item['SP_HINHANH']; ?>" alt="<?php echo $item['SP_TEN']; ?>"
                                            class="img-fluid rounded-3" style="width: 80px; height: 80px; object-fit: cover;" />
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo $item['SP_TEN']; ?></p>
                                    </td>
                                    <td>
                                        <form action="update-cart.php" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="sp_ma" value="<?php echo $item['SP_MA']; ?>">
                                            <button type="submit" name="action" value="decrease"
                                                class="btn btn-sm btn-outline-primary mx-1">-</button>
                                            <input type="text" name="soluong" value="<?php echo $item['soluong']; ?>" readonly
                                                class="form-control form-control-sm text-center" style="width: 50px;">
                                            <button type="submit" name="action" value="increase"
                                                class="btn btn-sm btn-outline-primary mx-1">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-secondary"><?php echo number_format($item['GSP_DONGIA']); ?> VND
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-success">
                                            <?php echo number_format($item['GSP_DONGIA'] * $item['soluong']); ?> VND
                                        </h6>
                                    </td>
                                    <td class="text-end">
                                        <form action="remove_item.php" method="post"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                            <input type="hidden" name="sp_ma" value="<?php echo $item['SP_MA']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Giỏ hàng trống</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-5 offset-7">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Thanh toán</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Tổng tiền</p>
                                    <p class="mb-0"><?php echo number_format($total); ?> VND</p>
                                </div>






                                <hr class="my-2">
                                <form action="dathang.php">
                                    <?php if (!empty($_SESSION['giohang'])): ?>
                                        <?php foreach ($_SESSION['giohang'] as $key => $item): ?>
                                            <input type="hidden" name="sanpham[<?php echo $item['SP_MA']; ?>][soluong]"
                                                value="<?php echo $item['soluong']; ?>">
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary w-100">Tiến hành thanh toán</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9gybgybwEm3JQar6Twg2oB3Q7l3u6CV7WxW9l2wYm4hghjtR1Lk6"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuFIdak/sDA6TZ0+Fv2i4LpZ42XZXMtwq6jQntXa3xzNdjGcUpiRxE9tpa72OKjX"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="JS.js"></script>
</body>

</html>