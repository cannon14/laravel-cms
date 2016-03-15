-- MySQL dump 10.13  Distrib 5.1.69, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ccdata_test
-- ------------------------------------------------------
-- Server version	5.1.69-0ubuntu0.11.10.1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,MYSQL40' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additional_benefits`
--

DROP TABLE IF EXISTS `additional_benefits`;
CREATE TABLE `additional_benefits` (
  `additional_benefit_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `benefit` varchar(255) NOT NULL,
  PRIMARY KEY (`additional_benefit_id`),
  UNIQUE KEY `IDX_sku_issuer_benefit` (`card_id`,`benefit`)
) TYPE=MyISAM AUTO_INCREMENT=17;

--
-- Table structure for table `additional_fees`
--

DROP TABLE IF EXISTS `additional_fees`;
CREATE TABLE `additional_fees` (
  `additional_fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `fee` varchar(255) NOT NULL,
  PRIMARY KEY (`additional_fee_id`),
  UNIQUE KEY `IDX_sku_issuer_fee` (`card_id`,`fee`)
) TYPE=MyISAM AUTO_INCREMENT=19;

--
-- Table structure for table `additional_notes`
--

DROP TABLE IF EXISTS `additional_notes`;
CREATE TABLE `additional_notes` (
  `additional_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`additional_note_id`),
  UNIQUE KEY `IDX_sku_issuer_note` (`card_id`,`note`)
) TYPE=MyISAM AUTO_INCREMENT=82;

--
-- Table structure for table `alternate_links`
--

DROP TABLE IF EXISTS `alternate_links`;
CREATE TABLE `alternate_links` (
  `affiliate_id` varchar(8) NOT NULL,
  `clickable_id` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `website_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`affiliate_id`,`clickable_id`,`website_id`)
) TYPE=MyISAM;

--
-- Table structure for table `approved_promotional_content`
--

