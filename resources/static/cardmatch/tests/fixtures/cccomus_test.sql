-- MySQL dump 10.13  Distrib 5.1.69, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cccomus_test
-- ------------------------------------------------------
-- Server version	5.1.69-0ubuntu0.11.10.1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,MYSQL40' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Record ID',
  `account_id` varchar(10) NOT NULL COMMENT 'Member ID',
  `first_name` varchar(50) NOT NULL COMMENT 'First Name',
  `last_name` varchar(50) NOT NULL COMMENT 'Last Name',
  `company_id` int(11) NOT NULL COMMENT 'Company Id',
  `email` varchar(100) NOT NULL COMMENT 'Email',
  PRIMARY KEY (`rec_id`),
  UNIQUE KEY `member_id` (`account_id`)
) TYPE=MyISAM;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(50) NOT NULL,
  PRIMARY KEY (`activity_id`)
) TYPE=MyISAM AUTO_INCREMENT=51;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `admin_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `jacl_username` varchar(230) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified_time` timestamp NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_user_id`)
) TYPE=InnoDB AUTO_INCREMENT=2;

--
-- Table structure for table `affiliate_tracking_pixels`
--

DROP TABLE IF EXISTS `affiliate_tracking_pixels`;
CREATE TABLE `affiliate_tracking_pixels` (
  `tracking_pixel_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(16) NOT NULL,
  `url` varchar(512) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tracking_pixel_id`),
  KEY `IDX_affiliate_id` (`affiliate_id`)
) TYPE=MyISAM AUTO_INCREMENT=12;

--
-- Table structure for table `alternately_tracked_clicks`
--

DROP TABLE IF EXISTS `alternately_tracked_clicks`;
CREATE TABLE `alternately_tracked_clicks` (
  `card_id` varchar(15) NOT NULL COMMENT 'Card Being Tracked',
  `exit_page_id` int(11) NOT NULL COMMENT 'ID of page that was exited when the user clicked on the card link',
  `landing_page_id` int(11) NOT NULL COMMENT 'ID of destinatation page on CCCOM site when the user clicked on the card link',
  `banner_id` varchar(20) NOT NULL COMMENT 'ID of the banner associated with the card when the user clicked on the card link',
  `affiliate_id` varchar(8) NOT NULL COMMENT 'ID of the CCCOM affiliate who dirrected the user to CCCOM',
  `click_datetime` timestamp NOT NULL COMMENT 'Timestamp of the users click',
  PRIMARY KEY (`card_id`,`exit_page_id`,`landing_page_id`,`banner_id`,`affiliate_id`,`click_datetime`)
) TYPE=MyISAM;

--
-- Table structure for table `app_log`
--

DROP TABLE IF EXISTS `app_log`;
CREATE TABLE `app_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` enum('ERROR','NOTICE') NOT NULL,
  `message` text NOT NULL,
  `time_logged` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) TYPE=MyISAM AUTO_INCREMENT=14;

--
-- Table structure for table `application_errors`
--

DROP TABLE IF EXISTS `application_errors`;
CREATE TABLE `application_errors` (
  `application_error_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `error_type` varchar(25) NOT NULL DEFAULT '',
  `error_time` datetime NOT NULL,
  PRIMARY KEY (`application_error_id`),
  UNIQUE KEY `idx_application_id` (`application_id`)
) TYPE=MyISAM AUTO_INCREMENT=1697991;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(32) DEFAULT NULL,
  `upload_file_id` int(11) DEFAULT NULL,
  `submission_date` datetime DEFAULT NULL,
  `state` enum('COMMITTED','DELETED','ERROR','VALID') DEFAULT NULL,
  `last_updated` timestamp NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `ap_upload_file_id_idx` (`upload_file_id`),
  KEY `app_last_updated_idx` (`last_updated`)
) TYPE=MyISAM AUTO_INCREMENT=7238817;

--
-- Table structure for table `banner_commission_data`
--

DROP TABLE IF EXISTS `banner_commission_data`;
CREATE TABLE `banner_commission_data` (
  `affiliate_id` varchar(8) NOT NULL,
  `banner_id` varchar(20) NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `process_date` date NOT NULL,
  `received` double(9,2) DEFAULT '0.00',
  `paid` double(9,2) DEFAULT '0.00',
  `declined` double(9,2) DEFAULT '0.00',
  PRIMARY KEY (`process_date`,`affiliate_id`,`banner_id`)
) TYPE=MyISAM;

--
-- Table structure for table `banner_performance_data`
--

DROP TABLE IF EXISTS `banner_performance_data`;
CREATE TABLE `banner_performance_data` (
  `banner_click_date` date NOT NULL,
  `affiliate_id` varchar(16) NOT NULL,
  `banner_clicks` int(11) DEFAULT '0',
  `offer_clicks` int(11) DEFAULT '0',
  `sales` int(11) DEFAULT '0',
  `commission` double DEFAULT '0',
  PRIMARY KEY (`banner_click_date`,`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `beacon_types`
--

DROP TABLE IF EXISTS `beacon_types`;
CREATE TABLE `beacon_types` (
  `beacon_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `beacon_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`beacon_type_id`)
) TYPE=MyISAM;

--
-- Table structure for table `botowners`
--

DROP TABLE IF EXISTS `botowners`;
CREATE TABLE `botowners` (
  `botOwnerid` bigint(20) NOT NULL AUTO_INCREMENT,
  `botDescription` varchar(50) NOT NULL DEFAULT 'unknown',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`botOwnerid`)
) TYPE=MyISAM AUTO_INCREMENT=13;

--
-- Table structure for table `bots`
--

DROP TABLE IF EXISTS `bots`;
CREATE TABLE `bots` (
  `botIp` varchar(20) NOT NULL,
  `botOwnerid` bigint(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`botIp`),
  KEY `IDX_bots_botOwnerid` (`botOwnerid`)
) TYPE=MyISAM;

--
-- Table structure for table `campaign_rate_groups`
--

DROP TABLE IF EXISTS `campaign_rate_groups`;
CREATE TABLE `campaign_rate_groups` (
  `campaign_rate_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`campaign_rate_group_id`)
) TYPE=MyISAM AUTO_INCREMENT=37;

--
-- Table structure for table `campaign_rate_groups_map`
--

DROP TABLE IF EXISTS `campaign_rate_groups_map`;
CREATE TABLE `campaign_rate_groups_map` (
  `campaign_rate_group_id` int(11) NOT NULL DEFAULT '0',
  `campaignid` varchar(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`campaign_rate_group_id`,`campaignid`)
) TYPE=MyISAM;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `init_account_id` varchar(10) NOT NULL,
  `resp_account_id` varchar(10) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `delete` tinyint(4) NOT NULL DEFAULT '0'
) TYPE=MyISAM;

--
-- Table structure for table `card_art`
--

DROP TABLE IF EXISTS `card_art`;
CREATE TABLE `card_art` (
  `card_id` varchar(50) NOT NULL,
  `found` tinyint(4) DEFAULT NULL,
  `original_filename` varchar(200) DEFAULT NULL,
  `new_filename` varchar(200) DEFAULT NULL,
  `date_created` timestamp NOT NULL,
  `noImageAvailable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_art_compare`
--

DROP TABLE IF EXISTS `card_art_compare`;
CREATE TABLE `card_art_compare` (
  `compare_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` varchar(20) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`compare_id`)
) TYPE=MyISAM;

--
-- Temporary table structure for view `card_boost`
--

