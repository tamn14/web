<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Trang chu</title>
</head>

<body>
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

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        name="query">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5 col-8">
        <div class="row justify-content-center">
            <?php
            include 'db.php';
            if (isset($_GET['sp_ma'])) {
                $sp_ma = $_GET['sp_ma'];
                $_SESSION['SPDG'] = $sp_ma;
                $sql = "SELECT s.*, g.GSP_DONGIA, d.DG_SOSAO 
                        FROM sanpham s 
                        JOIN giasp g ON s.SP_MA = g.SP_MA 
                        LEFT JOIN danhgia d ON s.SP_MA = d.SP_MA 
                        WHERE s.SP_MA = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $sp_ma);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $danhgia = isset($row['DG_SOSAO']) ? $row['DG_SOSAO'] : 0;
                    ?>
                    <div class="col-md-5 text-center mb-4">
                        <img src="<?php echo $row['SP_HINHANH']; ?>" alt="Hình ảnh sản phẩm"
                            class="img-fluid rounded mx-auto d-block" style="max-height: 400px; object-fit: cover;">
                    </div>
                    <div class="col-md-6">
                        <h1 class="product-title">
                            <?php echo isset($row['SP_TEN']) ? $row['SP_TEN'] : 'Tên sản phẩm không có'; ?></h1>
                        <p class="product-description">
                            <?php echo isset($row['SP_MOTA']) ? $row['SP_MOTA'] : 'Mô tả không có'; ?></p>
                        <p>
                            <strong class="text-danger">Giá: </strong>
                            <span
                                class="product-price"><?php echo number_format($row['GSP_DONGIA'], 0, ',', '.') . ' VNĐ'; ?></span>
                        </p>
                        <p>
                            <strong class="text-danger">Đánh giá: </strong>
                        <div class="rating">
                            <?php
                            $sp_ma = isset($_GET['sp_ma']) ? $_GET['sp_ma'] : '';  // Lấy mã sản phẩm từ URL
                            $sql_R = "SELECT ROUND(AVG(DG_SOSAO), 1) AS avg_rating FROM danhgia s WHERE s.SP_MA = ?";
                            $stmt2 = $conn->prepare($sql_R);
                            $stmt2->bind_param("s", $sp_ma);
                            $stmt2->execute();
                            $result1 = $stmt2->get_result();
                            $rating_row = $result1->fetch_assoc();
                            $danhgia = $rating_row['avg_rating'];

                            if (empty($danhgia) || $danhgia == 0 || is_null($danhgia)) {
                                echo '<span class="text-muted">Chưa có đánh giá</span>';
                            } else {
                                for ($i = 0; $i < $danhgia; $i++) {
                                    echo "<span class='text-warning'>&#9733;</span>";
                                }
                                for ($i = $danhgia; $i < 5; $i++) {
                                    echo "<span>&#9733;</span>";
                                }
                            }
                            ?>
                        </div>
                        </p>
                        <div class="btn-group" role="group">
                            <?php if (!isset($_SESSION['username'])): ?>
                                <a href="Login.php" class="btn btn-success btn-lg btn-block">Mua ngay</a>
                                <a href="Login.php" class="btn btn-lg btn-block btn-warning">Thêm vào giỏ hàng</a>
                            <?php else: ?>
                                <a href="themvaogiohang.php?sp_ma=<?php echo urlencode($row['SP_MA']); ?>&action=buy_now"
                                    class="btn btn-success btn-lg btn-block">Mua ngay</a>
                                <a href="themvaogiohang.php?sp_ma=<?php echo urlencode($row['SP_MA']); ?>&action=add_to_cart"
                                    class="btn btn-lg btn-block btn-warning">Thêm vào giỏ hàng</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                } else {
                    echo "<div class='col-12'><p class='text-danger'>Không tìm thấy sản phẩm.</p></div>";
                }
            } else {
                echo "<div class='col-12'><p class='text-danger'>Mã sản phẩm không hợp lệ.</p></div>";
            }
            ?>
        </div>

        <div class="row mt-5">
            <h3>Sản phẩm cùng loại</h3>
            <?php
            if (isset($sp_ma)) {
                $sql_cung_loai = "SELECT * FROM sanpham s 
                                  JOIN giasp g ON s.SP_MA = g.SP_MA 
                                  WHERE s.LSP_MA = ? AND s.SP_MA != ? LIMIT 3";
                $stmt_cung_loai = $conn->prepare($sql_cung_loai);
                $stmt_cung_loai->bind_param("ss", $row['LSP_MA'], $sp_ma);
                $stmt_cung_loai->execute();
                $result_cung_loai = $stmt_cung_loai->get_result();

                if ($result_cung_loai->num_rows > 0) {
                    while ($row_cung_loai = $result_cung_loai->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <a href="chitietsanpham.php?sp_ma=<?php echo $row_cung_loai['SP_MA']; ?>">
                                    <img src="<?php echo $row_cung_loai['SP_HINHANH']; ?>" class="card-img-top"
                                        alt="Hình ảnh sản phẩm" style="height: 200px; object-fit: cover; width: 100%;">
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title text-center"><?php echo $row_cung_loai['SP_TEN']; ?></h6>
                                    <p class="card-text text-center" style="font-size: 13px;">
                                        <strong style="color: red;">Giá:</strong>
                                        <?php echo number_format($row_cung_loai['GSP_DONGIA'], 0, ',', '.') . ' VNĐ'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-muted'>Không có sản phẩm nào cùng loại.</p>";
                }
            }
            ?>
        </div>
        <section class="container mt-5">
            <h2 class="mt-5">Đánh giá sản phẩm</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đánh giá sản phẩm</h5>
                            <form action="sulydanhgia.php" method="post">

                                <div class="rating-stars mb-3">
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5">
                                        <label for="star5"><span class="text-warning">5 &#9733;</span></label>
                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4"><span class="text-warning">4 &#9733;</span></label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3"><span class="text-warning">3 &#9733;</span></label>
                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2"><span class="text-warning">2 &#9733;</span></label>
                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1"><span class="text-warning">1 &#9733;</span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Bình luận:</label>
                                    <textarea class="form-control" id="comment" rows="3" name="comment"></textarea>
                                </div>
                                <div class="btn-group" role="group">
                                    <?php if (!isset($_SESSION['username'])): ?>
                                        <a href="Login.php" class="btn btn-success btn-lg btn-block">Gởi đánh giá</a>

                                    <?php else: ?>
                                        <button type="submit" class="btn btn-button btn-success">Gởi đánh giá</button>


                                    <?php endif; ?>




                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Nhận xét từ khách hàng</h5>
                            <div class="customer-reviews">
                                <?php
                                $sql_DG = "SELECT *  
                                        FROM sanpham s 
                                        JOIN danhgia d ON s.SP_MA = d.SP_MA 
                                        JOIN Khachhang k on k.KH_MA = d.KH_MA
                                        WHERE s.SP_MA = ? LIMIT 3";
                                $stmt1 = $conn->prepare($sql_DG);
                                $stmt1->bind_param("s", $sp_ma);
                                $stmt1->execute();
                                $result = $stmt1->get_result();
                                if ($result->num_rows > 0) {

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='review-item'>";
                                        echo "<h6 class='review-username'>" . htmlspecialchars($row["KH_TEN"]) . "</h6>";
                                        echo "<div class='review-rating'>";
                                        for ($i = 0; $i < $row['DG_SOSAO']; $i++) {
                                            echo "<span class='text-warning'>&#9733;</span>";
                                        }
                                        for ($i = $row['DG_SOSAO']; $i < 5; $i++) {
                                            echo "<span>&#9733;</span>";
                                        }
                                        echo "</div>";
                                        echo "<p class='review-comment'>" . htmlspecialchars($row['DG_NOIDUNG']) . "</p>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>Chưa có đánh giá nào.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <!-- CHAN TRANG -->
    <!-- Footer -->
    <section class="">
        <!-- Footer -->
        <footer class="bg-body-tertiary text-center">
            <!-- Grid container -->
            <div class="container p-4" style="background-color: #F5F5DC ">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <p><span class="glyphicon glyphicon-home"></span>Cần Thơ, Việt Nam.</p>
                        <p><span class="glyphicon glyphicon-home"></span> 3/2 Phường Xuân Khánh, Quận Ninh
                            Kiều,
                            Thành phố Cần Thơ.</p>
                        <p><span class="glyphicon glyphicon-earphone"></span> 0825606124</p>
                        <p><span class="glyphicon glyphicon-envelope"></span>
                            khoaB2003789@student.ctu.edu.vn
                        </p>
                        <p>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1436.8223934223308!2d105.76871541518592!3d10.030171088076532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0f1%3A0x4c90a391d232ccce!2sFaculty%20of%20Information%20Technology%20%26%20Communications!5e1!3m2!1sen!2s!4v1680803435571!5m2!1sen!2s"
                                width="200" height="100" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </p>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">về chúng tôi</h5>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="TrangChu.php" class="text-body" style=" text-decoration: none;"> Trang chủ</a>
                            </li>
                            <li>
                                <a href="sanpham.php" class="text-body" style=" text-decoration: none;">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="Lienhe.php" class="text-body" style=" text-decoration: none;">Liên hệ </a>
                            </li>

                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-0">Thời gian làm việc </h5>

                        <ul class="list-unstyled">
                            <li>
                                Sáng : 6 giờ đến 12 giờ
                            </li>
                            <li>
                                Chiều : 13 giờ 30 đến 21 giờ
                            </li>


                    </div>

                    </ul>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->

            <!-- Grid container -->


        </footer>
        <!-- Footer -->
    </section>

    <!-- End footer -->
    <script src="js.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>