DROP TABLE IF EXISTS `approved_promotional_content`;
CREATE TABLE `approved_promotional_content` (
  `approved_promotional_content_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`approved_promotional_content_id`)
) TYPE=MyISAM AUTO_INCREMENT=31690;

--
-- Table structure for table `balance_transfers`
--

DROP TABLE IF EXISTS `balance_transfers`;
CREATE TABLE `balance_transfers` (
  `card_id` int(11) NOT NULL,
  `accept_partial_balance_transfer` int(1) NOT NULL DEFAULT '0',
  `intro_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `intro_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_intro_period` int(11) NOT NULL DEFAULT '0',
  `max_intro_period` int(11) NOT NULL DEFAULT '0',
  `intro_period_end_date` date NOT NULL,
  `min_ongoing_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `min_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_ongoing_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `max_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_default_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `min_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_default_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `max_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_grace_period` int(11) NOT NULL DEFAULT '0',
  `min_finance_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_fixed_rate_period` int(11) NOT NULL DEFAULT '0',
  `min_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `max_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fee_rate` decimal(6,3) NOT NULL DEFAULT '0.000',
  `min_transfer_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `max_transfer_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_payment_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_payment_percentage` decimal(6,3) NOT NULL DEFAULT '0.000',
  `display_text` text,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_boost`
--

DROP TABLE IF EXISTS `card_boost`;
CREATE TABLE `card_boost` (
  `card_id` varchar(20) NOT NULL DEFAULT '',
  `boost` double DEFAULT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_categories`
--

DROP TABLE IF EXISTS `card_categories`;
CREATE TABLE `card_categories` (
  `card_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_category_name` varchar(255) NOT NULL,
  `card_category_display_name` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_category_id`)
) TYPE=MyISAM AUTO_INCREMENT=70;

--
-- Table structure for table `card_category_contexts`
--

DROP TABLE IF EXISTS `card_category_contexts`;
CREATE TABLE `card_category_contexts` (
  `card_category_context_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_category_context_name` varchar(255) NOT NULL,
  PRIMARY KEY (`card_category_context_id`)
) TYPE=MyISAM AUTO_INCREMENT=2;

--
-- Table structure for table `card_category_group_to_category`
--

DROP TABLE IF EXISTS `card_category_group_to_category`;
CREATE TABLE `card_category_group_to_category` (
  `card_category_group_id` int(10) unsigned NOT NULL,
  `card_category_id` int(10) unsigned NOT NULL,
  `card_category_group_rank` int(11) DEFAULT NULL COMMENT 'Stores ordering value of category within a group',
  PRIMARY KEY (`card_category_group_id`,`card_category_id`)
) TYPE=MyISAM;

--
-- Table structure for table `card_category_groups`
--

DROP TABLE IF EXISTS `card_category_groups`;
CREATE TABLE `card_category_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_category_group_name` varchar(64) NOT NULL,
  `context_id` smallint(6) DEFAULT '1',
  `inserted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6;

--
-- Table structure for table `card_category_ranks`
--

DROP TABLE IF EXISTS `card_category_ranks`;
CREATE TABLE `card_category_ranks` (
  `card_category_rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_category_rank` int(11) NOT NULL,
  `card_category_context_id` int(11) NOT NULL,
  `card_category_id` int(11) NOT NULL,
  PRIMARY KEY (`card_category_rank_id`)
) TYPE=MyISAM AUTO_INCREMENT=82;

--
-- Table structure for table `card_ranks`
--

DROP TABLE IF EXISTS `card_ranks`;
CREATE TABLE `card_ranks` (
  `card_rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_rank` int(11) NOT NULL,
  `card_category_context_id` int(11) NOT NULL,
  `card_category_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`card_rank_id`),
  KEY `card_id_cat_idx` (`card_id`,`card_category_id`),
  KEY `card_cat_idx` (`card_category_id`)
) TYPE=MyISAM AUTO_INCREMENT=815525;

--
-- Table structure for table `card_tags`
--

DROP TABLE IF EXISTS `card_tags`;
CREATE TABLE `card_tags` (
  `card_id` int(11) NOT NULL,
  `card_tag` varchar(255) NOT NULL,
  PRIMARY KEY (`card_id`,`card_tag`)
) TYPE=MyISAM;

--
-- Table structure for table `cardhistory`
--

DROP TABLE IF EXISTS `cardhistory`;
CREATE TABLE `cardhistory` (
  `campaigntype_id` varchar(16) NOT NULL DEFAULT '',
  `dateinserted` date NOT NULL DEFAULT '0000-00-00',
  `campaigntype_name` varchar(255) DEFAULT NULL,
  `intro_apr` float(4,2) DEFAULT NULL,
  `delta_intro_apr` float(4,2) DEFAULT NULL,
  `intro_apr_movement` varchar(255) DEFAULT NULL,
  `intro_apr_period` float(4,2) DEFAULT NULL,
  `delta_intro_apr_period` float(4,2) DEFAULT NULL,
  `intro_apr_period_movement` varchar(255) DEFAULT NULL,
  `regular_apr` float(4,2) DEFAULT NULL,
  `delta_regular_apr` float(4,2) DEFAULT NULL,
  `regular_apr_movement` varchar(255) DEFAULT NULL,
  `card_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`campaigntype_id`,`dateinserted`),
  KEY `dateinserted` (`dateinserted`)
) TYPE=MyISAM;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `card_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_sku` varchar(15) NOT NULL,
  `issuer` int(11) DEFAULT NULL,
  `effective_date` date NOT NULL,
  `status` varchar(15) DEFAULT 'NEW',
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `coissuing_organization` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `initial_setup_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `first_annual_fee` decimal(12,2) DEFAULT NULL,
  `ongoing_annual_fee` decimal(12,2) DEFAULT NULL,
  `annual_fee_display_text` text,
  `monthly_fee` decimal(12,2) DEFAULT '0.00',
  `min_late_payment_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `max_late_payment_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `late_payment_fee_percent` decimal(6,3) NOT NULL DEFAULT '0.000',
  `over_limit_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `returned_payment_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dishonored_convenience_check_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `convenience_check_stop_payment_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance_transfer_cancellation_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `bank_wire_payment_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `statement_copy_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `inactivity_fee` decimal(12,2) DEFAULT '0.00',
  `intro_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `intro_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `intro_apr_display_text` text,
  `min_intro_period` int(11) NOT NULL DEFAULT '0',
  `max_intro_period` int(11) NOT NULL DEFAULT '0',
  `intro_period_display_text` text,
  `intro_period_end_date` date DEFAULT NULL,
  `min_ongoing_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `min_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_ongoing_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `max_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `ongoing_apr_display_text` text,
  `min_default_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `min_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_default_apr` decimal(6,3) NOT NULL DEFAULT '0.000',
  `max_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_grace_period` int(11) NOT NULL DEFAULT '0',
  `min_finance_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_fixed_rate_period` int(11) NOT NULL DEFAULT '0',
  `balance_compute_method` varchar(255) NOT NULL,
  `min_payment_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_payment_percentage` decimal(6,3) NOT NULL DEFAULT '0.000',
  `credit_needed` varchar(255) NOT NULL,
  `credit_needed_display_text` text,
  `min_credit_line` decimal(12,2) NOT NULL DEFAULT '0.00',
  `max_credit_line` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_income` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_between_applications_period` int(11) NOT NULL DEFAULT '0',
  `interest_rate_type` varchar(255) NOT NULL,
  `used_index_rate` varchar(255) NOT NULL,
  `index_rate_definition` varchar(255) NOT NULL,
  `apply_payment` varchar(255) NOT NULL,
  `foreign_exchange_min_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `foreign_exchange_max_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `foreign_exchange_fee_rate` decimal(6,3) NOT NULL DEFAULT '0.000',
  `custom_prepaid_display_text` varchar(50) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `bt_intro_apr_display_text` text,
  `bt_intro_period_display_text` text,
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `IDX_SKU_Issuer` (`card_sku`,`issuer`)
) TYPE=MyISAM AUTO_INCREMENT=3338;