DROP TABLE IF EXISTS `card_boost`;
/*!50001 DROP VIEW IF EXISTS `card_boost`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `card_boost` (
 `card_id` tinyint NOT NULL,
  `boost` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `card_commission_data`
--

DROP TABLE IF EXISTS `card_commission_data`;
CREATE TABLE `card_commission_data` (
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `process_date` date NOT NULL,
  `received` double(9,2) DEFAULT '0.00',
  `paid` double(9,2) DEFAULT '0.00',
  `declined` double(9,2) DEFAULT '0.00',
  PRIMARY KEY (`process_date`,`affiliate_id`,`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_cpa_by_page`
--

DROP TABLE IF EXISTS `card_cpa_by_page`;
CREATE TABLE `card_cpa_by_page` (
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `calculated_cpa` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`page_fid`,`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `card_epc`
--

DROP TABLE IF EXISTS `card_epc`;
CREATE TABLE `card_epc` (
  `bannerid` varchar(20) NOT NULL,
  `sale_rate` float NOT NULL,
  `sale_price` float NOT NULL,
  `epc_rate` float NOT NULL,
  `epc_rate_override` float NOT NULL,
  `last_change_time` datetime DEFAULT NULL,
  `use_override` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bannerid`)
) TYPE=MyISAM;

--
-- Table structure for table `card_epc_by_page`
--

DROP TABLE IF EXISTS `card_epc_by_page`;
CREATE TABLE `card_epc_by_page` (
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `cpa_to_use` enum('CALCULATE','OVERRIDE','RATE_TABLE') NOT NULL,
  `cpa_override` decimal(6,2) NOT NULL,
  `sale_rate_to_use` enum('CALCULATE','OVERRIDE') NOT NULL,
  `sale_rate_override` decimal(5,5) NOT NULL,
  PRIMARY KEY (`page_fid`,`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `card_epc_by_page_sem`
--

DROP TABLE IF EXISTS `card_epc_by_page_sem`;
CREATE TABLE `card_epc_by_page_sem` (
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `cpa_to_use` enum('CALCULATE','OVERRIDE','RATE_TABLE') NOT NULL,
  `cpa_override` decimal(6,2) NOT NULL,
  `sale_rate_to_use` enum('CALCULATE','OVERRIDE') NOT NULL,
  `sale_rate_override` decimal(6,5) NOT NULL,
  PRIMARY KEY (`page_fid`,`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `card_epc_history`
--

DROP TABLE IF EXISTS `card_epc_history`;
CREATE TABLE `card_epc_history` (
  `bannerid` varchar(20) NOT NULL,
  `rate_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sale_rate` float NOT NULL,
  `sale_price` float NOT NULL,
  `epc_rate` float NOT NULL,
  `epc_rate_override` float NOT NULL,
  PRIMARY KEY (`bannerid`,`rate_begin_time`)
) TYPE=MyISAM;

--
-- Table structure for table `card_epc_sem`
--

DROP TABLE IF EXISTS `card_epc_sem`;
CREATE TABLE `card_epc_sem` (
  `bannerid` varchar(20) NOT NULL,
  `sale_rate` float NOT NULL,
  `sale_price` float NOT NULL,
  `epc_rate` float NOT NULL,
  `epc_rate_override` float NOT NULL,
  `last_change_time` datetime DEFAULT NULL,
  `use_override` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bannerid`)
) TYPE=MyISAM;

--
-- Table structure for table `card_level_rates`
--

DROP TABLE IF EXISTS `card_level_rates`;
CREATE TABLE `card_level_rates` (
  `card_level_id` int(10) unsigned NOT NULL,
  `commission_rate_id` int(11) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  PRIMARY KEY (`card_level_id`,`commission_rate_id`),
  KEY `commission_rate_id` (`commission_rate_id`),
  CONSTRAINT `card_level_rates_ibfk_1` FOREIGN KEY (`card_level_id`) REFERENCES `card_levels` (`card_level_id`) ON DELETE CASCADE,
  CONSTRAINT `card_level_rates_ibfk_2` FOREIGN KEY (`commission_rate_id`) REFERENCES `partner_commission_rates` (`commission_rate_id`) ON DELETE CASCADE
) TYPE=InnoDB;

--
-- Table structure for table `card_levels`
--

DROP TABLE IF EXISTS `card_levels`;
CREATE TABLE `card_levels` (
  `card_level_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `display_order` int(11) NOT NULL,
  PRIMARY KEY (`card_level_id`)
) TYPE=InnoDB AUTO_INCREMENT=8;

--
-- Table structure for table `card_performance_data`
--

DROP TABLE IF EXISTS `card_performance_data`;
CREATE TABLE `card_performance_data` (
  `card_click_date` date NOT NULL,
  `affiliate_id` varchar(16) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `card_title` varchar(255) DEFAULT NULL,
  `offer_clicks` int(11) DEFAULT '0',
  `sales` int(11) DEFAULT '0',
  `commission` double(11,2) DEFAULT '0.00',
  PRIMARY KEY (`card_click_date`,`affiliate_id`,`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_revenue_rates`
--

DROP TABLE IF EXISTS `card_revenue_rates`;
CREATE TABLE `card_revenue_rates` (
  `product_rate_id` int(16) NOT NULL AUTO_INCREMENT,
  `rate` double(12,2) DEFAULT NULL,
  `rate_type` int(11) DEFAULT '4',
  `rate_group_id` int(11) DEFAULT '1',
  `bonus` double(12,2) DEFAULT NULL,
  `card_id` varchar(15) DEFAULT NULL,
  `rate_start_date` date DEFAULT NULL,
  `rate_end_date` date DEFAULT '0000-00-00',
  `comment` text,
  `active` tinyint(1) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  PRIMARY KEY (`product_rate_id`),
  KEY `idx_rate_start_date` (`rate_start_date`),
  KEY `idx_card_id` (`card_id`)
) TYPE=MyISAM AUTO_INCREMENT=3;

--
-- Table structure for table `card_revenue_rates_log`
--

DROP TABLE IF EXISTS `card_revenue_rates_log`;
CREATE TABLE `card_revenue_rates_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` varchar(20) NOT NULL,
  `old_cpa` double NOT NULL,
  `new_cpa` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `date` (`date_created`),
  KEY `card_id` (`card_id`)
) TYPE=InnoDB AUTO_INCREMENT=926;

--
-- Table structure for table `card_sale_rates_by_page`
--

DROP TABLE IF EXISTS `card_sale_rates_by_page`;
CREATE TABLE `card_sale_rates_by_page` (
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `calculated_sale_rate` decimal(5,5) NOT NULL,
  PRIMARY KEY (`page_fid`,`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `click_report_data`
--

DROP TABLE IF EXISTS `click_report_data`;
CREATE TABLE `click_report_data` (
  `transaction_id` varchar(50) NOT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `merchant_name` varchar(250) NOT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `affiliate_id` varchar(50) NOT NULL,
  `website_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `card_name` varchar(250) NOT NULL DEFAULT '',
  `uv_data` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `click_date` datetime DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  KEY `idx_transactionid` (`transaction_id`),
  KEY `idx_merchant_id` (`merchant_id`),
  KEY `idx_account_id` (`account_id`),
  KEY `idx_affiliate_id` (`affiliate_id`),
  KEY `idx_website_id` (`website_id`),
  KEY `idx_card_id` (`card_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_page_position` (`page_position`),
  KEY `idx_clickReportData_clickDate` (`click_date`)
) TYPE=InnoDB;

--
-- Table structure for table `click_reporting`
--

DROP TABLE IF EXISTS `click_reporting`;
CREATE TABLE `click_reporting` (
  `transaction_id` varchar(50) NOT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `affiliate_id` varchar(50) NOT NULL,
  `website_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `uv_data` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `date_inserted` datetime NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  KEY `idx_transactionid` (`transaction_id`),
  KEY `idx_merchant_id` (`merchant_id`),
  KEY `idx_account_id` (`account_id`),
  KEY `idx_affiliate_id` (`affiliate_id`),
  KEY `idx_website_id` (`website_id`),
  KEY `idx_card_id` (`card_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_page_position` (`page_position`),
  KEY `idx_date_inserted` (`date_inserted`)
) TYPE=InnoDB;

--
-- Table structure for table `click_summary`
--

DROP TABLE IF EXISTS `click_summary`;
CREATE TABLE `click_summary` (
  `affiliate_id` varchar(50) NOT NULL DEFAULT '',
  `website_id` int(11) NOT NULL DEFAULT '0',
  `card_id` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `saleClickCount` int(11) NOT NULL DEFAULT '0',
  `nonSaleClickCount` int(11) NOT NULL DEFAULT '0',
  `applicationsCount` int(11) NOT NULL DEFAULT '0',
  `totalclicks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`affiliate_id`,`website_id`,`card_id`),
  KEY `idx_affiliateid` (`affiliate_id`),
  KEY `idx_websiteid` (`website_id`),
  KEY `idx_cardid` (`card_id`),
  KEY `idx_date` (`date`)
) TYPE=InnoDB;

--
-- Temporary table structure for view `cms_alternate_links`
--

DROP TABLE IF EXISTS `cms_alternate_links`;
/*!50001 DROP VIEW IF EXISTS `cms_alternate_links`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_alternate_links` (
 `affiliate_id` tinyint NOT NULL,
  `clickable_id` tinyint NOT NULL,
  `url` tinyint NOT NULL,
  `website_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_categories`
--

DROP TABLE IF EXISTS `cms_card_categories`;
/*!50001 DROP VIEW IF EXISTS `cms_card_categories`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_categories` (
 `card_category_id` tinyint NOT NULL,
  `card_category_name` tinyint NOT NULL,
  `card_category_display_name` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_category_contexts`
--

DROP TABLE IF EXISTS `cms_card_category_contexts`;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_contexts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_category_contexts` (
 `card_category_context_id` tinyint NOT NULL,
  `card_category_context_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_category_group_to_category`
--

DROP TABLE IF EXISTS `cms_card_category_group_to_category`;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_group_to_category`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_category_group_to_category` (
 `card_category_group_id` tinyint NOT NULL,
  `card_category_id` tinyint NOT NULL,
  `card_category_group_rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_category_groups`
--

DROP TABLE IF EXISTS `cms_card_category_groups`;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_groups`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_category_groups` (
 `id` tinyint NOT NULL,
  `card_category_group_name` tinyint NOT NULL,
  `context_id` tinyint NOT NULL,
  `inserted` tinyint NOT NULL,
  `updated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_category_ranks`
--

DROP TABLE IF EXISTS `cms_card_category_ranks`;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_ranks`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_category_ranks` (
 `card_category_rank_id` tinyint NOT NULL,
  `card_category_rank` tinyint NOT NULL,
  `card_category_context_id` tinyint NOT NULL,
  `card_category_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_data`
--

DROP TABLE IF EXISTS `cms_card_data`;
/*!50001 DROP VIEW IF EXISTS `cms_card_data`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_data` (
 `cardId` tinyint NOT NULL,
  `introApr` tinyint NOT NULL,
  `introAprPeriod` tinyint NOT NULL,
  `regularApr` tinyint NOT NULL,
  `annualFee` tinyint NOT NULL,
  `balanceTransfers` tinyint NOT NULL,
  `balanceTransferFee` tinyint NOT NULL,
  `balanceTransferIntroApr` tinyint NOT NULL,
  `balanceTransferIntroAprPeriod` tinyint NOT NULL,
  `monthlyFee` tinyint NOT NULL,
  `creditNeeded` tinyint NOT NULL,
  `dateModified` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_details`
--

DROP TABLE IF EXISTS `cms_card_details`;
/*!50001 DROP VIEW IF EXISTS `cms_card_details`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_details` (
 `id` tinyint NOT NULL,
  `cardShortName` tinyint NOT NULL,
  `cardLink` tinyint NOT NULL,
  `appLink` tinyint NOT NULL,
  `cardDetailVersion` tinyint NOT NULL,
  `cardDetailLabel` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `campaignLink` tinyint NOT NULL,
  `cardPageMeta` tinyint NOT NULL,
  `cardDetailText` tinyint NOT NULL,
  `cardIntroDetail` tinyint NOT NULL,
  `cardMoreDetail` tinyint NOT NULL,
  `cardSeeDetails` tinyint NOT NULL,
  `categoryImage` tinyint NOT NULL,
  `categoryAltText` tinyint NOT NULL,
  `cardIOImage` tinyint NOT NULL,
  `cardIOAltText` tinyint NOT NULL,
  `cardButtonImage` tinyint NOT NULL,
  `cardButtonAltText` tinyint NOT NULL,
  `cardIOButtonAltText` tinyint NOT NULL,
  `cardIconSmall` tinyint NOT NULL,
  `cardIconMid` tinyint NOT NULL,
  `cardIconLarge` tinyint NOT NULL,
  `detailOrder` tinyint NOT NULL,
  `dateCreated` tinyint NOT NULL,
  `dateUpdated` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `cardListingString` tinyint NOT NULL,
  `cardPageHeaderString` tinyint NOT NULL,
  `imageAltText` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `specialsDescription` tinyint NOT NULL,
  `specialsAdditionalLink` tinyint NOT NULL,
  `cardTeaserText` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_exclusion_map`
--

DROP TABLE IF EXISTS `cms_card_exclusion_map`;
/*!50001 DROP VIEW IF EXISTS `cms_card_exclusion_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_exclusion_map` (
 `mapid` tinyint NOT NULL,
  `siteid` tinyint NOT NULL,
  `pageid` tinyint NOT NULL,
  `cardid` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_history`
--

DROP TABLE IF EXISTS `cms_card_history`;
/*!50001 DROP VIEW IF EXISTS `cms_card_history`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_history` (
 `campaigntype_id` tinyint NOT NULL,
  `dateinserted` tinyint NOT NULL,
  `campaigntype_name` tinyint NOT NULL,
  `intro_apr` tinyint NOT NULL,
  `delta_intro_apr` tinyint NOT NULL,
  `intro_apr_movement` tinyint NOT NULL,
  `intro_apr_period` tinyint NOT NULL,
  `delta_intro_apr_period` tinyint NOT NULL,
  `intro_apr_period_movement` tinyint NOT NULL,
  `regular_apr` tinyint NOT NULL,
  `delta_regular_apr` tinyint NOT NULL,
  `regular_apr_movement` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_page_map`
--

DROP TABLE IF EXISTS `cms_card_page_map`;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_page_map` (
 `cardcategorymapId` tinyint NOT NULL,
  `pageInsert` tinyint NOT NULL,
  `cardpageId` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_page_map_affiliate`
--

DROP TABLE IF EXISTS `cms_card_page_map_affiliate`;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map_affiliate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_page_map_affiliate` (
 `cardcategorymapId` tinyint NOT NULL,
  `pageInsert` tinyint NOT NULL,
  `cardpageId` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_page_map_bankrate`
--

DROP TABLE IF EXISTS `cms_card_page_map_bankrate`;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map_bankrate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_page_map_bankrate` (
 `cardcategorymapId` tinyint NOT NULL,
  `pageInsert` tinyint NOT NULL,
  `cardpageId` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_placement_history`
--

DROP TABLE IF EXISTS `cms_card_placement_history`;
/*!50001 DROP VIEW IF EXISTS `cms_card_placement_history`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_placement_history` (
 `cardpageId` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `rank` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `time_snapped` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_card_ranks`
--

DROP TABLE IF EXISTS `cms_card_ranks`;
/*!50001 DROP VIEW IF EXISTS `cms_card_ranks`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_card_ranks` (
 `card_rank_id` tinyint NOT NULL,
  `card_rank` tinyint NOT NULL,
  `card_category_context_id` tinyint NOT NULL,
  `card_category_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_cards`
--

DROP TABLE IF EXISTS `cms_cards`;
/*!50001 DROP VIEW IF EXISTS `cms_cards`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_cards` (
 `id` tinyint NOT NULL,
  `cardId` tinyint NOT NULL,
  `site_code` tinyint NOT NULL,
  `cardTitle` tinyint NOT NULL,
  `cardDescription` tinyint NOT NULL,
  `merchant` tinyint NOT NULL,
  `introApr` tinyint NOT NULL,
  `active_introApr` tinyint NOT NULL,
  `introAprPeriod` tinyint NOT NULL,
  `active_introAprPeriod` tinyint NOT NULL,
  `regularApr` tinyint NOT NULL,
  `variable` tinyint NOT NULL,
  `active_regularApr` tinyint NOT NULL,
  `annualFee` tinyint NOT NULL,
  `active_annualFee` tinyint NOT NULL,
  `monthlyFee` tinyint NOT NULL,
  `active_monthlyFee` tinyint NOT NULL,
  `balanceTransfers` tinyint NOT NULL,
  `active_balanceTransfers` tinyint NOT NULL,
  `balanceTransferFee` tinyint NOT NULL,
  `active_balanceTransferFee` tinyint NOT NULL,
  `balanceTransferIntroApr` tinyint NOT NULL,
  `active_balanceTransferIntroApr` tinyint NOT NULL,
  `balanceTransferIntroAprPeriod` tinyint NOT NULL,
  `active_balanceTransferIntroAprPeriod` tinyint NOT NULL,
  `creditNeeded` tinyint NOT NULL,
  `active_creditNeeded` tinyint NOT NULL,
  `imagePath` tinyint NOT NULL,
  `ratesAndFees` tinyint NOT NULL,
  `rewards` tinyint NOT NULL,
  `cardBenefits` tinyint NOT NULL,
  `onlineServices` tinyint NOT NULL,
  `footNotes` tinyint NOT NULL,
  `layout` tinyint NOT NULL,
  `dateCreated` tinyint NOT NULL,
  `dateUpdated` tinyint NOT NULL,
  `subCat` tinyint NOT NULL,
  `catTitle` tinyint NOT NULL,
  `catDescription` tinyint NOT NULL,
  `catImage` tinyint NOT NULL,
  `catImageAltText` tinyint NOT NULL,
  `syndicate` tinyint NOT NULL,
  `url` tinyint NOT NULL,
  `applyByPhoneNumber` tinyint NOT NULL,
  `tPageText` tinyint NOT NULL,
  `private` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `active_epd_pages` tinyint NOT NULL,
  `active_show_epd_rates` tinyint NOT NULL,
  `show_verify` tinyint NOT NULL,
  `commission_label` tinyint NOT NULL,
  `payout_cap` tinyint NOT NULL,
  `card_level_id` tinyint NOT NULL,
  `requires_approval` tinyint NOT NULL,
  `secured` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_merchant_service_details`
--

DROP TABLE IF EXISTS `cms_merchant_service_details`;
/*!50001 DROP VIEW IF EXISTS `cms_merchant_service_details`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_merchant_service_details` (
 `merchant_service_detail_id` tinyint NOT NULL,
  `merchant_service_id` tinyint NOT NULL,
  `merchant_service_detail_version` tinyint NOT NULL,
  `merchant_service_detail_label` tinyint NOT NULL,
  `category_image_path` tinyint NOT NULL,
  `category_image_alt_text` tinyint NOT NULL,
  `merchant_service_link` tinyint NOT NULL,
  `app_link` tinyint NOT NULL,
  `merchant_service_image_path` tinyint NOT NULL,
  `merchant_service_image_alt_text` tinyint NOT NULL,
  `apply_button_alt_text` tinyint NOT NULL,
  `merchant_service_header_string` tinyint NOT NULL,
  `merchant_service_detail_text` tinyint NOT NULL,
  `merchant_service_intro_detail` tinyint NOT NULL,
  `merchant_service_more_detail` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `date_created` tinyint NOT NULL,
  `date_updated` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_merchant_services`
--

DROP TABLE IF EXISTS `cms_merchant_services`;
/*!50001 DROP VIEW IF EXISTS `cms_merchant_services`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_merchant_services` (
 `merchant_service_id` tinyint NOT NULL,
  `merchant_service_name` tinyint NOT NULL,
  `url` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `setup_fee` tinyint NOT NULL,
  `active_setup_fee` tinyint NOT NULL,
  `monthly_minimum` tinyint NOT NULL,
  `active_monthly_minimum` tinyint NOT NULL,
  `gateway_fee` tinyint NOT NULL,
  `active_gateway_fee` tinyint NOT NULL,
  `statement_fee` tinyint NOT NULL,
  `active_statement_fee` tinyint NOT NULL,
  `discount_rate` tinyint NOT NULL,
  `active_discount_rate` tinyint NOT NULL,
  `transaction_fee` tinyint NOT NULL,
  `active_transaction_fee` tinyint NOT NULL,
  `tech_support_fee` tinyint NOT NULL,
  `active_tech_support_fee` tinyint NOT NULL,
  `date_created` tinyint NOT NULL,
  `date_updated` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_merchants`
--

DROP TABLE IF EXISTS `cms_merchants`;
/*!50001 DROP VIEW IF EXISTS `cms_merchants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_merchants` (
 `merchantid` tinyint NOT NULL,
  `merchantname` tinyint NOT NULL,
  `merchantcardpage` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_page_details`
--

DROP TABLE IF EXISTS `cms_page_details`;
/*!50001 DROP VIEW IF EXISTS `cms_page_details`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_page_details` (
 `id` tinyint NOT NULL,
  `pageDetailVersion` tinyint NOT NULL,
  `pageDetailLabel` tinyint NOT NULL,
  `cardpageId` tinyint NOT NULL,
  `pageTitle` tinyint NOT NULL,
  `pageIntroDescription` tinyint NOT NULL,
  `pageDescription` tinyint NOT NULL,
  `pageSpecial` tinyint NOT NULL,
  `pageMeta` tinyint NOT NULL,
  `pageLearnMore` tinyint NOT NULL,
  `pageDisclaimer` tinyint NOT NULL,
  `pageHeaderImage` tinyint NOT NULL,
  `pageHeaderImageAltText` tinyint NOT NULL,
  `pageSpecialOfferImage` tinyint NOT NULL,
  `pageSpecialOfferImageAltText` tinyint NOT NULL,
  `pageSpecialOfferLink` tinyint NOT NULL,
  `pageSmallImage` tinyint NOT NULL,
  `pageSmallImageAltText` tinyint NOT NULL,
  `dateCreated` tinyint NOT NULL,
  `dateUpdated` tinyint NOT NULL,
  `pageLink` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `pageHeaderString` tinyint NOT NULL,
  `primaryNavString` tinyint NOT NULL,
  `secondaryNavString` tinyint NOT NULL,
  `topPickAltText` tinyint NOT NULL,
  `flagTopPick` tinyint NOT NULL,
  `flagAdditionalOffer` tinyint NOT NULL,
  `associatedArticleCategory` tinyint NOT NULL,
  `articlesPerPage` tinyint NOT NULL,
  `enableSort` tinyint NOT NULL,
  `itemsPerPage` tinyint NOT NULL,
  `pageSeeAlso` tinyint NOT NULL,
  `siteMapDescription` tinyint NOT NULL,
  `siteMapTitle` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `sitemapLink` tinyint NOT NULL,
  `navBarString` tinyint NOT NULL,
  `subPageNav` tinyint NOT NULL,
  `landingPage` tinyint NOT NULL,
  `landingPageFid` tinyint NOT NULL,
  `landingPageImage` tinyint NOT NULL,
  `landingPageHeaderString` tinyint NOT NULL,
  `itemsOnFirstPage` tinyint NOT NULL,
  `showMainCatOnFirstPage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_page_site_map`
--

DROP TABLE IF EXISTS `cms_page_site_map`;
/*!50001 DROP VIEW IF EXISTS `cms_page_site_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_page_site_map` (
 `categoryPageMapId` tinyint NOT NULL,
  `cardpageId` tinyint NOT NULL,
  `categoryId` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_pages`
--

DROP TABLE IF EXISTS `cms_pages`;
/*!50001 DROP VIEW IF EXISTS `cms_pages`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_pages` (
 `cardpageId` tinyint NOT NULL,
  `pageName` tinyint NOT NULL,
  `pageType` tinyint NOT NULL,
  `contentType` tinyint NOT NULL,
  `alternate_tracking_flag` tinyint NOT NULL,
  `schumerType` tinyint NOT NULL,
  `dateCreated` tinyint NOT NULL,
  `dateUpdated` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `rollup` tinyint NOT NULL,
  `card_category_id` tinyint NOT NULL,
  `active_introApr` tinyint NOT NULL,
  `active_introAprPeriod` tinyint NOT NULL,
  `active_regularApr` tinyint NOT NULL,
  `active_annualFee` tinyint NOT NULL,
  `active_monthlyFee` tinyint NOT NULL,
  `active_balanceTransfers` tinyint NOT NULL,
  `active_balanceTransferFee` tinyint NOT NULL,
  `active_balanceTransferIntroApr` tinyint NOT NULL,
  `active_balanceTransferIntroAprPeriod` tinyint NOT NULL,
  `active_creditNeeded` tinyint NOT NULL,
  `active_transactionFeeSignature` tinyint NOT NULL,
  `active_transactionFeePin` tinyint NOT NULL,
  `active_atmFee` tinyint NOT NULL,
  `active_prepaidText` tinyint NOT NULL,
  `active_loadFee` tinyint NOT NULL,
  `active_activationFee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_subpage_page_map`
--

DROP TABLE IF EXISTS `cms_subpage_page_map`;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_subpage_page_map` (
 `mapid` tinyint NOT NULL,
  `siteid` tinyint NOT NULL,
  `masterpageid` tinyint NOT NULL,
  `subpageid` tinyint NOT NULL,
  `hide` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_subpage_page_map_affiliate`
--

DROP TABLE IF EXISTS `cms_subpage_page_map_affiliate`;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map_affiliate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_subpage_page_map_affiliate` (
 `mapid` tinyint NOT NULL,
  `siteid` tinyint NOT NULL,
  `masterpageid` tinyint NOT NULL,
  `subpageid` tinyint NOT NULL,
  `hide` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_subpage_page_map_bankrate`
--

DROP TABLE IF EXISTS `cms_subpage_page_map_bankrate`;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map_bankrate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_subpage_page_map_bankrate` (
 `mapid` tinyint NOT NULL,
  `siteid` tinyint NOT NULL,
  `masterpageid` tinyint NOT NULL,
  `subpageid` tinyint NOT NULL,
  `hide` tinyint NOT NULL,
  `rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cms_versions`
--

DROP TABLE IF EXISTS `cms_versions`;
/*!50001 DROP VIEW IF EXISTS `cms_versions`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cms_versions` (
 `version_id` tinyint NOT NULL,
  `version_name` tinyint NOT NULL,
  `version_description` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `insert_time` tinyint NOT NULL,
  `update_time` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `commission_report`
--

DROP TABLE IF EXISTS `commission_report`;
CREATE TABLE `commission_report` (
  `process_date` date NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `sales_total` int(11) DEFAULT '0',
  `commission_total` double(12,2) DEFAULT '0.00',
  `sales_received` int(11) DEFAULT NULL,
  `commission_received` double(12,2) DEFAULT NULL,
  `sales_paid` int(11) DEFAULT NULL,
  `commission_paid` double(12,2) DEFAULT NULL,
  `sales_declined` int(11) DEFAULT NULL,
  `commission_declined` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`process_date`,`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `commission_summary`
--

DROP TABLE IF EXISTS `commission_summary`;
CREATE TABLE `commission_summary` (
  `affiliate_id` varchar(50) NOT NULL DEFAULT '',
  `website_id` int(11) NOT NULL DEFAULT '0',
  `card_id` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `clickCount` int(11) NOT NULL DEFAULT '0',
  `applicationSalesCount` int(11) NOT NULL DEFAULT '0',
  `crossSaleCount` int(11) NOT NULL DEFAULT '0',
  `approvalSalesCount` int(11) NOT NULL DEFAULT '0',
  `salesClickCommission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `nonSalesClickCommission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `totalcommission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `totalAdjustment` decimal(24,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`date`,`affiliate_id`,`website_id`,`card_id`),
  KEY `idx_affiliateid` (`affiliate_id`),
  KEY `idx_websiteid` (`website_id`),
  KEY `idx_cardid` (`card_id`),
  KEY `idx_date` (`date`)
) TYPE=InnoDB;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) NOT NULL,
  PRIMARY KEY (`company_id`)
) TYPE=MyISAM;

--
-- Table structure for table `completed_applications`
--

DROP TABLE IF EXISTS `completed_applications`;
CREATE TABLE `completed_applications` (
  `completed_application_id` varchar(36) NOT NULL,
  `transaction_id` varchar(36) NOT NULL,
  `date_inserted` datetime NOT NULL,
  PRIMARY KEY (`completed_application_id`),
  KEY `idx_transaction_id` (`transaction_id`),
  KEY `idx_date_inserted` (`date_inserted`)
) TYPE=MyISAM;

--
-- Temporary table structure for view `cp_authors`
--

DROP TABLE IF EXISTS `cp_authors`;
/*!50001 DROP VIEW IF EXISTS `cp_authors`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_authors` (
 `author_id` tinyint NOT NULL,
  `first_name` tinyint NOT NULL,
  `last_name` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `business_name` tinyint NOT NULL,
  `author_page_link` tinyint NOT NULL,
  `external_profile_link` tinyint NOT NULL,
  `author_photo_location` tinyint NOT NULL,
  `author_page_site_content_id` tinyint NOT NULL,
  `local_author_page_filename` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_document_groups`
--

DROP TABLE IF EXISTS `cp_document_groups`;
/*!50001 DROP VIEW IF EXISTS `cp_document_groups`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_document_groups` (
 `id` tinyint NOT NULL,
  `document_group` tinyint NOT NULL,
  `document` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_documentgroup_names`
--

DROP TABLE IF EXISTS `cp_documentgroup_names`;
/*!50001 DROP VIEW IF EXISTS `cp_documentgroup_names`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_documentgroup_names` (
 `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `private_memgroup` tinyint NOT NULL,
  `private_webgroup` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `index_page_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_glossary`
--

DROP TABLE IF EXISTS `cp_glossary`;
/*!50001 DROP VIEW IF EXISTS `cp_glossary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_glossary` (
 `id` tinyint NOT NULL,
  `term` tinyint NOT NULL,
  `definition` tinyint NOT NULL,
  `disabled` tinyint NOT NULL,
  `createdon` tinyint NOT NULL,
  `editedon` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_homepage_module`
--

DROP TABLE IF EXISTS `cp_homepage_module`;
/*!50001 DROP VIEW IF EXISTS `cp_homepage_module`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_homepage_module` (
 `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `caption` tinyint NOT NULL,
  `related` tinyint NOT NULL,
  `story` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_membergroup_access`
--

DROP TABLE IF EXISTS `cp_membergroup_access`;
/*!50001 DROP VIEW IF EXISTS `cp_membergroup_access`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_membergroup_access` (
 `id` tinyint NOT NULL,
  `membergroup` tinyint NOT NULL,
  `documentgroup` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_membergroup_names`
--

DROP TABLE IF EXISTS `cp_membergroup_names`;
/*!50001 DROP VIEW IF EXISTS `cp_membergroup_names`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_membergroup_names` (
 `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `aff_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_site_content`
--

DROP TABLE IF EXISTS `cp_site_content`;
/*!50001 DROP VIEW IF EXISTS `cp_site_content`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_site_content` (
 `id` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `contentType` tinyint NOT NULL,
  `author` tinyint NOT NULL,
  `pagetitle` tinyint NOT NULL,
  `longtitle` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `alias` tinyint NOT NULL,
  `link_attributes` tinyint NOT NULL,
  `published` tinyint NOT NULL,
  `publish_to_affiliates` tinyint NOT NULL,
  `publish_to_cccom` tinyint NOT NULL,
  `pub_date` tinyint NOT NULL,
  `unpub_date` tinyint NOT NULL,
  `repub_date` tinyint NOT NULL,
  `parent` tinyint NOT NULL,
  `isfolder` tinyint NOT NULL,
  `introtext` tinyint NOT NULL,
  `content` tinyint NOT NULL,
  `richtext` tinyint NOT NULL,
  `template` tinyint NOT NULL,
  `menuindex` tinyint NOT NULL,
  `searchable` tinyint NOT NULL,
  `cacheable` tinyint NOT NULL,
  `createdby` tinyint NOT NULL,
  `createdon` tinyint NOT NULL,
  `editedby` tinyint NOT NULL,
  `editedon` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `deletedon` tinyint NOT NULL,
  `deletedby` tinyint NOT NULL,
  `publishedon` tinyint NOT NULL,
  `publishedby` tinyint NOT NULL,
  `menutitle` tinyint NOT NULL,
  `donthit` tinyint NOT NULL,
  `haskeywords` tinyint NOT NULL,
  `hasmetatags` tinyint NOT NULL,
  `privateweb` tinyint NOT NULL,
  `privatemgr` tinyint NOT NULL,
  `content_dispo` tinyint NOT NULL,
  `hidemenu` tinyint NOT NULL,
  `pageid` tinyint NOT NULL,
  `story_keywords` tinyint NOT NULL,
  `homepage_headline` tinyint NOT NULL,
  `homepage_summary` tinyint NOT NULL,
  `homepage_thumb` tinyint NOT NULL,
  `homepage_alt` tinyint NOT NULL,
  `homepage_linktext` tinyint NOT NULL,
  `homepage_image_external` tinyint NOT NULL,
  `pubgroup` tinyint NOT NULL,
  `maincategory` tinyint NOT NULL,
  `archived` tinyint NOT NULL,
  `temp_wp_post_id` tinyint NOT NULL,
  `notes` tinyint NOT NULL,
  `actual_page_title` tinyint NOT NULL,
  `approved` tinyint NOT NULL,
  `invoiced` tinyint NOT NULL,
  `invoiced_amount` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_site_htmlsnippets`
--

DROP TABLE IF EXISTS `cp_site_htmlsnippets`;
/*!50001 DROP VIEW IF EXISTS `cp_site_htmlsnippets`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_site_htmlsnippets` (
 `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `editor_type` tinyint NOT NULL,
  `category` tinyint NOT NULL,
  `cache_type` tinyint NOT NULL,
  `snippet` tinyint NOT NULL,
  `locked` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cp_story_authors`
--

DROP TABLE IF EXISTS `cp_story_authors`;
/*!50001 DROP VIEW IF EXISTS `cp_story_authors`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cp_story_authors` (
 `story_id` tinyint NOT NULL,
  `author_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `credit_card_checkup`
--

DROP TABLE IF EXISTS `credit_card_checkup`;
CREATE TABLE `credit_card_checkup` (
  `checkup_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` varchar(10) NOT NULL,
  `external_visit_id` varchar(32) NOT NULL,
  `credit_card_name` varchar(255) NOT NULL,
  `interest_rate` decimal(10,2) NOT NULL,
  `annual_fee` decimal(10,2) NOT NULL,
  `amount_owed` decimal(10,2) NOT NULL,
  `monthly_charged` decimal(10,2) NOT NULL,
  `monthly_paid` decimal(10,2) NOT NULL,
  `credit_quality` enum('excellent','good','fair','bad','no_history') DEFAULT NULL,
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`checkup_id`,`server_id`)
) TYPE=InnoDB AUTO_INCREMENT=5019;

--
-- Table structure for table `declined_applications`
--

DROP TABLE IF EXISTS `declined_applications`;
CREATE TABLE `declined_applications` (
  `declined_application_id` int(11) NOT NULL AUTO_INCREMENT,
  `error_code` int(11) DEFAULT NULL,
  `transaction_id` varchar(30) DEFAULT NULL COMMENT 'joins to transid in the transactions tables',
  `upload_file_id` int(11) DEFAULT NULL COMMENT 'Joins to upload_files.upload_file_id',
  `provider_process_time` datetime DEFAULT NULL,
  `state` enum('COMMITTED','DELETED','ERROR','VALID') DEFAULT NULL,
  `update_time` timestamp NOT NULL,
  PRIMARY KEY (`declined_application_id`),
  KEY `idx_trans_id` (`transaction_id`),
  KEY `idx_upload_file_id` (`upload_file_id`),
  KEY `idx_update_time` (`update_time`),
  KEY `error_code` (`error_code`),
  CONSTRAINT `declined_applications_ibfk_1` FOREIGN KEY (`error_code`) REFERENCES `error_codes` (`error_code`)
) TYPE=InnoDB AUTO_INCREMENT=1023816;

--
-- Table structure for table `epc_change_transactions`
--

DROP TABLE IF EXISTS `epc_change_transactions`;
CREATE TABLE `epc_change_transactions` (
  `epc_change_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `insert_time` datetime NOT NULL,
  `note` text,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`epc_change_transaction_id`),
  KEY `IDX_CARD_PAGE` (`page_fid`,`card_id`),
  KEY `idx_insert_time` (`insert_time`)
) TYPE=InnoDB AUTO_INCREMENT=4755;

--
-- Table structure for table `epc_change_transactions_sem`
--

DROP TABLE IF EXISTS `epc_change_transactions_sem`;
CREATE TABLE `epc_change_transactions_sem` (
  `epc_change_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_fid` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `insert_time` datetime NOT NULL,
  `note` text,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`epc_change_transaction_id`),
  KEY `IDX_CARD_PAGE` (`page_fid`,`card_id`),
  KEY `idx_insert_time` (`insert_time`)
) TYPE=InnoDB AUTO_INCREMENT=4666;

--
-- Table structure for table `epc_changes`
--

DROP TABLE IF EXISTS `epc_changes`;
CREATE TABLE `epc_changes` (
  `epc_change_id` int(11) NOT NULL AUTO_INCREMENT,
  `epc_change_transaction_id` int(11) NOT NULL,
  `column_changed` varchar(255) NOT NULL,
  `before_value` varchar(255) DEFAULT NULL,
  `after_value` varchar(255) NOT NULL,
  PRIMARY KEY (`epc_change_id`),
  KEY `IDX_TRANS` (`epc_change_transaction_id`),
  CONSTRAINT `epc_changes_ibfk_1` FOREIGN KEY (`epc_change_transaction_id`) REFERENCES `epc_change_transactions` (`epc_change_transaction_id`)
) TYPE=InnoDB AUTO_INCREMENT=12532;

--
-- Table structure for table `epc_changes_sem`
--

DROP TABLE IF EXISTS `epc_changes_sem`;
CREATE TABLE `epc_changes_sem` (
  `epc_change_id` int(11) NOT NULL AUTO_INCREMENT,
  `epc_change_transaction_id` int(11) NOT NULL,
  `column_changed` varchar(255) NOT NULL,
  `before_value` varchar(255) DEFAULT NULL,
  `after_value` varchar(255) NOT NULL,
  PRIMARY KEY (`epc_change_id`),
  KEY `IDX_TRANS` (`epc_change_transaction_id`)
) TYPE=InnoDB AUTO_INCREMENT=2;

--
-- Table structure for table `error_codes`
--

DROP TABLE IF EXISTS `error_codes`;
CREATE TABLE `error_codes` (
  `error_code` int(11) NOT NULL,
  `error_type_id` int(11) NOT NULL COMMENT 'FK to error_types.error_type_id',
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`error_code`,`error_type_id`),
  KEY `error_type_id` (`error_type_id`),
  CONSTRAINT `error_codes_ibfk_1` FOREIGN KEY (`error_type_id`) REFERENCES `error_types` (`error_type_id`)
) TYPE=InnoDB;

--
-- Table structure for table `error_types`
--

DROP TABLE IF EXISTS `error_types`;
CREATE TABLE `error_types` (
  `error_type_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`error_type_id`)
) TYPE=InnoDB;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id of entry',
  `date_inserted` timestamp NOT NULL COMMENT 'Date entry was made',
  `activity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Activity of Responder',
  `date_initiated` datetime DEFAULT NULL COMMENT 'Date that the beacon was initiated',
  `resp_account_id` varchar(20) NOT NULL,
  `location_id` varchar(100) DEFAULT NULL COMMENT 'identifier for the location placed',
  `campaign_id` varchar(50) NOT NULL,
  `environment` varchar(10) NOT NULL,
  `beacon_type` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) TYPE=InnoDB AUTO_INCREMENT=11;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `expense_id` varchar(10) NOT NULL DEFAULT '0',
  `purchase_time` datetime DEFAULT NULL,
  `expense_start` datetime DEFAULT NULL,
  `expense_end` datetime DEFAULT NULL,
  `total_expense` double(15,2) DEFAULT NULL,
  `affiliate_id` varchar(8) DEFAULT NULL,
  `extcampaign_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`expense_id`),
  KEY `idx_expenses1` (`affiliate_id`),
  KEY `idx_expenses2` (`extcampaign_id`),
  KEY `idx_expenses3` (`keyword_id`)
) TYPE=MyISAM;

--
-- Table structure for table `expenses_networks`
--

DROP TABLE IF EXISTS `expenses_networks`;
CREATE TABLE `expenses_networks` (
  `affiliate_id` varchar(8) NOT NULL,
  `directory` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `expenses_upload`
--

DROP TABLE IF EXISTS `expenses_upload`;
CREATE TABLE `expenses_upload` (
  `expense_id` varchar(10) NOT NULL DEFAULT '0',
  `purchase_time` datetime DEFAULT NULL,
  `expense_start` datetime DEFAULT NULL,
  `expense_end` datetime DEFAULT NULL,
  `total_expense` double(15,2) DEFAULT NULL,
  `affiliate_id` varchar(8) DEFAULT NULL,
  `extcampaign_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`expense_id`)
) TYPE=MyISAM;

--
-- Table structure for table `expenses_upload_errors`
--

DROP TABLE IF EXISTS `expenses_upload_errors`;
CREATE TABLE `expenses_upload_errors` (
  `expense_id` varchar(10) NOT NULL DEFAULT '0',
  `purchase_time` datetime DEFAULT NULL,
  `expense_start` datetime DEFAULT NULL,
  `expense_end` datetime DEFAULT NULL,
  `total_expense` double(15,2) DEFAULT NULL,
  `affiliate_id` varchar(8) DEFAULT NULL,
  `extcampaign_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `error_time` datetime DEFAULT NULL,
  PRIMARY KEY (`expense_id`)
) TYPE=MyISAM;

--
-- Table structure for table `external_visits`
--

DROP TABLE IF EXISTS `external_visits`;
CREATE TABLE `external_visits` (
  `external_visit_id` varchar(32) NOT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `affiliate_id` varchar(32) DEFAULT NULL,
  `ad_id` varchar(32) DEFAULT NULL,
  `external_campaign_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  `landing_page_id` int(11) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `cccid` varchar(50) DEFAULT NULL,
  `curref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `ref_inception_date` datetime DEFAULT NULL,
  `new_visitor` tinyint(1) DEFAULT '0',
  `forwarding_ip` varchar(40) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `external_ad_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`external_visit_id`),
  KEY `IDX_affiliate_id` (`affiliate_id`),
  KEY `IDX_landing_page_id` (`landing_page_id`),
  KEY `IDX_insert_time` (`insert_time`),
  KEY `IDX_cccid` (`cccid`),
  KEY `IDX_new_visitor` (`new_visitor`),
  KEY `IDX_ad_id` (`ad_id`),
  KEY `IDX_extcampaign_id` (`external_campaign_id`),
  KEY `IDX_keyword_id` (`keyword_id`),
  KEY `idx_external_visits_ip` (`ip`),
  KEY `ext_ad_id_idx` (`external_ad_id`)
) TYPE=MyISAM;

--
-- Table structure for table `external_visits_debug`
--

DROP TABLE IF EXISTS `external_visits_debug`;
CREATE TABLE `external_visits_debug` (
  `external_visit_id` varchar(32) NOT NULL,
  `external_campaign_id` varchar(200) DEFAULT NULL,
  `keyword_id` varchar(200) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  PRIMARY KEY (`external_visit_id`),
  KEY `idx_insert_time` (`insert_time`)
) TYPE=MyISAM;

--
-- Table structure for table `external_visits_filtered`
--

DROP TABLE IF EXISTS `external_visits_filtered`;
CREATE TABLE `external_visits_filtered` (
  `external_visit_id` varchar(32) NOT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `affiliate_id` varchar(32) DEFAULT NULL,
  `ad_id` varchar(32) DEFAULT NULL,
  `external_campaign_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  `landing_page_id` int(11) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `cccid` varchar(50) DEFAULT NULL,
  `curref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `ref_inception_date` datetime DEFAULT NULL,
  `new_visitor` tinyint(1) DEFAULT '0',
  `forwarding_ip` varchar(40) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `external_ad_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`external_visit_id`),
  KEY `IDX_affiliate_id` (`affiliate_id`),
  KEY `IDX_landing_page_id` (`landing_page_id`),
  KEY `IDX_insert_time` (`insert_time`),
  KEY `IDX_cccid` (`cccid`),
  KEY `IDX_new_visitor` (`new_visitor`),
  KEY `IDX_ad_id` (`ad_id`),
  KEY `IDX_extcampaign_id` (`external_campaign_id`),
  KEY `IDX_keyword_id` (`keyword_id`),
  KEY `idx_external_visits_ip` (`ip`),
  KEY `ext_ad_id_fil_idx` (`external_ad_id`)
) TYPE=MyISAM;

--
-- Table structure for table `gacl_acl`
--

DROP TABLE IF EXISTS `gacl_acl`;
CREATE TABLE `gacl_acl` (
  `id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT 'system',
  `allow` int(11) NOT NULL DEFAULT '0',
  `enabled` int(11) NOT NULL DEFAULT '0',
  `return_value` text,
  `note` text,
  `updated_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gacl_enabled_acl` (`enabled`),
  KEY `gacl_section_value_acl` (`section_value`),
  KEY `gacl_updated_date_acl` (`updated_date`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_acl_sections`
--

DROP TABLE IF EXISTS `gacl_acl_sections`;
CREATE TABLE `gacl_acl_sections` (
  `id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_value_acl_sections` (`value`),
  KEY `gacl_hidden_acl_sections` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_acl_sections_seq`
--

DROP TABLE IF EXISTS `gacl_acl_sections_seq`;
CREATE TABLE `gacl_acl_sections_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_acl_seq`
--

DROP TABLE IF EXISTS `gacl_acl_seq`;
CREATE TABLE `gacl_acl_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aco`
--

DROP TABLE IF EXISTS `gacl_aco`;
CREATE TABLE `gacl_aco` (
  `id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_section_value_value_aco` (`section_value`,`value`),
  KEY `gacl_hidden_aco` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aco_map`
--

DROP TABLE IF EXISTS `gacl_aco_map`;
CREATE TABLE `gacl_aco_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aco_sections`
--

DROP TABLE IF EXISTS `gacl_aco_sections`;
CREATE TABLE `gacl_aco_sections` (
  `id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_value_aco_sections` (`value`),
  KEY `gacl_hidden_aco_sections` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aco_sections_seq`
--

DROP TABLE IF EXISTS `gacl_aco_sections_seq`;
CREATE TABLE `gacl_aco_sections_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aco_seq`
--

DROP TABLE IF EXISTS `gacl_aco_seq`;
CREATE TABLE `gacl_aco_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro`
--

DROP TABLE IF EXISTS `gacl_aro`;
CREATE TABLE `gacl_aro` (
  `id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_section_value_value_aro` (`section_value`,`value`),
  KEY `gacl_hidden_aro` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_groups`
--

DROP TABLE IF EXISTS `gacl_aro_groups`;
CREATE TABLE `gacl_aro_groups` (
  `id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`value`),
  UNIQUE KEY `gacl_value_aro_groups` (`value`),
  KEY `gacl_parent_id_aro_groups` (`parent_id`),
  KEY `gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_groups_id_seq`
--

DROP TABLE IF EXISTS `gacl_aro_groups_id_seq`;
CREATE TABLE `gacl_aro_groups_id_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_groups_map`
--

DROP TABLE IF EXISTS `gacl_aro_groups_map`;
CREATE TABLE `gacl_aro_groups_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`acl_id`,`group_id`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_map`
--

DROP TABLE IF EXISTS `gacl_aro_map`;
CREATE TABLE `gacl_aro_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_sections`
--

DROP TABLE IF EXISTS `gacl_aro_sections`;
CREATE TABLE `gacl_aro_sections` (
  `id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_value_aro_sections` (`value`),
  KEY `gacl_hidden_aro_sections` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_sections_seq`
--

DROP TABLE IF EXISTS `gacl_aro_sections_seq`;
CREATE TABLE `gacl_aro_sections_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_aro_seq`
--

DROP TABLE IF EXISTS `gacl_aro_seq`;
CREATE TABLE `gacl_aro_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo`
--

DROP TABLE IF EXISTS `gacl_axo`;
CREATE TABLE `gacl_axo` (
  `id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_section_value_value_axo` (`section_value`,`value`),
  KEY `gacl_hidden_axo` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_groups`
--

DROP TABLE IF EXISTS `gacl_axo_groups`;
CREATE TABLE `gacl_axo_groups` (
  `id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`value`),
  UNIQUE KEY `gacl_value_axo_groups` (`value`),
  KEY `gacl_parent_id_axo_groups` (`parent_id`),
  KEY `gacl_lft_rgt_axo_groups` (`lft`,`rgt`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_groups_id_seq`
--

DROP TABLE IF EXISTS `gacl_axo_groups_id_seq`;
CREATE TABLE `gacl_axo_groups_id_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_groups_map`
--

DROP TABLE IF EXISTS `gacl_axo_groups_map`;
CREATE TABLE `gacl_axo_groups_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`acl_id`,`group_id`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_map`
--

DROP TABLE IF EXISTS `gacl_axo_map`;
CREATE TABLE `gacl_axo_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_sections`
--

DROP TABLE IF EXISTS `gacl_axo_sections`;
CREATE TABLE `gacl_axo_sections` (
  `id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(230) NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `gacl_value_axo_sections` (`value`),
  KEY `gacl_hidden_axo_sections` (`hidden`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_sections_seq`
--

DROP TABLE IF EXISTS `gacl_axo_sections_seq`;
CREATE TABLE `gacl_axo_sections_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_axo_seq`
--

DROP TABLE IF EXISTS `gacl_axo_seq`;
CREATE TABLE `gacl_axo_seq` (
  `id` int(11) NOT NULL
) TYPE=InnoDB;

--
-- Table structure for table `gacl_groups_aro_map`
--

DROP TABLE IF EXISTS `gacl_groups_aro_map`;
CREATE TABLE `gacl_groups_aro_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `aro_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`aro_id`),
  KEY `gacl_aro_id` (`aro_id`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_groups_axo_map`
--

DROP TABLE IF EXISTS `gacl_groups_axo_map`;
CREATE TABLE `gacl_groups_axo_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `axo_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`axo_id`),
  KEY `gacl_axo_id` (`axo_id`)
) TYPE=InnoDB;

--
-- Table structure for table `gacl_phpgacl`
--

DROP TABLE IF EXISTS `gacl_phpgacl`;
CREATE TABLE `gacl_phpgacl` (
  `name` varchar(230) NOT NULL,
  `value` varchar(230) NOT NULL,
  PRIMARY KEY (`name`)
) TYPE=InnoDB;

--
-- Table structure for table `impressions`
--

DROP TABLE IF EXISTS `impressions`;
CREATE TABLE `impressions` (
  `impressionid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `dateimpression` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bannerid` varchar(20) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `all_imps_count` int(11) DEFAULT '0',
  `unique_imps_count` int(11) DEFAULT '0',
  `commissiongiven` tinyint(4) NOT NULL DEFAULT '0',
  `data1` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`impressionid`),
  KEY `IDX_pa_impressions_3` (`bannerid`,`affiliateid`,`dateimpression`),
  KEY `IDX_wd_pa_impressions3` (`affiliateid`),
  KEY `idx_dateimpression` (`dateimpression`)
) TYPE=MyISAM;

--
-- Table structure for table `keyword_text`
--

DROP TABLE IF EXISTS `keyword_text`;
CREATE TABLE `keyword_text` (
  `keyword_text_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_text` varchar(255) NOT NULL,
  `insert_time` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_text_id`),
  UNIQUE KEY `keyword_text` (`keyword_text`)
) TYPE=MyISAM AUTO_INCREMENT=97758;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_text_id` int(11) NOT NULL,
  `keyword_type` enum('Broad','Exact','BroadModified','Phrase') NOT NULL DEFAULT 'Exact',
  `insert_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_id`),
  UNIQUE KEY `idx_uk1` (`keyword_text_id`,`keyword_type`)
) TYPE=MyISAM AUTO_INCREMENT=158247;

--
-- Table structure for table `merchant_service_details`
--

DROP TABLE IF EXISTS `merchant_service_details`;
CREATE TABLE `merchant_service_details` (
  `merchant_service_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_service_id` int(11) DEFAULT NULL,
  `merchant_service_detail_version` int(11) NOT NULL DEFAULT '-1',
  `merchant_service_detail_label` varchar(50) DEFAULT NULL,
  `category_image_path` varchar(100) DEFAULT NULL,
  `category_image_alt_text` varchar(100) DEFAULT NULL,
  `merchant_service_link` varchar(100) DEFAULT NULL,
  `app_link` varchar(100) DEFAULT NULL,
  `merchant_service_image_path` varchar(50) DEFAULT NULL,
  `merchant_service_image_alt_text` varchar(100) DEFAULT NULL,
  `apply_button_alt_text` varchar(100) DEFAULT NULL,
  `merchant_service_header_string` varchar(100) DEFAULT NULL,
  `merchant_service_detail_text` blob,
  `merchant_service_intro_detail` blob,
  `merchant_service_more_detail` blob,
  `fid` int(10) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`merchant_service_detail_id`)
) TYPE=MyISAM AUTO_INCREMENT=34;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue_id` int(10) unsigned NOT NULL,
  `handle` char(32) DEFAULT NULL,
  `body` varchar(8192) NOT NULL,
  `md5` char(32) NOT NULL,
  `timeout` decimal(14,4) unsigned DEFAULT NULL,
  `created` int(10) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  UNIQUE KEY `message_handle` (`handle`),
  KEY `message_queueid` (`queue_id`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`queue_id`) REFERENCES `queue` (`queue_id`) ON DELETE CASCADE ON UPDATE CASCADE
) TYPE=InnoDB AUTO_INCREMENT=2744;

--
-- Table structure for table `ncs_affiliate_rep_map`
--

DROP TABLE IF EXISTS `ncs_affiliate_rep_map`;
CREATE TABLE `ncs_affiliate_rep_map` (
  `ncs_affiliate_rep_id` int(11) DEFAULT NULL,
  `cccom_affiliate_rep_id` int(11) DEFAULT NULL,
  KEY `idx_ncsaffiliaterepid` (`ncs_affiliate_rep_id`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_base_payouts_tmp`
--

DROP TABLE IF EXISTS `ncs_base_payouts_tmp`;
CREATE TABLE `ncs_base_payouts_tmp` (
  `card_id` int(11) NOT NULL DEFAULT '0',
  `card_name` varchar(256) DEFAULT NULL,
  `paygroupname` varchar(256) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `paytype` varchar(50) DEFAULT '',
  `mpo` float DEFAULT '0',
  `affmpo` float DEFAULT '0',
  `commission` float DEFAULT '0'
) TYPE=MyISAM;

--
-- Table structure for table `ncs_card_map`
--

DROP TABLE IF EXISTS `ncs_card_map`;
CREATE TABLE `ncs_card_map` (
  `cccom_cardId` varchar(20) NOT NULL DEFAULT '',
  `ncs_OfferId` int(11) NOT NULL,
  PRIMARY KEY (`cccom_cardId`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_category_map`
--

DROP TABLE IF EXISTS `ncs_category_map`;
CREATE TABLE `ncs_category_map` (
  `category_map_id` int(11) NOT NULL AUTO_INCREMENT,
  `cccom_category_id` int(11) NOT NULL,
  `ncs_category_id` int(11) NOT NULL,
  `br_category_id` int(11) DEFAULT NULL,
  `cccom_exit_page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_map_id`),
  UNIQUE KEY `ncs` (`ncs_category_id`)
) TYPE=InnoDB AUTO_INCREMENT=43;

--
-- Table structure for table `ncs_category_offer_map`
--

DROP TABLE IF EXISTS `ncs_category_offer_map`;
CREATE TABLE `ncs_category_offer_map` (
  `ncs_category_id` int(11) DEFAULT NULL,
  `category_name` varchar(1000) DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  `ncs_category_type` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `br_rank` int(11) DEFAULT NULL,
  `statusid` int(11) DEFAULT NULL
) TYPE=InnoDB;

--
-- Table structure for table `ncs_cms_alternate_links`
--

DROP TABLE IF EXISTS `ncs_cms_alternate_links`;
CREATE TABLE `ncs_cms_alternate_links` (
  `affiliate_id` varchar(8) NOT NULL,
  `clickable_id` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `website_id` int(11) NOT NULL DEFAULT '0',
  `sub_account_id` int(11) DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL
) TYPE=MyISAM;

--
-- Table structure for table `ncs_cms_card_page_map`
--

DROP TABLE IF EXISTS `ncs_cms_card_page_map`;
CREATE TABLE `ncs_cms_card_page_map` (
  `pageInsert` int(11) DEFAULT '0',
  `cardpageId` int(11) DEFAULT '0',
  `cardId` int(11) DEFAULT '0',
  `rank` int(11) DEFAULT NULL,
  `ncs_category_id` int(11) DEFAULT '0',
  `ncs_Offer_id` int(11) DEFAULT '0',
  `offer_name` varchar(1000) DEFAULT '',
  `ncs_rank` int(11) DEFAULT '9999',
  `bankrate_rank` int(11) DEFAULT '9999',
  `status_id` int(11) DEFAULT '2',
  `modify_date` datetime DEFAULT '1970-01-01 00:00:00'
) TYPE=InnoDB;

--
-- Table structure for table `ncs_cms_card_page_map_bankrate`
--

DROP TABLE IF EXISTS `ncs_cms_card_page_map_bankrate`;
CREATE TABLE `ncs_cms_card_page_map_bankrate` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `pageInsert` int(1) DEFAULT '0',
  `cardpageId` int(10) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`),
  UNIQUE KEY `IDX_cardpage` (`cardpageId`,`cardId`)
) TYPE=InnoDB AUTO_INCREMENT=5181;

--
-- Table structure for table `ncs_partner_affiliate_card_commissions`
--

DROP TABLE IF EXISTS `ncs_partner_affiliate_card_commissions`;
CREATE TABLE `ncs_partner_affiliate_card_commissions` (
  `affiliate_card_commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `commission_amount` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `creator_user_id` int(11) NOT NULL,
  `time_created` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `payout_type` varchar(50) DEFAULT NULL,
  `ncs_offerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_card_commission_id`)
) TYPE=InnoDB AUTO_INCREMENT=100001;

--
-- Table structure for table `ncs_partner_affiliate_representatives`
--

DROP TABLE IF EXISTS `ncs_partner_affiliate_representatives`;
CREATE TABLE `ncs_partner_affiliate_representatives` (
  `affiliate_representative_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `phone_extension` varchar(5) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ncs_staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_representative_id`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_partner_affiliate_solutions_map`
--

DROP TABLE IF EXISTS `ncs_partner_affiliate_solutions_map`;
CREATE TABLE `ncs_partner_affiliate_solutions_map` (
  `affiliate_id` varchar(8) NOT NULL,
  `solution_id` smallint(5) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `version_id` int(11) DEFAULT '-1',
  `request_date` datetime NOT NULL,
  `disposition_date` datetime DEFAULT NULL
) TYPE=InnoDB;

--
-- Table structure for table `ncs_partner_affiliates`
--

DROP TABLE IF EXISTS `ncs_partner_affiliates`;
CREATE TABLE `ncs_partner_affiliates` (
  `affiliate_id` varchar(8) NOT NULL,
  `account_id` int(11) NOT NULL,
  `affiliate_type` enum('PARTNER','TRAFFIC_SOURCE') NOT NULL,
  `ref_id` varchar(8) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `affiliate_representative_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `address2` varchar(60) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `billing_first_name` varchar(255) DEFAULT NULL,
  `billing_last_name` varchar(255) DEFAULT NULL,
  `billing_company_name` varchar(255) DEFAULT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(60) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(10) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `referral_type` tinyint(1) DEFAULT NULL,
  `referral_detail` varchar(255) DEFAULT NULL,
  `tax` varchar(255) NOT NULL,
  `status` enum('ACTIVE','DECLINED','INACTIVE','PENDING','APPROVED') NOT NULL,
  `commission_rate_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `payout_threshold` double NOT NULL,
  `payout_name` varchar(255) NOT NULL,
  `ip` int(10) unsigned DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `restricted` tinyint(1) NOT NULL DEFAULT '0',
  `in_house` tinyint(1) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `ncs_staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`),
  UNIQUE KEY `idx_ref_id` (`ref_id`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_partner_card_affiliate_map`
--

DROP TABLE IF EXISTS `ncs_partner_card_affiliate_map`;
CREATE TABLE `ncs_partner_card_affiliate_map` (
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `status` enum('APPROVED','PENDING','DECLINED') NOT NULL,
  `date_requested` date DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `time_approved` datetime DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_partner_card_website_map`
--

DROP TABLE IF EXISTS `ncs_partner_card_website_map`;
CREATE TABLE `ncs_partner_card_website_map` (
  `website_id` int(11) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `approver_user_id` int(11) NOT NULL,
  `time_approved` datetime NOT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`website_id`,`card_id`),
  KEY `idx_2` (`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_partner_communication_affiliate_map`
--

DROP TABLE IF EXISTS `ncs_partner_communication_affiliate_map`;
CREATE TABLE `ncs_partner_communication_affiliate_map` (
  `communication_id` int(11) NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `news_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`communication_id`,`affiliate_id`,`news_id`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_partner_communications`
--

DROP TABLE IF EXISTS `ncs_partner_communications`;
CREATE TABLE `ncs_partner_communications` (
  `communication_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `body_type` enum('HTML','TEXT') NOT NULL DEFAULT 'TEXT',
  `communication_type` enum('ANNOUNCEMENT','AUTO_MESSAGE','MESSAGE','NEWS','NEWSLETTER') NOT NULL,
  `newsletter_id` int(10) unsigned DEFAULT NULL,
  `time_created` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ncs_comm_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`communication_id`),
  KEY `idx_NewsLetterId` (`newsletter_id`)
) TYPE=MyISAM AUTO_INCREMENT=1253;

--
-- Table structure for table `ncs_partner_notes`
--

DROP TABLE IF EXISTS `ncs_partner_notes`;
CREATE TABLE `ncs_partner_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `entity_type` enum('AFFILIATE','ISSUER','USER','WEBSITE') NOT NULL,
  `entity_id` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `text` text,
  `date_created` timestamp NOT NULL,
  `created_by_user_username` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`)
) TYPE=InnoDB AUTO_INCREMENT=67872;

--
-- Table structure for table `ncs_partner_product_creatives`
--

DROP TABLE IF EXISTS `ncs_partner_product_creatives`;
CREATE TABLE `ncs_partner_product_creatives` (
  `product_creative_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(20) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `data` text NOT NULL,
  `text_type_id` tinyint(4) DEFAULT NULL,
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `image_kb_size` float DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `time_updated` datetime DEFAULT NULL,
  `time_created` datetime NOT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_creative_id`),
  KEY `idx1` (`product_id`,`type_id`)
) TYPE=InnoDB AUTO_INCREMENT=312434;

--
-- Table structure for table `ncs_partner_tos`
--

DROP TABLE IF EXISTS `ncs_partner_tos`;
CREATE TABLE `ncs_partner_tos` (
  `tos_id` int(11) NOT NULL AUTO_INCREMENT,
  `terms` longtext NOT NULL,
  `date_created` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`tos_id`)
) TYPE=InnoDB AUTO_INCREMENT=6;

--
-- Table structure for table `ncs_partner_users`
--

DROP TABLE IF EXISTS `ncs_partner_users`;
CREATE TABLE `ncs_partner_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `can_login` tinyint(1) NOT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_account_id` (`account_id`)
) TYPE=InnoDB AUTO_INCREMENT=114363;

--
-- Table structure for table `ncs_partner_websites`
--

DROP TABLE IF EXISTS `ncs_partner_websites`;
CREATE TABLE `ncs_partner_websites` (
  `website_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `sub_account_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `estimated_traffic_volume_id` tinyint(3) unsigned NOT NULL,
  `approval_status` enum('APPROVED','DECLINED','PENDING') NOT NULL DEFAULT 'PENDING',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`website_id`),
  KEY `idx_affiliate_id` (`affiliate_id`)
) TYPE=MyISAM AUTO_INCREMENT=13841;

--
-- Table structure for table `ncs_transactions`
--

DROP TABLE IF EXISTS `ncs_transactions`;
CREATE TABLE `ncs_transactions` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_transactions_affiliate_aug`
--

DROP TABLE IF EXISTS `ncs_transactions_affiliate_aug`;
CREATE TABLE `ncs_transactions_affiliate_aug` (
  `transaction_id` varchar(36) NOT NULL,
  `website_id` int(11) NOT NULL,
  `product_creative_id` int(11) DEFAULT NULL,
  `date_inserted` datetime DEFAULT NULL,
  `affiliate_id` varchar(50) DEFAULT NULL,
  `sub_account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_transactions_affiliate_generics`
--

DROP TABLE IF EXISTS `ncs_transactions_affiliate_generics`;
CREATE TABLE `ncs_transactions_affiliate_generics` (
  `transaction_id` varchar(36) NOT NULL,
  `website_id` int(11) NOT NULL,
  `product_creative_id` int(11) DEFAULT NULL,
  `date_inserted` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) TYPE=InnoDB;

--
-- Table structure for table `ncs_transactions_aug`
--

DROP TABLE IF EXISTS `ncs_transactions_aug`;
CREATE TABLE `ncs_transactions_aug` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_transactions_generics`
--

DROP TABLE IF EXISTS `ncs_transactions_generics`;
CREATE TABLE `ncs_transactions_generics` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=MyISAM;

--
-- Table structure for table `ncs_transactions_july`
--

DROP TABLE IF EXISTS `ncs_transactions_july`;
CREATE TABLE `ncs_transactions_july` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  `ncs_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=MyISAM;

--
-- Table structure for table `old_netfiniti_banner_clicks`
--

DROP TABLE IF EXISTS `old_netfiniti_banner_clicks`;
CREATE TABLE `old_netfiniti_banner_clicks` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `date_inserted` datetime DEFAULT NULL,
  `affiliate_id` varchar(15) DEFAULT NULL,
  `banner_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_affiliate_id` (`affiliate_id`),
  KEY `idx_banner_id` (`banner_id`),
  KEY `idx_date_inserted` (`date_inserted`)
) TYPE=MyISAM;

--
-- Table structure for table `page_reference`
--

DROP TABLE IF EXISTS `page_reference`;
CREATE TABLE `page_reference` (
  `page_reference_id` varchar(30) NOT NULL,
  `page_id` int(11) NOT NULL,
  `page_id_orig` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_reference_id`),
  KEY `idx_page_id` (`page_id`),
  KEY `idx_page_id_orig` (`page_id_orig`)
) TYPE=InnoDB;

--
-- Temporary table structure for view `page_subpage_ranking`
--

DROP TABLE IF EXISTS `page_subpage_ranking`;
/*!50001 DROP VIEW IF EXISTS `page_subpage_ranking`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `page_subpage_ranking` (
 `page_id` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `sub_page_rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `page_views`
--

DROP TABLE IF EXISTS `page_views`;
CREATE TABLE `page_views` (
  `page_id` int(11) NOT NULL,
  `external_visit_id` varchar(32) NOT NULL DEFAULT '',
  `view_time` datetime NOT NULL,
  `seed` varchar(5) NOT NULL DEFAULT '',
  `is_landing_page` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`external_visit_id`,`view_time`,`page_id`,`seed`),
  KEY `idx_view_time` (`view_time`),
  KEY `idx_page_id` (`page_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `insert_time` timestamp NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(10) NOT NULL DEFAULT '0',
  `page_url` varchar(255) DEFAULT NULL,
  `page_type` enum('ARTICLE','INDIVIDUAL_OFFER','OTHER','PRODUCT_CATEGORY') NOT NULL DEFAULT 'OTHER',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_name` (`page_name`,`page_type`)
) TYPE=InnoDB AUTO_INCREMENT=1712;

--
-- Table structure for table `parse_date_token_report`
--

DROP TABLE IF EXISTS `parse_date_token_report`;
CREATE TABLE `parse_date_token_report` (
  `parse_date` date NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `token_id` varchar(80) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT '0',
  `estimated_earnings` double(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`parse_date`,`affiliate_id`,`token_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_account_tos_map`
--

DROP TABLE IF EXISTS `partner_account_tos_map`;
CREATE TABLE `partner_account_tos_map` (
  `account_id` int(11) NOT NULL,
  `tos_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `initials` varchar(10) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`account_id`,`tos_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_account_types`
--

DROP TABLE IF EXISTS `partner_account_types`;
CREATE TABLE `partner_account_types` (
  `partner_account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(5) DEFAULT NULL,
  `can_receive_email` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`partner_account_type_id`),
  UNIQUE KEY `account_type_UNIQUE` (`account_type`)
) TYPE=InnoDB AUTO_INCREMENT=4;

--
-- Table structure for table `partner_accounts`
--

DROP TABLE IF EXISTS `partner_accounts`;
CREATE TABLE `partner_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account_type` enum('NCS','CS','LO') DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
  `created_time` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) TYPE=InnoDB AUTO_INCREMENT=3941;

--
-- Table structure for table `partner_activations`
--

DROP TABLE IF EXISTS `partner_activations`;
CREATE TABLE `partner_activations` (
  `activation_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `created_time` datetime NOT NULL,
  `activation_hash` varchar(32) NOT NULL,
  `activation_code` varchar(8) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`activation_id`)
) TYPE=InnoDB AUTO_INCREMENT=158;

--
-- Table structure for table `partner_admins`
--

DROP TABLE IF EXISTS `partner_admins`;
CREATE TABLE `partner_admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) TYPE=MyISAM AUTO_INCREMENT=29;

--
-- Table structure for table `partner_affiliate_card_commissions`
--

DROP TABLE IF EXISTS `partner_affiliate_card_commissions`;
CREATE TABLE `partner_affiliate_card_commissions` (
  `affiliate_card_commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `commission_amount` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `creator_user_id` int(11) NOT NULL,
  `time_created` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`affiliate_card_commission_id`),
  KEY `idx_pacc_affiliate_id` (`affiliate_id`),
  KEY `idx_pacc_start_date` (`start_date`),
  KEY `idx_pacc_end_date` (`end_date`),
  KEY `idx_pacc_card_id` (`card_id`)
) TYPE=InnoDB AUTO_INCREMENT=172291;

--
-- Table structure for table `partner_affiliate_card_ranks`
--

DROP TABLE IF EXISTS `partner_affiliate_card_ranks`;
CREATE TABLE `partner_affiliate_card_ranks` (
  `card_rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_rank` int(11) NOT NULL,
  `card_category_context_id` int(11) NOT NULL,
  `card_category_id` int(11) NOT NULL,
  `affiliate_id` varchar(20) NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`card_rank_id`),
  KEY `card_id_cat_idx` (`card_id`,`card_category_id`),
  KEY `card_cat_idx` (`card_category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_affiliate_click_counts`
--

DROP TABLE IF EXISTS `partner_affiliate_click_counts`;
CREATE TABLE `partner_affiliate_click_counts` (
  `affiliate_id` varchar(36) NOT NULL,
  `click_date` date NOT NULL DEFAULT '0000-00-00',
  `click_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`click_date`)
) TYPE=InnoDB;

--
-- Temporary table structure for view `partner_affiliate_click_reporting`
--

DROP TABLE IF EXISTS `partner_affiliate_click_reporting`;
/*!50001 DROP VIEW IF EXISTS `partner_affiliate_click_reporting`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `partner_affiliate_click_reporting` (
 `affiliate_id` tinyint NOT NULL,
  `website_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `date_inserted` tinyint NOT NULL,
  `saleClickCount` tinyint NOT NULL,
  `nonSaleClickCount` tinyint NOT NULL,
  `applicationsCount` tinyint NOT NULL,
  `crossSaleCount` tinyint NOT NULL,
  `totalClicks` tinyint NOT NULL,
  `totalCommission` tinyint NOT NULL,
  `nonSalesClickCommission` tinyint NOT NULL,
  `salesClickCommission` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `partner_affiliate_click_reporting_internal`
--

DROP TABLE IF EXISTS `partner_affiliate_click_reporting_internal`;
/*!50001 DROP VIEW IF EXISTS `partner_affiliate_click_reporting_internal`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `partner_affiliate_click_reporting_internal` (
 `affiliate_id` tinyint NOT NULL,
  `website_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `date_inserted` tinyint NOT NULL,
  `saleClickCount` tinyint NOT NULL,
  `nonSaleClickCount` tinyint NOT NULL,
  `applicationsCount` tinyint NOT NULL,
  `crossSaleCount` tinyint NOT NULL,
  `totalClicks` tinyint NOT NULL,
  `totalCommission` tinyint NOT NULL,
  `totalRevenue` tinyint NOT NULL,
  `totalAdjustment` tinyint NOT NULL,
  `nonSalesClickCommission` tinyint NOT NULL,
  `salesClickCommission` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `partner_affiliate_group_affiliate_map`
--

DROP TABLE IF EXISTS `partner_affiliate_group_affiliate_map`;
CREATE TABLE `partner_affiliate_group_affiliate_map` (
  `affiliate_id` varchar(8) NOT NULL DEFAULT '',
  `affiliate_group_id` varchar(16) NOT NULL,
  PRIMARY KEY (`affiliate_id`,`affiliate_group_id`),
  KEY `aff_grp_id_idx` (`affiliate_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_affiliate_groups`
--

DROP TABLE IF EXISTS `partner_affiliate_groups`;
CREATE TABLE `partner_affiliate_groups` (
  `affiliate_group_id` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_group_id` varchar(16) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`affiliate_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_affiliate_info_history`
--

DROP TABLE IF EXISTS `partner_affiliate_info_history`;
CREATE TABLE `partner_affiliate_info_history` (
  `affiliate_info_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `account_id` int(11) NOT NULL,
  `affiliate_type` enum('PARTNER','TRAFFIC_SOURCE') NOT NULL,
  `affiliate_representative_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `billing_first_name` varchar(255) DEFAULT NULL,
  `billing_last_name` varchar(255) DEFAULT NULL,
  `billing_company_name` varchar(255) DEFAULT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(60) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(10) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `payout_name` varchar(255) NOT NULL,
  `payout_threshold` double NOT NULL,
  `commission_rate_id` int(11) DEFAULT NULL,
  `restricted` tinyint(1) NOT NULL,
  `in_house` tinyint(1) NOT NULL,
  `time_created` datetime NOT NULL,
  `time_reviewed` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `status` enum('PENDING','APPROVED','DECLINED') NOT NULL,
  PRIMARY KEY (`affiliate_info_history_id`)
) TYPE=InnoDB AUTO_INCREMENT=14814;

--
-- Table structure for table `partner_affiliate_representatives`
--

DROP TABLE IF EXISTS `partner_affiliate_representatives`;
CREATE TABLE `partner_affiliate_representatives` (
  `affiliate_representative_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `phone_extension` varchar(5) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`affiliate_representative_id`)
) TYPE=InnoDB AUTO_INCREMENT=9;

--
-- Table structure for table `partner_affiliate_sales_transactions_report`
--

DROP TABLE IF EXISTS `partner_affiliate_sales_transactions_report`;
CREATE TABLE `partner_affiliate_sales_transactions_report` (
  `trans_id` varchar(36) NOT NULL,
  `affiliate_id` varchar(36) NOT NULL,
  `website_id` int(11) NOT NULL,
  `uv` varchar(200) DEFAULT NULL,
  `card_id` varchar(20) NOT NULL DEFAULT '',
  `click_date` datetime NOT NULL,
  `provider_process_date` datetime DEFAULT NULL COMMENT 'This was previously named posting_date',
  `upload_date` datetime DEFAULT NULL,
  `trans_type` int(11) NOT NULL,
  `commission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `cross_sale` varchar(80) DEFAULT NULL,
  `committed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`),
  KEY `idx_click_date` (`affiliate_id`,`click_date`),
  KEY `idx_post_date` (`affiliate_id`,`provider_process_date`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_affiliate_site_group`
--

DROP TABLE IF EXISTS `partner_affiliate_site_group`;
CREATE TABLE `partner_affiliate_site_group` (
  `affiliate_site_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_site_group_name` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified_time` timestamp NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`affiliate_site_group_id`),
  UNIQUE KEY `GroupName` (`affiliate_site_group_name`)
) TYPE=InnoDB AUTO_INCREMENT=3;

--
-- Table structure for table `partner_affiliate_site_group_map`
--

DROP TABLE IF EXISTS `partner_affiliate_site_group_map`;
CREATE TABLE `partner_affiliate_site_group_map` (
  `affiliate_site_group_map_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_site_group_id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  PRIMARY KEY (`affiliate_site_group_map_id`)
) TYPE=InnoDB AUTO_INCREMENT=4;

--
-- Table structure for table `partner_affiliates`
--

DROP TABLE IF EXISTS `partner_affiliates`;
CREATE TABLE `partner_affiliates` (
  `affiliate_id` varchar(8) NOT NULL,
  `account_id` int(11) NOT NULL,
  `affiliate_type` enum('PARTNER','TRAFFIC_SOURCE') NOT NULL,
  `ref_id` varchar(8) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `affiliate_representative_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `billing_first_name` varchar(255) DEFAULT NULL,
  `billing_last_name` varchar(255) DEFAULT NULL,
  `billing_company_name` varchar(255) DEFAULT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(60) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(10) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `referral_type` tinyint(1) DEFAULT NULL,
  `referral_detail` varchar(255) DEFAULT NULL,
  `tax` varchar(255) NOT NULL,
  `status` enum('ACTIVE','DECLINED','INACTIVE','PENDING','APPROVED') NOT NULL,
  `commission_rate_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL DEFAULT '0',
  `payout_threshold` double NOT NULL,
  `payout_name` varchar(255) NOT NULL,
  `ip` int(10) unsigned DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `tos_id` int(10) DEFAULT NULL COMMENT 'This field is to hold the TOS id that they initially signed when registering the account.',
  `restricted` tinyint(1) NOT NULL DEFAULT '0',
  `in_house` tinyint(1) NOT NULL DEFAULT '0',
  `time_inserted` datetime NOT NULL,
  `time_modified` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  PRIMARY KEY (`affiliate_id`),
  UNIQUE KEY `idx_ref_id` (`ref_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_banner_affiliate_map`
--

DROP TABLE IF EXISTS `partner_banner_affiliate_map`;
CREATE TABLE `partner_banner_affiliate_map` (
  `affiliate_id` varchar(8) NOT NULL DEFAULT '',
  `banner_id` varchar(20) NOT NULL,
  PRIMARY KEY (`affiliate_id`,`banner_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_banner_group_banner_map`
--

DROP TABLE IF EXISTS `partner_banner_group_banner_map`;
CREATE TABLE `partner_banner_group_banner_map` (
  `banner_id` varchar(20) NOT NULL,
  `banner_group_id` varchar(16) NOT NULL,
  PRIMARY KEY (`banner_id`,`banner_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_banner_groups`
--

DROP TABLE IF EXISTS `partner_banner_groups`;
CREATE TABLE `partner_banner_groups` (
  `banner_group_id` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_banner_impressions`
--

DROP TABLE IF EXISTS `partner_banner_impressions`;
CREATE TABLE `partner_banner_impressions` (
  `impression_id` varchar(30) NOT NULL,
  `banner_id` varchar(20) NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `impression_time` datetime NOT NULL,
  PRIMARY KEY (`impression_id`),
  KEY `idx_impression_time` (`impression_time`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_banners`
--

DROP TABLE IF EXISTS `partner_banners`;
CREATE TABLE `partner_banners` (
  `banner_id` varchar(20) NOT NULL,
  `banner_affiliate_type` enum('PARTNER','TRAFFIC_SOURCE') NOT NULL,
  `banner_type` enum('IMAGE','FLASH','TEXT') NOT NULL,
  `name` varchar(255) NOT NULL,
  `destination_url` text NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `hidden` tinyint(4) DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_bonuses`
--

DROP TABLE IF EXISTS `partner_bonuses`;
CREATE TABLE `partner_bonuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `notes` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_card_affiliate_map`
--

DROP TABLE IF EXISTS `partner_card_affiliate_map`;
CREATE TABLE `partner_card_affiliate_map` (
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `status` enum('APPROVED','PENDING','DECLINED') NOT NULL,
  `date_requested` datetime DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `time_approved` datetime DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`card_id`),
  KEY `idx_pcam_card_id` (`card_id`),
  KEY `affiliate_id` (`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_card_br_ranks`
--

DROP TABLE IF EXISTS `partner_card_br_ranks`;
CREATE TABLE `partner_card_br_ranks` (
  `card_rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_rank` int(11) NOT NULL,
  `card_category_context_id` int(11) NOT NULL,
  `card_category_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`card_rank_id`),
  KEY `card_id_cat_idx` (`card_id`,`card_category_id`),
  KEY `card_cat_idx` (`card_category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_card_group_card_map`
--

DROP TABLE IF EXISTS `partner_card_group_card_map`;
CREATE TABLE `partner_card_group_card_map` (
  `card_id` varchar(20) NOT NULL DEFAULT '',
  `card_group_id` varchar(16) NOT NULL,
  PRIMARY KEY (`card_id`,`card_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_card_groups`
--

DROP TABLE IF EXISTS `partner_card_groups`;
CREATE TABLE `partner_card_groups` (
  `card_group_id` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_group_id` varchar(16) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_card_website_map`
--

DROP TABLE IF EXISTS `partner_card_website_map`;
CREATE TABLE `partner_card_website_map` (
  `card_website_map_id` int(11) NOT NULL AUTO_INCREMENT,
  `website_id` int(11) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `status` enum('PENDING','APPROVED','DECLINED') NOT NULL,
  `date_requested` datetime DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `time_approved` datetime DEFAULT NULL,
  `last_modified_time` timestamp NOT NULL,
  PRIMARY KEY (`card_website_map_id`),
  UNIQUE KEY `website_card` (`website_id`,`card_id`),
  KEY `pcwm_card_id` (`card_id`),
  KEY `website_id` (`website_id`)
) TYPE=InnoDB AUTO_INCREMENT=3;

--
-- Table structure for table `partner_cards`
--

DROP TABLE IF EXISTS `partner_cards`;
CREATE TABLE `partner_cards` (
  `card_id` varchar(20) NOT NULL,
  `default_commission` double NOT NULL,
  `commission_label` enum('PER_APPLICATION','PER_APPROVAL','PER_CLICK') NOT NULL DEFAULT 'PER_APPROVAL',
  `payout_cap` decimal(6,5) unsigned DEFAULT NULL,
  `card_level_id` int(11) DEFAULT NULL COMMENT 'References cccomus.card_levels.card_level_id',
  `time_modified` datetime NOT NULL,
  `time_created` datetime NOT NULL,
  `acknowledged_time` datetime DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_id`),
  KEY `card_level_id` (`card_level_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_click_tags`
--

DROP TABLE IF EXISTS `partner_click_tags`;
CREATE TABLE `partner_click_tags` (
  `banner_id` varchar(20) NOT NULL,
  `click_tag_id` varchar(16) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`banner_id`,`click_tag_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_commission_card_map`
--

DROP TABLE IF EXISTS `partner_commission_card_map`;
CREATE TABLE `partner_commission_card_map` (
  `commission_rate_id` int(11) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `card_value` double(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`commission_rate_id`,`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_commission_flagged`
--

DROP TABLE IF EXISTS `partner_commission_flagged`;
CREATE TABLE `partner_commission_flagged` (
  `flag_id` int(11) NOT NULL AUTO_INCREMENT,
  `revenue_log_id` int(11) DEFAULT NULL,
  `commission_id` int(11) DEFAULT NULL,
  `percentage_of_cpa` double DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `card_name` varchar(250) DEFAULT NULL,
  `issuer_id` int(11) DEFAULT NULL,
  `issuer_name` varchar(250) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `affiliate_name` varchar(250) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`flag_id`)
) TYPE=MyISAM AUTO_INCREMENT=33;

--
-- Table structure for table `partner_commission_rates`
--

DROP TABLE IF EXISTS `partner_commission_rates`;
CREATE TABLE `partner_commission_rates` (
  `commission_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `commission_type` enum('FLAT','PERCENT') NOT NULL,
  `value` double NOT NULL,
  `time_modified` datetime NOT NULL,
  `time_created` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`commission_rate_id`)
) TYPE=InnoDB AUTO_INCREMENT=16;

--
-- Table structure for table `partner_commission_rates_log`
--

DROP TABLE IF EXISTS `partner_commission_rates_log`;
CREATE TABLE `partner_commission_rates_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `revenue_log_id` int(11) DEFAULT NULL,
  `card_id` varchar(20) DEFAULT NULL,
  `card_name` varchar(100) DEFAULT NULL,
  `old_rate` double DEFAULT NULL,
  `new_rate` double DEFAULT NULL,
  `rate_type` varchar(20) DEFAULT NULL,
  `rate_id` int(11) DEFAULT NULL,
  `old_start_date` date DEFAULT NULL,
  `old_end_date` date DEFAULT NULL,
  `new_start_date` date DEFAULT NULL,
  `new_end_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `issuer_id` varchar(20) DEFAULT NULL,
  `issuer_name` varchar(100) DEFAULT NULL,
  `affiliate_id` varchar(20) DEFAULT NULL,
  `affiliate_name` varchar(100) DEFAULT NULL,
  `affiliate_rep_id` varchar(20) DEFAULT NULL,
  `affiliate_rep_name` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `action` enum('create','update','delete') DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `affiliate` (`affiliate_id`),
  KEY `affiliate_rep_id` (`affiliate_rep_id`),
  KEY `date_created` (`date_created`),
  KEY `card_id` (`card_id`)
) TYPE=MyISAM AUTO_INCREMENT=7279;

--
-- Table structure for table `partner_communication_affiliate_map`
--

DROP TABLE IF EXISTS `partner_communication_affiliate_map`;
CREATE TABLE `partner_communication_affiliate_map` (
  `communication_id` int(11) NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  PRIMARY KEY (`communication_id`,`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_communications`
--

DROP TABLE IF EXISTS `partner_communications`;
CREATE TABLE `partner_communications` (
  `communication_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `body_type` enum('HTML','TEXT') NOT NULL DEFAULT 'TEXT',
  `communication_type` enum('ANNOUNCEMENT','AUTO_MESSAGE','MESSAGE','NEWS','NEWSLETTER') NOT NULL,
  `newsletter_id` int(10) unsigned DEFAULT NULL,
  `time_created` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`communication_id`)
) TYPE=MyISAM AUTO_INCREMENT=14249;

--
-- Table structure for table `partner_error_logs`
--

DROP TABLE IF EXISTS `partner_error_logs`;
CREATE TABLE `partner_error_logs` (
  `error_log_id` varchar(32) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `date_time_updated` datetime NOT NULL,
  `count_for_day` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `application_id` tinyint(4) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(75) DEFAULT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `details` text,
  `date_time_created` datetime NOT NULL,
  PRIMARY KEY (`error_log_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_estimated_traffic_volume`
--

DROP TABLE IF EXISTS `partner_estimated_traffic_volume`;
CREATE TABLE `partner_estimated_traffic_volume` (
  `volume_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(60) NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`volume_id`),
  UNIQUE KEY `UN_partner_website_traffic_options` (`label`)
) TYPE=MyISAM AUTO_INCREMENT=4;

--
-- Table structure for table `partner_flash_banners`
--

DROP TABLE IF EXISTS `partner_flash_banners`;
CREATE TABLE `partner_flash_banners` (
  `banner_id` varchar(20) NOT NULL,
  `flash_source` text NOT NULL,
  `backup_image` text NOT NULL,
  `backup_alt_text` text NOT NULL,
  PRIMARY KEY (`banner_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_history_logs`
--

DROP TABLE IF EXISTS `partner_history_logs`;
CREATE TABLE `partner_history_logs` (
  `history_log_id` varchar(32) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `application_id` tinyint(4) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(75) DEFAULT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `details` text,
  `date_time_created` datetime NOT NULL,
  PRIMARY KEY (`history_log_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_hosting`
--

DROP TABLE IF EXISTS `partner_hosting`;
CREATE TABLE `partner_hosting` (
  `hosting_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `header_url` varchar(255) NOT NULL,
  `nav_url` varchar(255) NOT NULL,
  `nav_location` enum('LEFT','TOP') NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`hosting_id`)
) TYPE=MyISAM AUTO_INCREMENT=78;

--
-- Table structure for table `partner_image_banners`
--

DROP TABLE IF EXISTS `partner_image_banners`;
CREATE TABLE `partner_image_banners` (
  `banner_id` varchar(20) NOT NULL,
  `image_path` text NOT NULL,
  `alt_text` text NOT NULL,
  PRIMARY KEY (`banner_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_log_type`
--

DROP TABLE IF EXISTS `partner_log_type`;
CREATE TABLE `partner_log_type` (
  `log_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` enum('HISTORY','ERROR') NOT NULL,
  `log_description` varchar(255) NOT NULL,
  PRIMARY KEY (`log_type_id`)
) TYPE=InnoDB AUTO_INCREMENT=69;

--
-- Table structure for table `partner_mass_change`
--

DROP TABLE IF EXISTS `partner_mass_change`;
CREATE TABLE `partner_mass_change` (
  `mass_change_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `reverted` tinyint(1) NOT NULL DEFAULT '0',
  `reverted_admin_id` int(11) DEFAULT NULL,
  `finalized_time` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mass_change_id`)
) TYPE=InnoDB AUTO_INCREMENT=88;

--
-- Table structure for table `partner_mass_change_history`
--

DROP TABLE IF EXISTS `partner_mass_change_history`;
CREATE TABLE `partner_mass_change_history` (
  `mass_change_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `mass_change_id` int(11) NOT NULL,
  `card_id` varchar(20) DEFAULT NULL,
  `website_id` int(11) NOT NULL,
  `previous_status` enum('PENDING','APPROVED','DECLINED') DEFAULT NULL,
  `reverted_time` datetime DEFAULT NULL,
  PRIMARY KEY (`mass_change_history_id`)
) TYPE=InnoDB AUTO_INCREMENT=37173;

--
-- Table structure for table `partner_message_actions`
--

DROP TABLE IF EXISTS `partner_message_actions`;
CREATE TABLE `partner_message_actions` (
  `message_action_id` varchar(255) NOT NULL,
  `message_template_id` int(11) NOT NULL,
  PRIMARY KEY (`message_action_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_message_queue`
--

DROP TABLE IF EXISTS `partner_message_queue`;
CREATE TABLE `partner_message_queue` (
  `message_queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `message_template_id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `solution_id` smallint(5) NOT NULL,
  `time_queued` datetime NOT NULL,
  PRIMARY KEY (`message_queue_id`)
) TYPE=MyISAM AUTO_INCREMENT=3728;

--
-- Table structure for table `partner_message_templates`
--

DROP TABLE IF EXISTS `partner_message_templates`;
CREATE TABLE `partner_message_templates` (
  `message_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `text_body` text NOT NULL,
  `html_body` text NOT NULL,
  `auto_dispatch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_template_id`)
) TYPE=MyISAM AUTO_INCREMENT=29;

--
-- Table structure for table `partner_notes`
--

DROP TABLE IF EXISTS `partner_notes`;
CREATE TABLE `partner_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `entity_type` enum('AFFILIATE','ISSUER','USER','WEBSITE') NOT NULL,
  `entity_id` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `text` text,
  `date_created` timestamp NOT NULL,
  `created_by_user_username` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`)
) TYPE=InnoDB AUTO_INCREMENT=39;

--
-- Table structure for table `partner_payment_types`
--

DROP TABLE IF EXISTS `partner_payment_types`;
CREATE TABLE `partner_payment_types` (
  `payment_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_type_id`)
) TYPE=MyISAM AUTO_INCREMENT=4;

--
-- Table structure for table `partner_payout_transaction_map`
--

DROP TABLE IF EXISTS `partner_payout_transaction_map`;
CREATE TABLE `partner_payout_transaction_map` (
  `payout_id` int(11) NOT NULL,
  `transaction_id` varchar(36) NOT NULL,
  PRIMARY KEY (`payout_id`,`transaction_id`),
  KEY `idx_trans_id` (`transaction_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_payouts`
--

DROP TABLE IF EXISTS `partner_payouts`;
CREATE TABLE `partner_payouts` (
  `payout_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `payout_name` varchar(255) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `process_time` datetime NOT NULL,
  `status` enum('approved','pending') DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payout_id`)
) TYPE=MyISAM AUTO_INCREMENT=1291;

--
-- Table structure for table `partner_product_creatives`
--

DROP TABLE IF EXISTS `partner_product_creatives`;
CREATE TABLE `partner_product_creatives` (
  `product_creative_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(20) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `data` text NOT NULL,
  `text_type_id` tinyint(4) DEFAULT NULL,
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `image_kb_size` float DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `time_updated` datetime NOT NULL,
  `time_created` datetime NOT NULL,
  PRIMARY KEY (`product_creative_id`),
  KEY `ppc_prod_id_type_id` (`product_id`,`type_id`)
) TYPE=InnoDB AUTO_INCREMENT=2;

--
-- Table structure for table `partner_search_engine_settings`
--

DROP TABLE IF EXISTS `partner_search_engine_settings`;
CREATE TABLE `partner_search_engine_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `setting_key` varchar(25) NOT NULL,
  `setting_value` varchar(25) NOT NULL,
  `change_date` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UN_affiliate_id_setting_key` (`affiliate_id`,`setting_key`)
) TYPE=MyISAM AUTO_INCREMENT=2655;

--
-- Table structure for table `partner_solutions`
--

DROP TABLE IF EXISTS `partner_solutions`;
CREATE TABLE `partner_solutions` (
  `solution_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`solution_id`),
  UNIQUE KEY `UN_partner_solution_name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=9;

--
-- Table structure for table `partner_solutions_map`
--

DROP TABLE IF EXISTS `partner_solutions_map`;
CREATE TABLE `partner_solutions_map` (
  `affiliate_id` varchar(8) NOT NULL,
  `solution_id` smallint(5) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `version_id` int(11) DEFAULT '-1',
  `request_date` datetime NOT NULL,
  `disposition_date` datetime DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`solution_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_text_banners`
--

DROP TABLE IF EXISTS `partner_text_banners`;
CREATE TABLE `partner_text_banners` (
  `banner_id` varchar(20) NOT NULL,
  `html_text` text NOT NULL,
  PRIMARY KEY (`banner_id`)
) TYPE=MyISAM;

--
-- Table structure for table `partner_tos`
--

DROP TABLE IF EXISTS `partner_tos`;
CREATE TABLE `partner_tos` (
  `tos_id` int(11) NOT NULL AUTO_INCREMENT,
  `terms` longtext NOT NULL,
  `date_created` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`tos_id`)
) TYPE=InnoDB AUTO_INCREMENT=20;

--
-- Table structure for table `partner_users`
--

DROP TABLE IF EXISTS `partner_users`;
CREATE TABLE `partner_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `can_login` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_account_id` (`account_id`)
) TYPE=InnoDB AUTO_INCREMENT=14806;

--
-- Table structure for table `partner_website_product_declined_map`
--

DROP TABLE IF EXISTS `partner_website_product_declined_map`;
CREATE TABLE `partner_website_product_declined_map` (
  `partner_website_product_declined_map_id` int(11) NOT NULL AUTO_INCREMENT,
  `website_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `time_created` datetime NOT NULL,
  PRIMARY KEY (`partner_website_product_declined_map_id`),
  UNIQUE KEY `website_id` (`website_id`,`product_id`)
) TYPE=InnoDB;

--
-- Table structure for table `partner_websites`
--

DROP TABLE IF EXISTS `partner_websites`;
CREATE TABLE `partner_websites` (
  `website_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(8) NOT NULL,
  `sub_account_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `estimated_traffic_volume_id` tinyint(3) unsigned NOT NULL,
  `approval_status` enum('APPROVED','DECLINED','PENDING') NOT NULL DEFAULT 'PENDING',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`website_id`),
  KEY `idx_affiliate_id` (`affiliate_id`)
) TYPE=MyISAM AUTO_INCREMENT=5;

--
-- Table structure for table `partner_widget_categories`
--

DROP TABLE IF EXISTS `partner_widget_categories`;
CREATE TABLE `partner_widget_categories` (
  `category_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `UN_partner_widget_categories_category_name` (`category_name`)
) TYPE=MyISAM AUTO_INCREMENT=4;

--
-- Table structure for table `partner_widgets`
--

DROP TABLE IF EXISTS `partner_widgets`;
CREATE TABLE `partner_widgets` (
  `widget_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `link_text` varchar(500) NOT NULL,
  `category_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`widget_id`),
  UNIQUE KEY `UN_partner_widgets_name` (`name`),
  KEY `IX_partner_widgets_category_id` (`category_id`)
) TYPE=MyISAM AUTO_INCREMENT=3;

--
-- Table structure for table `payment_report`
--

DROP TABLE IF EXISTS `payment_report`;
CREATE TABLE `payment_report` (
  `payment_date` date NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `check_number` int(11) NOT NULL DEFAULT '0',
  `check_amount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`payment_date`,`affiliate_id`,`check_number`),
  KEY `idx_payment_date` (`payment_date`),
  KEY `idx_affiliate_id` (`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_daily_click`
--

DROP TABLE IF EXISTS `pc_daily_click`;
CREATE TABLE `pc_daily_click` (
  `event_date` varchar(10) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_daily_conversion_rate`
--

DROP TABLE IF EXISTS `pc_daily_conversion_rate`;
CREATE TABLE `pc_daily_conversion_rate` (
  `event_date` varchar(10) NOT NULL DEFAULT '',
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `issuer_id` int(10) DEFAULT NULL,
  `conversion_rate` decimal(45,4) DEFAULT NULL,
  PRIMARY KEY (`event_date`,`product_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_daily_sale`
--

DROP TABLE IF EXISTS `pc_daily_sale`;
CREATE TABLE `pc_daily_sale` (
  `event_date` varchar(10) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_monthly_click`
--

DROP TABLE IF EXISTS `pc_monthly_click`;
CREATE TABLE `pc_monthly_click` (
  `event_date` varchar(7) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_monthly_conversion_rate`
--

DROP TABLE IF EXISTS `pc_monthly_conversion_rate`;
CREATE TABLE `pc_monthly_conversion_rate` (
  `event_date` varchar(7) NOT NULL DEFAULT '',
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `issuer_id` int(10) DEFAULT NULL,
  `conversion_rate` decimal(45,4) DEFAULT NULL,
  PRIMARY KEY (`event_date`,`product_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_monthly_sale`
--

DROP TABLE IF EXISTS `pc_monthly_sale`;
CREATE TABLE `pc_monthly_sale` (
  `event_date` varchar(7) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_transaction_detail`
--

DROP TABLE IF EXISTS `pc_transaction_detail`;
CREATE TABLE `pc_transaction_detail` (
  `transaction_id` varchar(36) NOT NULL DEFAULT '',
  `trans_type` varchar(5) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `issuer_id` int(10) DEFAULT NULL,
  `issuer_name` varchar(255) DEFAULT NULL,
  `product_id` varchar(20) DEFAULT NULL,
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `card_category_name` varchar(255) DEFAULT NULL,
  `affiliate_id` varchar(8) DEFAULT NULL,
  `affiliate_name` varchar(510) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_yearly_click`
--

DROP TABLE IF EXISTS `pc_yearly_click`;
CREATE TABLE `pc_yearly_click` (
  `event_date` varchar(4) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_yearly_conversion_rate`
--

DROP TABLE IF EXISTS `pc_yearly_conversion_rate`;
CREATE TABLE `pc_yearly_conversion_rate` (
  `event_date` varchar(4) NOT NULL DEFAULT '',
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `issuer_id` int(10) DEFAULT NULL,
  `conversion_rate` decimal(45,4) DEFAULT NULL,
  PRIMARY KEY (`event_date`,`product_id`)
) TYPE=MyISAM;

--
-- Table structure for table `pc_yearly_sale`
--

DROP TABLE IF EXISTS `pc_yearly_sale`;
CREATE TABLE `pc_yearly_sale` (
  `event_date` varchar(4) NOT NULL DEFAULT '',
  `issuer_id` int(10) DEFAULT NULL,
  `product_id` varchar(20) NOT NULL DEFAULT '',
  `product_sku` varchar(15) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `website_id` int(11) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `card_category_name` varchar(255) DEFAULT NULL,
  `transaction_count` bigint(21) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_date`,`product_id`,`website_url`,`category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rate` tinyint(1) DEFAULT NULL,
  `rate_group_id` int(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`provider_id`)
) TYPE=MyISAM AUTO_INCREMENT=3;

--
-- Table structure for table `providers2`
--

DROP TABLE IF EXISTS `providers2`;
CREATE TABLE `providers2` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(255) NOT NULL DEFAULT '',
  `upload_file_directory` varchar(255) DEFAULT NULL,
  `parser` varchar(255) DEFAULT NULL,
  `calculate_rate` tinyint(1) DEFAULT NULL,
  `provider_type` varchar(25) NOT NULL DEFAULT '',
  `metadata` varchar(40) DEFAULT NULL,
  `revenue_provider_id` int(11) DEFAULT NULL,
  `deleted` bit(1) NOT NULL,
  PRIMARY KEY (`provider_id`),
  KEY `prov_id_idx` (`provider_id`)
) TYPE=InnoDB AUTO_INCREMENT=45;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
CREATE TABLE `queue` (
  `queue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(100) NOT NULL,
  `timeout` smallint(5) unsigned NOT NULL DEFAULT '30',
  PRIMARY KEY (`queue_id`)
) TYPE=InnoDB AUTO_INCREMENT=2;

--
-- Table structure for table `queue_status`
--

DROP TABLE IF EXISTS `queue_status`;
CREATE TABLE `queue_status` (
  `queue_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(40) DEFAULT NULL,
  `insert_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`queue_status_id`)
) TYPE=InnoDB;

--
-- Table structure for table `rate_groups`
--

DROP TABLE IF EXISTS `rate_groups`;
CREATE TABLE `rate_groups` (
  `rate_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_group_name` varchar(30) NOT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`rate_group_id`)
) TYPE=InnoDB AUTO_INCREMENT=5;

--
-- Table structure for table `reconcile_types_solutions_map`
--

DROP TABLE IF EXISTS `reconcile_types_solutions_map`;
CREATE TABLE `reconcile_types_solutions_map` (
  `recon_type_id` int(11) NOT NULL DEFAULT '0',
  `recon_solution_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`recon_type_id`,`recon_solution_id`)
) TYPE=MyISAM;

--
-- Table structure for table `reference_token_report`
--

DROP TABLE IF EXISTS `reference_token_report`;
CREATE TABLE `reference_token_report` (
  `affiliate_id` varchar(8) NOT NULL DEFAULT '',
  `reference` varchar(50) NOT NULL DEFAULT '',
  `token_id` varchar(80) NOT NULL DEFAULT '',
  `sales` decimal(32,0) DEFAULT NULL,
  `revenue` double DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`reference`,`token_id`)
) TYPE=MyISAM;

--
-- Table structure for table `report_control`
--

DROP TABLE IF EXISTS `report_control`;
CREATE TABLE `report_control` (
  `report_control_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `run_reports` enum('yes','no') NOT NULL,
  `insert_date` datetime NOT NULL COMMENT 'This table is used by cardsynergy portal to decide whether or not the cron job that build summary reports should run.',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`report_control_id`)
) TYPE=InnoDB AUTO_INCREMENT=4;

--
-- Table structure for table `report_job_history`
--

DROP TABLE IF EXISTS `report_job_history`;
CREATE TABLE `report_job_history` (
  `report_job_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` enum('SUMMARY_REPORTS','TRANS_REPORT') NOT NULL,
  `insert_date` datetime NOT NULL,
  PRIMARY KEY (`report_job_history_id`)
) TYPE=InnoDB AUTO_INCREMENT=555;

--
-- Table structure for table `rev_bonus_transaction_map`
--

DROP TABLE IF EXISTS `rev_bonus_transaction_map`;
CREATE TABLE `rev_bonus_transaction_map` (
  `bonus_id` int(11) NOT NULL,
  `trans_id` varchar(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`bonus_id`,`trans_id`)
) TYPE=InnoDB;

--
-- Table structure for table `rev_bonuses`
--

DROP TABLE IF EXISTS `rev_bonuses`;
CREATE TABLE `rev_bonuses` (
  `bonus_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(45) NOT NULL,
  `affiliate_id` varchar(45) NOT NULL,
  `revenue` decimal(12,2) DEFAULT NULL,
  `commission` decimal(12,2) DEFAULT NULL,
  `filter_from_date` date DEFAULT NULL,
  `filter_to_date` date DEFAULT NULL,
  `filters_json` text,
  `filters_text` text,
  `insert_time` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`bonus_id`)
) TYPE=InnoDB AUTO_INCREMENT=133;

--
-- Table structure for table `rev_make_goods`
--

DROP TABLE IF EXISTS `rev_make_goods`;
CREATE TABLE `rev_make_goods` (
  `make_good_id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text NOT NULL,
  `inserted_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_id` varchar(45) NOT NULL,
  PRIMARY KEY (`make_good_id`)
) TYPE=InnoDB AUTO_INCREMENT=15;

--
-- Table structure for table `rev_slotting_apply`
--

DROP TABLE IF EXISTS `rev_slotting_apply`;
CREATE TABLE `rev_slotting_apply` (
  `slotting_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` int(11) NOT NULL,
  `account_type` varchar(5) NOT NULL,
  `apply_start_date` date NOT NULL,
  `apply_end_date` date NOT NULL,
  `issuer_id` int(11) DEFAULT NULL,
  `card_list` varchar(255) NOT NULL,
  `website_list` varchar(255) DEFAULT NULL,
  `page_list` varchar(255) DEFAULT NULL,
  `referred_affiliate_id` varchar(8) DEFAULT NULL,
  `affiliate_list` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `slotting_revenue` decimal(10,2) DEFAULT NULL,
  `affiliate_commission` decimal(10,2) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `applied` tinyint(1) DEFAULT '0',
  `apply_date` date DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified_time` timestamp NOT NULL,
  `records_affected` int(11) DEFAULT NULL,
  `created_admin_id` int(11) DEFAULT NULL,
  `created_admin_username` varchar(255) DEFAULT NULL,
  `applied_admin_id` int(11) DEFAULT NULL,
  `applied_admin_username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`slotting_entry_id`)
) TYPE=InnoDB AUTO_INCREMENT=22;

--
-- Table structure for table `rev_slotting_entry_transaction_map`
--

DROP TABLE IF EXISTS `rev_slotting_entry_transaction_map`;
CREATE TABLE `rev_slotting_entry_transaction_map` (
  `slotting_entry_id` int(11) NOT NULL,
  `transaction_id` varchar(36) NOT NULL,
  PRIMARY KEY (`slotting_entry_id`,`transaction_id`)
) TYPE=InnoDB;

--
-- Table structure for table `rev_slotting_transactions`
--

DROP TABLE IF EXISTS `rev_slotting_transactions`;
CREATE TABLE `rev_slotting_transactions` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit_page` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=InnoDB;

--
-- Table structure for table `rev_split_transactions`
--

DROP TABLE IF EXISTS `rev_split_transactions`;
CREATE TABLE `rev_split_transactions` (
  `rev_split_id` int(11) NOT NULL,
  `trans_id` varchar(32) NOT NULL,
  PRIMARY KEY (`rev_split_id`,`trans_id`)
) TYPE=InnoDB;

--
-- Table structure for table `rev_splits`
--

DROP TABLE IF EXISTS `rev_splits`;
CREATE TABLE `rev_splits` (
  `rev_split_id` int(11) NOT NULL AUTO_INCREMENT,
  `end_date` date NOT NULL,
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`rev_split_id`)
) TYPE=InnoDB AUTO_INCREMENT=116;

--
-- Table structure for table `revenue_summary`
--

DROP TABLE IF EXISTS `revenue_summary`;
CREATE TABLE `revenue_summary` (
  `affiliate_id` varchar(8) NOT NULL DEFAULT '',
  `website_id` int(11) NOT NULL DEFAULT '0',
  `card_id` varchar(20) NOT NULL,
  `post_date` date NOT NULL,
  `appl_sales` int(11) NOT NULL,
  `apvl_sales` int(11) NOT NULL,
  `appl_comm` decimal(24,2) NOT NULL,
  `apvl_comm` decimal(24,2) NOT NULL,
  `sales_comm` decimal(24,2) NOT NULL,
  `bonus_comm` decimal(24,2) NOT NULL,
  `slotting_fee_comm` decimal(24,2) NOT NULL,
  `make_goods_comm` decimal(24,2) NOT NULL,
  `app_orp_comm` decimal(24,2) NOT NULL,
  `total_comm` decimal(24,2) NOT NULL,
  `appl_rev` decimal(24,2) NOT NULL,
  `apvl_rev` decimal(24,2) NOT NULL,
  `sales_rev` decimal(24,2) NOT NULL,
  `app_orp_rev` decimal(24,2) NOT NULL,
  `bonus_rev` decimal(24,2) NOT NULL,
  `slotting_fee_rev` decimal(24,2) NOT NULL,
  `make_goods_rev` decimal(24,2) NOT NULL,
  `total_rev` decimal(24,2) NOT NULL,
  PRIMARY KEY (`post_date`,`affiliate_id`,`website_id`,`card_id`),
  KEY `idx_affiliateid` (`affiliate_id`),
  KEY `idx_websiteid` (`website_id`),
  KEY `idx_cardid` (`card_id`),
  KEY `idx_date` (`post_date`)
) TYPE=InnoDB;

--
-- Table structure for table `rex_log`
--

DROP TABLE IF EXISTS `rex_log`;
CREATE TABLE `rex_log` (
  `rex_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `log_level` smallint(6) NOT NULL,
  `log_label` varchar(64) DEFAULT NULL,
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`rex_log_id`),
  KEY `idx_insert_time` (`insert_time`)
) TYPE=InnoDB AUTO_INCREMENT=288610;

--
-- Temporary table structure for view `summary_day_clicks_by_aid`
--

DROP TABLE IF EXISTS `summary_day_clicks_by_aid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_clicks_by_aid` (
 `click_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `count_of_clicks` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_clicks_by_aid_card_id`
--

DROP TABLE IF EXISTS `summary_day_clicks_by_aid_card_id`;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid_card_id`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_clicks_by_aid_card_id` (
 `click_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `count_of_clicks` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_clicks_by_aid_did`
--

DROP TABLE IF EXISTS `summary_day_clicks_by_aid_did`;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid_did`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_clicks_by_aid_did` (
 `click_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `keyword_id` tinyint NOT NULL,
  `count_of_clicks` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_clicks_by_cid`
--

DROP TABLE IF EXISTS `summary_day_clicks_by_cid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_cid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_clicks_by_cid` (
 `click_day` tinyint NOT NULL,
  `external_campaign_id` tinyint NOT NULL,
  `count_of_clicks` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_legacy_page_views_by_aid`
--

DROP TABLE IF EXISTS `summary_day_legacy_page_views_by_aid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_legacy_page_views_by_aid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_legacy_page_views_by_aid` (
 `legacy_page_view_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `count_of_unique_page_views` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_unique_visits_by_aid`
--

DROP TABLE IF EXISTS `summary_day_unique_visits_by_aid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_unique_visits_by_aid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_unique_visits_by_aid` (
 `visit_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `count_of_visits` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_visits_by_aid`
--

DROP TABLE IF EXISTS `summary_day_visits_by_aid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_visits_by_aid` (
 `visit_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `count_of_visits` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_visits_by_aid_bid`
--

DROP TABLE IF EXISTS `summary_day_visits_by_aid_bid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid_bid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_visits_by_aid_bid` (
 `visit_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `ad_id` tinyint NOT NULL,
  `count_of_visits` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_visits_by_aid_did`
--

DROP TABLE IF EXISTS `summary_day_visits_by_aid_did`;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid_did`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_visits_by_aid_did` (
 `visit_day` tinyint NOT NULL,
  `affiliate_id` tinyint NOT NULL,
  `keyword_id` tinyint NOT NULL,
  `count_of_visits` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `summary_day_visits_by_cid`
--

DROP TABLE IF EXISTS `summary_day_visits_by_cid`;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_cid`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `summary_day_visits_by_cid` (
 `visit_day` tinyint NOT NULL,
  `external_campaign_id` tinyint NOT NULL,
  `count_of_visits` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `temp_transactions2`
--

DROP TABLE IF EXISTS `temp_transactions2`;
CREATE TABLE `temp_transactions2` (
  `transid` varchar(36) NOT NULL DEFAULT ''
) TYPE=InnoDB;

--
-- Table structure for table `tl_test_partner_affiliate_click_reporting`
--

DROP TABLE IF EXISTS `tl_test_partner_affiliate_click_reporting`;
CREATE TABLE `tl_test_partner_affiliate_click_reporting` (
  `affiliate_id` varchar(8) NOT NULL,
  `website_id` int(11) NOT NULL DEFAULT '0',
  `card_id` varchar(15) NOT NULL,
  `date_inserted` date NOT NULL,
  `saleClickCount` decimal(23,0) DEFAULT NULL,
  `nonSaleClickCount` decimal(24,0) DEFAULT NULL,
  `applicationsCount` decimal(23,0) DEFAULT NULL,
  `totalClicks` decimal(23,0) DEFAULT NULL,
  `totalCommission` double(23,2) DEFAULT NULL,
  `salesClickCommission` double(23,2) DEFAULT NULL,
  `nonSalesClickCommission` double(23,2) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`website_id`,`card_id`,`date_inserted`),
  KEY `pacr_card_id` (`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `tmp_cpbt_clicks`
--

DROP TABLE IF EXISTS `tmp_cpbt_clicks`;
CREATE TABLE `tmp_cpbt_clicks` (
  `tmp_click_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(45) DEFAULT NULL,
  `product_id` varchar(45) DEFAULT NULL,
  `issuer_id` int(11) DEFAULT NULL,
  `exit_page_id` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  PRIMARY KEY (`tmp_click_id`),
  KEY `product_id` (`product_id`)
) TYPE=MyISAM;

--
-- Table structure for table `tmp_cpbt_sales`
--

DROP TABLE IF EXISTS `tmp_cpbt_sales`;
CREATE TABLE `tmp_cpbt_sales` (
  `tmp_sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` varchar(45) DEFAULT NULL,
  `product_id` varchar(45) DEFAULT NULL,
  `issuer_id` int(11) DEFAULT NULL,
  `exit_page_id` int(11) DEFAULT NULL,
  `sales` int(11) DEFAULT NULL,
  PRIMARY KEY (`tmp_sale_id`),
  KEY `product_id` (`product_id`)
) TYPE=MyISAM;

--
-- Table structure for table `tmp_partner_card_affiliate_map`
--

DROP TABLE IF EXISTS `tmp_partner_card_affiliate_map`;
CREATE TABLE `tmp_partner_card_affiliate_map` (
  `affiliate_id` varchar(8) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `status` enum('APPROVED','PENDING','DECLINED') NOT NULL,
  `date_requested` date DEFAULT NULL,
  `approver_user_id` int(11) DEFAULT NULL,
  `time_approved` datetime DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`,`card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `trackback_applications`
--

DROP TABLE IF EXISTS `trackback_applications`;
CREATE TABLE `trackback_applications` (
  `trackback_application_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` varchar(10) NOT NULL,
  `click_id` varchar(32) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `process_time` datetime NOT NULL,
  PRIMARY KEY (`trackback_application_id`,`server_id`)
) TYPE=InnoDB AUTO_INCREMENT=729429;

--
-- Table structure for table `trackback_landings`
--

DROP TABLE IF EXISTS `trackback_landings`;
CREATE TABLE `trackback_landings` (
  `trackback_landing_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` varchar(10) NOT NULL,
  `click_id` varchar(32) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `process_time` datetime NOT NULL,
  PRIMARY KEY (`trackback_landing_id`,`server_id`)
) TYPE=InnoDB;

--
-- Table structure for table `trackback_sales`
--

DROP TABLE IF EXISTS `trackback_sales`;
CREATE TABLE `trackback_sales` (
  `trackback_sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` varchar(10) NOT NULL,
  `click_id` varchar(32) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `process_time` datetime NOT NULL,
  PRIMARY KEY (`trackback_sale_id`,`server_id`)
) TYPE=InnoDB AUTO_INCREMENT=78951;

--
-- Table structure for table `trackers`
--

DROP TABLE IF EXISTS `trackers`;
CREATE TABLE `trackers` (
  `trackerId` int(11) NOT NULL AUTO_INCREMENT,
  `trackerName` varchar(255) DEFAULT NULL,
  `description` text,
  `dateInserted` datetime DEFAULT NULL,
  `ordering` int(10) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trackerId`)
) TYPE=MyISAM AUTO_INCREMENT=10047;

--
-- Table structure for table `traffic_date_token_report`
--

DROP TABLE IF EXISTS `traffic_date_token_report`;
CREATE TABLE `traffic_date_token_report` (
  `click_date` date NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `token_id` varchar(80) NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `sales` int(11) NOT NULL DEFAULT '0',
  `estimated_earnings` double(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`click_date`,`affiliate_id`,`token_id`)
) TYPE=MyISAM;

--
-- Table structure for table `traffic_report`
--

DROP TABLE IF EXISTS `traffic_report`;
CREATE TABLE `traffic_report` (
  `click_date` date NOT NULL,
  `affiliate_id` varchar(8) NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `sales` int(11) NOT NULL DEFAULT '0',
  `estimated_earnings` double(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`click_date`,`affiliate_id`)
) TYPE=MyISAM;

--
-- Table structure for table `trans_verify`
--

DROP TABLE IF EXISTS `trans_verify`;
CREATE TABLE `trans_verify` (
  `trans_verify_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(20) NOT NULL DEFAULT '',
  `insert_time` datetime NOT NULL,
  `external_visit_id` varchar(32) NOT NULL,
  `card_id` varchar(32) NOT NULL,
  PRIMARY KEY (`trans_verify_id`,`server_name`),
  KEY `idx_insert_time` (`insert_time`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_card_id` (`card_id`)
) TYPE=MyISAM AUTO_INCREMENT=1862467;

--
-- Table structure for table `transaction_reconcile_solution`
--

DROP TABLE IF EXISTS `transaction_reconcile_solution`;
CREATE TABLE `transaction_reconcile_solution` (
  `recon_solution_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `solution` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`recon_solution_id`)
) TYPE=MyISAM AUTO_INCREMENT=5;

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE `transaction_types` (
  `transaction_type` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `count_as_sale` tinyint(1) NOT NULL DEFAULT '0',
  `sum_as_revenue` tinyint(1) NOT NULL DEFAULT '0',
  `calculate_commission` tinyint(1) NOT NULL DEFAULT '0',
  `is_rev_split` tinyint(1) NOT NULL DEFAULT '0',
  `sum_as_epc` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transaction_type`)
) TYPE=InnoDB;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(255) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`),
  KEY `idx_reftrans` (`reftrans`)
) TYPE=MRG_MyISAM INSERT_METHOD=LAST UNION=(`transactions_upload`,`transactions_recent`);

--
-- Table structure for table `transactions_affiliate`
--

DROP TABLE IF EXISTS `transactions_affiliate`;
CREATE TABLE `transactions_affiliate` (
  `transaction_id` varchar(36) NOT NULL,
  `website_id` int(11) NOT NULL,
  `product_creative_id` int(11) DEFAULT NULL,
  `date_inserted` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) TYPE=InnoDB;

--
-- Table structure for table `transactions_apply_map`
--

DROP TABLE IF EXISTS `transactions_apply_map`;
CREATE TABLE `transactions_apply_map` (
  `trans_id` varchar(36) NOT NULL COMMENT 'cccom transaction id',
  `apply_id` varchar(25) NOT NULL COMMENT 'omniture eVar13-trans_id-purchase_id',
  `epc` decimal(12,2) DEFAULT NULL,
  `date_inserted` datetime DEFAULT NULL COMMENT 'Time that trans_id and apply_id were recorded on the trans server... when user clicked apply here',
  PRIMARY KEY (`trans_id`),
  KEY `date_inserted_idx` (`date_inserted`)
) TYPE=MyISAM COMMENT='Map a cccom transaction id to an Omniture eVar13 trans id';

--
-- Table structure for table `transactions_deleted`
--

DROP TABLE IF EXISTS `transactions_deleted`;
CREATE TABLE `transactions_deleted` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_deleted_archive`
--

DROP TABLE IF EXISTS `transactions_deleted_archive`;
CREATE TABLE `transactions_deleted_archive` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_dateadjusted` (`dateadjusted`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_filtered`
--

DROP TABLE IF EXISTS `transactions_filtered`;
CREATE TABLE `transactions_filtered` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_ledger`
--

DROP TABLE IF EXISTS `transactions_ledger`;
CREATE TABLE `transactions_ledger` (
  `transactions_ledger_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique audit id',
  `trans_id` varchar(36) NOT NULL COMMENT 'cccom transaction_id used in transactions tables',
  `trans_type` tinyint(4) DEFAULT '0',
  `ref_trans_id` varchar(36) DEFAULT NULL COMMENT 'cccom reftrans used in transactions tables',
  `apply_id` varchar(25) DEFAULT NULL COMMENT 'omniture eVar13-trans_id-purchase_id',
  `card_id` varchar(20) DEFAULT NULL,
  `offer_click_time` datetime DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'number of sales from a bank associated with this trans_id',
  `revenue` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'revenue associate with this ledger entry',
  `insert_time` timestamp NOT NULL COMMENT 'timestamp when ledger entry recorded',
  `insert_user` varchar(76) NOT NULL DEFAULT 'anonymous' COMMENT 'user that inserted data into the table',
  `last_export_time` timestamp NULL DEFAULT NULL COMMENT 'last time, which is normally the only time, entry was exported',
  `orig_table` varchar(30) NOT NULL COMMENT 'table that triggered the insert',
  `orig_action` varchar(10) NOT NULL COMMENT 'action that triggered the insert',
  PRIMARY KEY (`transactions_ledger_id`),
  KEY `ins_time_revenue_idx` (`insert_time`,`revenue`),
  KEY `trans_apply_ins_time_idx` (`trans_id`,`apply_id`,`insert_time`),
  KEY `ref_trans_id_idx` (`ref_trans_id`)
) TYPE=InnoDB COMMENT='transaction deltas captured from the transactions table';

--
-- Table structure for table `transactions_ledger_archive`
--

DROP TABLE IF EXISTS `transactions_ledger_archive`;
CREATE TABLE `transactions_ledger_archive` (
  `transactions_ledger_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique audit id',
  `trans_id` varchar(36) NOT NULL COMMENT 'cccom transaction_id used in transactions tables',
  `trans_type` tinyint(4) DEFAULT '0',
  `ref_trans_id` varchar(36) DEFAULT NULL COMMENT 'cccom reftrans used in transactions tables',
  `apply_id` varchar(25) DEFAULT NULL COMMENT 'omniture eVar13-trans_id-purchase_id',
  `card_id` varchar(20) DEFAULT NULL,
  `offer_click_time` datetime DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'number of sales from a bank associated with this trans_id',
  `revenue` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'revenue associate with this ledger entry',
  `insert_time` timestamp NOT NULL COMMENT 'timestamp when ledger entry recorded',
  `insert_user` varchar(76) NOT NULL DEFAULT 'anonymous' COMMENT 'user that inserted data into the table',
  `last_export_time` timestamp NULL DEFAULT NULL COMMENT 'last time, which is normally the only time, entry was exported',
  `orig_table` varchar(30) NOT NULL COMMENT 'table that triggered the insert',
  `orig_action` varchar(10) NOT NULL COMMENT 'action that triggered the insert',
  PRIMARY KEY (`transactions_ledger_id`),
  KEY `ins_time_revenue_idx` (`insert_time`,`revenue`),
  KEY `trans_apply_ins_time_idx` (`trans_id`,`apply_id`,`insert_time`),
  KEY `ref_trans_id_idx` (`ref_trans_id`)
) TYPE=InnoDB COMMENT='transaction deltas captured from the transactions table; Inn';

--
-- Table structure for table `transactions_recent`
--

DROP TABLE IF EXISTS `transactions_recent`;
CREATE TABLE `transactions_recent` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(255) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`),
  KEY `idx_reftrans` (`reftrans`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_reconcile`
--

DROP TABLE IF EXISTS `transactions_reconcile`;
CREATE TABLE `transactions_reconcile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transid` varchar(36) DEFAULT NULL,
  `recon_type_id` int(11) DEFAULT NULL,
  `recon_solution_id` int(11) DEFAULT NULL,
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_pa_transactions_2` (`dateinserted`),
  KEY `IDX_pa_transactions_3` (`transkind`,`transtype`,`rstatus`),
  KEY `IDX_pa_transactions_4` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions4` (`bannerid`),
  KEY `IDX_wd_pa_transactions5` (`affiliateid`),
  KEY `IDX_wd_pa_transactions6` (`parenttransid`),
  KEY `IDX_wd_pa_transactions8` (`recurringcommid`),
  KEY `IDX_wd_pa_transactions9` (`accountingid`),
  KEY `IDX_wd_pa_transactions10` (`accountid`),
  KEY `IDX_wd_pa_transactions12` (`estimateddatafilename`),
  KEY `IDX_wd_pa_transactions13` (`actualdatafilename`),
  KEY `IDX_wd_pa_transactions11` (`reftrans`),
  KEY `IDX_wd_pa_transactions14` (`dateestimated`),
  KEY `IDX_wd_pa_transactions15` (`dateactual`),
  KEY `IDX_wd_pa_transactions17` (`providerprocessdate`),
  KEY `IDX_wd_pa_transactions7` (`transid`)
) TYPE=MyISAM AUTO_INCREMENT=14568;

--
-- Table structure for table `transactions_reconcile_solutions`
--

DROP TABLE IF EXISTS `transactions_reconcile_solutions`;
CREATE TABLE `transactions_reconcile_solutions` (
  `recon_solution_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `solution` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`recon_solution_id`)
) TYPE=MyISAM AUTO_INCREMENT=5;

--
-- Table structure for table `transactions_reconcile_types`
--

DROP TABLE IF EXISTS `transactions_reconcile_types`;
CREATE TABLE `transactions_reconcile_types` (
  `recon_type_id` int(10) unsigned NOT NULL,
  `recon_type` varchar(45) NOT NULL,
  PRIMARY KEY (`recon_type_id`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_upload`
--

DROP TABLE IF EXISTS `transactions_upload`;
CREATE TABLE `transactions_upload` (
  `transid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(255) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`transid`),
  KEY `IDX_wd_pa_transactions8` (`transtype`,`reftrans`),
  KEY `IDX_wd_pa_transactions10` (`dateinserted`),
  KEY `IDX_wd_pa_transactions11` (`affiliateid`),
  KEY `IDX_wd_pa_transactions12` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions13` (`ip`),
  KEY `IDX_wd_pa_transactions9` (`dateestimated`),
  KEY `idx_external_visit_id` (`external_visit_id`),
  KEY `idx_dateadjusted` (`dateadjusted`),
  KEY `idx_reftrans` (`reftrans`)
) TYPE=MyISAM;

--
-- Table structure for table `transactions_upload_errors`
--

DROP TABLE IF EXISTS `transactions_upload_errors`;
CREATE TABLE `transactions_upload_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transid` varchar(36) DEFAULT NULL,
  `errorcode` int(11) DEFAULT NULL,
  `errordate` datetime DEFAULT NULL,
  `accountid` varchar(8) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `transtype` tinyint(4) DEFAULT '0',
  `payoutstatus` tinyint(4) DEFAULT '1',
  `datepayout` datetime DEFAULT NULL,
  `cookiestatus` tinyint(4) DEFAULT NULL,
  `orderid` varchar(200) DEFAULT NULL,
  `totalcost` float DEFAULT NULL,
  `bannerid` varchar(20) DEFAULT NULL,
  `transkind` tinyint(4) DEFAULT '0',
  `refererurl` varchar(250) DEFAULT NULL,
  `affiliateid` varchar(8) DEFAULT NULL,
  `campcategoryid` varchar(8) DEFAULT NULL,
  `parenttransid` varchar(8) DEFAULT NULL,
  `commission` float DEFAULT '0',
  `ip` varchar(40) DEFAULT NULL,
  `recurringcommid` varchar(8) DEFAULT NULL,
  `accountingid` varchar(8) DEFAULT NULL,
  `productid` varchar(200) DEFAULT NULL,
  `data1` varchar(80) DEFAULT NULL,
  `data2` varchar(80) DEFAULT NULL,
  `data3` varchar(80) DEFAULT NULL,
  `channel` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `timeslot` varchar(200) DEFAULT NULL,
  `exit` int(11) DEFAULT NULL,
  `page_position` int(11) DEFAULT NULL,
  `provideractionname` varchar(100) DEFAULT NULL,
  `providerorderid` varchar(100) DEFAULT NULL,
  `providertype` varchar(100) DEFAULT NULL,
  `providereventdate` datetime DEFAULT NULL,
  `providerprocessdate` datetime DEFAULT NULL,
  `merchantname` varchar(100) DEFAULT NULL,
  `providerid` varchar(100) DEFAULT NULL,
  `merchantsales` varchar(100) DEFAULT NULL,
  `providerchannel` varchar(100) DEFAULT NULL,
  `estimatedrevenue` double(10,2) DEFAULT NULL,
  `dateestimated` datetime DEFAULT NULL,
  `dateactual` datetime DEFAULT NULL,
  `estimateddatafilename` varchar(50) DEFAULT NULL,
  `actualdatafilename` varchar(50) DEFAULT NULL,
  `providerstatus` varchar(50) DEFAULT NULL,
  `providercorrected` varchar(50) DEFAULT NULL,
  `providerwebsiteid` varchar(50) DEFAULT NULL,
  `providerwebsitename` varchar(50) DEFAULT NULL,
  `provideractionid` varchar(50) DEFAULT NULL,
  `reftrans` varchar(36) DEFAULT NULL,
  `modifiedby` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `reversed` tinyint(1) NOT NULL DEFAULT '0',
  `dateadjusted` datetime DEFAULT NULL,
  `currref` varchar(32) DEFAULT NULL,
  `prevref` varchar(32) DEFAULT NULL,
  `thirdref` varchar(32) DEFAULT NULL,
  `external_visit_id` varchar(32) DEFAULT NULL,
  `refinceptiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_pa_transactions_2` (`dateinserted`),
  KEY `IDX_pa_transactions_3` (`transkind`,`transtype`,`rstatus`),
  KEY `IDX_pa_transactions_4` (`campcategoryid`),
  KEY `IDX_wd_pa_transactions4` (`bannerid`),
  KEY `IDX_wd_pa_transactions5` (`affiliateid`),
  KEY `IDX_wd_pa_transactions6` (`parenttransid`),
  KEY `IDX_wd_pa_transactions8` (`recurringcommid`),
  KEY `IDX_wd_pa_transactions9` (`accountingid`),
  KEY `IDX_wd_pa_transactions10` (`accountid`),
  KEY `IDX_wd_pa_transactions12` (`estimateddatafilename`),
  KEY `IDX_wd_pa_transactions13` (`actualdatafilename`),
  KEY `IDX_wd_pa_transactions11` (`reftrans`),
  KEY `IDX_wd_pa_transactions14` (`dateestimated`),
  KEY `IDX_wd_pa_transactions15` (`dateactual`),
  KEY `IDX_wd_pa_transactions17` (`providerprocessdate`),
  KEY `IDX_wd_pa_transactions7` (`transid`)
) TYPE=MyISAM AUTO_INCREMENT=2848;

--
-- Table structure for table `tuna_card_matches_by_day`
--

DROP TABLE IF EXISTS `tuna_card_matches_by_day`;
CREATE TABLE `tuna_card_matches_by_day` (
  `card_id` int(11) NOT NULL,
  `bucket_id` varchar(4) NOT NULL,
  `insert_date` date NOT NULL,
  `matches` int(11) NOT NULL,
  PRIMARY KEY (`card_id`,`bucket_id`,`insert_date`)
) TYPE=InnoDB;

--
-- Table structure for table `tuna_consent_log`
--

DROP TABLE IF EXISTS `tuna_consent_log`;
CREATE TABLE `tuna_consent_log` (
  `consent_id` varchar(32) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_initial` varchar(2) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `consent_version` int(11) NOT NULL,
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`consent_id`)
) TYPE=InnoDB;

--
-- Table structure for table `tuna_consent_versions`
--

DROP TABLE IF EXISTS `tuna_consent_versions`;
CREATE TABLE `tuna_consent_versions` (
  `consent_version` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`consent_version`)
) TYPE=InnoDB;

--
-- Table structure for table `tuna_error_codes`
--

DROP TABLE IF EXISTS `tuna_error_codes`;
CREATE TABLE `tuna_error_codes` (
  `error_code` varchar(11) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`error_code`)
) TYPE=InnoDB;

--
-- Table structure for table `tuna_requests`
--

DROP TABLE IF EXISTS `tuna_requests`;
CREATE TABLE `tuna_requests` (
  `request_id` varchar(24) NOT NULL,
  `external_visit_id` varchar(32) NOT NULL DEFAULT '0',
  `insert_time` datetime NOT NULL,
  `error_number` int(11) NOT NULL,
  PRIMARY KEY (`request_id`)
) TYPE=InnoDB;

--
-- Table structure for table `tuna_responses`
--

DROP TABLE IF EXISTS `tuna_responses`;
CREATE TABLE `tuna_responses` (
  `response_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` varchar(36) NOT NULL,
  `insert_date` datetime DEFAULT NULL,
  `error_codes` text,
  `approved_buckets` text,
  PRIMARY KEY (`response_id`)
) TYPE=InnoDB AUTO_INCREMENT=857336;

--
-- Table structure for table `upload_files`
--

DROP TABLE IF EXISTS `upload_files`;
CREATE TABLE `upload_files` (
  `upload_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `upload_file_name` varchar(255) NOT NULL DEFAULT '',
  `process_time` datetime NOT NULL,
  PRIMARY KEY (`upload_file_id`),
  KEY `up_prov_id_idx` (`provider_id`),
  KEY `up_upload_file_id_idx` (`upload_file_id`)
) TYPE=InnoDB AUTO_INCREMENT=10824;

--
-- Temporary table structure for view `vw_bankrate_transactions`
--

DROP TABLE IF EXISTS `vw_bankrate_transactions`;
/*!50001 DROP VIEW IF EXISTS `vw_bankrate_transactions`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_bankrate_transactions` (
 `transid` tinyint NOT NULL,
  `accountid` tinyint NOT NULL,
  `rstatus` tinyint NOT NULL,
  `dateinserted` tinyint NOT NULL,
  `dateapproved` tinyint NOT NULL,
  `transtype` tinyint NOT NULL,
  `payoutstatus` tinyint NOT NULL,
  `datepayout` tinyint NOT NULL,
  `cookiestatus` tinyint NOT NULL,
  `orderid` tinyint NOT NULL,
  `totalcost` tinyint NOT NULL,
  `bannerid` tinyint NOT NULL,
  `transkind` tinyint NOT NULL,
  `refererurl` tinyint NOT NULL,
  `affiliateid` tinyint NOT NULL,
  `campcategoryid` tinyint NOT NULL,
  `parenttransid` tinyint NOT NULL,
  `commission` tinyint NOT NULL,
  `ip` tinyint NOT NULL,
  `recurringcommid` tinyint NOT NULL,
  `accountingid` tinyint NOT NULL,
  `productid` tinyint NOT NULL,
  `data1` tinyint NOT NULL,
  `data2` tinyint NOT NULL,
  `data3` tinyint NOT NULL,
  `channel` tinyint NOT NULL,
  `episode` tinyint NOT NULL,
  `timeslot` tinyint NOT NULL,
  `exit` tinyint NOT NULL,
  `page_position` tinyint NOT NULL,
  `provideractionname` tinyint NOT NULL,
  `providerorderid` tinyint NOT NULL,
  `providertype` tinyint NOT NULL,
  `providereventdate` tinyint NOT NULL,
  `providerprocessdate` tinyint NOT NULL,
  `merchantname` tinyint NOT NULL,
  `providerid` tinyint NOT NULL,
  `merchantsales` tinyint NOT NULL,
  `quantity` tinyint NOT NULL,
  `providerchannel` tinyint NOT NULL,
  `estimatedrevenue` tinyint NOT NULL,
  `dateestimated` tinyint NOT NULL,
  `dateactual` tinyint NOT NULL,
  `estimateddatafilename` tinyint NOT NULL,
  `actualdatafilename` tinyint NOT NULL,
  `providerstatus` tinyint NOT NULL,
  `providercorrected` tinyint NOT NULL,
  `providerwebsiteid` tinyint NOT NULL,
  `providerwebsitename` tinyint NOT NULL,
  `provideractionid` tinyint NOT NULL,
  `modifiedby` tinyint NOT NULL,
  `reftrans` tinyint NOT NULL,
  `reversed` tinyint NOT NULL,
  `dateadjusted` tinyint NOT NULL,
  `currref` tinyint NOT NULL,
  `prevref` tinyint NOT NULL,
  `thirdref` tinyint NOT NULL,
  `external_visit_id` tinyint NOT NULL,
  `refinceptiondate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_ccx_cms_map`
--

DROP TABLE IF EXISTS `vw_ccx_cms_map`;
/*!50001 DROP VIEW IF EXISTS `vw_ccx_cms_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_ccx_cms_map` (
 `ccx_card_id` tinyint NOT NULL,
  `cms_card_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_additional_benefits`
--

DROP TABLE IF EXISTS `vw_cms_ccx_additional_benefits`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_benefits`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_additional_benefits` (
 `additional_benefit_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `benefit` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_additional_fees`
--

DROP TABLE IF EXISTS `vw_cms_ccx_additional_fees`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_fees`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_additional_fees` (
 `additional_fee_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `fee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_additional_notes`
--

DROP TABLE IF EXISTS `vw_cms_ccx_additional_notes`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_notes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_additional_notes` (
 `additional_note_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `note` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_approved_promotional_content`
--

DROP TABLE IF EXISTS `vw_cms_ccx_approved_promotional_content`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_approved_promotional_content`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_approved_promotional_content` (
 `approved_promotional_content_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `content` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_balance_transfers`
--

DROP TABLE IF EXISTS `vw_cms_ccx_balance_transfers`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_balance_transfers`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_balance_transfers` (
 `card_id` tinyint NOT NULL,
  `accept_partial_balance_transfer` tinyint NOT NULL,
  `intro_apr` tinyint NOT NULL,
  `intro_apr_used_rate_type` tinyint NOT NULL,
  `min_intro_period` tinyint NOT NULL,
  `max_intro_period` tinyint NOT NULL,
  `intro_period_end_date` tinyint NOT NULL,
  `min_ongoing_apr` tinyint NOT NULL,
  `min_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `max_ongoing_apr` tinyint NOT NULL,
  `max_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `min_default_apr` tinyint NOT NULL,
  `min_default_apr_used_rate_type` tinyint NOT NULL,
  `max_default_apr` tinyint NOT NULL,
  `max_default_apr_used_rate_type` tinyint NOT NULL,
  `min_grace_period` tinyint NOT NULL,
  `min_finance_charge` tinyint NOT NULL,
  `min_fixed_rate_period` tinyint NOT NULL,
  `min_fee` tinyint NOT NULL,
  `max_fee` tinyint NOT NULL,
  `fee_rate` tinyint NOT NULL,
  `min_transfer_amount` tinyint NOT NULL,
  `max_transfer_amount` tinyint NOT NULL,
  `min_payment_amount` tinyint NOT NULL,
  `min_payment_percentage` tinyint NOT NULL,
  `display_text` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_card_tags`
--

DROP TABLE IF EXISTS `vw_cms_ccx_card_tags`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_card_tags`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_card_tags` (
 `card_id` tinyint NOT NULL,
  `card_tag` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_cards`
--

DROP TABLE IF EXISTS `vw_cms_ccx_cards`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cards`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_cards` (
 `card_id` tinyint NOT NULL,
  `card_sku` tinyint NOT NULL,
  `issuer` tinyint NOT NULL,
  `effective_date` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `image` tinyint NOT NULL,
  `coissuing_organization` tinyint NOT NULL,
  `network` tinyint NOT NULL,
  `title` tinyint NOT NULL,
  `category` tinyint NOT NULL,
  `color` tinyint NOT NULL,
  `initial_setup_fee` tinyint NOT NULL,
  `first_annual_fee` tinyint NOT NULL,
  `ongoing_annual_fee` tinyint NOT NULL,
  `annual_fee_display_text` tinyint NOT NULL,
  `monthly_fee` tinyint NOT NULL,
  `min_late_payment_fee` tinyint NOT NULL,
  `max_late_payment_fee` tinyint NOT NULL,
  `late_payment_fee_percent` tinyint NOT NULL,
  `over_limit_fee` tinyint NOT NULL,
  `returned_payment_fee` tinyint NOT NULL,
  `dishonored_convenience_check_fee` tinyint NOT NULL,
  `convenience_check_stop_payment_fee` tinyint NOT NULL,
  `balance_transfer_cancellation_fee` tinyint NOT NULL,
  `bank_wire_payment_fee` tinyint NOT NULL,
  `statement_copy_fee` tinyint NOT NULL,
  `inactivity_fee` tinyint NOT NULL,
  `intro_apr` tinyint NOT NULL,
  `intro_apr_used_rate_type` tinyint NOT NULL,
  `intro_apr_display_text` tinyint NOT NULL,
  `min_intro_period` tinyint NOT NULL,
  `max_intro_period` tinyint NOT NULL,
  `intro_period_display_text` tinyint NOT NULL,
  `intro_period_end_date` tinyint NOT NULL,
  `min_ongoing_apr` tinyint NOT NULL,
  `min_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `max_ongoing_apr` tinyint NOT NULL,
  `max_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `ongoing_apr_display_text` tinyint NOT NULL,
  `min_default_apr` tinyint NOT NULL,
  `min_default_apr_used_rate_type` tinyint NOT NULL,
  `max_default_apr` tinyint NOT NULL,
  `max_default_apr_used_rate_type` tinyint NOT NULL,
  `min_grace_period` tinyint NOT NULL,
  `min_finance_charge` tinyint NOT NULL,
  `min_fixed_rate_period` tinyint NOT NULL,
  `balance_compute_method` tinyint NOT NULL,
  `min_payment_amount` tinyint NOT NULL,
  `min_payment_percentage` tinyint NOT NULL,
  `credit_needed` tinyint NOT NULL,
  `credit_needed_display_text` tinyint NOT NULL,
  `min_credit_line` tinyint NOT NULL,
  `max_credit_line` tinyint NOT NULL,
  `min_income` tinyint NOT NULL,
  `min_between_applications_period` tinyint NOT NULL,
  `interest_rate_type` tinyint NOT NULL,
  `used_index_rate` tinyint NOT NULL,
  `index_rate_definition` tinyint NOT NULL,
  `apply_payment` tinyint NOT NULL,
  `foreign_exchange_min_fee` tinyint NOT NULL,
  `foreign_exchange_max_fee` tinyint NOT NULL,
  `foreign_exchange_fee_rate` tinyint NOT NULL,
  `custom_prepaid_display_text` tinyint NOT NULL,
  `modified_date` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `bt_intro_apr_display_text` tinyint NOT NULL,
  `bt_intro_period_display_text` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_cash_advances`
--

DROP TABLE IF EXISTS `vw_cms_ccx_cash_advances`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cash_advances`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_cash_advances` (
 `card_id` tinyint NOT NULL,
  `intro_apr` tinyint NOT NULL,
  `intro_apr_used_rate_type` tinyint NOT NULL,
  `min_intro_period` tinyint NOT NULL,
  `max_intro_period` tinyint NOT NULL,
  `intro_period_end_date` tinyint NOT NULL,
  `min_ongoing_apr` tinyint NOT NULL,
  `min_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `max_ongoing_apr` tinyint NOT NULL,
  `max_ongoing_apr_used_rate_type` tinyint NOT NULL,
  `min_default_apr` tinyint NOT NULL,
  `min_default_apr_used_rate_type` tinyint NOT NULL,
  `max_default_apr` tinyint NOT NULL,
  `max_default_apr_used_rate_type` tinyint NOT NULL,
  `min_grace_period` tinyint NOT NULL,
  `min_finance_charge` tinyint NOT NULL,
  `min_fixed_rate_period` tinyint NOT NULL,
  `min_fee` tinyint NOT NULL,
  `max_fee` tinyint NOT NULL,
  `fee_rate` tinyint NOT NULL,
  `max_convenience_check_fee` tinyint NOT NULL,
  `min_payment_amount` tinyint NOT NULL,
  `min_payment_percentage` tinyint NOT NULL,
  `cash_advance_limit` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_cash_back`
--

DROP TABLE IF EXISTS `vw_cms_ccx_cash_back`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cash_back`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_cash_back` (
 `card_id` tinyint NOT NULL,
  `base_reward_amount` tinyint NOT NULL,
  `special_reward_amount` tinyint NOT NULL,
  `special_reward_description` tinyint NOT NULL,
  `first_round_bonus` tinyint NOT NULL,
  `annual_bonus` tinyint NOT NULL,
  `other_bonus` tinyint NOT NULL,
  `intro_reward_period` tinyint NOT NULL,
  `intro_reward_amount` tinyint NOT NULL,
  `intro_special_reward_amount` tinyint NOT NULL,
  `max_annual_reward` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_commercial_features`
--

DROP TABLE IF EXISTS `vw_cms_ccx_commercial_features`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_commercial_features`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_commercial_features` (
 `card_id` tinyint NOT NULL,
  `reporting_features` tinyint NOT NULL,
  `travel_expense_management` tinyint NOT NULL,
  `purchasing_expense_management` tinyint NOT NULL,
  `fleet_expense_management` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_frequent_flier`
--

DROP TABLE IF EXISTS `vw_cms_ccx_frequent_flier`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_frequent_flier`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_frequent_flier` (
 `card_id` tinyint NOT NULL,
  `base_reward_amount` tinyint NOT NULL,
  `special_reward_amount` tinyint NOT NULL,
  `special_reward_description` tinyint NOT NULL,
  `which_airlines` tinyint NOT NULL,
  `subject_to_blackout_dates` tinyint NOT NULL,
  `first_purchase_bonus` tinyint NOT NULL,
  `other_bonus` tinyint NOT NULL,
  `intro_reward_period` tinyint NOT NULL,
  `intro_reward_amount` tinyint NOT NULL,
  `intro_special_reward_amount` tinyint NOT NULL,
  `max_annual_reward` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_other_benefits`
--

DROP TABLE IF EXISTS `vw_cms_ccx_other_benefits`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_other_benefits`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_other_benefits` (
 `card_id` tinyint NOT NULL,
  `insurance` tinyint NOT NULL,
  `retail_discounts` tinyint NOT NULL,
  `extended_warranties` tinyint NOT NULL,
  `roadside_assistance` tinyint NOT NULL,
  `security_identity_solution` tinyint NOT NULL,
  `account_protection` tinyint NOT NULL,
  `consierge_service` tinyint NOT NULL,
  `card_design` tinyint NOT NULL,
  `mini_card` tinyint NOT NULL,
  `photo_security` tinyint NOT NULL,
  `personalization` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_point_rewards`
--

DROP TABLE IF EXISTS `vw_cms_ccx_point_rewards`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_point_rewards`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_point_rewards` (
 `card_id` tinyint NOT NULL,
  `base_reward_amount` tinyint NOT NULL,
  `special_reward_amount` tinyint NOT NULL,
  `special_reward_description` tinyint NOT NULL,
  `where_points_redeemed` tinyint NOT NULL,
  `value_of_points` tinyint NOT NULL,
  `first_purchase_bonus` tinyint NOT NULL,
  `other_bonus` tinyint NOT NULL,
  `intro_reward_period` tinyint NOT NULL,
  `intro_reward_amount` tinyint NOT NULL,
  `intro_special_reward_amount` tinyint NOT NULL,
  `max_annual_reward` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cms_ccx_prepaid_card_fees`
--

DROP TABLE IF EXISTS `vw_cms_ccx_prepaid_card_fees`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_prepaid_card_fees`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cms_ccx_prepaid_card_fees` (
 `card_id` tinyint NOT NULL,
  `replacement_card_fee` tinyint NOT NULL,
  `atm_fee` tinyint NOT NULL,
  `live_teller_withdrawal_fee` tinyint NOT NULL,
  `atm_balance_inquiry_fee` tinyint NOT NULL,
  `monthly_inactive_account_fee` tinyint NOT NULL,
  `automated_telephone_inquiry_fee` tinyint NOT NULL,
  `customer_service_live_call_fee` tinyint NOT NULL,
  `activation_fee` tinyint NOT NULL,
  `cancel_card_fee` tinyint NOT NULL,
  `application_fee` tinyint NOT NULL,
  `purchase_merchant_fee` tinyint NOT NULL,
  `purchase_online_fee` tinyint NOT NULL,
  `purchase_telephone_fee` tinyint NOT NULL,
  `signature_transaction_fee` tinyint NOT NULL,
  `pin_transaction_fee` tinyint NOT NULL,
  `load_fee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_cp_quizzes`
--

DROP TABLE IF EXISTS `vw_cp_quizzes`;
/*!50001 DROP VIEW IF EXISTS `vw_cp_quizzes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_cp_quizzes` (
 `quiz_id` tinyint NOT NULL,
  `title` tinyint NOT NULL,
  `intro_text` tinyint NOT NULL,
  `pre_result_text` tinyint NOT NULL,
  `goodbye_text` tinyint NOT NULL,
  `default_submit_text` tinyint NOT NULL,
  `question_plume` tinyint NOT NULL,
  `fid` tinyint NOT NULL,
  `keywords` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `actual_page_title` tinyint NOT NULL,
  `update_time` tinyint NOT NULL,
  `active` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_historical_2depc_rates_consolidated_card_group`
--

DROP TABLE IF EXISTS `vw_historical_2depc_rates_consolidated_card_group`;
/*!50001 DROP VIEW IF EXISTS `vw_historical_2depc_rates_consolidated_card_group`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_historical_2depc_rates_consolidated_card_group` (
 `rate_id` tinyint NOT NULL,
  `click_date` tinyint NOT NULL,
  `click_month` tinyint NOT NULL,
  `card` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `card_name` tinyint NOT NULL,
  `card_group_id` tinyint NOT NULL,
  `card_group_name` tinyint NOT NULL,
  `merchant_id` tinyint NOT NULL,
  `merchant_name` tinyint NOT NULL,
  `exit_page_id` tinyint NOT NULL,
  `exit_page_name` tinyint NOT NULL,
  `estimated_epc` tinyint NOT NULL,
  `actual_epc` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_sales_rate`
--

DROP TABLE IF EXISTS `vw_sales_rate`;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_sales_rate` (
 `sales_rate_id` tinyint NOT NULL,
  `click_date` tinyint NOT NULL,
  `click_month` tinyint NOT NULL,
  `card` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `card_name` tinyint NOT NULL,
  `merchant_id` tinyint NOT NULL,
  `merchant_name` tinyint NOT NULL,
  `exit_page_id` tinyint NOT NULL,
  `exit_page_name` tinyint NOT NULL,
  `application_count` tinyint NOT NULL,
  `click_count` tinyint NOT NULL,
  `sales_count` tinyint NOT NULL,
  `revenue_amt` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_sales_rate_consolidated`
--

DROP TABLE IF EXISTS `vw_sales_rate_consolidated`;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate_consolidated`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_sales_rate_consolidated` (
 `sales_rate_id` tinyint NOT NULL,
  `click_date` tinyint NOT NULL,
  `click_month` tinyint NOT NULL,
  `card` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `card_name` tinyint NOT NULL,
  `merchant_id` tinyint NOT NULL,
  `merchant_name` tinyint NOT NULL,
  `exit_page_id` tinyint NOT NULL,
  `exit_page_name` tinyint NOT NULL,
  `application_count` tinyint NOT NULL,
  `click_count` tinyint NOT NULL,
  `sales_count` tinyint NOT NULL,
  `revenue_amt` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_sales_rate_summary_transactions`
--

DROP TABLE IF EXISTS `vw_sales_rate_summary_transactions`;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate_summary_transactions`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_sales_rate_summary_transactions` (
 `transid` tinyint NOT NULL,
  `transtype` tinyint NOT NULL,
  `dateinserted` tinyint NOT NULL,
  `quantity` tinyint NOT NULL,
  `estimatedrevenue` tinyint NOT NULL,
  `bannerid` tinyint NOT NULL,
  `exit_page_id` tinyint NOT NULL,
  `card_match` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_summary_day_offer_clicks_by_page`
--

DROP TABLE IF EXISTS `vw_summary_day_offer_clicks_by_page`;
/*!50001 DROP VIEW IF EXISTS `vw_summary_day_offer_clicks_by_page`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_summary_day_offer_clicks_by_page` (
 `web_page_id` tinyint NOT NULL,
  `click_date` tinyint NOT NULL,
  `page_title` tinyint NOT NULL,
  `click_count` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_summary_day_page_views_by_page`
--

DROP TABLE IF EXISTS `vw_summary_day_page_views_by_page`;
/*!50001 DROP VIEW IF EXISTS `vw_summary_day_page_views_by_page`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_summary_day_page_views_by_page` (
 `web_page_id` tinyint NOT NULL,
  `view_date` tinyint NOT NULL,
  `page_title` tinyint NOT NULL,
  `view_count` tinyint NOT NULL,
  `landing_count` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_trans_type_calculate_commission`
--

DROP TABLE IF EXISTS `vw_trans_type_calculate_commission`;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_calculate_commission`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_trans_type_calculate_commission` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_trans_type_count_as_sale`
--

DROP TABLE IF EXISTS `vw_trans_type_count_as_sale`;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_count_as_sale`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_trans_type_count_as_sale` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_trans_type_is_rev_split`
--

DROP TABLE IF EXISTS `vw_trans_type_is_rev_split`;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_is_rev_split`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_trans_type_is_rev_split` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_trans_type_sum_as_epc`
--

DROP TABLE IF EXISTS `vw_trans_type_sum_as_epc`;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_sum_as_epc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_trans_type_sum_as_epc` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_trans_type_sum_as_revenue`
--

DROP TABLE IF EXISTS `vw_trans_type_sum_as_revenue`;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_sum_as_revenue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_trans_type_sum_as_revenue` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_transtype_reporting`
--

DROP TABLE IF EXISTS `vw_transtype_reporting`;
/*!50001 DROP VIEW IF EXISTS `vw_transtype_reporting`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_transtype_reporting` (
 `transaction_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_us_publish_history`
--

DROP TABLE IF EXISTS `vw_us_publish_history`;
/*!50001 DROP VIEW IF EXISTS `vw_us_publish_history`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_us_publish_history` (
 `build_history_id` tinyint NOT NULL,
  `site_id` tinyint NOT NULL,
  `build_time` tinyint NOT NULL,
  `user_id` tinyint NOT NULL,
  `published` tinyint NOT NULL,
  `publish_time` tinyint NOT NULL,
  `note` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_us_publish_history_detail`
--

DROP TABLE IF EXISTS `vw_us_publish_history_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_us_publish_history_detail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_us_publish_history_detail` (
 `build_history_detail_id` tinyint NOT NULL,
  `build_history_id` tinyint NOT NULL,
  `web_page_id` tinyint NOT NULL,
  `sub_page_id` tinyint NOT NULL,
  `card_id` tinyint NOT NULL,
  `web_page_position` tinyint NOT NULL,
  `sub_page_position` tinyint NOT NULL,
  `web_page_number` tinyint NOT NULL,
  `estimated_epc` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wd_g_history`
--

DROP TABLE IF EXISTS `wd_g_history`;
CREATE TABLE `wd_g_history` (
  `historyid` varchar(36) NOT NULL DEFAULT '',
  `accountid` varchar(8) DEFAULT NULL,
  `rtype` tinyint(4) NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  `dateinserted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hfile` text,
  `line` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `module` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`historyid`),
  KEY `idx_dateinserted` (`dateinserted`)
) TYPE=MyISAM;

--
-- Table structure for table `wd_g_listviews`
--

DROP TABLE IF EXISTS `wd_g_listviews`;
CREATE TABLE `wd_g_listviews` (
  `viewid` varchar(8) NOT NULL DEFAULT '',
  `accountid` varchar(8) NOT NULL DEFAULT '',
  `userid` varchar(8) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `rcolumns` text NOT NULL,
  `listname` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`viewid`,`accountid`,`userid`),
  KEY `IDX_wd_g_listviews1` (`accountid`),
  KEY `IDX_wd_g_listviews2` (`userid`)
) TYPE=MyISAM;

--
-- Table structure for table `wd_g_righttypes`
--

DROP TABLE IF EXISTS `wd_g_righttypes`;
CREATE TABLE `wd_g_righttypes` (
  `righttypeid` varchar(8) NOT NULL DEFAULT '',
  `parentrighttypeid` varchar(8) DEFAULT NULL,
  `module` varchar(20) NOT NULL DEFAULT '',
  `category` varchar(40) NOT NULL DEFAULT '',
  `code` varchar(40) NOT NULL DEFAULT '',
  `righttype` varchar(20) DEFAULT NULL,
  `dateinserted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `categorylangid` varchar(80) NOT NULL DEFAULT '',
  `rightlangid` varchar(80) NOT NULL DEFAULT '',
  `typelangid` varchar(80) NOT NULL DEFAULT '',
  `rorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`righttypeid`),
  UNIQUE KEY `IDX_wd_g_righttypes1` (`righttypeid`),
  KEY `IDX_wd_g_righttypes2` (`parentrighttypeid`)
) TYPE=MyISAM;

--
-- Table structure for table `wd_g_settings`
--

DROP TABLE IF EXISTS `wd_g_settings`;
CREATE TABLE `wd_g_settings` (
  `settingsid` varchar(8) NOT NULL DEFAULT '',
  `rtype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL DEFAULT '',
  `value` text,
  `accountid` varchar(8) DEFAULT NULL,
  `userid` varchar(8) DEFAULT NULL,
  `id1` varchar(8) DEFAULT NULL,
  `id2` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`settingsid`),
  KEY `IDX_wd_g_settings2` (`userid`)
) TYPE=MyISAM;

--
-- Table structure for table `wd_g_userrights`
--

DROP TABLE IF EXISTS `wd_g_userrights`;
CREATE TABLE `wd_g_userrights` (
  `userrightid` char(8) NOT NULL DEFAULT '',
  `userprofileid` char(8) NOT NULL DEFAULT '',
  `righttypeid` char(8) DEFAULT NULL,
  PRIMARY KEY (`userrightid`),
  KEY `IDX_wd_g_userrights1` (`userprofileid`),
  KEY `IDX_wd_g_userrights2` (`righttypeid`)
) TYPE=MyISAM;

--
-- Table structure for table `wd_g_users`
--

DROP TABLE IF EXISTS `wd_g_users`;
CREATE TABLE `wd_g_users` (
  `userid` varchar(8) NOT NULL DEFAULT '',
  `accountid` varchar(8) NOT NULL DEFAULT '',
  `refid` varchar(20) DEFAULT NULL,
  `username` varchar(60) NOT NULL DEFAULT '',
  `rpassword` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT '0',
  `product` varchar(10) NOT NULL DEFAULT '',
  `dateinserted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `userprofileid` varchar(8) DEFAULT NULL,
  `rtype` tinyint(4) NOT NULL DEFAULT '0',
  `parentuserid` varchar(8) DEFAULT NULL,
  `leftnumber` int(11) DEFAULT NULL,
  `rightnumber` int(11) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `weburl` varchar(250) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `zipcode` varchar(40) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `tax_ssn` varchar(100) DEFAULT NULL,
  `data1` varchar(250) DEFAULT NULL,
  `data2` varchar(250) DEFAULT NULL,
  `data3` varchar(250) DEFAULT NULL,
  `data4` varchar(250) DEFAULT NULL,
  `data5` varchar(250) DEFAULT NULL,
  `payoptid` varchar(8) DEFAULT NULL,
  `originalparentid` varchar(8) DEFAULT NULL,
  `flags` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `idx_refid` (`refid`),
  KEY `IDX_pa_affiliates_2` (`username`,`rpassword`),
  KEY `IDX_wd_g_users5` (`userprofileid`),
  KEY `IDX_wd_g_users6` (`parentuserid`),
  KEY `IDX_wd_g_users7` (`payoptid`),
  KEY `IDX_wd_g_users8` (`originalparentid`)
) TYPE=MyISAM;

--
-- Final view structure for view `card_boost`
--

/*!50001 DROP TABLE IF EXISTS `card_boost`*/;
/*!50001 DROP VIEW IF EXISTS `card_boost`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `card_boost` AS select `ccdata_test`.`card_boost`.`card_id` AS `card_id`,`ccdata_test`.`card_boost`.`boost` AS `boost` from `ccdata_test`.`card_boost` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_alternate_links`
--

/*!50001 DROP TABLE IF EXISTS `cms_alternate_links`*/;
/*!50001 DROP VIEW IF EXISTS `cms_alternate_links`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_alternate_links` AS select `ccdata_test`.`alternate_links`.`affiliate_id` AS `affiliate_id`,`ccdata_test`.`alternate_links`.`clickable_id` AS `clickable_id`,`ccdata_test`.`alternate_links`.`url` AS `url`,`ccdata_test`.`alternate_links`.`website_id` AS `website_id` from `ccdata_test`.`alternate_links` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_categories`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_categories`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_categories`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_categories` AS select `ccdata_test`.`card_categories`.`card_category_id` AS `card_category_id`,`ccdata_test`.`card_categories`.`card_category_name` AS `card_category_name`,`ccdata_test`.`card_categories`.`card_category_display_name` AS `card_category_display_name`,`ccdata_test`.`card_categories`.`deleted` AS `deleted` from `ccdata_test`.`card_categories` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_category_contexts`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_category_contexts`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_contexts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_category_contexts` AS select `ccdata_test`.`card_category_contexts`.`card_category_context_id` AS `card_category_context_id`,`ccdata_test`.`card_category_contexts`.`card_category_context_name` AS `card_category_context_name` from `ccdata_test`.`card_category_contexts` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_category_group_to_category`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_category_group_to_category`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_group_to_category`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_category_group_to_category` AS select `ccdata_test`.`card_category_group_to_category`.`card_category_group_id` AS `card_category_group_id`,`ccdata_test`.`card_category_group_to_category`.`card_category_id` AS `card_category_id`,`ccdata_test`.`card_category_group_to_category`.`card_category_group_rank` AS `card_category_group_rank` from `ccdata_test`.`card_category_group_to_category` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_category_groups`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_category_groups`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_groups`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_category_groups` AS select `ccdata_test`.`card_category_groups`.`id` AS `id`,`ccdata_test`.`card_category_groups`.`card_category_group_name` AS `card_category_group_name`,`ccdata_test`.`card_category_groups`.`context_id` AS `context_id`,`ccdata_test`.`card_category_groups`.`inserted` AS `inserted`,`ccdata_test`.`card_category_groups`.`updated` AS `updated` from `ccdata_test`.`card_category_groups` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_category_ranks`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_category_ranks`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_category_ranks`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_category_ranks` AS select `ccdata_test`.`card_category_ranks`.`card_category_rank_id` AS `card_category_rank_id`,`ccdata_test`.`card_category_ranks`.`card_category_rank` AS `card_category_rank`,`ccdata_test`.`card_category_ranks`.`card_category_context_id` AS `card_category_context_id`,`ccdata_test`.`card_category_ranks`.`card_category_id` AS `card_category_id` from `ccdata_test`.`card_category_ranks` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_data`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_data`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_data`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_data` AS select `ccdata_test`.`cs_carddata`.`cardId` AS `cardId`,`ccdata_test`.`cs_carddata`.`introApr` AS `introApr`,`ccdata_test`.`cs_carddata`.`introAprPeriod` AS `introAprPeriod`,`ccdata_test`.`cs_carddata`.`regularApr` AS `regularApr`,`ccdata_test`.`cs_carddata`.`annualFee` AS `annualFee`,`ccdata_test`.`cs_carddata`.`balanceTransfers` AS `balanceTransfers`,`ccdata_test`.`cs_carddata`.`balanceTransferFee` AS `balanceTransferFee`,`ccdata_test`.`cs_carddata`.`balanceTransferIntroApr` AS `balanceTransferIntroApr`,`ccdata_test`.`cs_carddata`.`balanceTransferIntroAprPeriod` AS `balanceTransferIntroAprPeriod`,`ccdata_test`.`cs_carddata`.`monthlyFee` AS `monthlyFee`,`ccdata_test`.`cs_carddata`.`creditNeeded` AS `creditNeeded`,`ccdata_test`.`cs_carddata`.`dateModified` AS `dateModified` from `ccdata_test`.`cs_carddata` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_details`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_details`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_details` AS select `ccdata_test`.`rt_carddetails`.`id` AS `id`,`ccdata_test`.`rt_carddetails`.`cardShortName` AS `cardShortName`,`ccdata_test`.`rt_carddetails`.`cardLink` AS `cardLink`,`ccdata_test`.`rt_carddetails`.`appLink` AS `appLink`,`ccdata_test`.`rt_carddetails`.`cardDetailVersion` AS `cardDetailVersion`,`ccdata_test`.`rt_carddetails`.`cardDetailLabel` AS `cardDetailLabel`,`ccdata_test`.`rt_carddetails`.`cardId` AS `cardId`,`ccdata_test`.`rt_carddetails`.`campaignLink` AS `campaignLink`,`ccdata_test`.`rt_carddetails`.`cardPageMeta` AS `cardPageMeta`,`ccdata_test`.`rt_carddetails`.`cardDetailText` AS `cardDetailText`,`ccdata_test`.`rt_carddetails`.`cardIntroDetail` AS `cardIntroDetail`,`ccdata_test`.`rt_carddetails`.`cardMoreDetail` AS `cardMoreDetail`,`ccdata_test`.`rt_carddetails`.`cardSeeDetails` AS `cardSeeDetails`,`ccdata_test`.`rt_carddetails`.`categoryImage` AS `categoryImage`,`ccdata_test`.`rt_carddetails`.`categoryAltText` AS `categoryAltText`,`ccdata_test`.`rt_carddetails`.`cardIOImage` AS `cardIOImage`,`ccdata_test`.`rt_carddetails`.`cardIOAltText` AS `cardIOAltText`,`ccdata_test`.`rt_carddetails`.`cardButtonImage` AS `cardButtonImage`,`ccdata_test`.`rt_carddetails`.`cardButtonAltText` AS `cardButtonAltText`,`ccdata_test`.`rt_carddetails`.`cardIOButtonAltText` AS `cardIOButtonAltText`,`ccdata_test`.`rt_carddetails`.`cardIconSmall` AS `cardIconSmall`,`ccdata_test`.`rt_carddetails`.`cardIconMid` AS `cardIconMid`,`ccdata_test`.`rt_carddetails`.`cardIconLarge` AS `cardIconLarge`,`ccdata_test`.`rt_carddetails`.`detailOrder` AS `detailOrder`,`ccdata_test`.`rt_carddetails`.`dateCreated` AS `dateCreated`,`ccdata_test`.`rt_carddetails`.`dateUpdated` AS `dateUpdated`,`ccdata_test`.`rt_carddetails`.`fid` AS `fid`,`ccdata_test`.`rt_carddetails`.`cardListingString` AS `cardListingString`,`ccdata_test`.`rt_carddetails`.`cardPageHeaderString` AS `cardPageHeaderString`,`ccdata_test`.`rt_carddetails`.`imageAltText` AS `imageAltText`,`ccdata_test`.`rt_carddetails`.`active` AS `active`,`ccdata_test`.`rt_carddetails`.`deleted` AS `deleted`,`ccdata_test`.`rt_carddetails`.`specialsDescription` AS `specialsDescription`,`ccdata_test`.`rt_carddetails`.`specialsAdditionalLink` AS `specialsAdditionalLink`,`ccdata_test`.`rt_carddetails`.`cardTeaserText` AS `cardTeaserText` from `ccdata_test`.`rt_carddetails` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_exclusion_map`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_exclusion_map`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_exclusion_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_exclusion_map` AS select `ccdata_test`.`cs_pagecardexclusionmap`.`mapid` AS `mapid`,`ccdata_test`.`cs_pagecardexclusionmap`.`siteid` AS `siteid`,`ccdata_test`.`cs_pagecardexclusionmap`.`pageid` AS `pageid`,`ccdata_test`.`cs_pagecardexclusionmap`.`cardid` AS `cardid` from `ccdata_test`.`cs_pagecardexclusionmap` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_history`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_history`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_history`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_history` AS select `ccdata_test`.`cardhistory`.`campaigntype_id` AS `campaigntype_id`,`ccdata_test`.`cardhistory`.`dateinserted` AS `dateinserted`,`ccdata_test`.`cardhistory`.`campaigntype_name` AS `campaigntype_name`,`ccdata_test`.`cardhistory`.`intro_apr` AS `intro_apr`,`ccdata_test`.`cardhistory`.`delta_intro_apr` AS `delta_intro_apr`,`ccdata_test`.`cardhistory`.`intro_apr_movement` AS `intro_apr_movement`,`ccdata_test`.`cardhistory`.`intro_apr_period` AS `intro_apr_period`,`ccdata_test`.`cardhistory`.`delta_intro_apr_period` AS `delta_intro_apr_period`,`ccdata_test`.`cardhistory`.`intro_apr_period_movement` AS `intro_apr_period_movement`,`ccdata_test`.`cardhistory`.`regular_apr` AS `regular_apr`,`ccdata_test`.`cardhistory`.`delta_regular_apr` AS `delta_regular_apr`,`ccdata_test`.`cardhistory`.`regular_apr_movement` AS `regular_apr_movement` from `ccdata_test`.`cardhistory` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_page_map`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_page_map`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_page_map` AS select `ccdata_test`.`rt_cardpagemap`.`cardcategorymapId` AS `cardcategorymapId`,`ccdata_test`.`rt_cardpagemap`.`pageInsert` AS `pageInsert`,`ccdata_test`.`rt_cardpagemap`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_cardpagemap`.`cardId` AS `cardId`,`ccdata_test`.`rt_cardpagemap`.`rank` AS `rank` from `ccdata_test`.`rt_cardpagemap` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_page_map_affiliate`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_page_map_affiliate`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map_affiliate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_page_map_affiliate` AS select `ccdata_test`.`rt_cardpagemap_affiliate`.`cardcategorymapId` AS `cardcategorymapId`,`ccdata_test`.`rt_cardpagemap_affiliate`.`pageInsert` AS `pageInsert`,`ccdata_test`.`rt_cardpagemap_affiliate`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_cardpagemap_affiliate`.`cardId` AS `cardId`,`ccdata_test`.`rt_cardpagemap_affiliate`.`rank` AS `rank` from `ccdata_test`.`rt_cardpagemap_affiliate` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_page_map_bankrate`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_page_map_bankrate`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_page_map_bankrate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_page_map_bankrate` AS select `ccdata_test`.`rt_cardpagemap_bankrate`.`cardcategorymapId` AS `cardcategorymapId`,`ccdata_test`.`rt_cardpagemap_bankrate`.`pageInsert` AS `pageInsert`,`ccdata_test`.`rt_cardpagemap_bankrate`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_cardpagemap_bankrate`.`cardId` AS `cardId`,`ccdata_test`.`rt_cardpagemap_bankrate`.`rank` AS `rank` from `ccdata_test`.`rt_cardpagemap_bankrate` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_placement_history`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_placement_history`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_placement_history`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_placement_history` AS select `cms`.`card_placement_history`.`cardpageId` AS `cardpageId`,`cms`.`card_placement_history`.`cardId` AS `cardId`,`cms`.`card_placement_history`.`rank` AS `rank`,`cms`.`card_placement_history`.`active` AS `active`,`cms`.`card_placement_history`.`time_snapped` AS `time_snapped` from `cms`.`card_placement_history` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_card_ranks`
--

/*!50001 DROP TABLE IF EXISTS `cms_card_ranks`*/;
/*!50001 DROP VIEW IF EXISTS `cms_card_ranks`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_card_ranks` AS select `ccdata_test`.`card_ranks`.`card_rank_id` AS `card_rank_id`,`ccdata_test`.`card_ranks`.`card_rank` AS `card_rank`,`ccdata_test`.`card_ranks`.`card_category_context_id` AS `card_category_context_id`,`ccdata_test`.`card_ranks`.`card_category_id` AS `card_category_id`,`ccdata_test`.`card_ranks`.`card_id` AS `card_id` from `ccdata_test`.`card_ranks` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_cards`
--

/*!50001 DROP TABLE IF EXISTS `cms_cards`*/;
/*!50001 DROP VIEW IF EXISTS `cms_cards`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_cards` AS select `ccdata_test`.`rt_cards`.`id` AS `id`,`ccdata_test`.`rt_cards`.`cardId` AS `cardId`,`ccdata_test`.`rt_cards`.`site_code` AS `site_code`,`ccdata_test`.`rt_cards`.`cardTitle` AS `cardTitle`,`ccdata_test`.`rt_cards`.`cardDescription` AS `cardDescription`,`ccdata_test`.`rt_cards`.`merchant` AS `merchant`,`ccdata_test`.`rt_cards`.`introApr` AS `introApr`,`ccdata_test`.`rt_cards`.`active_introApr` AS `active_introApr`,`ccdata_test`.`rt_cards`.`introAprPeriod` AS `introAprPeriod`,`ccdata_test`.`rt_cards`.`active_introAprPeriod` AS `active_introAprPeriod`,`ccdata_test`.`rt_cards`.`regularApr` AS `regularApr`,`ccdata_test`.`rt_cards`.`variable` AS `variable`,`ccdata_test`.`rt_cards`.`active_regularApr` AS `active_regularApr`,`ccdata_test`.`rt_cards`.`annualFee` AS `annualFee`,`ccdata_test`.`rt_cards`.`active_annualFee` AS `active_annualFee`,`ccdata_test`.`rt_cards`.`monthlyFee` AS `monthlyFee`,`ccdata_test`.`rt_cards`.`active_monthlyFee` AS `active_monthlyFee`,`ccdata_test`.`rt_cards`.`balanceTransfers` AS `balanceTransfers`,`ccdata_test`.`rt_cards`.`active_balanceTransfers` AS `active_balanceTransfers`,`ccdata_test`.`rt_cards`.`balanceTransferFee` AS `balanceTransferFee`,`ccdata_test`.`rt_cards`.`active_balanceTransferFee` AS `active_balanceTransferFee`,`ccdata_test`.`rt_cards`.`balanceTransferIntroApr` AS `balanceTransferIntroApr`,`ccdata_test`.`rt_cards`.`active_balanceTransferIntroApr` AS `active_balanceTransferIntroApr`,`ccdata_test`.`rt_cards`.`balanceTransferIntroAprPeriod` AS `balanceTransferIntroAprPeriod`,`ccdata_test`.`rt_cards`.`active_balanceTransferIntroAprPeriod` AS `active_balanceTransferIntroAprPeriod`,`ccdata_test`.`rt_cards`.`creditNeeded` AS `creditNeeded`,`ccdata_test`.`rt_cards`.`active_creditNeeded` AS `active_creditNeeded`,`ccdata_test`.`rt_cards`.`imagePath` AS `imagePath`,`ccdata_test`.`rt_cards`.`ratesAndFees` AS `ratesAndFees`,`ccdata_test`.`rt_cards`.`rewards` AS `rewards`,`ccdata_test`.`rt_cards`.`cardBenefits` AS `cardBenefits`,`ccdata_test`.`rt_cards`.`onlineServices` AS `onlineServices`,`ccdata_test`.`rt_cards`.`footNotes` AS `footNotes`,`ccdata_test`.`rt_cards`.`layout` AS `layout`,`ccdata_test`.`rt_cards`.`dateCreated` AS `dateCreated`,`ccdata_test`.`rt_cards`.`dateUpdated` AS `dateUpdated`,`ccdata_test`.`rt_cards`.`subCat` AS `subCat`,`ccdata_test`.`rt_cards`.`catTitle` AS `catTitle`,`ccdata_test`.`rt_cards`.`catDescription` AS `catDescription`,`ccdata_test`.`rt_cards`.`catImage` AS `catImage`,`ccdata_test`.`rt_cards`.`catImageAltText` AS `catImageAltText`,`ccdata_test`.`rt_cards`.`syndicate` AS `syndicate`,`ccdata_test`.`rt_cards`.`url` AS `url`,`ccdata_test`.`rt_cards`.`applyByPhoneNumber` AS `applyByPhoneNumber`,`ccdata_test`.`rt_cards`.`tPageText` AS `tPageText`,`ccdata_test`.`rt_cards`.`private` AS `private`,`ccdata_test`.`rt_cards`.`active` AS `active`,`ccdata_test`.`rt_cards`.`deleted` AS `deleted`,`ccdata_test`.`rt_cards`.`active_epd_pages` AS `active_epd_pages`,`ccdata_test`.`rt_cards`.`active_show_epd_rates` AS `active_show_epd_rates`,`ccdata_test`.`rt_cards`.`show_verify` AS `show_verify`,`ccdata_test`.`rt_cards`.`commission_label` AS `commission_label`,`ccdata_test`.`rt_cards`.`payout_cap` AS `payout_cap`,`ccdata_test`.`rt_cards`.`card_level_id` AS `card_level_id`,`ccdata_test`.`rt_cards`.`requires_approval` AS `requires_approval`,`ccdata_test`.`rt_cards`.`secured` AS `secured` from `ccdata_test`.`rt_cards` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_merchant_service_details`
--

/*!50001 DROP TABLE IF EXISTS `cms_merchant_service_details`*/;
/*!50001 DROP VIEW IF EXISTS `cms_merchant_service_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_merchant_service_details` AS select `ccdata_test`.`merchant_service_details`.`merchant_service_detail_id` AS `merchant_service_detail_id`,`ccdata_test`.`merchant_service_details`.`merchant_service_id` AS `merchant_service_id`,`ccdata_test`.`merchant_service_details`.`merchant_service_detail_version` AS `merchant_service_detail_version`,`ccdata_test`.`merchant_service_details`.`merchant_service_detail_label` AS `merchant_service_detail_label`,`ccdata_test`.`merchant_service_details`.`category_image_path` AS `category_image_path`,`ccdata_test`.`merchant_service_details`.`category_image_alt_text` AS `category_image_alt_text`,`ccdata_test`.`merchant_service_details`.`merchant_service_link` AS `merchant_service_link`,`ccdata_test`.`merchant_service_details`.`app_link` AS `app_link`,`ccdata_test`.`merchant_service_details`.`merchant_service_image_path` AS `merchant_service_image_path`,`ccdata_test`.`merchant_service_details`.`merchant_service_image_alt_text` AS `merchant_service_image_alt_text`,`ccdata_test`.`merchant_service_details`.`apply_button_alt_text` AS `apply_button_alt_text`,`ccdata_test`.`merchant_service_details`.`merchant_service_header_string` AS `merchant_service_header_string`,`ccdata_test`.`merchant_service_details`.`merchant_service_detail_text` AS `merchant_service_detail_text`,`ccdata_test`.`merchant_service_details`.`merchant_service_intro_detail` AS `merchant_service_intro_detail`,`ccdata_test`.`merchant_service_details`.`merchant_service_more_detail` AS `merchant_service_more_detail`,`ccdata_test`.`merchant_service_details`.`fid` AS `fid`,`ccdata_test`.`merchant_service_details`.`date_created` AS `date_created`,`ccdata_test`.`merchant_service_details`.`date_updated` AS `date_updated`,`ccdata_test`.`merchant_service_details`.`active` AS `active`,`ccdata_test`.`merchant_service_details`.`deleted` AS `deleted` from `ccdata_test`.`merchant_service_details` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_merchant_services`
--

/*!50001 DROP TABLE IF EXISTS `cms_merchant_services`*/;
/*!50001 DROP VIEW IF EXISTS `cms_merchant_services`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_merchant_services` AS select `ccdata_test`.`merchant_services`.`merchant_service_id` AS `merchant_service_id`,`ccdata_test`.`merchant_services`.`merchant_service_name` AS `merchant_service_name`,`ccdata_test`.`merchant_services`.`url` AS `url`,`ccdata_test`.`merchant_services`.`description` AS `description`,`ccdata_test`.`merchant_services`.`setup_fee` AS `setup_fee`,`ccdata_test`.`merchant_services`.`active_setup_fee` AS `active_setup_fee`,`ccdata_test`.`merchant_services`.`monthly_minimum` AS `monthly_minimum`,`ccdata_test`.`merchant_services`.`active_monthly_minimum` AS `active_monthly_minimum`,`ccdata_test`.`merchant_services`.`gateway_fee` AS `gateway_fee`,`ccdata_test`.`merchant_services`.`active_gateway_fee` AS `active_gateway_fee`,`ccdata_test`.`merchant_services`.`statement_fee` AS `statement_fee`,`ccdata_test`.`merchant_services`.`active_statement_fee` AS `active_statement_fee`,`ccdata_test`.`merchant_services`.`discount_rate` AS `discount_rate`,`ccdata_test`.`merchant_services`.`active_discount_rate` AS `active_discount_rate`,`ccdata_test`.`merchant_services`.`transaction_fee` AS `transaction_fee`,`ccdata_test`.`merchant_services`.`active_transaction_fee` AS `active_transaction_fee`,`ccdata_test`.`merchant_services`.`tech_support_fee` AS `tech_support_fee`,`ccdata_test`.`merchant_services`.`active_tech_support_fee` AS `active_tech_support_fee`,`ccdata_test`.`merchant_services`.`date_created` AS `date_created`,`ccdata_test`.`merchant_services`.`date_updated` AS `date_updated`,`ccdata_test`.`merchant_services`.`active` AS `active`,`ccdata_test`.`merchant_services`.`deleted` AS `deleted` from `ccdata_test`.`merchant_services` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_merchants`
--

/*!50001 DROP TABLE IF EXISTS `cms_merchants`*/;
/*!50001 DROP VIEW IF EXISTS `cms_merchants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_merchants` AS select `ccdata_test`.`cs_merchants`.`merchantid` AS `merchantid`,`ccdata_test`.`cs_merchants`.`merchantname` AS `merchantname`,`ccdata_test`.`cs_merchants`.`merchantcardpage` AS `merchantcardpage`,`ccdata_test`.`cs_merchants`.`deleted` AS `deleted` from `ccdata_test`.`cs_merchants` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_page_details`
--

/*!50001 DROP TABLE IF EXISTS `cms_page_details`*/;
/*!50001 DROP VIEW IF EXISTS `cms_page_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_page_details` AS select `ccdata_test`.`rt_pagedetails`.`id` AS `id`,`ccdata_test`.`rt_pagedetails`.`pageDetailVersion` AS `pageDetailVersion`,`ccdata_test`.`rt_pagedetails`.`pageDetailLabel` AS `pageDetailLabel`,`ccdata_test`.`rt_pagedetails`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_pagedetails`.`pageTitle` AS `pageTitle`,`ccdata_test`.`rt_pagedetails`.`pageIntroDescription` AS `pageIntroDescription`,`ccdata_test`.`rt_pagedetails`.`pageDescription` AS `pageDescription`,`ccdata_test`.`rt_pagedetails`.`pageSpecial` AS `pageSpecial`,`ccdata_test`.`rt_pagedetails`.`pageMeta` AS `pageMeta`,`ccdata_test`.`rt_pagedetails`.`pageLearnMore` AS `pageLearnMore`,`ccdata_test`.`rt_pagedetails`.`pageDisclaimer` AS `pageDisclaimer`,`ccdata_test`.`rt_pagedetails`.`pageHeaderImage` AS `pageHeaderImage`,`ccdata_test`.`rt_pagedetails`.`pageHeaderImageAltText` AS `pageHeaderImageAltText`,`ccdata_test`.`rt_pagedetails`.`pageSpecialOfferImage` AS `pageSpecialOfferImage`,`ccdata_test`.`rt_pagedetails`.`pageSpecialOfferImageAltText` AS `pageSpecialOfferImageAltText`,`ccdata_test`.`rt_pagedetails`.`pageSpecialOfferLink` AS `pageSpecialOfferLink`,`ccdata_test`.`rt_pagedetails`.`pageSmallImage` AS `pageSmallImage`,`ccdata_test`.`rt_pagedetails`.`pageSmallImageAltText` AS `pageSmallImageAltText`,`ccdata_test`.`rt_pagedetails`.`dateCreated` AS `dateCreated`,`ccdata_test`.`rt_pagedetails`.`dateUpdated` AS `dateUpdated`,`ccdata_test`.`rt_pagedetails`.`pageLink` AS `pageLink`,`ccdata_test`.`rt_pagedetails`.`fid` AS `fid`,`ccdata_test`.`rt_pagedetails`.`pageHeaderString` AS `pageHeaderString`,`ccdata_test`.`rt_pagedetails`.`primaryNavString` AS `primaryNavString`,`ccdata_test`.`rt_pagedetails`.`secondaryNavString` AS `secondaryNavString`,`ccdata_test`.`rt_pagedetails`.`topPickAltText` AS `topPickAltText`,`ccdata_test`.`rt_pagedetails`.`flagTopPick` AS `flagTopPick`,`ccdata_test`.`rt_pagedetails`.`flagAdditionalOffer` AS `flagAdditionalOffer`,`ccdata_test`.`rt_pagedetails`.`associatedArticleCategory` AS `associatedArticleCategory`,`ccdata_test`.`rt_pagedetails`.`articlesPerPage` AS `articlesPerPage`,`ccdata_test`.`rt_pagedetails`.`enableSort` AS `enableSort`,`ccdata_test`.`rt_pagedetails`.`itemsPerPage` AS `itemsPerPage`,`ccdata_test`.`rt_pagedetails`.`pageSeeAlso` AS `pageSeeAlso`,`ccdata_test`.`rt_pagedetails`.`siteMapDescription` AS `siteMapDescription`,`ccdata_test`.`rt_pagedetails`.`siteMapTitle` AS `siteMapTitle`,`ccdata_test`.`rt_pagedetails`.`active` AS `active`,`ccdata_test`.`rt_pagedetails`.`deleted` AS `deleted`,`ccdata_test`.`rt_pagedetails`.`sitemapLink` AS `sitemapLink`,`ccdata_test`.`rt_pagedetails`.`navBarString` AS `navBarString`,`ccdata_test`.`rt_pagedetails`.`subPageNav` AS `subPageNav`,`ccdata_test`.`rt_pagedetails`.`landingPage` AS `landingPage`,`ccdata_test`.`rt_pagedetails`.`landingPageFid` AS `landingPageFid`,`ccdata_test`.`rt_pagedetails`.`landingPageImage` AS `landingPageImage`,`ccdata_test`.`rt_pagedetails`.`landingPageHeaderString` AS `landingPageHeaderString`,`ccdata_test`.`rt_pagedetails`.`itemsOnFirstPage` AS `itemsOnFirstPage`,`ccdata_test`.`rt_pagedetails`.`showMainCatOnFirstPage` AS `showMainCatOnFirstPage` from `ccdata_test`.`rt_pagedetails` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_page_site_map`
--

/*!50001 DROP TABLE IF EXISTS `cms_page_site_map`*/;
/*!50001 DROP VIEW IF EXISTS `cms_page_site_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_page_site_map` AS select `ccdata_test`.`rt_pagecategorymap`.`categoryPageMapId` AS `categoryPageMapId`,`ccdata_test`.`rt_pagecategorymap`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_pagecategorymap`.`categoryId` AS `categoryId`,`ccdata_test`.`rt_pagecategorymap`.`rank` AS `rank` from `ccdata_test`.`rt_pagecategorymap` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_pages`
--

/*!50001 DROP TABLE IF EXISTS `cms_pages`*/;
/*!50001 DROP VIEW IF EXISTS `cms_pages`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_pages` AS select `ccdata_test`.`rt_cardpages`.`cardpageId` AS `cardpageId`,`ccdata_test`.`rt_cardpages`.`pageName` AS `pageName`,`ccdata_test`.`rt_cardpages`.`pageType` AS `pageType`,`ccdata_test`.`rt_cardpages`.`contentType` AS `contentType`,`ccdata_test`.`rt_cardpages`.`alternate_tracking_flag` AS `alternate_tracking_flag`,`ccdata_test`.`rt_cardpages`.`schumerType` AS `schumerType`,`ccdata_test`.`rt_cardpages`.`dateCreated` AS `dateCreated`,`ccdata_test`.`rt_cardpages`.`dateUpdated` AS `dateUpdated`,`ccdata_test`.`rt_cardpages`.`type` AS `type`,`ccdata_test`.`rt_cardpages`.`active` AS `active`,`ccdata_test`.`rt_cardpages`.`deleted` AS `deleted`,`ccdata_test`.`rt_cardpages`.`rollup` AS `rollup`,`ccdata_test`.`rt_cardpages`.`card_category_id` AS `card_category_id`,`ccdata_test`.`rt_cardpages`.`active_introApr` AS `active_introApr`,`ccdata_test`.`rt_cardpages`.`active_introAprPeriod` AS `active_introAprPeriod`,`ccdata_test`.`rt_cardpages`.`active_regularApr` AS `active_regularApr`,`ccdata_test`.`rt_cardpages`.`active_annualFee` AS `active_annualFee`,`ccdata_test`.`rt_cardpages`.`active_monthlyFee` AS `active_monthlyFee`,`ccdata_test`.`rt_cardpages`.`active_balanceTransfers` AS `active_balanceTransfers`,`ccdata_test`.`rt_cardpages`.`active_balanceTransferFee` AS `active_balanceTransferFee`,`ccdata_test`.`rt_cardpages`.`active_balanceTransferIntroApr` AS `active_balanceTransferIntroApr`,`ccdata_test`.`rt_cardpages`.`active_balanceTransferIntroAprPeriod` AS `active_balanceTransferIntroAprPeriod`,`ccdata_test`.`rt_cardpages`.`active_creditNeeded` AS `active_creditNeeded`,`ccdata_test`.`rt_cardpages`.`active_transactionFeeSignature` AS `active_transactionFeeSignature`,`ccdata_test`.`rt_cardpages`.`active_transactionFeePin` AS `active_transactionFeePin`,`ccdata_test`.`rt_cardpages`.`active_atmFee` AS `active_atmFee`,`ccdata_test`.`rt_cardpages`.`active_prepaidText` AS `active_prepaidText`,`ccdata_test`.`rt_cardpages`.`active_loadFee` AS `active_loadFee`,`ccdata_test`.`rt_cardpages`.`active_activationFee` AS `active_activationFee` from `ccdata_test`.`rt_cardpages` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_subpage_page_map`
--

/*!50001 DROP TABLE IF EXISTS `cms_subpage_page_map`*/;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_subpage_page_map` AS select `ccdata_test`.`rt_pagesubpagemap`.`mapid` AS `mapid`,`ccdata_test`.`rt_pagesubpagemap`.`siteid` AS `siteid`,`ccdata_test`.`rt_pagesubpagemap`.`masterpageid` AS `masterpageid`,`ccdata_test`.`rt_pagesubpagemap`.`subpageid` AS `subpageid`,`ccdata_test`.`rt_pagesubpagemap`.`hide` AS `hide`,`ccdata_test`.`rt_pagesubpagemap`.`rank` AS `rank` from `ccdata_test`.`rt_pagesubpagemap` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_subpage_page_map_affiliate`
--

