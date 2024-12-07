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
    <title>Sản Phẩm</title>
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

<!-- noi dung  -->
<section class="vh-70 bg-image mt-3"
    style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card" style="border-radius: 15px; max-width: 90%; margin: auto;">
                        <div class="card-body p-4">
                            <h2 class="text-uppercase text-center mb-4">Tạo Tài Khoản</h2>

                            <form  onsubmit="Register(event)" id="DangKy" action="sulydangky.php" method="post" enctype="multipart/form-data"
                               >

                                <div id="general_error" class="text-danger text-center"></div>

                                <div class="form-outline mb-3">
                                    <div id="error_name" class="text-danger fst-italic"></div>
                                    <label for="name">Họ Tên</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_email" class="text-danger fst-italic"></div>
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_address" class="text-danger fst-italic"></div>
                                    <label for="diachi">Địa Chỉ</label>
                                    <input type="text" id="diachi" name="diachi" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_sdt" class="text-danger fst-italic"></div>
                                    <label for="sdt">Số Điện Thoại</label>
                                    <input type="tel" id="sdt" name="Sodienthoai"
                                        class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_username" class="text-danger fst-italic"></div>
                                    <label for="username">Tên Đăng Nhập</label>
                                    <input type="text" id="username" name="username"
                                        class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_password" class="text-danger fst-italic"></div>
                                    <label for="password">Mật Khẩu</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <div id="error_repeatPassword" class="text-danger fst-italic"></div>
                                    <label for="repeatPassword">Nhập Lại Mật Khẩu</label>
                                    <input type="password" id="repeatPassword" name="repeatPassword"
                                        class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="file" id="avatar" name="avatar" class="form-control form-control-lg" />
                                    <label for="avatar">Ảnh đại diện</label>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Đăng Ký</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







</div>


<!-- CHAN TRANG -->
<!-- Footer -->
<section class="mt-5">
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





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9gybEV/6oyA6oxkYj04S/2I5hXAw9z6LwHE2spWzJ8MRKq+K8mZ"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-1GfP9AmA2KxhPQO4h4FTt05A8zjNkfWniP63Ih2xw5VOlktqWGGp4DNF4ZgjVr63"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="JS.js"></script>
</body>

</html>