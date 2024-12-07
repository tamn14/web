<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <div class="logo m-3"><a href="trangchu.php">ShopHoaDaLat</a></div>
                                        <h4 class="mt-1 mb-5 pb-1">Chúng tôi là shop hoa đà lạt </h4>
                                    </div>

                                    <?php
                                    session_start();
                                    if (isset($_SESSION['error_message'])): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $_SESSION['error_message']; ?>
                                        </div>
                                        <?php unset($_SESSION['error_message']); ?>
                                    <?php endif; ?>

                                    <form id="login" action="sulylogin.php" method="post"
                                        onsubmit="return login(event)">
                                        <p>Please login to your account</p>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <div id="error_username" class="text-danger fst-italic"></div>
                                            <input type="text" id="username" class="form-control"
                                                placeholder="Vui lòng nhập tên đang nhập " name="username" />

                                            <label class="form-label" for="username">Username</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <div id="error_password" class="text-danger fst-italic"></div>
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Vui lòng nhập mật khẩu " />

                                            <label class="form-label" for="password">Password</label>
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 "
                                                type="submit">Đăng nhập
                                            </button>
                                            <!-- <a class="text-muted" href="#!">Quên mật khẩu?</a> -->
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Bạn chưa có tài khoản?</p>
                                            <a href="DangKy.php">
                                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-outline-danger">Create new
                                                </button>
                                            </a>
                                        </div>
                                    </form>


                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Chúng tôi có những thứ mà bạn cần</h4>
                                    <p class="small mb-0">Chào mừng bạn đến với Shop Hoa Đà Lạt - nơi vẻ đẹp thiên nhiên
                                        hội
                                        tụ trong từng cánh hoa! Với niềm đam mê và tâm huyết, chúng tôi mang đến cho
                                        khách
                                        hàng những bó hoa tươi thắm, rực rỡ sắc màu được chọn lọc kỹ lưỡng từ vùng đất
                                        Đà
                                        Lạt mộng mơ. Tại Shop Hoa Đà Lạt, bạn sẽ tìm thấy sự đa dạng về chủng loại hoa
                                        từ
                                        hoa hồng, hoa ly, cẩm tú cầu, đến các loài hoa độc đáo chỉ có ở Đà Lạt. Chúng
                                        tôi
                                        luôn cam kết chất lượng hoa tươi mới mỗi ngày, cùng dịch vụ giao hoa tận nơi
                                        nhanh
                                        chóng, chu đáo, mang đến niềm vui và những khoảnh khắc ý nghĩa cho bạn và người
                                        thân
                                        yêu. Hãy để Shop Hoa Đà Lạt làm cầu nối gửi gắm tình yêu thương qua những đóa
                                        hoa
                                        tươi thắm nhất!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="JS.js"></script>
</body>

</html>