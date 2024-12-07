<?php
session_start();
include 'db.php';

$sql1 = " SELECT COUNT(*) AS total_records FROM hoadon";
$result = $conn->query($sql1);
$row = $result->fetch_assoc();
$total_records = $row['total_records'];


$sql2 = " SELECT sum(HD_TONGTIEN) AS tongtien FROM hoadon";
$result = $conn->query($sql2);
$row = $result->fetch_assoc();
$tongtien = $row['tongtien'];


$sql3 = "WITH SoLuongBan AS (
    SELECT s.SP_TEN, SUM(c.CTHD_SLB) AS TongSoLuong
    FROM CHITIETHD c
    JOIN SANPHAM s ON c.SP_MA = s.SP_MA
    GROUP BY s.SP_TEN
)
SELECT SP_TEN, TongSoLuong
FROM SoLuongBan
WHERE TongSoLuong = (SELECT MAX(TongSoLuong) FROM SoLuongBan);
";
$result = $conn->query($sql3);
$row = $result->fetch_assoc();
$max = $row['SP_TEN'];


$sql4 = "WITH SoLuongBan AS (
    SELECT s.SP_TEN, SUM(c.CTHD_SLB) AS TongSoLuong
    FROM CHITIETHD c
    JOIN SANPHAM s ON c.SP_MA = s.SP_MA
    GROUP BY s.SP_TEN
)
SELECT SP_TEN, TongSoLuong
FROM SoLuongBan
WHERE TongSoLuong = (SELECT MIN(TongSoLuong) FROM SoLuongBan);
";
$result = $conn->query($sql4);
$row = $result->fetch_assoc();
$min = $row['SP_TEN'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body class="with-welcome-text">
  <div class="container-scroller">
    <div class="row p-0 m-0 proBanner" id="proBanner">
      <div class="col-md-12 p-0 m-0">
        <div class="card-body card-body-padding px-3 d-flex align-items-center justify-content-between">
          <div class="ps-lg-3">
            <div class="d-flex align-items-center justify-content-between">
              <p class="mb-0 fw-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this
                template!</p>
              <a href="https://www.bootstrapdash.com/product/star-admin-pro/" target="_blank"
                class="btn me-2 buy-now-btn border-0">Buy Now</a>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <a href="https://www.bootstrapdash.com/product/star-admin-pro/"><i class="ti-home me-3 text-white"></i></a>
            <button id="bannerClose" class="btn border-0 p-0">
              <i class="ti-close text-white"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="admin.php">
            <img src="assets/images/logo.svg" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="admin.php">
            <img src="assets/images/logo-mini.svg" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Xin chào, <span
                class="text-black fw-bold"><?php echo $_SESSION['username'] ?></span></h1>
            <h3 class="welcome-sub-text">Một ngày mới tốt lành </h3>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">

          <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
              <span class="input-group-addon input-group-prepend border-right">
                <span class="icon-calendar input-group-text calendar-icon"></span>
              </span>
              <input type="text" class="form-control">
            </div>
          </li>
          <li class="nav-item">
          <form class="d-flex" role="search" action="search-ad.php" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </li>

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
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="admin.php">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Tổng quan</span>
            </a>
          </li>
          <li class="nav-item nav-category">Danh mục</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
              aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Quản lý danh mục</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="sanpham-ad.php">Sản phẩm</a></li>
                <li class="nav-item"> <a class="nav-link" href="hoadon-ad.php">Hóa đơn</a></li>
                <li class="nav-item"> <a class="nav-link" href="nhanvien-ad.php">Nhân Viên</a></li>
                <li class="nav-item"> <a class="nav-link" href="nhaphanphoi-ad.php">Nhà phân phối</a></li>
                <li class="nav-item"> <a class="nav-link" href="khuyenmai-ad.php">Khuyến mãi</a></li>
                <li class="nav-item"> <a class="nav-link" href="nhavanchuyen-ad.php">Nhà vận chuyển</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Kinh doanh</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="thongkedoanhthu.php">Thống kê doanh thu</a>
                </li>
              </ul>
            </div>
          
          </li>

        </ul>
      </nav>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                        aria-controls="overview" aria-selected="true">Overview</a>
                    </li>

                  </ul>
                  <div>

                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                          <div>
                            <p class="statistics-title">Tổng số đơn</p>
                            <h3 class="rate-percentage">
                              <?php echo $total_records ?>
                            </h3>

                          </div>
                          <div>
                            <p class="statistics-title">Sản phẩm bán nhiều nhất</p>
                            <h3 class="rate-percentage">
                              <?php echo $max ?>
                            </h3>

                          </div>
                          <div>
                            <p class="statistics-title">Sản phẩm bán ít nhất</p>
                            <h3 class="rate-percentage">
                              <?php echo $min ?>

                            </h3>

                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Tổng doanh thu</p>
                            <h3 class="rate-percentage">
                              <?php echo $tongtien ?>
                            </h3>
                            </h3>

                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="row mt-5">
                      <div class="col-sm-12">
                        <div class="home-tab">
                          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                            <ul class="nav nav-tabs" role="tablist">


                            </ul>
                            <div>
                           
                            </div>
                          </div>
                          <!-- Table for displaying products -->
                          <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                              <tr>
                                <th>Mã sản phẩm</th>
                                <th>Loại sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Giá niêm yết</th>
                                <th>Số lượng tồn kho</th>
                                <th>Hành động</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              // Số bản ghi trên mỗi trang
                              $records_per_page = 5;
                              // Xác định trang hiện tại
                              $page = isset($_GET['page']) ? $_GET['page'] : 1;
                              $start_from = ($page - 1) * $records_per_page;




                              // Truy vấn tổng số bản ghi trong bảng
                              $sql = "SELECT COUNT(*) AS total_records FROM SanPham";
                              $result = $conn->query($sql);
                              $row = $result->fetch_assoc();
                              $total_records = $row['total_records'];

                              // Truy vấn lấy dữ liệu sản phẩm với phân trang
                              $sql = " SELECT * FROM sanpham s
                              JOIN loaisp l  ON l.LSP_MA = s.LSP_MA 
                              JOIN giasp g ON g.SP_MA = s.SP_MA  LIMIT $start_from, $records_per_page";
                              $result = $conn->query($sql);

                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  $sp_ma = $row["SP_MA"];

                                  // Truy vấn lấy số lượng tồn kho
                                  $sql_kho = "SELECT COALESCE(SUM(k.SLthaydoi), 0) AS current_quantity
                                    FROM khohang k 
                                    WHERE k.SP_MA = ?";
                                  $stmt_kho = $conn->prepare($sql_kho);
                                  $stmt_kho->bind_param("s", $sp_ma);
                                  $stmt_kho->execute();
                                  $stmt_kho->bind_result($soluong_kho);
                                  $stmt_kho->fetch();
                                  $stmt_kho->close();

                                  // Hiển thị dữ liệu sản phẩm
                                  echo "<tr>";
                                  echo "<td>" . $row["SP_MA"] . "</td>";
                                  echo "<td>" . $row["LSP_TEN"] . "</td>";
                                  echo "<td><img src='" . $row["SP_HINHANH"] . "' alt='' style='width: 45px; height: 45px;' class='rounded-circle' /></td>";
                                  echo "<td class='text-wrap'>" . $row["SP_TEN"] . "</td>";
                                  echo "<td class='text-wrap'>" . $row["SP_MOTA"] . "</td>";
                                  echo "<td>" . number_format($row["GSP_DONGIA"], 0, ',', '.') . " VND</td>";
                                  echo "<td>" . $soluong_kho . "</td>";
                                  echo "<td>" . $soluong_kho . "</td>";
                                  echo "<td>";
                                  echo "<a href='edit_product.php?id=" . $row["SP_MA"] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i> Sửa</a> ";
                                  echo "<a href='delete_product.php?delete_id=" . $row["SP_MA"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sản phẩm này không?\")'><i class='bi bi-trash'></i> Xóa</a>";
                                  echo "</td>";
                                  echo "</tr>";
                                }
                              } else {
                                echo "<tr><td colspan='8' class='text-center'>Không có sản phẩm nào.</td></tr>";
                              }
                              // $stmt->close();
                              $conn->close();
                              ?>
                            </tbody>
                          </table>

                          <!-- Pagination -->
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

                          <!-- Form Thêm Sản Phẩm -->
                          <div class="container mt-5">
                            <div class="card shadow-sm">
                              <div class="card-header bg-primary text-white">
                                <div id="successs" class="text-danger fst-italic">
                                  <?php
                                  if (isset($_SESSION['success'])) {
                                    echo "<div class='alert alert-info'>" . $_SESSION['success'] . "</div>";
                                    unset($_SESSION['success']);
                                  }
                                  ?>

                                </div>

                              </div>

                            </div>
                          </div>


                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a
                href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from
              BootstrapDash.</span>
            <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © 2023. All rights
              reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/vendors/chart.js/chart.umd.js"></script>
  <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="assets/js/dashboard.js"></script>
  <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
  <!-- End custom js for this page-->
</body>

</html>