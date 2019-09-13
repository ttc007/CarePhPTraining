-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 13, 2019 lúc 09:27 AM
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
  `season_id` int(11) NOT NULL,
  `date_provide` date DEFAULT NULL,
  `isLock` tinyint(1) NOT NULL DEFAULT 1,
  `ward_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `batchs`
--

INSERT INTO `batchs` (`id`, `name`, `season_id`, `date_provide`, `isLock`, `ward_id`) VALUES
(1, 'Đợt 1', 1, '2018-02-08', 1, 4),
(2, 'Đợt 2', 1, '2018-06-18', 1, 4),
(3, 'Đợt 3', 1, '2018-09-07', 1, 4),
(4, 'Đợt 1', 2, '2019-03-04', 0, 4),
(5, 'Đợt 2', 2, '2019-06-15', 1, 4),
(6, 'Đợt 3', 2, '2019-09-18', 1, 4),
(7, 'Đợt 4', 2, '2019-12-15', 1, 4),
(8, 'Đợt 1', 3, '2018-01-02', 1, 1),
(9, 'Đợt 2', 3, '2018-03-06', 1, 1),
(10, 'Đợt 3', 3, '2018-09-16', 1, 1),
(11, 'Đợt 1', 4, '2019-01-11', 0, 1),
(12, 'Đợt 2', 4, '2019-03-11', 1, 1),
(13, 'Đợt 3', 4, '2019-09-11', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `content` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `image`, `content`) VALUES
(1, 'REGENCY COLLECTION 111', '', 'zxczxc'),
(2, 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.', '', 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.'),
(3, 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.', '', 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.'),
(4, 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.', '', 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.'),
(5, 'Creates a submit button element. ', '', 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by supplying an image path for $caption.'),
(6, 'Creates a submit button element1112', '', 'Creates a submit button element. This method will generate <input/> elements that can be used to submit, and reset forms by using $options. Image submits can be created by suppl'),
(7, 'Creates a submit button element1112', '', 'Creates a submit button element. This method will generate <input/> Creates a submit button element. This method will generate <input/> Creates a submit button element. This method will generate <input/> Creates a submit button element. This method will generate <input/> Creates a submit button element. This method will generate <input/> ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farmers`
--

CREATE TABLE `farmers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `village_id` int(11) NOT NULL,
  `ward_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `farmers`
--

