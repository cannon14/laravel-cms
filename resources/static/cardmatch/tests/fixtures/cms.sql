-- MySQL dump 10.13  Distrib 5.1.69, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cms
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
) TYPE=MyISAM AUTO_INCREMENT=31681;

--
-- Table structure for table `arch_build_history_detail_all`
--

DROP TABLE IF EXISTS `arch_build_history_detail_all`;
CREATE TABLE `arch_build_history_detail_all` (
  `build_history_detail_id` int(11) NOT NULL DEFAULT '0',
  `build_history_id` int(11) NOT NULL,
  `web_page_id` int(11) NOT NULL,
  `sub_page_id` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `web_page_position` int(11) NOT NULL,
  `sub_page_position` int(11) NOT NULL,
  `web_page_number` int(11) NOT NULL,
  `estimated_epc` decimal(8,5) DEFAULT NULL
) TYPE=InnoDB;

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
-- Table structure for table `build_history`
--

DROP TABLE IF EXISTS `build_history`;
CREATE TABLE `build_history` (
  `build_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `build_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `publish_time` datetime DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`build_history_id`),
  KEY `idx_build_time` (`build_time`),
  KEY `idx_publish_time` (`publish_time`)
) TYPE=InnoDB AUTO_INCREMENT=7936;

--
-- Table structure for table `build_history_detail`
--

