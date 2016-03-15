CREATE DATABASE  IF NOT EXISTS `ccadmin` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ccadmin`;
-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: ccadmin
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2015_11_14_193421_CreateSchumerTypesTable',1),('2015_11_15_181535_CreateTemplatesTable',1),('2015_11_16_032355_CreateCategoryTable',1),('2015_11_17_015445_CreateNodeTable',1),('2015_11_17_032355_CreateCardTable',1),('2015_11_18_184854_CreateFeedsTable',1),('2015_11_18_192653_CreatePageTypeTable',1),('2015_11_18_192654_CreatePageTable',1),('2015_11_19_220850_CreateCardPageMapTable',1),('2015_11_20_050856_CreateAclTable',1),('2015_11_20_050857_CreateUsersTable',1),('2015_11_21_013941_CreateContentBlockTable',1),('2015_11_21_014226_CreatePageContentBlockMapTable',1),('2015_12_10_003256_CreateIssuersTable',1),('2015_12_10_003303_CreateReviewsTable',1),('2015_12_12_173650_CreateDeviceTypesTable',1),('2015_12_12_173703_CreateLinkTypesTable',1),('2015_12_12_173810_CreateProductLinksTable',1),('2015_12_14_161857_CreateTemplateTypeTable',1),('2015_12_18_232307_CreateNodeObjectMapTable',1),('2015_12_29_020404_CreateCardCategoryMapTable',1),('2016_01_01_012504_AddOrphanedFileToTemplatesTable',2),('2016_01_04_175043_CreateReviewsTable',3),('2016_01_04_175047_CreateStaffReviewsTable',3),('2016_01_04_200015_CrateProductToProductMapping',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-04 19:54:04
