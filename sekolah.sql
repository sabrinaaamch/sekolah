-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int NOT NULL,
  `status_jadwal` int NOT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `jadwal` (`id_jadwal`, `id_peminjaman`, `status_jadwal`) VALUES
(1,	1,	2),
(2,	2,	2),
(3,	3,	2),
(4,	5,	1);

DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_ruangan` int NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_berakhir` time NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(32) NOT NULL,
  `status_peminjaman` int NOT NULL COMMENT '0 = Request\r\n1 = Meminjam\r\n2 = Selesai\r\n3 = Ditolak',
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_ruangan`, `jam_mulai`, `jam_berakhir`, `tanggal`, `keterangan`, `status_peminjaman`) VALUES
(1,	2,	2,	'01:53:00',	'01:59:00',	'2024-06-02',	'Praktek',	2),
(2,	3,	3,	'01:03:00',	'01:59:00',	'2024-06-02',	'Praktek',	2),
(3,	2,	2,	'02:59:28',	'01:59:28',	'2024-06-01',	'Praktek',	2),
(4,	2,	2,	'02:02:00',	'03:02:00',	'2024-06-02',	'Praktek',	2),
(5,	2,	2,	'17:50:00',	'18:50:00',	'2024-11-06',	'Praktek',	1);

DROP TABLE IF EXISTS `ruangan`;
CREATE TABLE `ruangan` (
  `id_ruangan` int NOT NULL AUTO_INCREMENT,
  `kode_ruangan` varchar(10) NOT NULL,
  `nama_ruangan` varchar(25) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status_ruangan` enum('Dipakai','Nganggur') NOT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ruangan` (`id_ruangan`, `kode_ruangan`, `nama_ruangan`, `image`, `status_ruangan`) VALUES
(2,	'R2.LKS',	'Ruangan 2 Lab Komputer',	'6649040c008d0.png',	'Dipakai'),
(3,	'R3.LK',	'Ruangan 3 Lab Komputer',	'5e13825fac4bd.png',	'Nganggur');

DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `id_site` int NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`id_site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `site` (`id_site`, `icon`, `logo`, `title`) VALUES
(1,	'664cbf8825b5e1.jpeg',	'664cbf8825b5e.jpeg',	'SIPLAB');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(32) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `level` enum('Admin','Peminjam','Guru') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id_user`, `nama_lengkap`, `bio`, `username`, `password`, `nip`, `no_telp`, `level`, `image`, `status`) VALUES
(1,	'Admin',	'Ini bio admin',	'admin',	'd033e22ae348aeb5660fc2140aec35850c4da997',	'11753101951',	'82286062083',	'Admin',	'6650c9d75175e.png',	1),
(2,	'user',	'',	'user',	'12dea96fec20593566ab75692c9949596833adc9',	'123',	'',	'Peminjam',	'',	1),
(3,	'user2',	'',	'user2',	'a1881c06eec96db9901c7bbfe41c42a3f08e9cb4',	'23345',	'',	'Peminjam',	'',	1),
(4,	'user3',	'',	'user3',	'0b7f849446d3383546d15a480966084442cd2193',	'35434',	'',	'Peminjam',	'',	1),
(5,	'Bokir',	'',	'bokir',	'b24a2801c104173e1f487f955f5c6b603787ec0a',	'321222222',	'',	'Guru',	'',	1);

-- 2024-11-06 16:16:27
