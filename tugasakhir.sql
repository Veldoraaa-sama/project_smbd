-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 08:50 AM
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
-- Database: `tugasakhir`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `HitungTotalSewa` (IN `p_tanggal_sewa` DATE, IN `p_tanggal_kembali` DATE, IN `p_harga_per_hari` DECIMAL(10,2), OUT `p_total` DECIMAL(10,2))   BEGIN
    DECLARE hari_sewa INT;
    SET hari_sewa = DATEDIFF(p_tanggal_kembali, p_tanggal_sewa);
    IF hari_sewa <= 0 THEN
        SET hari_sewa = 1;
    END IF;
    SET p_total = hari_sewa * p_harga_per_hari;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `posisi`, `no_telp`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Susanto', 'Admin', '081234567890', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(2, 'Siti Nurhaliza', 'Customer Service', '081234567891', '2025-05-21 03:37:04', '2025-05-21 03:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `harga_per_hari` decimal(10,2) NOT NULL,
  `status` enum('tersedia','disewa','maintenance') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `merek`, `tipe`, `tahun`, `plat_nomor`, `harga_per_hari`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', 'Avanza', '2020', 'B1234CD', 300000.00, 'disewa', '2025-05-21 03:37:04', '2025-05-21 03:43:53'),
(2, 'Honda', 'Jazz', '2019', 'B5678EF', 350000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(3, 'Suzuki', 'Ertiga', '2021', 'B9012GH', 320000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(4, 'Daihatsu', 'Xenia', '2018', 'B3456IJ', 280000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(5, 'Mitsubishi', 'Pajero', '2020', 'B7890KL', 500000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(6, 'Toyota', 'Innova', '2019', 'B2345MN', 400000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(7, 'Honda', 'Brio', '2020', 'B6789OP', 250000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(8, 'Nissan', 'March', '2018', 'B0123QR', 270000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(9, 'Toyota', 'Fortuner', '2021', 'B4567ST', 600000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(10, 'Suzuki', 'Swift', '2019', 'B8901UV', 300000.00, 'tersedia', '2025-05-21 03:37:04', '2025-05-21 03:37:04'),
(11, 'Mitsubishi', 'Xpander', '2023', 'B1234XYZ', 450000.00, 'tersedia', '2025-05-21 03:51:04', '2025-05-21 03:51:04'),
(12, 'Toyota', 'Yaris', '2022', 'B5678ABC', 300000.00, 'tersedia', '2025-05-21 03:51:04', '2025-05-21 03:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_ktp`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'adhitya', '09090090900', '08900000000', 'jomokkerto', '2025-05-21 03:43:53', '2025-05-21 03:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `status` enum('berlangsung','selesai','dibatalkan') DEFAULT 'berlangsung',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_mobil`, `id_pelanggan`, `id_karyawan`, `tanggal_sewa`, `tanggal_kembali`, `total_bayar`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-05-22', '2025-05-24', 600000.00, 'berlangsung', '2025-05-21 03:43:53', '2025-05-21 03:43:53');

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `after_insert_transaksi` AFTER INSERT ON `transaksi` FOR EACH ROW BEGIN
    UPDATE mobil SET status = 'disewa' WHERE id_mobil = NEW.id_mobil;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_transaksi` AFTER UPDATE ON `transaksi` FOR EACH ROW BEGIN
    IF NEW.status = 'selesai' AND OLD.status = 'berlangsung' THEN
        UPDATE mobil SET status = 'tersedia' WHERE id_mobil = NEW.id_mobil;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi_detail`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi_detail` (
`id_transaksi` int(11)
,`merek` varchar(50)
,`tipe` varchar(50)
,`plat_nomor` varchar(20)
,`nama_pelanggan` varchar(100)
,`nama_karyawan` varchar(100)
,`tanggal_sewa` date
,`tanggal_kembali` date
,`total_bayar` decimal(10,2)
,`status` enum('berlangsung','selesai','dibatalkan')
);

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi_detail`
--
DROP TABLE IF EXISTS `view_transaksi_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_transaksi_detail`  AS SELECT `t`.`id_transaksi` AS `id_transaksi`, `m`.`merek` AS `merek`, `m`.`tipe` AS `tipe`, `m`.`plat_nomor` AS `plat_nomor`, `p`.`nama` AS `nama_pelanggan`, `k`.`nama` AS `nama_karyawan`, `t`.`tanggal_sewa` AS `tanggal_sewa`, `t`.`tanggal_kembali` AS `tanggal_kembali`, `t`.`total_bayar` AS `total_bayar`, `t`.`status` AS `status` FROM (((`transaksi` `t` join `mobil` `m` on(`t`.`id_mobil` = `m`.`id_mobil`)) join `pelanggan` `p` on(`t`.`id_pelanggan` = `p`.`id_pelanggan`)) join `karyawan` `k` on(`t`.`id_karyawan` = `k`.`id_karyawan`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`),
  ADD UNIQUE KEY `plat_nomor` (`plat_nomor`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `no_ktp` (`no_ktp`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
