<?php
session_start();

// Kiểm tra nếu không có thông tin đơn hàng trong session, chuyển hướng về trang chủ
if (!isset($_SESSION['name']) || !isset($_SESSION['Tong'])) {
    header('Location: trangchu.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Hóa Đơn Đặt Hàng</title>
</head>

<body>
    <div class="card">
        <div class="card-body mx-4">
            <div class="container">
                <p class="my-5 mx-5" style="font-size: 30px;">Hóa Đơn Đặt Hàng</p>
                <div class="row">
                    <ul class="list-unstyled">
                        <li class="text-black">Họ và Tên: <?php echo $_SESSION['name']; ?></li>
                        <li class="text-black mt-1">Số điện thoại: <?php echo $_SESSION['sdt']; ?></li>
                        <li class="text-black mt-1">Địa chỉ nhận hàng: <?php echo $_SESSION['diachi']; ?></li>
                        <li class="text-black mt-1">Email: <?php echo $_SESSION['email']; ?></li>
                        <li class="text-black mt-1">Đơn vị vận chuyển: <?php echo $_SESSION['DVVC']; ?></li>
                        <li class="text-black mt-1">Phương thức thanh toán: <?php echo $_SESSION['pttt']; ?></li>
                    </ul>
                    <hr>
                </div>

                <!-- Hiển thị bảng danh sách sản phẩm đã mua -->
                <div class="row">
                    <h5 class="mt-3">Danh sách sản phẩm đã mua:</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá (VND)</th>
                                <th>Khuyến mãi</th>
                                <th>Thành tiền (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalBeforeDiscount = 0; // Tổng tiền trước khi giảm giá
                        $totalAfterDiscount = 0;  // Tổng tiền sau khi giảm giá

                        if (!empty($_SESSION['giohang'])): 
                            foreach ($_SESSION['giohang'] as $key => $item):
                                $totalBeforeDiscount += $item['GSP_DONGIA'] * $item['soluong']; 
                                $discountedPrice = $item['GSP_DONGIA'] * (1 - $item['KM_GTRI'] / 100); 
                                $totalAfterDiscount += $discountedPrice * $item['soluong']; 
                                $_SESSION['totalprice'] =  $totalAfterDiscount + $_SESSION['NVCPhi'] ;  
                        ?>
                                <tr class="border-bottom">
                                    <td>
                                        <img src="<?php echo $item['SP_HINHANH']; ?>" alt="<?php echo $item['SP_TEN']; ?>"
                                            class="img-fluid rounded-3" style="width: 80px; height: 80px; object-fit: cover;" />
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo $item['SP_TEN']; ?></p>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo $item['soluong']; ?></p>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-secondary"><?php echo number_format($item['GSP_DONGIA']); ?> VND
                                        </h6>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo $item['KM_GTRI']; ?> %</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo number_format($discountedPrice * $item['soluong']); ?> VND</p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">không có</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    </table>

                </div>
                <hr>
                <div class="row text-black">
                    <div class="col-xl-12">
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Tổng tiền sản phẩm:</span>
                            <span><?php echo number_format($totalBeforeDiscount, 0, ',', '.'); ?> VND</span>
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Phí vận chuyển:</span>
                            <span><?php echo number_format($_SESSION['NVCPhi'], 0, ',', '.'); ?> VND</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            
                            <span>Tổng tiền phải trả:</span>
                            <span><?php echo number_format($totalAfterDiscount + $_SESSION['NVCPhi'], 0, ',', '.'); ?> VND</span>
                        </div>
                    </div>

                    <hr style="border: 2px solid black;">
                </div>

                <div class="text-center" style="margin-top: 90px;">
                    <div class="row justify-content-center">
                        <div class="col-8 col-md-2 mb-3">
                            <a href="sulysubmit.php">
                                <button type="button" class="btn btn-primary btn-block w-100">Đồng ý</button>
                            </a>
                        </div>
                        <div class="col-8 col-md-2 mb-3">
                            <a href="dathang.php">
                                <button type="button" class="btn btn-secondary btn-block w-100">Thoát</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
