-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 01:50 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `IdKonsultasi` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `IdPasien` bigint(20) NOT NULL,
  `NIK` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `NoHP` varchar(15) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `HasilAnalisa` text NOT NULL,
  `ResepObat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`IdKonsultasi`, `Tanggal`, `IdPasien`, `NIK`, `Nama`, `NoHP`, `Status`, `HasilAnalisa`, `ResepObat`) VALUES
(2311, '2024-10-27', 2157201030, '273238293', 'Agus Salim', 'q3982739837273', 'Dosen', 'demam', 'parastamol'),
(5162, '2024-10-27', 2157201032, '140392089883', 'M.ZULFIQRI', '08239828329', 'Mahasiswa', 'demam', 'prastamol');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `IdPasien` bigint(20) NOT NULL,
  `NIK` varchar(16) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `TTL` varchar(100) NOT NULL,
  `Alamat` text NOT NULL,
  `NoHP` varchar(15) NOT NULL,
  `Status` enum('Dosen','Karyawan','Mahasiswa','Umum') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`IdPasien`, `NIK`, `Nama`, `TTL`, `Alamat`, `NoHP`, `Status`) VALUES
(2157201030, '28127918181182', 'Agus Salim', 'Perawang, 11 Januari 2001', 'Perawang', '0823239801239', 'Dosen'),
(2157201032, '140392089883', 'M.ZULFIQRI', 'Sungai Apit, 19 Januari 2003', 'Siak Sri Indrapura', '08239828329', 'Mahasiswa'),
(2157201047, '140409403913', 'Mhd Fahriza Kurniawan', 'Pekanbaru, 18 April 2003', 'Pekanbaru', '08239828329', 'Mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `Id` int(11) NOT NULL,
  `IdPasien` varchar(20) DEFAULT NULL,
  `Biaya` int(11) DEFAULT NULL,
  `Tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`Id`, `IdPasien`, `Biaya`, `Tanggal`) VALUES
(3, '2157201032', 50000, '2024-10-26 11:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` enum('admin','kasir','dokter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `role`) VALUES
('2157201032', '12345678', 'admin'),
('2157201047', '12345678', 'kasir'),
('2157201081', '12345678', 'dokter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`IdKonsultasi`),
  ADD KEY `IdPasien` (`IdPasien`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`IdPasien`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `IdKonsultasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5163;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD CONSTRAINT `konsultasi_ibfk_1` FOREIGN KEY (`IdPasien`) REFERENCES `pasien` (`IdPasien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
