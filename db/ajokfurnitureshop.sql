-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 12:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajokfurnitureshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `mypurchase`
--

CREATE TABLE `mypurchase` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mypurchase`
--

INSERT INTO `mypurchase` (`id`, `user_id`, `product_id`, `status`, `created_at`) VALUES
(13, 4, 56, 'Preparing-order', '2023-12-13 14:37:58'),
(14, 4, 56, 'Placed', '2023-12-14 07:31:10'),
(15, 4, 56, 'Placed', '2023-12-14 07:32:14'),
(16, 4, 56, 'Placed', '2023-12-14 07:32:20'),
(17, 4, 56, 'Placed', '2023-12-14 07:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_shop_name` varchar(255) DEFAULT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `product_condition` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `seller_shop_name`, `product_title`, `product_category`, `product_condition`, `price`, `quantity`, `image`, `description`) VALUES
(56, 4, 'Ajok Furniture Shop', 'Furniture', NULL, '', 5000.00, 0, 'marshall.jpg', 'This is the most purchased on the shop, grab it now!'),
(57, 4, 'Ajok Furniture Shop', 'Furniture 2', NULL, '', 8000.00, 10, 'ezgif-5-d6f5d8edc5.jpg', 'This is the cheapest furniture listed in the shop, grab it now!');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `seller_shop_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `seller_shop_name`, `email`, `password_hash`, `address`, `date_of_birth`, `gender`, `registration_date`) VALUES
(4, 'Ajok Furniture Shop', 'ajokfurnitureshop@gmail.com', '12345678', 'Brgy. San Roque, Sogod, Southern Leyte', '2001-02-22', 'Female', '2023-12-14 02:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` char(200) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `shipping_address` varchar(155) DEFAULT NULL,
  `mode_of_payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `password_hash`, `contact_number`, `date_of_birth`, `gender`, `shipping_address`, `mode_of_payment`, `created_at`) VALUES
(1, 'Grim3ntrix', 'Richard Samberi', 'example@gmail.com', '1234', '09261997348', '2002-01-27', 'male', 'Brgy. San Bugwak, Southern Leyte', NULL, '2023-07-22 04:09:21'),
(2, NULL, NULL, 'LG@gmail.com', '87654321', NULL, '2023-06-26', 'male', NULL, NULL, '2023-06-25 12:04:30'),
(3, NULL, NULL, '3rd@gmail.com', '123', NULL, '2002-01-20', 'female', NULL, NULL, '2023-07-04 07:23:03'),
(4, 'Gwaprogz', 'Richard Samberi', '2010456-1@gmail.com', '12345678', '09261997348', '2023-12-14', 'female', 'San Isidro', 'Cash-On-Delivery', '2023-12-13 10:46:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mypurchase`
--
ALTER TABLE `mypurchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seller_id` (`seller_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mypurchase`
--
ALTER TABLE `mypurchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mypurchase`
--
ALTER TABLE `mypurchase`
  ADD CONSTRAINT `mypurchase_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mypurchase_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_seller_id` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