--
-- Table structure for table `cash_advances`
--

DROP TABLE IF EXISTS `cash_advances`;
CREATE TABLE `cash_advances` (
  `card_id` int(11) NOT NULL,
  `intro_apr` decimal(6,3) NOT NULL,
  `intro_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_intro_period` int(11) NOT NULL,
  `max_intro_period` int(11) NOT NULL,
  `intro_period_end_date` date NOT NULL,
  `min_ongoing_apr` decimal(6,3) NOT NULL,
  `min_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_ongoing_apr` decimal(6,3) NOT NULL,
  `max_ongoing_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_default_apr` decimal(6,3) NOT NULL,
  `min_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `max_default_apr` decimal(6,3) NOT NULL,
  `max_default_apr_used_rate_type` varchar(50) DEFAULT NULL,
  `min_grace_period` int(11) NOT NULL,
  `min_finance_charge` decimal(12,2) NOT NULL,
  `min_fixed_rate_period` int(11) NOT NULL,
  `min_fee` decimal(12,2) NOT NULL,
  `max_fee` decimal(12,2) NOT NULL,
  `fee_rate` decimal(6,3) NOT NULL,
  `max_convenience_check_fee` decimal(12,2) NOT NULL,
  `min_payment_amount` decimal(12,2) NOT NULL,
  `min_payment_percentage` decimal(6,3) NOT NULL,
  `cash_advance_limit` decimal(12,2) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `cash_back`
--

DROP TABLE IF EXISTS `cash_back`;
CREATE TABLE `cash_back` (
  `card_id` int(11) NOT NULL,
  `base_reward_amount` decimal(12,2) NOT NULL,
  `special_reward_amount` decimal(12,2) NOT NULL,
  `special_reward_description` varchar(255) NOT NULL,
  `first_round_bonus` decimal(12,2) NOT NULL,
  `annual_bonus` decimal(12,2) NOT NULL,
  `other_bonus` varchar(255) NOT NULL,
  `intro_reward_period` int(11) NOT NULL,
  `intro_reward_amount` decimal(12,2) NOT NULL,
  `intro_special_reward_amount` decimal(12,2) NOT NULL,
  `max_annual_reward` decimal(12,2) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `ccx_cms_map`
--

DROP TABLE IF EXISTS `ccx_cms_map`;
CREATE TABLE `ccx_cms_map` (
  `ccx_card_id` int(11) NOT NULL,
  `cms_card_id` varchar(15) NOT NULL,
  PRIMARY KEY (`ccx_card_id`,`cms_card_id`)
) TYPE=InnoDB;

--
-- Table structure for table `commercial_features`
--

DROP TABLE IF EXISTS `commercial_features`;
CREATE TABLE `commercial_features` (
  `card_id` int(11) NOT NULL,
  `reporting_features` text NOT NULL,
  `travel_expense_management` text NOT NULL,
  `purchasing_expense_management` text NOT NULL,
  `fleet_expense_management` text NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `cs_carddata`
--

DROP TABLE IF EXISTS `cs_carddata`;
CREATE TABLE `cs_carddata` (
  `cardId` varchar(15) NOT NULL DEFAULT '0',
  `introApr` double(11,2) DEFAULT NULL,
  `introAprPeriod` tinyint(4) DEFAULT NULL,
  `regularApr` double(11,2) DEFAULT NULL,
  `annualFee` double(11,2) DEFAULT NULL,
  `balanceTransfers` tinyint(1) DEFAULT NULL,
  `balanceTransferFee` double(11,2) DEFAULT NULL,
  `balanceTransferIntroApr` double(11,2) DEFAULT NULL,
  `balanceTransferIntroAprPeriod` tinyint(4) DEFAULT NULL,
  `monthlyFee` double(11,2) DEFAULT NULL,
  `creditNeeded` tinyint(4) DEFAULT NULL,
  `dateModified` datetime DEFAULT NULL,
  PRIMARY KEY (`cardId`)
) TYPE=MyISAM;

--
-- Table structure for table `cs_merchants`
--

DROP TABLE IF EXISTS `cs_merchants`;
CREATE TABLE `cs_merchants` (
  `merchantid` int(10) NOT NULL AUTO_INCREMENT,
  `merchantname` varchar(255) DEFAULT NULL,
  `merchantcardpage` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `display_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `site_code` varchar(5) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`merchantid`)
) TYPE=MyISAM AUTO_INCREMENT=167;