/*!50001 DROP TABLE IF EXISTS `cms_subpage_page_map_affiliate`*/;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map_affiliate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_subpage_page_map_affiliate` AS select `ccdata_test`.`rt_pagesubpagemap_affiliate`.`mapid` AS `mapid`,`ccdata_test`.`rt_pagesubpagemap_affiliate`.`siteid` AS `siteid`,`ccdata_test`.`rt_pagesubpagemap_affiliate`.`masterpageid` AS `masterpageid`,`ccdata_test`.`rt_pagesubpagemap_affiliate`.`subpageid` AS `subpageid`,`ccdata_test`.`rt_pagesubpagemap_affiliate`.`hide` AS `hide`,`ccdata_test`.`rt_pagesubpagemap_affiliate`.`rank` AS `rank` from `ccdata_test`.`rt_pagesubpagemap_affiliate` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_subpage_page_map_bankrate`
--

/*!50001 DROP TABLE IF EXISTS `cms_subpage_page_map_bankrate`*/;
/*!50001 DROP VIEW IF EXISTS `cms_subpage_page_map_bankrate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_subpage_page_map_bankrate` AS select `ccdata_test`.`rt_pagesubpagemap_bankrate`.`mapid` AS `mapid`,`ccdata_test`.`rt_pagesubpagemap_bankrate`.`siteid` AS `siteid`,`ccdata_test`.`rt_pagesubpagemap_bankrate`.`masterpageid` AS `masterpageid`,`ccdata_test`.`rt_pagesubpagemap_bankrate`.`subpageid` AS `subpageid`,`ccdata_test`.`rt_pagesubpagemap_bankrate`.`hide` AS `hide`,`ccdata_test`.`rt_pagesubpagemap_bankrate`.`rank` AS `rank` from `ccdata_test`.`rt_pagesubpagemap_bankrate` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cms_versions`
--

/*!50001 DROP TABLE IF EXISTS `cms_versions`*/;
/*!50001 DROP VIEW IF EXISTS `cms_versions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cms_versions` AS select `ccdata_test`.`versions`.`version_id` AS `version_id`,`ccdata_test`.`versions`.`version_name` AS `version_name`,`ccdata_test`.`versions`.`version_description` AS `version_description`,`ccdata_test`.`versions`.`deleted` AS `deleted`,`ccdata_test`.`versions`.`insert_time` AS `insert_time`,`ccdata_test`.`versions`.`update_time` AS `update_time` from `ccdata_test`.`versions` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_authors`
--

/*!50001 DROP TABLE IF EXISTS `cp_authors`*/;
/*!50001 DROP VIEW IF EXISTS `cp_authors`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_authors` AS select `cardpress`.`cp_authors`.`author_id` AS `author_id`,`cardpress`.`cp_authors`.`first_name` AS `first_name`,`cardpress`.`cp_authors`.`last_name` AS `last_name`,`cardpress`.`cp_authors`.`address` AS `address`,`cardpress`.`cp_authors`.`business_name` AS `business_name`,`cardpress`.`cp_authors`.`author_page_link` AS `author_page_link`,`cardpress`.`cp_authors`.`external_profile_link` AS `external_profile_link`,`cardpress`.`cp_authors`.`author_photo_location` AS `author_photo_location`,`cardpress`.`cp_authors`.`author_page_site_content_id` AS `author_page_site_content_id`,`cardpress`.`cp_authors`.`local_author_page_filename` AS `local_author_page_filename` from `cardpress`.`cp_authors` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_document_groups`
--

/*!50001 DROP TABLE IF EXISTS `cp_document_groups`*/;
/*!50001 DROP VIEW IF EXISTS `cp_document_groups`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_document_groups` AS select `cardpress`.`cp_document_groups`.`id` AS `id`,`cardpress`.`cp_document_groups`.`document_group` AS `document_group`,`cardpress`.`cp_document_groups`.`document` AS `document` from `cardpress`.`cp_document_groups` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_documentgroup_names`
--

/*!50001 DROP TABLE IF EXISTS `cp_documentgroup_names`*/;
/*!50001 DROP VIEW IF EXISTS `cp_documentgroup_names`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_documentgroup_names` AS select `cardpress`.`cp_documentgroup_names`.`id` AS `id`,`cardpress`.`cp_documentgroup_names`.`name` AS `name`,`cardpress`.`cp_documentgroup_names`.`private_memgroup` AS `private_memgroup`,`cardpress`.`cp_documentgroup_names`.`private_webgroup` AS `private_webgroup`,`cardpress`.`cp_documentgroup_names`.`fid` AS `fid`,`cardpress`.`cp_documentgroup_names`.`index_page_id` AS `index_page_id` from `cardpress`.`cp_documentgroup_names` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_glossary`
--

/*!50001 DROP TABLE IF EXISTS `cp_glossary`*/;
/*!50001 DROP VIEW IF EXISTS `cp_glossary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_glossary` AS select `cardpress`.`cp_glossary`.`id` AS `id`,`cardpress`.`cp_glossary`.`term` AS `term`,`cardpress`.`cp_glossary`.`definition` AS `definition`,`cardpress`.`cp_glossary`.`disabled` AS `disabled`,`cardpress`.`cp_glossary`.`createdon` AS `createdon`,`cardpress`.`cp_glossary`.`editedon` AS `editedon` from `cardpress`.`cp_glossary` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_homepage_module`
--

/*!50001 DROP TABLE IF EXISTS `cp_homepage_module`*/;
/*!50001 DROP VIEW IF EXISTS `cp_homepage_module`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_homepage_module` AS select `cardpress`.`cp_homepage_module`.`id` AS `id`,`cardpress`.`cp_homepage_module`.`name` AS `name`,`cardpress`.`cp_homepage_module`.`caption` AS `caption`,`cardpress`.`cp_homepage_module`.`related` AS `related`,`cardpress`.`cp_homepage_module`.`story` AS `story` from `cardpress`.`cp_homepage_module` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_membergroup_access`
--

/*!50001 DROP TABLE IF EXISTS `cp_membergroup_access`*/;
/*!50001 DROP VIEW IF EXISTS `cp_membergroup_access`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_membergroup_access` AS select `cardpress`.`cp_membergroup_access`.`id` AS `id`,`cardpress`.`cp_membergroup_access`.`membergroup` AS `membergroup`,`cardpress`.`cp_membergroup_access`.`documentgroup` AS `documentgroup` from `cardpress`.`cp_membergroup_access` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_membergroup_names`
--

/*!50001 DROP TABLE IF EXISTS `cp_membergroup_names`*/;
/*!50001 DROP VIEW IF EXISTS `cp_membergroup_names`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_membergroup_names` AS select `cardpress`.`cp_membergroup_names`.`id` AS `id`,`cardpress`.`cp_membergroup_names`.`name` AS `name`,`cardpress`.`cp_membergroup_names`.`aff_id` AS `aff_id` from `cardpress`.`cp_membergroup_names` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_site_content`
--

/*!50001 DROP TABLE IF EXISTS `cp_site_content`*/;
/*!50001 DROP VIEW IF EXISTS `cp_site_content`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_site_content` AS select `cardpress`.`cp_site_content`.`id` AS `id`,`cardpress`.`cp_site_content`.`type` AS `type`,`cardpress`.`cp_site_content`.`contentType` AS `contentType`,`cardpress`.`cp_site_content`.`author` AS `author`,`cardpress`.`cp_site_content`.`pagetitle` AS `pagetitle`,`cardpress`.`cp_site_content`.`longtitle` AS `longtitle`,`cardpress`.`cp_site_content`.`description` AS `description`,`cardpress`.`cp_site_content`.`alias` AS `alias`,`cardpress`.`cp_site_content`.`link_attributes` AS `link_attributes`,`cardpress`.`cp_site_content`.`published` AS `published`,`cardpress`.`cp_site_content`.`publish_to_affiliates` AS `publish_to_affiliates`,`cardpress`.`cp_site_content`.`publish_to_cccom` AS `publish_to_cccom`,`cardpress`.`cp_site_content`.`pub_date` AS `pub_date`,`cardpress`.`cp_site_content`.`unpub_date` AS `unpub_date`,`cardpress`.`cp_site_content`.`repub_date` AS `repub_date`,`cardpress`.`cp_site_content`.`parent` AS `parent`,`cardpress`.`cp_site_content`.`isfolder` AS `isfolder`,`cardpress`.`cp_site_content`.`introtext` AS `introtext`,`cardpress`.`cp_site_content`.`content` AS `content`,`cardpress`.`cp_site_content`.`richtext` AS `richtext`,`cardpress`.`cp_site_content`.`template` AS `template`,`cardpress`.`cp_site_content`.`menuindex` AS `menuindex`,`cardpress`.`cp_site_content`.`searchable` AS `searchable`,`cardpress`.`cp_site_content`.`cacheable` AS `cacheable`,`cardpress`.`cp_site_content`.`createdby` AS `createdby`,`cardpress`.`cp_site_content`.`createdon` AS `createdon`,`cardpress`.`cp_site_content`.`editedby` AS `editedby`,`cardpress`.`cp_site_content`.`editedon` AS `editedon`,`cardpress`.`cp_site_content`.`deleted` AS `deleted`,`cardpress`.`cp_site_content`.`deletedon` AS `deletedon`,`cardpress`.`cp_site_content`.`deletedby` AS `deletedby`,`cardpress`.`cp_site_content`.`publishedon` AS `publishedon`,`cardpress`.`cp_site_content`.`publishedby` AS `publishedby`,`cardpress`.`cp_site_content`.`menutitle` AS `menutitle`,`cardpress`.`cp_site_content`.`donthit` AS `donthit`,`cardpress`.`cp_site_content`.`haskeywords` AS `haskeywords`,`cardpress`.`cp_site_content`.`hasmetatags` AS `hasmetatags`,`cardpress`.`cp_site_content`.`privateweb` AS `privateweb`,`cardpress`.`cp_site_content`.`privatemgr` AS `privatemgr`,`cardpress`.`cp_site_content`.`content_dispo` AS `content_dispo`,`cardpress`.`cp_site_content`.`hidemenu` AS `hidemenu`,`cardpress`.`cp_site_content`.`pageid` AS `pageid`,`cardpress`.`cp_site_content`.`story_keywords` AS `story_keywords`,`cardpress`.`cp_site_content`.`homepage_headline` AS `homepage_headline`,`cardpress`.`cp_site_content`.`homepage_summary` AS `homepage_summary`,`cardpress`.`cp_site_content`.`homepage_thumb` AS `homepage_thumb`,`cardpress`.`cp_site_content`.`homepage_alt` AS `homepage_alt`,`cardpress`.`cp_site_content`.`homepage_linktext` AS `homepage_linktext`,`cardpress`.`cp_site_content`.`homepage_image_external` AS `homepage_image_external`,`cardpress`.`cp_site_content`.`pubgroup` AS `pubgroup`,`cardpress`.`cp_site_content`.`maincategory` AS `maincategory`,`cardpress`.`cp_site_content`.`archived` AS `archived`,`cardpress`.`cp_site_content`.`temp_wp_post_id` AS `temp_wp_post_id`,`cardpress`.`cp_site_content`.`notes` AS `notes`,`cardpress`.`cp_site_content`.`actual_page_title` AS `actual_page_title`,`cardpress`.`cp_site_content`.`approved` AS `approved`,`cardpress`.`cp_site_content`.`invoiced` AS `invoiced`,`cardpress`.`cp_site_content`.`invoiced_amount` AS `invoiced_amount` from `cardpress`.`cp_site_content` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_site_htmlsnippets`
--

/*!50001 DROP TABLE IF EXISTS `cp_site_htmlsnippets`*/;
/*!50001 DROP VIEW IF EXISTS `cp_site_htmlsnippets`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_site_htmlsnippets` AS select `cardpress`.`cp_site_htmlsnippets`.`id` AS `id`,`cardpress`.`cp_site_htmlsnippets`.`name` AS `name`,`cardpress`.`cp_site_htmlsnippets`.`description` AS `description`,`cardpress`.`cp_site_htmlsnippets`.`editor_type` AS `editor_type`,`cardpress`.`cp_site_htmlsnippets`.`category` AS `category`,`cardpress`.`cp_site_htmlsnippets`.`cache_type` AS `cache_type`,`cardpress`.`cp_site_htmlsnippets`.`snippet` AS `snippet`,`cardpress`.`cp_site_htmlsnippets`.`locked` AS `locked` from `cardpress`.`cp_site_htmlsnippets` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cp_story_authors`
--

/*!50001 DROP TABLE IF EXISTS `cp_story_authors`*/;
/*!50001 DROP VIEW IF EXISTS `cp_story_authors`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `cp_story_authors` AS select `cardpress`.`cp_story_authors`.`story_id` AS `story_id`,`cardpress`.`cp_story_authors`.`author_id` AS `author_id` from `cardpress`.`cp_story_authors` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `page_subpage_ranking`
--

--
-- Final view structure for view `partner_affiliate_click_reporting`
--

/*!50001 DROP TABLE IF EXISTS `partner_affiliate_click_reporting`*/;
/*!50001 DROP VIEW IF EXISTS `partner_affiliate_click_reporting`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `partner_affiliate_click_reporting` AS select `cl`.`affiliate_id` AS `affiliate_id`,`cl`.`website_id` AS `website_id`,`cl`.`card_id` AS `card_id`,`cl`.`date` AS `date_inserted`,ifnull(`co`.`approvalSalesCount`,0) AS `saleClickCount`,_latin1'0' AS `nonSaleClickCount`,ifnull(`co`.`applicationSalesCount`,0) AS `applicationsCount`,ifnull(`co`.`crossSaleCount`,0) AS `crossSaleCount`,ifnull(`cl`.`totalclicks`,0) AS `totalClicks`,ifnull(`co`.`totalcommission`,0) AS `totalCommission`,_latin1'0' AS `nonSalesClickCommission`,_latin1'0' AS `salesClickCommission` from (`click_summary` `cl` left join `commission_summary` `co` on(((`co`.`affiliate_id` = `cl`.`affiliate_id`) and (`co`.`card_id` = `cl`.`card_id`) and (`co`.`date` = `cl`.`date`) and (`co`.`website_id` = `cl`.`website_id`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `partner_affiliate_click_reporting_internal`
--

/*!50001 DROP TABLE IF EXISTS `partner_affiliate_click_reporting_internal`*/;
/*!50001 DROP VIEW IF EXISTS `partner_affiliate_click_reporting_internal`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `partner_affiliate_click_reporting_internal` AS select `cl`.`affiliate_id` AS `affiliate_id`,`cl`.`website_id` AS `website_id`,`cl`.`card_id` AS `card_id`,`cl`.`date` AS `date_inserted`,ifnull(`co`.`approvalSalesCount`,0) AS `saleClickCount`,_latin1'0' AS `nonSaleClickCount`,ifnull(`co`.`applicationSalesCount`,0) AS `applicationsCount`,ifnull(`co`.`crossSaleCount`,0) AS `crossSaleCount`,ifnull(`cl`.`totalclicks`,0) AS `totalClicks`,ifnull(`co`.`totalcommission`,0) AS `totalCommission`,ifnull(`rs`.`sales_rev`,0) AS `totalRevenue`,ifnull(`co`.`totalAdjustment`,0) AS `totalAdjustment`,_latin1'0' AS `nonSalesClickCommission`,_latin1'0' AS `salesClickCommission` from ((`click_summary` `cl` left join `commission_summary` `co` on(((`co`.`affiliate_id` = `cl`.`affiliate_id`) and (`co`.`card_id` = `cl`.`card_id`) and (`co`.`date` = `cl`.`date`) and (`co`.`website_id` = `cl`.`website_id`)))) left join `revenue_summary` `rs` on(((`rs`.`affiliate_id` = `cl`.`affiliate_id`) and (`rs`.`card_id` = `cl`.`card_id`) and (`rs`.`post_date` = `cl`.`date`) and (`rs`.`website_id` = `cl`.`website_id`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_clicks_by_aid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_clicks_by_aid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_clicks_by_aid` AS select `cccomus_reporting`.`summary_day_clicks_by_aid`.`click_day` AS `click_day`,`cccomus_reporting`.`summary_day_clicks_by_aid`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_clicks_by_aid`.`count_of_clicks` AS `count_of_clicks` from `cccomus_reporting`.`summary_day_clicks_by_aid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_clicks_by_aid_card_id`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_clicks_by_aid_card_id`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid_card_id`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_clicks_by_aid_card_id` AS select `cccomus_reporting`.`summary_day_clicks_by_aid_card_id`.`click_day` AS `click_day`,`cccomus_reporting`.`summary_day_clicks_by_aid_card_id`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_clicks_by_aid_card_id`.`card_id` AS `card_id`,`cccomus_reporting`.`summary_day_clicks_by_aid_card_id`.`count_of_clicks` AS `count_of_clicks` from `cccomus_reporting`.`summary_day_clicks_by_aid_card_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_clicks_by_aid_did`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_clicks_by_aid_did`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_aid_did`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_clicks_by_aid_did` AS select `cccomus_reporting`.`summary_day_clicks_by_aid_did`.`click_day` AS `click_day`,`cccomus_reporting`.`summary_day_clicks_by_aid_did`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_clicks_by_aid_did`.`keyword_id` AS `keyword_id`,`cccomus_reporting`.`summary_day_clicks_by_aid_did`.`count_of_clicks` AS `count_of_clicks` from `cccomus_reporting`.`summary_day_clicks_by_aid_did` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_clicks_by_cid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_clicks_by_cid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_clicks_by_cid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_clicks_by_cid` AS select `cccomus_reporting`.`summary_day_clicks_by_cid`.`click_day` AS `click_day`,`cccomus_reporting`.`summary_day_clicks_by_cid`.`external_campaign_id` AS `external_campaign_id`,`cccomus_reporting`.`summary_day_clicks_by_cid`.`count_of_clicks` AS `count_of_clicks` from `cccomus_reporting`.`summary_day_clicks_by_cid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_legacy_page_views_by_aid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_legacy_page_views_by_aid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_legacy_page_views_by_aid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_legacy_page_views_by_aid` AS select `cccomus_reporting`.`summary_day_legacy_page_views_by_aid`.`legacy_page_view_day` AS `legacy_page_view_day`,`cccomus_reporting`.`summary_day_legacy_page_views_by_aid`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_legacy_page_views_by_aid`.`count_of_unique_page_views` AS `count_of_unique_page_views` from `cccomus_reporting`.`summary_day_legacy_page_views_by_aid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_unique_visits_by_aid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_unique_visits_by_aid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_unique_visits_by_aid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_unique_visits_by_aid` AS select `cccomus_reporting`.`summary_day_unique_visits_by_aid`.`visit_day` AS `visit_day`,`cccomus_reporting`.`summary_day_unique_visits_by_aid`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_unique_visits_by_aid`.`count_of_visits` AS `count_of_visits` from `cccomus_reporting`.`summary_day_unique_visits_by_aid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_visits_by_aid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_visits_by_aid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_visits_by_aid` AS select `cccomus_reporting`.`summary_day_visits_by_aid`.`visit_day` AS `visit_day`,`cccomus_reporting`.`summary_day_visits_by_aid`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_visits_by_aid`.`count_of_visits` AS `count_of_visits` from `cccomus_reporting`.`summary_day_visits_by_aid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_visits_by_aid_bid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_visits_by_aid_bid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid_bid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_visits_by_aid_bid` AS select `cccomus_reporting`.`summary_day_visits_by_aid_bid`.`visit_day` AS `visit_day`,`cccomus_reporting`.`summary_day_visits_by_aid_bid`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_visits_by_aid_bid`.`ad_id` AS `ad_id`,`cccomus_reporting`.`summary_day_visits_by_aid_bid`.`count_of_visits` AS `count_of_visits` from `cccomus_reporting`.`summary_day_visits_by_aid_bid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_visits_by_aid_did`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_visits_by_aid_did`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_aid_did`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_visits_by_aid_did` AS select `cccomus_reporting`.`summary_day_visits_by_aid_did`.`visit_day` AS `visit_day`,`cccomus_reporting`.`summary_day_visits_by_aid_did`.`affiliate_id` AS `affiliate_id`,`cccomus_reporting`.`summary_day_visits_by_aid_did`.`keyword_id` AS `keyword_id`,`cccomus_reporting`.`summary_day_visits_by_aid_did`.`count_of_visits` AS `count_of_visits` from `cccomus_reporting`.`summary_day_visits_by_aid_did` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `summary_day_visits_by_cid`
--

/*!50001 DROP TABLE IF EXISTS `summary_day_visits_by_cid`*/;
/*!50001 DROP VIEW IF EXISTS `summary_day_visits_by_cid`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `summary_day_visits_by_cid` AS select `cccomus_reporting`.`summary_day_visits_by_cid`.`visit_day` AS `visit_day`,`cccomus_reporting`.`summary_day_visits_by_cid`.`external_campaign_id` AS `external_campaign_id`,`cccomus_reporting`.`summary_day_visits_by_cid`.`count_of_visits` AS `count_of_visits` from `cccomus_reporting`.`summary_day_visits_by_cid` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_bankrate_transactions`
--

/*!50001 DROP TABLE IF EXISTS `vw_bankrate_transactions`*/;
/*!50001 DROP VIEW IF EXISTS `vw_bankrate_transactions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_bankrate_transactions` AS select `transactions_recent`.`transid` AS `transid`,`transactions_recent`.`accountid` AS `accountid`,`transactions_recent`.`rstatus` AS `rstatus`,`transactions_recent`.`dateinserted` AS `dateinserted`,`transactions_recent`.`dateapproved` AS `dateapproved`,`transactions_recent`.`transtype` AS `transtype`,`transactions_recent`.`payoutstatus` AS `payoutstatus`,`transactions_recent`.`datepayout` AS `datepayout`,`transactions_recent`.`cookiestatus` AS `cookiestatus`,`transactions_recent`.`orderid` AS `orderid`,`transactions_recent`.`totalcost` AS `totalcost`,`transactions_recent`.`bannerid` AS `bannerid`,`transactions_recent`.`transkind` AS `transkind`,`transactions_recent`.`refererurl` AS `refererurl`,`transactions_recent`.`affiliateid` AS `affiliateid`,`transactions_recent`.`campcategoryid` AS `campcategoryid`,`transactions_recent`.`parenttransid` AS `parenttransid`,`transactions_recent`.`commission` AS `commission`,`transactions_recent`.`ip` AS `ip`,`transactions_recent`.`recurringcommid` AS `recurringcommid`,`transactions_recent`.`accountingid` AS `accountingid`,`transactions_recent`.`productid` AS `productid`,`transactions_recent`.`data1` AS `data1`,`transactions_recent`.`data2` AS `data2`,`transactions_recent`.`data3` AS `data3`,`transactions_recent`.`channel` AS `channel`,`transactions_recent`.`episode` AS `episode`,`transactions_recent`.`timeslot` AS `timeslot`,`transactions_recent`.`exit` AS `exit`,`transactions_recent`.`page_position` AS `page_position`,`transactions_recent`.`provideractionname` AS `provideractionname`,`transactions_recent`.`providerorderid` AS `providerorderid`,`transactions_recent`.`providertype` AS `providertype`,`transactions_recent`.`providereventdate` AS `providereventdate`,`transactions_recent`.`providerprocessdate` AS `providerprocessdate`,`transactions_recent`.`merchantname` AS `merchantname`,`transactions_recent`.`providerid` AS `providerid`,`transactions_recent`.`merchantsales` AS `merchantsales`,`transactions_recent`.`quantity` AS `quantity`,`transactions_recent`.`providerchannel` AS `providerchannel`,`transactions_recent`.`estimatedrevenue` AS `estimatedrevenue`,`transactions_recent`.`dateestimated` AS `dateestimated`,`transactions_recent`.`dateactual` AS `dateactual`,`transactions_recent`.`estimateddatafilename` AS `estimateddatafilename`,`transactions_recent`.`actualdatafilename` AS `actualdatafilename`,`transactions_recent`.`providerstatus` AS `providerstatus`,`transactions_recent`.`providercorrected` AS `providercorrected`,`transactions_recent`.`providerwebsiteid` AS `providerwebsiteid`,`transactions_recent`.`providerwebsitename` AS `providerwebsitename`,`transactions_recent`.`provideractionid` AS `provideractionid`,`transactions_recent`.`modifiedby` AS `modifiedby`,`transactions_recent`.`reftrans` AS `reftrans`,`transactions_recent`.`reversed` AS `reversed`,`transactions_recent`.`dateadjusted` AS `dateadjusted`,`transactions_recent`.`currref` AS `currref`,`transactions_recent`.`prevref` AS `prevref`,`transactions_recent`.`thirdref` AS `thirdref`,`transactions_recent`.`external_visit_id` AS `external_visit_id`,`transactions_recent`.`refinceptiondate` AS `refinceptiondate` from `transactions_recent` union select `ncs_transactions`.`transid` AS `transid`,`ncs_transactions`.`accountid` AS `accountid`,`ncs_transactions`.`rstatus` AS `rstatus`,`ncs_transactions`.`dateinserted` AS `dateinserted`,`ncs_transactions`.`dateapproved` AS `dateapproved`,`ncs_transactions`.`transtype` AS `transtype`,`ncs_transactions`.`payoutstatus` AS `payoutstatus`,`ncs_transactions`.`datepayout` AS `datepayout`,`ncs_transactions`.`cookiestatus` AS `cookiestatus`,`ncs_transactions`.`orderid` AS `orderid`,`ncs_transactions`.`totalcost` AS `totalcost`,`ncs_transactions`.`bannerid` AS `bannerid`,`ncs_transactions`.`transkind` AS `transkind`,`ncs_transactions`.`refererurl` AS `refererurl`,`ncs_transactions`.`affiliateid` AS `affiliateid`,`ncs_transactions`.`campcategoryid` AS `campcategoryid`,`ncs_transactions`.`parenttransid` AS `parenttransid`,`ncs_transactions`.`commission` AS `commission`,`ncs_transactions`.`ip` AS `ip`,`ncs_transactions`.`recurringcommid` AS `recurringcommid`,`ncs_transactions`.`accountingid` AS `accountingid`,`ncs_transactions`.`productid` AS `productid`,`ncs_transactions`.`data1` AS `data1`,`ncs_transactions`.`data2` AS `data2`,`ncs_transactions`.`data3` AS `data3`,`ncs_transactions`.`channel` AS `channel`,`ncs_transactions`.`episode` AS `episode`,`ncs_transactions`.`timeslot` AS `timeslot`,`ncs_transactions`.`exit` AS `exit`,`ncs_transactions`.`page_position` AS `page_position`,`ncs_transactions`.`provideractionname` AS `provideractionname`,`ncs_transactions`.`providerorderid` AS `providerorderid`,`ncs_transactions`.`providertype` AS `providertype`,`ncs_transactions`.`providereventdate` AS `providereventdate`,`ncs_transactions`.`providerprocessdate` AS `providerprocessdate`,`ncs_transactions`.`merchantname` AS `merchantname`,`ncs_transactions`.`providerid` AS `providerid`,`ncs_transactions`.`merchantsales` AS `merchantsales`,`ncs_transactions`.`quantity` AS `quantity`,`ncs_transactions`.`providerchannel` AS `providerchannel`,`ncs_transactions`.`estimatedrevenue` AS `estimatedrevenue`,`ncs_transactions`.`dateestimated` AS `dateestimated`,`ncs_transactions`.`dateactual` AS `dateactual`,`ncs_transactions`.`estimateddatafilename` AS `estimateddatafilename`,`ncs_transactions`.`actualdatafilename` AS `actualdatafilename`,`ncs_transactions`.`providerstatus` AS `providerstatus`,`ncs_transactions`.`providercorrected` AS `providercorrected`,`ncs_transactions`.`providerwebsiteid` AS `providerwebsiteid`,`ncs_transactions`.`providerwebsitename` AS `providerwebsitename`,`ncs_transactions`.`provideractionid` AS `provideractionid`,`ncs_transactions`.`modifiedby` AS `modifiedby`,`ncs_transactions`.`reftrans` AS `reftrans`,`ncs_transactions`.`reversed` AS `reversed`,`ncs_transactions`.`dateadjusted` AS `dateadjusted`,`ncs_transactions`.`currref` AS `currref`,`ncs_transactions`.`prevref` AS `prevref`,`ncs_transactions`.`thirdref` AS `thirdref`,`ncs_transactions`.`external_visit_id` AS `external_visit_id`,`ncs_transactions`.`refinceptiondate` AS `refinceptiondate` from `ncs_transactions` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_ccx_cms_map`
--

/*!50001 DROP TABLE IF EXISTS `vw_ccx_cms_map`*/;
/*!50001 DROP VIEW IF EXISTS `vw_ccx_cms_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_ccx_cms_map` AS select `ccdata_test`.`ccx_cms_map`.`ccx_card_id` AS `ccx_card_id`,`ccdata_test`.`ccx_cms_map`.`cms_card_id` AS `cms_card_id` from `ccdata_test`.`ccx_cms_map` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_additional_benefits`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_additional_benefits`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_benefits`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_additional_benefits` AS select `ccdata_test`.`additional_benefits`.`additional_benefit_id` AS `additional_benefit_id`,`ccdata_test`.`additional_benefits`.`card_id` AS `card_id`,`ccdata_test`.`additional_benefits`.`benefit` AS `benefit` from `ccdata_test`.`additional_benefits` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_additional_fees`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_additional_fees`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_fees`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_additional_fees` AS select `ccdata_test`.`additional_fees`.`additional_fee_id` AS `additional_fee_id`,`ccdata_test`.`additional_fees`.`card_id` AS `card_id`,`ccdata_test`.`additional_fees`.`fee` AS `fee` from `ccdata_test`.`additional_fees` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_additional_notes`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_additional_notes`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_additional_notes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_additional_notes` AS select `ccdata_test`.`additional_notes`.`additional_note_id` AS `additional_note_id`,`ccdata_test`.`additional_notes`.`card_id` AS `card_id`,`ccdata_test`.`additional_notes`.`note` AS `note` from `ccdata_test`.`additional_notes` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_approved_promotional_content`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_approved_promotional_content`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_approved_promotional_content`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_approved_promotional_content` AS select `ccdata_test`.`approved_promotional_content`.`approved_promotional_content_id` AS `approved_promotional_content_id`,`ccdata_test`.`approved_promotional_content`.`card_id` AS `card_id`,`ccdata_test`.`approved_promotional_content`.`content` AS `content` from `ccdata_test`.`approved_promotional_content` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_balance_transfers`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_balance_transfers`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_balance_transfers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_balance_transfers` AS select `ccdata_test`.`balance_transfers`.`card_id` AS `card_id`,`ccdata_test`.`balance_transfers`.`accept_partial_balance_transfer` AS `accept_partial_balance_transfer`,`ccdata_test`.`balance_transfers`.`intro_apr` AS `intro_apr`,`ccdata_test`.`balance_transfers`.`intro_apr_used_rate_type` AS `intro_apr_used_rate_type`,`ccdata_test`.`balance_transfers`.`min_intro_period` AS `min_intro_period`,`ccdata_test`.`balance_transfers`.`max_intro_period` AS `max_intro_period`,`ccdata_test`.`balance_transfers`.`intro_period_end_date` AS `intro_period_end_date`,`ccdata_test`.`balance_transfers`.`min_ongoing_apr` AS `min_ongoing_apr`,`ccdata_test`.`balance_transfers`.`min_ongoing_apr_used_rate_type` AS `min_ongoing_apr_used_rate_type`,`ccdata_test`.`balance_transfers`.`max_ongoing_apr` AS `max_ongoing_apr`,`ccdata_test`.`balance_transfers`.`max_ongoing_apr_used_rate_type` AS `max_ongoing_apr_used_rate_type`,`ccdata_test`.`balance_transfers`.`min_default_apr` AS `min_default_apr`,`ccdata_test`.`balance_transfers`.`min_default_apr_used_rate_type` AS `min_default_apr_used_rate_type`,`ccdata_test`.`balance_transfers`.`max_default_apr` AS `max_default_apr`,`ccdata_test`.`balance_transfers`.`max_default_apr_used_rate_type` AS `max_default_apr_used_rate_type`,`ccdata_test`.`balance_transfers`.`min_grace_period` AS `min_grace_period`,`ccdata_test`.`balance_transfers`.`min_finance_charge` AS `min_finance_charge`,`ccdata_test`.`balance_transfers`.`min_fixed_rate_period` AS `min_fixed_rate_period`,`ccdata_test`.`balance_transfers`.`min_fee` AS `min_fee`,`ccdata_test`.`balance_transfers`.`max_fee` AS `max_fee`,`ccdata_test`.`balance_transfers`.`fee_rate` AS `fee_rate`,`ccdata_test`.`balance_transfers`.`min_transfer_amount` AS `min_transfer_amount`,`ccdata_test`.`balance_transfers`.`max_transfer_amount` AS `max_transfer_amount`,`ccdata_test`.`balance_transfers`.`min_payment_amount` AS `min_payment_amount`,`ccdata_test`.`balance_transfers`.`min_payment_percentage` AS `min_payment_percentage`,`ccdata_test`.`balance_transfers`.`display_text` AS `display_text` from `ccdata_test`.`balance_transfers` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_card_tags`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_card_tags`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_card_tags`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_card_tags` AS select `ccdata_test`.`card_tags`.`card_id` AS `card_id`,`ccdata_test`.`card_tags`.`card_tag` AS `card_tag` from `ccdata_test`.`card_tags` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_cards`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_cards`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cards`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_cards` AS select `ccdata_test`.`cards`.`card_id` AS `card_id`,`ccdata_test`.`cards`.`card_sku` AS `card_sku`,`ccdata_test`.`cards`.`issuer` AS `issuer`,`ccdata_test`.`cards`.`effective_date` AS `effective_date`,`ccdata_test`.`cards`.`status` AS `status`,`ccdata_test`.`cards`.`type` AS `type`,`ccdata_test`.`cards`.`image` AS `image`,`ccdata_test`.`cards`.`coissuing_organization` AS `coissuing_organization`,`ccdata_test`.`cards`.`network` AS `network`,`ccdata_test`.`cards`.`title` AS `title`,`ccdata_test`.`cards`.`category` AS `category`,`ccdata_test`.`cards`.`color` AS `color`,`ccdata_test`.`cards`.`initial_setup_fee` AS `initial_setup_fee`,`ccdata_test`.`cards`.`first_annual_fee` AS `first_annual_fee`,`ccdata_test`.`cards`.`ongoing_annual_fee` AS `ongoing_annual_fee`,`ccdata_test`.`cards`.`annual_fee_display_text` AS `annual_fee_display_text`,`ccdata_test`.`cards`.`monthly_fee` AS `monthly_fee`,`ccdata_test`.`cards`.`min_late_payment_fee` AS `min_late_payment_fee`,`ccdata_test`.`cards`.`max_late_payment_fee` AS `max_late_payment_fee`,`ccdata_test`.`cards`.`late_payment_fee_percent` AS `late_payment_fee_percent`,`ccdata_test`.`cards`.`over_limit_fee` AS `over_limit_fee`,`ccdata_test`.`cards`.`returned_payment_fee` AS `returned_payment_fee`,`ccdata_test`.`cards`.`dishonored_convenience_check_fee` AS `dishonored_convenience_check_fee`,`ccdata_test`.`cards`.`convenience_check_stop_payment_fee` AS `convenience_check_stop_payment_fee`,`ccdata_test`.`cards`.`balance_transfer_cancellation_fee` AS `balance_transfer_cancellation_fee`,`ccdata_test`.`cards`.`bank_wire_payment_fee` AS `bank_wire_payment_fee`,`ccdata_test`.`cards`.`statement_copy_fee` AS `statement_copy_fee`,`ccdata_test`.`cards`.`inactivity_fee` AS `inactivity_fee`,`ccdata_test`.`cards`.`intro_apr` AS `intro_apr`,`ccdata_test`.`cards`.`intro_apr_used_rate_type` AS `intro_apr_used_rate_type`,`ccdata_test`.`cards`.`intro_apr_display_text` AS `intro_apr_display_text`,`ccdata_test`.`cards`.`min_intro_period` AS `min_intro_period`,`ccdata_test`.`cards`.`max_intro_period` AS `max_intro_period`,`ccdata_test`.`cards`.`intro_period_display_text` AS `intro_period_display_text`,`ccdata_test`.`cards`.`intro_period_end_date` AS `intro_period_end_date`,`ccdata_test`.`cards`.`min_ongoing_apr` AS `min_ongoing_apr`,`ccdata_test`.`cards`.`min_ongoing_apr_used_rate_type` AS `min_ongoing_apr_used_rate_type`,`ccdata_test`.`cards`.`max_ongoing_apr` AS `max_ongoing_apr`,`ccdata_test`.`cards`.`max_ongoing_apr_used_rate_type` AS `max_ongoing_apr_used_rate_type`,`ccdata_test`.`cards`.`ongoing_apr_display_text` AS `ongoing_apr_display_text`,`ccdata_test`.`cards`.`min_default_apr` AS `min_default_apr`,`ccdata_test`.`cards`.`min_default_apr_used_rate_type` AS `min_default_apr_used_rate_type`,`ccdata_test`.`cards`.`max_default_apr` AS `max_default_apr`,`ccdata_test`.`cards`.`max_default_apr_used_rate_type` AS `max_default_apr_used_rate_type`,`ccdata_test`.`cards`.`min_grace_period` AS `min_grace_period`,`ccdata_test`.`cards`.`min_finance_charge` AS `min_finance_charge`,`ccdata_test`.`cards`.`min_fixed_rate_period` AS `min_fixed_rate_period`,`ccdata_test`.`cards`.`balance_compute_method` AS `balance_compute_method`,`ccdata_test`.`cards`.`min_payment_amount` AS `min_payment_amount`,`ccdata_test`.`cards`.`min_payment_percentage` AS `min_payment_percentage`,`ccdata_test`.`cards`.`credit_needed` AS `credit_needed`,`ccdata_test`.`cards`.`credit_needed_display_text` AS `credit_needed_display_text`,`ccdata_test`.`cards`.`min_credit_line` AS `min_credit_line`,`ccdata_test`.`cards`.`max_credit_line` AS `max_credit_line`,`ccdata_test`.`cards`.`min_income` AS `min_income`,`ccdata_test`.`cards`.`min_between_applications_period` AS `min_between_applications_period`,`ccdata_test`.`cards`.`interest_rate_type` AS `interest_rate_type`,`ccdata_test`.`cards`.`used_index_rate` AS `used_index_rate`,`ccdata_test`.`cards`.`index_rate_definition` AS `index_rate_definition`,`ccdata_test`.`cards`.`apply_payment` AS `apply_payment`,`ccdata_test`.`cards`.`foreign_exchange_min_fee` AS `foreign_exchange_min_fee`,`ccdata_test`.`cards`.`foreign_exchange_max_fee` AS `foreign_exchange_max_fee`,`ccdata_test`.`cards`.`foreign_exchange_fee_rate` AS `foreign_exchange_fee_rate`,`ccdata_test`.`cards`.`custom_prepaid_display_text` AS `custom_prepaid_display_text`,`ccdata_test`.`cards`.`modified_date` AS `modified_date`,`ccdata_test`.`cards`.`deleted` AS `deleted`,`ccdata_test`.`cards`.`bt_intro_apr_display_text` AS `bt_intro_apr_display_text`,`ccdata_test`.`cards`.`bt_intro_period_display_text` AS `bt_intro_period_display_text` from `ccdata_test`.`cards` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_cash_advances`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_cash_advances`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cash_advances`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_cash_advances` AS select `ccdata_test`.`cash_advances`.`card_id` AS `card_id`,`ccdata_test`.`cash_advances`.`intro_apr` AS `intro_apr`,`ccdata_test`.`cash_advances`.`intro_apr_used_rate_type` AS `intro_apr_used_rate_type`,`ccdata_test`.`cash_advances`.`min_intro_period` AS `min_intro_period`,`ccdata_test`.`cash_advances`.`max_intro_period` AS `max_intro_period`,`ccdata_test`.`cash_advances`.`intro_period_end_date` AS `intro_period_end_date`,`ccdata_test`.`cash_advances`.`min_ongoing_apr` AS `min_ongoing_apr`,`ccdata_test`.`cash_advances`.`min_ongoing_apr_used_rate_type` AS `min_ongoing_apr_used_rate_type`,`ccdata_test`.`cash_advances`.`max_ongoing_apr` AS `max_ongoing_apr`,`ccdata_test`.`cash_advances`.`max_ongoing_apr_used_rate_type` AS `max_ongoing_apr_used_rate_type`,`ccdata_test`.`cash_advances`.`min_default_apr` AS `min_default_apr`,`ccdata_test`.`cash_advances`.`min_default_apr_used_rate_type` AS `min_default_apr_used_rate_type`,`ccdata_test`.`cash_advances`.`max_default_apr` AS `max_default_apr`,`ccdata_test`.`cash_advances`.`max_default_apr_used_rate_type` AS `max_default_apr_used_rate_type`,`ccdata_test`.`cash_advances`.`min_grace_period` AS `min_grace_period`,`ccdata_test`.`cash_advances`.`min_finance_charge` AS `min_finance_charge`,`ccdata_test`.`cash_advances`.`min_fixed_rate_period` AS `min_fixed_rate_period`,`ccdata_test`.`cash_advances`.`min_fee` AS `min_fee`,`ccdata_test`.`cash_advances`.`max_fee` AS `max_fee`,`ccdata_test`.`cash_advances`.`fee_rate` AS `fee_rate`,`ccdata_test`.`cash_advances`.`max_convenience_check_fee` AS `max_convenience_check_fee`,`ccdata_test`.`cash_advances`.`min_payment_amount` AS `min_payment_amount`,`ccdata_test`.`cash_advances`.`min_payment_percentage` AS `min_payment_percentage`,`ccdata_test`.`cash_advances`.`cash_advance_limit` AS `cash_advance_limit` from `ccdata_test`.`cash_advances` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_cash_back`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_cash_back`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_cash_back`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_cash_back` AS select `ccdata_test`.`cash_back`.`card_id` AS `card_id`,`ccdata_test`.`cash_back`.`base_reward_amount` AS `base_reward_amount`,`ccdata_test`.`cash_back`.`special_reward_amount` AS `special_reward_amount`,`ccdata_test`.`cash_back`.`special_reward_description` AS `special_reward_description`,`ccdata_test`.`cash_back`.`first_round_bonus` AS `first_round_bonus`,`ccdata_test`.`cash_back`.`annual_bonus` AS `annual_bonus`,`ccdata_test`.`cash_back`.`other_bonus` AS `other_bonus`,`ccdata_test`.`cash_back`.`intro_reward_period` AS `intro_reward_period`,`ccdata_test`.`cash_back`.`intro_reward_amount` AS `intro_reward_amount`,`ccdata_test`.`cash_back`.`intro_special_reward_amount` AS `intro_special_reward_amount`,`ccdata_test`.`cash_back`.`max_annual_reward` AS `max_annual_reward` from `ccdata_test`.`cash_back` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_commercial_features`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_commercial_features`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_commercial_features`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_commercial_features` AS select `ccdata_test`.`commercial_features`.`card_id` AS `card_id`,`ccdata_test`.`commercial_features`.`reporting_features` AS `reporting_features`,`ccdata_test`.`commercial_features`.`travel_expense_management` AS `travel_expense_management`,`ccdata_test`.`commercial_features`.`purchasing_expense_management` AS `purchasing_expense_management`,`ccdata_test`.`commercial_features`.`fleet_expense_management` AS `fleet_expense_management` from `ccdata_test`.`commercial_features` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_frequent_flier`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_frequent_flier`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_frequent_flier`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_frequent_flier` AS select `ccdata_test`.`frequent_flier`.`card_id` AS `card_id`,`ccdata_test`.`frequent_flier`.`base_reward_amount` AS `base_reward_amount`,`ccdata_test`.`frequent_flier`.`special_reward_amount` AS `special_reward_amount`,`ccdata_test`.`frequent_flier`.`special_reward_description` AS `special_reward_description`,`ccdata_test`.`frequent_flier`.`which_airlines` AS `which_airlines`,`ccdata_test`.`frequent_flier`.`subject_to_blackout_dates` AS `subject_to_blackout_dates`,`ccdata_test`.`frequent_flier`.`first_purchase_bonus` AS `first_purchase_bonus`,`ccdata_test`.`frequent_flier`.`other_bonus` AS `other_bonus`,`ccdata_test`.`frequent_flier`.`intro_reward_period` AS `intro_reward_period`,`ccdata_test`.`frequent_flier`.`intro_reward_amount` AS `intro_reward_amount`,`ccdata_test`.`frequent_flier`.`intro_special_reward_amount` AS `intro_special_reward_amount`,`ccdata_test`.`frequent_flier`.`max_annual_reward` AS `max_annual_reward` from `ccdata_test`.`frequent_flier` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_other_benefits`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_other_benefits`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_other_benefits`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_other_benefits` AS select `ccdata_test`.`other_benefits`.`card_id` AS `card_id`,`ccdata_test`.`other_benefits`.`insurance` AS `insurance`,`ccdata_test`.`other_benefits`.`retail_discounts` AS `retail_discounts`,`ccdata_test`.`other_benefits`.`extended_warranties` AS `extended_warranties`,`ccdata_test`.`other_benefits`.`roadside_assistance` AS `roadside_assistance`,`ccdata_test`.`other_benefits`.`security_identity_solution` AS `security_identity_solution`,`ccdata_test`.`other_benefits`.`account_protection` AS `account_protection`,`ccdata_test`.`other_benefits`.`consierge_service` AS `consierge_service`,`ccdata_test`.`other_benefits`.`card_design` AS `card_design`,`ccdata_test`.`other_benefits`.`mini_card` AS `mini_card`,`ccdata_test`.`other_benefits`.`photo_security` AS `photo_security`,`ccdata_test`.`other_benefits`.`personalization` AS `personalization` from `ccdata_test`.`other_benefits` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_point_rewards`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_point_rewards`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_point_rewards`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_point_rewards` AS select `ccdata_test`.`point_rewards`.`card_id` AS `card_id`,`ccdata_test`.`point_rewards`.`base_reward_amount` AS `base_reward_amount`,`ccdata_test`.`point_rewards`.`special_reward_amount` AS `special_reward_amount`,`ccdata_test`.`point_rewards`.`special_reward_description` AS `special_reward_description`,`ccdata_test`.`point_rewards`.`where_points_redeemed` AS `where_points_redeemed`,`ccdata_test`.`point_rewards`.`value_of_points` AS `value_of_points`,`ccdata_test`.`point_rewards`.`first_purchase_bonus` AS `first_purchase_bonus`,`ccdata_test`.`point_rewards`.`other_bonus` AS `other_bonus`,`ccdata_test`.`point_rewards`.`intro_reward_period` AS `intro_reward_period`,`ccdata_test`.`point_rewards`.`intro_reward_amount` AS `intro_reward_amount`,`ccdata_test`.`point_rewards`.`intro_special_reward_amount` AS `intro_special_reward_amount`,`ccdata_test`.`point_rewards`.`max_annual_reward` AS `max_annual_reward` from `ccdata_test`.`point_rewards` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_ccx_prepaid_card_fees`
--

/*!50001 DROP TABLE IF EXISTS `vw_cms_ccx_prepaid_card_fees`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cms_ccx_prepaid_card_fees`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_ccx_prepaid_card_fees` AS select `ccdata_test`.`prepaid_card_fees`.`card_id` AS `card_id`,`ccdata_test`.`prepaid_card_fees`.`replacement_card_fee` AS `replacement_card_fee`,`ccdata_test`.`prepaid_card_fees`.`atm_fee` AS `atm_fee`,`ccdata_test`.`prepaid_card_fees`.`live_teller_withdrawal_fee` AS `live_teller_withdrawal_fee`,`ccdata_test`.`prepaid_card_fees`.`atm_balance_inquiry_fee` AS `atm_balance_inquiry_fee`,`ccdata_test`.`prepaid_card_fees`.`monthly_inactive_account_fee` AS `monthly_inactive_account_fee`,`ccdata_test`.`prepaid_card_fees`.`automated_telephone_inquiry_fee` AS `automated_telephone_inquiry_fee`,`ccdata_test`.`prepaid_card_fees`.`customer_service_live_call_fee` AS `customer_service_live_call_fee`,`ccdata_test`.`prepaid_card_fees`.`activation_fee` AS `activation_fee`,`ccdata_test`.`prepaid_card_fees`.`cancel_card_fee` AS `cancel_card_fee`,`ccdata_test`.`prepaid_card_fees`.`application_fee` AS `application_fee`,`ccdata_test`.`prepaid_card_fees`.`purchase_merchant_fee` AS `purchase_merchant_fee`,`ccdata_test`.`prepaid_card_fees`.`purchase_online_fee` AS `purchase_online_fee`,`ccdata_test`.`prepaid_card_fees`.`purchase_telephone_fee` AS `purchase_telephone_fee`,`ccdata_test`.`prepaid_card_fees`.`signature_transaction_fee` AS `signature_transaction_fee`,`ccdata_test`.`prepaid_card_fees`.`pin_transaction_fee` AS `pin_transaction_fee`,`ccdata_test`.`prepaid_card_fees`.`load_fee` AS `load_fee` from `ccdata_test`.`prepaid_card_fees` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cp_quizzes`
--

/*!50001 DROP TABLE IF EXISTS `vw_cp_quizzes`*/;
/*!50001 DROP VIEW IF EXISTS `vw_cp_quizzes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cp_quizzes` AS select `cardpress`.`cp_quizzes`.`quiz_id` AS `quiz_id`,`cardpress`.`cp_quizzes`.`title` AS `title`,`cardpress`.`cp_quizzes`.`intro_text` AS `intro_text`,`cardpress`.`cp_quizzes`.`pre_result_text` AS `pre_result_text`,`cardpress`.`cp_quizzes`.`goodbye_text` AS `goodbye_text`,`cardpress`.`cp_quizzes`.`default_submit_text` AS `default_submit_text`,`cardpress`.`cp_quizzes`.`question_plume` AS `question_plume`,`cardpress`.`cp_quizzes`.`fid` AS `fid`,`cardpress`.`cp_quizzes`.`keywords` AS `keywords`,`cardpress`.`cp_quizzes`.`description` AS `description`,`cardpress`.`cp_quizzes`.`actual_page_title` AS `actual_page_title`,`cardpress`.`cp_quizzes`.`update_time` AS `update_time`,`cardpress`.`cp_quizzes`.`active` AS `active` from `cardpress`.`cp_quizzes` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_historical_2depc_rates_consolidated_card_group`
--

/*!50001 DROP TABLE IF EXISTS `vw_historical_2depc_rates_consolidated_card_group`*/;
/*!50001 DROP VIEW IF EXISTS `vw_historical_2depc_rates_consolidated_card_group`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_historical_2depc_rates_consolidated_card_group` AS select `cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`rate_id` AS `rate_id`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`click_date` AS `click_date`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`click_month` AS `click_month`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`card` AS `card`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`card_id` AS `card_id`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`card_name` AS `card_name`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`card_group_id` AS `card_group_id`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`card_group_name` AS `card_group_name`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`merchant_id` AS `merchant_id`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`merchant_name` AS `merchant_name`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`exit_page_id` AS `exit_page_id`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`exit_page_name` AS `exit_page_name`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`estimated_epc` AS `estimated_epc`,`cccomus_reporting`.`historical_2depc_rates_consolidated_card_group`.`actual_epc` AS `actual_epc` from `cccomus_reporting`.`historical_2depc_rates_consolidated_card_group` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_sales_rate`
--

/*!50001 DROP TABLE IF EXISTS `vw_sales_rate`*/;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sales_rate` AS select `cccomus_reporting`.`sales_rate`.`sales_rate_id` AS `sales_rate_id`,`cccomus_reporting`.`sales_rate`.`click_date` AS `click_date`,`cccomus_reporting`.`sales_rate`.`click_month` AS `click_month`,`cccomus_reporting`.`sales_rate`.`card` AS `card`,`cccomus_reporting`.`sales_rate`.`card_id` AS `card_id`,`cccomus_reporting`.`sales_rate`.`card_name` AS `card_name`,`cccomus_reporting`.`sales_rate`.`merchant_id` AS `merchant_id`,`cccomus_reporting`.`sales_rate`.`merchant_name` AS `merchant_name`,`cccomus_reporting`.`sales_rate`.`exit_page_id` AS `exit_page_id`,`cccomus_reporting`.`sales_rate`.`exit_page_name` AS `exit_page_name`,`cccomus_reporting`.`sales_rate`.`application_count` AS `application_count`,`cccomus_reporting`.`sales_rate`.`click_count` AS `click_count`,`cccomus_reporting`.`sales_rate`.`sales_count` AS `sales_count`,`cccomus_reporting`.`sales_rate`.`revenue_amt` AS `revenue_amt` from `cccomus_reporting`.`sales_rate` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_sales_rate_consolidated`
--

