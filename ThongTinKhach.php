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
    <title>Thong tin khach</title>
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
                <img src="product/shopping-card.png"  alt="Giỏ hàng" width="25px" style="cursor: pointer;" style = "color: black;">
                <sub class="cart-count" id = "cart-count" >0</sub>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="sanpham.php" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="sanpham.php">Hoa tươi</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="sanpham.php">Hoa giấy</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="tintuc.php">Tin Tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="Lienhe.php">Liên Hệ</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-5 col-6">
        <h4 class="text-center m-5">Thông tin mua hàng</h4>
        <form>
            <!-- Họ tên -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="name">Họ tên:</label>
                <div class="col-8">
                    <input type="text" id="name" class="form-control" name="name" />
                </div>
            </div>

            <!-- Số điện thoại -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="phone">Số điện thoại:</label>
                <div class="col-8">
                    <input type="text" id="phone" class="form-control" />
                </div>
            </div>

            <!-- Địa chỉ -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="address">Địa chỉ:</label>
                <div class="col-8">
                    <input type="text" id="address" class="form-control" />
                </div>
            </div>

            <!-- Địa chỉ nhận hàng -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="address_recieve">Địa chỉ nhận hàng:</label>
                <div class="col-8">
                    <input type="text" id="address_recieve" class="form-control" />
                </div>
            </div>

            <!-- Email -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="email">Email:</label>
                <div class="col-8">
                    <input type="email" id="email" class="form-control" />
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="inputState">Phương thức thanh toán:</label>
                <div class="col-8">
                    <select id="inputState" class="form-select">
                        <option selected>Chọn phương thức thanh toán</option>
                        <option value="thanhtoankhinhan" id="thanhtoankhinhan">Thanh toán khi nhận hàng</option>
                        <option value="the" id="the">Thanh toán bằng thẻ ngân hàng</option>
                    </select>
                </div>
            </div>

            <!-- Nhà vận chuyển -->
            <div class="row mb-3 align-items-center">
                <label class="col-4 form-label" for="shipping">Nhà vận chuyển:</label>
                <div class="col-8">
                    <input type="text" id="shipping" class="form-control" />
                </div>
            </div>

            <!-- Ghi chú -->
            <div class="row mb-3 align-items-start">
                <label class="col-4 form-label" for="form6Example7">Ghi chú:</label>
                <div class="col-8">
                    <textarea class="form-control" id="form6Example7" rows="4"></textarea>
                </div>
            </div>

            <!-- Nút mua -->
            <div class="row m-5">
            <div class="col-12 d-flex justify-content-end">
                <button data-mdb-ripple-init type="button" class="btn btn-success col-2">Mua</button>
            </div>
        </div>
        </form>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/js.js"></script>
</body>

</html>