--
-- Table structure for table `cs_pagecardexclusionmap`
--

DROP TABLE IF EXISTS `cs_pagecardexclusionmap`;
CREATE TABLE `cs_pagecardexclusionmap` (
  `mapid` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(11) DEFAULT NULL,
  `pageid` int(11) DEFAULT NULL,
  `cardid` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`mapid`),
  KEY `IDX_sitepagecard` (`siteid`,`pageid`,`cardid`)
) TYPE=MyISAM AUTO_INCREMENT=10517;

--
-- Table structure for table `frequent_flier`
--

DROP TABLE IF EXISTS `frequent_flier`;
CREATE TABLE `frequent_flier` (
  `card_id` int(11) NOT NULL,
  `base_reward_amount` int(11) NOT NULL,
  `special_reward_amount` int(11) NOT NULL,
  `special_reward_description` text NOT NULL,
  `which_airlines` text NOT NULL,
  `subject_to_blackout_dates` text NOT NULL,
  `first_purchase_bonus` int(11) NOT NULL,
  `other_bonus` text NOT NULL,
  `intro_reward_period` int(11) NOT NULL,
  `intro_reward_amount` int(11) NOT NULL,
  `intro_special_reward_amount` int(11) NOT NULL,
  `max_annual_reward` int(11) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `merchant_service_details`
--

DROP TABLE IF EXISTS `merchant_service_details`;
CREATE TABLE `merchant_service_details` (
  `merchant_service_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_service_id` varchar(20) DEFAULT NULL,
  `merchant_service_detail_version` int(11) NOT NULL DEFAULT '-1',
  `merchant_service_detail_label` varchar(255) DEFAULT NULL,
  `category_image_path` varchar(100) DEFAULT NULL,
  `category_image_alt_text` varchar(100) DEFAULT NULL,
  `merchant_service_link` varchar(100) DEFAULT NULL,
  `app_link` varchar(100) DEFAULT NULL,
  `merchant_service_image_path` varchar(255) DEFAULT NULL,
  `merchant_service_image_alt_text` varchar(100) DEFAULT NULL,
  `apply_button_alt_text` varchar(100) DEFAULT NULL,
  `merchant_service_header_string` varchar(100) DEFAULT NULL,
  `page_meta` text,
  `disclaimer` text,
  `merchant_service_detail_text` blob,
  `merchant_service_intro_detail` blob,
  `merchant_service_more_detail` blob,
  `fid` int(10) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`merchant_service_detail_id`)
) TYPE=MyISAM AUTO_INCREMENT=154;

--
-- Table structure for table `merchant_services`
--

