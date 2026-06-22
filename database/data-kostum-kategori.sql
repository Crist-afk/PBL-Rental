-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pbl_rental
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
-- Table structure for table `kostum`
--

DROP TABLE IF EXISTS `kostum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kostum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint(20) unsigned NOT NULL,
  `nama_kostum` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_per_ukuran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stok_per_ukuran`)),
  `harga_sewa` int(11) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `kelengkapan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kostum_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `kostum_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kostum`
--

LOCK TABLES `kostum` WRITE;
/*!40000 ALTER TABLE `kostum` DISABLE KEYS */;
INSERT INTO `kostum` VALUES (1,1,'Gojo Satoru',31,'{\"L\":11,\"XL\":10,\"XXL\":10}',150000,'L, XL, XXL','Wig, Eye Patch, Jujutsu High Uniform','kostum/gojo.jpg','2026-05-28 23:25:07','2026-06-14 19:31:37'),(2,2,'Kafka',2,'{\"M\":1,\"L\":1}',200000,'M, L','Wig, Coat, Shirt, Trousers, Accessories','kostum/kafka.jpg','2026-05-28 23:25:07','2026-06-08 20:00:28'),(3,1,'Monkey D. Luffy',5,'{\"S\":1,\"M\":2,\"L\":2}',100000,'S, M, L','Straw Hat, Red Vest, Shorts, Waist Sash','kostum/luffy.jpg','2026-05-28 23:25:07','2026-05-29 06:47:57'),(4,2,'Raiden Shogun',4,'{\"M\":1,\"L\":1,\"XL\":2}',250000,'M, L, XL','Wig, Kimono, Obi, Hairpiece, Tabi','kostum/raiden.jpg','2026-05-28 23:25:07','2026-06-22 02:23:46'),(5,3,'Spider-Man',4,'{\"M\":2,\"L\":2}',125000,'M, L','Full Body Suit, Mask','kostum/spiderman.jpg','2026-05-28 23:25:07','2026-05-29 06:47:57'),(6,2,'Yae Miko',2,'{\"M\":1,\"L\":1}',225000,'M, L','Wig, Shrine Maiden Outfit, Accessories','kostum/yae.jpg','2026-05-28 23:25:07','2026-05-29 06:47:57'),(9,1,'Saitama',4,'{\"M\":1,\"L\":2,\"XL\":1}',180000,'M, L, XL','Full Set','kostum/sNz4TMcfuxlsUhygTohbYtD1noAeGF74o8hblkkc.jpg','2026-06-22 03:19:40','2026-06-22 03:19:40'),(10,1,'Anya Forger',6,'{\"M\":2,\"L\":2,\"XL\":2}',150000,'M, L, XL','Eden Academy Uniform Dress, Detachable White Collar with Red Ribbon Tie, Character Pink Wig, Pair of Anya\'s Signature Hair Ornaments, Pair of Over-Knee White Socks','kostum/AfWzRkT9xKv7XW9SH9VAVG0qgvxDUFQGTupQeHTq.jpg','2026-06-22 03:23:48','2026-06-22 03:23:48'),(11,1,'Geto Suguru',3,'{\"M\":1,\"L\":1,\"XL\":1}',160000,'M, L, XL','Jujutsu High School Uniform Jacket, Matching Baggy Hakama-style Pants, Character Black Wig','kostum/vsQetkpy3qBCvDqgwqxPuBaoHoerolvxLmZlJvRW.jpg','2026-06-22 03:28:35','2026-06-22 03:28:35');
/*!40000 ALTER TABLE `kostum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `franchise` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Anime','Various Anime','2026-05-28 23:25:07','2026-05-28 23:25:07'),(2,'Game','Various Games','2026-05-28 23:25:07','2026-05-28 23:25:07'),(3,'Superhero','Marvel & DC','2026-05-28 23:25:07','2026-05-28 23:25:07');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-22 10:33:46
