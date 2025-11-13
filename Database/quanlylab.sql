-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 04:57 AM
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
-- Table structure for table `khoa`
--

CREATE TABLE `khoa` (
  `MaKhoa` varchar(50) NOT NULL,
  `TenKhoa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loai`
--

CREATE TABLE `loai` (
  `MaLoai` varchar(50) NOT NULL,
  `TenLoai` varchar(100) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

CREATE TABLE `lop` (
  `MaLop` varchar(50) NOT NULL,
  `TenLop` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `MaLop` varchar(50) DEFAULT NULL,
  `NgayTao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhomphong`
--

CREATE TABLE `nhomphong` (
  `MaNhom` varchar(50) NOT NULL,
  `TenNhom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieumuon`
--

CREATE TABLE `phieumuon` (
  `MaPhieu` varchar(50) NOT NULL,
  `MaPhong` varchar(50) NOT NULL,
  `MaND` varchar(50) NOT NULL,
  `MaTTPM` varchar(50) NOT NULL,
  `MucDich` text NOT NULL,
  `NgayBD` date NOT NULL,
  `NgayKT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `MaPhong` varchar(50) NOT NULL,
  `TenPhong` varchar(100) NOT NULL,
  `MaNhom` varchar(50) NOT NULL,
  `MaTTP` varchar(50) NOT NULL,
  `SucChua` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `MaThietBi` varchar(50) NOT NULL,
  `TenThietBi` varchar(100) NOT NULL,
  `MaLoai` varchar(50) NOT NULL,
  `MaTTTB` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thietbi_phong`
--

CREATE TABLE `thietbi_phong` (
  `MaPhong` varchar(50) NOT NULL,
  `MaThietBi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thoigianmuon`
--

CREATE TABLE `thoigianmuon` (
  `MaPhieu` varchar(50) NOT NULL,
  `MaTiet` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `trangthaiphieumuon`
--

CREATE TABLE `trangthaiphieumuon` (
  `MaTTPM` varchar(50) NOT NULL,
  `TenTTPM` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trangthaiphong`
--

CREATE TABLE `trangthaiphong` (
  `MaTTP` varchar(50) NOT NULL,
  `TenTTP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trangthaithietbi`
--

CREATE TABLE `trangthaithietbi` (
  `MaTTTB` varchar(50) NOT NULL,
  `TenTTTB` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaitro`
--

CREATE TABLE `vaitro` (
  `MaVT` varchar(50) NOT NULL,
  `TenVT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`MaLop`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaND`),
  ADD KEY `fk_NguoiDung_VaiTro` (`MaVT`),
  ADD KEY `fk_NguoiDung_Khoa` (`MaKhoa`),
  ADD KEY `fk_NguoiDung_Lop` (`MaLop`);

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
  ADD KEY `fk_PhieuMuon_NguoiDung` (`MaND`),
  ADD KEY `fk_PhieuMuon_TrangThaiPhieuMuon` (`MaTTPM`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`MaPhong`),
  ADD KEY `fk_Phong_NhomPhong` (`MaNhom`),
  ADD KEY `fk_Phong_TrangThaiPhong` (`MaTTP`);

--
-- Indexes for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`MaThietBi`),
  ADD KEY `fk_ThietBi_Loai` (`MaLoai`),
  ADD KEY `fk_ThietBi_TrangThaiThietBi` (`MaTTTB`);

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
  ADD PRIMARY KEY (`MaPhieu`,`MaTiet`),
  ADD KEY `fk_ThoiGianMuon_TietHoc` (`MaTiet`);

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
-- Indexes for table `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`MaVT`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `fk_NguoiDung_Khoa` FOREIGN KEY (`MaKhoa`) REFERENCES `khoa` (`MaKhoa`),
  ADD CONSTRAINT `fk_NguoiDung_Lop` FOREIGN KEY (`MaLop`) REFERENCES `lop` (`MaLop`),
  ADD CONSTRAINT `fk_NguoiDung_VaiTro` FOREIGN KEY (`MaVT`) REFERENCES `vaitro` (`MaVT`);

--
-- Constraints for table `phieumuon`
--
ALTER TABLE `phieumuon`
  ADD CONSTRAINT `fk_PhieuMuon_NguoiDung` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`),
  ADD CONSTRAINT `fk_PhieuMuon_Phong` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`),
  ADD CONSTRAINT `fk_PhieuMuon_TrangThaiPhieuMuon` FOREIGN KEY (`MaTTPM`) REFERENCES `trangthaiphieumuon` (`MaTTPM`);

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `fk_Phong_NhomPhong` FOREIGN KEY (`MaNhom`) REFERENCES `nhomphong` (`MaNhom`),
  ADD CONSTRAINT `fk_Phong_TrangThaiPhong` FOREIGN KEY (`MaTTP`) REFERENCES `trangthaiphong` (`MaTTP`);

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_ThietBi_Loai` FOREIGN KEY (`MaLoai`) REFERENCES `loai` (`MaLoai`),
  ADD CONSTRAINT `fk_ThietBi_TrangThaiThietBi` FOREIGN KEY (`MaTTTB`) REFERENCES `trangthaithietbi` (`MaTTTB`);

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
  ADD CONSTRAINT `fk_ThoiGianMuon_PhieuMuon` FOREIGN KEY (`MaPhieu`) REFERENCES `phieumuon` (`MaPhieu`),
  ADD CONSTRAINT `fk_ThoiGianMuon_TietHoc` FOREIGN KEY (`MaTiet`) REFERENCES `tiethoc` (`MaTiet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
