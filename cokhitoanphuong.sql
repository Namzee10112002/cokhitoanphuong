-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th8 24, 2025 lúc 07:31 AM
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
-- Cơ sở dữ liệu: `cokhitoanphuong`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(18, 2, 1, 10),
(19, 2, 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_product`
--

CREATE TABLE `category_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_category` varchar(255) NOT NULL,
  `status_category` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category_product`
--

INSERT INTO `category_product` (`id`, `name_category`, `status_category`) VALUES
(1, 'Dụng cụ cầm tay', 0),
(2, 'Thiết bị khí nén', 0),
(3, 'Vật tư hàn cắt', 0),
(4, 'Bạc đạn - Vòng bi', 0),
(5, 'Thiết bị nâng hạ', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_product`
--

CREATE TABLE `import_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date_import` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import_product`
--

INSERT INTO `import_product` (`id`, `product_id`, `user_id`, `quantity`, `date_import`) VALUES
(2, 6, 1, 10, '2025-07-28 16:39:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_pdf` longblob NOT NULL,
  `date_export` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(4) NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_07_23_000000_create_cache_locks_table', 1),
(2, '2025_07_23_000000_create_cache_table', 1),
(3, '2025_07_23_000000_create_failed_jobs_table', 1),
(4, '2025_07_23_000000_create_job_batches_table', 1),
(5, '2025_07_23_000000_create_jobs_table', 1),
(6, '2025_07_23_000000_create_password_reset_tokens_table', 1),
(7, '2025_07_23_000000_create_sessions_table', 1),
(8, '2025_07_23_000001_create_users_table', 1),
(9, '2025_07_23_000002_create_category_product_table', 1),
(10, '2025_07_23_000003_create_suppliers_table', 1),
(11, '2025_07_23_000004_create_promotion_table', 1),
(12, '2025_07_23_000005_create_products_table', 1),
(13, '2025_07_23_000006_create_orders_table', 1),
(14, '2025_07_23_000007_create_order_details_table', 1),
(15, '2025_07_23_000008_create_order_feedbacks_table', 1),
(16, '2025_07_23_000009_create_carts_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method_pay` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 là thanh toán khi nhận hàng, 1 là chuyển khoản, 2 là ví điện tử',
  `status_order` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 là chờ xác nhận, 1 đã xác nhận, 2 đang vận chuyển, 3 đã giao hàng, 4 Hủy',
  `address_order` varchar(255) NOT NULL,
  `phone_order` varchar(10) NOT NULL,
  `name_order` varchar(255) NOT NULL,
  `total_order` double NOT NULL,
  `note_order` varchar(255) DEFAULT NULL,
  `date_order` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `method_pay`, `status_order`, `address_order`, `phone_order`, `name_order`, `total_order`, `note_order`, `date_order`) VALUES
(9, 2, 0, 0, 'Số 17', '0365245602', 'Nguyễn Vũ Đại Dương', 3605000, NULL, '2025-07-26 22:11:16'),
(10, 2, 0, 0, 'Số 17', '0365245602', 'Nguyễn Vũ Đại Dương', 5308000, NULL, '2025-07-26 22:31:59'),
(12, 2, 2, 0, 'Số 17', '0365245602', 'Nguyễn Vũ Đại Dương', 45000, NULL, '2025-07-27 13:57:23'),
(13, 2, 2, 0, 'Số 17', '0365245602', 'Nguyễn Vũ Đại Dương', 85000, NULL, '2025-07-27 13:57:58'),
(14, 4, 2, 0, 'Hai Phong', '0365245602', 'Thanh Cao Dat', 108000, NULL, '2025-07-29 21:05:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_detail` double NOT NULL,
  `status_detail` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 là sản phẩm oke, 1 là sản phẩm có lỗi chờ thu hồi, 2 sản phẩm được thu hồi chờ xử lý,3 đã xử lý xong.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `total_detail`, `status_detail`) VALUES
(9, 9, 5, 2, 3520000, 0),
(10, 9, 4, 1, 85000, 0),
(11, 10, 2, 1, 5200000, 1),
(12, 10, 1, 1, 108000, 0),
(14, 12, 3, 1, 45000, 0),
(15, 13, 4, 1, 85000, 0),
(16, 14, 1, 1, 108000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_feedbacks`
--

CREATE TABLE `order_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(1000) NOT NULL,
  `time_message` datetime NOT NULL DEFAULT current_timestamp(),
  `belong` tinyint(4) NOT NULL COMMENT '0 là khách, 1 là admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_feedbacks`
--

INSERT INTO `order_feedbacks` (`id`, `order_id`, `message`, `time_message`, `belong`) VALUES
(1, 10, 'hello', '2025-07-26 17:29:07', 0),
(2, 10, 'Bạn ơi hỗ trợ mình đơn hàng này nhé', '2025-07-26 17:29:24', 0),
(3, 10, 'oke bạn', '2025-07-26 17:37:05', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_product` varchar(255) NOT NULL,
  `image_product` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `name_product` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `promotion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(255) NOT NULL,
  `status_product` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 là khả dụng, 1 là bị khóa, 2 là đang sale'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `code_product`, `image_product`, `description`, `name_product`, `price`, `promotion_id`, `category_id`, `supplier_id`, `quantity`, `sold`, `unit`, `status_product`) VALUES
(1, 'SP_1', 'https://tse1.mm.bing.net/th/id/OIP.szbNk_zImn2rGkXYnkb0PgHaHa?pid=Api&P=0&h=180', 'Kìm cắt đa năng dùng cho các loại dây điện và kim loại mềm.', 'Kìm cắt đa năng', 120000, NULL, 1, 3, 97, 2, 'Cái', 0),
(2, 'SP_2', 'https://sieuthimaynenkhitrucvit.com/wp-content/uploads/2021/07/z2414978140854_ae3a80f13aa734fc37f4f927cb568792.jpg', 'Máy nén khí piston công suất 3HP, phù hợp cho xưởng nhỏ.', 'Máy nén khí Piston 3HP', 6500000, 2, 2, 1, 99, 1, 'Bộ', 0),
(3, 'SP_3', 'https://img.alicdn.com/imgextra/i3/3950812417/O1CN01eTJtMf1Tj28Wkag7c_!!3950812417.jpg_800x800.jpg_.webp', 'Que hàn điện J422 dùng cho thép cacbon.', 'Que hàn J422', 45000, 1, 3, 5, 99, 1, 'Kg', 0),
(4, 'SP_4', 'https://tse4.mm.bing.net/th/id/OIP.txjuif5YMCjme-hE-kJQCAHaHa?pid=Api&P=0&h=180', 'Vòng bi bạc đạn NSK 6205 chính hãng, chịu tải tốt.', 'Vòng bi NSK 6205', 85000, NULL, 4, 2, 93, 2, 'Cái', 0),
(5, 'SP_5', 'https://down-vn.img.susercontent.com/file/vn-11134207-7r98o-lua5qloyk9w1c2', 'Palang xích kéo tay 1 tấn dùng nâng hạ hàng hóa.', 'Palang xích kéo tay 1T', 2200000, 2, 5, 4, 96, 2, 'Bộ', 0),
(6, 'Sp_10', 'https://tse1.mm.bing.net/th/id/OIP.2Q6uBNbhfR_SJV1BKQW-7QHaE7?pid=Api&P=0&h=180', 'Sản phẩm mới đó', 'Sản phẩm mới', 100000, NULL, 1, 1, 10, 0, 'Cân', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_promotion` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `status_promotion` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotion`
--

INSERT INTO `promotion` (`id`, `name_promotion`, `value`, `status_promotion`) VALUES
(1, 'Giảm 10%', 10, 0),
(2, 'Giảm 20%', 20, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kAydf3HoxCHftsWhoL03KsYGn8JzoOCHBEfcMNOX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3ZCbEdLOURJNDJqQmZwcTJVdXpmR1M0RllmUXNoNUxnVGp0eWNQSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1753797323),
('RyckX9Uoi27uQ82Ktr8aPKY57pG7LtnQKsVzzje3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1FScFhYdHdQRzBrZjY3cmdNaXQweXlNcnpMcU1NMXRPOHJmSDlaeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1755185488),
('Y9LRVtZwyQ70GzU4XIvqi4L8C9Fcy29FA9sv2hd6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1djbnpoYnJFY1Rpbk1KYU9vRGxEMnZtbUMwNDVkQ08wNzI4QUo5TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNToiY2hhdGJvdF9oaXN0b3J5IjthOjQ6e2k6MDthOjI6e3M6NDoicm9sZSI7czo0OiJ1c2VyIjtzOjc6Im1lc3NhZ2UiO3M6NTg6Im3DrG5oIG114buRbiB0w6xtIGhp4buDdSB24buBIDEgc+G7kSBz4bqjbiBwaOG6qW0gY8ahIGtow60iO31pOjE7YToyOntzOjQ6InJvbGUiO3M6MzoiYm90IjtzOjc6Im1lc3NhZ2UiO3M6NjYxOiJN4buZdCBz4buRIHPhuqNuIHBo4bqpbSBu4buVaSBi4bqtdDo8YnI+LSA8YSBjbGFzcz0ibGluayIgaHJlZj0iaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2R1Y3QvMSI+S8OsbSBj4bqvdCDEkWEgbsSDbmc8L2E+IChHacOhOiAxMjAsMDAwIFZORCk8YnI+LSA8YSBjbGFzcz0ibGluayIgaHJlZj0iaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2R1Y3QvMiI+TcOheSBuw6luIGtow60gUGlzdG9uIDNIUDwvYT4gKEdpw6E6IDYsNTAwLDAwMCBWTkQpPGJyPi0gPGEgY2xhc3M9ImxpbmsiIGhyZWY9Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzMiPlF1ZSBow6BuIEo0MjI8L2E+IChHacOhOiA0NSwwMDAgVk5EKTxicj4tIDxhIGNsYXNzPSJsaW5rIiBocmVmPSJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZHVjdC80Ij5Ww7JuZyBiaSBOU0sgNjIwNTwvYT4gKEdpw6E6IDg1LDAwMCBWTkQpPGJyPi0gPGEgY2xhc3M9ImxpbmsiIGhyZWY9Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzUiPlBhbGFuZyB4w61jaCBrw6lvIHRheSAxVDwvYT4gKEdpw6E6IDIsMjAwLDAwMCBWTkQpPGJyPjxicj48YSBjbGFzcz0ibGluayIgaHJlZj0iaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2R1Y3QiPlhlbSB0aMOqbSBz4bqjbiBwaOG6qW0gdOG6oWkgxJHDonk8L2E+Ijt9aToyO2E6Mjp7czo0OiJyb2xlIjtzOjQ6InVzZXIiO3M6NzoibWVzc2FnZSI7czo1OiJoZWxsbyI7fWk6MzthOjI6e3M6NDoicm9sZSI7czozOiJib3QiO3M6NzoibWVzc2FnZSI7czoxMTY6IlhpbiBjaMOgbyEgVMO0aSBjw7MgdGjhu4MgZ2nDunAgZ8OsIGNobyBi4bqhbiB24buBIHPhuqNuIHBo4bqpbSBob+G6t2MgY2jDrW5oIHPDoWNoIG11YSBow6BuZyB0cm9uZyBuZ8OgbmggY8ahIGtow60/Ijt9fX0=', 1753799541);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_supplier` varchar(255) NOT NULL,
  `status_supplier` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `name_supplier`, `status_supplier`) VALUES
(1, 'Công ty TNHH Thiết Bị Công Nghiệp Hoàng Long', 0),
(2, 'Công ty CP Cơ Khí Hà Nội (HAMECO)', 0),
(3, 'Công ty TNHH Sản Xuất Cơ Khí An Phát', 0),
(4, 'Công ty CP Thiết Bị Công Nghiệp Hưng Phát', 0),
(5, 'Công ty CP Cơ Khí Công Nghiệp Toàn Thắng', 0),
(6, 'Nhà cung cấp mới đó', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 khách hàng, 1 nhân viên, 2 quản trị viên',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 là hoạt động, 1 bị khóa',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`, `last_login`) VALUES
(1, 'Nguyễn Vũ Đại Nam1', 'nguyenvudaianm115@gmail.com', '0365245602', 'Số 17', NULL, '$2y$12$z50UBGMTmbPXETTKn9X7genO.lLtOnuKKWEn09xT1CSyRueSQAC8y', NULL, '2025-07-26 01:42:23', '2025-07-29 07:21:58', 2, 0, '2025-07-29 14:21:58'),
(2, 'Nguyễn Vũ Đại Dương', 'nguyenvudaianm113@gmail.com', '0365245602', 'Số 17', NULL, '$2y$12$Vw8gIw84uwnVvEBv2sD0HumpbH0p4L32K0WXb9.d3amONWMhtlJki', NULL, '2025-07-26 02:01:27', '2025-07-29 07:30:55', 0, 0, '2025-07-29 14:18:48'),
(3, 'Nguyễn Vũ Đại Nam', 'nguyenvudaianm116@gmail.com', '0365245602', 'Số 17', NULL, '$2y$12$dBufRc6KKWvv1BzJKtXOo.BMbwHuOLV4R3eSeW/JLe5F75JWqw2Xi', NULL, '2025-07-28 07:55:51', '2025-07-28 07:55:51', 1, 0, NULL),
(4, 'Thanh Cao Dat 1', 'dat@gmail.com', '0365245602', 'Hai Phong', NULL, '$2y$12$RsRsvxz.dMPKhBfT6Vw6yeeXp6nLGXNYGASp7rJz0Q8lONg3VGTJK', NULL, '2025-07-29 07:00:56', '2025-07-29 07:15:22', 0, 0, '2025-07-29 14:15:22');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `import_product`
--
ALTER TABLE `import_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id_import` (`product_id`),
  ADD KEY `fk_user_id_import` (`user_id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_id_invoice` (`order_id`),
  ADD KEY `fk_user_id_invoice` (`user_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `order_feedbacks`
--
ALTER TABLE `order_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_feedbacks_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_product_unique` (`code_product`),
  ADD KEY `products_promotion_id_foreign` (`promotion_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Chỉ mục cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `import_product`
--
ALTER TABLE `import_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `order_feedbacks`
--
ALTER TABLE `order_feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `import_product`
--
ALTER TABLE `import_product`
  ADD CONSTRAINT `fk_product_id_import` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_user_id_import` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_order_id_invoice` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_user_id_invoice` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `order_feedbacks`
--
ALTER TABLE `order_feedbacks`
  ADD CONSTRAINT `order_feedbacks_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_product` (`id`),
  ADD CONSTRAINT `products_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`),
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