DROP TABLE IF EXISTS `merchant_services`;
CREATE TABLE `merchant_services` (
  `merchant_service_id` varchar(20) NOT NULL DEFAULT '',
  `merchant_service_name` varchar(255) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` blob,
  `setup_fee` varchar(100) DEFAULT '$@@one_time_setup_fee@@',
  `active_setup_fee` int(1) DEFAULT '0',
  `monthly_minimum` varchar(100) DEFAULT '$@@monthly_minimum@@',
  `active_monthly_minimum` int(1) DEFAULT NULL,
  `gateway_fee` varchar(100) DEFAULT '$@@gateway_fee@@',
  `active_gateway_fee` int(1) DEFAULT NULL,
  `statement_fee` varchar(100) DEFAULT '$@@statement_fee@@',
  `active_statement_fee` int(1) DEFAULT NULL,
  `discount_rate` varchar(100) DEFAULT '@@discount_rate@@%',
  `active_discount_rate` int(1) DEFAULT NULL,
  `transaction_fee` varchar(100) DEFAULT '$@@transaction_fee@@',
  `active_transaction_fee` int(1) DEFAULT NULL,
  `tech_support_fee` varchar(100) DEFAULT '$@@tech_support_fee@@',
  `active_tech_support_fee` int(1) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  `internet_discount_rate` varchar(100) DEFAULT '@@internet_discount_rate@@%',
  `internet_transaction_fee` varchar(100) DEFAULT '$@@internet_transaction_fee@@',
  `address_verification_fee` varchar(100) DEFAULT '$@@address_verification_fee@@',
  `application_fee` varchar(100) DEFAULT '$@@application_fee@@',
  `reserve` varchar(100) DEFAULT '$@@reserve@@',
  `chargeback_fee` varchar(100) DEFAULT '$@@chargeback_fee@@',
  `active_internet_transaction_fee` int(1) DEFAULT '0',
  `active_address_verification_fee` int(1) DEFAULT '0',
  `active_application_fee` int(1) DEFAULT '0',
  `active_reserve` int(1) DEFAULT '0',
  `active_chargeback_fee` int(1) DEFAULT '0',
  `active_internet_discount_rate` int(1) DEFAULT '0',
  PRIMARY KEY (`merchant_service_id`)
) TYPE=MyISAM AUTO_INCREMENT=22774975;

--
-- Table structure for table `other_benefits`
--

DROP TABLE IF EXISTS `other_benefits`;
CREATE TABLE `other_benefits` (
  `card_id` int(11) NOT NULL,
  `insurance` tinyint(1) NOT NULL,
  `retail_discounts` tinyint(1) NOT NULL,
  `extended_warranties` tinyint(1) NOT NULL,
  `roadside_assistance` tinyint(1) NOT NULL,
  `security_identity_solution` tinyint(1) NOT NULL,
  `account_protection` tinyint(1) NOT NULL,
  `consierge_service` tinyint(1) NOT NULL,
  `card_design` tinyint(1) NOT NULL,
  `mini_card` tinyint(1) NOT NULL,
  `photo_security` tinyint(1) NOT NULL,
  `personalization` tinyint(1) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `point_rewards`
--

DROP TABLE IF EXISTS `point_rewards`;
CREATE TABLE `point_rewards` (
  `card_id` int(11) NOT NULL,
  `base_reward_amount` decimal(12,2) NOT NULL,
  `special_reward_amount` decimal(12,2) NOT NULL,
  `special_reward_description` text NOT NULL,
  `where_points_redeemed` text NOT NULL,
  `value_of_points` varchar(255) NOT NULL,
  `first_purchase_bonus` int(11) NOT NULL,
  `other_bonus` text NOT NULL,
  `intro_reward_period` int(11) NOT NULL,
  `intro_reward_amount` int(11) NOT NULL,
  `intro_special_reward_amount` int(11) NOT NULL,
  `max_annual_reward` int(11) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `prepaid_card_fees`
--

DROP TABLE IF EXISTS `prepaid_card_fees`;
CREATE TABLE `prepaid_card_fees` (
  `card_id` int(11) NOT NULL,
  `replacement_card_fee` decimal(12,2) NOT NULL,
  `atm_fee` decimal(12,2) NOT NULL,
  `live_teller_withdrawal_fee` decimal(12,2) NOT NULL,
  `atm_balance_inquiry_fee` decimal(12,2) NOT NULL,
  `monthly_inactive_account_fee` decimal(12,2) NOT NULL,
  `automated_telephone_inquiry_fee` decimal(12,2) NOT NULL,
  `customer_service_live_call_fee` decimal(12,2) NOT NULL,
  `activation_fee` decimal(12,2) NOT NULL,
  `cancel_card_fee` decimal(12,2) NOT NULL,
  `application_fee` decimal(12,2) NOT NULL,
  `purchase_merchant_fee` decimal(12,2) NOT NULL,
  `purchase_online_fee` decimal(12,2) NOT NULL,
  `purchase_telephone_fee` decimal(12,2) NOT NULL,
  `signature_transaction_fee` decimal(12,2) NOT NULL,
  `pin_transaction_fee` decimal(12,2) NOT NULL,
  `load_fee` decimal(12,2) NOT NULL,
  PRIMARY KEY (`card_id`)
) TYPE=MyISAM;

--
-- Table structure for table `rt_carddetails`
--

DROP TABLE IF EXISTS `rt_carddetails`;
CREATE TABLE `rt_carddetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardShortName` varchar(30) DEFAULT NULL,
  `cardLink` varchar(100) DEFAULT NULL,
  `appLink` varchar(100) DEFAULT NULL,
  `cardDetailVersion` int(10) DEFAULT NULL,
  `cardDetailLabel` varchar(50) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `campaignLink` varchar(32) DEFAULT NULL,
  `cardPageMeta` text,
  `cardDetailText` text,
  `cardIntroDetail` text,
  `cardMoreDetail` text,
  `cardSeeDetails` text,
  `categoryImage` varchar(255) DEFAULT NULL,
  `categoryAltText` varchar(255) DEFAULT NULL,
  `cardIOImage` varchar(255) DEFAULT NULL,
  `cardIOAltText` varchar(255) DEFAULT NULL,
  `cardButtonImage` varchar(255) DEFAULT NULL,
  `cardButtonAltText` varchar(255) DEFAULT NULL,
  `cardIOButtonAltText` varchar(255) DEFAULT NULL,
  `cardIconSmall` varchar(255) DEFAULT NULL,
  `cardIconMid` varchar(255) DEFAULT NULL,
  `cardIconLarge` varchar(255) DEFAULT NULL,
  `detailOrder` int(3) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT '0000-00-00 00:00:00',
  `fid` varchar(50) DEFAULT NULL,
  `cardListingString` varchar(100) DEFAULT NULL,
  `cardPageHeaderString` varchar(100) DEFAULT NULL,
  `imageAltText` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  `specialsDescription` varchar(255) DEFAULT NULL,
  `specialsAdditionalLink` varchar(255) DEFAULT NULL,
  `cardTeaserText` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_carddetaildeleted` (`cardId`,`cardDetailVersion`,`deleted`)
) TYPE=MyISAM AUTO_INCREMENT=2;

