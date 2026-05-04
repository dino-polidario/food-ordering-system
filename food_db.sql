-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 05:17 AM
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
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `payment_details` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `phone`, `address`, `payment_method`, `notes`, `payment_details`) VALUES
(1, 7, 200.00, 'completed', '2025-12-09 14:51:51', NULL, NULL, NULL, NULL, NULL),
(2, 8, 125.00, 'pending', '2025-12-09 14:58:44', NULL, NULL, NULL, NULL, NULL),
(3, 8, 125.00, 'pending', '2025-12-09 23:15:13', NULL, NULL, NULL, NULL, NULL),
(4, 8, 200.00, 'pending', '2025-12-09 23:15:40', NULL, NULL, NULL, NULL, NULL),
(5, 7, 125.00, 'cancelled', '2025-12-10 00:56:16', NULL, NULL, NULL, NULL, NULL),
(6, 7, 200.00, 'pending', '2025-12-10 01:12:15', NULL, NULL, NULL, NULL, NULL),
(7, 9, 2485.00, 'pending', '2025-12-10 14:59:50', NULL, NULL, NULL, NULL, NULL),
(8, 7, 1220.00, 'pending', '2025-12-10 17:16:49', NULL, NULL, NULL, NULL, NULL),
(9, 7, 1220.00, 'pending', '2025-12-10 18:27:29', NULL, NULL, NULL, NULL, NULL),
(10, 7, 1220.00, 'pending', '2025-12-10 18:37:22', NULL, NULL, NULL, NULL, NULL),
(11, 7, 10035.00, 'cancelled', '2025-12-10 18:39:26', NULL, NULL, NULL, NULL, NULL),
(12, 7, 125.00, 'pending', '2025-12-11 12:24:09', NULL, 'manila', 'card', 'deliver in frontdoor', '1234567890123456'),
(13, 9, 190.00, 'completed', '2025-12-11 17:22:57', NULL, 'Paranaque', 'gcash', 'bring infront of door', '09123456789'),
(14, 9, 210.00, 'cancelled', '2025-12-11 17:23:57', NULL, 'Paranaque', 'card', 'none', '1234567890123456'),
(15, 4, 195.00, 'pending', '2025-12-12 00:34:09', NULL, 'sdfjksfks', 'cod', 'dyan lang', ''),
(16, 9, 195.00, 'pending', '2025-12-12 16:59:54', NULL, 'manila', 'gcash', 'anything', '09123456789'),
(17, 10, 330.00, 'cancelled', '2026-03-30 05:43:20', NULL, 'taga jn lang bok', 'gcash', 'sa tabi ng bahay ni goku', '09123456789'),
(18, 11, 200.00, 'pending', '2026-03-30 05:51:50', NULL, 'kanila jai', 'cod', 'dun sa bisaya na taga davao', ''),
(19, 11, 500.00, 'pending', '2026-03-30 05:53:38', NULL, 'asdf', 'cod', 'asdfsd', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_time_of_order` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_time_of_order`) VALUES
(1, 1, 2, 1, 75.00),
(2, 1, 3, 1, 75.00),
(3, 2, 2, 1, 75.00),
(4, 3, 2, 1, 75.00),
(5, 4, 3, 2, 75.00),
(6, 5, 2, 1, 75.00),
(7, 6, 2, 1, 75.00),
(8, 6, 3, 1, 75.00),
(9, 7, 3, 3, 75.00),
(10, 7, 5, 3, 20.00),
(11, 7, 4, 2, 1000.00),
(12, 7, 2, 2, 75.00),
(13, 8, 3, 1, 75.00),
(14, 8, 2, 1, 75.00),
(15, 8, 4, 1, 1000.00),
(16, 8, 5, 1, 20.00),
(17, 9, 2, 1, 75.00),
(18, 9, 3, 1, 75.00),
(19, 9, 4, 1, 1000.00),
(20, 9, 5, 1, 20.00),
(21, 10, 2, 1, 75.00),
(22, 10, 3, 1, 75.00),
(23, 10, 4, 1, 1000.00),
(24, 10, 5, 1, 20.00),
(25, 11, 5, 8, 20.00),
(26, 11, 2, 1, 75.00),
(27, 11, 3, 10, 75.00),
(28, 11, 4, 9, 1000.00),
(29, 12, 3, 1, 75.00),
(30, 13, 7, 1, 60.00),
(31, 13, 14, 1, 55.00),
(32, 13, 21, 1, 25.00),
(33, 14, 10, 1, 75.00),
(34, 14, 16, 1, 65.00),
(35, 14, 24, 1, 20.00),
(36, 15, 8, 1, 65.00),
(37, 15, 14, 1, 55.00),
(38, 15, 21, 1, 25.00),
(39, 16, 8, 1, 65.00),
(40, 16, 14, 1, 55.00),
(41, 16, 21, 1, 25.00),
(42, 17, 8, 3, 65.00),
(43, 17, 7, 1, 60.00),
(44, 17, 21, 1, 25.00),
(45, 18, 30, 1, 150.00),
(46, 19, 30, 3, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('musubi','onigiri','drinks','other') DEFAULT 'musubi',
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `image_url`, `created_at`, `is_active`) VALUES
(2, 'Teriyaki Spam Musubi', 'Spam glazed with teriyaki sauce and a touch of sesame for a sweet-savory flavor.', 'musubi', 75.00, 'assets/img/products/6938218c1a447.png', '2025-12-09 13:18:04', 0),
(3, 'Spicy Teriyaki Spam Musubi', 'Spam glazed with teriyaki sauce and a touch of sesame for a spicy sweet-savory flavor.', 'musubi', 75.00, 'assets/img/products/693823aeb0e63.png', '2025-12-09 13:27:10', 0),
(4, 'menu', 'mema', 'musubi', 1000.00, 'assets/img/products/693ad7851be3a.png', '2025-12-10 01:47:40', 0),
(5, 'coca-cola', 'drink', 'musubi', 20.00, 'assets/img/products/693ad76687e12.png', '2025-12-10 11:06:34', 0),
(7, 'Teriyaki Spam Musubi', 'A juicy slice of Spam glazed with homemade teriyaki sauce, topped with sesame seeds for a sweet and savory finish.', NULL, 60.00, 'assets/img/products/693adce7ce963.png', '2025-12-11 15:01:59', 1),
(8, 'Spicy Teriyaki Spam Musubi', 'Spam glazed with spicy teriyaki sauce and sprinkled with sesame seeds for a flavorful kick.', NULL, 65.00, 'assets/img/products/693ae0dd27f31.png', '2025-12-11 15:18:53', 1),
(9, 'Cheesy Spam Musubi', 'Classic Spam topped with rich, melted cheese for a creamy, satisfying bite.', NULL, 70.00, 'assets/img/products/693ae1322b26f.png', '2025-12-11 15:20:18', 1),
(10, 'Egg & Spam Musubi', 'A perfect breakfast combo of fluffy egg omelet and savory Spam wrapped together.', NULL, 75.00, 'assets/img/products/693ae45ed0841.png', '2025-12-11 15:33:50', 1),
(11, 'Double Spam Musubi', 'Two thick slices of Spam stacked for the ultimate meat lover’s musubi.', NULL, 90.00, 'assets/img/products/693ae4f0e768a.png', '2025-12-11 15:36:16', 1),
(12, 'Overload Spam Musubi', 'A loaded treat with Spam, melted cheese, egg, and teriyaki sauce all in one.', NULL, 90.00, 'assets/img/products/693ae5a09c20a.png', '2025-12-11 15:39:12', 1),
(13, 'Overload Double Spam Musubi', 'Double Spam plus cheese, egg, and teriyaki—full flavor in every bite.', NULL, 110.00, 'assets/img/products/693ae7ba37318.png', '2025-12-11 15:48:10', 1),
(14, 'Tuna Mayo Onigiri', 'Japanese-style tuna mixed with creamy mayo wrapped in seasoned rice.', NULL, 55.00, 'assets/img/products/693aee1089a42.jpg', '2025-12-11 16:15:12', 1),
(15, 'Spicy Tuna Onigiri', 'Tuna mayo with chili for a satisfying heat.', NULL, 60.00, 'assets/img/products/693aee40ba310.jpg', '2025-12-11 16:16:00', 1),
(16, 'Salmon Flakes Onigiri', 'Soft, savory salmon flakes tucked inside warm rice.', NULL, 65.00, 'assets/img/products/693aee665b163.jpg', '2025-12-11 16:16:38', 1),
(17, 'Chicken Teriyaki Onigiri', 'Tender chicken cooked in sweet teriyaki sauce for a flavorful rice filling.', NULL, 60.00, 'assets/img/products/693aef1001553.jpg', '2025-12-11 16:19:28', 0),
(18, 'Chicken Teriyaki Onigiri', 'Tender chicken cooked in sweet teriyaki sauce for a flavorful rice filling.', NULL, 60.00, 'assets/img/products/693af32fe5d18.jpg', '2025-12-11 16:37:03', 1),
(19, 'Spam Mayo Onigiri', 'A twist on the classic—diced Spam mixed with creamy Japanese mayo.', NULL, 70.00, 'assets/img/products/693af3512d4fc.jpg', '2025-12-11 16:37:37', 1),
(20, 'Cheese Onigiri', 'Soft, melty cheese center wrapped in seasoned rice—simple and comforting.', NULL, 50.00, 'assets/img/products/693af3846a713.png', '2025-12-11 16:38:28', 1),
(21, 'Iced Tea', 'Refreshing house-blend iced tea.', NULL, 25.00, 'assets/img/products/693afaaa68358.jpg', '2025-12-11 17:00:42', 1),
(22, 'Calamansi Juice', 'Fresh, sweet-tangy local favorite.', NULL, 30.00, 'assets/img/products/693af8e4c044d.jpg', '2025-12-11 17:01:24', 1),
(23, 'Lemonade', 'Cool, citrusy, and thirst-quenching.', NULL, 35.00, 'assets/img/products/693af90107408.jpg', '2025-12-11 17:01:53', 1),
(24, 'Bottled Water', 'Clean, crisp, and refreshing purified water.', NULL, 20.00, 'assets/img/products/693af9bda2a4e.jpg', '2025-12-11 17:05:01', 1),
(25, 'Matcha Milk Tea', 'Earthy, premium Japanese matcha blended with smooth, creamy milk.', NULL, 60.00, 'assets/img/products/693af9f1e4c16.jpg', '2025-12-11 17:05:53', 1),
(26, 'Wintermelon Milk Tea', 'A classic favorite featuring rich, caramelized wintermelon sweetness.', NULL, 60.00, 'assets/img/products/693afa0bc6e1c.jpg', '2025-12-11 17:06:19', 1),
(27, 'Okinawa Milk Tea', 'Velvety milk tea sweetened with roasted brown sugar for a deep, toffee-like flavor.', NULL, 60.00, 'assets/img/products/693afa28c51d0.jpg', '2025-12-11 17:06:48', 1),
(28, 'Chocolate Milk Tea', 'Rich, indulgent chocolate blended into creamy milk tea for a satisfying treat.', NULL, 60.00, 'assets/img/products/693afa4424592.jpg', '2025-12-11 17:07:16', 1),
(29, '', NULL, 'musubi', 0.00, NULL, '2026-03-30 05:36:19', 0),
(30, 'sije', 'bading', NULL, 150.00, 'assets/img/products/69ca0f2705704.jpg', '2026-03-30 05:50:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES
(4, 'Raine Nudo', 'admin1@musubi.com', '$2y$10$fYFFQy69dXSweDq3KEZ3QuYlVfty5zwe/vsJ2LKXseOo3BWLyNmbu', 'admin', '2025-12-09 12:53:29'),
(6, 'Site Admin', 'admin@musubi.com', '$2y$10$VHxH5n6ZS2ZqOvFPe1WQkOGqzPqU3NTQ7HQeIeJYFKFQ4KUOq91Z2', 'admin', '2025-12-09 13:03:37'),
(7, 'User1', 'user1@musubi.com', '$2y$10$RTUroGhW1q7pVrxXXWuIeOQdFoxrJwYTaMD7WFP7fFASaEWIVHq5S', 'customer', '2025-12-09 13:22:12'),
(8, 'Bernardino Polidario', 'admin2@musubi.com', '$2y$10$8qC35Tn.4BJSfGaOfwzClehpG..pJ0pTXzkJnf.nrhMSBpgc2Wwvi', 'customer', '2025-12-09 14:58:06'),
(9, 'user2', 'user2@musubi.com', '$2y$10$7uM019WcyFtyK.tyr1EREeKr1o.WFrZ4Gd/w6pn2mEBB/e2Wwih5y', 'customer', '2025-12-10 14:00:08'),
(10, 'bok1', 'bok1@email.com', '$2y$10$C2fcO.GBUQ8XwLKtl2RK3Ol7b.5WI095lxF/0gkfqqTvTw1GtrRuy', 'customer', '2026-03-30 05:41:02'),
(11, 'adminbok', 'adminbok@email.com', '$2y$10$bHaQBprqSxnwVp1ugzAaqu/Vs4I.eyHlut0/YV0SsbguD9g8UK2Hi', 'customer', '2026-03-30 05:46:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
