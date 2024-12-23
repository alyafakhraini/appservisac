-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 11:07 AM
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
-- Database: `serasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_cust` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nm_cust` varchar(255) NOT NULL,
  `alamat_cust` varchar(255) NOT NULL,
  `wilayah_cust` varchar(255) NOT NULL,
  `telp_cust` varchar(255) NOT NULL,
  `email_cust` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_cust`, `id_user`, `nm_cust`, `alamat_cust`, `wilayah_cust`, `telp_cust`, `email_cust`) VALUES
(1, 21, 'Alya Fakhraini', 'Jl. Bridgen Hasan Basri', '1', '081234567890', 'a@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_servis`
--

CREATE TABLE `tbl_jenis_servis` (
  `id_jenis` int(11) NOT NULL,
  `nm_servis` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `biaya` varchar(255) NOT NULL,
  `durasi` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jenis_servis`
--

INSERT INTO `tbl_jenis_servis` (`id_jenis`, `nm_servis`, `deskripsi`, `biaya`, `durasi`, `gambar`) VALUES
(1, 'Cleaning', 'Pembersihan menyeluruh unit AC dari debu, kotoran, dan sisa-sisa kotoran lainnya.', '150000', '1-2 Jam', 'cleaning.jpg'),
(2, 'Repair', 'Perbaikan kerusakan pada unit AC seperti kebocoran, kerusakan komponen, dan sistem pendinginan yang tidak berfungsi.', '300000', '3-4 Jam', 'repair.jpg'),
(3, 'Maintenance', 'Pemeliharaan rutin untuk menjaga kinerja AC tetap optimal, termasuk penggantian filter dan pengecekan sistem.', '250000', '2-3 Jam', 'maintenance.jpg'),
(4, 'Instalasi Baru', 'Instalasi AC baru mulai dari pemasangan hingga konfigurasi pengaturan.', '500000', '5-6 Jam', 'baru.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servis`
--

CREATE TABLE `tbl_servis` (
  `id_servis` int(11) NOT NULL,
  `id_cust` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_teknisi` int(11) NOT NULL,
  `tgl_servis` date NOT NULL,
  `bukpem` varchar(255) NOT NULL,
  `status_pem` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `alasan` text NOT NULL,
  `batal_cust` varchar(255) NOT NULL,
  `gagal_pem` varchar(255) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_spesialisasi`
--

CREATE TABLE `tbl_spesialisasi` (
  `id_spes` int(11) NOT NULL,
  `id_teknisi` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_spesialisasi`
--

INSERT INTO `tbl_spesialisasi` (`id_spes`, `id_teknisi`, `id_jenis`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 3),
(5, 3, 1),
(6, 3, 2),
(7, 3, 3),
(8, 4, 2),
(9, 5, 3),
(10, 6, 1),
(11, 6, 3),
(12, 7, 1),
(13, 7, 2),
(14, 8, 2),
(15, 8, 4),
(16, 9, 1),
(17, 9, 3),
(18, 10, 3),
(19, 10, 4),
(20, 11, 3),
(21, 11, 4),
(22, 12, 2),
(23, 13, 4),
(24, 13, 2),
(25, 13, 1),
(26, 14, 4),
(27, 15, 1),
(28, 15, 2),
(29, 15, 3),
(30, 15, 4),
(32, 16, 3),
(33, 16, 1),
(34, 16, 4),
(35, 17, 2),
(36, 17, 4),
(37, 18, 1),
(38, 19, 2),
(39, 19, 3),
(40, 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teknisi`
--

CREATE TABLE `tbl_teknisi` (
  `id_teknisi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nm_teknisi` varchar(255) NOT NULL,
  `alamat_teknisi` text NOT NULL,
  `wilayah_teknisi` varchar(255) NOT NULL,
  `telp_teknisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teknisi`
--

INSERT INTO `tbl_teknisi` (`id_teknisi`, `id_user`, `nm_teknisi`, `alamat_teknisi`, `wilayah_teknisi`, `telp_teknisi`) VALUES
(1, 2, 'Ahmad Fauzi', 'Jl. Sultan Adam, RT 03, RW 02', '1', '081234567890'),
(2, 3, 'Rizky Saputra', 'Jl. Lambung Mangkurat, RT 02, RW 01', '3', '083456789012'),
(3, 4, 'Andi Gunawan', 'Jl. Sutoyo S, RT 06, RW 03', '5', '085678901234'),
(4, 5, 'Fajar Maulana', 'Jl. Belitung Darat, RT 03, RW 01', '2', '082334556677'),
(5, 6, 'Muhammad Ridwan', 'Jl. Brigjen Hasan Basry, RT 01, RW 02', '1', '086789012345'),
(6, 7, 'Farhan Rahmad', 'Jl. Pramuka, RT 06, RW 03', '4', '081901234567'),
(7, 8, 'Yudha Pratama', 'Jl. H. Hasan Basry, RT 05, RW 02', '1', '083901234567'),
(8, 9, 'Fadli Akbar', 'Jl. Lambung Mangkurat II, RT 02, RW 01', '3', '086901234567'),
(9, 10, 'Rizwan Saputra', 'Jl. Gatot Subroto, RT 01, RW 01', '5', '089901234567'),
(10, 11, 'Ardiansyah Putra', 'Jl. Sungai Andai, RT 01, RW 02', '1', '082901234876'),
(11, 12, 'Fahmi Wijaya', 'Jl. Sultan Adam VI, RT 03, RW 01', '2', '083456789012'),
(12, 13, 'Rendi Akmal', 'Jl. Ahmad Yani, RT 05, RW 03', '3', '084567890123'),
(13, 14, 'Ilham Ramadhan', 'Jl. Veteran, RT 04, RW 02', '4', '085678901234'),
(14, 15, 'Yusuf Rachman', 'Jl. Belitung Darat, RT 06, RW 03', '5', '086789012345'),
(15, 16, 'Dimas Anggara', 'Jl. Pangeran, RT 03, RW 03', '2', '087890123456'),
(16, 17, 'Fajar Pratama', 'Jl. Kampung Melayu, RT 03, RW 01', '3', '085789012345'),
(17, 18, 'Arfan Setiawan', 'Jl. Sutoyo S Barat, RT 02, RW 02', '5', '083234567890'),
(18, 19, 'Agung Saputra', 'Jl. Komplek Herlina, RT 01, RW 03', '2', '086890123456'),
(19, 20, 'Hendra Surya', 'Jl. Gatot Subroto IV, RT 06, RW 02', '4', '087678901234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `jk_user` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `jk_user`, `foto`, `level`, `status`) VALUES
(1, 'admin', 'admin', '', '', 1, 'aktif'),
(2, 'fauzi', 'fauzi', 'lk', '', 2, 'aktif'),
(3, 'rizky', 'rizky', 'lk', '', 2, 'aktif'),
(4, 'andi', 'andi', 'lk', '', 2, 'aktif'),
(5, 'fajar', 'fajar', 'lk', '', 2, 'aktif'),
(6, 'ridwan', 'ridwan', 'lk', '', 2, 'aktif'),
(7, 'farhan', 'farhan', 'lk', '', 2, 'aktif'),
(8, 'yudha', 'yudha', 'lk', '', 2, 'aktif'),
(9, 'fadli', 'fadli', 'lk', '', 2, 'aktif'),
(10, 'rizwan', 'rizwan', 'lk', '', 2, 'aktif'),
(11, 'ardiansyah', 'ardiansyah', 'lk', '', 2, 'aktif'),
(12, 'fahmi', 'fahmi', 'lk', '', 2, 'aktif'),
(13, 'rendi', 'rendi', 'lk', '', 2, 'aktif'),
(14, 'ilham', 'ilham', 'lk', '', 2, 'aktif'),
(15, 'yusuf', 'yusuf', 'lk', '', 2, 'aktif'),
(16, 'dimas', 'dimas', 'lk', '', 2, 'aktif'),
(17, 'pratama', 'pratama', 'lk', '', 2, 'aktif'),
(18, 'arfan', 'arfan', 'lk', '', 2, 'aktif'),
(19, 'agung', 'agung', 'lk', '', 2, 'aktif'),
(20, 'hendra', 'hendra', 'lk', '', 2, 'aktif'),
(21, 'alya', 'alya', 'pr', '', 3, 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `tbl_jenis_servis`
--
ALTER TABLE `tbl_jenis_servis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tbl_servis`
--
ALTER TABLE `tbl_servis`
  ADD PRIMARY KEY (`id_servis`);

--
-- Indexes for table `tbl_spesialisasi`
--
ALTER TABLE `tbl_spesialisasi`
  ADD PRIMARY KEY (`id_spes`);

--
-- Indexes for table `tbl_teknisi`
--
ALTER TABLE `tbl_teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_jenis_servis`
--
ALTER TABLE `tbl_jenis_servis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_servis`
--
ALTER TABLE `tbl_servis`
  MODIFY `id_servis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_spesialisasi`
--
ALTER TABLE `tbl_spesialisasi`
  MODIFY `id_spes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_teknisi`
--
ALTER TABLE `tbl_teknisi`
  MODIFY `id_teknisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
