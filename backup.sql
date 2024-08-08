-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: vehicle-rental-management-system_dev
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.10-MariaDB-1:10.6.10+maria~ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Cat','2024-06-15 12:33:34','2024-06-15 12:33:34'),(4,'Cat II','2024-06-27 11:46:09','2024-07-02 08:25:57'),(5,'Cat','2024-07-09 14:35:27','2024-07-09 14:35:27'),(7,'Cat test','2024-08-06 10:26:10','2024-08-06 10:26:10'),(8,'Cat test2','2024-08-06 10:57:32','2024-08-06 10:57:32'),(18,'Cat test3','2024-08-08 11:30:28','2024-08-08 11:30:28'),(19,'Cat test4','2024-08-08 12:41:17','2024-08-08 12:41:17');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240604113208','2024-06-06 11:08:48',7),('DoctrineMigrations\\Version20240606123259','2024-06-06 12:36:07',15),('DoctrineMigrations\\Version20240612113542','2024-06-12 11:42:36',15),('DoctrineMigrations\\Version20240615102832','2024-06-15 10:29:16',94);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refresh_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refresh_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
INSERT INTO `refresh_tokens` VALUES (49,'daeae03639df6beaa44a888d996e8e02bf0d44ad7ce00cda416db3097d0624caddc4c11bc4f9d06d57ae6c6356ea0bdd745e9ffc7f2b46cf76009e89ff4a871a','admin@test.com','2024-07-16 09:56:52'),(50,'1f05dc0d14f3cca20261856e1ec3575aba0994ddf571a73943143da2180210c778b68cabfeffc8ff331104a47213e26b3335f2bb9b0871b19eda37c5bf26bb09','admin@test.com','2024-07-18 11:48:59'),(51,'4165f0016824b203bb194caa625c6dd9e8c38add5761d5590fce021521d46e3bec1166cac37312d65c6e4b28895e0f6ad989176cf47a1c168b4b1b0c367f16c4','admin@test.com','2024-07-23 13:14:16'),(52,'3e54d4586d497671d8a0f0ffb08e918b857f1eea8ac1a0f0b1810e2f0c7e4a59ef824d1f531b744cd1147e57119326d9b32a2093e3ae66c92afcb254e48ce377','admin@test.com','2024-07-25 10:37:19'),(53,'723100032e1f7b911253d58cb07f1b8a7b4f6450b6a66a2efbb6636936624843e525d2473761185640333a0a2082dfd11c15be9323c091b3b1c3ad79e8c14916','admin@test.com','2024-08-08 08:20:38'),(54,'54baabcf892de413fda82c22e543c28e0daa2f3acfc5527826cf878259705b0f4a51a301e2b6e351be623a092946366012cea884f0a78accb48d334d2eb08f9e','admin@test.com','2024-08-12 13:12:49'),(55,'0a53c0147290a33c9254b078feec1210d7a9c233d560b6935e518bcb9cda001ffdebd912750dd98b75d4a96a8d8296a6dcf5cb73d9b09ea11a2fd28cc0757f7f','admin@test.com','2024-08-13 13:28:59'),(56,'df5b43da1c0a2de06ab4184cf0034879fa6bb968bc04be794410b016d13980a41aaa3af91fbea683cda35b28ea3e16edb5018c9342f00421811e0d460ad8aad9','admin@test.com','2024-08-15 09:01:42');
/*!40000 ALTER TABLE `refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@test.com','[\"ROLE_ADMIN\"]','$2y$13$FLTtjBdG1OVIRnoZkI64D.Yd0Jf.tnz7Yz7pZe66u6uZBkdTwX.aC'),(6,'testt@test.pl','[]','$2y$13$y4xTGQ7Xr42j55H95Lu/7eWg6VmX/VPEzLR5UbiiaB9aixNpknVdO'),(7,'testttt@test.pl','[]','$2y$13$wzpjgA9Ach7XOgV9CM6hDelZFkXyzPWQRHZuVepbzAJ4u8YLnEZnS'),(8,'testtttt@test.pl','[]','$2y$13$9oXbdBZutdARig13Xgs7ZO8v4YQU1p3yD0I.Rc2h/9hg5pZZ0VzuK');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `mileage` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1B80E48644F5D008` (`brand_id`),
  CONSTRAINT `FK_1B80E48644F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES (6,'Cat III','EPI 12345','2024-06-17 11:10:03','2024-07-11 11:52:16',10000,1),(7,'Cat II','EPI 12345','2024-06-17 11:29:15','2024-06-17 11:29:15',10000,1),(8,'Cat II','EPI 12345','2024-06-17 11:29:21','2024-06-17 11:29:21',10000,1),(9,'Cat II','EPI 12345','2024-06-17 11:30:15','2024-06-17 11:30:15',10000,1),(10,'Cat II','EPI 12345','2024-06-17 11:33:05','2024-06-17 11:33:05',10000,1),(11,'Cat II','EPI 12345','2024-06-17 11:54:00','2024-06-17 11:54:00',10000,1),(12,'Cat I','EPI 12345','2024-06-18 10:40:32','2024-06-18 10:40:32',10000,4),(13,'Cat I','EPI 12345','2024-06-18 10:41:03','2024-06-18 10:41:03',10000,4),(14,'Cat I','EPI 12345','2024-06-18 10:43:03','2024-06-18 10:43:03',10000,4),(15,'Cat I','EPI 12345','2024-06-18 10:43:14','2024-06-18 10:43:14',10000,5),(16,'Cat I','EPI 12345','2024-06-18 10:54:08','2024-06-18 10:54:08',10000,5),(17,'Cat I','EPI 12345','2024-06-19 11:41:41','2024-06-19 11:41:41',10000,5),(18,'Cat test','abc 12345','2024-08-06 10:29:39','2024-08-06 10:29:39',0,7),(19,'Cat test2','abc 12345','2024-08-06 10:57:43','2024-08-06 10:57:43',0,8);
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-08 15:25:44