DROP TABLE IF EXISTS `build_history_detail`;
CREATE TABLE `build_history_detail` (
  `build_history_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `build_history_id` int(11) NOT NULL,
  `web_page_id` int(11) NOT NULL,
  `sub_page_id` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `web_page_position` int(11) NOT NULL,
  `sub_page_position` int(11) NOT NULL,
  `web_page_number` int(11) NOT NULL,
  `estimated_epc` decimal(8,5) DEFAULT NULL,
  PRIMARY KEY (`build_history_detail_id`),
  UNIQUE KEY `IDX_WEB` (`build_history_id`,`web_page_id`,`card_id`,`web_page_position`),
  UNIQUE KEY `IDX_SUB` (`build_history_id`,`sub_page_id`,`card_id`,`sub_page_position`),
  CONSTRAINT `build_history_detail_ibfk_1` FOREIGN KEY (`build_history_id`) REFERENCES `build_history` (`build_history_id`)
) TYPE=InnoDB AUTO_INCREMENT=17399;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `build_history_detail_binsert` BEFORE INSERT ON `cms`.`build_history_detail` FOR EACH ROW BEGIN
   DECLARE var_epc_estimate DECIMAL(8,5);

   select
      (case cccomus_cebp.cpa_to_use
          when _utf8'CALCULATE' then cccomus_cpa.calculated_cpa
          when _utf8'OVERRIDE' then cccomus_cebp.cpa_override
          when _utf8'RATE_TABLE' then cccomus_crr.rate
       end) *
      (case cccomus_cebp.sale_rate_to_use
          when _utf8'CALCULATE' then cccomus_csr.calculated_sale_rate
          when _utf8'OVERRIDE' then cccomus_cebp.sale_rate_override
       end) as epc_estimate

   into var_epc_estimate

   from
     
      cccomus.card_epc_by_page cccomus_cebp

      left join cccomus.card_cpa_by_page cccomus_cpa
      on (cccomus_cpa.page_fid = cccomus_cebp.page_fid)
      and (cccomus_cpa.card_id = cccomus_cebp.card_id)

      left join cccomus.card_sale_rates_by_page cccomus_csr
      on (cccomus_csr.page_fid = cccomus_cebp.page_fid)
      and (cccomus_csr.card_id = cccomus_cebp.card_id)

      left join cccomus.card_revenue_rates cccomus_crr
      on (cccomus_crr.card_id = cccomus_cebp.card_id)
      and ((now() between
            cccomus_crr.rate_start_date and
            cccomus_crr.rate_end_date) or
           (now() >= cccomus_crr.rate_start_date and
            cccomus_crr.rate_end_date = _utf8'0000-00-00'))
      and (cccomus_crr.active = 1)
      and (cccomus_crr.rate_group_id = 1) /* Only consider CCCOM rates */

   where
      (cccomus_cebp.page_fid = NEW.web_page_id)
      and (cccomus_cebp.card_id = NEW.card_id)

      and cccomus_cebp.page_fid
            in (select page_id from cccomus.pages)
      and cccomus_cebp.card_id
            in (select cardId from ccdata.rt_cards where site_code = _latin1'USEN')

      and cccomus_cebp.card_id
            in (select card_id
                from cms.build_history_detail cms_bhd
                where
                  cms_bhd.build_history_id
                    = (select cms_bh.build_history_id
                       from cms.build_history cms_bh
                       where cms_bh.publish_time
                         = (select max(cms_bh.publish_time)
                            from cms.build_history cms_bh
                            where cms_bh.site_id = 35
                            and cms_bh.published = 1
                            limit 1)
                      limit 1)
                  and cms_bhd.web_page_id=NEW.web_page_id
                  and cms_bhd.card_id=NEW.card_id);

   if var_epc_estimate is NULL
   then
      select
         case use_override
            when 1 then epc_rate_override
            else epc_rate
         end
      into var_epc_estimate
      from cccomus.card_epc
      where bannerid = NEW.card_id
      and active = 1;
   end if;


END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `card_apr_history`
--

DROP TABLE IF EXISTS `card_apr_history`;
CREATE TABLE `card_apr_history` (
  `card_apr_history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` varchar(20) NOT NULL,
  `insert_time` datetime NOT NULL,
  `regular_apr` decimal(6,3) DEFAULT NULL,
  `card_status` enum('Active','Inactive') DEFAULT NULL,
  PRIMARY KEY (`card_apr_history_id`),
  UNIQUE KEY `idx_card_date` (`card_id`,`insert_time`)
) TYPE=InnoDB AUTO_INCREMENT=835718;

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
-- Table structure for table `card_placement_history`
--

DROP TABLE IF EXISTS `card_placement_history`;
CREATE TABLE `card_placement_history` (
  `cardpageId` int(10) NOT NULL,
  `cardId` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `active` int(11) DEFAULT NULL,
  `time_snapped` datetime NOT NULL,
  PRIMARY KEY (`cardpageId`,`cardId`,`rank`,`time_snapped`),
  KEY `idx_time_snapped` (`time_snapped`),
  KEY `idx_cardId` (`cardId`)
) TYPE=MyISAM;

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
) TYPE=MyISAM AUTO_INCREMENT=808218;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `A_card_rank_insert` AFTER INSERT ON `cms`.`card_ranks` FOR EACH ROW BEGIN
   DECLARE card_action varchar(10);
   DECLARE username varchar(20);
   SET card_action = "INSERT";
   SET username = session_user();
   INSERT INTO card_rank_changes_temp( action, card_rank_id, session_user ) VALUES ( card_action, new.card_rank_id, username );
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `B_card_rank_update` BEFORE UPDATE ON `cms`.`card_ranks` FOR EACH ROW BEGIN
   DECLARE card_action varchar(10);
   DECLARE username varchar(20);
   SET card_action = "UPDATE";
   SET username = session_user();
   INSERT INTO card_rank_changes_temp( action, card_rank_id, card_rank, card_category_context_id, card_category_id, card_id, session_user )
        VALUES ( card_action, old.card_rank_id, old.card_rank, old.card_category_context_id, old.card_category_id, old.card_id, username );
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `B_card_rank_delete` BEFORE DELETE ON `cms`.`card_ranks` FOR EACH ROW BEGIN
   DECLARE card_action varchar(10);
   DECLARE username varchar(20);
   SET card_action = "DELETE";
   SET username = session_user();
   INSERT INTO card_rank_changes_temp( action, card_rank_id, card_rank, card_category_context_id, card_category_id, card_id, session_user )
        VALUES ( card_action, old.card_rank_id, old.card_rank, old.card_category_context_id, old.card_category_id, old.card_id, username );
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
-- Temporary table structure for view `cccomus_page_reference`
--

DROP TABLE IF EXISTS `cccomus_page_reference`;
/*!50001 DROP VIEW IF EXISTS `cccomus_page_reference`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cccomus_page_reference` (
 `page_reference_id` tinyint NOT NULL,
  `page_id` tinyint NOT NULL,
  `page_id_orig` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `cccomus_pages`
--

DROP TABLE IF EXISTS `cccomus_pages`;
/*!50001 DROP VIEW IF EXISTS `cccomus_pages`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `cccomus_pages` (
 `page_id` tinyint NOT NULL,
  `page_name` tinyint NOT NULL,
  `insert_time` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `ordering` tinyint NOT NULL,
  `page_url` tinyint NOT NULL,
  `page_type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `ccx_cms_map`
--

DROP TABLE IF EXISTS `ccx_cms_map`;
/*!50001 DROP VIEW IF EXISTS `ccx_cms_map`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `ccx_cms_map` (
 `ccx_card_id` tinyint NOT NULL,
  `cms_card_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
-- Table structure for table `cs_amenities`
--

DROP TABLE IF EXISTS `cs_amenities`;
CREATE TABLE `cs_amenities` (
  `amenityid` int(11) NOT NULL AUTO_INCREMENT,
  `label` text,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`amenityid`)
) TYPE=MyISAM AUTO_INCREMENT=5;

--
-- Table structure for table `cs_banners`
--

DROP TABLE IF EXISTS `cs_banners`;
CREATE TABLE `cs_banners` (
  `bannerid` varchar(8) NOT NULL DEFAULT '',
  `description` text,
  `destinationurl` text,
  `sourceurl` text,
  `bannertype` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  `campaignid` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`bannerid`),
  UNIQUE KEY `IDX_wd_pa_banners2` (`bannerid`),
  KEY `IDX_pa_banners_1` (`campaignid`)
) TYPE=MyISAM;

--
-- Table structure for table `cs_cardamenitymap`
--

DROP TABLE IF EXISTS `cs_cardamenitymap`;
CREATE TABLE `cs_cardamenitymap` (
  `cardid` int(11) NOT NULL,
  `amenityid` int(11) NOT NULL
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
-- Table structure for table `cs_cardhistory`
--

DROP TABLE IF EXISTS `cs_cardhistory`;
CREATE TABLE `cs_cardhistory` (
  `cardid` varchar(11) NOT NULL,
  `introApr` double DEFAULT NULL,
  `introAprPeriod` int(4) DEFAULT NULL,
  `regularApr` double DEFAULT NULL,
  `monthlyFee` double DEFAULT NULL,
  `annualFee` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`cardid`)
) TYPE=MyISAM;

--
-- Table structure for table `cs_diffTable`
--

DROP TABLE IF EXISTS `cs_diffTable`;
CREATE TABLE `cs_diffTable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `content` text,
  `changed` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `ignoreLines` text,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=329;

--
-- Table structure for table `cs_history`
--

DROP TABLE IF EXISTS `cs_history`;
CREATE TABLE `cs_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateinserted` datetime DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=121942;

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
  `cardid` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`mapid`),
  KEY `IDX_sitepagecard` (`siteid`,`pageid`,`cardid`)
) TYPE=MyISAM AUTO_INCREMENT=11025;

--
-- Table structure for table `cs_pagecomponentmap`
--

DROP TABLE IF EXISTS `cs_pagecomponentmap`;
CREATE TABLE `cs_pagecomponentmap` (
  `mapid` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) DEFAULT NULL,
  `pagetype` varchar(50) DEFAULT NULL,
  `pageid` int(10) DEFAULT NULL,
  `itemid` int(10) DEFAULT '-1',
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=MyISAM AUTO_INCREMENT=11823;

--
-- Table structure for table `cs_pagecomponents`
--

DROP TABLE IF EXISTS `cs_pagecomponents`;
CREATE TABLE `cs_pagecomponents` (
  `itemid` int(10) NOT NULL AUTO_INCREMENT,
  `item` varchar(50) DEFAULT NULL,
  `render` mediumtext,
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM AUTO_INCREMENT=69;

--
-- Table structure for table `cs_rights`
--

DROP TABLE IF EXISTS `cs_rights`;
CREATE TABLE `cs_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `code` varchar(75) NOT NULL,
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=18;

--
-- Table structure for table `cs_settings`
--

DROP TABLE IF EXISTS `cs_settings`;
CREATE TABLE `cs_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `data1` varchar(255) DEFAULT NULL,
  `data2` varchar(255) DEFAULT NULL,
  `settingLabel` text,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=12;

--
-- Table structure for table `cs_sitearticlecategorymap`
--

DROP TABLE IF EXISTS `cs_sitearticlecategorymap`;
CREATE TABLE `cs_sitearticlecategorymap` (
  `mapid` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(11) DEFAULT NULL,
  `articlecategoryid` int(11) DEFAULT NULL,
  `rank` int(4) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=MyISAM AUTO_INCREMENT=815;

--
-- Table structure for table `cs_userrights`
--

DROP TABLE IF EXISTS `cs_userrights`;
CREATE TABLE `cs_userrights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `rightid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=511;

--
-- Table structure for table `cs_users`
--

DROP TABLE IF EXISTS `cs_users`;
CREATE TABLE `cs_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) DEFAULT NULL,
  `lastName` varchar(25) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `userGroup` int(3) DEFAULT '0',
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`userid`)
) TYPE=MyISAM AUTO_INCREMENT=52;

--
-- Table structure for table `export_cs_cccom`
--

DROP TABLE IF EXISTS `export_cs_cccom`;
CREATE TABLE `export_cs_cccom` (
  `campaignid` varchar(15) DEFAULT NULL,
  `introApr` varchar(156) DEFAULT NULL,
  `q_introApr` double(11,2) DEFAULT NULL,
  `introAprPeriod` varchar(100) DEFAULT NULL,
  `q_introAprPeriod` tinyint(4) DEFAULT NULL,
  `regularApr` varchar(135) DEFAULT NULL,
  `q_regularApr` double(11,2) DEFAULT NULL,
  `annualFee` varchar(142) DEFAULT NULL,
  `q_annualFee` double(53,2) DEFAULT NULL,
  `monthlyFee` varchar(345) DEFAULT NULL,
  `q_monthlyFee` varbinary(53) DEFAULT NULL,
  `balanceTransfers` varchar(100) DEFAULT NULL,
  `q_balanceTransfers` tinyint(1) DEFAULT NULL,
  `creditNeeded` varchar(100) DEFAULT NULL,
  `q_creditNeeded` tinyint(4) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `url` varchar(355) DEFAULT NULL
) TYPE=MyISAM;

--
-- Table structure for table `export_wd_pa_banners`
--

DROP TABLE IF EXISTS `export_wd_pa_banners`;
CREATE TABLE `export_wd_pa_banners` (
  `bannerid` varchar(15) DEFAULT NULL,
  `description` text,
  `destinationurl` varchar(255) DEFAULT NULL,
  `type` bigint(2) NOT NULL DEFAULT '0',
  `campaignid` varchar(15) DEFAULT NULL
) TYPE=MyISAM;

--
-- Table structure for table `export_wd_pa_campaigncategories`
--

DROP TABLE IF EXISTS `export_wd_pa_campaigncategories`;
CREATE TABLE `export_wd_pa_campaigncategories` (
  `campaignid` varchar(15) DEFAULT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `category_id` varchar(64) NOT NULL DEFAULT ''
) TYPE=MyISAM;

--
-- Table structure for table `export_wd_pa_campaigns`
--

DROP TABLE IF EXISTS `export_wd_pa_campaigns`;
CREATE TABLE `export_wd_pa_campaigns` (
  `campaignid` varchar(15) DEFAULT NULL,
  `accountid` varchar(8) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `shortDescription` text
) TYPE=MyISAM;

--
-- Table structure for table `export_wd_pa_campaigntypemap`
--

DROP TABLE IF EXISTS `export_wd_pa_campaigntypemap`;
CREATE TABLE `export_wd_pa_campaigntypemap` (
  `cardcategorymapId` int(10) NOT NULL DEFAULT '0',
  `cardId` varchar(15) DEFAULT NULL,
  `cardpageId` int(10) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL
) TYPE=MyISAM;

--
-- Table structure for table `export_wd_pa_campaigntypes`
--

DROP TABLE IF EXISTS `export_wd_pa_campaigntypes`;
CREATE TABLE `export_wd_pa_campaigntypes` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `disclaimer` text,
  `displayorder` int(10) DEFAULT NULL
) TYPE=MyISAM;

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
-- Table structure for table `hbx_data`
--

DROP TABLE IF EXISTS `hbx_data`;
CREATE TABLE `hbx_data` (
  `hbx_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` varchar(255) DEFAULT NULL,
  `item_fid` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`hbx_data_id`)
) TYPE=MyISAM AUTO_INCREMENT=207;

--
-- Table structure for table `hbx_elements`
--

DROP TABLE IF EXISTS `hbx_elements`;
CREATE TABLE `hbx_elements` (
  `hbx_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('hbx_product','hbx_category','hbx_class','hbx_group') DEFAULT NULL,
  PRIMARY KEY (`hbx_option_id`)
) TYPE=MyISAM AUTO_INCREMENT=86;

--
-- Table structure for table `merchant_data`
--

DROP TABLE IF EXISTS `merchant_data`;
CREATE TABLE `merchant_data` (
  `merchant_data_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `setup_fee` float DEFAULT NULL,
  `monthly_minimum` float DEFAULT NULL,
  `gateway_fee` float DEFAULT NULL,
  `statement_fee` float DEFAULT NULL,
  `transaction_fee` float DEFAULT NULL,
  `discount_rate` float DEFAULT NULL,
  `tech_support_fee` float DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  PRIMARY KEY (`merchant_data_id`)
) TYPE=MyISAM;

--
-- Table structure for table `merchant_details`
--

DROP TABLE IF EXISTS `merchant_details`;
CREATE TABLE `merchant_details` (
  `merchant_detail_id` int(11) NOT NULL DEFAULT '0',
  `merchant_id` int(11) DEFAULT NULL,
  `merchant_detail_version` int(11) NOT NULL DEFAULT '-1',
  `merchant_link` varchar(100) DEFAULT NULL,
  `app_link` varchar(100) DEFAULT NULL,
  `merchant_detail_label` varchar(50) DEFAULT NULL,
  `merchant_image_path` varchar(50) DEFAULT NULL,
  `merchant_image_alt_text` varchar(100) DEFAULT NULL,
  `apply_button_image` varchar(100) DEFAULT NULL,
  `apply_button_alt_text` varchar(100) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`merchant_detail_id`)
) TYPE=MyISAM;

--
-- Table structure for table `merchant_service_data`
--

DROP TABLE IF EXISTS `merchant_service_data`;
CREATE TABLE `merchant_service_data` (
  `merchant_service_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_service_id` varchar(20) DEFAULT NULL,
  `setup_fee` float DEFAULT NULL,
  `monthly_minimum` float DEFAULT NULL,
  `gateway_fee` float DEFAULT NULL,
  `statement_fee` float DEFAULT NULL,
  `transaction_fee` float DEFAULT NULL,
  `discount_rate` float DEFAULT NULL,
  `tech_support_fee` float DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `internet_discount_rate` decimal(7,4) DEFAULT NULL,
  `internet_transaction_fee` decimal(12,2) DEFAULT NULL,
  `address_verification_fee` decimal(12,2) DEFAULT NULL,
  `application_fee` decimal(12,2) DEFAULT NULL,
  `reserve` decimal(12,2) DEFAULT NULL,
  `chargeback_fee` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`merchant_service_data_id`)
) TYPE=MyISAM AUTO_INCREMENT=161;

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
-- Table structure for table `merchant_services_page_map`
--

DROP TABLE IF EXISTS `merchant_services_page_map`;
CREATE TABLE `merchant_services_page_map` (
  `merchant_service_page_map_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `merchant_service_id` varchar(20) DEFAULT NULL,
  `rank` int(5) DEFAULT NULL,
  PRIMARY KEY (`merchant_service_page_map_id`)
) TYPE=MyISAM AUTO_INCREMENT=3000;

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE `merchants` (
  `merchant_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_name` varchar(50) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` blob,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`merchant_id`)
) TYPE=MyISAM;

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
-- Table structure for table `profiles_data`
--

DROP TABLE IF EXISTS `profiles_data`;
CREATE TABLE `profiles_data` (
  `profile_id` int(11) NOT NULL COMMENT 'ID# for this profile',
  `title` varchar(255) DEFAULT NULL COMMENT 'Appears on this profile''s page heading',
  `sub_title` varchar(255) DEFAULT NULL COMMENT 'Appears under this profile''s title',
  `content_sub_title` varchar(255) DEFAULT NULL COMMENT 'Subtitle displayed on inner content pages',
  `background_color_code_light` varchar(25) DEFAULT NULL COMMENT 'Hex code for this profile''s background light color',
  `background_color_code_dark` varchar(25) DEFAULT 'NULL' COMMENT 'Hex code for this profile''s background dark color',
  `profile_description` varchar(255) DEFAULT NULL COMMENT 'Short description of this profile''s average user',
  `profile_card_types` varchar(255) DEFAULT NULL COMMENT 'List of the types of cards the user would be interested in',
  `profile_tip` varchar(255) DEFAULT '' COMMENT 'Profile tip message',
  `news_static_content` text COMMENT 'Static HTML code displayed at the bottom of the profile',
  `calculator_url` varchar(255) DEFAULT NULL COMMENT 'URL for calculator SWF file',
  `image_path` varchar(255) DEFAULT NULL COMMENT 'Path and filename to this profile''s image file',
  `media_url` varchar(255) DEFAULT NULL COMMENT 'URL for embedded swf file at top of profile page',
  `card_category_1` int(11) DEFAULT NULL COMMENT 'ID# of main card category of interest',
  `card_category_2` int(11) DEFAULT NULL COMMENT 'ID# of secondary card category of interest',
  `card_category_3` int(11) DEFAULT NULL COMMENT 'ID# of tertiary card category of interest',
  `tag_category_1` int(11) DEFAULT NULL,
  `tag_category_2` int(11) DEFAULT NULL,
  `tag_category_3` int(11) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'timestamp for last record update',
  `insert_time` timestamp NULL DEFAULT NULL COMMENT 'timestamp for record creation',
  `rank` int(11) DEFAULT NULL COMMENT 'This profile''s ranking in the index',
  PRIMARY KEY (`profile_id`)
) TYPE=MyISAM COMMENT='Contains all the data describing a profile';

--
-- Table structure for table `published_card_history`
--

DROP TABLE IF EXISTS `published_card_history`;
CREATE TABLE `published_card_history` (
  `card_id` varchar(15) NOT NULL DEFAULT '',
  `card_title` varchar(100) NOT NULL DEFAULT '',
  `date_inserted` date NOT NULL DEFAULT '0000-00-00',
  `time_inserted` time DEFAULT NULL,
  PRIMARY KEY (`card_id`,`card_title`,`date_inserted`)
) TYPE=InnoDB;

--
-- Table structure for table `redirects`
--

DROP TABLE IF EXISTS `redirects`;
CREATE TABLE `redirects` (
  `redirect_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `destination_url` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`redirect_id`)
) TYPE=InnoDB AUTO_INCREMENT=164;

--
-- Table structure for table `rt_articlepagecategorymap`
--

DROP TABLE IF EXISTS `rt_articlepagecategorymap`;
CREATE TABLE `rt_articlepagecategorymap` (
  `mapId` int(10) NOT NULL AUTO_INCREMENT,
  `cardpageId` int(10) DEFAULT NULL,
  `categoryId` int(10) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`mapId`)
) TYPE=MyISAM AUTO_INCREMENT=2063;

--
-- Table structure for table `rt_articlepagemap`
--

DROP TABLE IF EXISTS `rt_articlepagemap`;
CREATE TABLE `rt_articlepagemap` (
  `mapId` int(10) NOT NULL AUTO_INCREMENT,
  `cardpageId` int(10) DEFAULT NULL,
  `articleId` int(10) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`mapId`)
) TYPE=MyISAM AUTO_INCREMENT=11655;

--
-- Table structure for table `rt_articles`
--

DROP TABLE IF EXISTS `rt_articles`;
CREATE TABLE `rt_articles` (
  `articleId` int(11) NOT NULL AUTO_INCREMENT,
  `subCat` tinyint(1) DEFAULT '0',
  `articleTitle` varchar(100) DEFAULT NULL,
  `articleIntroText` varchar(250) DEFAULT NULL,
  `articleLink` varchar(250) DEFAULT NULL,
  `articleLinkName` varchar(20) DEFAULT NULL,
  `articleBody` text,
  `deleted` int(1) DEFAULT '0',
  `active` int(1) DEFAULT '1',
  `catTitle` varchar(100) DEFAULT NULL,
  `catDescription` text,
  `catImage` varchar(100) DEFAULT NULL,
  `catImageAltText` varchar(100) DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`articleId`)
) TYPE=MyISAM AUTO_INCREMENT=9;

--
-- Table structure for table `rt_cardcategorymap`
--

DROP TABLE IF EXISTS `rt_cardcategorymap`;
CREATE TABLE `rt_cardcategorymap` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) DEFAULT NULL,
  `cardId` varchar(11) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`)
) TYPE=MyISAM AUTO_INCREMENT=10162;

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
) TYPE=MyISAM AUTO_INCREMENT=2493;

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
-- Table structure for table `rt_cardpagemap_ccg`
--

DROP TABLE IF EXISTS `rt_cardpagemap_ccg`;
CREATE TABLE `rt_cardpagemap_ccg` (
  `cardcategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `pageInsert` int(1) DEFAULT '0',
  `cardpageId` int(10) DEFAULT NULL,
  `cardId` varchar(15) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`cardcategorymapId`),
  UNIQUE KEY `IDX_cardpage` (`cardpageId`,`cardId`)
) TYPE=MyISAM;

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
  `cardDescription` text COMMENT 'Internal name',
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
-- Table structure for table `rt_categories`
--

DROP TABLE IF EXISTS `rt_categories`;
CREATE TABLE `rt_categories` (
  `categoryId` int(10) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(100) DEFAULT NULL,
  `shortName` varchar(25) DEFAULT NULL,
  `categoryDescription` text,
  `order` int(10) DEFAULT NULL,
  `parentId` int(10) DEFAULT NULL,
  `siteId` int(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`categoryId`)
) TYPE=MyISAM AUTO_INCREMENT=36;

--
-- Table structure for table `rt_keywords`
--

DROP TABLE IF EXISTS `rt_keywords`;
CREATE TABLE `rt_keywords` (
  `entryId` int(10) NOT NULL AUTO_INCREMENT,
  `keywordId` int(10) NOT NULL DEFAULT '0',
  `keyword` varchar(255) DEFAULT NULL,
  `dateinserted` datetime DEFAULT NULL,
  `ordering` int(10) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`entryId`,`keywordId`)
) TYPE=MyISAM AUTO_INCREMENT=6542;

--
-- Table structure for table `rt_merchants`
--

DROP TABLE IF EXISTS `rt_merchants`;
CREATE TABLE `rt_merchants` (
  `merchantId` int(10) NOT NULL AUTO_INCREMENT,
  `shortName` varchar(20) DEFAULT NULL,
  `longName` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `acctId` varchar(50) DEFAULT NULL,
  `addressLine1` varchar(100) DEFAULT NULL,
  `addressLine2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `notes` text,
  `dateinserted` datetime DEFAULT NULL,
  `deleted` int(1) unsigned zerofill DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`merchantId`)
) TYPE=MyISAM AUTO_INCREMENT=2;

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
-- Table structure for table `rt_pages`
--

DROP TABLE IF EXISTS `rt_pages`;
CREATE TABLE `rt_pages` (
  `entryId` int(10) NOT NULL AUTO_INCREMENT,
  `pageId` int(10) NOT NULL DEFAULT '0',
  `pageName` varchar(255) DEFAULT NULL,
  `dateInserted` datetime DEFAULT NULL,
  `deleted` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `ordering` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`entryId`)
) TYPE=MyISAM AUTO_INCREMENT=29;

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
-- Table structure for table `rt_pagesubpagemap_ccg`
--

DROP TABLE IF EXISTS `rt_pagesubpagemap_ccg`;
CREATE TABLE `rt_pagesubpagemap_ccg` (
  `mapid` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) DEFAULT NULL,
  `masterpageid` int(10) DEFAULT NULL,
  `subpageid` int(10) DEFAULT NULL,
  `hide` int(1) DEFAULT NULL,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=MyISAM;

--
-- Table structure for table `rt_sitecategorymap`
--

DROP TABLE IF EXISTS `rt_sitecategorymap`;
CREATE TABLE `rt_sitecategorymap` (
  `sitecategorymapId` int(10) NOT NULL AUTO_INCREMENT,
  `siteId` int(10) DEFAULT NULL,
  `categoryId` int(10) DEFAULT NULL,
  `rank` int(10) DEFAULT NULL,
  PRIMARY KEY (`sitecategorymapId`)
) TYPE=MyISAM;

--
-- Table structure for table `rt_sites`
--

DROP TABLE IF EXISTS `rt_sites`;
CREATE TABLE `rt_sites` (
  `siteId` int(10) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(100) DEFAULT NULL,
  `siteTitle` varchar(100) DEFAULT NULL,
  `siteDescription` text,
  `language` varchar(255) NOT NULL DEFAULT 'EN',
  `layout` varchar(50) DEFAULT NULL,
  `pagetype` varchar(5) DEFAULT NULL,
  `applyLogo` varchar(250) DEFAULT NULL,
  `ftpSite` varchar(250) DEFAULT NULL,
  `ftpPath` varchar(250) DEFAULT NULL,
  `sourcePath` varchar(250) DEFAULT NULL,
  `corePath` varchar(255) DEFAULT NULL,
  `publishPath` varchar(250) DEFAULT NULL,
  `publishurl` varchar(250) DEFAULT NULL,
  `hostname` varchar(100) DEFAULT NULL,
  `postBuildScript` varchar(255) DEFAULT NULL,
  `publishScript` varchar(255) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT '0000-00-00 00:00:00',
  `dateLastBuilt` datetime DEFAULT NULL,
  `dblocation` varchar(255) DEFAULT NULL,
  `dbname` varchar(255) DEFAULT NULL,
  `ccbuildPublish` tinyint(1) DEFAULT '0',
  `individualcards` int(1) DEFAULT NULL,
  `individualcarddir` varchar(255) DEFAULT NULL,
  `individualmerchantservices` int(1) DEFAULT NULL,
  `individualmerchantservicesdir` varchar(255) DEFAULT NULL,
  `createSeoDoc` int(1) DEFAULT NULL,
  `sitemap` int(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  `articledb` varchar(80) DEFAULT NULL,
  `articledbhost` varchar(255) DEFAULT NULL,
  `articletableprefix` varchar(80) DEFAULT NULL,
  `articledbun` varchar(80) DEFAULT NULL,
  `articledbpw` varchar(80) DEFAULT NULL,
  `articleindexlink` varchar(255) DEFAULT NULL,
  `sitemaplink` varchar(255) DEFAULT NULL,
  `articleSiteMapFile` varchar(255) DEFAULT NULL,
  `yahooArticleFile` varchar(255) DEFAULT NULL,
  `yahooArticleCategoryFile` varchar(255) DEFAULT NULL,
  `googleArticleFile` varchar(255) DEFAULT NULL,
  `dbun` varchar(255) DEFAULT NULL,
  `dbpw` varchar(255) DEFAULT NULL,
  `landingPageDir` varchar(255) DEFAULT NULL,
  `editorialLandingPgPath` varchar(255) NOT NULL,
  `creditCardNewsPg` varchar(120) NOT NULL,
  `alternativecardpages` tinyint(4) DEFAULT NULL,
  `alternativecardpagesdir` varchar(255) DEFAULT NULL,
  `version_id` int(11) DEFAULT '-1',
  PRIMARY KEY (`siteId`)
) TYPE=MyISAM AUTO_INCREMENT=48;

--
-- Table structure for table `sc_card_page_data`
--

DROP TABLE IF EXISTS `sc_card_page_data`;
CREATE TABLE `sc_card_page_data` (
  `page_details_id` int(11) NOT NULL COMMENT 'Detail level id for pages.  Should FK to rt_pagedetails.id',
  `var_name` varchar(20) NOT NULL COMMENT 'Site Catalyst variable name, see FK for relation.',
  `var_value` varchar(100) NOT NULL COMMENT 'Site Catalyst variable value.',
  PRIMARY KEY (`page_details_id`,`var_name`),
  KEY `FK_var_name` (`var_name`),
  CONSTRAINT `sc_card_page_data_ibfk_1` FOREIGN KEY (`var_name`) REFERENCES `sc_page_vars` (`var_name`)
) TYPE=InnoDB COMMENT='Holds Site Catalyst variables for card pages.';

--
-- Table structure for table `sc_individual_card_page_data`
--

DROP TABLE IF EXISTS `sc_individual_card_page_data`;
CREATE TABLE `sc_individual_card_page_data` (
  `card_details_id` int(11) NOT NULL COMMENT 'Detail level id for individual card pages.  Should FK to rt_carddetails.id',
  `var_name` varchar(20) NOT NULL COMMENT 'Site Catalyst variable name, see FK for relation.',
  `var_value` varchar(100) NOT NULL COMMENT 'Site Catalyst variable value.',
  PRIMARY KEY (`card_details_id`,`var_name`),
  KEY `FK_var_name` (`var_name`),
  CONSTRAINT `sc_individual_card_page_data_ibfk_1` FOREIGN KEY (`var_name`) REFERENCES `sc_page_vars` (`var_name`)
) TYPE=InnoDB COMMENT='Holds Site Catalyst page variabels for individual card pages';

--
-- Table structure for table `sc_merchant_page_data`
--

DROP TABLE IF EXISTS `sc_merchant_page_data`;
CREATE TABLE `sc_merchant_page_data` (
  `merchant_service_details_id` int(11) NOT NULL COMMENT 'Detail level id for merchant service pages. Should FK to merchant_service_details.merchant_service_detail_id',
  `var_name` varchar(20) NOT NULL COMMENT 'Site Catalyst variable name.  See FK for column relation.',
  `var_value` varchar(100) NOT NULL COMMENT 'Site Catalyst variable value.',
  PRIMARY KEY (`merchant_service_details_id`,`var_name`),
  KEY `FK_var_name` (`var_name`),
  CONSTRAINT `FK_var_name` FOREIGN KEY (`var_name`) REFERENCES `sc_page_vars` (`var_name`)
) TYPE=InnoDB COMMENT='Holds Site Catalyst page variabels for merchant service pgs.';

--
-- Table structure for table `sc_page_vars`
--

DROP TABLE IF EXISTS `sc_page_vars`;
CREATE TABLE `sc_page_vars` (
  `var_name` varchar(20) NOT NULL COMMENT 'The name of each site catalyst page variable.',
  PRIMARY KEY (`var_name`)
) TYPE=InnoDB COMMENT='Holds Site Catalyst page variables.';

--
-- Table structure for table `site_card_map`
--

DROP TABLE IF EXISTS `site_card_map`;
CREATE TABLE `site_card_map` (
  `site_id` int(11) NOT NULL,
  `card_id` varchar(15) NOT NULL,
  `insert_date` date DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`site_id`,`card_id`)
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
-- Table structure for table `specials_page_map`
--

DROP TABLE IF EXISTS `specials_page_map`;
CREATE TABLE `specials_page_map` (
  `mapid` int(11) NOT NULL AUTO_INCREMENT,
  `specialspageid` varchar(50) DEFAULT NULL,
  `pageid` varchar(50) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`mapid`)
) TYPE=MyISAM AUTO_INCREMENT=52747;

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

--
-- Temporary table structure for view `vw_ccx_issuers`
--

DROP TABLE IF EXISTS `vw_ccx_issuers`;
/*!50001 DROP VIEW IF EXISTS `vw_ccx_issuers`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_ccx_issuers` (
 `issuer_id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `logo` tinyint NOT NULL,
  `site_code` tinyint NOT NULL,
  `deleted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vw_publish_history`
--

DROP TABLE IF EXISTS `vw_publish_history`;
/*!50001 DROP VIEW IF EXISTS `vw_publish_history`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_publish_history` (
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
-- Temporary table structure for view `vw_publish_history_detail`
--

DROP TABLE IF EXISTS `vw_publish_history_detail`;
/*!50001 DROP VIEW IF EXISTS `vw_publish_history_detail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_publish_history_detail` (
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
-- Table structure for table `wd_pa_banners_mal`
--

DROP TABLE IF EXISTS `wd_pa_banners_mal`;
CREATE TABLE `wd_pa_banners_mal` (
  `bannerid` varchar(50) NOT NULL DEFAULT '',
  `description` text,
  `destinationurl` text,
  `sourceurl` text,
  `bannertype` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  `campaignid` varchar(50) NOT NULL DEFAULT '',
  `dimension` varchar(25) DEFAULT NULL,
  `bannertitle` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`bannerid`),
  KEY `IDX_pa_banners_1` (`campaignid`)
) TYPE=MyISAM CONNECTION='mysql://markl:test@10.11.100.152:/csdb/wd_pa_banners_mal';

--
-- Final view structure for view `cccomus_page_reference`
--

/*!50001 DROP TABLE IF EXISTS `cccomus_page_reference`*/;
/*!50001 DROP VIEW IF EXISTS `cccomus_page_reference`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `cccomus_page_reference` AS select `cccomus`.`page_reference`.`page_reference_id` AS `page_reference_id`,`cccomus`.`page_reference`.`page_id` AS `page_id`,`cccomus`.`page_reference`.`page_id_orig` AS `page_id_orig` from `cccomus`.`page_reference` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `cccomus_pages`
--

/*!50001 DROP TABLE IF EXISTS `cccomus_pages`*/;
/*!50001 DROP VIEW IF EXISTS `cccomus_pages`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `cccomus_pages` AS select `cccomus`.`pages`.`page_id` AS `page_id`,`cccomus`.`pages`.`page_name` AS `page_name`,`cccomus`.`pages`.`insert_time` AS `insert_time`,`cccomus`.`pages`.`deleted` AS `deleted`,`cccomus`.`pages`.`ordering` AS `ordering`,`cccomus`.`pages`.`page_url` AS `page_url`,`cccomus`.`pages`.`page_type` AS `page_type` from `cccomus`.`pages` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `ccx_cms_map`
--

/*!50001 DROP TABLE IF EXISTS `ccx_cms_map`*/;
/*!50001 DROP VIEW IF EXISTS `ccx_cms_map`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ccx_cms_map` AS select `cardbank`.`ccx_cms_map`.`ccx_card_id` AS `ccx_card_id`,`cardbank`.`ccx_cms_map`.`cms_card_id` AS `cms_card_id` from `cardbank`.`ccx_cms_map` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_ccx_issuers`
--

/*!50001 DROP TABLE IF EXISTS `vw_ccx_issuers`*/;
/*!50001 DROP VIEW IF EXISTS `vw_ccx_issuers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_ccx_issuers` AS select `cardbank`.`issuers`.`issuer_id` AS `issuer_id`,`cardbank`.`issuers`.`name` AS `name`,`cardbank`.`issuers`.`logo` AS `logo`,`cardbank`.`issuers`.`site_code` AS `site_code`,`cardbank`.`issuers`.`deleted` AS `deleted` from `cardbank`.`issuers` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_publish_history`
--

/*!50001 DROP TABLE IF EXISTS `vw_publish_history`*/;
/*!50001 DROP VIEW IF EXISTS `vw_publish_history`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_publish_history` AS select `build_history`.`build_history_id` AS `build_history_id`,`build_history`.`site_id` AS `site_id`,`build_history`.`build_time` AS `build_time`,`build_history`.`user_id` AS `user_id`,`build_history`.`published` AS `published`,`build_history`.`publish_time` AS `publish_time`,`build_history`.`note` AS `note` from `build_history` where (`build_history`.`published` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_publish_history_detail`
--

/*!50001 DROP TABLE IF EXISTS `vw_publish_history_detail`*/;
/*!50001 DROP VIEW IF EXISTS `vw_publish_history_detail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dba`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_publish_history_detail` AS select `build_history_detail`.`build_history_detail_id` AS `build_history_detail_id`,`build_history_detail`.`build_history_id` AS `build_history_id`,`build_history_detail`.`web_page_id` AS `web_page_id`,`build_history_detail`.`sub_page_id` AS `sub_page_id`,`build_history_detail`.`card_id` AS `card_id`,`build_history_detail`.`web_page_position` AS `web_page_position`,`build_history_detail`.`sub_page_position` AS `sub_page_position`,`build_history_detail`.`web_page_number` AS `web_page_number`,`build_history_detail`.`estimated_epc` AS `estimated_epc` from (`build_history_detail` join `build_history` on((`build_history_detail`.`build_history_id` = `build_history`.`build_history_id`))) where (`build_history`.`published` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-10 16:37:46
