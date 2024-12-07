<?php
session_start();

// Kiểm tra thông tin thanh toán có tồn tại trong session
if (!isset($_SESSION['maHD'], $_SESSION['name'], $_SESSION['TONGTIEN'])) {
    echo "<script>alert('Không có thông tin thanh toán.'); window.location.href = 'dathang.php';</script>";
    exit();
}

$maHD = $_SESSION['maHD']; // Mã đơn hàng
$tenKH = $_SESSION['name']; // Tên khách hàng
$tongTien = $_SESSION['TONGTIEN']; // Tổng tiền

// Tạo nội dung thanh toán
$paymentContent = $maHD . "- " . $tenKH ."-" .$tongTien;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            background-color: #f5f5f5;
        }
        h2 {
            color: #4CAF50;
        }
        .qr-code {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
            display: inline-block;
        }
        .order-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Thanh toán qua mã QR Vietcombank</h2>
    <div class="order-info">
        <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($maHD); ?></p>
        <p><strong>Họ Tên Khách:</strong> <?php echo htmlspecialchars($tenKH); ?></p>
        <p><strong>Tổng tiền:</strong> <?php echo number_format($tongTien, 0, ',', '.') . ' VND'; ?></p>
        <p>Vui lòng thanh toán với nội dung sau: <strong><?php echo htmlspecialchars($paymentContent); ?></strong></p>
    </div>

    <div class="qr-code">
        <img src="product/qr.png" alt="QR">
    </div>

    <p>Vui lòng quét mã QR để thanh toán.</p>
</body>
</html>



