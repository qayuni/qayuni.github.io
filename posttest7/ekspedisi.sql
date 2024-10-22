-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 08:03 PM
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
-- Database: `ekspedisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `resi` varchar(6) NOT NULL,
  `pengirim` varchar(50) NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `jenis` enum('Dokumen','Barang','Elektronik','Makanan') NOT NULL,
  `berat` int(11) NOT NULL,
  `status_paket` enum('Pending','Dikonfirmasi','Dikirim','Diterima') NOT NULL DEFAULT 'Pending',
  `bukti` varchar(255) NOT NULL,
  `konfirmasi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`resi`, `pengirim`, `penerima`, `alamat`, `hp`, `jenis`, `berat`, `status_paket`, `bukti`, `konfirmasi`) VALUES
('SCP001', 'tyui', 'cfvghbj', 'i', '2', 'Barang', 10, 'Dikirim', '', ''),
('SCP002', '4567', 'dfgh', 'xrctfvybh', '78', 'Makanan', 6, 'Pending', '', ''),
('SCP003', '4567', 'fgh', 'fgh', '8', 'Elektronik', 7, 'Pending', '', ''),
('SCP004', 'erty', 'sdfgh', 'zxrctfvgbh', '567', 'Elektronik', 6, 'Pending', '', ''),
('SCP005', 'tfygh', 'rtyu', 'vygbhjn', '00000000000', 'Dokumen', 12, 'Diterima', '2024-10-16_11.20.26.png', ''),
('SCP006', 'wertyu', 'qwertyui', 'sdfghjkl', '1234567890', 'Barang', 12, 'Pending', '', ''),
('SCP007', 'miaw', 'mew', 'duar', '081649427018', 'Barang', 6, 'Diterima', '2024-10-16_12.28.48.png', ''),
('SCP008', 'ayuni', 'elly', 'unmul', '0000000000', 'Dokumen', 1, 'Diterima', '2024-10-16_09.35.45.jpg', ''),
('SCP009', 'marius', 'vyn', 'stellis', '1', 'Dokumen', 2, 'Pending', '', ''),
('SCP010', 'luke', 'artem', 'north stellis', '0000000000', 'Barang', 2, 'Diterima', '2024-10-16_09.46.52.jpeg', ''),
('SCP011', 'fgh', 'gh', 'f', '4', 'Barang', 4, 'Pending', '', 'DEE10'),
('SCP012', 'mew', 'mwe', 'arop', '2', 'Dokumen', 12, 'Pending', '', '5A093'),
('SCP013', 'mew', 'se', 'wer', '081649427018', 'Barang', 12, 'Diterima', '2024-10-22_06.20.42.png', 'C4F97'),
('SCP014', 'mew', 'ad', 'wer', '00000000000', 'Elektronik', 12, 'Pending', '', 'E4A04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$10$TejGnSz9sUKw79AENph7KuZSwX5TXLLqiXIo/g4yXvZMozQem/6Yi'),
('ayuni', '$2y$10$45EWYdeJ6xtu/YoD2gpzoufcPXh0nEfXODzg6hwC1DsPl3y3Ov8/.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`resi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