/*!50001 DROP TABLE IF EXISTS `vw_sales_rate_consolidated`*/;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate_consolidated`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sales_rate_consolidated` AS select `cccomus_reporting`.`sales_rate_consolidated`.`sales_rate_id` AS `sales_rate_id`,`cccomus_reporting`.`sales_rate_consolidated`.`click_date` AS `click_date`,`cccomus_reporting`.`sales_rate_consolidated`.`click_month` AS `click_month`,`cccomus_reporting`.`sales_rate_consolidated`.`card` AS `card`,`cccomus_reporting`.`sales_rate_consolidated`.`card_id` AS `card_id`,`cccomus_reporting`.`sales_rate_consolidated`.`card_name` AS `card_name`,`cccomus_reporting`.`sales_rate_consolidated`.`merchant_id` AS `merchant_id`,`cccomus_reporting`.`sales_rate_consolidated`.`merchant_name` AS `merchant_name`,`cccomus_reporting`.`sales_rate_consolidated`.`exit_page_id` AS `exit_page_id`,`cccomus_reporting`.`sales_rate_consolidated`.`exit_page_name` AS `exit_page_name`,`cccomus_reporting`.`sales_rate_consolidated`.`application_count` AS `application_count`,`cccomus_reporting`.`sales_rate_consolidated`.`click_count` AS `click_count`,`cccomus_reporting`.`sales_rate_consolidated`.`sales_count` AS `sales_count`,`cccomus_reporting`.`sales_rate_consolidated`.`revenue_amt` AS `revenue_amt` from `cccomus_reporting`.`sales_rate_consolidated` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_sales_rate_summary_transactions`
--

/*!50001 DROP TABLE IF EXISTS `vw_sales_rate_summary_transactions`*/;
/*!50001 DROP VIEW IF EXISTS `vw_sales_rate_summary_transactions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sales_rate_summary_transactions` AS select `t`.`transid` AS `transid`,`t`.`transtype` AS `transtype`,`t`.`dateinserted` AS `dateinserted`,`t`.`quantity` AS `quantity`,`t`.`estimatedrevenue` AS `estimatedrevenue`,`t`.`bannerid` AS `bannerid`,(case `t`.`exit` when NULL then 0 when 1415 then 1077 when 1397 then 11 when 1398 then 12 when 1399 then 13 when 1400 then 14 when 1406 then 15 when 1407 then 16 when 1408 then 17 when 1410 then 18 when 1409 then 19 when 1414 then 20 when 1416 then 21 when 1417 then 22 when 1418 then 23 when 1420 then 25 when 1421 then 26 when 1422 then 27 when 1423 then 28 when 1424 then 30 when 1425 then 31 when 1426 then 32 when 1419 then 39 when 1413 then 74 when 1412 then 75 when 1411 then 76 when 1401 then 77 when 1402 then 78 when 1403 then 79 when 1404 then 80 when 1405 then 82 when 1427 then 979 when 1478 then 1477 else `t`.`exit` end) AS `exit_page_id`,(case `t`.`data3` when NULL then _utf8'Unmatched' when 0 then _utf8'Unmatched' when 1 then _utf8'Matched' else _utf8'Unmatched' end) AS `card_match` from `transactions` `t` where (`t`.`affiliateid` <> _latin1'bf97ede0') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_summary_day_offer_clicks_by_page`
--

