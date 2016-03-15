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
-- Table structure for table `issuers`
--

DROP TABLE IF EXISTS `issuers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuers` (
  `issuer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`issuer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuers`
--

LOCK TABLES `issuers` WRITE;
/*!40000 ALTER TABLE `issuers` DISABLE KEYS */;
INSERT INTO `issuers` VALUES (1,'Discover',NULL,'discover',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(2,'American Express',NULL,'american-express',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(3,'Bank of America',NULL,'bank-of-america',1,'2015-12-31 22:04:08','2016-01-01 04:04:08',NULL),(4,'Capital One',NULL,'capital-one',1,'2015-12-31 22:04:10','2016-01-01 04:04:10',NULL),(5,'Chase',NULL,'chase',1,'2015-12-31 22:04:11','2016-01-01 04:04:11',NULL),(6,'Citi',NULL,'citi',1,'2015-12-31 22:04:13','2016-01-01 04:04:13',NULL),(7,'Discover',NULL,'discover',1,'2016-01-01 04:04:14','2016-01-01 04:04:14',NULL),(8,'First PREMIER&#174; Bank',NULL,'first-premier-bank',1,'2016-01-01 04:04:13','2016-01-01 04:04:13',NULL),(28,'RushCard',NULL,'rushcard',1,'2016-01-01 04:04:22','2016-01-01 04:04:22',NULL),(30,'NetSpend',NULL,'netspend',1,'2016-01-01 04:04:13','2016-01-01 04:04:13',NULL),(36,'Simmons First National Bank',NULL,'simmons-first-national-bank',1,'2016-01-01 04:04:13','2016-01-01 04:04:13',NULL),(42,'AccountNow',NULL,'accountnow',1,'2016-01-04 00:14:39','2016-01-04 06:14:39',NULL),(46,'Barclaycard',NULL,'barclaycard',1,'2016-01-01 04:04:06','2016-01-01 04:04:06',NULL),(66,'READYdebit',NULL,'readydebit',1,'2016-01-01 04:04:16','2016-01-01 04:04:16',NULL),(86,'Green Dot',NULL,'green-dot',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(109,'Horizon Gold',NULL,'horizon-gold',1,'2016-01-01 04:04:22','2016-01-01 04:04:22',NULL),(113,'U.S. Bank',NULL,'u.s.-bank',1,'2016-01-01 04:04:17','2016-01-01 04:04:17',NULL),(119,'USAA Savings',NULL,'usaa-savings',1,'2016-01-01 04:04:17','2016-01-01 04:04:17',NULL),(128,'BB&T ',NULL,'bb&t-',1,'2016-01-01 04:04:20','2016-01-01 04:04:20',NULL),(132,'Credit One Bank',NULL,'credit-one-bank',1,'2016-01-01 04:04:16','2016-01-01 04:04:16',NULL),(147,'PEX Card',NULL,'pex-card',1,'2016-01-01 04:04:15','2016-01-01 04:04:15',NULL),(152,'AchieveCard',NULL,'achievecard',1,'2016-01-01 04:04:16','2016-01-01 04:04:16',NULL),(154,'First Progress',NULL,'first-progress',1,'2016-01-01 04:04:15','2016-01-01 04:04:15',NULL),(163,'FLEETCOR',NULL,'fleetcor',1,'2016-01-01 04:04:16','2016-01-01 04:04:16',NULL),(165,'KAIKU Finance',NULL,'kaiku-finance',1,'2016-01-01 04:04:23','2016-01-01 04:04:23',NULL),(174,'Bank of America',NULL,'bank-of-america',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(181,'Ace Cash Express',NULL,'ace-cash-express',1,'2016-01-04 00:14:40','2016-01-04 06:14:40',NULL),(190,'Prosper',NULL,'prosper',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(202,'OneMain Financial',NULL,'onemain-financial',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(206,'LendingClub',NULL,'lendingclub',1,'2016-01-01 04:04:24','2016-01-01 04:04:24',NULL),(207,'OneUnited',NULL,'oneunited',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(209,'Virgin America',NULL,'virgin-america',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(213,'D&B',NULL,'d&b',1,'2016-01-01 04:04:20','2016-01-01 04:04:20',NULL),(219,'Kabbage',NULL,'kabbage',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(220,'LendUp',NULL,'lendup',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(221,'PersonalLoan.com',NULL,'personalloan.com',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(222,'primor',NULL,'primor',1,'2016-01-01 04:04:18','2016-01-01 04:04:18',NULL),(224,'American Express Gift Card',NULL,'american-express-gift-card',1,'2016-01-01 04:04:19','2016-01-01 04:04:19',NULL),(250,'NetCredit',NULL,'netcredit',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(251,'Webster Bank',NULL,'webster-bank',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(255,'AvantCredit',NULL,'avantcredit',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(258,'CircleBackLending',NULL,'circlebacklending',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(261,'Mid America Bank & Trust',NULL,'mid-america-bank-&-trust',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(264,'Genesis Bankcard Services',NULL,'genesis-bankcard-services',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(268,'OnDeck',NULL,'ondeck',1,'2016-01-01 04:04:21','2016-01-01 04:04:21',NULL),(271,'Rakuten Card USA, Inc.',NULL,'rakuten-card-usa,-inc.',1,'2016-01-01 04:04:23','2016-01-01 04:04:23',NULL),(275,'SignatureLoan.com',NULL,'signatureloan.com',1,'2016-01-01 04:04:24','2016-01-01 04:04:24',NULL),(276,'CashAdvance.com',NULL,'cashadvance.com',1,'2016-01-01 04:04:24','2016-01-01 04:04:24',NULL),(278,'NASA Federal Credit Union',NULL,'nasa-federal-credit-union',1,'2016-01-01 04:04:23','2016-01-01 04:04:23',NULL),(280,'Next Millennium ',NULL,'next-millennium-',1,'2016-01-01 04:04:27','2016-01-01 04:04:27',NULL),(282,'Luxe Signature',NULL,'luxe-signature',1,'2016-01-01 04:04:23','2016-01-01 04:04:23',NULL),(286,'Biz2Credit',NULL,'biz2credit',1,'2016-01-01 04:04:24','2016-01-01 04:04:24',NULL),(288,'ForwardLine',NULL,'forwardline',1,'2016-01-01 04:04:24','2016-01-01 04:04:24',NULL),(290,'Lendyou.com',NULL,'lendyou.com',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(291,'Walmart MoneyCard',NULL,'walmart-moneycard',1,'2016-01-01 04:04:25','2016-01-01 04:04:25',NULL),(293,'Central National Bank and Trust Company',NULL,'central-national-bank-and-trust-company',1,'2016-01-01 04:04:27','2016-01-01 04:04:27',NULL),(294,'Group One Freedom',NULL,'group-one-freedom',1,'2016-01-01 04:04:27','2016-01-01 04:04:27',NULL),(295,'Vast Platinum',NULL,'vast-platinum',1,'2016-01-01 04:04:27','2016-01-01 04:04:27',NULL),(297,'CardMatch',NULL,'cardmatch',1,'2016-01-01 04:04:27','2016-01-01 04:04:27',NULL),(300,'FOUNDERSCARD',NULL,'founderscard',1,'2016-01-01 04:04:28','2016-01-01 04:04:28',NULL),(302,'Holiday Loans',NULL,'holiday-loans',1,'2016-01-01 04:04:28','2016-01-01 04:04:28',NULL);
/*!40000 ALTER TABLE `issuers` ENABLE KEYS */;
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
