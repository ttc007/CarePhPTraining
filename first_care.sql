-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 06, 2019 lúc 01:02 PM
-- Phiên bản máy phục vụ: 10.3.16-MariaDB
-- Phiên bản PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `first_care`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `batchs`
--

CREATE TABLE `batchs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `season_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `batchs`
--

INSERT INTO `batchs` (`id`, `name`, `season_id`) VALUES
(1, 'Đợt 1', 1),
(2, 'Đợt 2', 1),
(3, 'Đợt 3', 1),
(4, 'Đợt 1', 2),
(5, 'Đợt 2', 2),
(6, 'Đợt 3', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `image`, `content`, `user_id`) VALUES
(1, 'REGENCY COLLECTION 111', NULL, 'zxczxc', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farmers`
--

CREATE TABLE `farmers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `village_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `farmers`
--

INSERT INTO `farmers` (`id`, `name`, `phone`, `address`, `village_id`) VALUES
(1, 'Nguyễn Văn A', '0912335566', NULL, 2),
(2, 'Trần Văn B', '0912335566', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farmer_fertilizers`
--

CREATE TABLE `farmer_fertilizers` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `fertilizer_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `farmer_fertilizers`
--

INSERT INTO `farmer_fertilizers` (`id`, `farmer_id`, `fertilizer_id`, `season_id`, `batch_id`, `price`, `quantity`) VALUES
(15, 2, 1, 0, 4, 20000, '3'),
(16, 2, 2, 0, 4, 30000, '4'),
(17, 2, 1, 0, 4, 20000, '3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fertilizers`
--

CREATE TABLE `fertilizers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `fertilizers`
--

INSERT INTO `fertilizers` (`id`, `name`, `price`, `unit`) VALUES
(1, 'Phân bón NPK', 20000, 'Kg'),
(2, 'Phân Kali', 30000, 'Kg'),
(3, 'Phân bón hữu cơ vi sinh', 25000, 'Kg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seasons`
--

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `seasons`
--

INSERT INTO `seasons` (`id`, `name`) VALUES
(1, 'Mùa vụ năm 2018'),
(2, 'Mùa vụ năm 2019');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `role`) VALUES
(2, 'ttc123', '', '123456', NULL, NULL),
(3, 'ttc1909', '', '$2y$10$DqYLeJieM7N3Lof3JuIPo.G4GRM6QPx1z7rp7ZpHK.6vJ43eDawL2', NULL, NULL),
(4, 'ttc567', '', '$2y$10$elJ7HhfZ.aI62ifvc4PVv.aLobl/bhdE0XUg9nue2pqvRCRnpXB3e', NULL, NULL),
(5, 'ttc890', '', '$2y$10$EI2H8upCJiqSK0JDxRA2E.oELP1auOtpVVwjYq19HcUmmsB4p8AW.', NULL, NULL),
(6, 'ttc3376', '', '$2y$10$ybiq/dSj.cp.UOC/bQZzte9O2Xkes55RIRLWQX34.MLBBp34HX49S', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `villages`
--

CREATE TABLE `villages` (
  `id` int(11) NOT NULL,
  `name` varchar(55) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `villages`
--

INSERT INTO `villages` (`id`, `name`) VALUES
(1, 'Nghĩa Phước'),
(2, 'Nghĩa Đông');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `batchs`
--
ALTER TABLE `batchs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `farmer_fertilizers`
--
ALTER TABLE `farmer_fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `fertilizers`
--
ALTER TABLE `fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `batchs`
--
ALTER TABLE `batchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `farmer_fertilizers`
--
ALTER TABLE `farmer_fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `fertilizers`
--
ALTER TABLE `fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `villages`
--
ALTER TABLE `villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
