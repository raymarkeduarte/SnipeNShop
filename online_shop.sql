-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2022 at 01:25 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shop`
--
CREATE DATABASE IF NOT EXISTS `online_shop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `online_shop`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_image` blob NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_image`, `cat_name`, `cat_description`) VALUES
(4, 0x50726f647563742d4d6f7573652e6a7067, 'Mouse', 'Pang click'),
(5, 0x494d475f333836342e77656270, 'Keyboard', 'Type type type'),
(12, 0x50726f647563742d4d6f6e69746f722e6a7067, 'Monitor', 'A computer monitor is an output device that displays information in pictorial or text form. A monitor usually comprises a visual display, some circuitry, a casing, and a power supply.'),
(13, 0x72616d2e6a7067, 'RAM', 'Random-access memory is a form of computer memory that can be read and changed in any order, typically used to store working data and machine code.'),
(14, 0x50726f636573736f722e6a7067, 'Processor', 'A processor (CPU) is the logic circuitry that responds to and processes the basic instructions that drive a computer. The CPU is seen as the main and most crucial integrated circuitry (IC) chip in a computer, as it is responsible for interpreting most of computers commands.'),
(15, 0x434841535349532e6a7067, 'Computer Case', 'A computer case, also known as a computer chassis, is the enclosure that contains most of the components of a personal computer (usually excluding the display, keyboard, and mouse). Cases are usually constructed from steel (often SECCâ€”steel, electrogalvanized, cold-rolled, coil), aluminium and plastic. Other materials such as glass, wood, acrylic and even Lego bricks have appeared in home-built cases.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_image` blob NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_brand` varchar(50) NOT NULL,
  `prod_description` text NOT NULL,
  `prod_quantity` int(4) NOT NULL,
  `prod_price` decimal(8,2) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_image`, `prod_name`, `prod_brand`, `prod_description`, `prod_quantity`, `prod_price`, `cat_id`) VALUES
(1, 0x50726f647563742d4d6f6e69746f722e6a7067, 'HP Smart TV/Monitor', 'HP', '24 inches ito at 720p na den', 30, '9900.45', 12),
(20, 0x494d475f333836342e77656270, 'Keyboard v2', 'Logitech', 'Limited edition!', 68, '999.88', 5),
(21, 0x50726f647563742d4d6f6e69746f722e6a7067, 'Smart TV', 'Samsung', 'high definition monitor', 3, '8998.00', 12),
(22, 0x72616d2e6a7067, 'DDR99 RAM', 'STARK', '1 Terabytes of RAM!', 1, '599487.99', 13),
(23, 0x6370752e6a7067, 'ThreadZipper 9998Z', 'SpaceX', '999-core, with 3.2k threads. Considered as the fastest CPU in 2029. Features a 9.7 GHz base clock and a 12.1 GHz max boost clock that facilitates multitasking and fast load times.', 5, '990333.45', 14);

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_firstName` varchar(50) NOT NULL,
  `seller_lastName` varchar(50) NOT NULL,
  `seller_userName` varchar(50) NOT NULL,
  `seller_password` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 5,
  `lock_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`seller_firstName`, `seller_lastName`, `seller_userName`, `seller_password`, `status`, `lock_date`) VALUES
('AJ', 'Ferry', 'aj', '25d55ad283aa400af464c76d713c07ad', 5, ''),
('Raymark', 'Dela Cruz', 'ray', '81dc9bdb52d04dc20036dbd8313ed055', 5, ''),
('Renzo', 'Malubay', 'renzo', '1a1dc91c907325c69271ddf0c944bc72', 5, ''),
('Althea', 'Bantatua', 'thea', '25d55ad283aa400af464c76d713c07ad', 5, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
