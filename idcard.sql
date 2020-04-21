-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2020 at 05:59 AM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jagowebd_idcard`
--

-- --------------------------------------------------------

--
-- Table structure for table `layout_kartu`
--

CREATE TABLE `layout_kartu` (
  `id_layout_kartu` tinyint(3) UNSIGNED NOT NULL,
  `nama_layout` varchar(255) DEFAULT NULL COMMENT 'Untuk identifikasi kartu, misal kartu untuk mahasiswa',
  `panjang` decimal(10,3) DEFAULT NULL,
  `lebar` decimal(10,3) DEFAULT NULL,
  `background_depan` varchar(255) DEFAULT NULL COMMENT 'Background kartu',
  `background_belakang` varchar(255) DEFAULT NULL,
  `berlaku` tinyint(4) DEFAULT NULL COMMENT 'Masa berlaku kartu, misal 4 tahun kedepan',
  `gunakan` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `layout_kartu`
--

INSERT INTO `layout_kartu` (`id_layout_kartu`, `nama_layout`, `panjang`, `lebar`, `background_depan`, `background_belakang`, `berlaku`, `gunakan`) VALUES
(1, 'Kartu Mahasiswa', 8.560, 5.396, 'background_depan.png', 'kartu_belakang.png', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `npm` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `qrcode_text` text DEFAULT NULL,
  `tgl_input` date DEFAULT NULL,
  `id_user_input` mediumint(8) UNSIGNED DEFAULT NULL,
  `tgl_edit` date DEFAULT NULL,
  `id_user_edit` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `npm`, `tempat_lahir`, `tgl_lahir`, `prodi`, `fakultas`, `alamat`, `foto`, `qrcode_text`, `tgl_input`, `id_user_input`, `tgl_edit`, `id_user_edit`) VALUES
(9, 'Wicaksono Catur', '123456', 'Solo', '1998-03-11', 'Sistem Informasi Modern', 'Teknik Informatika', 'Jl. Kencur No. 19, Sukoharjo', 'Wicaksono Wahyu.jpeg', 'website: www.jagowebdev.com', '2020-03-28', 1, '2020-03-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `id_module` smallint(5) UNSIGNED DEFAULT NULL,
  `id_parent` smallint(5) UNSIGNED DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `new` tinyint(1) NOT NULL DEFAULT 0,
  `urut` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `class`, `url`, `id_module`, `id_parent`, `aktif`, `new`, `urut`) VALUES
(1, 'User', 'fas fa-users', 'user', 5, 8, 1, 0, 1),
(2, 'Assign Role', 'fas fa-link', '#', 0, 8, 1, 0, 5),
(3, 'User Role', 'fas fa-user-tag', 'user-role', 7, 2, 1, 0, 1),
(4, 'Module', 'fas fa-network-wired', 'module', 2, 8, 1, 0, 2),
(5, 'Module Role', 'fas fa-desktop', 'module-role', 3, 2, 1, 0, 2),
(6, 'Menu', 'fas fa-clone', 'menu', 1, 8, 1, 0, 4),
(7, 'Menu Role', 'fas fa-folder-minus', 'menu-role', 8, 2, 1, 0, 3),
(8, 'Website', 'fas fa-globe', '#', 1, 0, 1, 0, 1),
(9, 'Data Universitas', 'fas fa-university', 'universitas', 10, 0, 1, 0, 4),
(10, 'Data Nama', 'far fa-user-circle', 'daftarnama', 9, 0, 1, 0, 3),
(11, 'Tanda Tangan', 'fas fa-pen-nib', 'tandatangan', 12, 0, 1, 0, 5),
(12, 'Layout Kartu', 'fas fa-address-card', 'layoutkartu', 11, 0, 1, 0, 2),
(13, 'Setting Printer', 'fas fa-cog', 'settingprinter', 14, 0, 1, 0, 6),
(14, 'Cetak Kartu', 'fas fa-print', 'cetakkartu', 13, 0, 1, 0, 8),
(17, 'Role', 'fas fa-briefcase', 'role', 4, 8, 1, 0, 3),
(18, 'Setting Website', 'fas fa-cog', 'setting-web', 16, 8, 1, 0, 6),
(19, 'Setting QR Code', 'fas fa-qrcode', 'setting-qrcode', 17, NULL, 1, 0, 7),
(20, 'Layout Setting', 'fas fa-brush', 'setting', 15, 8, 1, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `menu_1`
--

CREATE TABLE `menu_1` (
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `id_module` smallint(5) UNSIGNED DEFAULT NULL,
  `id_parent` smallint(5) UNSIGNED DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `new` tinyint(1) NOT NULL DEFAULT 0,
  `urut` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu_1`