/*!50001 DROP TABLE IF EXISTS `vw_summary_day_offer_clicks_by_page`*/;
/*!50001 DROP VIEW IF EXISTS `vw_summary_day_offer_clicks_by_page`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_summary_day_offer_clicks_by_page` AS select `cccomus_reporting`.`summary_day_offer_clicks_by_page`.`web_page_id` AS `web_page_id`,`cccomus_reporting`.`summary_day_offer_clicks_by_page`.`click_date` AS `click_date`,`cccomus_reporting`.`summary_day_offer_clicks_by_page`.`page_title` AS `page_title`,`cccomus_reporting`.`summary_day_offer_clicks_by_page`.`click_count` AS `click_count` from `cccomus_reporting`.`summary_day_offer_clicks_by_page` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_summary_day_page_views_by_page`
--

/*!50001 DROP TABLE IF EXISTS `vw_summary_day_page_views_by_page`*/;
/*!50001 DROP VIEW IF EXISTS `vw_summary_day_page_views_by_page`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_summary_day_page_views_by_page` AS select `cccomus_reporting`.`summary_day_page_views_by_page`.`web_page_id` AS `web_page_id`,`cccomus_reporting`.`summary_day_page_views_by_page`.`view_date` AS `view_date`,`cccomus_reporting`.`summary_day_page_views_by_page`.`page_title` AS `page_title`,`cccomus_reporting`.`summary_day_page_views_by_page`.`view_count` AS `view_count`,`cccomus_reporting`.`summary_day_page_views_by_page`.`landing_count` AS `landing_count` from `cccomus_reporting`.`summary_day_page_views_by_page` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_trans_type_calculate_commission`
--

/*!50001 DROP TABLE IF EXISTS `vw_trans_type_calculate_commission`*/;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_calculate_commission`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_trans_type_calculate_commission` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where (`transaction_types`.`calculate_commission` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_trans_type_count_as_sale`
--

/*!50001 DROP TABLE IF EXISTS `vw_trans_type_count_as_sale`*/;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_count_as_sale`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_trans_type_count_as_sale` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where (`transaction_types`.`count_as_sale` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_trans_type_is_rev_split`
--

/*!50001 DROP TABLE IF EXISTS `vw_trans_type_is_rev_split`*/;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_is_rev_split`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_trans_type_is_rev_split` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where (`transaction_types`.`is_rev_split` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_trans_type_sum_as_epc`
--

/*!50001 DROP TABLE IF EXISTS `vw_trans_type_sum_as_epc`*/;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_sum_as_epc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_trans_type_sum_as_epc` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where (`transaction_types`.`sum_as_epc` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_trans_type_sum_as_revenue`
--

/*!50001 DROP TABLE IF EXISTS `vw_trans_type_sum_as_revenue`*/;
/*!50001 DROP VIEW IF EXISTS `vw_trans_type_sum_as_revenue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_trans_type_sum_as_revenue` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where (`transaction_types`.`sum_as_revenue` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_transtype_reporting`
--

/*!50001 DROP TABLE IF EXISTS `vw_transtype_reporting`*/;
/*!50001 DROP VIEW IF EXISTS `vw_transtype_reporting`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_transtype_reporting` AS select `transaction_types`.`transaction_type` AS `transaction_type` from `transaction_types` where ((`transaction_types`.`count_as_sale` = 1) or (`transaction_types`.`sum_as_revenue` = 1) or (`transaction_types`.`transaction_type` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_us_publish_history`
--

/*!50001 DROP TABLE IF EXISTS `vw_us_publish_history`*/;
/*!50001 DROP VIEW IF EXISTS `vw_us_publish_history`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_us_publish_history` AS select `bh`.`build_history_id` AS `build_history_id`,`bh`.`site_id` AS `site_id`,`bh`.`build_time` AS `build_time`,`bh`.`user_id` AS `user_id`,`bh`.`published` AS `published`,`bh`.`publish_time` AS `publish_time`,`bh`.`note` AS `note` from `cms`.`build_history` `bh` where ((`bh`.`published` = 1) and (`bh`.`site_id` = 35)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_us_publish_history_detail`
--

/*!50001 DROP TABLE IF EXISTS `vw_us_publish_history_detail`*/;
/*!50001 DROP VIEW IF EXISTS `vw_us_publish_history_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`cccomususer`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_us_publish_history_detail` AS select `bhd`.`build_history_detail_id` AS `build_history_detail_id`,`bhd`.`build_history_id` AS `build_history_id`,`bhd`.`web_page_id` AS `web_page_id`,`bhd`.`sub_page_id` AS `sub_page_id`,`bhd`.`card_id` AS `card_id`,`bhd`.`web_page_position` AS `web_page_position`,`bhd`.`sub_page_position` AS `sub_page_position`,`bhd`.`web_page_number` AS `web_page_number`,`bhd`.`estimated_epc` AS `estimated_epc` from (`cms`.`build_history_detail` `bhd` join `cms`.`build_history` `bh` on((`bhd`.`build_history_id` = `bh`.`build_history_id`))) where ((`bh`.`published` = 1) and (`bh`.`site_id` = 35)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-10 16:36:28
