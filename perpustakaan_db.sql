-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2022 at 12:24 AM
-- Server version: 5.7.38-0ubuntu0.18.04.1
-- PHP Version: 7.2.34-28+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `isbn` varchar(20) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`isbn`, `judul`, `pengarang`, `penerbit`, `tahun`, `stok`) VALUES
('978-602-05-2857-1', 'Sebuah Seni Untuk Bersikap Bodo Amat', 'Mark Manson', 'Grasindo (Gramedia Widia Sarana Indonesia)', 2021, 101),
('978-602-220-333-9', 'KKN di Desa Penari', 'SimpleMan', 'PT. Bukune Kreatif Cipta', 2019, 67),
('978-602-220-348-3', 'Sewu Dino', 'SimpleMan', 'PT. Bukune Kreatif Cipta', 2019, 98),
('978-602-220-364-3', 'Janur Ireng', 'SimpleMan', 'PT. Bukune Kreatif Cipta', 2020, 100),
('978-602-220-399-5', 'Ranjat Kembang', 'SimpleMan', 'PT. Bukune Kreatif Cipta', 2021, 99);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `alamat`, `jenis_kelamin`) VALUES
('112010057', 'Ryan Aunur Rassyid', 'Teknik Informatika', 'Jombang', 'L'),
('112010058', 'S. Linda Rohmana Wulan Sari', 'Teknik Informatika', 'Lamongan', 'P'),
('112010078', 'Cindy Lilla', 'Teknik Informatika', 'Lamongan', 'P'),
('112010102', 'M. Iqbal Panduwinata', 'Teknik Informatika', 'Bojonegoro', 'L'),
('112010105', 'Putra Vira Madya', 'Teknik Informatika', 'Lamongan', 'L'),
('112010165', 'Fatma Sa\'diyah', 'Teknik Informatika', 'Lamongan', 'P'),
('112010173', 'M. Akmal Syarifuddin', 'Teknik Informatika', 'Gresik', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` varchar(20) NOT NULL,
  `buku_id` varchar(20) NOT NULL,
  `denda` int(11) NOT NULL DEFAULT '0',
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `tanggal_harus_kembali` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `mahasiswa_id`, `buku_id`, `denda`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_harus_kembali`, `status`) VALUES
(1, '112010057', '978-602-220-348-3', 19000, '2022-04-22', '2022-05-04', '2022-04-15', 'kembali'),
(2, '112010057', '978-602-220-348-3', 1000, '2022-04-29', '2022-04-29', '2022-04-29', 'kembali'),
(3, '112010057', '978-602-220-348-3', 16000, '2022-05-04', '2022-05-23', '2022-05-07', 'kembali'),
(4, '112010057', '978-602-220-348-3', 0, '2022-05-23', NULL, '2022-05-25', 'pinjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_buku_fk` (`buku_id`),
  ADD KEY `transaksi_mahasiswa_fk` (`mahasiswa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_buku_fk` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`isbn`),
  ADD CONSTRAINT `transaksi_mahasiswa_fk` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
