-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th12 07, 2024 lúc 07:47 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `htbanhoatuoi`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethd`
--

CREATE TABLE `chitiethd` (
  `SP_MA` varchar(5) NOT NULL,
  `HD_MA` varchar(5) NOT NULL,
  `CTHD_SLB` int(11) NOT NULL,
  `CTHD_DONGIA` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethd`
--

INSERT INTO `chitiethd` (`SP_MA`, `HD_MA`, `CTHD_SLB`, `CTHD_DONGIA`) VALUES
('SP003', 'HD001', 1, 250000),
('SP003', 'HD002', 2, 500000),
('SP003', 'HD003', 2, 500000),
('SP004', 'HD002', 3, 525000),
('SP004', 'HD004', 6, 1050000),
('SP008', 'HD002', 3, 1080000),
('SP008', 'HD003', 3, 1080000),
('SP020', 'HD003', 2, 3000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chucvu`
--

CREATE TABLE `chucvu` (
  `CV_MA` varchar(5) NOT NULL,
  `CV_ND` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chucvu`
--

INSERT INTO `chucvu` (`CV_MA`, `CV_ND`) VALUES
('CV001', 'Quản lý'),
('CV002', 'Nhân viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `DG_MA` varchar(5) NOT NULL,
  `KH_MA` varchar(5) NOT NULL,
  `SP_MA` varchar(5) DEFAULT NULL,
  `DG_NOIDUNG` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DG_SOSAO` int(11) NOT NULL,
  `DG_NGAYGIO` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`DG_MA`, `KH_MA`, `SP_MA`, `DG_NOIDUNG`, `DG_SOSAO`, `DG_NGAYGIO`) VALUES
('DG001', 'KH001', 'SP001', 'Rất đẹp', 5, '2024-10-01 10:00:00'),
('DG002', 'KH002', 'SP002', 'Tạm ổn', 4, '2024-10-02 11:00:00'),
('DG003', 'KH004', 'SP002', 'được', 4, '2024-11-20 16:04:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donvanchuyen`
--

CREATE TABLE `donvanchuyen` (
  `DVC_MA` varchar(10) NOT NULL,
  `NVC_MA` varchar(5) NOT NULL,
  `DVC_DIACHI` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DVC_TGBD` datetime NOT NULL,
  `DVC_TGHT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donvanchuyen`
--

INSERT INTO `donvanchuyen` (`DVC_MA`, `NVC_MA`, `DVC_DIACHI`, `DVC_TGBD`, `DVC_TGHT`) VALUES
('DVC001', 'NVC01', 'Can Tho', '2024-11-21 09:13:30', '2024-11-21 00:00:00'),
('DVC002', 'NVC01', 'Phong Điền Cần Thơ', '2024-11-21 11:27:14', '2024-11-21 00:00:00'),
('DVC003', 'NVC02', 'Phong Điền Cần Thơ', '2024-11-21 11:28:55', NULL),
('DVC004', 'NVC01', 'phong dien can tho', '2024-11-21 14:24:30', '2024-11-21 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giasp`
--

CREATE TABLE `giasp` (
  `SP_MA` varchar(5) NOT NULL,
  `GSP_DONGIA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giasp`
--

INSERT INTO `giasp` (`SP_MA`, `GSP_DONGIA`) VALUES
('SP001', 250000),
('SP002', 1000000),
('SP003', 250000),
('SP004', 250000),
('SP005', 2000000),
('SP007', 250000),
('SP008', 400000),
('SP009', 250000),
('SP010', 300000),
('SP011', 1000000),
('SP012', 150000),
('SP013', 750000),
('SP016', 250000),
('SP020', 1500000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `HD_MA` varchar(5) NOT NULL,
  `DVC_MA` varchar(10) DEFAULT NULL,
  `PTTT_MA` varchar(5) NOT NULL,
  `KM_MA` varchar(5) DEFAULT NULL,
  `TT_MA` varchar(5) NOT NULL,
  `KH_MA` varchar(5) NOT NULL,
  `HD_NGAYLAP` date NOT NULL,
  `HD_TONGTIEN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`HD_MA`, `DVC_MA`, `PTTT_MA`, `KM_MA`, `TT_MA`, `KH_MA`, `HD_NGAYLAP`, `HD_TONGTIEN`) VALUES
('HD001', 'DVC001', 'PTTT2', 'KM01', 'TT002', 'KH004', '2024-11-21', 270000),
('HD002', 'DVC002', 'PTTT2', 'KM01', 'TT003', 'KH004', '2024-11-21', 2125000),
('HD003', 'DVC003', 'PTTT2', 'KM01', 'TT002', 'KH004', '2024-11-21', 4598000),
('HD004', 'DVC004', 'PTTT2', 'KM01', 'TT003', 'KH004', '2024-11-21', 1070000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `KH_MA` varchar(5) NOT NULL,
  `KH_TDN` varchar(25) NOT NULL,
  `KH_MK` varchar(100) NOT NULL,
  `KH_TEN` varchar(50) NOT NULL,
  `KH_DIACHI` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `KH_SDT` varchar(11) NOT NULL,
  `KH_EMAIL` varchar(70) DEFAULT NULL,
  `KH_Avatar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`KH_MA`, `KH_TDN`, `KH_MK`, `KH_TEN`, `KH_DIACHI`, `KH_SDT`, `KH_EMAIL`, `KH_Avatar`) VALUES
('KH001', 'nguyenvantri', 'nvt', 'Nguyễn Văn Trí', 'Cần thơ', '0123456789', 'nvt@example.com', NULL),
('KH002', 'nguyenvanbay', 'nvb', 'Nguyễn Văn Bảy', 'Vĩnh long', '0987654321', 'nvb@example.com', NULL),
('KH004', 'tien', '$2y$10$W7ae4ZHqE2OX7yQC9sI17O05XwNrlVbFesRp3vIEDJoDizVCkWJw2', 'Tran Thi Cam Luyen', 'hau giang', '0987654321', 'tien123@gmail.com', 'avatar/tien.jpg'),
('KH006', 'nhi', '$2y$10$XbgnugOZCLYYUuRGUN1j8ugayBQKxmDu7cLUQq9Rhv2hUYBtejTfm', 'Ngoc Nhi ', 'Cần thơ', '0987576654', 'abc@abc.abc', 'avatar/nhi.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khohang`
--

CREATE TABLE `khohang` (
  `MAGIAODICH` int(11) NOT NULL,
  `SP_MA` varchar(5) DEFAULT NULL,
  `SLTHAYDOI` int(11) DEFAULT NULL,
  `NGAYTHAYDOI` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khohang`
--

INSERT INTO `khohang` (`MAGIAODICH`, `SP_MA`, `SLTHAYDOI`, `NGAYTHAYDOI`) VALUES
(1, 'SP001', 10, '2024-11-05 21:10:19'),
(2, 'SP002', 10, '2024-11-05 21:10:46'),
(3, 'SP003', 10, '2024-11-05 21:10:46'),
(4, 'SP004', 10, '2024-11-05 21:10:46'),
(7, 'SP007', 10, '2024-11-05 21:10:46'),
(8, 'SP008', 10, '2024-11-05 21:10:46'),
(13, 'SP009', 10, '2024-11-16 20:04:35'),
(30, 'SP010', 10, '2024-11-17 11:27:39'),
(31, 'SP011', 10, '2024-11-17 11:27:58'),
(32, 'SP012', 10, '2024-11-17 11:28:07'),
(33, 'SP013', 10, '2024-11-17 11:28:16'),
(34, 'SP007', -3, '2024-11-17 11:30:01'),
(35, 'SP002', 10, '2024-11-17 11:30:01'),
(39, 'SP016', 10, '2024-11-17 13:06:07'),
(43, 'SP020', 10, '2024-11-17 14:29:30'),
(45, 'SP001', -2, '2024-11-19 09:49:22'),
(46, 'SP004', -1, '2024-11-19 09:49:22'),
(47, 'SP002', -2, '2024-11-20 03:41:05'),
(48, 'SP011', -1, '2024-11-20 03:41:05'),
(49, 'SP002', -2, '2024-11-20 03:53:03'),
(50, 'SP010', -4, '2024-11-20 03:53:03'),
(51, 'SP003', -1, '2024-11-21 02:13:30'),
(54, 'SP004', -3, '2024-11-21 04:27:14'),
(55, 'SP003', -2, '2024-11-21 04:27:14'),
(56, 'SP008', -3, '2024-11-21 04:27:14'),
(57, 'SP003', -2, '2024-11-21 04:28:55'),
(58, 'SP008', -3, '2024-11-21 04:28:55'),
(59, 'SP020', -2, '2024-11-21 04:28:55'),
(60, 'SP004', -6, '2024-11-21 07:24:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `KM_MA` varchar(5) NOT NULL,
  `KM_TGBD` datetime NOT NULL,
  `KM_TGKT` datetime NOT NULL,
  `KM_GTRI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`KM_MA`, `KM_TGBD`, `KM_TGKT`, `KM_GTRI`) VALUES
('KM01', '2024-11-19 14:34:04', '2025-11-19 14:34:06', 10),
('KM02', '2024-11-19 00:00:00', '2025-11-30 00:00:00', 30),
('KM03', '2024-11-21 00:00:00', '2024-11-30 00:00:00', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `km_sp`
--

CREATE TABLE `km_sp` (
  `KM_MA` varchar(5) NOT NULL,
  `SP_MA` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `km_sp`
--

INSERT INTO `km_sp` (`KM_MA`, `SP_MA`) VALUES
('KM02', 'SP013'),
('KM02', 'SP001'),
('KM02', 'SP002'),
('KM02', 'SP004'),
('KM02', 'SP007'),
('KM01', 'SP011'),
('KM01', 'SP008'),
('KM03', 'SP020');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisp`
--

CREATE TABLE `loaisp` (
  `LSP_MA` varchar(5) NOT NULL,
  `LSP_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisp`
--

INSERT INTO `loaisp` (`LSP_MA`, `LSP_TEN`) VALUES
('LSP01', 'Hoa tươi'),
('LSP02', 'Hoa handmade');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `NV_MA` varchar(5) NOT NULL,
  `NV_TDN` varchar(25) NOT NULL,
  `NV_MK` varchar(100) NOT NULL,
  `NV_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NV_DIACHI` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NV_SDT` varchar(11) NOT NULL,
  `NV_EMAIL` varchar(100) NOT NULL,
  `CV_MA` varchar(5) NOT NULL,
  `NV_Avatar` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`NV_MA`, `NV_TDN`, `NV_MK`, `NV_TEN`, `NV_DIACHI`, `NV_SDT`, `NV_EMAIL`, `CV_MA`, `NV_Avatar`) VALUES
('NV001', 'lamtrucnhu', '$2y$10$mUE0Ute6bURWFRQpEixXe.dqg3t.E3IIoM8B5GNz9fPX75uJlqQmi', 'Lâm Trúc Như', 'Cần thơ', '0123456789', 'ltn@example.com', 'CV001', 'assets/images/faces/face26.jpg'),
('NV002', 'anh', 'anh1234@', 'Trần Thị Vân Anh', 'Hậu Giang', '0987654321', 'anh@gmail.com', 'CV002', 'assets/images/faces/hoalyvang.jpeg'),
('NV003', 'luyen', 'l123456@', 'Cẩm Luyến', 'Cần Thơ', '1234567890', 'luyen@gmail.com', 'CV002', 'assets/images/faces/android_logo.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhaphanphoi`
--

CREATE TABLE `nhaphanphoi` (
  `NPP_MA` varchar(5) NOT NULL,
  `NPP_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NPP_VOHH` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhaphanphoi`
--

INSERT INTO `nhaphanphoi` (`NPP_MA`, `NPP_TEN`, `NPP_VOHH`) VALUES
('NPO05', 'HCM', 1),
('NPP00', 'Nhà Hương', 0),
('NPP01', 'Chợ hoa Hồ Thị Kỷ', 1),
('NPP02', 'Nhà Vườn Đà Lạt', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhavanchuyen`
--

CREATE TABLE `nhavanchuyen` (
  `NVC_MA` varchar(5) NOT NULL,
  `NVC_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NVC_KHUVUC` varchar(100) NOT NULL,
  `NVC_PHI` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhavanchuyen`
--

INSERT INTO `nhavanchuyen` (`NVC_MA`, `NVC_TEN`, `NVC_KHUVUC`, `NVC_PHI`) VALUES
('NVC01', 'Giao hàng nhanh', 'Cần Thơ', 20000),
('NVC01', 'Giao hàng nhanh', 'Hậu Giang', 60000),
('NVC02', 'Giao hàng tiết kiệm', 'Cần Thơ', 18000),
('NVC02', 'Giao hàng tiết kiệm', 'Hậu Giang', 50000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `PN_MA` varchar(5) NOT NULL,
  `NV_MA` varchar(5) NOT NULL,
  `NPP_MA` varchar(5) NOT NULL,
  `SP_MA` varchar(5) NOT NULL,
  `PN_NGAYNHAP` date NOT NULL,
  `PN_SL` int(11) NOT NULL,
  `PN_PBGIA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`PN_MA`, `NV_MA`, `NPP_MA`, `SP_MA`, `PN_NGAYNHAP`, `PN_SL`, `PN_PBGIA`) VALUES
('PN001', 'NV001', 'NPO05', 'SP016', '2024-11-17', 10, 100000),
('PN002', 'NV001', 'NPO05', 'SP001', '2024-11-20', 20, 50000),
('PN003', 'NV001', 'NPP00', 'SP002', '2024-11-20', 10, 20000),
('PN004', 'NV001', 'NPO05', 'SP003', '2024-11-20', 10, 10000),
('PN005', 'NV001', 'NPP00', 'SP004', '2024-11-20', 10, 20000),
('PN006', 'NV001', 'NPP02', 'SP007', '2024-11-20', 10, 50000),
('PN007', 'NV001', 'NPP02', 'SP008', '2024-11-20', 10, 15000),
('PN008', 'NV001', 'NPP00', 'SP020', '2024-11-20', 10, 20000),
('PN009', 'NV001', 'NPP00', 'SP010', '2024-11-20', 10, 20000),
('PN010', 'NV001', 'NPO05', 'SP009', '2024-11-20', 10, 20000),
('PN011', 'NV001', 'NPP02', 'SP010', '2024-11-20', 10, 10000),
('PN012', 'NV001', 'NPP02', 'SP011', '2024-11-20', 10, 20000),
('PN013', 'NV001', 'NPP02', 'SP012', '2024-11-20', 10, 15000),
('PN014', 'NV001', 'NPP00', 'SP013', '2024-11-20', 10, 20000),
('PN015', 'NV001', 'NPP01', 'SP005', '2024-11-21', 10, 10000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ptthanhtoan`
--

CREATE TABLE `ptthanhtoan` (
  `PTTT_MA` varchar(5) NOT NULL,
  `PTTT_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ptthanhtoan`
--

INSERT INTO `ptthanhtoan` (`PTTT_MA`, `PTTT_TEN`) VALUES
('PTTT1', 'Thanh toán chuyển khoản'),
('PTTT2', 'Thanh toán khi nhận hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `SP_MA` varchar(5) NOT NULL,
  `LSP_MA` varchar(5) NOT NULL,
  `SP_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `SP_MOTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `SP_HINHANH` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`SP_MA`, `LSP_MA`, `SP_TEN`, `SP_MOTA`, `SP_HINHANH`) VALUES
('SP001', 'LSP01', 'Hoa hồng mau vang', 'Hoa hồng vàng đại diện cho tình bạn chân thành, ấm áp. Bó hoa Soulmate được thiết kế với 12 bông hồng vàng là lựa chọn hoàn hảo để tặng bạn thân vào những dịp đặc biệt', 'product/bo-hoa-hong-vang.jpg'),
('SP002', 'LSP01', 'Hoa ly', 'Hoa ly (lilium) là một trong những loài hoa đẹp và quý phái, được nhiều người yêu thích trong các dịp lễ tết, sự kiện trọng đại hoặc trang trí không gian sống', 'product/hoaly.jpg'),
('SP003', 'LSP01', 'Hoa hồng trà', 'Hoa hồng trà (tên khoa học: Camellia sinensis) là một loại hoa thuộc họ trà, nổi bật với vẻ đẹp quyến rũ và sự thanh lịch.', 'product/bo-hoa-hong-trang-xinh-3568.jpg'),
('SP004', 'LSP01', 'Hoa candy', 'Hoa Candy là một trong những loài hoa độc đáo, nổi bật với vẻ đẹp rực rỡ và sắc màu ngọt ngào, giống như chính cái tên của nó.', 'product/candy.jpg'),
('SP005', 'LSP01', 'Hoa mẩu đơn', 'Hoa mẫu đơn, hay còn gọi là Peony trong tiếng Anh, là một loài hoa mang vẻ đẹp lộng lẫy, sang trọng và đầy ý nghĩa.', 'product/maudon.jpeg'),
('SP007', 'LSP01', 'Hoa sao xanh', 'Hoa sao xanh, với vẻ đẹp dịu dàng và sắc xanh nhẹ nhàng, là một biểu tượng của sự thanh thoát và bình yên', 'product/hao-sao-xanh_045.jpg'),
('SP008', 'LSP01', 'Hoa hồng đỏ', 'Hoa hồng đỏ, biểu tượng của tình yêu nồng cháy và sự lãng mạn, đã từ lâu trở thành loài hoa được yêu thích nhất trên thế giới.', 'product/hoa_hong.jpg'),
('SP009', 'LSP02', 'Hoa baby', 'HoaBaby là cửa hàng hoa tươi chuyên cung cấp các sản phẩm hoa đẹp, độc đáo và chất lượng cao cho mọi dịp lễ, sự kiện', 'product/bo-hoa-baby-first-date.jpg'),
('SP010', 'LSP02', 'Hoa hướng dương', 'Hoa hướng dương, loài hoa luôn vươn mình theo ánh mặt trời, là biểu tượng của sức mạnh, niềm tin và sự kiên định.', 'product/bo-hoa-huong-duong-handmade-ban-mai_anh_phu.jpg'),
('SP011', 'LSP02', 'Hoa ly handmade', 'Hoa ly handmade là một sản phẩm thủ công độc đáo, được tạo ra với sự tỉ mỉ và tinh tế trong từng chi tiết. ', 'product/bo-hoa-ly-kem-nhung-handmade-ngay-dep-troi.jpg'),
('SP012', 'LSP02', 'Hoa hướng dương len', 'Hoa hướng dương là biểu tượng của sự lạc quan, hy vọng và sức sống mạnh mẽ, mang đến cảm giác ấm áp và tươi sáng. Sản phẩm hoa hướng dương handmade không chỉ giữ trọn vẹn vẻ đẹp tự nhiên của loài hoa', 'product/hdlen.jpg'),
('SP013', 'LSP02', 'Hoa cẩm tú cầu', 'Hoa cẩm tú cầu (Hydrangea) là một trong những loại hoa đẹp và thanh lịch nhất, nổi tiếng với vẻ ngoài rực rỡ và màu sắc đa dạng', 'product/Hoa-cam-tu-cau-handmade.jpg'),
('SP016', 'LSP01', 'Hoa ly vang', 'Hoa ly vàng là một trong những loài hoa quý phái và nổi bật, mang lại vẻ đẹp rạng ngời cho không gian. Với màu vàng tươi sáng, hoa ly vàng tượng trưng cho sự giàu có, may mắn và thịnh vượng', 'product/hoalyvang.jpeg'),
('SP020', 'LSP01', 'Hoa sen', 'Hoa sen, biểu tượng của sự tinh khiết và thanh cao, là loài hoa đặc trưng của vùng đất nhiệt đới, gắn liền với văn hóa và tín ngưỡng của nhiều quốc gia, đặc biệt là Việt Nam. ', 'product/tải xuống.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `TT_MA` varchar(5) NOT NULL,
  `TT_TEN` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`TT_MA`, `TT_TEN`) VALUES
('TT002', 'Đang giao hàng'),
('TT003', 'Hoàn tất');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethd`
--
ALTER TABLE `chitiethd`
  ADD PRIMARY KEY (`SP_MA`,`HD_MA`),
  ADD KEY `FK_CTHD_HD` (`HD_MA`);

--
-- Chỉ mục cho bảng `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`CV_MA`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`DG_MA`),
  ADD KEY `FK_DG_KH` (`KH_MA`),
  ADD KEY `FK_DG_SP` (`SP_MA`);

--
-- Chỉ mục cho bảng `donvanchuyen`
--
ALTER TABLE `donvanchuyen`
  ADD PRIMARY KEY (`DVC_MA`),
  ADD KEY `FK_DVC_NVC` (`NVC_MA`);

--
-- Chỉ mục cho bảng `giasp`
--
ALTER TABLE `giasp`
  ADD PRIMARY KEY (`SP_MA`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`HD_MA`),
  ADD KEY `FK_HD_PTTT` (`PTTT_MA`),
  ADD KEY `FK_HD_KM` (`KM_MA`),
  ADD KEY `FK_HD_TT` (`TT_MA`),
  ADD KEY `FK_HD_KH` (`KH_MA`),
  ADD KEY `FK_HD_DVC` (`DVC_MA`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`KH_MA`),
  ADD UNIQUE KEY `KH_TDN` (`KH_TDN`),
  ADD UNIQUE KEY `KH_EMAIL` (`KH_EMAIL`),
  ADD KEY `idx_kh_tdn` (`KH_TDN`);

--
-- Chỉ mục cho bảng `khohang`
--
ALTER TABLE `khohang`
  ADD PRIMARY KEY (`MAGIAODICH`),
  ADD KEY `fk_khohang_sp` (`SP_MA`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`KM_MA`);

--
-- Chỉ mục cho bảng `km_sp`
--
ALTER TABLE `km_sp`
  ADD KEY `FK_KMSP_KM` (`KM_MA`),
  ADD KEY `FK_KMSP_SP` (`SP_MA`);

--
-- Chỉ mục cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`LSP_MA`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`NV_MA`),
  ADD UNIQUE KEY `NV_TDN` (`NV_TDN`),
  ADD KEY `FK_NV_CV` (`CV_MA`),
  ADD KEY `idx_nv_tdn` (`NV_TDN`);

--
-- Chỉ mục cho bảng `nhaphanphoi`
--
ALTER TABLE `nhaphanphoi`
  ADD PRIMARY KEY (`NPP_MA`);

--
-- Chỉ mục cho bảng `nhavanchuyen`
--
ALTER TABLE `nhavanchuyen`
  ADD PRIMARY KEY (`NVC_MA`,`NVC_KHUVUC`) USING BTREE;

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`PN_MA`),
  ADD KEY `FK_PN_NV` (`NV_MA`),
  ADD KEY `FK_PN_NPP` (`NPP_MA`),
  ADD KEY `FK_PN_SP` (`SP_MA`);

--
-- Chỉ mục cho bảng `ptthanhtoan`
--
ALTER TABLE `ptthanhtoan`
  ADD PRIMARY KEY (`PTTT_MA`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`SP_MA`),
  ADD KEY `FK_SANPHAM_LOAISP` (`LSP_MA`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`TT_MA`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `khohang`
--
ALTER TABLE `khohang`
  MODIFY `MAGIAODICH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethd`
--
ALTER TABLE `chitiethd`
  ADD CONSTRAINT `FK_CTHD_HD` FOREIGN KEY (`HD_MA`) REFERENCES `hoadon` (`HD_MA`),
  ADD CONSTRAINT `FK_CTHD_SP` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `FK_DG_KH` FOREIGN KEY (`KH_MA`) REFERENCES `khachhang` (`KH_MA`),
  ADD CONSTRAINT `FK_DG_SP` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`);

--
-- Các ràng buộc cho bảng `donvanchuyen`
--
ALTER TABLE `donvanchuyen`
  ADD CONSTRAINT `FK_DVC_NVC` FOREIGN KEY (`NVC_MA`) REFERENCES `nhavanchuyen` (`NVC_MA`);

--
-- Các ràng buộc cho bảng `giasp`
--
ALTER TABLE `giasp`
  ADD CONSTRAINT `FK_GIASP_SANPHAM` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `FK_HD_DVC` FOREIGN KEY (`DVC_MA`) REFERENCES `donvanchuyen` (`DVC_MA`),
  ADD CONSTRAINT `FK_HD_KH` FOREIGN KEY (`KH_MA`) REFERENCES `khachhang` (`KH_MA`),
  ADD CONSTRAINT `FK_HD_KM` FOREIGN KEY (`KM_MA`) REFERENCES `khuyenmai` (`KM_MA`),
  ADD CONSTRAINT `FK_HD_PTTT` FOREIGN KEY (`PTTT_MA`) REFERENCES `ptthanhtoan` (`PTTT_MA`),
  ADD CONSTRAINT `FK_HD_TT` FOREIGN KEY (`TT_MA`) REFERENCES `trangthai` (`TT_MA`);

--
-- Các ràng buộc cho bảng `khohang`
--
ALTER TABLE `khohang`
  ADD CONSTRAINT `fk_khohang_sp` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`) ON DELETE CASCADE,
  ADD CONSTRAINT `khohang_ibfk_1` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`);

--
-- Các ràng buộc cho bảng `km_sp`
--
ALTER TABLE `km_sp`
  ADD CONSTRAINT `FK_KMSP_KM` FOREIGN KEY (`KM_MA`) REFERENCES `khuyenmai` (`KM_MA`),
  ADD CONSTRAINT `FK_KMSP_SP` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_NV_CV` FOREIGN KEY (`CV_MA`) REFERENCES `chucvu` (`CV_MA`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `FK_PN_NPP` FOREIGN KEY (`NPP_MA`) REFERENCES `nhaphanphoi` (`NPP_MA`),
  ADD CONSTRAINT `FK_PN_NV` FOREIGN KEY (`NV_MA`) REFERENCES `nhanvien` (`NV_MA`),
  ADD CONSTRAINT `FK_PN_SP` FOREIGN KEY (`SP_MA`) REFERENCES `sanpham` (`SP_MA`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `FK_SANPHAM_LOAISP` FOREIGN KEY (`LSP_MA`) REFERENCES `loaisp` (`LSP_MA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
