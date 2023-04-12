-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2023 at 11:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `init`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `phone_number`, `password`, `address`, `role`, `created_at`, `updated_at`) VALUES
(14, 'Quách Anh', 'Hào', 'quachanhhao', 'quachanhhao@ltw.hcmut', '0123456789', 'e10adc3949ba59abbe56e057f20f883e', '101H1\r\n', 'customer', '2023-04-12 21:30:00', '2023-04-12 21:30:00'),
(15, 'admin', 'admin', 'admin', 'admin@gmail.com', '0123456789', '$2y$10$Z/SvFKGqqc9ePkJKjWpUuu/OxRUbIC5ZGTKFqZkFXcGLAIyxqoXky', '101H1', 'admin', '2023-04-12 21:32:25', '2023-04-12 21:32:25'),
(16, 'Nguyễn Hữu', 'Hiếu', 'nguyenhuuhieu', 'nguyenhuuhieu@ltw.hcmut', '0123456789', '$2y$10$bGrEc1zvf242TYiKdtuS3./11WFeuO1PQundZ1D7Dq70oezFtDC/e', '101H2', 'customer', '2023-04-12 21:33:02', '2023-04-12 21:33:02'),
(17, 'Người', 'Dùng 1', 'customer0', 'customer0@gmail.com', '0123456789', '$2y$10$jl9Nwb6BRiNbzJbj61HmDuekC3vsQbTHHdCTogqmPmGm0z9L.2Fom', '101H3', 'customer', '2023-04-12 21:34:11', '2023-04-12 21:34:11'),
(18, 'Người', 'Dùng 1', 'customer1', 'customer1@gmail.com', '0123456789', '$2y$10$ua/WwMr0ag/HDtgi/9UUROEvs/e0C01eTecxkXEBePMPNkzzwi0C.', 'Dĩ an, Bình dương', 'customer', '2023-04-12 21:35:14', '2023-04-12 21:35:14'),
(19, 'Người', 'Dùng 2', 'customer2', 'customer2@gmail.com', '0912345678', '$2y$10$nXEsOPPK6poC5277vEgmhOGWYz5SHZMu10zFyyQUgVM/sieUJiKYS', '268 LTK P14 Q10', 'customer', '2023-04-12 21:36:08', '2023-04-12 21:36:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
