<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    $kh_ma =  $_SESSION['user_id'];
    $masp = $_SESSION['SPDG'];
    $sql_MaNV = "SELECT COUNT(*) AS max_ma_NV FROM DANHGIA";
    $result = $conn->query($sql_MaNV);
    $row = $result->fetch_assoc();
    $new_ma_nv = 'DG' . str_pad($row['max_ma_NV'] + 1, 3, '0', STR_PAD_LEFT);



    $sql = "INSERT INTO danhgia (DG_MA,KH_MA, SP_MA , DG_NOIDUNG , DG_SOSAO, DG_NGAYGIO) VALUES ('$new_ma_nv', '$kh_ma', '$masp', '$comment', '$rating', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Đánh giá của bạn đã được gửi thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Vui lòng đăng nhập để gửi đánh giá.";
}

?>