INSERT INTO `farmers` (`id`, `name`, `phone`, `village_id`, `ward_id`, `group_id`) VALUES
(1, 'Nguyễn Văn A', '0912335566', 2, 4, NULL),
(2, 'Trần Văn B', '0912335566', 1, 4, 5),
(3, 'Hà Văn C', '0912335566', 1, 4, 1),
(4, 'Đặng Văn D', '0912335566', 1, 4, 2),
(5, 'Hà Văn Nghi', '0912335566', 6, 1, NULL),
(6, 'Đặng Hà', '0912335566', 3, 1, NULL),
(7, 'Nguyễn Hà Phu', '0912335566', 1, 4, 1),
(8, 'Lương Văn Nghĩa', '0912335566', 1, 4, 2),
(9, 'Lương Văn Ka', '0912335567', 1, 4, 5),
(10, 'Nguyễn Thái Lũy', '0912335568', 1, 4, 5),
(11, 'Trần Hùng', '0912335569', 1, 4, 2),
(12, 'Trần Văn K', '0912335562', 1, 4, 1),
(13, 'Trần Văn Bin', '0912335567', 1, 4, 5),
(14, 'Trần Văn Bền', '0912335567', 1, 4, 5),
(15, 'Lã Văn Bưởi', '0912335567', 1, 4, 5),
(16, 'Hướng Văn Đới', '0912335567', 1, 4, 5),
(17, 'Trần Trọng Khiêm', '0912335567', 1, 4, 1),
(18, 'Lương Hữu Lượng', '0912335567', 1, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `farmer_fertilizers`
--

CREATE TABLE `farmer_fertilizers` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `fertilizer_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `farmer_fertilizers`
--

INSERT INTO `farmer_fertilizers` (`id`, `farmer_id`, `village_id`, `fertilizer_id`, `season_id`, `batch_id`, `price`, `unit`, `quantity`, `total`) VALUES
(47, 6, 6, 4, 0, 11, 20000, 'Kg', '10', 200000),
(48, 6, 6, 5, 0, 11, 30000, 'Kg', '20', 600000),
(49, 6, 6, 6, 0, 11, 40000, 'Gói', '3', 120000),
(79, 3, 1, 1, 2, 4, 20000, 'Kg', '10', 200000),
(80, 3, 1, 2, 2, 4, 30000, 'Kg', '20', 600000),
(81, 3, 1, 3, 2, 4, 25000, 'Gói', '2', 50000),
(82, 4, 1, 1, 2, 4, 20000, 'Kg', '10', 200000),
(83, 4, 1, 2, 2, 4, 30000, 'Kg', '12', 360000),
(84, 4, 1, 3, 2, 4, 25000, 'Gói', '5', 125000),
(85, 2, 1, 1, 2, 4, 20000, 'Kg', '60', 1200000),
(86, 2, 1, 2, 2, 4, 30000, 'Kg', '10', 300000),
(87, 1, 2, 1, 2, 4, 20000, 'Kg', '10', 200000),
(88, 1, 2, 2, 2, 4, 30000, 'Kg', '20', 600000),
(89, 1, 2, 3, 2, 4, 25000, 'Gói', '4', 100000),
(104, 7, 1, 1, 2, 4, 20000, 'Kg', '10', 200000),
(105, 7, 1, 2, 2, 4, 30000, 'Kg', '30', 900000),
(106, 7, 1, 3, 2, 4, 25000, 'Gói', '5', 125000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fertilizers`
--

CREATE TABLE `fertilizers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(25) DEFAULT NULL,
  `ward_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `fertilizers`
--

INSERT INTO `fertilizers` (`id`, `name`, `price`, `unit`, `ward_id`) VALUES
(1, 'Phân bón NPK', 20000, 'Kg', 4),
(2, 'Phân Kali', 30000, 'Kg', 4),
(3, 'Phân bón hữu cơ vi sinh', 25000, 'Gói', 4),
(4, 'Phân Kali', 20000, 'Kg', 1),
(5, 'Phân bón NPK', 30000, 'Kg', 1),
(6, 'Phân bón hữu cơ vi sinh', 40000, 'Gói', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `village_id` int(11) NOT NULL,
  `ward_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `groups`
--

INSERT INTO `groups` (`id`, `name`, `village_id`, `ward_id`) VALUES
(1, 'Tổ 1', 1, 4),
(2, 'Tổ 2', 1, 4),
(3, 'Tổ 1', 2, 4),
(4, 'Tổ 2', 2, 4),
(5, 'Tổ 3', 1, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seasons`
--

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `ward_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `seasons`
--

INSERT INTO `seasons` (`id`, `name`, `ward_id`) VALUES
(1, 'Mùa vụ năm 2018', 4),
(2, 'Mùa vụ năm 2019', 4),
(3, 'Mùa vụ năm 2018', 1),
(4, 'Mùa vụ năm 2019', 1);

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
  `ward_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `ward_id`) VALUES
(3, 'ttc1909', '', '$2y$10$DqYLeJieM7N3Lof3JuIPo.G4GRM6QPx1z7rp7ZpHK.6vJ43eDawL2', NULL, NULL),
(4, 'ttc567', '', '$2y$10$elJ7HhfZ.aI62ifvc4PVv.aLobl/bhdE0XUg9nue2pqvRCRnpXB3e', NULL, NULL),
(5, 'ttc890', '', '$2y$10$EI2H8upCJiqSK0JDxRA2E.oELP1auOtpVVwjYq19HcUmmsB4p8AW.', NULL, NULL),
(6, 'ttc3376', '', '$2y$10$ybiq/dSj.cp.UOC/bQZzte9O2Xkes55RIRLWQX34.MLBBp34HX49S', NULL, NULL),
(7, 'daihiep_htx', '', '$2y$10$rNqTnodLEZ5OcTATZ6t.4ebh78nNNpzOCPBUgDk9M/m7jMDH0NHV.', NULL, 1),
(9, 'daiquang_htx', '', '$2y$10$lNaJrqdqWuaDC9a8WdepWu9KqiPmb2lZkxNBJ3SzRPkmtTHoHfpOm', NULL, 3),
(10, 'ainghia_htx', '', '$2y$10$tSbs.kj60b9CHLrhW0QiyO9i0MYN2LbYapzQMti78vnNsG2WeKJki', NULL, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `villages`
--

CREATE TABLE `villages` (
  `id` int(11) NOT NULL,
  `name` varchar(55) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `ward_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `villages`
--

INSERT INTO `villages` (`id`, `name`, `ward_id`) VALUES
(1, 'Khu Nghĩa Phước', 4),
(2, 'Khu Nghĩa Đông', 4),
(3, 'Thôn Đông Phú', 1),
(4, 'Thôn Phú Đông', 1),
(5, 'Thôn Phú Hải', 1),
(6, 'Thôn Phú Mỹ', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wards`
--

CREATE TABLE `wards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `wards`
--

INSERT INTO `wards` (`id`, `name`) VALUES
(1, 'Xã Đại Hiệp'),
(3, 'Xã Đại Quang'),
(4, 'Thị trấn Ái Nghĩa');

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
-- Chỉ mục cho bảng `groups`
--
ALTER TABLE `groups`
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
-- Chỉ mục cho bảng `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `batchs`
--
ALTER TABLE `batchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `farmer_fertilizers`
--
ALTER TABLE `farmer_fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT cho bảng `fertilizers`
--
ALTER TABLE `fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `villages`
--
ALTER TABLE `villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
