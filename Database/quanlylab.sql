-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 04:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlylab`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietttp`
--

CREATE TABLE `chitietttp` (
  `MaPhong` varchar(50) NOT NULL,
  `MaTTP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitietttp`
--

INSERT INTO `chitietttp` (`MaPhong`, `MaTTP`) VALUES
('P001', 'TTP001'),
('P002', 'TTP001'),
('P003', 'TTP001'),
('P004', 'TTP001'),
('P005', 'TTP001'),
('P006', 'TTP001'),
('P007', 'TTP001'),
('P008', 'TTP001'),
('P009', 'TTP001'),
('P010', 'TTP001'),
('P011', 'TTP001'),
('P012', 'TTP001'),
('P013', 'TTP001'),
('P014', 'TTP001'),
('P015', 'TTP001');

-- --------------------------------------------------------

--
-- Table structure for table `chitietttpm`
--

CREATE TABLE `chitietttpm` (
  `MaPhieu` varchar(50) NOT NULL,
  `MaTTPM` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitietttpm`
--

INSERT INTO `chitietttpm` (`MaPhieu`, `MaTTPM`) VALUES
('PH001', 'TTPM001'),
('PH002', 'TTPM002'),
('PH003', 'TTPM001'),
('PH004', 'TTPM002');

-- --------------------------------------------------------

--
-- Table structure for table `chitiettttb`
--

CREATE TABLE `chitiettttb` (
  `MaThietBi` varchar(50) NOT NULL,
  `MaTTTB` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiettttb`
--

INSERT INTO `chitiettttb` (`MaThietBi`, `MaTTTB`) VALUES
('BAN001', 'TTTB001'),
('BP001', 'TTTB001'),
('CH001', 'TTTB001'),
('DC001', 'TTTB003'),
('GHE001', 'TTTB001'),
('MTB001', 'TTTB001'),
('MTB002', 'TTTB001');

-- --------------------------------------------------------

--
-- Table structure for table `khoa`
--

CREATE TABLE `khoa` (
  `MaKhoa` varchar(50) NOT NULL,
  `TenKhoa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khoa`
--

INSERT INTO `khoa` (`MaKhoa`, `TenKhoa`) VALUES
('CK', 'Cơ khí'),
('CNSHMT', 'Công nghệ sinh học và môi trường'),
('CNTP', 'Công nghệ thực phẩm'),
('CNTT', 'Công nghệ thông tin'),
('DDT', 'Điện - điện tử'),
('DL', 'Du lịch'),
('KHKTTS', 'Khoa học và công nghệ khai thác thuỷ sản'),
('KHXHNV', 'Khoa học xã hội và nhân văn'),
('KT', 'Kinh tế'),
('KTGT', 'Kỹ thuật giao thông'),
('KTTC', 'Kế toán tài chính'),
('NN', 'Ngoại ngữ'),
('NTTS', 'Nuôi trồng thuỷ sản'),
('XD', 'Xây dựng');

-- --------------------------------------------------------

--
-- Table structure for table `loai`
--

CREATE TABLE `loai` (
  `MaLoai` varchar(50) NOT NULL,
  `TenLoai` varchar(100) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai`
--

INSERT INTO `loai` (`MaLoai`, `TenLoai`, `SoLuong`) VALUES
('BAN', 'Bàn', 400),
('BP', 'Bàn phím', 400),
('CH', 'Chuột', 400),
('DC', 'Dây cáp', 100),
('GHE', 'Ghế', 400),
('MTB', 'Máy tính bàn', 400),
('TV', 'Ti vi', 20);

-- --------------------------------------------------------

--
-- Table structure for table `ngaytuan`
--

CREATE TABLE `ngaytuan` (
  `MaNgay` varchar(50) NOT NULL,
  `TenNgay` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ngaytuan`
--

INSERT INTO `ngaytuan` (`MaNgay`, `TenNgay`) VALUES
('CHUNHAT', 'Chủ nhật'),
('THUBA', 'Thứ ba'),
('THUBAY', 'Thứ bảy'),
('THUHAI', 'Thứ hai'),
('THUNAM', 'Thứ năm'),
('THUSAU', 'Thứ sáu'),
('THUTU', 'Thứ tư');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaND` varchar(50) NOT NULL,
  `MaVT` varchar(50) NOT NULL,
  `Ho` varchar(50) NOT NULL,
  `Ten` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` text NOT NULL,
  `Anh` varchar(255) NOT NULL,
  `Sdt` varchar(20) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` tinyint(4) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `MaKhoa` varchar(50) NOT NULL,
  `Lop` varchar(50) DEFAULT NULL,
  `NgayTao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`MaND`, `MaVT`, `Ho`, `Ten`, `Email`, `MatKhau`, `Anh`, `Sdt`, `NgaySinh`, `GioiTinh`, `DiaChi`, `MaKhoa`, `Lop`, `NgayTao`) VALUES
('ND001', 'QTV', 'Nguyễn', 'Hiếu', 'hieu@ntu.edu.vn', 'nguyenhieu123', 'hieu.jpg', '0985904921', '1990-05-10', 1, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND002', 'QTV', 'Phạm ', 'Thị Thu Thuý', 'thuthuypt@ntu.edu.vn', 'thuthuy123', 'thuy.jpg', '0997256141', '1981-11-12', 0, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND003', 'QTV', 'Bùi', 'Chí Thành', 'thanhbuic@ntu.edu.vn', 'chithanh123', 'thanh.jpg', '0836825785', '1983-08-22', 1, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND004', 'GV', 'Nguyễn', 'Hải Triều', 'trieu.jpg', 'haitrieu123', 'trieu.jpg', '0992682518', '1995-03-09', 1, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND005', 'GV', 'Nguyễn', 'Đình Hưng', 'ndhung@ntu.edu.vn', 'dinhhung123', 'hung.jpg', '0987656787', '1980-10-10', 1, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND006', 'GV', 'Nguyễn', 'Thị Hương Lý', 'lyngth@ntu.edu.vn', 'huongly123', 'ly.jpg', '0987789789', '1987-12-01', 0, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND007', 'GV', 'Phạm', 'Thị Kim Ngoan', 'ptkngoan@ntu.edu.vn', 'kimngoan123', 'ngoan.jpg', '0898531219', '1985-09-04', 0, 'Nha Trang', 'CNTT', NULL, '2025-11-14 08:03:10'),
('ND008', 'SV', 'Phạm', 'Tuấn Kiệt', 'kiet.pt.64cntt@ntu.edu.vn', 'tuankiet1774', 'kiet.jpg', '0987654671', '2004-07-17', 1, 'Diên Khánh', 'CNTT', '64.CNTT-1', '2025-11-14 08:03:10'),
('ND009', 'SV', 'Cao', 'Linh Hà', 'ha.cl.64cntt@ntu.edu.vn', 'linhha124', 'ha.jpg', '0828635809', '2004-12-17', 0, 'Ninh Hoà', 'CNTT', '64.CNTT-2', '2025-11-14 08:03:10'),
('ND010', 'SV', 'Huỳnh', 'Minh Bảo', 'bao.hm.64nna@ntu.edu.vn', 'minhbao123', 'bao.jpg', '0987654653', '2000-06-30', 1, 'DienKhanh', 'NN', '64.NNA-1', '2025-11-14 08:03:10'),
('ND011', 'SV', 'Nguyễn ', 'Hồ Thanh Bình', 'binh.nht.64NTTS@ntu.edu.vn', 'thanhbinh123', 'binh.jpg', '0987654453', '2004-04-02', 0, 'Ninh Hoà', 'NTTS', '64.NTTS-2', '2025-11-14 08:03:10'),
('ND012', 'SV', 'Nguyễn ', 'Hiểu Quyên', 'quyen.nh.64cntp@ntu.edu.vn', 'hieuquyen124', 'quyen.jpg', '0828635784', '2004-10-17', 0, 'Diên Sơn', 'CNTP', '64.CNTP-3', '2025-11-14 08:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `nhomphong`
--

CREATE TABLE `nhomphong` (
  `MaNhom` varchar(50) NOT NULL,
  `TenNhom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhomphong`
--

INSERT INTO `nhomphong` (`MaNhom`, `TenNhom`) VALUES
('G7', 'Giảng đường G7'),
('G8', 'Giảng đường G8'),
('NDN', 'Toà nhà đa năng');

-- --------------------------------------------------------

--
-- Table structure for table `phieumuon`
--

CREATE TABLE `phieumuon` (
  `MaPhieu` varchar(50) NOT NULL,
  `MaPhong` varchar(50) NOT NULL,
  `MaND` varchar(50) NOT NULL,
  `MucDich` text NOT NULL,
  `NgayBD` date NOT NULL,
  `NgayKT` date NOT NULL,
  `NgayTao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phieumuon`
--

INSERT INTO `phieumuon` (`MaPhieu`, `MaPhong`, `MaND`, `MucDich`, `NgayBD`, `NgayKT`, `NgayTao`) VALUES
('PH001', 'P011', 'ND004', 'Thực hành môn phát triển mã nguồn mở', '2025-09-15', '2025-10-26', '2025-11-14 08:33:38'),
('PH002', 'P004', 'ND003', 'Thực hành phát triển ứng dụng Web', '2025-09-15', '2025-10-26', '2025-11-14 08:33:38'),
('PH003', 'P008', 'ND002', 'Thực hành hệ quản trị cơ sở dữ liệu', '2025-09-15', '2025-10-26', '2025-11-14 08:33:38'),
('PH004', 'P002', 'ND006', 'Thực hành thiết kế giao diện Web', '2025-09-15', '2025-10-26', '2025-11-14 08:33:38'),
('PH005', 'P004', 'ND005', 'Thực hành lập trình hướng đối tượng', '2025-09-15', '2025-10-26', '2025-11-14 08:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `MaPhong` varchar(50) NOT NULL,
  `TenPhong` varchar(100) NOT NULL,
  `MaNhom` varchar(50) NOT NULL,
  `SucChua` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phong`
--

INSERT INTO `phong` (`MaPhong`, `TenPhong`, `MaNhom`, `SucChua`) VALUES
('P001', 'NĐN.201', 'NDN', 27),
('P002', 'NĐN.204', 'NDN', 28),
('P003', 'NĐN.205', 'NDN', 28),
('P004', 'NĐN.206', 'NDN', 29),
('P005', 'NĐN.209', 'NDN', 28),
('P006', 'NĐN.210', 'NDN', 28),
('P007', 'NĐN.304', 'NDN', 28),
('P008', 'NĐN.309', 'NDN', 26),
('P009', 'Cybersecurity lab 1', 'NDN', 34),
('P010', 'Cybersecurity lab 1', 'NDN', 15),
('P011', 'G7.THM', 'G7', 25),
('P012', 'G8.101', 'G8', 25),
('P013', 'G8.102', 'G8', 25),
('P014', 'G8.103', 'G8', 25),
('P015', 'G8.201', 'G8', 27);

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `MaThietBi` varchar(50) NOT NULL,
  `TenThietBi` varchar(100) NOT NULL,
  `MaLoai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thietbi`
--

INSERT INTO `thietbi` (`MaThietBi`, `TenThietBi`, `MaLoai`) VALUES
('BAN001', 'Bàn ', 'BAN'),
('BP001', 'Bán phím', 'BP'),
('CH001', 'Chuột có dây', 'CH'),
('DC001', 'Dây cáp', 'DC'),
('GHE001', 'Ghế tựa', 'GHE'),
('MTB001', 'Máy tính bàn', 'MTB'),
('MTB002', 'Máy tính bàn ', 'MTB');

-- --------------------------------------------------------

--
-- Table structure for table `thietbi_phong`
--

CREATE TABLE `thietbi_phong` (
  `MaPhong` varchar(50) NOT NULL,
  `MaThietBi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thietbi_phong`
--

INSERT INTO `thietbi_phong` (`MaPhong`, `MaThietBi`) VALUES
('P001', 'GHE001'),
('P001', 'MTB001'),
('P002', 'BP001'),
('P002', 'DC001'),
('P003', 'CH001'),
('P003', 'MTB002');

-- --------------------------------------------------------

--
-- Table structure for table `thoigianmuon`
--

CREATE TABLE `thoigianmuon` (
  `MaTGM` int(11) NOT NULL,
  `MaPhieu` varchar(50) DEFAULT NULL,
  `MaTiet` varchar(50) DEFAULT NULL,
  `MaTTT` varchar(50) DEFAULT NULL,
  `MaNgay` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thoigianmuon`
--

INSERT INTO `thoigianmuon` (`MaTGM`, `MaPhieu`, `MaTiet`, `MaTTT`, `MaNgay`) VALUES
(1, 'PH001', 'T001', 'TUANXS', 'THUBA'),
(2, 'PH001', 'T002', 'TUANXS', 'THUBA'),
(3, 'PH001', 'T003', 'TUANXS', 'THUBA'),
(4, 'PH001', 'T004', 'TUANXS', 'THUBA'),
(5, 'PH001', 'T005', 'TUANXS', 'THUBA'),
(6, 'PH002', 'T001', 'TUANCHAN', 'THUHAI'),
(7, 'PH002', 'T002', 'TUANCHAN', 'THUHAI'),
(8, 'PH002', 'T003', 'TUANCHAN', 'THUHAI'),
(9, 'PH002', 'T004', 'TUANCHAN', 'THUHAI'),
(10, 'PH002', 'T005', 'TUANCHAN', 'THUHAI');

-- --------------------------------------------------------

--
-- Table structure for table `tiethoc`
--

CREATE TABLE `tiethoc` (
  `MaTiet` varchar(50) NOT NULL,
  `TenTiet` varchar(100) NOT NULL,
  `GioBG` time NOT NULL,
  `GioKT` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tiethoc`
--

INSERT INTO `tiethoc` (`MaTiet`, `TenTiet`, `GioBG`, `GioKT`) VALUES
('T001', 'Tiết 1', '07:00:00', '07:45:00'),
('T002', 'Tiết 2', '07:50:00', '08:35:00'),
('T003', 'Tiết 3', '08:50:00', '09:35:00'),
('T004', 'Tiết 4', '09:40:00', '10:25:00'),
('T005', 'Tiết 5', '10:30:00', '11:15:00'),
('T006', 'Tiết 6', '13:00:00', '13:45:00'),
('T007', 'Tiết 7', '13:50:00', '14:35:00'),
('T008', 'Tiết 8', '14:50:00', '15:35:00'),
('T009', 'Tiết 9', '15:40:00', '16:25:00'),
('T010', 'Tiết 10', '16:30:00', '17:15:00'),
('T011', 'Tiết 11', '18:30:00', '19:15:00'),
('T012', 'Tiết 12', '19:20:00', '20:05:00'),
('T013', 'Tiết 13', '20:10:00', '20:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `trangthaiphieumuon`
--

CREATE TABLE `trangthaiphieumuon` (
  `MaTTPM` varchar(50) NOT NULL,
  `TenTTPM` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trangthaiphieumuon`
--

INSERT INTO `trangthaiphieumuon` (`MaTTPM`, `TenTTPM`) VALUES
('TTPM001', 'Chưa duyệt'),
('TTPM002', 'Đã duyệt'),
('TTPM003', 'Không chấp nhận');

-- --------------------------------------------------------

--
-- Table structure for table `trangthaiphong`
--

CREATE TABLE `trangthaiphong` (
  `MaTTP` varchar(50) NOT NULL,
  `TenTTP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trangthaiphong`
--

INSERT INTO `trangthaiphong` (`MaTTP`, `TenTTP`) VALUES
('TTP001', 'Hoạt động'),
('TTP002', 'Không hoạt động');

-- --------------------------------------------------------

--
-- Table structure for table `trangthaithietbi`
--

CREATE TABLE `trangthaithietbi` (
  `MaTTTB` varchar(50) NOT NULL,
  `TenTTTB` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trangthaithietbi`
--

INSERT INTO `trangthaithietbi` (`MaTTTB`, `TenTTTB`) VALUES
('TTTB001', 'Hoạt động tốt'),
('TTTB002', 'Đang bảo trì'),
('TTTB003', 'Cần kiểm tra lại'),
('TTTB004', 'Hỏng');

-- --------------------------------------------------------

--
-- Table structure for table `trangthaituan`
--

CREATE TABLE `trangthaituan` (
  `MaTTT` varchar(50) NOT NULL,
  `TenTTT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trangthaituan`
--

INSERT INTO `trangthaituan` (`MaTTT`, `TenTTT`) VALUES
('TUANCHAN', 'Tuần chẵn'),
('TUANLE', 'Tuần lẻ'),
('TUANXS', 'Xuyên suốt');

-- --------------------------------------------------------

--
-- Table structure for table `vaitro`
--

CREATE TABLE `vaitro` (
  `MaVT` varchar(50) NOT NULL,
  `TenVT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaitro`
--

INSERT INTO `vaitro` (`MaVT`, `TenVT`) VALUES
('GV', 'Giảng viên'),
('QTV', 'Quản trị viên'),
('SV', 'Sinh viên');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietttp`
--
ALTER TABLE `chitietttp`
  ADD PRIMARY KEY (`MaPhong`,`MaTTP`),
  ADD KEY `fk_ChiTietTTP_TrangThaiPhong` (`MaTTP`);

--
-- Indexes for table `chitietttpm`
--
ALTER TABLE `chitietttpm`
  ADD PRIMARY KEY (`MaPhieu`,`MaTTPM`),
  ADD KEY `fk_ChiTietTTPM_TrangThaiPhieuMuon` (`MaTTPM`);

--
-- Indexes for table `chitiettttb`
--
ALTER TABLE `chitiettttb`
  ADD PRIMARY KEY (`MaThietBi`,`MaTTTB`),
  ADD KEY `fk_ChiTietTTTB_TrangThaiThietBi` (`MaTTTB`);

--
-- Indexes for table `khoa`
--
ALTER TABLE `khoa`
  ADD PRIMARY KEY (`MaKhoa`);

--
-- Indexes for table `loai`
--
ALTER TABLE `loai`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Indexes for table `ngaytuan`
--
ALTER TABLE `ngaytuan`
  ADD PRIMARY KEY (`MaNgay`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaND`),
  ADD KEY `fk_NguoiDung_VaiTro` (`MaVT`),
  ADD KEY `fk_NguoiDung_Khoa` (`MaKhoa`),
  ADD KEY `fk_NguoiDung_Lop` (`Lop`);

--
-- Indexes for table `nhomphong`
--
ALTER TABLE `nhomphong`
  ADD PRIMARY KEY (`MaNhom`);

--
-- Indexes for table `phieumuon`
--
ALTER TABLE `phieumuon`
  ADD PRIMARY KEY (`MaPhieu`),
  ADD KEY `fk_PhieuMuon_Phong` (`MaPhong`),
  ADD KEY `fk_PhieuMuon_NguoiDung` (`MaND`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`MaPhong`),
  ADD KEY `fk_Phong_NhomPhong` (`MaNhom`);

--
-- Indexes for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`MaThietBi`),
  ADD KEY `fk_ThietBi_Loai` (`MaLoai`);

--
-- Indexes for table `thietbi_phong`
--
ALTER TABLE `thietbi_phong`
  ADD PRIMARY KEY (`MaPhong`,`MaThietBi`),
  ADD KEY `fk_ThietBiPhong_ThietBi` (`MaThietBi`);

--
-- Indexes for table `thoigianmuon`
--
ALTER TABLE `thoigianmuon`
  ADD PRIMARY KEY (`MaTGM`),
  ADD KEY `fk_ThoiGianMuon_PhieuMuon` (`MaPhieu`),
  ADD KEY `fk_ThoiGianMuon_TietHoc` (`MaTiet`),
  ADD KEY `fk_ThoiGianMuon_TrangThaiTuan` (`MaTTT`),
  ADD KEY `fk_ThoiGianMuon_NgayTuan` (`MaNgay`);

--
-- Indexes for table `tiethoc`
--
ALTER TABLE `tiethoc`
  ADD PRIMARY KEY (`MaTiet`);

--
-- Indexes for table `trangthaiphieumuon`
--
ALTER TABLE `trangthaiphieumuon`
  ADD PRIMARY KEY (`MaTTPM`);

--
-- Indexes for table `trangthaiphong`
--
ALTER TABLE `trangthaiphong`
  ADD PRIMARY KEY (`MaTTP`);

--
-- Indexes for table `trangthaithietbi`
--
ALTER TABLE `trangthaithietbi`
  ADD PRIMARY KEY (`MaTTTB`);

--
-- Indexes for table `trangthaituan`
--
ALTER TABLE `trangthaituan`
  ADD PRIMARY KEY (`MaTTT`);

--
-- Indexes for table `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`MaVT`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `thoigianmuon`
--
ALTER TABLE `thoigianmuon`
  MODIFY `MaTGM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietttp`
--
ALTER TABLE `chitietttp`
  ADD CONSTRAINT `fk_ChiTietTTP_Phong` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`),
  ADD CONSTRAINT `fk_ChiTietTTP_TrangThaiPhong` FOREIGN KEY (`MaTTP`) REFERENCES `trangthaiphong` (`MaTTP`);

--
-- Constraints for table `chitietttpm`
--
ALTER TABLE `chitietttpm`
  ADD CONSTRAINT `fk_ChiTietTTPM_PhieuMuon` FOREIGN KEY (`MaPhieu`) REFERENCES `phieumuon` (`MaPhieu`),
  ADD CONSTRAINT `fk_ChiTietTTPM_TrangThaiPhieuMuon` FOREIGN KEY (`MaTTPM`) REFERENCES `trangthaiphieumuon` (`MaTTPM`);

--
-- Constraints for table `chitiettttb`
--
ALTER TABLE `chitiettttb`
  ADD CONSTRAINT `fk_ChiTietTTTB_ThietBi` FOREIGN KEY (`MaThietBi`) REFERENCES `thietbi` (`MaThietBi`),
  ADD CONSTRAINT `fk_ChiTietTTTB_TrangThaiThietBi` FOREIGN KEY (`MaTTTB`) REFERENCES `trangthaithietbi` (`MaTTTB`);

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `fk_NguoiDung_Khoa` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`),
  ADD CONSTRAINT `fk_NguoiDung_VaiTro` FOREIGN KEY (`MaVT`) REFERENCES `vaitro` (`MaVT`);

--
-- Constraints for table `phieumuon`
--
ALTER TABLE `phieumuon`
  ADD CONSTRAINT `fk_PhieuMuon_NguoiDung` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`),
  ADD CONSTRAINT `fk_PhieuMuon_Phong` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `fk_Phong_NhomPhong` FOREIGN KEY (`MaNhom`) REFERENCES `nhomphong` (`MaNhom`);

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_ThietBi_Loai` FOREIGN KEY (`MaLoai`) REFERENCES `loai` (`MaLoai`);

--
-- Constraints for table `thietbi_phong`
--
ALTER TABLE `thietbi_phong`
  ADD CONSTRAINT `fk_ThietBiPhong_Phong` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`),
  ADD CONSTRAINT `fk_ThietBiPhong_ThietBi` FOREIGN KEY (`MaThietBi`) REFERENCES `thietbi` (`MaThietBi`);

--
-- Constraints for table `thoigianmuon`
--
ALTER TABLE `thoigianmuon`
  ADD CONSTRAINT `fk_ThoiGianMuon_NgayTuan` FOREIGN KEY (`MaNgay`) REFERENCES `ngaytuan` (`MaNgay`),
  ADD CONSTRAINT `fk_ThoiGianMuon_PhieuMuon` FOREIGN KEY (`MaPhieu`) REFERENCES `phieumuon` (`MaPhieu`),
  ADD CONSTRAINT `fk_ThoiGianMuon_TietHoc` FOREIGN KEY (`MaTiet`) REFERENCES `tiethoc` (`MaTiet`),
  ADD CONSTRAINT `fk_ThoiGianMuon_TrangThaiTuan` FOREIGN KEY (`MaTTT`) REFERENCES `trangthaituan` (`MaTTT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
