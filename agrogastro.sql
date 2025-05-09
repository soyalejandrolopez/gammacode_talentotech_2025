-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2025 at 10:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agrogastro`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'trest', 'trest', 'tres', NULL, NULL, 1, '2025-05-09 06:46:59', '2025-05-09 06:46:59'),
(2, 'hola.txt', 'holatxt', NULL, NULL, NULL, 1, '2025-05-09 12:07:51', '2025-05-09 12:07:51'),
(3, 'hola', 'hola', NULL, NULL, NULL, 1, '2025-05-09 12:41:27', '2025-05-09 12:41:27'),
(4, 'Verduras', 'verduras', 'Verduras frescas y de temporada', 'categories/vegetables.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22'),
(5, 'Frutas', 'frutas', 'Frutas dulces y nutritivas', 'categories/fruits.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22'),
(6, 'Lácteos', 'lacteos', 'Productos lácteos artesanales', 'categories/dairy.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22'),
(7, 'Miel y Derivados', 'miel-y-derivados', 'Miel pura y productos derivados', 'categories/honey.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22'),
(8, 'Carnes', 'carnes', 'Carnes de animales criados en libertad', 'categories/meat.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22'),
(9, 'Hierbas y Especias', 'hierbas-y-especias', 'Hierbas aromáticas y especias', 'categories/herbs.jpg', NULL, 1, '2025-05-09 13:19:22', '2025-05-09 13:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_carts`
--

