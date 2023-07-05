/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.22-MariaDB : Database - dbnectarine
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbnectarine` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbnectarine`;

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `idbarang` bigint(255) NOT NULL AUTO_INCREMENT,
  `idsupplier` bigint(255) NOT NULL,
  `namabarang` varchar(255) NOT NULL,
  `hargabarang` bigint(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  PRIMARY KEY (`idbarang`),
  UNIQUE KEY `namabarang` (`namabarang`),
  KEY `idsupplier` (`idsupplier`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`idsupplier`)
) ENGINE=InnoDB AUTO_INCREMENT=1639143647 DEFAULT CHARSET=utf8mb4;

/*Data for the table `barang` */

insert  into `barang`(`idbarang`,`idsupplier`,`namabarang`,`hargabarang`,`gambar`,`deskripsi`) values 
(1639138042,1639138008,'Sabun',1000,'../img/1639138042.jpg','Ini Sabun ...'),
(1639138073,1639138008,'Shampoo',2000,'../img/1639138073.jpg','Ini sampoo ...'),
(1639142352,1639138008,'Sikat',10000,'../img/1639142352.jpg','Ini Sikat ...'),
(1639143646,1639138008,'Cidok',5000,'../img/1639143646.jpg','ini cidok');

/*Table structure for table `barangmasuk` */

DROP TABLE IF EXISTS `barangmasuk`;

CREATE TABLE `barangmasuk` (
  `idmasuk` bigint(255) NOT NULL,
  `tanggalmasuk` date NOT NULL,
  PRIMARY KEY (`idmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `barangmasuk` */

insert  into `barangmasuk`(`idmasuk`,`tanggalmasuk`) values 
(1639138101,'2021-12-10'),
(1639142435,'2021-12-10'),
(1639142746,'2021-12-10'),
(1639143761,'2021-12-10'),
(1639145200,'2021-12-10');

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `idpelanggan` bigint(255) NOT NULL AUTO_INCREMENT,
  `namapelanggan` varchar(255) NOT NULL,
  `alamatpelanggan` varchar(255) NOT NULL,
  `nomorpelanggan` varchar(255) NOT NULL,
  PRIMARY KEY (`idpelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=1639143377 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`idpelanggan`,`namapelanggan`,`alamatpelanggan`,`nomorpelanggan`) values 
(1638940443,'Enrico','Jl. Pandanaran No.114, Pekunden, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50241','8123'),
(1639143376,'Aurelius','Jl. Pandanaran No.114, Pekunden, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50241','8123');

/*Table structure for table `rincibarangmasuk` */

DROP TABLE IF EXISTS `rincibarangmasuk`;

CREATE TABLE `rincibarangmasuk` (
  `idmasuk` bigint(255) NOT NULL,
  `idbarang` bigint(255) NOT NULL,
  `hargamasuk` bigint(255) NOT NULL,
  `jumlahbarang` bigint(255) NOT NULL,
  KEY `rincibarangmasuk_ibfk_1` (`idmasuk`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `rincibarangmasuk_ibfk_1` FOREIGN KEY (`idmasuk`) REFERENCES `barangmasuk` (`idmasuk`) ON DELETE CASCADE,
  CONSTRAINT `rincibarangmasuk_ibfk_2` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `rincibarangmasuk` */

insert  into `rincibarangmasuk`(`idmasuk`,`idbarang`,`hargamasuk`,`jumlahbarang`) values 
(1639138101,1639138042,500,5),
(1639138101,1639138073,1000,5),
(1639142746,1639142352,5000,10),
(1639143761,1639143646,1000,5),
(1639143761,1639138042,500,2),
(1639145200,1639138042,1000,5);

/*Table structure for table `rincitransaksi` */

DROP TABLE IF EXISTS `rincitransaksi`;

CREATE TABLE `rincitransaksi` (
  `idtransaksi` bigint(255) NOT NULL,
  `idbarang` bigint(255) NOT NULL,
  `jumlahbarang` bigint(255) NOT NULL,
  `hargabarang` bigint(255) NOT NULL,
  KEY `idbarang` (`idbarang`),
  KEY `rincitransaksi_ibfk_1` (`idtransaksi`),
  CONSTRAINT `rincitransaksi_ibfk_1` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`idtransaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rincitransaksi_ibfk_2` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `rincitransaksi` */

insert  into `rincitransaksi`(`idtransaksi`,`idbarang`,`jumlahbarang`,`hargabarang`) values 
(1639138132,1639138073,2,2000),
(1639138132,1639138042,1,1000),
(1639140190,1639138042,1,1000),
(1639140190,1639138073,1,2000),
(1639141680,1639138042,1,1000),
(1639141968,1639138042,2,1000),
(1639141968,1639138073,2,2000),
(1639142783,1639142352,2,10000);

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `idsupplier` bigint(255) NOT NULL AUTO_INCREMENT,
  `namasupplier` varchar(255) NOT NULL,
  `notelp` bigint(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  PRIMARY KEY (`idsupplier`),
  UNIQUE KEY `namasupplier` (`namasupplier`)
) ENGINE=InnoDB AUTO_INCREMENT=1639138009 DEFAULT CHARSET=utf8mb4;

/*Data for the table `supplier` */

insert  into `supplier`(`idsupplier`,`namasupplier`,`notelp`,`alamat`) values 
(1639138008,'Nectarine',81224670606,'Semarang');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `idtransaksi` bigint(255) NOT NULL,
  `tanggal` date NOT NULL,
  `idpelanggan` bigint(255) NOT NULL,
  PRIMARY KEY (`idtransaksi`),
  KEY `idpelanggan` (`idpelanggan`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `transaksi` */

insert  into `transaksi`(`idtransaksi`,`tanggal`,`idpelanggan`) values 
(1639138132,'2021-12-10',1638940443),
(1639140190,'2021-12-10',1638940443),
(1639141680,'2021-12-10',1638940443),
(1639141968,'2021-12-10',1638940443),
(1639142783,'2021-12-10',1638940443);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
