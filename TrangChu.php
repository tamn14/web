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
<div class="container col-8">
    <div id="myCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="product/slider-02.jpg" class="d-block w-100" alt="Slider Image 1" height="400">
            </div>
            <div class="carousel-item">
                <img src="product/slider3.jpg" class="d-block w-100" alt="Slider Image 2" height="400">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container col-9">
        <h2 class="text-center my-5">Sản phẩm</h2>
        <div class="row">
            <?php
            // Kết nối cơ sở dữ liệu
            include 'db.php';

            $sql = "SELECT * FROM sanpham sp 
            LEFT JOIN KM_SP km ON sp.SP_MA = km.SP_MA 
            LEFT JOIN khuyenmai k ON k.KM_MA = km.KM_MA
            LEFT JOIN giasp g ON g.SP_MA = sp.SP_MA Limit 6" ;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $giaGoc = $row['GSP_DONGIA'];
                    $phanTramGiam = $row['KM_GTRI'];
                    $ngayBatDau = $row['KM_TGBD'];
                    $ngayKetThuc = $row['KM_TGKT'];
                    $currentDate = date('Y-m-d H:i:s');

                    // Kiểm tra xem sản phẩm có khuyến mãi và trong thời gian khuyến mãi hay không
                    if ($phanTramGiam > 0 && strtotime($currentDate) >= strtotime($ngayBatDau) && strtotime($currentDate) <= strtotime($ngayKetThuc)) {
                        $giaSauGiam = $giaGoc - ($giaGoc * $phanTramGiam / 100);
                        $giaMoi = number_format($giaSauGiam, 0, ',', '.');
                        $giaGocFormat = number_format($giaGoc, 0, ',', '.');

                    } else {
                        // Nếu không có khuyến mãi, chỉ hiển thị giá gốc
                        $giaMoi = number_format($giaGoc, 0, ',', '.');
                        $giaGocFormat = '';

                    }
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 w-100">
                            <a href="chitietsanpham.php?sp_ma=<?php echo $row['SP_MA']; ?>">

                                <img src="<?php echo !empty($row['SP_HINHANH']) ? $row['SP_HINHANH'] : 'default.jpg'; ?>"
                                    class="card-img-top" alt="Hình ảnh sản phẩm" width="200px" height="230px">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title text-center"><?php echo $row['SP_TEN']; ?></h6>

                                <!-- Hiển thị giá gốc với dấu gạch ngang nếu có khuyến mãi -->
                                <div class="d-flex justify-content-center" style="font-size: 11px;">
                                    <?php if ($phanTramGiam > 0 && $currentDate >= $ngayBatDau && $currentDate <= $ngayKetThuc) { ?>
                                        <span
                                            style="text-decoration: line-through; color: grey; margin-right: 10px;"><?php echo $giaGocFormat . ' VNĐ'; ?></span>
                                        <span style="color: red;"><strong
                                                style="color: red;"></strong><?php echo $giaMoi . ' VNĐ'; ?></span>
                                    <?php } else { ?>
                                        <span style="color: red;"><strong
                                                style="color: red;"></strong><?php echo $giaMoi . ' VNĐ'; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Không có sản phẩm nào.";
            }
            ?>
        </div>
        <h2 class="text-center my-5">Sản phẩm có giá tốt nhất </h2>
        <div class="row">
    <?php
    // Kết nối cơ sở dữ liệu
    $sql = "SELECT * FROM sanpham sp 
            LEFT JOIN KM_SP km ON sp.SP_MA = km.SP_MA 
            LEFT JOIN khuyenmai k ON k.KM_MA = km.KM_MA
            LEFT JOIN giasp g ON g.SP_MA = sp.SP_MA
            ORDER BY KM_GTRI DESC LIMIT 6";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $giaGoc = $row['GSP_DONGIA'];
            $phanTramGiam = $row['KM_GTRI'];
            $ngayBatDau = $row['KM_TGBD'];
            $ngayKetThuc = $row['KM_TGKT'];
            $currentDate = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại

            // Kiểm tra xem sản phẩm có khuyến mãi và trong thời gian khuyến mãi hay không
            if ($phanTramGiam > 0 && strtotime($currentDate) >= strtotime($ngayBatDau) && strtotime($currentDate) <= strtotime($ngayKetThuc)) {
                $giaSauGiam = $giaGoc - ($giaGoc * $phanTramGiam / 100); // Tính giá sau khuyến mãi
                $giaMoi = number_format($giaSauGiam, 0, ',', '.'); // Định dạng giá mới
                $giaGocFormat = number_format($giaGoc, 0, ',', '.'); // Định dạng giá gốc
            } else {
                // Nếu không có khuyến mãi, chỉ hiển thị giá gốc
                $giaMoi = number_format($giaGoc, 0, ',', '.');
                $giaGocFormat = ''; // Không hiển thị giá gốc khi không có khuyến mãi
            }
    ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="chitietsanpham.php?sp_ma=<?php echo $row['SP_MA']; ?>">
                        <img src="<?php echo !empty($row['SP_HINHANH']) ? $row['SP_HINHANH'] : 'default.jpg'; ?>"
                             class="card-img-top" alt="Hình ảnh sản phẩm" width="200px" height="230px">
                    </a>
                    <div class="card-body">
                        <h6 class="card-title text-center"><?php echo $row['SP_TEN']; ?></h6>

                        <!-- Hiển thị giá gốc với dấu gạch ngang nếu có khuyến mãi -->
                        <div class="d-flex justify-content-center" style="font-size: 11px;">
                            <?php if ($phanTramGiam > 0 && strtotime($currentDate) >= strtotime($ngayBatDau) && strtotime($currentDate) <= strtotime($ngayKetThuc)) { ?>
                                <span style="text-decoration: line-through; color: grey; margin-right: 10px;">
                                    <?php echo $giaGocFormat . ' VNĐ'; ?>
                                </span>
                                <span style="color: red;">
                                    <strong><?php echo $giaMoi . ' VNĐ'; ?></strong>
                                </span>
                            <?php } else { ?>
                                <span style="color: red;">
                                    <strong><?php echo $giaMoi . ' VNĐ'; ?></strong>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "Không có sản phẩm nào.";
    }
    ?>