CREATE TABLE `guest_carts` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_cart_items`
--

CREATE TABLE `guest_cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `guest_cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_05_08_000001_create_roles_table', 1),
(7, '2024_05_08_000002_create_role_user_table', 1),
(8, '2024_05_08_000003_create_stores_table', 1),
(9, '2024_05_08_000004_create_categories_table', 1),
(10, '2024_05_08_000005_create_products_table', 1),
(11, '2024_05_08_000006_create_orders_table', 1),
(12, '2024_05_08_000007_create_order_items_table', 1),
(13, '2023_10_15_000000_add_fields_to_users_table', 2),
(14, '2025_05_09_090138_create_guest_carts_table', 3),
(15, '2025_05_09_090147_create_guest_cart_items_table', 3),
(16, '2025_05_09_090559_add_guest_fields_to_orders_table', 4),
(17, '2025_05_09_094415_create_notifications_table', 5),
(18, '2024_05_10_000001_add_status_to_order_items_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('53702abf-f9db-4ff7-81a9-730dd9459b91', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 2, '{\"order_id\":4,\"order_number\":\"ORD-QPXZFTHUKF\",\"total_amount\":\"30000.00\",\"status\":\"pending\",\"payment_method\":\"cash\",\"created_at\":\"2025-05-09 09:52:05\",\"for_admin\":false}', NULL, '2025-05-09 14:52:05', '2025-05-09 14:52:05'),
('d7f5e70e-dfcf-459a-98a6-0fa098d0617d', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 1, '{\"order_id\":4,\"order_number\":\"ORD-QPXZFTHUKF\",\"total_amount\":\"30000.00\",\"status\":\"pending\",\"payment_method\":\"cash\",\"created_at\":\"2025-05-09 09:52:05\",\"for_admin\":true}', NULL, '2025-05-09 14:52:05', '2025-05-09 14:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_guest_order` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `total_amount`, `payment_method`, `payment_status`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zipcode`, `shipping_phone`, `notes`, `guest_email`, `guest_name`, `is_guest_order`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ORD-F0SWOS2KPM', 'pending', '25000.00', 'cash', 'pending', 'Colombia, Bogota, DC', 'Bogota', 'Alabama', '110110', '3122154598', NULL, 'business.alejandrolopezmurillo@gmail.com', 'Alejandro Lopez', 0, '2025-05-09 14:34:52', '2025-05-09 14:34:52'),
(2, NULL, 'ORD-FR3CK0MQGG', 'pending', '15000.00', 'cash', 'pending', 'Colombia, Bogota, DC', 'Bogota', 'Alabama', '110110', '3122154598', NULL, 'business.alejandrolopezmurillo@gmail.com', 'Alejandro Lopez', 0, '2025-05-09 14:46:49', '2025-05-09 14:46:49'),
(3, NULL, 'ORD-GN8OYWSRBT', 'pending', '15000.00', 'cash', 'pending', 'Colombia, Bogota, DC', 'Bogota', 'Alabama', '110110', '3122154598', NULL, 'business.alejandrolopezmurillo@gmail.com', 'Alejandro Lopez', 0, '2025-05-09 14:49:23', '2025-05-09 14:49:23'),
(4, NULL, 'ORD-QPXZFTHUKF', 'pending', '30000.00', 'cash', 'pending', 'Colombia, Bogota, DC', 'Bogota', 'Alabama', '110110', '3122154598', NULL, 'business.alejandrolopezmurillo@gmail.com', 'Alejandro Lopez', 0, '2025-05-09 14:52:05', '2025-05-09 14:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `store_id`, `quantity`, `price`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 1, '25000.00', '25000.00', 'pending', '2025-05-09 14:34:52', '2025-05-09 14:34:52'),
(2, 2, 1, 1, 1, '15000.00', '15000.00', 'pending', '2025-05-09 14:46:49', '2025-05-09 14:46:49'),
(3, 3, 1, 1, 1, '15000.00', '15000.00', 'pending', '2025-05-09 14:49:23', '2025-05-09 14:49:23'),
(4, 4, 3, 1, 2, '15000.00', '30000.00', 'processing', '2025-05-09 14:52:05', '2025-05-09 15:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `store_id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `sku`, `images`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'test', 'test', 'agregarf', '15000.00', 0, '1234567', '[\"products/96dVHB2Hfrj90Nide0SCRXhNYuFPW0YWHo79hw5J.png\"]', 1, 0, '2025-05-09 06:47:19', '2025-05-09 14:49:23'),
(3, 1, 2, 'test', 'test-1', 'fgfdfgd', '15000.00', -1, '86887', '[\"products/2riRkWuHd9p1d4Jt6iOfaC8VdgEgCW2gvekuYlKE.png\"]', 1, 0, '2025-05-09 12:11:14', '2025-05-09 14:52:05'),
(4, 1, 1, 'Canasta de Verduras Orgánicas', 'canasta-de-verduras-organicas', 'Selección de verduras frescas de temporada cultivadas sin pesticidas. Incluye lechuga, tomate, cebolla, zanahoria, pimentón y más.', '25000.00', 19, 'VRD-001', '[\"products/vegetable-basket-1.jpg\", \"products/vegetable-basket-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 14:34:52'),
(5, 1, 1, 'Tomates Orgánicos', 'tomates-organicos', 'Tomates cultivados sin pesticidas ni químicos. Dulces, jugosos y llenos de sabor.', '5000.00', 50, 'VRD-002', '[\"products/tomatoes-1.jpg\", \"products/tomatoes-2.jpg\"]', 1, 0, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(6, 1, 2, 'Fresas Frescas', 'fresas-frescas', 'Fresas dulces y jugosas recién cosechadas. Perfectas para postres o para comer directamente.', '8000.00', 30, 'FRT-001', '[\"products/strawberries-1.jpg\", \"products/strawberries-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(7, 3, 3, 'Queso Campesino', 'queso-campesino', 'Queso fresco elaborado artesanalmente con leche de vacas alimentadas con pasto. Suave y cremoso.', '12000.00', 25, 'QSO-001', '[\"products/cheese-1.jpg\", \"products/cheese-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(8, 3, 3, 'Yogurt Natural', 'yogurt-natural', 'Yogurt natural sin azúcar añadido. Elaborado con leche fresca y cultivos probióticos.', '7000.00', 40, 'YGT-001', '[\"products/yogurt-1.jpg\", \"products/yogurt-2.jpg\"]', 1, 0, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(9, 4, 4, 'Miel Pura de Abeja', 'miel-pura-de-abeja', 'Miel 100% natural recolectada de colmenas en bosques nativos. Sin aditivos ni conservantes.', '15000.00', 35, 'MIL-001', '[\"products/honey-1.jpg\", \"products/honey-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(10, 4, 4, 'Polen de Abeja', 'polen-de-abeja', 'Polen de abeja recolectado por nuestras abejas. Rico en proteínas, vitaminas y minerales.', '18000.00', 20, 'POL-001', '[\"products/pollen-1.jpg\", \"products/pollen-2.jpg\"]', 1, 0, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(11, 5, 5, 'Carne de Res Premium', 'carne-de-res-premium', 'Carne de res de ganado criado en libertad, alimentado con pasto. Sin hormonas ni antibióticos.', '30000.00', 15, 'CRN-001', '[\"products/beef-1.jpg\", \"products/beef-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(12, 5, 5, 'Pollo Campesino', 'pollo-campesino', 'Pollo criado en libertad, alimentado naturalmente. Carne firme y sabrosa.', '22000.00', 20, 'POL-001', '[\"products/chicken-1.jpg\", \"products/chicken-2.jpg\"]', 1, 0, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(13, 6, 6, 'Mix de Hierbas Aromáticas', 'mix-de-hierbas-aromaticas', 'Selección de hierbas aromáticas frescas: albahaca, tomillo, romero y orégano.', '10000.00', 30, 'HRB-001', '[\"products/herbs-1.jpg\", \"products/herbs-2.jpg\"]', 1, 1, '2025-05-09 13:19:57', '2025-05-09 13:19:57'),
(14, 6, 6, 'Té de Hierbas Medicinales', 'te-de-hierbas-medicinales', 'Mezcla de hierbas medicinales para infusión. Ayuda a la digestión y relajación.', '12000.00', 25, 'TE-001', '[\"products/tea-1.jpg\", \"products/tea-2.jpg\"]', 1, 0, '2025-05-09 13:19:57', '2025-05-09 13:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin', 'El Administrador tiene acceso completo al sistema', '2025-05-09 06:27:28', '2025-05-09 11:12:03'),
(2, 'Productor', 'producer', 'El Productor puede gestionar su propia tienda y productos', '2025-05-09 06:27:28', '2025-05-09 11:12:03'),
(3, 'Cliente', 'customer', 'El Cliente puede navegar por productos y realizar pedidos', '2025-05-09 06:27:28', '2025-05-09 11:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(6, 2, 6, NULL, NULL),
(7, 2, 7, NULL, NULL),
(8, 2, 8, NULL, NULL),
(9, 2, 9, NULL, NULL),
(10, 2, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `user_id`, `name`, `slug`, `description`, `logo`, `banner`, `phone`, `whatsapp`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Test Store1', 'test-store1', 'This is a test store', 'stores/logos/aclihT7GHqH59dsEfzmVD0fRX5jcAZ3l3ojdwdeA.png', 'stores/banners/WqMRgBnhjvMj83q6IDrC5lCgWjI4lg4DtNTmIAAa.png', '1234567890', '1234567890', 'producer@example.com', 'Store Address', 1, '2025-05-09 06:27:29', '2025-05-09 12:22:10'),
(3, 2, 'nueva tienda1', 'nueva-tienda1', 'cr 33', 'stores/logos/K6IajcfL6n6a3YLLy7YAp7CEsky9lOLkLeMnQKp7.png', 'stores/banners/8oncyR9OT5MJ1COar6UZvuIPOwWZ3JOOoLlcXxnu.png', '3122154598', '3122154598', 'info@alejandropro.co', 'cr33', 1, '2025-05-09 09:22:22', '2025-05-09 10:14:28'),
(4, 6, 'Finca El Paraíso', 'finca-el-paraiso', 'Somos una finca familiar dedicada al cultivo de frutas y verduras orgánicas. Nuestros productos son cultivados sin pesticidas ni químicos, respetando el medio ambiente.', 'stores/logos/finca-paraiso.jpg', 'stores/banners/finca-paraiso-banner.jpg', '3101234567', '573101234567', 'contacto@fincaelparaiso.com', 'Vereda La Esperanza, Popayán, Cauca', 1, '2025-05-09 13:19:28', '2025-05-09 13:19:28'),
(5, 7, 'Lácteos La Vaca Feliz', 'lacteos-la-vaca-feliz', 'Producimos lácteos artesanales de la más alta calidad. Nuestras vacas son alimentadas con pasto natural y tratadas con respeto y cariño.', 'stores/logos/lacteos-vaca-feliz.jpg', 'stores/banners/lacteos-vaca-feliz-banner.jpg', '3157654321', '573157654321', 'info@lavacafeliz.com', 'Km 5 vía Popayán - Timbío, Cauca', 1, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(6, 8, 'Miel Pura Cauca', 'miel-pura-cauca', 'Producimos miel 100% pura y natural. Nuestras abejas polinizan en bosques nativos libres de contaminación.', 'stores/logos/miel-pura-cauca.jpg', 'stores/banners/miel-pura-cauca-banner.jpg', '3209876543', '573209876543', 'contacto@mielpuracauca.com', 'Vereda El Rosal, Cajibío, Cauca', 1, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(7, 9, 'Carnes El Potrero', 'carnes-el-potrero', 'Ofrecemos carnes de res, cerdo y pollo de animales criados en libertad, alimentados naturalmente y sin hormonas.', 'stores/logos/carnes-potrero.jpg', 'stores/banners/carnes-potrero-banner.jpg', '3183456789', '573183456789', 'ventas@carneselpotrero.com', 'Vereda San Antonio, Popayán, Cauca', 1, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(8, 10, 'Hierbas del Macizo', 'hierbas-del-macizo', 'Cultivamos hierbas aromáticas y medicinales en las faldas del Macizo Colombiano, aprovechando su clima y suelos excepcionales.', 'stores/logos/hierbas-macizo.jpg', 'stores/banners/hierbas-macizo-banner.jpg', '3167890123', '573167890123', 'info@hierbasdelmacizocom', 'Vereda Alto de las Hierbas, San Sebastián, Cauca', 1, '2025-05-09 13:19:29', '2025-05-09 13:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `city`, `state`, `zipcode`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2025-05-09 06:27:29', '$2y$12$N3z6e3SjFjlCpIzkvFiEiO9.dL9f0bk1SPodpgYqR3LxnKvPq792u', NULL, NULL, NULL, NULL, NULL, 'Z33aJQxbjg19vA4mm1rr5OhGa1NJ6E5A1h7S7FihQuKZf0AcPBswaYurZZf4', '2025-05-09 06:27:29', '2025-05-09 06:27:29'),
(2, 'Producer User', 'producer@example.com', '2025-05-09 06:27:29', '$2y$12$2AaLQQoHEqsP0d0mMU5QUugGK7BmLlLD4qmHSEW0XMphIT9hlc9qe', '1234567890', 'Producer Address', NULL, NULL, NULL, 'EaFj26ymLRe3BMjhAzYpTt5hzkre7CowNIDyEhblyBLQUDgC1c92MmX7S9bu', '2025-05-09 06:27:29', '2025-05-09 06:27:29'),
(3, 'Customer User', 'customer@example.com', '2025-05-09 06:27:30', '$2y$12$.99DtwHeNnAzfukMTyNEaOs54sJyRZ8fqmH.q.0XzDQhi71vpIdaK', '0987654321', 'Customer Address', NULL, NULL, NULL, 'DCLhK6kBydp6baUfyUyfMint8umKsCdMsckJBPwzJTykPGn2kBx949tNpVj2', '2025-05-09 06:27:30', '2025-05-09 06:27:30'),
(6, 'Productor 1', 'productor1@example.com', NULL, '$2y$12$KXqxw4g2ak2SNkCQ0oqaJOTkqw3Rd67Qw66yCR2GQUBd927tQSjdW', '3101234567', 'Vereda La Esperanza, Popayán, Cauca', NULL, NULL, NULL, NULL, '2025-05-09 13:19:28', '2025-05-09 13:19:28'),
(7, 'Productor 2', 'productor2@example.com', NULL, '$2y$12$AjUITYc5EDU5abvwTwm7/etS9oQ5K1O33l/xBo7zSfuD/nm0d00Q.', '3157654321', 'Km 5 vía Popayán - Timbío, Cauca', NULL, NULL, NULL, NULL, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(8, 'Productor 3', 'productor3@example.com', NULL, '$2y$12$a5Q2JNwOElmb8HoTgLMh4el4tIbwi6M29qxYk79o67joKkmB4/xDG', '3209876543', 'Vereda El Rosal, Cajibío, Cauca', NULL, NULL, NULL, NULL, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(9, 'Productor 4', 'productor4@example.com', NULL, '$2y$12$zPUUeZ/r1H8.Ulxdjfat1ux97RSQ6gaRkzvVlw2VEaZyUF5wU2vYa', '3183456789', 'Vereda San Antonio, Popayán, Cauca', NULL, NULL, NULL, NULL, '2025-05-09 13:19:29', '2025-05-09 13:19:29'),
(10, 'Productor 5', 'productor5@example.com', NULL, '$2y$12$Fuq3SqT/6aPaLMflb9XA2eZU.73GatKl7xT8VW18WBHNpuPdq5UIi', '3167890123', 'Vereda Alto de las Hierbas, San Sebastián, Cauca', NULL, NULL, NULL, NULL, '2025-05-09 13:19:29', '2025-05-09 13:19:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guest_carts`
--
ALTER TABLE `guest_carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_carts_session_id_unique` (`session_id`);

--
-- Indexes for table `guest_cart_items`
--
ALTER TABLE `guest_cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_cart_items_guest_cart_id_foreign` (`guest_cart_id`),
  ADD KEY `guest_cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_store_id_foreign` (`store_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_store_id_foreign` (`store_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_slug_unique` (`slug`),
  ADD KEY `stores_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_carts`
--
ALTER TABLE `guest_carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guest_cart_items`
--
ALTER TABLE `guest_cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `guest_cart_items`
--
ALTER TABLE `guest_cart_items`
  ADD CONSTRAINT `guest_cart_items_guest_cart_id_foreign` FOREIGN KEY (`guest_cart_id`) REFERENCES `guest_carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guest_cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
