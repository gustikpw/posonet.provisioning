-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.6-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for posonetprovisioningdev
CREATE DATABASE IF NOT EXISTS `posonetprovisioningdev` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `posonetprovisioningdev`;

-- Dumping structure for table posonetprovisioningdev.detail_setoran
CREATE TABLE IF NOT EXISTS `detail_setoran` (
  `id_detail_setoran` int(11) NOT NULL AUTO_INCREMENT,
  `id_master_setoran` int(11) NOT NULL,
  `kode_invoice` varchar(15) NOT NULL,
  `no_pelanggan` varchar(4) DEFAULT NULL,
  `bulan_penagihan` date NOT NULL,
  `expired` date NOT NULL,
  `tgl_input` date DEFAULT NULL,
  `status` enum('Lunas','Diputihkan') NOT NULL DEFAULT 'Lunas',
  `keterangan` tinytext DEFAULT NULL,
  `remark` int(11) DEFAULT NULL,
  `id_kolektor` int(4) DEFAULT NULL,
  `kode_wilayah` varchar(5) DEFAULT NULL,
  `metode_pembayaran` enum('not','transfer','kolektor','antar') DEFAULT 'not',
  `penerima` int(2) DEFAULT NULL COMMENT 'id_karyawan // default kolektor',
  `tarif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail_setoran`),
  UNIQUE KEY `kode_invoice` (`kode_invoice`),
  KEY `FK_detail_setoran_kolektor` (`id_kolektor`),
  KEY `FK_detail_setoran_master_setoran` (`id_master_setoran`),
  CONSTRAINT `FK_detail_setoran_kolektor` FOREIGN KEY (`id_kolektor`) REFERENCES `kolektor` (`id_kolektor`),
  CONSTRAINT `FK_detail_setoran_master_setoran` FOREIGN KEY (`id_master_setoran`) REFERENCES `master_setoran` (`id_master_setoran`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.karyawan
CREATE TABLE IF NOT EXISTS `karyawan` (
  `id_karyawan` int(2) NOT NULL AUTO_INCREMENT,
  `kode_karyawan` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `tgl_masuk` date DEFAULT NULL,
  `tgl_berakhir` date DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `alamat` tinytext DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Data karyawan';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.kolektor
CREATE TABLE IF NOT EXISTS `kolektor` (
  `id_kolektor` int(4) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(2) DEFAULT NULL,
  `wilayah` text DEFAULT NULL COMMENT 'multiselect',
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_kolektor`),
  KEY `FK_kolektor_karyawan` (`id_karyawan`),
  CONSTRAINT `FK_kolektor_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Setiap kolektor mempunyai wilayah penagihan masing masing';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.log_temp_invoice
CREATE TABLE IF NOT EXISTS `log_temp_invoice` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(50) NOT NULL,
  `trigger_time` datetime NOT NULL DEFAULT current_timestamp(),
  `id_trx` int(11) NOT NULL,
  `kode_invoice` varchar(15) DEFAULT NULL,
  `no_pelanggan` varchar(10) DEFAULT NULL,
  `bulan_penagihan` date DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `tgl_penyetoran` date DEFAULT NULL,
  `status` enum('Lunas','Belum Bayar','Diputihkan') DEFAULT 'Belum Bayar',
  `keterangan` tinytext DEFAULT NULL,
  `kode_wilayah` varchar(5) DEFAULT NULL,
  `id_kolektor` int(4) DEFAULT NULL,
  `metode_pembayaran` enum('not','transfer','kolektor','antar') DEFAULT 'not',
  `penerima` int(2) DEFAULT NULL COMMENT 'id_karyawan',
  `tarif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=2557 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='mencatat event log di tabel temp_invoice';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.master_setoran
CREATE TABLE IF NOT EXISTS `master_setoran` (
  `id_master_setoran` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_setoran` date NOT NULL,
  `id_kolektor` int(3) NOT NULL,
  `total_setoran` int(11) DEFAULT 0,
  `total_setoran_remark` int(11) DEFAULT 0,
  `keterangan` tinytext DEFAULT NULL,
  `lembar` int(4) DEFAULT NULL,
  `komisi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_master_setoran`),
  KEY `FK_master_setoran_kolektor` (`id_kolektor`),
  CONSTRAINT `FK_master_setoran_kolektor` FOREIGN KEY (`id_kolektor`) REFERENCES `kolektor` (`id_kolektor`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.outbox
CREATE TABLE IF NOT EXISTS `outbox` (
  `id_outbox` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(18) DEFAULT NULL,
  `messages` text DEFAULT NULL,
  `messages_type` varchar(18) DEFAULT NULL COMMENT 'text or image',
  `status` varchar(18) DEFAULT NULL COMMENT 'pending',
  `mode` varchar(18) DEFAULT NULL COMMENT 'single or batch',
  PRIMARY KEY (`id_outbox`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.paket
CREATE TABLE IF NOT EXISTS `paket` (
  `id_paket` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(50) NOT NULL,
  `mikrotik_profile` varchar(50) NOT NULL,
  `speed_max` varchar(50) NOT NULL,
  `tarif` int(11) NOT NULL,
  `keterangan` tinytext DEFAULT NULL,
  PRIMARY KEY (`id_paket`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` int(4) NOT NULL AUTO_INCREMENT,
  `no_pelanggan` varchar(4) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `id_wilayah` int(3) NOT NULL,
  `id_paket` int(3) NOT NULL,
  `tgl_instalasi` date DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `lokasi_map` tinytext NOT NULL,
  `telp` varchar(16) DEFAULT NULL,
  `status` enum('AKTIF','NONAKTIF') NOT NULL DEFAULT 'AKTIF',
  `keterangan` tinytext DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ktp_filename` tinytext DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `serial_number` varchar(50) NOT NULL COMMENT 'sn ONT',
  `sn_stb` varchar(50) NOT NULL COMMENT 'sn stb IPTV',
  `gpon_olt` varchar(20) NOT NULL COMMENT 'olt 1/1/3',
  `gpon_onu` varchar(20) NOT NULL COMMENT 'olt 1/1/3:6',
  `onu_type` varchar(20) NOT NULL COMMENT 'olt',
  `name` varchar(50) NOT NULL COMMENT 'olt',
  `description` varchar(50) NOT NULL COMMENT 'olt',
  `ppp_profile` varchar(50) NOT NULL COMMENT 'ppp/profile',
  `access_mode` enum('pppoe','bridge') NOT NULL DEFAULT 'pppoe' COMMENT 'pppoe,bridge',
  `username` varchar(50) NOT NULL COMMENT 'username pppoe',
  `password` varchar(50) NOT NULL COMMENT 'password pppoe',
  `ip_address` varchar(20) NOT NULL COMMENT 'ip_address',
  `active_connection` enum('connected','disconnected') NOT NULL DEFAULT 'disconnected',
  `onu_db` varchar(50) NOT NULL DEFAULT '0' COMMENT 'rx dB',
  `distance` varchar(50) NOT NULL DEFAULT '0' COMMENT 'meter',
  `ont_phase_state` enum('working','DyingGasp','LOS','logging','syncMib','offline','Unconfigured') DEFAULT 'Unconfigured',
  `remote_web_state` enum('enabled','disabled') DEFAULT 'disabled',
  `vlan_profile` varchar(50) DEFAULT NULL,
  `odp_number` varchar(50) DEFAULT NULL,
  `odp_location` tinytext DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`),
  UNIQUE KEY `no_pelanggan` (`no_pelanggan`),
  KEY `FK_pelanggan_wilayah` (`id_wilayah`),
  KEY `FK_pelanggan_paket` (`id_paket`),
  CONSTRAINT `FK_pelanggan_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id_paket`),
  CONSTRAINT `FK_pelanggan_wilayah` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`)
) ENGINE=InnoDB AUTO_INCREMENT=813 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.pengeluaran
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_pengeluaran` date NOT NULL,
  `nama_pengeluaran` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` tinytext NOT NULL,
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.profil_perusahaan
CREATE TABLE IF NOT EXISTS `profil_perusahaan` (
  `id_profil` int(1) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `slogan` tinytext NOT NULL,
  `alamat` tinytext NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `telp_cs` varchar(50) NOT NULL,
  `kodepos` varchar(50) NOT NULL,
  `rekening_perusahaan` varchar(50) NOT NULL,
  `nama_pimpinan` varchar(50) NOT NULL,
  `jabatan_pimpinan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_profil`),
  UNIQUE KEY `nama_perusahaan` (`nama_perusahaan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.serial_number
CREATE TABLE IF NOT EXISTS `serial_number` (
  `id_serial_number` int(4) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  PRIMARY KEY (`id_serial_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `option_id` int(3) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(50) DEFAULT NULL,
  `option_value` text DEFAULT NULL,
  `autoload` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='semua pengaturan aplikasi letaknya disini';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.statistik_bulanan
CREATE TABLE IF NOT EXISTS `statistik_bulanan` (
  `id_statistik` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` date DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `capaian` int(11) DEFAULT NULL,
  `capaian_remark` int(11) DEFAULT NULL,
  `rate_success` float DEFAULT NULL,
  `rate_margin` float DEFAULT NULL,
  PRIMARY KEY (`id_statistik`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Target dan pencapaian tiap bulan\r\n\r\nTampil di Dashboard';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.temp_invoice
CREATE TABLE IF NOT EXISTS `temp_invoice` (
  `id_trx` int(11) NOT NULL AUTO_INCREMENT,
  `kode_invoice` varchar(15) DEFAULT NULL,
  `no_pelanggan` varchar(10) DEFAULT NULL,
  `bulan_penagihan` date DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `tgl_penyetoran` date DEFAULT NULL,
  `status` enum('Lunas','Belum Bayar','Diputihkan') DEFAULT 'Belum Bayar',
  `keterangan` tinytext DEFAULT NULL,
  `kode_wilayah` varchar(5) DEFAULT NULL,
  `id_kolektor` int(4) DEFAULT NULL,
  `metode_pembayaran` enum('not','transfer','kolektor','antar') DEFAULT 'not',
  `penerima` int(2) DEFAULT NULL COMMENT 'id_karyawan',
  `tarif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trx`),
  UNIQUE KEY `kode_invoice` (`kode_invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=1836 DEFAULT CHARSET=latin1 COMMENT='- Kwitansi -\r\nData sementara untuk membuat kwitansi pdf';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id_tickets` int(11) NOT NULL AUTO_INCREMENT,
  `gpon_onu` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `gangguan` varchar(50) DEFAULT NULL,
  `maps` text DEFAULT NULL,
  `cp` varchar(50) DEFAULT NULL,
  `penanganan` text DEFAULT NULL,
  `status` enum('SELESAI','PROGRESS') DEFAULT 'PROGRESS',
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_tickets`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_karyawan` int(2) NOT NULL,
  `level` enum('administrator','kolektor','teknisi') NOT NULL,
  `aktif` enum('nonaktif','aktif') NOT NULL,
  `rules` enum('api','webapp') DEFAULT NULL,
  `id_api` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.u_olt_onu_type
CREATE TABLE IF NOT EXISTS `u_olt_onu_type` (
  `id_onu_type` int(11) NOT NULL AUTO_INCREMENT,
  `onu_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_onu_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Diisi otomatis oleh api flask';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.u_reconfig_ont
CREATE TABLE IF NOT EXISTS `u_reconfig_ont` (
  `id_reconfig` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(50) DEFAULT NULL,
  `gpon_olt_lama` varchar(50) DEFAULT NULL,
  `gpon_olt_baru` varchar(50) DEFAULT NULL,
  `onu_type` varchar(50) DEFAULT NULL,
  `mode` enum('reconfig','pindahpon') DEFAULT NULL,
  PRIMARY KEY (`id_reconfig`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1 COMMENT='untuk kondisi manual delete dan pindah port';

-- Data exporting was unselected.

-- Dumping structure for table posonetprovisioningdev.u_router_ppp_profile
CREATE TABLE IF NOT EXISTS `u_router_ppp_profile` (
  `id_profile` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `local_address` varchar(50) DEFAULT NULL,
  `remote_address` varchar(50) DEFAULT NULL,
  `rate_limit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel ini akan diisi otomatis oleh api flask. Truncate otomatis ketika update data';

-- Data exporting was unselected.

-- Dumping structure for view posonetprovisioningdev.v_detail_setoran
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_detail_setoran` (
	`id_detail_setoran` INT(11) NOT NULL,
	`id_master_setoran` INT(11) NOT NULL,
	`kode_invoice` VARCHAR(15) NOT NULL COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(4) NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`bulan_penagihan` DATE NOT NULL,
	`expired` DATE NOT NULL,
	`tgl_input` DATE NULL,
	`tarif` INT(11) NOT NULL,
	`remark` INT(11) NULL,
	`status` ENUM('Lunas','Diputihkan') NOT NULL COLLATE 'latin1_swedish_ci',
	`metode_pembayaran` ENUM('not','transfer','kolektor','antar') NULL COLLATE 'latin1_swedish_ci',
	`keterangan` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`tgl_setoran` DATE NOT NULL,
	`nama_kolektor` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`nama_penerima` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`id_kolektor` INT(3) NOT NULL,
	`penerima` INT(2) NULL COMMENT 'id_karyawan // default kolektor'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_expired
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_expired` (
	`id_pelanggan` INT(4) NOT NULL,
	`gpon_onu` VARCHAR(20) NOT NULL COMMENT 'olt 1/1/3:6' COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(4) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`ont_phase_state` ENUM('working','DyingGasp','LOS','logging','syncMib','offline','Unconfigured') NULL COLLATE 'latin1_swedish_ci',
	`expired` DATE NULL,
	`username` VARCHAR(50) NOT NULL COMMENT 'username pppoe' COLLATE 'latin1_swedish_ci',
	`mikrotik_profile` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`active_connection` ENUM('connected','disconnected') NOT NULL COLLATE 'latin1_swedish_ci',
	`telp` VARCHAR(16) NULL COLLATE 'latin1_swedish_ci',
	`status_berlangganan` VARCHAR(7) NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_kolektor
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_kolektor` (
	`id_kolektor` INT(4) NOT NULL,
	`kode_karyawan` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`nama_lengkap` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`wilayah` TEXT NULL COMMENT 'multiselect' COLLATE 'latin1_swedish_ci',
	`keterangan` TEXT NULL COLLATE 'latin1_swedish_ci',
	`telp` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`id_karyawan` INT(2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_master_setoran
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_master_setoran` (
	`id_master_setoran` INT(11) NOT NULL,
	`tgl_setoran` DATE NOT NULL,
	`kolektor` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`total_setoran` INT(11) NULL,
	`total_setoran_remark` INT(11) NULL,
	`keterangan` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`id_kolektor` INT(3) NOT NULL,
	`id_karyawan` INT(2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_onu_los
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_onu_los` (
	`id_pelanggan` INT(4) NOT NULL,
	`gpon_onu` VARCHAR(20) NOT NULL COMMENT 'olt 1/1/3:6' COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(4) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`ont_phase_state` ENUM('working','DyingGasp','LOS','logging','syncMib','offline','Unconfigured') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_onu_offline
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_onu_offline` (
	`id_pelanggan` INT(4) NOT NULL,
	`gpon_onu` VARCHAR(20) NOT NULL COMMENT 'olt 1/1/3:6' COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(4) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`ont_phase_state` ENUM('working','DyingGasp','LOS','logging','syncMib','offline','Unconfigured') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_pelanggan
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_pelanggan` (
	`id_pelanggan` INT(4) NOT NULL,
	`no_pelanggan` VARCHAR(4) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`alamat` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`wilayah` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_paket` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`tarif` INT(11) NOT NULL,
	`tgl_instalasi` DATE NULL,
	`expired` DATE NULL,
	`serial_number` VARCHAR(50) NOT NULL COMMENT 'sn ONT' COLLATE 'latin1_swedish_ci',
	`lokasi_map` TINYTEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`telp` VARCHAR(16) NULL COLLATE 'latin1_swedish_ci',
	`status` ENUM('AKTIF','NONAKTIF') NOT NULL COLLATE 'latin1_swedish_ci',
	`keterangan` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`id_wilayah` INT(3) NOT NULL,
	`id_paket` INT(3) NOT NULL,
	`kode_wilayah` INT(1) NOT NULL,
	`email` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`ktp_filename` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`gpon_olt` VARCHAR(20) NOT NULL COMMENT 'olt 1/1/3' COLLATE 'latin1_swedish_ci',
	`gpon_onu` VARCHAR(20) NOT NULL COMMENT 'olt 1/1/3:6' COLLATE 'latin1_swedish_ci',
	`remote_web_state` ENUM('enabled','disabled') NULL COLLATE 'latin1_swedish_ci',
	`onu_db` VARCHAR(50) NOT NULL COMMENT 'rx dB' COLLATE 'latin1_swedish_ci',
	`distance` VARCHAR(50) NOT NULL COMMENT 'meter' COLLATE 'latin1_swedish_ci',
	`ont_phase_state` ENUM('working','DyingGasp','LOS','logging','syncMib','offline','Unconfigured') NULL COLLATE 'latin1_swedish_ci',
	`mikrotik_profile` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`name` VARCHAR(50) NOT NULL COMMENT 'olt' COLLATE 'latin1_swedish_ci',
	`username` VARCHAR(50) NOT NULL COMMENT 'username pppoe' COLLATE 'latin1_swedish_ci',
	`password` VARCHAR(50) NOT NULL COMMENT 'password pppoe' COLLATE 'latin1_swedish_ci',
	`onu_type` VARCHAR(20) NOT NULL COMMENT 'olt' COLLATE 'latin1_swedish_ci',
	`description` VARCHAR(50) NOT NULL COMMENT 'olt' COLLATE 'latin1_swedish_ci',
	`active_connection` ENUM('connected','disconnected') NOT NULL COLLATE 'latin1_swedish_ci',
	`status_berlangganan` VARCHAR(7) NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_setoran
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_setoran` (
	`id_detail_setoran` INT(11) NOT NULL,
	`kode_invoice` VARCHAR(15) NOT NULL COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(4) NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`bulan_penagihan` DATE NOT NULL,
	`tgl_input` DATE NULL,
	`status` ENUM('Lunas','Diputihkan') NOT NULL COLLATE 'latin1_swedish_ci',
	`keterangan` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`remark` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_setoran_bulan_ini
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_setoran_bulan_ini` (
	`nama_kolektor` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`subtotal` DECIMAL(32,0) NULL,
	`subtotal_remark` DECIMAL(32,0) NULL,
	`bulan` VARCHAR(7) NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_temp_invoice
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_temp_invoice` (
	`id_trx` INT(11) NOT NULL,
	`kode_invoice` VARCHAR(15) NULL COLLATE 'latin1_swedish_ci',
	`no_pelanggan` VARCHAR(10) NULL COLLATE 'latin1_swedish_ci',
	`nama_pelanggan` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`bulan_penagihan` DATE NULL,
	`expired` DATE NULL,
	`tgl_penyetoran` DATE NULL,
	`tarif` INT(11) NULL,
	`status` ENUM('Lunas','Belum Bayar','Diputihkan') NULL COLLATE 'latin1_swedish_ci',
	`keterangan` TINYTEXT NULL COLLATE 'latin1_swedish_ci',
	`kode_wilayah` VARCHAR(5) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view posonetprovisioningdev.v_users
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_users` (
	`id_users` INT(4) NOT NULL,
	`username` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`password` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_lengkap` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`level` ENUM('administrator','kolektor','teknisi') NOT NULL COLLATE 'latin1_swedish_ci',
	`aktif` ENUM('nonaktif','aktif') NOT NULL COLLATE 'latin1_swedish_ci',
	`id_karyawan` INT(2) NOT NULL,
	`rules` ENUM('api','webapp') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for table posonetprovisioningdev.wilayah
CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` int(3) NOT NULL AUTO_INCREMENT,
  `kode_wilayah` int(1) NOT NULL,
  `wilayah` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_wilayah`),
  UNIQUE KEY `kode_wilayah` (`kode_wilayah`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Wilayah Domisili Pelanggan';

-- Data exporting was unselected.

-- Dumping structure for trigger posonetprovisioningdev.temp_invoice_before_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `temp_invoice_before_delete` BEFORE DELETE ON `temp_invoice` FOR EACH ROW BEGIN
INSERT INTO log_temp_invoice (event,id_trx,kode_invoice,no_pelanggan,bulan_penagihan,expired,tgl_penyetoran,status,keterangan,kode_wilayah,id_kolektor,metode_pembayaran,penerima,tarif) 
VALUES ('DELETE',OLD.id_trx,OLD.kode_invoice,OLD.no_pelanggan,OLD.bulan_penagihan,OLD.expired,OLD.tgl_penyetoran,OLD.status,OLD.keterangan,OLD.kode_wilayah,OLD.id_kolektor,OLD.metode_pembayaran,OLD.penerima,OLD.tarif);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for view posonetprovisioningdev.v_detail_setoran
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_detail_setoran`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_detail_setoran` AS select `d`.`id_detail_setoran` AS `id_detail_setoran`,`d`.`id_master_setoran` AS `id_master_setoran`,`d`.`kode_invoice` AS `kode_invoice`,`d`.`no_pelanggan` AS `no_pelanggan`,`p`.`nama_pelanggan` AS `nama_pelanggan`,`d`.`bulan_penagihan` AS `bulan_penagihan`,`d`.`expired` AS `expired`,`d`.`tgl_input` AS `tgl_input`,`p`.`tarif` AS `tarif`,`d`.`remark` AS `remark`,`d`.`status` AS `status`,`d`.`metode_pembayaran` AS `metode_pembayaran`,`d`.`keterangan` AS `keterangan`,`m`.`tgl_setoran` AS `tgl_setoran`,`k`.`nama_lengkap` AS `nama_kolektor`,`y`.`nama_lengkap` AS `nama_penerima`,`m`.`id_kolektor` AS `id_kolektor`,`d`.`penerima` AS `penerima` from ((((`detail_setoran` `d` join `v_master_setoran` `m`) join `v_pelanggan` `p`) join `v_kolektor` `k`) join `karyawan` `y`) where `d`.`id_master_setoran` = `m`.`id_master_setoran` and `d`.`no_pelanggan` = `p`.`no_pelanggan` and `d`.`id_kolektor` = `k`.`id_kolektor` and `d`.`penerima` = `y`.`id_karyawan` ;

-- Dumping structure for view posonetprovisioningdev.v_expired
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_expired`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_expired` AS SELECT  id_pelanggan,gpon_onu,no_pelanggan,nama_pelanggan, ont_phase_state, expired, username, mikrotik_profile, active_connection, telp,IF(expired < CURDATE(),'Expired','Active') AS status_berlangganan
FROM v_pelanggan
WHERE expired < CURDATE()
AND gpon_onu != ''
#AND ont_phase_state = 'working'
ORDER BY no_pelanggan ASC ;

-- Dumping structure for view posonetprovisioningdev.v_kolektor
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_kolektor`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_kolektor` AS select `k`.`id_kolektor` AS `id_kolektor`,`kr`.`kode_karyawan` AS `kode_karyawan`,`kr`.`nama_lengkap` AS `nama_lengkap`,`k`.`wilayah` AS `wilayah`,`k`.`keterangan` AS `keterangan`,`kr`.`telp` AS `telp`,`k`.`id_karyawan` AS `id_karyawan` from (`kolektor` `k` join `karyawan` `kr`) where `k`.`id_karyawan` = `kr`.`id_karyawan` ;

-- Dumping structure for view posonetprovisioningdev.v_master_setoran
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_master_setoran`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_master_setoran` AS select `m`.`id_master_setoran` AS `id_master_setoran`,`m`.`tgl_setoran` AS `tgl_setoran`,`k`.`nama_lengkap` AS `kolektor`,`m`.`total_setoran` AS `total_setoran`,`m`.`total_setoran_remark` AS `total_setoran_remark`,`m`.`keterangan` AS `keterangan`,`m`.`id_kolektor` AS `id_kolektor`,`k`.`id_karyawan` AS `id_karyawan` from (`master_setoran` `m` join `v_kolektor` `k`) where `m`.`id_kolektor` = `k`.`id_kolektor` ;

-- Dumping structure for view posonetprovisioningdev.v_onu_los
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_onu_los`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_onu_los` AS SELECT v.id_pelanggan,v.gpon_onu,v.no_pelanggan,v.nama_pelanggan, v.ont_phase_state
FROM v_pelanggan v 
WHERE v.ont_phase_state = 'LOS'
ORDER BY v.gpon_onu ASC ;

-- Dumping structure for view posonetprovisioningdev.v_onu_offline
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_onu_offline`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_onu_offline` AS SELECT v.id_pelanggan,v.gpon_onu,v.no_pelanggan,v.nama_pelanggan, v.ont_phase_state
FROM v_pelanggan v 
WHERE v.ont_phase_state = 'offline'
OR v.ont_phase_state = 'DyingGasp'
OR v.ont_phase_state = 'syncMib'
OR v.ont_phase_state = 'logging'
ORDER BY v.gpon_onu ASC ;

-- Dumping structure for view posonetprovisioningdev.v_pelanggan
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_pelanggan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_pelanggan` AS SELECT `p`.`id_pelanggan` AS `id_pelanggan`,`p`.`no_pelanggan` AS `no_pelanggan`,`p`.`nama_pelanggan` AS `nama_pelanggan`,
`p`.`alamat` AS `alamat`,`w`.`wilayah` AS `wilayah`,`t`.`nama_paket` AS `nama_paket`,`t`.`tarif` AS `tarif`,
`p`.`tgl_instalasi` AS `tgl_instalasi`,`p`.`expired` AS `expired`,`p`.`serial_number` AS `serial_number`,
`p`.`lokasi_map` AS `lokasi_map`,`p`.`telp` AS `telp`,`p`.`status` AS `status`,`p`.`keterangan` AS `keterangan`,
`p`.`id_wilayah` AS `id_wilayah`,`p`.`id_paket` AS `id_paket`,`w`.`kode_wilayah` AS `kode_wilayah`,
`p`.`email` AS `email`, ktp_filename, p.gpon_olt, p.gpon_onu,p.remote_web_state, p.onu_db, p.distance, 
p.ont_phase_state, t.mikrotik_profile,p.name,p.username,p.`password`,p.onu_type,p.description,p.active_connection,IF(p.expired < CURDATE(),'Expired','Active') AS status_berlangganan
FROM ((`pelanggan` `p` join `paket` `t`) join `wilayah` `w`) 
WHERE `p`.`id_wilayah` = `w`.`id_wilayah` 
AND `p`.`id_paket` = `t`.`id_paket` 
ORDER BY `p`.`id_pelanggan` DESC ;

-- Dumping structure for view posonetprovisioningdev.v_setoran
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_setoran`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_setoran` AS select `s`.`id_detail_setoran` AS `id_detail_setoran`,`s`.`kode_invoice` AS `kode_invoice`,`s`.`no_pelanggan` AS `no_pelanggan`,`p`.`nama_pelanggan` AS `nama_pelanggan`,`s`.`bulan_penagihan` AS `bulan_penagihan`,`s`.`tgl_input` AS `tgl_input`,`s`.`status` AS `status`,`s`.`keterangan` AS `keterangan`,`s`.`remark` AS `remark` from ((`detail_setoran` `s` join `karyawan` `k`) join `pelanggan` `p`) where `s`.`penerima` = `k`.`id_karyawan` and `s`.`no_pelanggan` = `p`.`no_pelanggan` ;

-- Dumping structure for view posonetprovisioningdev.v_setoran_bulan_ini
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_setoran_bulan_ini`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_setoran_bulan_ini` AS select `t`.`nama_kolektor` AS `nama_kolektor`,sum(`t`.`tarif`) AS `subtotal`,sum(`t`.`remark`) AS `subtotal_remark`,substr(`t`.`tgl_input`,1,7) AS `bulan` from `v_detail_setoran` `t` where substr(`t`.`tgl_input`,1,7) like substr(cast(current_timestamp() as date),1,7) and `t`.`status` = 'Lunas' group by `t`.`id_kolektor` ;

-- Dumping structure for view posonetprovisioningdev.v_temp_invoice
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_temp_invoice`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_temp_invoice` AS select `t`.`id_trx` AS `id_trx`,`t`.`kode_invoice` AS `kode_invoice`,`t`.`no_pelanggan` AS `no_pelanggan`,`p`.`nama_pelanggan` AS `nama_pelanggan`,`t`.`bulan_penagihan` AS `bulan_penagihan`,`t`.`expired` AS `expired`,`t`.`tgl_penyetoran` AS `tgl_penyetoran`,`t`.`tarif` AS `tarif`,`t`.`status` AS `status`,`t`.`keterangan` AS `keterangan`,`t`.`kode_wilayah` AS `kode_wilayah` from (`temp_invoice` `t` join `v_pelanggan` `p`) where `t`.`no_pelanggan` = `p`.`no_pelanggan` ;

-- Dumping structure for view posonetprovisioningdev.v_users
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_users`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_users` AS select `u`.`id_users` AS `id_users`,`u`.`username` AS `username`,`u`.`password` AS `password`,`k`.`nama_lengkap` AS `nama_lengkap`,`u`.`level` AS `level`,`u`.`aktif` AS `aktif`,`u`.`id_karyawan` AS `id_karyawan`,`u`.`rules` AS `rules` from (`users` `u` join `karyawan` `k`) where `u`.`id_karyawan` = `k`.`id_karyawan` ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