</div>

    </div>

    <div class="container my-5">
        <div class="container my-5 py-4 bg-light rounded shadow">
            <div class="LichSuHinhThanh">
                <h2 class="text-center text-primary fw-bold mb-4">Lịch Sử Hình Thành</h2>
                <div class="px-4">
                    <p class="mb-4">
                        <strong>Shop Hoa Đà Lạt</strong> được thành lập vào năm 2024 với mục tiêu mang đến cho khách
                        hàng
                        những sản phẩm hoa tươi
                        đẹp và chất lượng nhất từ vùng đất Đà Lạt mộng mơ. Khởi nguồn từ niềm đam mê với hoa và mong
                        muốn
                        chia sẻ vẻ đẹp của thiên nhiên,
                        chúng tôi đã bắt đầu hành trình cung cấp các loại hoa tươi, từ những bông hoa hồng quyến rũ,
                        hoa
                        lan
                        thanh lịch đến các loại hoa dã quỳ rực rỡ.
                    </p>
                    <p class="mb-4">
                        Với sự phát triển của nền tảng công nghệ và xu hướng mua sắm trực tuyến, Shop Hoa Đà Lạt đã
                        nhanh
                        chóng
                        mở rộng và áp dụng công nghệ để mang đến dịch vụ giao hàng hoa tươi tận nơi. Chúng tôi tự
                        hào là
                        một
                        trong những cửa hàng hoa trực tuyến hàng đầu tại Đà Lạt,
                        phục vụ đa dạng nhu cầu của khách hàng từ các buổi tiệc sinh nhật, lễ cưới cho đến những sự
                        kiện
                        quan trọng khác.
                    </p>
                    <p class="mb-4">
                        Chúng tôi cam kết cung cấp các sản phẩm hoa chất lượng cao, được chăm sóc và chọn lọc kỹ
                        lưỡng
                        từ
                        những nông trại uy tín tại Đà Lạt.
                        Đội ngũ nhân viên tận tâm và chuyên nghiệp của chúng tôi luôn sẵn sàng tư vấn và hỗ trợ để
                        mỗi
                        khách
                        hàng có được trải nghiệm mua sắm hoàn hảo nhất.
                    </p>
                    <p class="mb-0">
                        Hãy đến với <strong>Shop Hoa Đà Lạt</strong> để trải nghiệm sự tươi mới và rực rỡ của những
                        bông
                        hoa, và cùng chúng tôi lan tỏa niềm vui đến với những người thân yêu!
                    </p>
                </div>
            </div>
            <div class="container my-5 py-4 bg-light rounded shadow">
                <div class="VeChungToi">
                    <h2 class="text-center text-primary fw-bold mb-4">Về Chúng Tôi</h2>
                    <div class="px-4">
                        <div class="container my-5">
                            <div class="row">
                                <!-- Cột bên trái -->
                                <div class="col-md-6 bg-light p-4">
                                    <h2 class="text-dark fw-bold">Sứ mệnh của chúng tôi</h2>


                                    <p>Sứ mệnh của chúng tôi là mang đến những bông hoa tươi đẹp nhất từ Đà Lạt đến
                                        với
                                        mọi
                                        người, mọi nhà. Chúng tôi luôn nỗ lực để đảm bảo chất lượng từng bông hoa,
                                        giúp
                                        khách
                                        hàng cảm nhận được vẻ đẹp tự nhiên tinh khiết từ những vườn hoa trứ danh.
                                        Không
                                        chỉ là
                                        cung cấp hoa, chúng tôi mong muốn lan tỏa niềm vui và những cảm xúc đặc biệt
                                        thông qua
                                        mỗi bó hoa, để mỗi món quà hoa tươi đều mang theo sự chân thành và ý nghĩa
                                        sâu
                                        sắc.</p>


                                </div>

                                <!-- Cột bên phải -->
                                <div class="col-md-6 bg-danger p-4 text-white">
                                    <h2 class="fw-bold">Giá trị của chúng tôi</h2>
                                    <p>Giá trị của chúng tôi được xây dựng dựa trên sự tận tâm, chất lượng, và sự
                                        sáng
                                        tạo trong
                                        từng sản phẩm hoa. Chúng tôi tin rằng mỗi bông hoa đều có câu chuyện riêng
                                        và
                                        đáng được
                                        trân trọng. Sự hài lòng của khách hàng luôn là ưu tiên hàng đầu, vì vậy
                                        chúng
                                        tôi không
                                        ngừng cải tiến dịch vụ và quy trình chăm sóc hoa để mang đến trải nghiệm tốt
                                        nhất. Shop
                                        Hoa Đà Lạt cam kết mang lại giá trị vượt trội, giúp khách hàng dễ dàng lựa
                                        chọn
                                        món quà
                                        hoa phù hợp cho mọi dịp, từ những khoảnh khắc giản dị đến các sự kiện quan
                                        trọng.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="TaiSaoNenChon py-5">
                    <h2 class="text-center text-primary fw-bold mb-4">Tại sao nên chọn chúng tôi?</h2>
                    <div class="row text-center">
                        <div class="col-md-4 mb-4">
                            <img src="product/icon-cam-ket-giong-mau.png" alt="Cam kết giống mẫu" width="100px"
                                height="100px" class="mb-2">
                            <h5 class="fw-bold">Giống mẫu 100%</h5>
                            <p>Chúng tôi đảm bảo sản phẩm giống mẫu với cam kết chất lượng cao nhất.</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <img src="product/icon-cam-ket-uy-tin.png" alt="Cam kết uy tín" width="100px" height="100px"
                                class="mb-2">
                            <h5 class="fw-bold">Uy tín hàng đầu</h5>
                            <p>Chúng tôi xây dựng niềm tin qua chất lượng sản phẩm và dịch vụ tận tâm.</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <img src="product/icon-ccam-ket-giao-hang-nhanh.png" alt="Cam kết giao hàng nhanh"
                                width="100px" height="100px" class="mb-2">
                            <h5 class="fw-bold">Giao hàng nhanh chóng</h5>
                            <p>Cam kết giao hàng đúng giờ, đảm bảo sản phẩm đến tay khách hàng kịp thời.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



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








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="js.js"></script>
</body>

</html>