--

INSERT INTO `menu_1` (`id_menu`, `nama_menu`, `class`, `url`, `id_module`, `id_parent`, `aktif`, `new`, `urut`) VALUES
(1, 'User', 'fas fa-user', 'user', 0, 8, 1, 0, 2),
(2, 'Assign Role', 'far fa-circle', '#', 0, 8, 1, 0, 6),
(3, 'User Role', 'far fa-circle', 'user-role', 7, 2, 1, 0, 1),
(4, 'Module', 'far fa-circle', 'module', 2, 8, 1, 0, 3),
(5, 'Module Role', 'far fa-circle', 'module-role', 3, 2, 1, 0, 2),
(6, 'Menu', 'far fa-circle', 'menu', 1, 8, 1, 0, 4),
(7, 'Menu Role', 'far fa-circle', 'menu-role', 8, 2, 1, 0, 3),
(8, 'Website', 'far fa-circle', '#', 1, 0, 1, 0, 2),
(9, 'Data Universitas', 'far fa-circle', 'universitas', 10, 0, 1, 0, 5),
(10, 'Data Nama', 'far fa-circle', 'daftarnama', 9, 0, 1, 0, 4),
(11, 'Tanda Tangan', 'far fa-circle', 'tandatangan', 12, 0, 1, 0, 6),
(12, 'Layout Kartu', 'far fa-circle', 'layoutkartu', 11, 0, 1, 0, 3),
(13, 'Setting Printer', 'far fa-circle', 'settingprinter', 14, 0, 1, 0, 7),
(14, 'Cetak Kartu', 'far fa-circle', 'cetakkartu', 13, 0, 1, 0, 8),
(17, 'Aplikasi', 'fas fa-address-book', '#', 0, 8, 1, 0, 1),
(18, 'Aplikasi 2', 'fas fa-address-card', '#', 0, 17, 1, 0, 1),
(19, 'Setting Qrcode', 'fas fa-qrcode', 'setting-qrcode', 17, NULL, 1, 0, 1),
(20, 'Administrasi 3', 'far fa-circle', '#', 0, 17, 1, 0, 2),
(21, 'Role', 'far fa-circle', 'role', 4, 8, 1, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `menu_copy`
--

CREATE TABLE `menu_copy` (
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `menu_nama` varchar(50) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `id_module` smallint(5) UNSIGNED DEFAULT NULL,
  `id_parent` smallint(5) UNSIGNED DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `new` tinyint(1) NOT NULL DEFAULT 0,
  `urut` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu_copy`
--

INSERT INTO `menu_copy` (`id_menu`, `menu_nama`, `class`, `url`, `id_module`, `id_parent`, `aktif`, `new`, `urut`) VALUES
(1, 'Tanda Tangan', 'far fa-circle', 'tandatangan', 16, 0, 1, 0, 4),
(2, 'Layout Kartu', 'far fa-circle', 'layoutkartu', 15, 0, 1, 0, 1),
(3, 'Data Universitas', 'far fa-circle', 'universitas', 14, 0, 1, 0, 2),
(4, 'Data Nama', 'far fa-circle', 'daftarnama', 13, 0, 1, 0, 3),
(32, 'Cetak Kartu', 'far fa-circle', 'cetakkartu', 17, 0, 1, 0, 6),
(33, 'Setting Printer', 'far fa-circle', 'settingprinter', 18, 0, 1, 0, 5),
(34, 'User', 'far fa-circle', 'user', 8, 0, 1, 0, 7),
(35, 'Module', 'far fa-circle', 'module', 5, 0, 1, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role`
--

CREATE TABLE `menu_role` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses dari menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu_role`
--

INSERT INTO `menu_role` (`id`, `id_menu`, `id_role`) VALUES
(1, 5, 1),
(3, 9, 1),
(6, 2, 1),
(7, 3, 1),
(8, 4, 1),
(9, 6, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(15, 10, 1),
(16, 10, 2),
(17, 14, 1),
(18, 14, 2),
(19, 1, 1),
(20, 1, 2),
(23, 8, 1),
(25, 7, 1),
(26, 7, 2),
(27, 2, 2),
(28, 8, 2),
(29, 17, 1),
(30, 18, 1),
(31, 19, 1),
(32, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role_1`
--

CREATE TABLE `menu_role_1` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses dari menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu_role_1`
--

INSERT INTO `menu_role_1` (`id`, `id_menu`, `id_role`) VALUES
(3, 9, 1),
(8, 4, 1),
(9, 6, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(15, 10, 1),
(16, 10, 2),
(17, 14, 1),
(18, 14, 2),
(19, 1, 1),
(20, 1, 2),
(31, 7, 1),
(108, 3, 1),
(109, 2, 1),
(113, 5, 1),
(141, 21, 1),
(142, 8, 1),
(143, 8, 2),
(146, 0, 0),
(147, 0, 0),
(157, 17, 1),
(158, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role_copy`
--

CREATE TABLE `menu_role_copy` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_menu` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses dari menu aplikasi' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu_role_copy`
--

INSERT INTO `menu_role_copy` (`id`, `id_menu`, `id_role`) VALUES
(3, 2, 1),
(5, 1, 1),
(6, 8, 1),
(7, 3, 1),
(9, 4, 1),
(11, 5, 1),
(13, 6, 1),
(15, 7, 1),
(17, 9, 1),
(19, 10, 1),
(20, 10, 2),
(21, 11, 1),
(23, 12, 1),
(25, 13, 1),
(27, 14, 1),
(28, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id_module` smallint(5) UNSIGNED NOT NULL,
  `nama_module` varchar(50) DEFAULT NULL,
  `judul_module` varchar(50) DEFAULT NULL,
  `id_module_status` tinyint(1) DEFAULT NULL,
  `login` tinyint(1) DEFAULT NULL,
  `deskripsi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel modul aplikasi' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id_module`, `nama_module`, `judul_module`, `id_module_status`, `login`, `deskripsi`) VALUES
(1, 'menu', 'Menu Manager', 1, 1, 'Administrasi Menu'),
(2, 'module', 'Module Manager', 1, 1, 'Pengaturan Module'),
(3, 'module-role', 'Assign Role ke Module', 1, 1, 'Assign Role ke Module'),
(4, 'role', 'Role Manager', 1, 1, 'Pengaturan Role'),
(5, 'user', 'User Manager', 1, 1, 'Pengaturan user'),
(6, 'login', 'Login', 1, 0, 'Login ke akun Anda'),
(7, 'user-role', 'Assign Role ke User', 1, 1, 'Assign role ke user'),
(8, 'menu-role', 'Menu - Role', 1, 1, 'Assign role ke menu'),
(9, 'daftarnama', 'Daftar Mahasiswa', 1, 1, 'Nama Mahasiswa'),
(10, 'universitas', 'Universitas', 1, 1, 'Universitas'),
(11, 'layoutkartu', 'Layout Kartu', 1, 1, 'Layput kartu identitas, mahasiswa maupun dosen'),
(12, 'tandatangan', 'Tanda Tangan', 1, 1, 'Penandatangan kartu'),
(13, 'cetakkartu', 'Cetak Kartu', 1, 1, 'Cetak Kartu'),
(14, 'settingprinter', 'Setting Printer', 1, 1, 'Setting printer'),
(15, 'setting', 'Web Setting', 1, NULL, 'Web Setting'),
(16, 'setting-web', 'Setting Web', 1, NULL, 'Pengaturan website seperti nama web, logo, dll'),
(17, 'setting-qrcode', 'Setting QRCode', 1, NULL, 'Setting QRCode'),
(19, 'theme', 'Theme Web', 3, NULL, 'Theme Web');

-- --------------------------------------------------------

--
-- Table structure for table `module_copy3`
--

CREATE TABLE `module_copy3` (
  `id_module` smallint(5) UNSIGNED NOT NULL,
  `nama_module` varchar(50) DEFAULT NULL,
  `judul_module` varchar(50) DEFAULT NULL,
  `id_module_status` tinyint(1) DEFAULT NULL,
  `login` tinyint(1) DEFAULT NULL,
  `deskripsi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel modul aplikasi' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module_copy3`
--

INSERT INTO `module_copy3` (`id_module`, `nama_module`, `judul_module`, `id_module_status`, `login`, `deskripsi`) VALUES
(1, 'menu', 'Menu Aplikasi', 1, 1, 'Administrasi Menu'),
(2, 'module', 'Module', 1, 1, 'Module'),
(3, 'module-role', 'Assign Role ke Module', 1, 1, 'Assign Role ke Module'),
(4, 'role', 'Role', 1, 1, 'Role'),
(5, 'user', 'User', 1, 1, 'User'),
(6, 'login', 'Login', 1, 0, 'Login ke akun Anda'),
(7, 'user-role', 'Assign Role ke User', 1, 1, 'Assign role ke user'),
(8, 'menu-role', 'Menu - Role', 1, 1, 'Assign role ke menu'),
(9, 'daftarnama', 'Daftar Mahasiswa', 1, 1, 'Nama Mahasiswa'),
(10, 'universitas', 'Universitas', 1, 1, 'Universitas'),
(11, 'layoutkartu', 'Layout Kartu', 1, 1, 'Layput kartu identitas, mahasiswa maupun dosen'),
(12, 'tandatangan', 'Tanda Tangan', 1, 1, 'Penandatangan kartu'),
(13, 'cetakkartu', 'Cetak Kartu', 1, 1, 'Cetak Kartu'),
(14, 'settingprinter', 'Setting Printer', 1, 1, 'Setting printer'),
(15, 'setting', 'Web Setting', 1, NULL, 'Web Setting'),
(16, 'setting-web', 'Setting Web', 1, NULL, 'Pengaturan website seperti nama web, logo, dll'),
(17, 'setting-qrcode', 'Setting QRCode', 1, NULL, 'Setting QRCode');

-- --------------------------------------------------------

--
-- Table structure for table `module_role`
--

CREATE TABLE `module_role` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_module` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL,
  `read_data` varchar(255) NOT NULL DEFAULT '',
  `create_data` varchar(255) NOT NULL DEFAULT '',
  `update_data` varchar(255) NOT NULL DEFAULT '',
  `delete_data` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses module aplikasi, module aplikasi boleh diakses oleh user yang mempunyai role apa saja' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module_role`
--

INSERT INTO `module_role` (`id`, `id_module`, `id_role`, `read_data`, `create_data`, `update_data`, `delete_data`) VALUES
(1, 3, 1, 'all', 'yes', 'all', 'all'),
(2, 8, 1, 'all', 'yes', 'all', 'all'),
(3, 4, 1, 'all', 'yes', 'all', 'all'),
(5, 2, 1, 'all', 'yes', 'all', 'all'),
(6, 1, 1, 'all', 'yes', 'all', 'all'),
(7, 7, 1, 'all', 'yes', 'all', 'all'),
(10, 11, 1, 'all', 'yes', 'all', 'all'),
(11, 12, 1, 'all', 'yes', 'all', 'all'),
(13, 14, 1, 'all', 'yes', 'all', 'all'),
(14, 10, 1, 'all', 'yes', 'all', 'all'),
(16, 9, 1, 'all', 'yes', 'all', 'all'),
(17, 9, 2, 'own', 'yes', 'no', 'no'),
(18, 13, 1, 'all', 'yes', 'all', 'all'),
(19, 13, 2, 'all', 'yes', 'all', 'all'),
(24, 5, 1, 'all', 'yes', 'all', 'all'),
(25, 5, 2, 'own', 'no', 'own', 'no'),
(26, 15, 1, 'all', 'yes', 'all', 'all'),
(27, 15, 2, 'own', 'no', 'own', 'own'),
(28, 16, 1, 'all', 'yes', 'all', 'all'),
(29, 17, 1, 'all', 'yes', 'all', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `module_role_copy`
--

CREATE TABLE `module_role_copy` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_module` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL,
  `read` varchar(255) NOT NULL DEFAULT '',
  `create` varchar(255) NOT NULL DEFAULT '',
  `update` varchar(255) NOT NULL DEFAULT '',
  `delete` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses module aplikasi, module aplikasi boleh diakses oleh user yang mempunyai role apa saja' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module_role_copy`
--

INSERT INTO `module_role_copy` (`id`, `id_module`, `id_role`, `read`, `create`, `update`, `delete`) VALUES
(48, 5, 1, 'all', 'yes', 'all', 'all'),
(49, 6, 1, 'all', 'yes', 'all', 'all'),
(50, 7, 1, 'all', 'yes', 'all', 'all'),
(51, 8, 1, 'all', 'yes', 'all', 'all'),
(52, 14, 1, 'all', 'yes', 'all', 'all'),
(58, 15, 1, 'all', 'yes', 'all', 'all'),
(63, 16, 1, 'all', 'yes', 'all', 'all'),
(70, 18, 1, 'all', 'yes', 'own', 'all'),
(71, 13, 1, 'all', 'yes', 'all', 'all'),
(72, 13, 2, 'own', 'yes', 'own', 'own'),
(73, 17, 1, 'all', 'yes', 'all', 'all'),
(74, 17, 2, 'own', 'yes', 'own', 'own'),
(75, 8, 2, 'own', 'no', 'own', 'no'),
(76, 3, 1, '', '', '', ''),
(77, 3, 2, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `module_role_copy2`
--

CREATE TABLE `module_role_copy2` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_module` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL,
  `read_data` varchar(255) NOT NULL DEFAULT '',
  `create_data` varchar(255) NOT NULL DEFAULT '',
  `update_data` varchar(255) NOT NULL DEFAULT '',
  `delete_data` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel hak akses module aplikasi, module aplikasi boleh diakses oleh user yang mempunyai role apa saja' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module_role_copy2`
--

INSERT INTO `module_role_copy2` (`id`, `id_module`, `id_role`, `read_data`, `create_data`, `update_data`, `delete_data`) VALUES
(1, 5, 1, 'all', 'yes', 'all', 'all'),
(2, 6, 1, 'all', 'yes', 'all', 'all'),
(3, 7, 1, 'all', 'yes', 'all', 'all'),
(4, 8, 1, 'all', 'yes', 'all', 'all'),
(5, 14, 1, 'all', 'yes', 'all', 'all'),
(6, 15, 1, 'all', 'yes', 'all', 'all'),
(7, 16, 1, 'all', 'yes', 'all', 'all'),
(8, 13, 1, 'all', 'yes', 'all', 'all'),
(9, 13, 2, 'own', 'yes', 'own', 'own'),
(10, 17, 1, 'all', 'yes', 'all', 'all'),
(11, 17, 2, 'own', 'yes', 'own', 'own'),
(12, 8, 2, 'own', 'no', 'own', 'no'),
(13, 3, 1, '', '', '', ''),
(15, 18, 1, 'all', 'yes', 'all', 'all'),
(16, 18, 2, 'all', 'no', 'no', 'no'),
(17, 11, 1, 'all', 'yes', 'all', 'all'),
(18, 1, 1, 'all', 'yes', 'all', 'all'),
(19, 2, 1, 'all', 'yes', 'all', 'all'),
(20, 4, 1, 'all', 'yes', 'all', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `module_status`
--

CREATE TABLE `module_status` (
  `id_module_status` tinyint(1) NOT NULL,
  `nama_status` varchar(50) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel status modul, seperti: aktif, non aktif, dalam perbaikan' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `module_status`
--

INSERT INTO `module_status` (`id_module_status`, `nama_status`, `keterangan`) VALUES
(1, 'Aktif', NULL),
(2, 'Dalam Perbaikan', 'Hanya role developer yang dapat mengakses module dengan status ini'),
(3, 'Non Aktif', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` smallint(5) UNSIGNED NOT NULL,
  `nama_role` varchar(50) NOT NULL,
  `judul_role` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `id_module` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel yang berisi daftar role, role ini mengatur bagaimana user mengakses module, role ini nantinya diassign ke user' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`, `judul_role`, `keterangan`, `id_module`) VALUES
(1, 'admin', 'Administrator', 'Administrator', 5),
(2, 'user', 'User', 'Pengguna umum', 9),
(3, 'webdev', 'Web Developer', 'Pengembang aplikasi', 5);

-- --------------------------------------------------------

--
-- Table structure for table `role_detail`
--

CREATE TABLE `role_detail` (
  `id_role_detail` tinyint(3) UNSIGNED NOT NULL,
  `nama_role_detail` varchar(255) DEFAULT NULL,
  `judul_role_detail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_detail`
--

INSERT INTO `role_detail` (`id_role_detail`, `nama_role_detail`, `judul_role_detail`) VALUES
(1, 'all', 'Boleh Akses Semua Data'),
(2, 'no', 'Tidak Boleh Akses Semua Data'),
(3, 'own', 'Hanya Data Miliknya Sendiri');

-- --------------------------------------------------------

--
-- Table structure for table `setting_app_tampilan`
--

CREATE TABLE `setting_app_tampilan` (
  `id` int(11) NOT NULL,
  `param` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `setting_app_tampilan`
--

INSERT INTO `setting_app_tampilan` (`id`, `param`, `value`) VALUES
(191, 'color_scheme', 'red'),
(192, 'sidebar_color', 'light'),
(193, 'logo_background_color', 'dark'),
(194, 'font_family', 'poppins'),
(195, 'font_size', '17');

-- --------------------------------------------------------

--
-- Table structure for table `setting_app_user`
--

CREATE TABLE `setting_app_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `param` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `setting_app_user`
--

INSERT INTO `setting_app_user` (`id`, `id_user`, `param`) VALUES
(6, 2, '{\"color_scheme\":\"grey\",\"sidebar_color\":\"dark\",\"logo_background_color\":\"default\",\"font_family\":\"open-sans\",\"font_size\":\"16\"}');

-- --------------------------------------------------------

--
-- Table structure for table `setting_printer`
--

CREATE TABLE `setting_printer` (
  `id_setting_printer` tinyint(3) UNSIGNED NOT NULL,
  `dpi` smallint(5) UNSIGNED DEFAULT NULL,
  `margin_kiri` decimal(10,2) UNSIGNED DEFAULT NULL,
  `margin_atas` decimal(10,2) UNSIGNED DEFAULT NULL,
  `margin_kartu_kanan` decimal(10,2) UNSIGNED DEFAULT NULL COMMENT 'Margin kanan antar kartu, jika cetak lebih dari satu',
  `margin_kartu_bawah` decimal(10,2) UNSIGNED DEFAULT NULL COMMENT 'Margin bawah antar kartu dalam hal kartu dicetak lebih dari satu',
  `margin_kartu_depan_belakang` decimal(10,2) UNSIGNED DEFAULT NULL COMMENT 'Margin antara kartu depan dan belakang, kartu depan dan belakang dicetak atas bawah',
  `gunakan` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_printer`
--

INSERT INTO `setting_printer` (`id_setting_printer`, `dpi`, `margin_kiri`, `margin_atas`, `margin_kartu_kanan`, `margin_kartu_bawah`, `margin_kartu_depan_belakang`, `gunakan`) VALUES
(4, 100, 2.00, 2.00, 2.00, 2.00, 2.00, 0),
(5, 100, 1.00, 1.00, 1.00, 1.00, 1.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_qrcode`
--

CREATE TABLE `setting_qrcode` (
  `id_setting_qrcode` int(10) UNSIGNED NOT NULL,
  `version` tinyint(4) NOT NULL,
  `ecc` enum('L','M','Q','H') NOT NULL DEFAULT 'L',
  `size_module` decimal(10,1) NOT NULL DEFAULT 0.0,
  `padding` varchar(50) NOT NULL,
  `global_text` mediumtext NOT NULL,
  `posisi_kartu` varchar(255) NOT NULL,
  `posisi_top` smallint(6) NOT NULL,
  `posisi_left` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_qrcode`
--

INSERT INTO `setting_qrcode` (`id_setting_qrcode`, `version`, `ecc`, `size_module`, `padding`, `global_text`, `posisi_kartu`, `posisi_top`, `posisi_left`) VALUES
(1, 4, 'L', 1.0, '4px', 'url: <a href=\"https://jagowebdev.com\">Jagowebdev.com</a>', 'background_belakang', 124, 259);

-- --------------------------------------------------------

--
-- Table structure for table `setting_qrcode_copy`
--

CREATE TABLE `setting_qrcode_copy` (
  `id_setting_qrcode` int(10) UNSIGNED NOT NULL,
  `version` tinyint(4) NOT NULL,
  `ecc` enum('L','M','Q','H') NOT NULL DEFAULT 'L',
  `size_module` tinyint(4) NOT NULL DEFAULT 0,
  `padding` varchar(50) NOT NULL,
  `global_text` mediumtext NOT NULL,
  `posisi_kartu` varchar(255) NOT NULL,
  `posisi_top` smallint(6) NOT NULL,
  `posisi_left` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `setting_web`
--

CREATE TABLE `setting_web` (
  `id_setting` tinyint(3) UNSIGNED NOT NULL,
  `param` varchar(255) DEFAULT NULL,
  `value` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_web`
--

INSERT INTO `setting_web` (`id_setting`, `param`, `value`) VALUES
(102, 'logo_login', 'jagowebdev_login.png'),
(103, 'logo_app', 'jagowebdev_app.png'),
(104, 'footer_login', '&copy;{{YEAR}} <a href=\"https://jagowebdev.com\" target=\"_blank\">Jagowebdev.com</a>'),
(105, 'btn_login', 'btn-danger'),
(106, 'footer_app', '&copy;{{YEAR}} <a href=\"https://jagowebdev.com\" target=\"_blank\">www.Jagowebdev.com</a>'),
(107, 'background_logo', '#f8e6ee'),
(108, 'judul_web', 'Admin Template Jagowebdev'),
(109, 'deskripsi_web', 'Template administrasi lengkap dengan fitur penting dalam pengembangan aplikasi seperti pengatuan web, layout, dll'),
(110, 'favicon', 'favicon.png');

-- --------------------------------------------------------

--
-- Table structure for table `tandatangan`
--

CREATE TABLE `tandatangan` (
  `id_tandatangan` tinyint(4) UNSIGNED NOT NULL,
  `kota_tandatangan` varchar(255) DEFAULT NULL,
  `nama_tandatangan` varchar(255) DEFAULT NULL,
  `nip_tandatangan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `tgl_tandatangan` date DEFAULT NULL,
  `file_tandatangan` varchar(50) DEFAULT NULL,
  `file_cap_tandatangan` varchar(50) DEFAULT NULL,
  `gunakan` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tandatangan`
--

INSERT INTO `tandatangan` (`id_tandatangan`, `kota_tandatangan`, `nama_tandatangan`, `nip_tandatangan`, `jabatan`, `tgl_tandatangan`, `file_tandatangan`, `file_cap_tandatangan`, `gunakan`) VALUES
(12, 'Surakarta', 'Agus Prawoto Hadi, S.S.T, M.T', '19880620 200012 1 001', 'Rektor', '2020-03-24', 'tanda_tangan_kartu.png', 'stempel.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tandatangan_copy`
--

CREATE TABLE `tandatangan_copy` (
  `id_tandatangan` tinyint(4) UNSIGNED NOT NULL,
  `kota_tandatangan` varchar(255) DEFAULT NULL,
  `nama_tandatangan` varchar(255) DEFAULT NULL,
  `nip_tandatangan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `tgl_tandatangan` date DEFAULT NULL,
  `file_tandatangan` varchar(50) DEFAULT NULL,
  `file_cap_tandatangan` varchar(50) DEFAULT NULL,
  `gunakan` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tandatangan_copy`
--

INSERT INTO `tandatangan_copy` (`id_tandatangan`, `kota_tandatangan`, `nama_tandatangan`, `nip_tandatangan`, `jabatan`, `tgl_tandatangan`, `file_tandatangan`, `file_cap_tandatangan`, `gunakan`) VALUES
(1, 'Kefamenanu', 'Krisantus T. Pambudi Raharjo, S.P., M.Sc', '19710204 200312 1 001', 'Plt Rektor', '2020-01-02', 'Tanda Tangan.png', 'cap tanda tangan.png', 1),
(4, 'Serang 2', 'Dr. Sarrilius Seran, SE. MS', '19630620 200012 1 001', 'Rektor', '2020-03-24', 'Tanda Tangan(3).jpeg', 'cap tanda tangan(3).jpg', 0),
(9, 'Serang2', 'Dr. Sarrilius Seran, SE. MS 2', '19630620 200012 1 001', 'Rektor', '2020-03-25', 'Tanda Tangan(7).jpeg', 'cap tanda tangan(7).jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `universitas`
--

CREATE TABLE `universitas` (
  `id_universitas` tinyint(3) UNSIGNED NOT NULL,
  `nama_universitas` varchar(255) NOT NULL DEFAULT '0',
  `alamat` varchar(255) NOT NULL DEFAULT '0',
  `tlp_fax` varchar(255) NOT NULL DEFAULT '0',
  `website` varchar(255) NOT NULL DEFAULT '0',
  `nama_kementerian` varchar(255) NOT NULL DEFAULT '0',
  `logo` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `universitas`
--

INSERT INTO `universitas` (`id_universitas`, `nama_universitas`, `alamat`, `tlp_fax`, `website`, `nama_kementerian`, `logo`) VALUES
(1, 'Jagowebdev College', 'Jl. Jend. Sudirman No. 24 Solo', '(0271) 666667', 'www.jagowebdev.com', 'TECHNOLOGY DEPARTMENT', 'Logo Jagowebdev.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `aktif` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `id_role` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel user untuk login' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `username`, `nama`, `password`, `verified`, `aktif`, `created`, `id_role`, `avatar`) VALUES
(1, 'prawoto.hadi@gmail.com', 'admin', 'Agus Prawoto Hadi', '$2y$10$1r3zvYDDqh1XEawyvKxpke95501y6nYxPrfW87Nf0/dWpHLiFL4b2', 1, 1, '2018-09-20 16:04:35', 1, '0'),
(2, 'user.administrasi@gmail.com', 'user', 'User Administrasi', '$2y$10$XVQrOo0l9RztgqpZbFIb9eUkeEca7wK1PVvSMNC8QeG7xdnYTubQm', 0, 1, '0000-00-00 00:00:00', 2, 'man_old.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_cookie`
--

CREATE TABLE `user_cookie` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `selector` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel cookie untuk fitur remember me' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_cookie`
--

INSERT INTO `user_cookie` (`id`, `id_user`, `selector`, `token`, `expires`) VALUES
(15, 1, 'b41ff7742dcece3c47', '70993b3109b9b221d34b905f3aa55706acc0dc0f7f3991d4a10c822213c60c07', '2020-04-29 01:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_user` smallint(5) UNSIGNED NOT NULL,
  `id_role` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel yang berisi role yang dimili oleh masing masing user' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `id_user`, `id_role`) VALUES
(1, 1, 1),
(11, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `layout_kartu`
--
ALTER TABLE `layout_kartu`
  ADD PRIMARY KEY (`id_layout_kartu`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`) USING BTREE,
  ADD KEY `menu_module` (`id_module`) USING BTREE;

--
-- Indexes for table `menu_1`
--
ALTER TABLE `menu_1`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `menu_module` (`id_module`);

--
-- Indexes for table `menu_copy`
--
ALTER TABLE `menu_copy`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `menu_module` (`id_module`);

--
-- Indexes for table `menu_role`
--
ALTER TABLE `menu_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_menu`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `menu_role_1`
--
ALTER TABLE `menu_role_1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_menu`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `menu_role_copy`
--
ALTER TABLE `menu_role_copy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_menu`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_module`),
  ADD UNIQUE KEY `module_nama` (`nama_module`),
  ADD KEY `module_module_status` (`id_module_status`);

--
-- Indexes for table `module_copy3`
--
ALTER TABLE `module_copy3`
  ADD PRIMARY KEY (`id_module`) USING BTREE,
  ADD UNIQUE KEY `module_nama` (`nama_module`) USING BTREE,
  ADD KEY `module_module_status` (`id_module_status`) USING BTREE;

--
-- Indexes for table `module_role`
--
ALTER TABLE `module_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_module`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `module_role_copy`
--
ALTER TABLE `module_role_copy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_module`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `module_role_copy2`
--
ALTER TABLE `module_role_copy2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_module`),
  ADD KEY `module_role_role` (`id_role`);

--
-- Indexes for table `module_status`
--
ALTER TABLE `module_status`
  ADD PRIMARY KEY (`id_module_status`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `role_nama` (`nama_role`);

--
-- Indexes for table `role_detail`
--
ALTER TABLE `role_detail`
  ADD PRIMARY KEY (`id_role_detail`);

--
-- Indexes for table `setting_app_tampilan`
--
ALTER TABLE `setting_app_tampilan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `setting_app_user`
--
ALTER TABLE `setting_app_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `setting_printer`
--
ALTER TABLE `setting_printer`
  ADD PRIMARY KEY (`id_setting_printer`);

--
-- Indexes for table `setting_qrcode`
--
ALTER TABLE `setting_qrcode`
  ADD PRIMARY KEY (`id_setting_qrcode`) USING BTREE;

--
-- Indexes for table `setting_qrcode_copy`
--
ALTER TABLE `setting_qrcode_copy`
  ADD PRIMARY KEY (`id_setting_qrcode`) USING BTREE;

--
-- Indexes for table `setting_web`
--
ALTER TABLE `setting_web`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tandatangan`
--
ALTER TABLE `tandatangan`
  ADD PRIMARY KEY (`id_tandatangan`);

--
-- Indexes for table `tandatangan_copy`
--
ALTER TABLE `tandatangan_copy`
  ADD PRIMARY KEY (`id_tandatangan`);

--
-- Indexes for table `universitas`
--
ALTER TABLE `universitas`
  ADD PRIMARY KEY (`id_universitas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `user_role` (`id_role`);

--
-- Indexes for table `user_cookie`
--
ALTER TABLE `user_cookie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cookie_auth` (`id_user`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module` (`id_user`),
  ADD KEY `module_role_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `layout_kartu`
--
ALTER TABLE `layout_kartu`
  MODIFY `id_layout_kartu` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menu_1`
--
ALTER TABLE `menu_1`
  MODIFY `id_menu` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `menu_copy`
--
ALTER TABLE `menu_copy`
  MODIFY `id_menu` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu_role`
--
ALTER TABLE `menu_role`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `menu_role_1`
--
ALTER TABLE `menu_role_1`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `menu_role_copy`
--
ALTER TABLE `menu_role_copy`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id_module` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module_copy3`
--
ALTER TABLE `module_copy3`
  MODIFY `id_module` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `module_role`
--
ALTER TABLE `module_role`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `module_role_copy`
--
ALTER TABLE `module_role_copy`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `module_role_copy2`
--
ALTER TABLE `module_role_copy2`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module_status`
--
ALTER TABLE `module_status`
  MODIFY `id_module_status` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role_detail`
--
ALTER TABLE `role_detail`
  MODIFY `id_role_detail` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_app_tampilan`
--
ALTER TABLE `setting_app_tampilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `setting_app_user`
--
ALTER TABLE `setting_app_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting_printer`
--
ALTER TABLE `setting_printer`
  MODIFY `id_setting_printer` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setting_qrcode`
--
ALTER TABLE `setting_qrcode`
  MODIFY `id_setting_qrcode` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_qrcode_copy`
--
ALTER TABLE `setting_qrcode_copy`
  MODIFY `id_setting_qrcode` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setting_web`
--
ALTER TABLE `setting_web`
  MODIFY `id_setting` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `tandatangan`
--
ALTER TABLE `tandatangan`
  MODIFY `id_tandatangan` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tandatangan_copy`
--
ALTER TABLE `tandatangan_copy`
  MODIFY `id_tandatangan` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `universitas`
--
ALTER TABLE `universitas`
  MODIFY `id_universitas` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_cookie`
--
ALTER TABLE `user_cookie`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
