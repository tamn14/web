<?php
session_start();
include 'db.php';

// Get search query and filter parameters from the GET request
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
$hoaTuoi = isset($_GET['hoaTuoi']) ? 1 : 0; // Hoa Tươi
$hoaGiay = isset($_GET['Hoahandmade']) ? 1 : 0; // Hoa Giấy
$priceRange = isset($_GET['priceRange']) ? $_GET['priceRange'] : '';

// Build the base SQL query with prepared statements to prevent SQL injection
$sql = "SELECT * FROM sanpham sp 
        LEFT JOIN KM_SP km ON sp.SP_MA = km.SP_MA 
        LEFT JOIN khuyenmai k ON k.KM_MA = km.KM_MA
        LEFT JOIN giasp g ON g.SP_MA = sp.SP_MA
        LEFT JOIN loaisp l ON l.LSP_MA = sp.LSP_MA WHERE 1";

// Add filtering based on search query (product name or description)
if (!empty($searchQuery)) {
    $sql .= " AND (sp.SP_TEN LIKE ? )";
}

// Add category filter (Hoa Tươi, Hoa Giấy)
if ($hoaTuoi && $hoaGiay) {
    $sql .= " AND (l.LSP_TEN = 'hoa tươi' OR l.LSP_TEN = 'Hoa handmade')";
} elseif ($hoaTuoi) {
    $sql .= " AND l.LSP_TEN = 'hoa tươi'";
} elseif ($hoaGiay) {
    $sql .= " AND l.LSP_TEN = 'Hoa handmade'";
}




// Add price filter based on selected price range
switch ($priceRange) {
    case 'under300k':
        $sql .= " AND g.GSP_DONGIA * (1 - (COALESCE(k.KM_GTRI, 0) / 100)) < 300000";
        break;
    case 'under600k':
        $sql .= " AND g.GSP_DONGIA * (1 - (COALESCE(k.KM_GTRI, 0) / 100)) < 600000";
        break;
    case 'above600k':
        $sql .= " AND g.GSP_DONGIA * (1 - (COALESCE(k.KM_GTRI, 0) / 100)) >= 600000";
        break;
}

// Prepare the statement to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind parameters for search query (to avoid direct input in SQL query)
if (!empty($searchQuery)) {
    $searchParam = "%$searchQuery%";
    $stmt->bind_param("s", $searchParam);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Search</title>
</head>

<body>

    <!-- Navbar -->
    <div class="top-navbar mt-2 d-flex justify-content-between align-items-center px-4 py-2 shadow-sm"
        style="background-color: #f8f9fa;">
        <div class="top-icons d-flex gap-3">
            <img src="product/facebook.png" alt="Facebook" width="20px" style="cursor: pointer;">
            <img src="product/tiktok.png" alt="TikTok" width="20px" style="cursor: pointer;">
            <img src="product/youtube.png" alt="YouTube" width="20px" style="cursor: pointer;">
        </div>
        <div class="logo">
            <a href="trangchu.php" class="text-decoration-none font-weight-bold text-dark"
                style="font-size: 24px;">ShopHoaDaLat</a>
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
                    <?php echo isset($_SESSION['giohang']) ? count($_SESSION['giohang']) : 0; ?>
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

    <!-- Main Content -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="TrangChu.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="VeChungToi.php">Về chúng tôi</a></li>
                    <li class="nav-item"><a class="nav-link" href="sanpham.php">Sản Phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="Lienhe.php">Liên Hệ</a></li>
                </ul>
                <form class="d-flex" role="search" action="search.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" name="query"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Search Results -->
    <div class="container mt-5 col-8">
        <div class="col-8">
            <div class="row">
                <?php
                // Display the filtered products
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $giaGoc = $row['GSP_DONGIA'];
                        $phanTramGiam = $row['KM_GTRI'];
                        $ngayBatDau = $row['KM_TGBD'];
                        $ngayKetThuc = $row['KM_TGKT'];
                        $currentDate = date('Y-m-d H:i:s');

                        // Tính giá sau giảm giá
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
                                    <div class="d-flex justify-content-center" style="font-size: 13px;">
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