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

<div class="container-fluid col-8">
    <div class="row">
        <div class="col-12">
            <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <!-- <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"
                            aria-label="Slide 3"></button> -->
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="product/slider-02.jpg" alt="" height="400px" width="100%">
                        <div class="container">
                            <div class="carousel-caption text-start">


                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="product/slider3.jpg" alt="" height="400px" width="100%">
                        <div class="container">
                            <div class="carousel-caption text-end">

                                <p><a class="btn btn-lg btn-primary" href="DangKy.php">Đăng ký ngay</a></p>
                            </div>
                        </div>
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
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <!-- Danh sách hoa -->
                <ul class="list-group">
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hồng">Hoa hồng</a></li>
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20candy">Hoa candy</a>
                    </li>
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20cam%20tu%20cau">Hoa cẩm
                            tú cầu</a></li>
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20huong%20duong">Hoa
                            hướng dương</a></li>
                    <!-- <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20mau%20don">Hoa mẫu
                            đơn</a></li> -->
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20sen">Hoa sen</a></li>
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20baby">Hoa baby</a></li>
                    <li class="list-group-item"><a class="nav-link" href="search.php?query=hoa%20ly">Hoa ly</a></li>
                </ul>
                <form method="get" action="search.php">
                    <h4 class="mt-3">Thể Loại</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hoaTuoi" name="hoaTuoi" checked>
                        <label class="form-check-label" for="hoaTuoi">Hoa tươi</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hoaGiay" name="Hoahandmade">
                        <label class="form-check-label" for="hoaGiay">Hoa Giấy</label>
                    </div>

                    <h4 class="mt-3">Giá</h4>
                    <div class="form-group">
                        <label for="priceRange">Chọn khoảng giá:</label>
                        <select class="form-control" id="priceRange" name="priceRange">
                            <option value="under300k">Dưới 300.000</option>
                            <option value="under600k">Dưới 600.000</option>
                            <option value="above600k">Trên 600.000</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary"> Lọc</button>
                </form>



            </div>
            <div class="col-9">
                <div class="row">
                    <?php
                    $records_per_page = 6;
                    // Xác định trang hiện tại
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start_from = ($page - 1) * $records_per_page;

                    include 'db.php';

                    // Truy vấn tổng số bản ghi trong bảng
                    $sql = "SELECT COUNT(*) AS total_records FROM sanpham";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $total_records = $row['total_records'];

                    // Truy vấn các sản phẩm có phân trang
                    $sql = "SELECT * FROM sanpham sp 
                LEFT JOIN KM_SP km ON sp.SP_MA = km.SP_MA 
                LEFT JOIN khuyenmai k ON k.KM_MA = km.KM_MA
                LEFT JOIN giasp g ON g.SP_MA = sp.SP_MA
                LIMIT $start_from, $records_per_page";
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
                                $giaMoi = number_format($giaGoc, 0, ',', '.');
                                $giaGocFormat = '';
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
                                        <div class="d-flex justify-content-center" style="font-size: 13px;">
                                            <?php if ($phanTramGiam > 0 && strtotime($currentDate) >= strtotime($ngayBatDau) && strtotime($currentDate) <= strtotime($ngayKetThuc)) { ?>
                                                <span
                                                    style="text-decoration: line-through; color: grey; margin-right: 10px;"><?php echo $giaGocFormat . ' VNĐ'; ?></span>
                                                <span style="color: red;"><strong><?php echo $giaMoi . ' VNĐ'; ?></strong></span>
                                            <?php } else { ?>
                                                <span style="color: red;"><strong><?php echo $giaMoi . ' VNĐ'; ?></strong></span>
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

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    <div class="pagination">
                        <?php
                        $total_pages = ceil($total_records / $records_per_page);
                        if ($page > 1) {
                            echo "<a href='?page=" . ($page - 1) . "' class='btn btn-primary'>Trước</a>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo "<span class='btn btn-secondary'>$i</span>";
                            } else {
                                echo "<a href='?page=$i' class='btn btn-light'>$i</a>";
                            }
                        }
                        if ($page < $total_pages) {
                            echo "<a href='?page=" . ($page + 1) . "' class='btn btn-primary'>Sau</a>";
                        }
                        ?>
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
<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementsByClassName("max-value")[0];
    output.innerHTML = slider.value;

    slider.oninput = function () {
        output.innerHTML = this.value;
    }
</script>
</body>

</html>