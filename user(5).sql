-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 04:32 AM
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
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Kakanin'),
(2, 'Pancit'),
(3, 'Ulam');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_id` int(10) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Image` varchar(50) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`food_id`, `Name`, `Description`, `Image`, `category_id`) VALUES
(1, 'Pancit', 'Masarap ang pancit!', 'uploads/Screenshot (62).png', 1),
(2, 'Manok', 'Masarap ang Manok!', 'uploads/Screenshot (61).png', 2),
(3, 'Ewan', 'Ewan ko!', 'uploads/Screenshot (54).png', 3),
(5, 'Puto', 'Savor the rich flavors of Puto, the Filipino steam', 'uploads/puto.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_size_pricing`
--

CREATE TABLE `food_size_pricing` (
  `pricing_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_size_pricing`
--

INSERT INTO `food_size_pricing` (`pricing_id`, `food_id`, `size_id`, `price`) VALUES
(1, 1, 1, 20.00),
(2, 1, 2, 30.00),
(3, 1, 3, 50.00),
(4, 2, 1, 20.00),
(5, 2, 2, 40.00),
(6, 2, 3, 50.00),
(7, 3, 1, 100.00),
(8, 3, 2, 120.00),
(9, 3, 3, 130.00),
(22, 5, 1, 500.00),
(23, 5, 2, 600.00),
(24, 5, 3, 700.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`, `status`) VALUES
(1, 7, '2025-01-05 19:10:51', 90.00, 'completed'),
(2, 7, '2025-01-05 19:15:21', 90.00, 'completed'),
(3, 7, '2025-01-05 19:26:23', 50.00, 'completed'),
(4, 7, '2025-01-05 19:40:11', 260.00, 'completed'),
(5, 7, '2025-01-06 13:23:47', 260.00, 'completed'),
(6, 7, '2025-01-06 13:24:03', 260.00, 'completed'),
(7, 7, '2025-01-06 13:24:52', 260.00, 'completed'),
(8, 7, '2025-01-06 13:27:22', 260.00, 'completed'),
(9, 7, '2025-01-06 13:31:57', 20.00, 'completed'),
(10, 7, '2025-01-06 13:32:51', 20.00, 'completed'),
(11, 7, '2025-01-06 13:32:56', 20.00, 'completed'),
(12, 7, '2025-01-06 13:33:45', 20.00, 'completed'),
(13, 7, '2025-01-06 13:34:57', 20.00, 'completed'),
(14, 7, '2025-01-06 13:40:11', 20.00, 'completed'),
(15, 7, '2025-01-06 14:02:38', 350.00, 'completed'),
(16, 7, '2025-01-06 14:33:11', 120.00, 'completed'),
(17, 7, '2025-01-06 15:38:15', 40.00, 'completed'),
(18, 7, '2025-01-07 13:50:01', 50.00, 'completed'),
(19, 7, '2025-01-07 14:25:59', 40.00, 'completed'),
(20, 7, '2025-01-07 14:30:54', 260.00, 'completed'),
(21, 7, '2025-01-07 14:32:10', 30.00, 'completed'),
(22, 7, '2025-01-07 14:48:36', 40.00, 'completed'),
(23, 7, '2025-01-07 15:00:02', 40.00, 'completed'),
(24, 7, '2025-01-07 15:02:22', 50.00, 'completed'),
(25, 7, '2025-01-12 21:04:20', 120.00, 'Pending'),
(26, 7, '2025-01-15 17:45:38', 40.00, 'Pending'),
(27, 7, '2025-01-15 17:46:21', 90.00, 'Pending'),
(28, 7, '2025-01-16 08:07:58', 170.00, 'Pending'),
(29, 7, '2025-01-16 11:09:12', 40.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pricing_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `pricing_id`, `quantity`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 1),
(3, 4, 6, 2),
(4, 4, 5, 1),
(5, 4, 8, 1),
(6, 5, 6, 2),
(7, 5, 5, 1),
(8, 5, 8, 1),
(9, 6, 6, 2),
(10, 6, 5, 1),
(11, 6, 8, 1),
(12, 7, 6, 2),
(13, 7, 5, 1),
(14, 7, 8, 1),
(15, 8, 6, 2),
(16, 8, 5, 1),
(17, 8, 8, 1),
(18, 9, 4, 1),
(19, 10, 4, 1),
(20, 11, 4, 1),
(21, 12, 4, 1),
(22, 13, 4, 1),
(23, 14, 4, 1),
(24, 15, 5, 1),
(25, 15, 3, 1),
(26, 15, 9, 2),
(27, 16, 8, 1),
(28, 17, 5, 1),
(29, 18, 6, 1),
(30, 19, 5, 1),
(31, 20, 6, 2),
(32, 20, 5, 1),
(33, 20, 8, 1),
(34, 21, 2, 1),
(35, 22, 5, 1),
(36, 23, 5, 1),
(37, 24, 6, 1),
(38, 25, 5, 3),
(39, 26, 5, 1),
(40, 27, 5, 1),
(41, 27, 3, 1),
(42, 28, 5, 1),
(43, 28, 9, 1),
(44, 29, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`size_id`, `size_name`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `user_id` int(10) NOT NULL,
  `Fname` varchar(20) NOT NULL,
  `Lname` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `Phone_No` int(20) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`user_id`, `Fname`, `Lname`, `Email`, `Password`, `Phone_No`, `Address`) VALUES
(1, 'John', 'Doe', 'john@example.com', 'password', 1234567890, '123 Main St'),
(6, 'Fard', '', 't@gmail.com', 'Ferd1234', 0, ''),
(7, 'Ferd', 'Olaira', 'ferdolaira@gmail.com', 'Ferd1234', 2147483647, 'Blk 14, Lot 28, Garnet St, Silvertowne 4, Malagasang 2-B, Imus Cavite'),
(8, 'ferdi', 'dabol', 'tae@gmail.com', '$2y$10$s', 0, ''),
(9, 'F', 'f', 'tt@gmail.com', '$2y$10$h', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `food_size_pricing`
--
ALTER TABLE `food_size_pricing`
  ADD PRIMARY KEY (`pricing_id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `pricing_id` (`pricing_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_size_pricing`
--
ALTER TABLE `food_size_pricing`
  MODIFY `pricing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `food_size_pricing`
--
ALTER TABLE `food_size_pricing`
  ADD CONSTRAINT `food_size_pricing_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_size_pricing_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`pricing_id`) REFERENCES `food_size_pricing` (`pricing_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
