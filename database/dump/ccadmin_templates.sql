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
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_type_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `orphaned_file` tinyint(1) NOT NULL DEFAULT '1',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES (1,'Card Category Page','card-category-page.php',2,'Standard Credit Card Category Page','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'card-category-page.php'),(2,'Top Offers Page','top-offers.php',2,'Top Offers Page','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'top-offers.php'),(3,'Bank Card Category Page','bank-category-page.php',2,'Bank Card Category Page','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'bank-category-page.php'),(4,'Home Page','home-page.php',2,'Home Page','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'home-page.php'),(5,'Best Credit Cards Page','best-cards.php',2,'Best Cards Cards Page','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'best-cards.php'),(8,'Balance Transfer Category Page Right Gutter','balance-transfer.blade.php',4,'Balance Transfer Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'balance-transfer'),(9,'Low Interest Category Page Right Gutter','low-interest.blade.php',4,'Low Interest Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'low-interest'),(10,'Cash Back Category Page Right Gutter','cash-back.blade.php',4,'Cash Back Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'cash-back'),(12,'Balance Transfer Schumer Box','balance-transfer.blade.php',5,'Balance Transfer Schumer Box','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'balance-transfer'),(13,'Standard Schumer Box','standard.blade.php',5,'Standard Schumer Box','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'standard'),(14,'Personal Loans Schumer Box','personal-loans.blade.php',5,'Personal Loans Schumer Box','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'personal-loans'),(15,'Top Offers Schumer Box','top-offers.blade.php',5,'Top Offers Schumer Box','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'top-offers'),(18,'Master Layout','master.blade.php',1,'Master Layout Template','1.0.0','2015-11-20','2016-01-04 23:18:24','2016-01-05 05:18:24',0,'master'),(19,'Main Footer','footer.blade.php',3,'Main Footer Template','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'footer'),(20,'Main Header','header.blade.php',3,'Main Header Template','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'header'),(21,'No Credit History Category Page Right Gutter','no-credit-history.blade.php',4,'No Credit History Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'no-credit-history'),(22,'No Foreign Transaction Fee Category Page Right Gutter','no-foreign-transaction-fee.blade.php',4,'No Foreign Transaction Fee Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'no-foreign-transaction-fee'),(23,'Fair Category Page Right Gutter','fair-credit.blade.php',4,'Fair Credit Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'fair-credit'),(24,'Gas Cards Category Page Right Gutter','gas-cards.blade.php',4,'Gas Cards Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'gas-cards'),(25,'Travel and Airline Miles Category Page Right Gutter','airline-miles.blade.php',4,'Travel and Airline Miles Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'airline-miles'),(26,'Hotel Category Page Right Gutter','hotel-cards.blade.php',4,'Hotel Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'hotel-cards'),(27,'Good Category Page Right Gutter','good-credit.blade.php',4,'Good Credit Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'good-credit'),(28,'Points Rewards Category Page Right Gutter','points-rewards.blade.php',4,'Points Rewards Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'points-rewards'),(29,'Excellent Category Page Right Gutter','excellent-credit.blade.php',4,'Excellent Credit Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'excellent-credit'),(30,'Rewards Category Page Right Gutter','reward.blade.php',4,'Rewards Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'reward'),(31,'0% APR Category Page Right Gutter','0-apr-credit-cards.blade.php',4,'0% APR Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'0-apr-credit-cards'),(32,'EMV Smart Chips Category Page Right Gutter','smart-emv-chip.blade.php',4,'EMV Smart Chips Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:25','2016-01-05 05:18:25',0,'smart-emv-chip'),(33,'Bad Category Page Right Gutter','bad-credit.blade.php',4,'Bad Credit Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'bad-credit'),(34,'No Annual Fee Category Page Right Gutter','no-annual-fee.blade.php',4,'No Annual Fee Category Page Right Gutter','1.0.0','2015-11-20','2016-01-04 23:18:26','2016-01-05 05:18:26',0,'no-annual-fee');
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
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
