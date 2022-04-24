-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2022 at 03:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_telp` varchar(14) NOT NULL,
  `isowner` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_username`, `admin_password`, `admin_telp`, `isowner`) VALUES
(1, 'lorem@ipsum.com', 'admin', '123', '08123456789', 'false'),
(2, 'kevindarmawan022@gmail.com', 'kevin', '$2y$10$6bM1Nkh5ND.f5CrH.h0AcuxiMXK1d2VCYFYZZiv8sWgFYwzNNWB4S', '6283865326472', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_telp` varchar(14) NOT NULL,
  `user_pfp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_email`, `user_telp`, `user_pfp`) VALUES
(48, 'kevin', '$2y$10$X6nKLfgjacFCXJtCmMrHyeTnO0P9a5xCfZgDTDeJo5olDZTtiqAUi', 'kevindarmawan022@gmail.com', '6281905013973', '62617b83eb01d.webp'),
(52, 'kevin1231', '$2y$10$39FGWEKcp0LaNdtXxPyeTOw/l19kb.eb2.srSZKb5axpp2vIc3qSq', 'Lorem@Ipsum.com', '6281905013973', '626550aa9bbb5.jfif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