--
-- Table structure for table `rt_cardpagemap`
--

DROP TABLE IF EXISTS `rt_cardpagemap`;
CREATE TABLE `rt_cardpagemap` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `pageInsert` int(1) DEFAULT '0',
  `cardpageId` int(10) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`),
  UNIQUE KEY `IDX_cardpage` (`cardpageId`,`cardId`)
) TYPE=MyISAM AUTO_INCREMENT=186941;

--
-- Table structure for table `rt_cardpagemap_affiliate`
--

DROP TABLE IF EXISTS `rt_cardpagemap_affiliate`;
CREATE TABLE `rt_cardpagemap_affiliate` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `pageInsert` int(1) DEFAULT '0',
  `cardpageId` int(10) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`),
  UNIQUE KEY `IDX_cardpage` (`cardpageId`,`cardId`)
) TYPE=InnoDB AUTO_INCREMENT=185006;

--
-- Table structure for table `rt_cardpagemap_bankrate`
--

DROP TABLE IF EXISTS `rt_cardpagemap_bankrate`;
CREATE TABLE `rt_cardpagemap_bankrate` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `pageInsert` int(1) DEFAULT '0',
  `cardpageId` int(10) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`),
  UNIQUE KEY `IDX_cardpage` (`cardpageId`,`cardId`)
) TYPE=InnoDB AUTO_INCREMENT=1844;

--
-- Table structure for table `rt_cardpages`
--

DROP TABLE IF EXISTS `rt_cardpages`;
CREATE TABLE `rt_cardpages` (
  `cardpageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(255) DEFAULT NULL,
  `pageType` enum('TYPE','CREDIT','BANK') DEFAULT NULL,
  `contentType` varchar(255) DEFAULT NULL,
  `alternate_tracking_flag` tinyint(1) DEFAULT NULL,
  `schumerType` varchar(20) DEFAULT 'STANDARD',
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  `rollup` tinyint(1) NOT NULL DEFAULT '0',
  `card_category_id` int(11) DEFAULT NULL COMMENT 'References cms.card_categories.card_category_id',
  `active_introApr` int(1) DEFAULT NULL,
  `active_introAprPeriod` int(1) DEFAULT NULL,
  `active_regularApr` int(1) DEFAULT NULL,
  `active_annualFee` int(1) DEFAULT NULL,
  `active_monthlyFee` int(1) DEFAULT NULL,
  `active_balanceTransfers` int(1) DEFAULT NULL,
  `active_balanceTransferFee` int(1) DEFAULT NULL,
  `active_balanceTransferIntroApr` int(1) DEFAULT NULL,
  `active_balanceTransferIntroAprPeriod` int(1) DEFAULT NULL,
  `active_creditNeeded` int(1) DEFAULT NULL,
  `active_transactionFeeSignature` int(1) DEFAULT NULL,
  `active_transactionFeePin` int(1) DEFAULT NULL,
  `active_atmFee` int(1) DEFAULT NULL,
  `active_prepaidText` int(1) DEFAULT NULL,
  `active_loadFee` int(1) DEFAULT NULL,
  `active_activationFee` int(1) DEFAULT NULL,
  PRIMARY KEY (`cardpageId`)
) TYPE=MyISAM AUTO_INCREMENT=514;

