<?php
session_start();
include 'db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
  
    // Pagination setup
    $records_per_page = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_from = ($page - 1) * $records_per_page;

    // Query to get the total number of records for pagination
    $sql = "SELECT COUNT(*) AS total_records FROM ChitietHD WHERE HD_MA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];

    // Query to get products with pagination
    $sql = "SELECT * FROM ChitietHD hd
                LEFT JOIN SanPham s ON s.SP_MA = hd.SP_MA
                LEFT JOIN km_sp km on km.SP_MA = s.SP_MA
                LEFT JOIN khuyenmai k on k.KM_MA = km.KM_MA
                LEFT JOIN LoaiSP l ON l.LSP_MA = s.LSP_MA
                            WHERE hd.HD_MA = ? LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $id, $start_from, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();




    

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <style>
        table {
            table-layout: fixed;
            width: 100%;
        }

        td:nth-child(3) {
            word-wrap: break-word;
            white-space: normal;
            overflow: hidden;
            max-width: 250px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
        }

        .actions button {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="main-panel container col-10 mt-5">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home-tab">
                        <h3 class="text-center mb-4">Chi Tiết Hóa Đơn</h3>
                        <table id="example" class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Loại sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Khuyến mãi</th>
                                   
                                    <th>Số lượng Mua</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["SP_TEN"] . "</td>";
                                        echo "<td>" . $row["LSP_TEN"] . "</td>";
                                        echo "<td><img src='" . $row["SP_HINHANH"] . "' alt='" . $row["SP_TEN"] . "' class='img-fluid rounded-circle' style='width: 50px; height: 50px;' /></td>";
                                        echo "<td class='text-wrap'>" . $row["SP_TEN"] . "</td>";
                                        echo "<td>" . $row["KM_GTRI"] . "</td>";
                                        
                                        echo "<td>" . $row["CTHD_SLB"] . "</td>";
                                        echo "<td>" . number_format($row["CTHD_DONGIA"], 0, ',', '.') . " VND</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Không có sản phẩm nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Pagination Controls -->
                        <div class="pagination d-flex justify-content-center mt-4">
                            <?php
                            $total_pages = ceil($total_records / $records_per_page);
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo "<a href='?id=$id&page=$i' class='btn btn-sm btn-primary mx-1'>$i</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Close statement and connection
    $stmt->close();
    $conn->close();
    ?>

    <!-- Include JavaScript files -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="js.js"></script>
</body>

</html>
