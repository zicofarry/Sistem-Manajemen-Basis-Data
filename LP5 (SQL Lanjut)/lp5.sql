-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gor
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `harga` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (4,'Kerucut',10000,50),(5,'Handuk',15000,12),(6,'Peluit',5000,10),(7,'Kartu Kuning',3000,14),(8,'Kartu Merah',3000,11),(10,'Jersey Tim',75000,15);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `is_member` varchar(255) NOT NULL,
  `id_pelanggan` int(10) NOT NULL,
  `status_booking` varchar(255) NOT NULL,
  `total_harga` int(10) NOT NULL,
  `total_jam` varchar(255) NOT NULL,
  `tanggal_booking` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pelanggan` (`id_pelanggan`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (1,'Yes',1,'Confirmed',300000,'2','2025-03-22'),(2,'No',2,'Pending',150000,'1','2025-03-23'),(3,'1',1,'confirmed',200000,'2','2024-03-01'),(4,'1',1,'confirmed',250000,'3','2024-03-02'),(5,'0',2,'pending',300000,'4','2024-03-03'),(6,'0',2,'cancelled',150000,'2','2024-03-04'),(7,'1',2,'confirmed',200000,'3','2024-03-05');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegiatan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) NOT NULL,
  `biaya` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
INSERT INTO `kegiatan` VALUES (1,'Futsal',100000),(2,'Basket',120000);
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_barang`
--

DROP TABLE IF EXISTS `list_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_barang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_booking` int(10) NOT NULL,
  `id_barang` int(10) NOT NULL,
  `Kuantitas_pinjam` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_booking` (`id_booking`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `list_barang_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`),
  CONSTRAINT `list_barang_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_barang`
--

LOCK TABLES `list_barang` WRITE;
/*!40000 ALTER TABLE `list_barang` DISABLE KEYS */;
INSERT INTO `list_barang` VALUES (1,1,4,2),(2,2,5,1);
/*!40000 ALTER TABLE `list_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_booking`
--

DROP TABLE IF EXISTS `list_booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_booking` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_slot_waktu` int(10) NOT NULL,
  `id_booking` int(10) NOT NULL,
  `id_kegiatan` int(10) NOT NULL,
  `tanggal_main` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_slot_waktu` (`id_slot_waktu`),
  KEY `id_booking` (`id_booking`),
  KEY `id_kegiatan` (`id_kegiatan`),
  CONSTRAINT `list_booking_ibfk_1` FOREIGN KEY (`id_slot_waktu`) REFERENCES `slot_waktu` (`id`),
  CONSTRAINT `list_booking_ibfk_2` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`),
  CONSTRAINT `list_booking_ibfk_3` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_booking`
--

LOCK TABLES `list_booking` WRITE;
/*!40000 ALTER TABLE `list_booking` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelanggan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggan`
--

LOCK TABLES `pelanggan` WRITE;
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
INSERT INTO `pelanggan` VALUES (1,'Budi Santoso','Jl. Merdeka No. 45','081234567890'),(2,'Ani Wijaya','Jl. Sudirman No. 67','089876543210');
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slot_waktu`
--

DROP TABLE IF EXISTS `slot_waktu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slot_waktu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `waktu_awal` time NOT NULL,
  `waktu_akhir` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slot_waktu`
--

LOCK TABLES `slot_waktu` WRITE;
/*!40000 ALTER TABLE `slot_waktu` DISABLE KEYS */;
INSERT INTO `slot_waktu` VALUES (1,'08:00:00','10:00:00'),(2,'10:00:00','12:00:00');
/*!40000 ALTER TABLE `slot_waktu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_booking` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `Id_kegiatan` int(11) DEFAULT NULL,
  `Status_pembayaran` enum('pending','lunas','batal') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_booking` (`id_booking`),
  KEY `id_pelanggan` (`id_pelanggan`),
  KEY `id_barang` (`id_barang`),
  KEY `Id_kegiatan` (`Id_kegiatan`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`),
  CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`),
  CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`Id_kegiatan`) REFERENCES `kegiatan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` VALUES (7,1,2,4,1,'pending'),(8,2,1,5,2,'lunas'),(9,1,1,6,2,'batal');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-24 11:32:29