--
-- Table structure for table `rt_cards`
--

DROP TABLE IF EXISTS `rt_cards`;
CREATE TABLE `rt_cards` (
  `id` varchar(15) NOT NULL,
  `cardId` varchar(15) NOT NULL,
  `site_code` varchar(5) NOT NULL DEFAULT 'USEN',
  `cardTitle` varchar(100) DEFAULT NULL,
  `cardDescription` text,
  `merchant` int(10) DEFAULT NULL,
  `introApr` varchar(100) DEFAULT '@@introApr@@%*',
  `active_introApr` int(1) DEFAULT '0',
  `introAprPeriod` varchar(100) DEFAULT '@@introAprPeriod@@*',
  `active_introAprPeriod` int(1) DEFAULT '0',
  `regularApr` varchar(100) DEFAULT '@@regularApr@@%*',
  `variable` int(1) DEFAULT '0',
  `active_regularApr` int(1) DEFAULT '0',
  `annualFee` varchar(100) DEFAULT '$@@annualFee@@*',
  `active_annualFee` int(1) DEFAULT '0',
  `monthlyFee` varchar(255) DEFAULT '$@@monthlyFee@@*',
  `active_monthlyFee` int(1) DEFAULT '0',
  `balanceTransfers` varchar(100) DEFAULT '@@balanceTransfers@@*',
  `active_balanceTransfers` int(1) DEFAULT '0',
  `balanceTransferFee` varchar(100) DEFAULT '@@balanceTransferFee@@*',
  `active_balanceTransferFee` int(1) DEFAULT NULL,
  `balanceTransferIntroApr` varchar(100) DEFAULT '@@balanceTransferIntroApr@@*',
  `active_balanceTransferIntroApr` int(1) DEFAULT NULL,
  `balanceTransferIntroAprPeriod` varchar(100) DEFAULT '@@balanceTransferIntroAprPeriod@@*',
  `active_balanceTransferIntroAprPeriod` int(1) DEFAULT NULL,
  `creditNeeded` varchar(100) DEFAULT '@@creditNeeded@@*',
  `active_creditNeeded` int(1) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `ratesAndFees` text,
  `rewards` text,
  `cardBenefits` text,
  `onlineServices` text,
  `footNotes` text,
  `layout` varchar(50) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `subCat` tinyint(1) DEFAULT '0',
  `catTitle` varchar(100) DEFAULT NULL,
  `catDescription` text,
  `catImage` varchar(100) DEFAULT NULL,
  `catImageAltText` varchar(100) DEFAULT NULL,
  `syndicate` tinyint(1) DEFAULT '1',
  `url` varchar(255) DEFAULT NULL,
  `applyByPhoneNumber` varchar(20) DEFAULT NULL,
  `tPageText` text,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `active_epd_pages` int(11) DEFAULT NULL,
  `active_show_epd_rates` int(11) DEFAULT NULL,
  `show_verify` varchar(255) DEFAULT NULL,
  `commission_label` enum('PER_APPLICATION','PER_APPROVAL','PER_CLICK') DEFAULT 'PER_APPROVAL',
  `payout_cap` decimal(6,5) unsigned DEFAULT NULL,
  `card_level_id` int(11) DEFAULT NULL COMMENT 'References cccomus.card_levels.card_level_id',
  `requires_approval` tinyint(1) NOT NULL COMMENT 'Card requires issuer approval before it may be syndicated.',
  `secured` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_cardId` (`cardId`)
) TYPE=InnoDB;

--
-- Table structure for table `rt_pagecategorymap`
--

DROP TABLE IF EXISTS `rt_pagecategorymap`;
CREATE TABLE `rt_pagecategorymap` (
  `categoryPageMapId` int(10) NOT NULL AUTO_INCREMENT,
  `cardpageId` int(10) DEFAULT NULL,
  `categoryId` int(10) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`categoryPageMapId`),
  UNIQUE KEY `IDX_sitepage` (`cardpageId`,`categoryId`)
) TYPE=MyISAM AUTO_INCREMENT=20901;

--
-- Table structure for table `rt_pagedetails`
--

DROP TABLE IF EXISTS `rt_pagedetails`;
CREATE TABLE `rt_pagedetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageDetailVersion` int(11) DEFAULT '-1',
  `pageDetailLabel` varchar(100) DEFAULT NULL,
  `cardpageId` int(11) DEFAULT NULL,
  `pageTitle` varchar(100) DEFAULT NULL,
  `pageIntroDescription` text,
  `pageDescription` text,
  `pageSpecial` text,
  `pageMeta` text,
  `pageLearnMore` text,
  `pageDisclaimer` text,
  `pageHeaderImage` varchar(100) DEFAULT NULL,
  `pageHeaderImageAltText` varchar(100) DEFAULT NULL,
  `pageSpecialOfferImage` varchar(100) DEFAULT NULL,
  `pageSpecialOfferImageAltText` varchar(100) DEFAULT NULL,
  `pageSpecialOfferLink` varchar(100) DEFAULT NULL,
  `pageSmallImage` varchar(100) DEFAULT NULL,
  `pageSmallImageAltText` varchar(100) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `pageLink` varchar(100) DEFAULT NULL,
  `fid` int(20) DEFAULT NULL,
  `pageHeaderString` varchar(255) DEFAULT NULL,
  `primaryNavString` varchar(100) DEFAULT NULL,
  `secondaryNavString` varchar(100) DEFAULT NULL,
  `topPickAltText` varchar(100) DEFAULT NULL,
  `flagTopPick` int(1) DEFAULT NULL,
  `flagAdditionalOffer` int(1) DEFAULT '0',
  `associatedArticleCategory` varchar(255) DEFAULT NULL,
  `articlesPerPage` int(2) DEFAULT '3',
  `enableSort` int(1) DEFAULT '0',
  `itemsPerPage` int(7) DEFAULT '99999',
  `pageSeeAlso` text,
  `siteMapDescription` varchar(255) DEFAULT NULL,
  `siteMapTitle` varchar(100) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  `sitemapLink` int(11) DEFAULT '1',
  `navBarString` varchar(100) DEFAULT NULL,
  `subPageNav` int(1) DEFAULT '0',
  `landingPage` int(1) DEFAULT NULL,
  `landingPageFid` int(10) DEFAULT NULL,
  `landingPageImage` varchar(100) DEFAULT NULL,
  `landingPageHeaderString` blob,
  `itemsOnFirstPage` int(7) NOT NULL DEFAULT '99999',
  `showMainCatOnFirstPage` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_pagedetaildeleted` (`pageDetailVersion`,`cardpageId`,`deleted`)
) TYPE=MyISAM AUTO_INCREMENT=594;

