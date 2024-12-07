

/// file Login
function login(event) {
    event.preventDefault();
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var error_username = document.getElementById("error_username");
    var error_password = document.getElementById("error_password");

    var usernameValue = username.value;
    var passwordValue = password.value;
    var isValid = true;

    // Xóa thông báo lỗi cũ
    error_username.innerHTML = "";
    error_password.innerHTML = "";

    if (usernameValue.length === 0 || passwordValue.length === 0) {
        if (usernameValue.length === 0) {
            error_username.innerHTML = "Bạn chưa nhập username!";
            isValid = false;
        }
        if (passwordValue.length === 0) {
            error_password.innerHTML = "Bạn chưa nhập Password!";
            isValid = false;
        }
    }

    if (isValid) {
        document.getElementById("login").submit();
    }

    return isValid;
}


// file dang ky  

function Register(event) {
    console.log("JS file is loaded.");
    event.preventDefault();
    // clearErrors();

    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var diachi = document.getElementById("diachi").value;
    var sdt = document.getElementById("sdt").value;
    var password = document.getElementById("password").value;
    var repeatPassword = document.getElementById("repeatPassword").value;

    // Xóa lỗi trước khi kiểm tra
    document.getElementById("error_name").innerHTML = "";
    document.getElementById("error_email").innerHTML = "";
    document.getElementById("error_address").innerHTML = "";
    document.getElementById("error_sdt").innerHTML = "";
    document.getElementById("error_username").innerHTML = "";
    document.getElementById("error_password").innerHTML = "";
    document.getElementById("error_repeatPassword").innerHTML = "";

    var isValid = true;

    // Kiểm tra tên
    if (name.length === 0) {
        document.getElementById("error_name").innerHTML = "Bạn chưa nhập tên !!!";
        isValid = false;
    }

    // Kiểm tra email
    if (email.length === 0) {
        document.getElementById("error_email").innerHTML = "Bạn chưa nhập email !!!";
        isValid = false;
    } else {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            document.getElementById("error_email").innerHTML = "Email không hợp lệ (ví dụ: abc@example.com) !!!";
            isValid = false;
        }
    }

    // Kiểm tra địa chỉ
    if (diachi.length === 0) {
        document.getElementById("error_address").innerHTML = "Bạn chưa nhập địa chỉ !!!";
        isValid = false;
    }

    // Kiểm tra số điện thoại
    if (sdt.length === 0) {
        document.getElementById("error_sdt").innerHTML = "Bạn chưa nhập số điện thoại !!!";
        isValid = false;
    } else if (!/^\d{10,11}$/.test(sdt)) {
        document.getElementById("error_sdt").innerHTML = "Số điện thoại không hợp lệ (chỉ 10-11 chữ số) !!!";
        isValid = false;
    }

    // Kiểm tra tên đăng nhập
    if (username.length === 0) {
        document.getElementById("error_username").innerHTML = "Bạn chưa nhập tên đăng nhập !!!";
        isValid = false;
    }

    // Kiểm tra mật khẩu
    if (password.length === 0) {
        document.getElementById("error_password").innerHTML = "Bạn chưa nhập mật khẩu !!!";
        isValid = false;
    } else {
        var passwordPattern = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z0-9!@#$%^&*(),.?":{}|<>]{8,}$/;
        if (!passwordPattern.test(password)) {
            document.getElementById("error_password").innerHTML = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt !!!";
            isValid = false;
        }
    }

    // Kiểm tra mật khẩu nhập lại
    if (repeatPassword.length === 0) {
        document.getElementById("error_repeatPassword").innerHTML = "Bạn chưa nhập lại mật khẩu !!!";
        isValid = false;
    } else if (password !== repeatPassword) {
        document.getElementById("error_repeatPassword").innerHTML = "Mật khẩu không khớp !!!";
        isValid = false;
    }

    // Thiết lập lại dữ liệu nếu không hợp lệ
    if (!isValid) {
        // Giữ lại các giá trị hợp lệ trong form
        document.getElementById("name").value = name;
        document.getElementById("username").value = username;
        document.getElementById("email").value = email;
        document.getElementById("diachi").value = diachi;
        document.getElementById("sdt").value = sdt;
        document.getElementById("password").value = "";
        document.getElementById("repeatPassword").value = "";
        return;
    }

    
    document.getElementById("DangKy").submit();
}

