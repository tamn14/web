<?php
session_start();

$ten = $_SESSION['name'];
echo $ten; 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Dat hang</title>
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
    <div class="container mb-5">
        <div class="row">
            <!-- Left Section: Order Form -->
            <div class="col-12 col-md-12">
                <section class="container mt-5">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <h3 class="text-center mb-4">Thông tin đơn hàng</h3>
                                    <form onsubmit="formDatHang(event)" action="sulydathang.php" method="post" id = "DatHang"  enctype="multipart/form-data">
                                        <!-- Customer Information -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div id="error_name" class="text-danger fst-italic">
                                                    <?php
                                                    // if (isset($_SESSION['error_n'])) {
                                                    //     echo $_SESSION['error_n'];
                                                    //     unset($_SESSION['error_n']);
                                                    // }
                                                    ?>
                                                </div>
                                                <label for="inputName" class="form-label">Họ tên</label>
                                                <input type="text" id="name" class="form-control form-control-lg"
                                                    name="inputName" style="font-size: 18px;" placeholder="Nhập tên"
                                                    value="<?php echo $_SESSION['name']  ?>"
                                                    >
                                            </div>
                                            <div class="col-md-6">
                                                <div id="error_sdt" class="text-danger fst-italic"> <?php
                                                // if (isset($_SESSION['error_s'])) {
                                                //     echo $_SESSION['error_s'];
                                                //     unset($_SESSION['error_s']);
                                                // }
                                                ?></div>
                                                <label for="inputPhone" class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" id="inputPhone" name="inputPhone"
                                                    placeholder="Nhập số điện thoại">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div id="error_email" class="text-danger fst-italic"><?php
                                            // if (isset($_SESSION['error_e'])) {
                                            //     echo $_SESSION['error_e'];
                                            //     unset($_SESSION['error_e']);
                                            // }
                                            ?></div>
                                            <label for="inputEmail" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="inputEmail" name="inputEmail"
                                                placeholder="Nhập email">
                                        </div>

                                        <!-- Delivery Address -->
                                        <div class="mb-4">
                                            <div id="error_address" class="text-danger fst-italic"><?php
                                            // if (isset($_SESSION['error_a'])) {
                                            //     echo $_SESSION['error_a'];
                                            //     unset($_SESSION['error_a']);
                                            // }
                                            ?></div>
                                            <label for="inputAddress" class="form-label">Địa chỉ nhận hàng</label>
                                            <input type="text" class="form-control" id="inputAddress"
                                                name="inputAddress"
                                                placeholder="Vui lòng điền chi tiết địa chỉ nhận hàng">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label" for="CiTy">Chọn Tỉnh/Thành Phố</label>
                                            <select class="form-select" id="CiTy" name="CiTy">
                                                <option value="Cần Thơ" selected>Cần Thơ</option>
                                                <option value="Hậu Giang">Hậu Giang</option>
                                            </select>
                                        </div>

                                        <!-- Payment Method -->
                                        <div class="mb-4">
                                            <label class="form-label">Phương thức thanh toán</label>
                                            <div class="form-check">

                                                <input class="form-check-input" type="radio" name="paymentMethod"
                                                    id="paymentCOD" value="Thanh toán khi nhận hàng" checked>
                                                <label class="form-check-label" for="paymentCOD">Thanh toán khi nhận
                                                    hàng
                                                    (COD)</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMethod"
                                                    id="paymentOnline" value="Thanh toán chuyển khoản">
                                                <label class="form-check-label" for="paymentOnline">Thanh toán chuyển
                                                    khoản</label>
                                            </div>
                                        </div>

                                        <!-- Shipping Method -->
                                        <!-- <div class="mb-4">
                                            <label class="form-label" for="shippingMethod">Chọn nhà vận chuyển</label>
                                            <select class="form-select" id="shippingMethod" name="shippingMethod">
                                                <option value="Giao hàng nhanh" selected>Giao hàng nhanh</option>
                                                <option value="Giao hàng tiết kiệm">Giao hàng tiết kiệm</option>
                                            </select>
                                        </div> -->
                                        <div class="mb-4">
                                        <select class="form-control" id="shippingMethod" name="shippingMethod">
                                            <?php
                                            include 'db.php';
                                            $sql = "SELECT DISTINCT NVC_MA, NVC_TEN FROM nhavanchuyen";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['NVC_MA'] . '" ' . $selected . '>'  . $row['NVC_TEN'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">Không có nhà phân phối nào</option>';
                                            }
                                            ?>
                                        </select>
                                        </div>


                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Đặt Hàng Ngay</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        </div>


        <!-- Footer -->
        <section class="">
            <!-- Footer -->
            <footer class="bg-body-tertiary text-center">
                <!-- Grid container -->
                <div class="container p-4">
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
                                    <a href="#!" class="text-body"> Trang chủ</a>
                                </li>
                                <li>
                                    <a href="#!" class="text-body">Tin tức</a>
                                </li>
                                <li>
                                    <a href="#!" class="text-body">Liên hệ </a>
                                </li>

                            </ul>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-0">Thời gian làm việc </h5>

                            <ul class="list-unstyled">
                                <li>
                                    <a href="#!" class="text-body">Sáng : 6 giờ đến 12 giờ</a>
                                </li>
                                <li>
                                    <a href="#!" class="text-body">Chiều : 13 giờ 30 đến 21 giờ </a>
                                </li>


                        </div>

                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
    </div>
    <!-- Grid container -->


    </footer>
    <!-- Footer -->
    </section>


    <!-- End footer -->

    <script src="JS.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybEV/6oyA6oxkYj04S/2I5hXAw9z6LwHE2spWzJ8MRKq+K8mZ"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-1GfP9AmA2KxhPQO4h4FTt05A8zjNkfWniP63Ih2xw5VOlktqWGGp4DNF4ZgjVr63"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>