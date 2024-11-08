-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 05:42 PM
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
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`email`, `username`, `password`, `status`) VALUES
(' ', 'admin', '$2y$10$dwSUylM4p8LrRWjJai0TC.nrfnVrRDkCl040H0vd7HHK3Tgx/AyVK', 'active'),
('farrelsirah@gmail.com', 'farel', '$2y$10$.Sht8.smGOwAfFm47d4S1.zSfY/O0EkmxcZFOjUIfyqZbDz3/o2cG', 'banned'),
('raihanrahmadiniputri@gmail.com', 'puput', '$2y$10$hdwnoxuYHiZ0rxrqza.5sOoOanMozmK462h5ANMJXUpd/znrd91CO', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` date NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `gambar`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kuantitas`, `ISBN`, `deskripsi`) VALUES
(1, '2024-11-07 15.45.25.jpg', 'Make You Own Happiness', 'Mark Worthington', 'Balboa Press', '2022-05-05', 12, '1982294574', 'Where Your Happiness Hides gives readers real hope for a happier life. Even before the pandemic, many people struggled to find consistent fulfillment. '),
(3, '2024-11-07 15.50.27.jpg', 'Konspirasi Alam Semesta', 'Fiersa Bersari', 'Media Kita', '2022-08-30', 5, ' 9797946568', 'Entah apa yang ada di dalam pikiran Juang Astrajingga, ketika di suatu sore, dirinya tidak sengaja bertabrakan dengan seorang gadis di salah satu lorong di antara deretan toko buku di daerah Palasari. '),
(5, '2024-11-07 16.08.43.jpg', 'The Psychology of Money', 'Morgan Housel', 'Gramedia Pustaka Utama', '2019-09-16', 2, '6020633179', 'Orang mengira ketika Anda ingin mengubah hidup, Anda perlu memikirkan hal-hal besar. '),
(6, '2024-11-07 16.13.11.jpg', 'The Many Faces Of Autism', 'Jorieke Duvekot', ' Universiteit Leiden', '2024-11-09', 13, '70645678092', 'The Many Faces Of Autism'),
(7, '2024-11-07 16.18.13.jpg', 'Catatan Juang', 'Fiersa Besari', 'Mediakita', '2017-01-01', 6, '9797945499', ' Buku yang ia sebut \"obat kuat\" berisi goresan tinta seorang pria bernama Juang di tiap lembar buku, membuka cakrawala pengetahuan, dan menemani tiap langkah kehidupan Suar.'),
(8, '2024-11-07 16.31.32.jpg', 'Data Structures', 'Mark A. Weiss', 'Pearson', '2013-01-01', 7, '0132847377', 'Data Structures and Algorithm Analysis in C++ (4th Edition) by Mark A. Weiss is a comprehensive textbook that focuses on the design and analysis of algorithms and data structures. '),
(9, '2024-11-07 16.35.58.jpg', 'The Algorithm Design ', 'Steven S. Skiena', 'Springer', '2008-01-01', 11, '1848000698', 'This book is well-known for providing a practical guide to designing and analyzing algorithms. Steven Skiena offers many real-world examples and presents algorithm design techniques in a very practical and easy-to-understand way.'),
(10, '2024-11-07 16.42.56.jpg', 'The Selection', 'Kiera Cass', 'HarperCollins', '2012-04-24', 9, '0062059939', 'Fall in love—from the very beginning. Discover the first book in the captivating, #1 New York Times bestselling Selection series.'),
(11, '2024-11-07 17.10.56.jpg', 'Dont Make Me Think', 'Steve Krug', 'Pearson Education', '2013-12-23', 2, ' 01335972', 'Since it was first published in 2000, hundreds of thousands of Web designers and developers have relied on usability guru Steve Krugs guide to understand the principles of intuitive navigation and information design.'),
(12, '2024-11-07 17.14.56.jpg', 'The Lean Startup', 'Eric Ries', 'Bentang Pustaka', '2018-06-08', 6, '6022914981', 'Lean Startup bukanlah metode yang menjadikan sistem Anda lebih hemat biaya, melainkan lebih efisien sekaligus (tetap) bermanfaat.'),
(13, '2024-11-08 06.27.18.jpg', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', '1980-08-25', 12, '602063719', 'Buku ini bercerita tentang perjalanan seorang tokoh bernama Minke. Minke adalah salah satu anak pribumi yang sekolah di HBS. Pada masa itu, yang dapat masuk ke sekolah HBS adalah orang-orang keturunan Eropa. Minke adalah seorang pribumi yang pandai, ia sangat pandai menulis.'),
(14, '2024-11-07 17.28.05.webp', 'JavaScript The Good Parts', 'Douglas Crockford', 'OReilly Media', '2008-05-08', 6, '0596554877', 'Most programming languages contain good and bad parts, but JavaScript has more than its share of the bad, having been developed and released in a hurry before it could be refined.'),
(15, '2024-11-07 17.34.16.jpg', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang', '2011-01-01', 18, '602881136', 'Laskar Pelangi adalah novel pertama karya Andrea Hirata yang diterbitkan oleh Bentang Pustaka pada tahun 2005. Novel ini bercerita tentang kehidupan 10 anak dari keluarga miskin yang bersekolah di sebuah sekolah Muhammadiyah di Pulau Belitung yang penuh dengan keterbatasan.'),
(16, '2024-11-07 17.39.00.jpg', 'Gadis Kretek', 'Ratih Kumala', 'Gramedia Pustaka Utama', '2012-01-01', 10, '97922814', 'Pak Raja sekarat. Dalam menanti ajal, ia memanggil satu nama perempuan yang bukan istrinya; Jeng Yah. Tiga anaknya, pewaris Kretek Djagad Raja, dimakan gundah.'),
(17, '2024-11-07 17.41.51.jpg', 'Negeri 5 Menara', 'A. Fuadi', 'Gramedia Pustaka Utama', '2013-02-01', 8, '9792280049', 'Man Jadda Wajada, siapa yang sungguh-sungguh akan berhasil. Kalimat itu bukan hanya “mantra” dalam cerita novel Negeri 5 Menara. '),
(18, '2024-11-08 04.44.31.jpg', 'Laut Bercerita', 'Leila S. Chudori', 'Kepustakaan Populer Gramedia', '2017-10-25', 6, ' 6024246943', 'Jakarta, Maret 1998 Di sebuah senja, di sebuah rumah susun di Jakarta, mahasiswa bernama Biru Laut disergap empat lelaki tak dikenal. '),
(19, '2024-11-08 04.52.24.jpg', 'Detektif Conan 10', 'Gōshō Aoyama', 'Elex Media Komputindo', '2023-03-10', 4, '9792001174', 'Suatu hari, datang seorang pemuda yang mengaku sebagai detektif dari barat ke rumah Ran. Ia mencari Shinichi dan menantangnya untuk menyelesaikan suatu kasus.'),
(20, '2024-11-08 04.59.53.jpg', 'Thinking, Fast and Slow', 'Daniel Kahneman', 'Gramedia Pustaka Utama', '2020-05-29', 11, ' 6020637190', 'Dalam buku yang sangat dinanti-nantikan ini, Kahneman menjelaskan dua sistem yang mendorong cara kita berpikir. Sistem 1 bersifat cepat, intuitif, dan emosional; Sistem 2 lebih pelan, lebih bertujuan, dan lebih logis.'),
(21, '2024-11-08 05.10.07.jpg', 'The Hidden Life of Trees', 'Peter Wohlleben', 'Greystone Books', '2016-09-13', 9, '1771642491', 'A NEW YORK TIMES, WASHINGTON POST, AND WALL STREET JOURNAL BESTSELLER • One of the most beloved books of our time: an illuminating account of the forest, and the science that shows us how trees communicate, feel, and live in social networks. After reading this book, a walk in the woods will never be the same again.'),
(22, '2024-11-08 05.24.02.jpg', 'Turn Left at Orion', 'Guy Consolmagno, Dan M. Davis', 'Cambridge University Press', '2000-10-19', 15, ' 0521781906', 'A superb guidebook described in Bookwatch as the home astronomers bible, Turn Left at Orion provides all the information beginning amateur astronomers need to observe the Moon, the planets and a whole host of celestial objects.');

-- --------------------------------------------------------

--
-- Table structure for table `lupa`
--

CREATE TABLE `lupa` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lupa`
--

INSERT INTO `lupa` (`email`, `token`, `created_at`, `reset_token_expiry`) VALUES
('ayunie.755@gmail.com', 'e61ec47971', '2024-11-05 10:51:27', '2024-11-05 19:51:27'),
('raihanrahmadiniputri0610@gmail.com', '727c559204', '2024-11-05 11:06:51', '2024-11-05 20:06:51'),
('raihanrahmadiniputri148@gmail.com', '4839647358', '2024-11-05 11:04:57', '2024-11-05 20:04:57'),
('raihanrahmadiniputri@gmail.com', 'd990e9db99', '2024-11-08 14:17:45', '2024-11-08 23:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` varchar(5) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` enum('dipinjam','dikembalikan') NOT NULL DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_buku`, `username`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
('PJ115', 5, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ308', 3, 'puput', '2024-11-07', '2024-11-14', 'dipinjam'),
('PJ428', 3, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ441', 3, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ566', 13, 'puput', '2024-11-08', '2024-11-15', 'dipinjam'),
('PJ763', 1, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ817', 1, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ895', 1, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan'),
('PJ953', 5, 'puput', '2024-11-07', '2024-11-14', 'dikembalikan');

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `pinjam` AFTER INSERT ON `peminjaman` FOR EACH ROW BEGIN
    UPDATE buku
    SET kuantitas = kuantitas - 1
    WHERE id = NEW.id_buku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` varchar(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `id_pinjam` varchar(5) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `denda` decimal(10,2) NOT NULL,
  `status` enum('tepat waktu','telat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `username`, `id_pinjam`, `id_buku`, `tanggal_kembali`, `denda`, `status`) VALUES
('KM168', 'ayuni', 'PJ652', 2, '2024-11-06', 0.00, 'telat'),
('KM182', 'puput', 'PJ895', 1, '2024-11-07', 0.00, 'tepat waktu'),
('KM267', 'ayuni', 'PJ603', 2, '2024-11-07', 40000.00, 'telat'),
('KM437', 'ayuni', 'PJ988', 2, '2024-11-06', 10000.00, 'telat'),
('KM464', 'puput', 'PJ763', 1, '2024-11-07', 80000.00, 'telat'),
('KM627', 'ayuni', 'PJ516', 2, '2024-11-07', 0.00, 'tepat waktu'),
('KM643', 'puput', 'PJ115', 5, '2024-11-07', 0.00, 'tepat waktu'),
('KM650', 'ayuni', 'PJ473', 3, '2024-11-06', 0.00, 'tepat waktu'),
('KM800', 'ayuni', 'PJ604', 2, '2024-11-07', 0.00, 'tepat waktu'),
('KM993', 'ayuni', 'PJ986', 2, '2024-11-07', 80000.00, 'telat');

--
-- Triggers `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `kembali` AFTER INSERT ON `pengembalian` FOR EACH ROW BEGIN
    UPDATE buku
    SET kuantitas = kuantitas + 1
    WHERE id = NEW.id_buku;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `status` AFTER INSERT ON `pengembalian` FOR EACH ROW BEGIN
    -- Update status to 'dikembalikan' in the peminjaman table
    UPDATE peminjaman
    SET status = 'dikembalikan'
    WHERE id = NEW.id_pinjam;  -- Assuming buku_id is the key to link the tables
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_kontak`
--

CREATE TABLE `pesan_kontak` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesan_kontak`
--

INSERT INTO `pesan_kontak` (`id`, `nama_depan`, `nama_belakang`, `email`, `pesan`, `tanggal_dibuat`) VALUES
(1, 'Raihan ', 'Putri', 'raihanrahmadiniputri148@gmail.com', 'aaaaaaaaaaaaaaaaa', '2024-11-07 05:01:25'),
(2, 'Raihan ', 'Putri', 'raihanrahmadiniputri148@gmail.com', 'aaaaaaaaaaaaaaaaa', '2024-11-07 05:03:24'),
(3, 'Raihan ', 'Putri', 'raihanrahmadiniputri148@gmail.com', 'aaaaaaaaaaaaaaaaa', '2024-11-07 05:05:23'),
(4, 'Raihan ', 'Putri', 'raihanrahmadiniputri148@gmail.com', 'aaaaaaaaaaaaaaaaa', '2024-11-07 05:05:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indexes for table `lupa`
--
ALTER TABLE `lupa`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idbuku` (`id_buku`),
  ADD KEY `fk_user` (`username`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_uname` (`username`),
  ADD KEY `fk_pinjam` (`id_pinjam`),
  ADD KEY `fk_buku` (`id_buku`);

--
-- Indexes for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
