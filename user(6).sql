-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 09:32 AM
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
(2, 'Manok', 'Masarap ang Manok!', 'uploads/chicken.jpg', 3),
(3, 'Ewan', 'Ewan ko!', 'uploads/Screenshot (54).png', 3),
(5, 'Puto', 'Savor the rich flavors of Puto, the Filipino steam', 'uploads/puto.jpg', 1),
(7, 'Pancit Bihon', 'Masarap ang pancit bihon!', 'uploads/pancit.jpg', 2),
(9, 'Buchi', 'Masarap ang Buchi', 'uploads/b3.jpg', 1);

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
(24, 5, 3, 700.00),
(28, 7, 1, 20.00),
(29, 7, 2, 30.00),
(30, 7, 3, 50.00),
(37, 9, 1, 300.00),
(38, 9, 2, 500.00),
(39, 9, 3, 700.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `preparation_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `preparation_date`, `total_price`, `status`) VALUES
(1, 7, '2025-01-22 15:03:28', '0000-00-00', 150.00, 'Pending'),
(2, 7, '2025-01-22 15:06:48', '0000-00-00', 550.00, 'Pending'),
(3, 7, '2025-01-22 15:08:55', '0000-00-00', 200.00, 'Pending'),
(4, 7, '2025-01-22 15:10:24', '0000-00-00', 650.00, 'Pending'),
(5, 7, '2025-01-22 15:13:52', NULL, 650.00, 'Pending'),
(6, 7, '2025-01-22 15:15:55', '0000-00-00', 650.00, 'Pending'),
(7, 7, '2025-01-22 15:15:55', NULL, 650.00, 'Pending'),
(8, 7, '2025-01-22 15:19:10', '0000-00-00', 520.00, 'Pending'),
(9, 7, '2025-01-22 15:24:34', '0000-00-00', 4200.00, 'Pending'),
(10, 7, '2025-01-22 15:26:53', '2024-01-19', 1000.00, 'Pending'),
(11, 7, '2025-01-22 15:28:17', '2024-01-26', 780.00, 'Pending'),
(12, 7, '2025-01-22 15:29:46', '2024-01-12', 240.00, 'Pending');

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
(1, 1, 6, 3),
(2, 2, 30, 11),
(3, 3, 5, 5),
(4, 4, 9, 5),
(5, 5, 9, 5),
(6, 7, 9, 5),
(7, 8, 9, 4),
(8, 9, 24, 6),
(9, 11, 9, 6),
(10, 12, 5, 6);

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
(9, 'F', 'f', 'tt@gmail.com', '$2y$10$h', 0, ''),
(10, 'Ken', 'Orosco', 'ken@gmail.com', '$2y$10$W', 923232424, 'fwafawfawfwasf');

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
  MODIFY `food_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `food_size_pricing`
--
ALTER TABLE `food_size_pricing`
  MODIFY `pricing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