function formDatHang(event) {
    console.log("JS file is loaded.");
    event.preventDefault();

    var name = document.getElementById("name").value;
    var email = document.getElementById("inputEmail").value;
    var diachi = document.getElementById("inputAddress").value;
    var sdt = document.getElementById("inputPhone").value;

    document.getElementById("error_name").innerHTML = "";
    document.getElementById("error_email").innerHTML = "";
    document.getElementById("error_address").innerHTML = "";
    document.getElementById("error_sdt").innerHTML = "";

    var isValid = true;
    if (name.length === 0) {
        document.getElementById("error_name").innerHTML = "Bạn chưa nhập tên !!!";
        isValid = false;
    }

    // Kiểm tra email
    if (email.length === 0) {
        document.getElementById("error_email").innerHTML = "Bạn chưa nhập email !!!";
        isValid = false;
    } else {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            document.getElementById("error_email").innerHTML = "Email không hợp lệ (ví dụ: abc@example.com) !!!";
            isValid = false;
        }
    }

    // Kiểm tra địa chỉ
    if (diachi.length === 0) {
        document.getElementById("error_address").innerHTML = "Bạn chưa nhập địa chỉ !!!";
        isValid = false;
    }

    if (sdt.length === 0) {
        document.getElementById("error_sdt").innerHTML = "Bạn chưa nhập số điện thoại !!!";
        isValid = false;
    } else if (!/^\d{10,11}$/.test(sdt)) {
        document.getElementById("error_sdt").innerHTML = "Số điện thoại không hợp lệ (chỉ 10-11 chữ số) !!!";
        isValid = false;
    }

    if (!isValid) {
        // Giữ lại các giá trị hợp lệ trong form
        document.getElementById("name").value = name;
        document.getElementById("email").value = email;
        document.getElementById("diachi").value = diachi;
        document.getElementById("sdt").value = sdt;
        return;
    }

    // Nếu form hợp lệ thì submit
    document.getElementById("DatHang").submit();






}

function themSanPham(event) {
    console.log("JS file is loaded.");
    event.preventDefault();
    // clearErrors();

    var name = document.getElementById("ten_sp").value;
    var gia = document.getElementById("SP_gia").value;
    var sl = document.getElementById("sl").value;
    var mota_sp = document.getElementById("mota_sp").value;
    var hinhanh_sp = document.getElementById("hinhanh_sp").value;
    var npp = document.getElementById("npp").value;
    var gianhap = document.getElementById("gianhap").value;


    document.getElementById("error_ten").innerHTML = "";
    document.getElementById("error_gia").innerHTML = "";
    document.getElementById("error_sl").innerHTML = "";
    document.getElementById("error_mota").innerHTML = "";
    document.getElementById("error_hinh").innerHTML = "";
    document.getElementById("error_npp").innerHTML = "";
    document.getElementById("error_gianhap").innerHTML = "";

    var isValid = true;

    // Kiểm tra tên
    if (name.length === 0) {
        document.getElementById("error_ten").innerHTML = "Bạn chưa nhập tên !!!";
        isValid = false;
    }

    // Kiểm tra email
    if (sl.length === 0) {
        document.getElementById("error_sl").innerHTML = "Bạn chưa nhập số lượng !!!";
        isValid = false;
    }

    // Kiểm tra địa chỉ
    if (gia.length === 0) {
        document.getElementById("error_gia").innerHTML = "Bạn chưa nhập giá !!!";
        isValid = false;
    }

    // Kiểm tra số điện thoại
    if (mota_sp.length === 0) {
        document.getElementById("error_mota").innerHTML = "Bạn chưa nhập mô tả !!!";
        isValid = false;
    } 
    // Kiểm tra tên đăng nhập
    if (hinhanh_sp.length === 0) {
        document.getElementById("error_hinh").innerHTML = "Bạn chưa nhập hình ảnh !!!";
        isValid = false;
    }

    // Kiểm tra mật khẩu
    if (npp.length === 0) {
        document.getElementById("error_npp").innerHTML = "Bạn chưa nhập nhà phân phối !!!";
        isValid = false;
    } 

    // Kiểm tra mật khẩu nhập lại
    if (gianhap.length === 0) {
        document.getElementById("error_gianhap").innerHTML = "Bạn chưa nhập giá nhập !!!";
        isValid = false;
    } 

    // Thiết lập lại dữ liệu nếu không hợp lệ
    if (!isValid) {
        // Giữ lại các giá trị hợp lệ trong form
        document.getElementById("ten_sp").value = name;
        document.getElementById("SP_gia").value = gia;
        document.getElementById("sl").value = sl;
        document.getElementById("mota_sp").value = mota_sp;
        document.getElementById("hinhanh_sp").value = hinhanh_sp;
        document.getElementById("npp").value = npp;
        document.getElementById("gianhap").value = gianhap;
        return;
    }

    
    document.getElementById("sanpham-ad").submit();
}