--
-- Table structure for table `rt_pagesubpagemap`
--

DROP TABLE IF EXISTS `rt_pagesubpagemap`;
CREATE TABLE `rt_pagesubpagemap` (
  `mapid` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) DEFAULT NULL,
  `masterpageid` int(10) DEFAULT NULL,
  `subpageid` int(10) DEFAULT NULL,
  `hide` int(1) DEFAULT NULL,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=MyISAM AUTO_INCREMENT=1203;

--
-- Table structure for table `rt_pagesubpagemap_affiliate`
--

DROP TABLE IF EXISTS `rt_pagesubpagemap_affiliate`;
CREATE TABLE `rt_pagesubpagemap_affiliate` (
  `mapid` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) DEFAULT NULL,
  `masterpageid` int(10) DEFAULT NULL,
  `subpageid` int(10) DEFAULT NULL,
  `hide` int(1) DEFAULT NULL,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=InnoDB AUTO_INCREMENT=1191;

--
-- Table structure for table `rt_pagesubpagemap_bankrate`
--

DROP TABLE IF EXISTS `rt_pagesubpagemap_bankrate`;
CREATE TABLE `rt_pagesubpagemap_bankrate` (
  `mapid` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) DEFAULT NULL,
  `masterpageid` int(10) DEFAULT NULL,
  `subpageid` int(10) DEFAULT NULL,
  `hide` int(1) DEFAULT NULL,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=InnoDB;

--
-- Table structure for table `site_codes`
--

DROP TABLE IF EXISTS `site_codes`;
CREATE TABLE `site_codes` (
  `site_code` varchar(5) NOT NULL,
  `site_description` varchar(25) NOT NULL,
  PRIMARY KEY (`site_code`)
) TYPE=InnoDB;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_name` varchar(255) DEFAULT NULL,
  `version_description` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) unsigned zerofill DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`version_id`)
) TYPE=InnoDB AUTO_INCREMENT=40;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-10 16:36:46
