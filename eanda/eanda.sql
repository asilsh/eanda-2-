-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2023 at 04:30 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eanda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_a` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_a`, `name`, `email`, `password`, `city`, `phone`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 'NYC', '372189');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_cus` int(11) NOT NULL,
  `id_p` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_cat` int(11) NOT NULL,
  `name_cat` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_cus` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `city` varchar(265) NOT NULL,
  `phone` varchar(265) NOT NULL,
  `id_o` varchar(500) DEFAULT NULL,
  `wishlist` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_cus`, `name`, `email`, `password`, `city`, `phone`, `id_o`, `wishlist`) VALUES
(1, 'Katiaش', 'katia@gmail.com', '123', 'NYC', '172374393', '70,71,,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90', '1,3'),
(3, 'test 6', 'test1@gmail.com', 'test1', 'Shafe\'amer', '120', '0', NULL),
(5, 'asa asa', 'as@gmail.com', '12', 'Shefa’Amer', '0521234567', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id_o` int(11) NOT NULL,
  `id_cus` int(11) DEFAULT NULL,
  `id_p` varchar(500) DEFAULT NULL,
  `amount` varchar(500) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `id_w` int(11) NOT NULL,
  `amount_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id_o`, `id_cus`, `id_p`, `amount`, `status`, `date`, `start`, `end`, `id_w`, `amount_price`) VALUES
(68, 1, '2', '4', 'Has been reviewed', '2023-07-08 00:00:00', '2023-07-14 15:44:31', '2023-07-15 15:49:07', 5, NULL),
(69, 1, '2', '4', 'Shipped', '2023-07-08 00:00:00', '2023-07-14 15:44:31', '2023-07-14 15:49:07', 5, NULL),
(70, 1, '2', '1', 'Shipped', '2023-07-18 16:37:28', '2023-07-29 10:50:34', '2023-07-29 10:50:41', 5, NULL),
(80, 1, '1,2', '1,1', 'complete', '2023-08-11 20:47:50', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(81, 1, '1,2', '3,1', 'Request', '2023-08-12 20:48:24', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(82, 1, '1', '2', 'Request', '2023-08-12 20:50:37', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(83, 1, '1,2', '5,1', 'Request', '2023-08-12 20:58:40', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(84, 1, '2', '1', 'Request', '2023-08-12 22:00:14', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(85, 1, '2', '1', 'Request', '2023-08-12 22:02:30', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, NULL),
(86, 1, '3', '1', 'Request', '2023-08-12 22:04:59', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, '54.00'),
(87, 1, '1', '3', 'Request', '2023-08-25 11:34:24', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, '45.00'),
(88, 1, '1', '3', 'Request', '2023-08-25 11:35:05', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, '45.00'),
(89, 1, '3', '2', 'Request', '2023-08-25 11:36:39', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, '108.00'),
(90, 1, '3', '2', 'Request', '2023-08-25 11:51:27', '2023-01-01 00:00:00', '2023-01-01 00:00:00', 0, '108.00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_p` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `body` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(256) NOT NULL,
  `inventory` int(11) NOT NULL,
  `gender` enum('woman','men','kids','jewelry') DEFAULT NULL,
  `clothing_jewelry` enum('dress','t-shirt','pants','necklaces','rings','bracelets') DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_s` varchar(50) DEFAULT NULL,
  `status_m` varchar(50) DEFAULT NULL,
  `status_l` varchar(50) DEFAULT NULL,
  `s` varchar(255) DEFAULT NULL,
  `m` varchar(255) DEFAULT NULL,
  `l` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_p`, `name`, `body`, `price`, `image`, `inventory`, `gender`, `clothing_jewelry`, `status`, `status_s`, `status_m`, `status_l`, `s`, `m`, `l`) VALUES
(1, 'hiiisssjhghgjhghjgj', 'test1', 15, 'img/dress.jpg', 0, 'woman', 'dress', 'Out of Stock', 'available', 'Out of Stock', 'available', '6', '0', '3'),
(2, 'test2', 'Colorful dress for summer', 50, 'img/dress1.jpg', 0, 'woman', 'dress', 'Out of Stock', 'Out of Stock', 'Out of Stock', 'Out of Stock', '0', '0', '0'),
(3, 'test3', 'body', 54, 'img/dress2.jpg', 1, 'woman', 'dress', 'available', 'available', 'Out of Stock', 'Out of Stock', '1', '0', '0'),
(4, 'test4', 'body', 34, 'img/dress3.jpg', 5, 'woman', 'dress', 'available', NULL, NULL, NULL, '6', '0', '3'),
(8, 'tshirt', 'tshirt for men', 10, 'img/top.jpg', 10, 'men', 't-shirt', 'available', NULL, NULL, NULL, '6', '0', '3');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id_r` int(11) NOT NULL,
  `id_p` int(11) NOT NULL,
  `review` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id_r`, `id_p`, `review`) VALUES
(1, 2, 'good'),
(2, 2, 'Love'),
(3, 2, 'test?'),
(4, 2, 'test?'),
(5, 2, 'hello'),
(6, 2, '2\r\n'),
(7, 2, 'review'),
(8, 2, '..'),
(9, 2, 'done\r\n'),
(10, 2, 'ha'),
(11, 2, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `id_w` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `id_o` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`id_w`, `name`, `email`, `password`, `city`, `phone`, `id_o`) VALUES
(1, 'q', 'q', 'q', 'q', 'q', '0'),
(3, 'test', 'test@gmail.com', 'test', 'test', '1234', '0'),
(5, 'worker', 'worker@gmail.com', '123', 'Shefa’Amer', '123', '68,69,70,71'),
(7, 'aslkj asjl', 'asju@gmail.com', 'ks', 'sa', '0521234555', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_r`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