function formnhanvien(event) {
    console.log("JS file is loaded.");
    event.preventDefault();
  

    var name = document.getElementById("ten_nv").value;
    var diachi = document.getElementById("diachi").value;
    var sdt = document.getElementById("sdt").value;
    var email = document.getElementById("email").value;
    var hinhanh_nv = document.getElementById("hinhanh_nv").value;
    var tendangnhap = document.getElementById("tendangnhap").value;
    var mk = document.getElementById("mk").value;

    document.getElementById("error_nameNV").innerHTML = "";
    document.getElementById("error_diachiNV").innerHTML = "";
    document.getElementById("error_sdt").innerHTML = "";
  
    document.getElementById("error_email").innerHTML = "";
    document.getElementById("error_hinh").innerHTML = "";
    document.getElementById("error_tdn").innerHTML = "";
    document.getElementById("error_mk").innerHTML = "";

    var isValid = true;

    // Kiểm tra tên
    if (name.length === 0) {
        document.getElementById("error_nameNV").innerHTML = "Bạn chưa nhập tên !!!";
        isValid = false;
    }

    // Kiểm tra email
    if (email.length === 0) {
        document.getElementById("error_email").innerHTML = "Bạn chưa nhập email !!!";
        isValid = false;
    } else {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            document.getElementById("error_email").innerHTML = "Email không hợp lệ (ví dụ: abc@example.com) !!!";
            isValid = false;
        }
    }

    // Kiểm tra địa chỉ
    if (diachi.length === 0) {
        document.getElementById("error_diachiNV").innerHTML = "Bạn chưa nhập địa chỉ !!!";
        isValid = false;
    }

    // Kiểm tra số điện thoại
    if (sdt.length === 0) {
        document.getElementById("error_sdt").innerHTML = "Bạn chưa nhập số điện thoại !!!";
        isValid = false;
    } else if (!/^\d{10,11}$/.test(sdt)) {
        document.getElementById("error_sdt").innerHTML = "Số điện thoại không hợp lệ (chỉ 10-11 chữ số) !!!";
        isValid = false;
    }

    // Kiểm tra tên đăng nhập
    if (tendangnhap.length === 0) {
        document.getElementById("error_tdn").innerHTML = "Bạn chưa nhập tên đăng nhập !!!";
        isValid = false;
    }

    // Kiểm tra mật khẩu
    if (mk.length === 0) {
        document.getElementById("error_mk").innerHTML = "Bạn chưa nhập mật khẩu !!!";
        isValid = false;
    } else {
        var passwordPattern = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z0-9!@#$%^&*(),.?":{}|<>]{8,}$/;
        if (!passwordPattern.test(mk)) {
            document.getElementById("error_mk").innerHTML = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt !!!";
            isValid = false;
        }
    }

    if (hinhanh_nv.length === 0) {
        document.getElementById("error_hinh").innerHTML = "Bạn chưa nhập hình ảnh !!!";
        isValid = false;
    }

    

    // Thiết lập lại dữ liệu nếu không hợp lệ
    if (!isValid) {
        // Giữ lại các giá trị hợp lệ trong form
        document.getElementById("name").value = name;
        document.getElementById("diachi").value = diachi;
        document.getElementById("sdt").value = sdt;
        document.getElementById("email").value = email;
        document.getElementById("hinhanh_nv").value = hinhanh_nv;
        document.getElementById("tendangnhap").value = tendangnhap;
        document.getElementById("mk").value = mk;
        return;
    }

    
    document.getElementById("nhanvien-ad").submit();



}

