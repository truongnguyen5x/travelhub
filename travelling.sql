-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 10, 2018 lúc 05:39 AM
-- Phiên bản máy phục vụ: 10.1.33-MariaDB
-- Phiên bản PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `travelling`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `plan_id`, `content`, `parent_comment_id`, `location_id`, `date_created`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'thời gian phượt bao lâu', NULL, NULL, '2018-07-23 14:45:23', NULL, NULL),
(2, 2, 2, 'thời gian phượt bao lâu', NULL, NULL, '2018-07-21 14:30:23', NULL, NULL),
(3, 3, 1, 'thời gian phượt bao lâu', NULL, NULL, '2018-07-22 14:15:23', NULL, NULL),
(4, 3, 1, 'thời gian phượt bao lâu', NULL, NULL, '2018-07-22 14:15:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follows`
--

CREATE TABLE `follows` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `follows`
--

INSERT INTO `follows` (`id`, `user_id`, `plan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 13, NULL, NULL),
(2, 2, 14, NULL, NULL),
(3, 3, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `markers`
--

CREATE TABLE `markers` (
  `id` int(10) UNSIGNED NOT NULL,
  `lat` double(18,15) NOT NULL,
  `lng` double(18,15) NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `index_in_plan` int(11) DEFAULT NULL,
  `place_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_detail` text COLLATE utf8mb4_unicode_ci,
  `has_link` tinyint(1) NOT NULL DEFAULT '0',
  `arriver_time` datetime DEFAULT NULL,
  `leave_time` datetime DEFAULT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `travel_mode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRIVING',
  `vehicle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_waypoints` tinyint(1) NOT NULL DEFAULT '0',
  `route_index` int(11) NOT NULL DEFAULT '0',
  `waypoints` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `markers`
--

INSERT INTO `markers` (`id`, `lat`, `lng`, `label`, `created_at`, `updated_at`, `plan_id`, `index_in_plan`, `place_id`, `place_detail`, `has_link`, `arriver_time`, `leave_time`, `activity`, `travel_mode`, `vehicle`, `has_waypoints`, `route_index`, `waypoints`) VALUES
(21, 21.027764400000000, 105.834159799999950, NULL, NULL, NULL, 13, 0, 'ChIJoRyG2ZurNTERqRfKcnt_iOc', '{\"formatted_address\":\"Hà Nội, Hoàn Kiếm, Hà Nội, Việt Nam\",\"name\":\"Hà Nội\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Xe máy', 0, 0, NULL),
(22, 21.199229800000000, 105.423211600000060, NULL, NULL, NULL, 13, 1, 'ChIJNbd72ZmKNDERGPiCUi1L57s', '{\"formatted_address\":\"Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Ba Vì\"}', 1, '2018-08-15 18:51:00', '2018-08-15 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(23, 21.767004600000000, 104.146604600000050, NULL, NULL, NULL, 13, 2, 'ChIJ35HrcXzaMjERng84RfjJcBM', '{\"formatted_address\":\"Mù Cang Chải, Yên Bái, Việt Nam\",\"name\":\"Mù Cang Chải\"}', 1, '2018-08-16 18:51:00', '2018-08-16 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(24, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 14, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(25, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 14, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 19:08:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(26, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 14, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(27, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 15, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(28, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 15, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 22:00:00', 'Ăn chơi nhảy múa', 'DRIVING', 'Ô tô', 0, 0, NULL),
(29, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 15, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(30, 21.027764400000000, 105.834159799999950, NULL, NULL, NULL, 16, 0, 'ChIJoRyG2ZurNTERqRfKcnt_iOc', '{\"formatted_address\":\"Hà Nội, Hoàn Kiếm, Hà Nội, Việt Nam\",\"name\":\"Hà Nội\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Xe máy', 0, 0, NULL),
(31, 21.199229800000000, 105.423211600000060, NULL, NULL, NULL, 16, 1, 'ChIJNbd72ZmKNDERGPiCUi1L57s', '{\"formatted_address\":\"Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Ba Vì\"}', 1, '2018-08-15 18:51:00', '2018-08-15 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(32, 21.767004600000000, 104.146604600000050, NULL, NULL, NULL, 16, 2, 'ChIJ35HrcXzaMjERng84RfjJcBM', '{\"formatted_address\":\"Mù Cang Chải, Yên Bái, Việt Nam\",\"name\":\"Mù Cang Chải\"}', 1, '2018-08-16 18:51:00', '2018-08-16 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(33, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 17, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(34, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 17, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 19:08:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(35, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 17, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(36, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 18, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(37, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 18, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 22:00:00', 'Ăn chơi nhảy múa', 'DRIVING', 'Ô tô', 0, 0, NULL),
(38, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 19, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(39, 21.027764400000000, 105.834159799999950, NULL, NULL, NULL, 20, 0, 'ChIJoRyG2ZurNTERqRfKcnt_iOc', '{\"formatted_address\":\"Hà Nội, Hoàn Kiếm, Hà Nội, Việt Nam\",\"name\":\"Hà Nội\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Xe máy', 0, 0, NULL),
(40, 21.199229800000000, 105.423211600000060, NULL, NULL, NULL, 20, 1, 'ChIJNbd72ZmKNDERGPiCUi1L57s', '{\"formatted_address\":\"Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Ba Vì\"}', 1, '2018-08-15 18:51:00', '2018-08-15 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(41, 21.767004600000000, 104.146604600000050, NULL, NULL, NULL, 20, 2, 'ChIJ35HrcXzaMjERng84RfjJcBM', '{\"formatted_address\":\"Mù Cang Chải, Yên Bái, Việt Nam\",\"name\":\"Mù Cang Chải\"}', 1, '2018-08-16 18:51:00', '2018-08-16 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(42, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 21, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(43, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 21, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 19:08:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(44, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 21, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(45, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 22, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(46, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 22, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 22:00:00', 'Ăn chơi nhảy múa', 'DRIVING', 'Ô tô', 0, 0, NULL),
(47, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 22, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(48, 21.027764400000000, 105.834159799999950, NULL, NULL, NULL, 23, 0, 'ChIJoRyG2ZurNTERqRfKcnt_iOc', '{\"formatted_address\":\"Hà Nội, Hoàn Kiếm, Hà Nội, Việt Nam\",\"name\":\"Hà Nội\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Xe máy', 0, 0, NULL),
(49, 21.199229800000000, 105.423211600000060, NULL, NULL, NULL, 23, 1, 'ChIJNbd72ZmKNDERGPiCUi1L57s', '{\"formatted_address\":\"Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Ba Vì\"}', 1, '2018-08-15 18:51:00', '2018-08-15 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(50, 21.767004600000000, 104.146604600000050, NULL, NULL, NULL, 23, 2, 'ChIJ35HrcXzaMjERng84RfjJcBM', '{\"formatted_address\":\"Mù Cang Chải, Yên Bái, Việt Nam\",\"name\":\"Mù Cang Chải\"}', 1, '2018-08-16 18:51:00', '2018-08-16 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(51, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 24, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(52, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 24, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 19:08:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(53, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 24, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(54, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 25, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(55, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 25, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 22:00:00', 'Ăn chơi nhảy múa', 'DRIVING', 'Ô tô', 0, 0, NULL),
(56, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 25, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(57, 21.474368917160188, 105.855361041125550, NULL, NULL, NULL, 26, 0, 'ChIJvbU5d74hNTERI_0ZQtJvPwU', '{\"formatted_address\":\"Bách Quang, Tp . Sông Công, Thái Nguyên, Việt Nam\",\"name\":\"Bách Quang\"}', 0, '2018-08-13 18:50:00', '2018-08-13 18:50:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL),
(58, 21.079127146696110, 105.387405180654130, NULL, NULL, NULL, 26, 1, 'ChIJu5Lckr5gNDERojhxioGwjLk', '{\"formatted_address\":\"Thiên Sơn Suối Ngà, Vân Hòa, Ba Vì, Hà Nội, Việt Nam\",\"name\":\"Thiên Sơn Suối Ngà\"}', 0, '2018-08-15 19:08:00', '2018-08-15 22:00:00', 'Ăn chơi nhảy múa', 'DRIVING', 'Ô tô', 0, 0, NULL),
(59, 20.801566586212267, 105.307001147189230, NULL, NULL, NULL, 26, 2, 'ChIJhaYWcz1rNDERKe8dHbMMKRM', '{\"formatted_address\":\"Tp . Hòa Bình, Hòa Bình, Việt Nam\",\"name\":\"Thành phố Hòa Bình\"}', 0, '2018-08-21 18:51:00', '2018-08-21 18:51:00', '', 'DRIVING', 'Ô tô', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(287, '2014_10_12_000000_create_users_table', 1),
(288, '2014_10_12_100000_create_password_resets_table', 1),
(289, '2018_07_18_024737_create__notifications_table', 1),
(290, '2018_07_18_025025_create__participants_table', 1),
(291, '2018_07_18_025209_create_follows_table', 1),
(292, '2018_07_18_025358_create_requests_table', 1),
(293, '2018_07_18_025934_create_comments_table', 1),
(294, '2018_07_18_030629_create_images_table', 1),
(295, '2018_07_18_030859_create_plans_table', 1),
(296, '2018_07_18_032513_create_markers_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bạn đã được tham gia vào kế hoạch', NULL, NULL),
(2, 1, 'một người bạn của bạn đã bình luận về kế hoạch của bạn', NULL, NULL),
(3, 1, 'một người bạn của bạn đang theo dõi kế hoạch của bạn', NULL, NULL),
(4, 1, 'một người bạn của bạn muốn tham gia kế hoạch của bạn', NULL, NULL),
(5, 2, 'Bạn đã được tham gia vào kế hoạch', NULL, NULL),
(6, 2, 'một người bạn của bạn đã bình luận về kế hoạch của bạn', NULL, NULL),
(7, 2, 'một người bạn của bạn đang theo dõi kế hoạch của bạn', NULL, NULL),
(8, 2, 'một người bạn của bạn muốn tham gia kế hoạch của bạn', NULL, NULL),
(9, 3, 'Bạn đã được tham gia vào kế hoạch', NULL, NULL),
(10, 3, 'một người bạn của bạn đã bình luận về kế hoạch của bạn', NULL, NULL),
(11, 3, 'một người bạn của bạn đang theo dõi kế hoạch của bạn', NULL, NULL),
(12, 3, 'một người bạn của bạn muốn tham gia kế hoạch của bạn', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `participants`
--

CREATE TABLE `participants` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `participants`
--

INSERT INTO `participants` (`id`, `user_id`, `plan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 23, NULL, NULL),
(2, 2, 24, NULL, NULL),
(3, 3, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lên kế hoạch',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `plans`
--

INSERT INTO `plans` (`id`, `user_id`, `name`, `cover_image`, `state`, `created_at`, `updated_at`, `start_time`, `end_time`) VALUES
(13, 4, 'Mù căng chải', 'public/plans/mucangchai.jpeg', 'Lên kế hoạch', '2018-08-12 11:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(14, 1, 'Chơi sông Đà', 'public/plans/songda.jpg', 'Lên kế hoạch', '2018-08-12 12:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(15, 2, 'Đi chơi Lạng Sơn', 'public/plans/langson.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(16, 3, 'Du lịch chùa Trâm', 'public/plans/chuatram.jpg', 'Lên kế hoạch', '2018-08-09 19:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(17, 4, 'Chơi Sa Pa', 'public/plans/sapa.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(18, 1, 'Dã ngoại tràng An', 'public/plans/trangan.jpg', 'Lên kế hoạch', '2018-08-12 01:50:00', NULL, '2018-08-13 01:50:00', '2018-08-24 18:50:00'),
(19, 2, 'Tam đảo', 'public/plans/tamdao.jpg', 'Lên kế hoạch', '2018-08-10 05:20:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(20, 3, 'Đi Hạ Long', 'public/plans/halong.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(21, 4, 'Đi vịnh Lăng cô', 'public/plans/langco.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(22, 1, 'Đảo Phú Quốc', 'public/plans/phuquoc.jpg', 'Lên kế hoạch', '2018-08-11 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(23, 2, 'Đi chơi Lạng Sơn', 'public/plans/langson.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(24, 3, 'Tam cốc bích động', 'public/plans/tamcoc.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-24 18:50:00'),
(25, 4, 'Trở về PHong Nha kẻ bàng', 'public/plans/phongnha.jpg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-09-24 18:50:00'),
(26, 1, 'Chuyến đi Móng cái', 'public/plans/mongcai.jpeg', 'Lên kế hoạch', '2018-08-13 05:50:00', NULL, '2018-08-13 18:50:00', '2018-08-28 18:50:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `plan_id`, `state`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 0, NULL, NULL),
(2, 2, 14, 1, NULL, NULL),
(3, 3, 15, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roads`
--

CREATE TABLE `roads` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_marker_id` int(11) NOT NULL,
  `end_marker_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `vehicle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` int(11) NOT NULL,
  `index_in_plan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roads`
--

INSERT INTO `roads` (`id`, `start_marker_id`, `end_marker_id`, `start_time`, `end_time`, `vehicle`, `action`, `plan_id`, `index_in_plan`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2018-07-24 07:00:00', NULL, NULL, 'Ăn chơi', 3, 0, NULL, NULL),
(2, 2, NULL, '2018-07-24 07:00:00', NULL, NULL, 'Ăn chơi', 2, 0, NULL, NULL),
(3, 3, NULL, '2018-07-24 07:00:00', NULL, NULL, 'Ăn chơi', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone_number`, `gender`, `avatar`, `date_of_birth`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'TrongQT', 'trongqtbkap@gmail.com', '$2y$10$KdNpzstcCcZHJpcLVVfDmupVPfIe4yES3BYF6IVDfzL1Fdno5iGTa', 'Trần Quang Trọng', 1653586444, 0, 'image/avatar/trong.jpg', '1997-12-22', NULL, NULL, NULL),
(2, 'TruongNV', 'truongnv@gmail.com', '$2y$10$ASkN1p4MmITXf3R1/LAlA.p6D7Ho0zobl6ASK6uRUI0HdFVjY/Cje', 'Nguyễn Văn Trường', 1653586555, 0, 'image/avatar/truong.jpeg', '1997-08-10', NULL, NULL, NULL),
(3, 'TaiMT', 'taimt@gmail.com', '$2y$10$UJb5INRvUjmrJJjwiESD3eFct1yioDFN1KmcZqVXhGExX6BzfP42i', 'Mẫn Tiến Tài', 1653586666, 0, 'image/avatar/tai.jpeg', '1996-03-07', NULL, NULL, NULL),
(4, 'DungThu', 'dungt@gmail.com', '$2y$10$11LEWbqhHq8Efki0tcvCh.l4OCRcMSUJVqCndPZ30peYQmOupuwiy', 'Nguyễn Văn Dũng', 1653586666, 0, 'image/avatar/dung.jpeg', '1996-03-07', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `roads`
--
ALTER TABLE `roads`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `roads`
--
ALTER TABLE `roads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
