-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2020 at 03:43 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_classica`
--

-- --------------------------------------------------------

--
-- Table structure for table `is_paket`
--

CREATE TABLE `is_paket` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(30) NOT NULL,
  `deskripsi_paket` text NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_tambahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_paket`
--

INSERT INTO `is_paket` (`id_paket`, `nama_paket`, `deskripsi_paket`, `harga`, `harga_tambahan`) VALUES
(6, 'Foto Family', 'maximal 5 orang, 4 fose, 4cetakan 4R, 1 cetakan 12R, 1Background,1 kostum', 390000, 10000),
(7, 'Paket Glamour', 'maximal 2orang, 10 foto retuch, 7 cetakan 5R, 1 cetakan 12r+lamixsani+frame, 1 backgound tematik', 750000, 30000),
(8, 'Foto Casual', 'maximal 2 orang, 4 fose, 4 cetakan 4R,1 Kostum, 1 Background polos', 70000, 10000),
(9, 'Foto Wisuda', 'maximal 5 orang, 3 pose, 3 cetakan 8R+laminasi+frame,1 background, 1 kostum', 290000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `is_transaksi`
--

CREATE TABLE `is_transaksi` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `total` int(11) NOT NULL,
  `tambahan_orang` int(11) NOT NULL,
  `paket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_transaksi`
--

INSERT INTO `is_transaksi` (`id_transaksi`, `tanggal`, `nama_pelanggan`, `total`, `tambahan_orang`, `paket`) VALUES
('TR-00001', '2020-01-20', 'shafa Kamila', 0, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `is_user`
--

CREATE TABLE `is_user` (
  `id_user` int(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `hak_akses` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `is_user`
--

INSERT INTO `is_user` (`id_user`, `username`, `password`, `nama_user`, `hak_akses`) VALUES
(1, 'uzifru', '806602bb8b70ae57a2e991ac00d26b13', 'uzifru', 'admin'),
(5, 'fauzi', '0bd9897bf12294ce35fdc0e21065c8a7', 'fauzi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `is_paket`
--
ALTER TABLE `is_paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `is_transaksi`
--
ALTER TABLE `is_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `paket` (`paket`);

--
-- Indexes for table `is_user`
--
ALTER TABLE `is_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `is_paket`
--
ALTER TABLE `is_paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `is_user`
--
ALTER TABLE `is_user`
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `is_transaksi`
--
ALTER TABLE `is_transaksi`
  ADD CONSTRAINT `is_transaksi_ibfk_1` FOREIGN KEY (`paket`) REFERENCES `is_paket` (`id_paket`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