function formnpp(event) {
    console.log("JS file is loaded.");
    event.preventDefault();
  

    var ma = document.getElementById("ma_km").value;
    var ten = document.getElementById("ma_sp").value;

    document.getElementById("error_ma_km").innerHTML = "";
    document.getElementById("error_sdt").innerHTML = "";

    var isValid = true;
    if (ma.length === 0) {
        document.getElementById("error_ma_km").innerHTML = "Bạn chưa nhập mã !!!";
        isValid = false;
    }
    if (ten.length === 0) {
        document.getElementById("error_sdt").innerHTML = "Bạn chưa nhập tên nhà phân phối !!!";
        isValid = false;
    }

    if (!isValid) {
        // Giữ lại các giá trị hợp lệ trong form
        document.getElementById("ma_km").value = ma;
        document.getElementById("ma_sp").value = ten;
       
        return;
    }

    
    document.getElementById("npp").submit();



}

function formKM(event) {
    console.log("JS file is loaded.");
    event.preventDefault();  // Ngừng form submit

    var makm = document.getElementById("ma_km").value;
    var maSP = document.getElementById("ma_sp").value;
    var tgbd = document.getElementById("tgbd").value;
    var tgkt = document.getElementById("tgkt").value;
    var gtkm = document.getElementById("gtkm").value;

    var isValid = true;

    document.getElementById("error_ma_km").innerHTML = "";
    document.getElementById("error_masp").innerHTML = "";
    document.getElementById("error_tgbd").innerHTML = "";
    document.getElementById("error_tgkt").innerHTML = "";
    document.getElementById("error_gtkm").innerHTML = "";

    if (makm.length === 0) {
        document.getElementById("error_ma_km").innerHTML = "Bạn chưa nhập mã khuyến mãi !!!";
        isValid = false;
    }

    if (maSP.length === 0) {
        document.getElementById("error_masp").innerHTML = "Bạn chưa nhập mã sản phẩm !!!";
        isValid = false;
    }

    if (new Date(tgkt) < new Date(tgbd)) {
        document.getElementById("error_tgkt").innerHTML = "Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.";
        isValid = false;
    }

    if (gtkm < 0 || gtkm > 100) {
        document.getElementById("error_gtkm").innerHTML = "Giá trị giảm giá phải từ 0 đến 100.";
        isValid = false;
    }

    if (!isValid) {
        return;
    }

    document.getElementById("km").submit();
}


function formNVC(event) {
    console.log("JS file is loaded.");
    event.preventDefault();  // Ngừng form submit

    var maNVC = document.getElementById("ma_km").value;
    var TenNVC = document.getElementById("ma_sp").value;
    var ma_khuvuc = document.getElementById("ma_khuvuc").value;
    var phi = document.getElementById("ma_phi").value;
    
    var isValid = true;

    document.getElementById("error_Ma").innerHTML = "";
    document.getElementById("error_TVC").innerHTML = "";
    document.getElementById("error_khuvuc").innerHTML = "";
    document.getElementById("error_phi").innerHTML = "";

    if (maNVC.length === 0) {
        document.getElementById("error_Ma").innerHTML = "Bạn chưa nhập mã nhà vận chuyển !!!";
        isValid = false;
    }

    if (TenNVC.length === 0) {
        document.getElementById("error_TVC").innerHTML = "Bạn chưa nhập tên nhà vận chuyển !!!";
        isValid = false;
    }
    if (ma_khuvuc.length === 0) {
        document.getElementById("error_khuvuc").innerHTML = "Bạn chưa nhập khu vực !!!";
        isValid = false;
    }

    if (phi.length === 0) {
        document.getElementById("error_phi").innerHTML = "Bạn chưa nhập mã phí giao !!!";
        isValid = false;
    }

    

    if (!isValid) {
        return;
    }

    document.getElementById("nvc").submit();
}












// function checkAll(bx) {
//   var cbs = document.getElementsByTagName('input');
//   for(var i=0; i < cbs.length; i++) {
//     if(cbs[i].type == 'checkbox') {
//       cbs[i].checked = bx.checked;
//     }
//   }
// }