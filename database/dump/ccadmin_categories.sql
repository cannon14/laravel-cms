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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2373 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'N/A',NULL,'No Category','none',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(11,'Low Interest Credit Cards',NULL,NULL,'low-interest-credit-cards',1,'2016-01-01 04:04:34','2016-01-01 04:04:34',NULL),(12,'Balance Transfer Credit Cards',NULL,NULL,'balance-transfer-credit-cards',1,'2016-01-01 04:04:44','2016-01-01 04:04:44',NULL),(13,'Instant Approval Credit Cards',NULL,NULL,'instant-approval-credit-cards',1,'2016-01-01 04:05:11','2016-01-01 04:05:11',NULL),(14,'Reward Credit Cards',NULL,NULL,'reward-credit-cards',1,'2016-01-01 04:04:36','2016-01-01 04:04:36',NULL),(15,'Cash Back Credit Cards',NULL,NULL,'cash-back-credit-cards',1,'2016-01-01 04:04:39','2016-01-01 04:04:39',NULL),(16,'Airline Credit Cards',NULL,NULL,'airline-credit-cards',1,'2016-01-01 04:04:32','2016-01-01 04:04:32',NULL),(17,'Business Credit Cards',NULL,NULL,'business-credit-cards',1,'2016-01-01 04:04:40','2016-01-01 04:04:40',NULL),(18,'Student Credit Cards',NULL,NULL,'student-credit-cards',1,'2016-01-01 04:05:10','2016-01-01 04:05:10',NULL),(19,'Prepaid & Debit Cards',NULL,NULL,'prepaid-&-debit-cards',1,'2016-01-01 04:04:42','2016-01-01 04:04:42',NULL),(20,'Cards for Bad Credit',NULL,NULL,'cards-for-bad-credit',1,'2016-01-01 04:04:48','2016-01-01 04:04:48',NULL),(22,'American Express',NULL,NULL,'american-express',1,'2016-01-01 04:05:03','2016-01-01 04:05:03',NULL),(23,'Bank of America',NULL,NULL,'bank-of-america',1,'2016-01-01 04:04:45','2016-01-01 04:04:45',NULL),(25,'Chase',NULL,NULL,'chase',1,'2016-01-01 04:04:46','2016-01-01 04:04:46',NULL),(26,'Citi Credit Cards',NULL,NULL,'citi-credit-cards',1,'2016-01-01 04:05:11','2016-01-01 04:05:11',NULL),(27,'Discover',NULL,NULL,'discover',1,'2016-01-01 04:04:46','2016-01-01 04:04:46',NULL),(31,'MasterCard',NULL,NULL,'mastercard',1,'2016-01-01 04:04:47','2016-01-01 04:04:47',NULL),(32,'Visa',NULL,NULL,'visa',1,'2016-01-01 04:05:05','2016-01-01 04:05:05',NULL),(37,'Top 10 Best Credit Card Deals and Offers',NULL,NULL,'top-10-best-credit-card-deals-and-offers',1,'2016-01-01 04:04:57','2016-01-01 04:04:57',NULL),(39,'Capital One',NULL,NULL,'capital-one',1,'2016-01-01 04:04:48','2016-01-01 04:04:48',NULL),(74,'Credit Quality Fair',NULL,NULL,'credit-quality-fair',1,'2016-01-01 04:05:10','2016-01-01 04:05:10',NULL),(75,'Credit Quality Good',NULL,NULL,'credit-quality-good',1,'2016-01-01 04:04:55','2016-01-01 04:04:55',NULL),(76,'Credit Quality Excellent',NULL,NULL,'credit-quality-excellent',1,'2016-01-01 04:04:51','2016-01-01 04:04:51',NULL),(77,'Points Rewards Credit Cards',NULL,NULL,'points-rewards-credit-cards',1,'2016-01-01 04:04:50','2016-01-01 04:04:50',NULL),(79,'Gas Cards',NULL,NULL,'gas-cards',1,'2016-01-01 04:05:07','2016-01-01 04:05:07',NULL),(979,'Barclaycard',NULL,NULL,'barclaycard',1,'2016-01-01 04:04:57','2016-01-01 04:04:57',NULL),(1077,'Limited or No Credit History',NULL,NULL,'limited-or-no-credit-history',1,'2016-01-01 04:05:08','2016-01-01 04:05:08',NULL),(1477,'0% APR Credit Cards',NULL,NULL,'0%-apr-credit-cards',1,'2016-01-03 23:57:37','2016-01-04 05:57:37',NULL),(1768,'Secured Credit Cards',NULL,NULL,'secured-credit-cards',1,'2016-01-01 04:04:49','2016-01-01 04:04:49',NULL),(2005,'No Annual Fee Credit Cards',NULL,NULL,'no-annual-fee-credit-cards',1,'2016-01-01 04:04:58','2016-01-01 04:04:58',NULL),(2022,'No Foreign Transaction Fee Credit Cards',NULL,NULL,'no-foreign-transaction-fee-credit-cards',1,'2016-01-01 04:04:59','2016-01-01 04:04:59',NULL),(2024,'U.S. Bank',NULL,NULL,'u.s.-bank',1,'2016-01-01 04:05:11','2016-01-01 04:05:11',NULL),(2116,'EMV Smart Chips',NULL,NULL,'emv-smart-chips',1,'2016-01-01 04:05:10','2016-01-01 04:05:10',NULL),(2296,'USAA',NULL,NULL,'usaa',1,'2016-01-01 04:05:01','2016-01-01 04:05:01',NULL),(2314,'Hotel Credit Cards',NULL,NULL,'hotel-credit-cards',1,'2016-01-01 04:05:02','2016-01-01 04:05:02',NULL),(2345,'Small Business Loans',NULL,NULL,'small-business-loans',1,'2016-01-01 04:05:02','2016-01-01 04:05:02',NULL),(2372,'Personal Loans',NULL,NULL,'personal-loans',1,'2016-01-01 04:05:03','2016-01-01 04:05:03',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-04 19:54:03
