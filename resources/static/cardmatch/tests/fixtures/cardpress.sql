-- MySQL dump 10.13  Distrib 5.1.69, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cardpress
-- ------------------------------------------------------
-- Server version	5.1.69-0ubuntu0.11.10.1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,MYSQL40' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cp_active_users`
--

DROP TABLE IF EXISTS `cp_active_users`;
CREATE TABLE `cp_active_users` (
  `internalKey` int(9) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `lasthit` int(20) NOT NULL DEFAULT '0',
  `id` int(10) DEFAULT NULL,
  `action` varchar(10) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`internalKey`)
) TYPE=MyISAM COMMENT='Contains data about active users.';

--
-- Table structure for table `cp_answers`
--

DROP TABLE IF EXISTS `cp_answers`;
CREATE TABLE `cp_answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `score_value` int(11) DEFAULT NULL,
  `answer_text` text,
  `explain_text` text,
  `sort_order` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `question_id` (`question_id`)
) TYPE=InnoDB AUTO_INCREMENT=431;

--
-- Table structure for table `cp_authors`
--

DROP TABLE IF EXISTS `cp_authors`;
CREATE TABLE `cp_authors` (
  `author_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL DEFAULT '',
  `last_name` varchar(64) NOT NULL DEFAULT '',
  `address` text,
  `business_name` varchar(128) NOT NULL DEFAULT '',
  `author_page_link` varchar(255) DEFAULT NULL,
  `external_profile_link` varchar(255) DEFAULT NULL,
  `author_photo_location` varchar(255) DEFAULT NULL,
  `author_page_site_content_id` int(10) DEFAULT NULL,
  `local_author_page_filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`author_id`)
) TYPE=MyISAM AUTO_INCREMENT=124;

--
-- Table structure for table `cp_categories`
--

DROP TABLE IF EXISTS `cp_categories`;
CREATE TABLE `cp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=15 COMMENT='Categories to be used snippets,tv,chunks, etc';

--
-- Table structure for table `cp_document_groups`
--

DROP TABLE IF EXISTS `cp_document_groups`;
CREATE TABLE `cp_document_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `document_group` int(10) NOT NULL DEFAULT '0',
  `document` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `document` (`document`),
  KEY `document_group` (`document_group`)
) TYPE=MyISAM AUTO_INCREMENT=491560 COMMENT='Contains data used for access permissions.';

--
-- Table structure for table `cp_documentgroup_names`
--

DROP TABLE IF EXISTS `cp_documentgroup_names`;
CREATE TABLE `cp_documentgroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `private_memgroup` tinyint(4) DEFAULT '0' COMMENT 'determine whether the document group is private to manager users',
  `private_webgroup` tinyint(4) DEFAULT '0' COMMENT 'determines whether the document is private to web users',
  `fid` int(11) NOT NULL DEFAULT '-1',
  `index_page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=49 COMMENT='Contains data used for access permissions.';

--
-- Table structure for table `cp_editorial_landing_page`
--

DROP TABLE IF EXISTS `cp_editorial_landing_page`;
CREATE TABLE `cp_editorial_landing_page` (
  `name` varchar(255) NOT NULL,
  `content_id` int(11) NOT NULL,
  `content` blob,
  `extra` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_editorial_snippets`
--

DROP TABLE IF EXISTS `cp_editorial_snippets`;
CREATE TABLE `cp_editorial_snippets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=70;

--
-- Table structure for table `cp_evaluations`
--

DROP TABLE IF EXISTS `cp_evaluations`;
CREATE TABLE `cp_evaluations` (
  `evaluation_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `score_high_bound` int(11) DEFAULT NULL,
  `score_low_bound` int(11) DEFAULT NULL,
  `eval_explain_text` text,
  `update_time` timestamp NOT NULL,
  PRIMARY KEY (`evaluation_id`),
  KEY `quiz_id` (`quiz_id`)
) TYPE=InnoDB AUTO_INCREMENT=51;

--
-- Table structure for table `cp_event_log`
--

DROP TABLE IF EXISTS `cp_event_log`;
CREATE TABLE `cp_event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) DEFAULT '0',
  `createdon` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1- information, 2 - warning, 3- error',
  `user` int(11) NOT NULL DEFAULT '0' COMMENT 'link to user table',
  `usertype` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - manager, 1 - web',
  `source` varchar(50) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) TYPE=MyISAM AUTO_INCREMENT=286 COMMENT='Stores event and error logs';

--
-- Table structure for table `cp_glossary`
--

DROP TABLE IF EXISTS `cp_glossary`;
CREATE TABLE `cp_glossary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` text NOT NULL,
  `definition` text NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT '0',
  `createdon` int(11) NOT NULL DEFAULT '0',
  `editedon` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=448;

--
-- Table structure for table `cp_homepage_module`
--

DROP TABLE IF EXISTS `cp_homepage_module`;
CREATE TABLE `cp_homepage_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `related` text NOT NULL,
  `story` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=8;

--
-- Table structure for table `cp_jot_content`
--

DROP TABLE IF EXISTS `cp_jot_content`;
CREATE TABLE `cp_jot_content` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `tagid` varchar(50) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `uparent` int(10) NOT NULL DEFAULT '0',
  `parent` int(10) NOT NULL DEFAULT '0',
  `flags` varchar(25) DEFAULT NULL,
  `secip` varchar(32) DEFAULT NULL,
  `sechash` varchar(32) DEFAULT NULL,
  `content` mediumtext,
  `customfields` mediumtext,
  `mode` int(1) NOT NULL DEFAULT '1',
  `createdby` int(10) NOT NULL DEFAULT '0',
  `createdon` int(20) NOT NULL DEFAULT '0',
  `editedby` int(10) NOT NULL DEFAULT '0',
  `editedon` int(20) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deletedon` int(20) NOT NULL DEFAULT '0',
  `deletedby` int(10) NOT NULL DEFAULT '0',
  `publishedon` int(20) NOT NULL DEFAULT '0',
  `publishedby` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `secip` (`secip`),
  KEY `tagidx` (`tagid`),
  KEY `uparent` (`uparent`)
) TYPE=MyISAM AUTO_INCREMENT=16;

--
-- Table structure for table `cp_jot_fields`
--

DROP TABLE IF EXISTS `cp_jot_fields`;
CREATE TABLE `cp_jot_fields` (
  `id` mediumint(10) NOT NULL,
  `label` varchar(50) NOT NULL,
  `content` text,
  KEY `id` (`id`),
  KEY `label` (`label`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_jot_subscriptions`
--

DROP TABLE IF EXISTS `cp_jot_subscriptions`;
CREATE TABLE `cp_jot_subscriptions` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `uparent` mediumint(10) NOT NULL DEFAULT '0',
  `tagid` varchar(50) NOT NULL DEFAULT '',
  `userid` mediumint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uparent` (`uparent`),
  KEY `tagid` (`tagid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_keyword_xref`
--

DROP TABLE IF EXISTS `cp_keyword_xref`;
CREATE TABLE `cp_keyword_xref` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `keyword_id` int(11) NOT NULL DEFAULT '0',
  KEY `content_id` (`content_id`),
  KEY `keyword_id` (`keyword_id`)
) TYPE=MyISAM COMMENT='Cross reference bewteen keywords and content';

--
-- Table structure for table `cp_locked_stories`
--

DROP TABLE IF EXISTS `cp_locked_stories`;
CREATE TABLE `cp_locked_stories` (
  `locked_story_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT 'The user locking a story.',
  `site_content_id` int(11) NOT NULL COMMENT 'The story id of the story being locked; FK to cp_site_content.id.',
  `locked_time` timestamp NOT NULL COMMENT 'The timestamp of the creation of the lock.',
  PRIMARY KEY (`locked_story_id`),
  KEY `idx_site_content_id` (`site_content_id`)
) TYPE=InnoDB AUTO_INCREMENT=492;

--
-- Table structure for table `cp_manager_log`
--

DROP TABLE IF EXISTS `cp_manager_log`;
CREATE TABLE `cp_manager_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `timestamp` int(20) NOT NULL DEFAULT '0',
  `internalKey` int(10) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `action` int(10) NOT NULL DEFAULT '0',
  `itemid` varchar(10) DEFAULT '0',
  `itemname` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=411568 COMMENT='Contains a record of user interaction.';

--
-- Table structure for table `cp_manager_users`
--

DROP TABLE IF EXISTS `cp_manager_users`;
CREATE TABLE `cp_manager_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM AUTO_INCREMENT=44 COMMENT='Contains login information for backend users.';

--
-- Table structure for table `cp_marquee`
--

DROP TABLE IF EXISTS `cp_marquee`;
CREATE TABLE `cp_marquee` (
  `cp_marquee_id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) NOT NULL,
  PRIMARY KEY (`cp_marquee_id`),
  KEY `idx_story_id` (`story_id`)
) TYPE=InnoDB AUTO_INCREMENT=49;

--
-- Table structure for table `cp_member_groups`
--

DROP TABLE IF EXISTS `cp_member_groups`;
CREATE TABLE `cp_member_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_group` int(10) NOT NULL DEFAULT '0',
  `member` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=241 COMMENT='Contains data used for access permissions.';

--
-- Table structure for table `cp_membergroup_access`
--

DROP TABLE IF EXISTS `cp_membergroup_access`;
CREATE TABLE `cp_membergroup_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `membergroup` int(10) NOT NULL DEFAULT '0',
  `documentgroup` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=59 COMMENT='Contains data used for access permissions.';

--
-- Table structure for table `cp_membergroup_names`
--

DROP TABLE IF EXISTS `cp_membergroup_names`;
CREATE TABLE `cp_membergroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `aff_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=8 COMMENT='Contains data used for access permissions.';

--
-- Table structure for table `cp_poll_choices`
--

DROP TABLE IF EXISTS `cp_poll_choices`;
CREATE TABLE `cp_poll_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL DEFAULT '0',
  `choice` varchar(255) DEFAULT NULL,
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`)
) TYPE=MyISAM AUTO_INCREMENT=647;

--
-- Table structure for table `cp_poller_vote`
--

DROP TABLE IF EXISTS `cp_poller_vote`;
CREATE TABLE `cp_poller_vote` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `optionID` int(11) DEFAULT NULL,
  `ipAddress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_pollip`
--

DROP TABLE IF EXISTS `cp_pollip`;
CREATE TABLE `cp_pollip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) DEFAULT NULL,
  `ipaddress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_polls`
--

DROP TABLE IF EXISTS `cp_polls`;
CREATE TABLE `cp_polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=155;

--
-- Table structure for table `cp_questions`
--

DROP TABLE IF EXISTS `cp_questions`;
CREATE TABLE `cp_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `can_select_multi` tinyint(1) DEFAULT '0',
  `question_text` text,
  `sort_order` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `quiz_id` (`quiz_id`)
) TYPE=InnoDB AUTO_INCREMENT=130;

--
-- Table structure for table `cp_quizzes`
--

DROP TABLE IF EXISTS `cp_quizzes`;
CREATE TABLE `cp_quizzes` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `intro_text` text,
  `pre_result_text` text,
  `goodbye_text` text,
  `default_submit_text` text,
  `question_plume` varchar(255) DEFAULT 'Q',
  `fid` int(11) DEFAULT '0',
  `keywords` text,
  `description` text,
  `actual_page_title` varchar(255) DEFAULT 'Credit Card Quiz',
  `update_time` timestamp NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`quiz_id`)
) TYPE=InnoDB AUTO_INCREMENT=15;

--
-- Table structure for table `cp_redirect`
--

DROP TABLE IF EXISTS `cp_redirect`;
CREATE TABLE `cp_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `editable` int(1) NOT NULL,
  `update_time` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`,`filepath`)
) TYPE=MyISAM AUTO_INCREMENT=4897;

--
-- Table structure for table `cp_review`
--

DROP TABLE IF EXISTS `cp_review`;
CREATE TABLE `cp_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `review_date` int(11) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`content_id`)
) TYPE=MyISAM AUTO_INCREMENT=6;

--
-- Table structure for table `cp_site_content`
--

DROP TABLE IF EXISTS `cp_site_content`;
CREATE TABLE `cp_site_content` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'document',
  `contentType` varchar(50) NOT NULL DEFAULT 'text/html',
  `author` varchar(255) NOT NULL,
  `pagetitle` varchar(255) NOT NULL DEFAULT '',
  `longtitle` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) DEFAULT '',
  `link_attributes` varchar(255) NOT NULL DEFAULT '',
  `published` int(1) NOT NULL DEFAULT '0',
  `publish_to_affiliates` tinyint(4) NOT NULL DEFAULT '1',
  `publish_to_cccom` tinyint(4) NOT NULL DEFAULT '1',
  `original_source` tinyint(4) NOT NULL DEFAULT '1',
  `pub_date` int(20) NOT NULL DEFAULT '0',
  `unpub_date` int(20) NOT NULL DEFAULT '0',
  `repub_date` int(20) NOT NULL DEFAULT '0',
  `parent` int(10) NOT NULL DEFAULT '0',
  `isfolder` int(1) NOT NULL DEFAULT '0',
  `introtext` text COMMENT 'Used to provide quick summary of the document',
  `content` mediumtext,
  `richtext` tinyint(1) NOT NULL DEFAULT '1',
  `template` int(10) NOT NULL DEFAULT '1',
  `menuindex` int(10) NOT NULL DEFAULT '0',
  `searchable` int(1) NOT NULL DEFAULT '1',
  `cacheable` int(1) NOT NULL DEFAULT '0',
  `createdby` int(10) NOT NULL DEFAULT '0',
  `createdon` int(20) NOT NULL DEFAULT '0',
  `editedby` int(10) NOT NULL DEFAULT '0',
  `editedon` int(20) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deletedon` int(20) NOT NULL DEFAULT '0',
  `deletedby` int(10) NOT NULL DEFAULT '0',
  `publishedon` int(20) NOT NULL DEFAULT '0',
  `publishedby` int(10) NOT NULL DEFAULT '0',
  `menutitle` varchar(255) NOT NULL DEFAULT '' COMMENT 'Menu title',
  `donthit` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Disable page hit count',
  `haskeywords` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'has links to keywords',
  `hasmetatags` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'has links to meta tags',
  `privateweb` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Private web document',
  `privatemgr` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Private manager document',
  `content_dispo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-inline, 1-attachment',
  `hidemenu` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Hide document from menu',
  `pageid` int(20) DEFAULT NULL,
  `story_keywords` varchar(255) NOT NULL,
  `homepage_headline` varchar(255) NOT NULL,
  `homepage_summary` varchar(255) NOT NULL,
  `homepage_thumb` varchar(255) NOT NULL,
  `homepage_alt` varchar(255) NOT NULL,
  `homepage_linktext` varchar(255) NOT NULL,
  `homepage_image_external` tinyint(1) NOT NULL DEFAULT '1',
  `pubgroup` varchar(255) NOT NULL,
  `maincategory` int(11) NOT NULL DEFAULT '0',
  `archived` int(1) NOT NULL,
  `temp_wp_post_id` bigint(20) DEFAULT NULL,
  `notes` mediumtext,
  `actual_page_title` varchar(255) NOT NULL DEFAULT '',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `invoiced` tinyint(1) NOT NULL DEFAULT '0',
  `invoiced_amount` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `parent` (`parent`),
  KEY `aliasidx` (`alias`),
  FULLTEXT KEY `content_ft_idx` (`pagetitle`,`description`,`content`)
) TYPE=MyISAM AUTO_INCREMENT=5481 COMMENT='Contains the site document tree.';

--
-- Table structure for table `cp_site_content_metatags`
--

DROP TABLE IF EXISTS `cp_site_content_metatags`;
CREATE TABLE `cp_site_content_metatags` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `metatag_id` int(11) NOT NULL DEFAULT '0',
  KEY `content_id` (`content_id`),
  KEY `metatag_id` (`metatag_id`)
) TYPE=MyISAM COMMENT='Reference table between meta tags and content';

--
-- Table structure for table `cp_site_htmlsnippets`
--

DROP TABLE IF EXISTS `cp_site_htmlsnippets`;
CREATE TABLE `cp_site_htmlsnippets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Chunk',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cache option',
  `snippet` mediumtext,
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=223 COMMENT='Contains the site chunks.';

--
-- Table structure for table `cp_site_keywords`
--

DROP TABLE IF EXISTS `cp_site_keywords`;
CREATE TABLE `cp_site_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) TYPE=MyISAM AUTO_INCREMENT=5 COMMENT='Site keyword list';

--
-- Table structure for table `cp_site_metatags`
--

DROP TABLE IF EXISTS `cp_site_metatags`;
CREATE TABLE `cp_site_metatags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `tag` varchar(50) NOT NULL DEFAULT '' COMMENT 'tag name',
  `tagvalue` varchar(255) NOT NULL DEFAULT '',
  `http_equiv` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 - use http_equiv tag style, 0 - use name',
  PRIMARY KEY (`id`)
) TYPE=MyISAM COMMENT='Site meta tags';

--
-- Table structure for table `cp_site_module_access`
--

DROP TABLE IF EXISTS `cp_site_module_access`;
CREATE TABLE `cp_site_module_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL DEFAULT '0',
  `usergroup` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM COMMENT='Module users group access permission';

--
-- Table structure for table `cp_site_module_depobj`
--

DROP TABLE IF EXISTS `cp_site_module_depobj`;
CREATE TABLE `cp_site_module_depobj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL DEFAULT '0',
  `resource` int(11) NOT NULL DEFAULT '0',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '10-chunks, 20-docs, 30-plugins, 40-snips, 50-tpls, 60-tvs',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 COMMENT='Module Dependencies';

--
-- Table structure for table `cp_site_modules`
--

DROP TABLE IF EXISTS `cp_site_modules`;
CREATE TABLE `cp_site_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '0',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `disabled` tinyint(4) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `wrap` tinyint(4) NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT 'url to module icon',
  `enable_resource` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'enables the resource file feature',
  `resourcefile` varchar(255) NOT NULL DEFAULT '' COMMENT 'a physical link to a resource file',
  `createdon` int(11) NOT NULL DEFAULT '0',
  `editedon` int(11) NOT NULL DEFAULT '0',
  `guid` varchar(32) NOT NULL DEFAULT '' COMMENT 'globally unique identifier',
  `enable_sharedparams` tinyint(4) NOT NULL DEFAULT '0',
  `properties` text,
  `modulecode` mediumtext COMMENT 'module boot up code',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 COMMENT='Site Modules';

--
-- Table structure for table `cp_site_plugin_events`
--

DROP TABLE IF EXISTS `cp_site_plugin_events`;
CREATE TABLE `cp_site_plugin_events` (
  `pluginid` int(10) NOT NULL,
  `evtid` int(10) NOT NULL DEFAULT '0',
  `priority` int(10) NOT NULL DEFAULT '0' COMMENT 'determines plugin run order'
) TYPE=MyISAM COMMENT='Links to system events';

--
-- Table structure for table `cp_site_plugins`
--

DROP TABLE IF EXISTS `cp_site_plugins`;
CREATE TABLE `cp_site_plugins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Plugin',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cache option',
  `plugincode` mediumtext,
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `properties` text,
  `disabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Disables the plugin',
  `moduleguid` varchar(32) NOT NULL DEFAULT '' COMMENT 'GUID of module from which to import shared parameters',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 COMMENT='Contains the site plugins.';

--
-- Table structure for table `cp_site_snippets`
--

DROP TABLE IF EXISTS `cp_site_snippets`;
CREATE TABLE `cp_site_snippets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Snippet',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cache option',
  `snippet` mediumtext,
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `properties` text,
  `moduleguid` varchar(32) NOT NULL DEFAULT '' COMMENT 'GUID of module from which to import shared parameters',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=42 COMMENT='Contains the site snippets.';

--
-- Table structure for table `cp_site_templates`
--

DROP TABLE IF EXISTS `cp_site_templates`;
CREATE TABLE `cp_site_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `templatename` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Template',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT 'url to icon file',
  `template_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-page,1-content',
  `content` mediumtext,
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=21 COMMENT='Contains the site templates.';

--
-- Table structure for table `cp_site_tmplvar_access`
--

DROP TABLE IF EXISTS `cp_site_tmplvar_access`;
CREATE TABLE `cp_site_tmplvar_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tmplvarid` int(10) NOT NULL DEFAULT '0',
  `documentgroup` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM COMMENT='Contains data used for template variable access permissions.';

--
-- Table structure for table `cp_site_tmplvar_contentvalues`
--

DROP TABLE IF EXISTS `cp_site_tmplvar_contentvalues`;
CREATE TABLE `cp_site_tmplvar_contentvalues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tmplvarid` int(10) NOT NULL DEFAULT '0' COMMENT 'Template Variable id',
  `contentid` int(10) NOT NULL DEFAULT '0' COMMENT 'Site Content Id',
  `value` text,
  PRIMARY KEY (`id`),
  KEY `idx_tmplvarid` (`tmplvarid`),
  KEY `idx_id` (`contentid`)
) TYPE=MyISAM COMMENT='Site Template Variables Content Values Link Table';

--
-- Table structure for table `cp_site_tmplvar_templates`
--

DROP TABLE IF EXISTS `cp_site_tmplvar_templates`;
CREATE TABLE `cp_site_tmplvar_templates` (
  `tmplvarid` int(10) NOT NULL DEFAULT '0' COMMENT 'Template Variable id',
  `templateid` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tmplvarid`,`templateid`)
) TYPE=MyISAM COMMENT='Site Template Variables Templates Link Table';

--
-- Table structure for table `cp_site_tmplvars`
--

DROP TABLE IF EXISTS `cp_site_tmplvars`;
CREATE TABLE `cp_site_tmplvars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `caption` varchar(80) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `editor_type` int(11) NOT NULL DEFAULT '0' COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `elements` text,
  `rank` int(11) NOT NULL DEFAULT '0',
  `display` varchar(20) NOT NULL DEFAULT '' COMMENT 'Display Control',
  `display_params` text COMMENT 'Display Control Properties',
  `default_text` text,
  PRIMARY KEY (`id`),
  KEY `indx_rank` (`rank`)
) TYPE=MyISAM AUTO_INCREMENT=15 COMMENT='Site Template Variables';

--
-- Table structure for table `cp_spelling_whitelist`
--

DROP TABLE IF EXISTS `cp_spelling_whitelist`;
CREATE TABLE `cp_spelling_whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`)
) TYPE=MyISAM AUTO_INCREMENT=20;

--
-- Table structure for table `cp_story_authors`
--

DROP TABLE IF EXISTS `cp_story_authors`;
CREATE TABLE `cp_story_authors` (
  `story_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`story_id`,`author_id`)
) TYPE=MyISAM;

--
-- Table structure for table `cp_system_eventnames`
--

DROP TABLE IF EXISTS `cp_system_eventnames`;
CREATE TABLE `cp_system_eventnames` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `service` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'System Service number',
  `groupname` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1001 COMMENT='System Event Names.';

--
-- Table structure for table `cp_system_settings`
--

DROP TABLE IF EXISTS `cp_system_settings`;
CREATE TABLE `cp_system_settings` (
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text,
  UNIQUE KEY `setting_name` (`setting_name`)
) TYPE=MyISAM COMMENT='Contains Content Manager settings.';

--
-- Table structure for table `cp_term_groups`
--

DROP TABLE IF EXISTS `cp_term_groups`;
CREATE TABLE `cp_term_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `term_group` int(10) NOT NULL DEFAULT '0',
  `term` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `term` (`term`),
  KEY `term_group` (`term_group`)
) TYPE=MyISAM AUTO_INCREMENT=712;

--
-- Table structure for table `cp_user_attributes`
--

DROP TABLE IF EXISTS `cp_user_attributes`;
CREATE TABLE `cp_user_attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `internalKey` int(10) NOT NULL DEFAULT '0',
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `role` int(10) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `mobilephone` varchar(100) NOT NULL DEFAULT '',
  `blocked` int(1) NOT NULL DEFAULT '0',
  `blockeduntil` int(11) NOT NULL DEFAULT '0',
  `blockedafter` int(11) NOT NULL DEFAULT '0',
  `logincount` int(11) NOT NULL DEFAULT '0',
  `lastlogin` int(11) NOT NULL DEFAULT '0',
  `thislogin` int(11) NOT NULL DEFAULT '0',
  `failedlogincount` int(10) NOT NULL DEFAULT '0',
  `sessionid` varchar(100) NOT NULL DEFAULT '',
  `dob` int(10) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '0' COMMENT '0 - unknown, 1 - Male 2 - female',
  `country` varchar(5) NOT NULL DEFAULT '',
  `state` varchar(25) NOT NULL DEFAULT '',
  `zip` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT 'link to photo',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT 'short comment',
  PRIMARY KEY (`id`),
  KEY `userid` (`internalKey`)
) TYPE=MyISAM AUTO_INCREMENT=38 COMMENT='Contains information about the backend users.';

--
-- Table structure for table `cp_user_messages`
--

DROP TABLE IF EXISTS `cp_user_messages`;
CREATE TABLE `cp_user_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL DEFAULT '',
  `subject` varchar(60) NOT NULL DEFAULT '',
  `message` text,
  `sender` int(10) NOT NULL DEFAULT '0',
  `recipient` int(10) NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `postdate` int(20) NOT NULL DEFAULT '0',
  `messageread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM COMMENT='Contains messages for the Content Manager messaging system.';

--
-- Table structure for table `cp_user_roles`
--

DROP TABLE IF EXISTS `cp_user_roles`;
CREATE TABLE `cp_user_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `frames` int(1) NOT NULL DEFAULT '0',
  `home` int(1) NOT NULL DEFAULT '0',
  `view_document` int(1) NOT NULL DEFAULT '0',
  `new_document` int(1) NOT NULL DEFAULT '0',
  `save_document` int(1) NOT NULL DEFAULT '0',
  `publish_document` int(1) NOT NULL DEFAULT '0',
  `delete_document` int(1) NOT NULL DEFAULT '0',
  `action_ok` int(1) NOT NULL DEFAULT '0',
  `logout` int(1) NOT NULL DEFAULT '0',
  `help` int(1) NOT NULL DEFAULT '0',
  `messages` int(1) NOT NULL DEFAULT '0',
  `new_user` int(1) NOT NULL DEFAULT '0',
  `edit_user` int(1) NOT NULL DEFAULT '0',
  `logs` int(1) NOT NULL DEFAULT '0',
  `edit_parser` int(1) NOT NULL DEFAULT '0',
  `save_parser` int(1) NOT NULL DEFAULT '0',
  `edit_template` int(1) NOT NULL DEFAULT '0',
  `settings` int(1) NOT NULL DEFAULT '0',
  `credits` int(1) NOT NULL DEFAULT '0',
  `new_template` int(1) NOT NULL DEFAULT '0',
  `save_template` int(1) NOT NULL DEFAULT '0',
  `delete_template` int(1) NOT NULL DEFAULT '0',
  `edit_snippet` int(1) NOT NULL DEFAULT '0',
  `new_snippet` int(1) NOT NULL DEFAULT '0',
  `save_snippet` int(1) NOT NULL DEFAULT '0',
  `delete_snippet` int(1) NOT NULL DEFAULT '0',
  `edit_chunk` int(1) NOT NULL DEFAULT '0',
  `new_chunk` int(1) NOT NULL DEFAULT '0',
  `save_chunk` int(1) NOT NULL DEFAULT '0',
  `delete_chunk` int(1) NOT NULL DEFAULT '0',
  `empty_cache` int(1) NOT NULL DEFAULT '0',
  `edit_document` int(1) NOT NULL DEFAULT '0',
  `change_password` int(1) NOT NULL DEFAULT '0',
  `error_dialog` int(1) NOT NULL DEFAULT '0',
  `about` int(1) NOT NULL DEFAULT '0',
  `file_manager` int(1) NOT NULL DEFAULT '0',
  `save_user` int(1) NOT NULL DEFAULT '0',
  `delete_user` int(1) NOT NULL DEFAULT '0',
  `save_password` int(11) NOT NULL DEFAULT '0',
  `edit_role` int(1) NOT NULL DEFAULT '0',
  `save_role` int(1) NOT NULL DEFAULT '0',
  `delete_role` int(1) NOT NULL DEFAULT '0',
  `new_role` int(1) NOT NULL DEFAULT '0',
  `access_permissions` int(1) NOT NULL DEFAULT '0',
  `bk_manager` int(1) NOT NULL DEFAULT '0',
  `new_plugin` int(1) NOT NULL DEFAULT '0',
  `edit_plugin` int(1) NOT NULL DEFAULT '0',
  `save_plugin` int(1) NOT NULL DEFAULT '0',
  `delete_plugin` int(1) NOT NULL DEFAULT '0',
  `new_module` int(1) NOT NULL DEFAULT '0',
  `edit_module` int(1) NOT NULL DEFAULT '0',
  `save_module` int(1) NOT NULL DEFAULT '0',
  `delete_module` int(1) NOT NULL DEFAULT '0',
  `exec_module` int(1) NOT NULL DEFAULT '0',
  `view_eventlog` int(1) NOT NULL DEFAULT '0',
  `delete_eventlog` int(1) NOT NULL DEFAULT '0',
  `manage_metatags` int(1) NOT NULL DEFAULT '0' COMMENT 'manage site meta tags and keywords',
  `edit_doc_metatags` int(1) NOT NULL DEFAULT '0' COMMENT 'edit document meta tags and keywords',
  `new_web_user` int(1) NOT NULL DEFAULT '0',
  `edit_web_user` int(1) NOT NULL DEFAULT '0',
  `save_web_user` int(1) NOT NULL DEFAULT '0',
  `delete_web_user` int(1) NOT NULL DEFAULT '0',
  `web_access_permissions` int(1) NOT NULL DEFAULT '0',
  `view_unpublished` int(1) NOT NULL DEFAULT '0',
  `import_static` int(1) NOT NULL DEFAULT '0',
  `export_static` int(1) NOT NULL DEFAULT '0',
  `review_document` int(1) NOT NULL DEFAULT '0',
  `find_replace` int(1) NOT NULL,
  `edit_dictionary` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6 COMMENT='Contains information describing the user roles.';

--
-- Table structure for table `cp_user_settings`
--

DROP TABLE IF EXISTS `cp_user_settings`;
CREATE TABLE `cp_user_settings` (
  `user` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text,
  KEY `setting_name` (`setting_name`),
  KEY `user` (`user`)
) TYPE=MyISAM COMMENT='Contains backend user settings.';

--
-- Table structure for table `cp_web_groups`
--

DROP TABLE IF EXISTS `cp_web_groups`;
CREATE TABLE `cp_web_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `webgroup` int(10) NOT NULL DEFAULT '0',
  `webuser` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 COMMENT='Contains data used for web access permissions.';

--
-- Table structure for table `cp_web_user_attributes`
--

DROP TABLE IF EXISTS `cp_web_user_attributes`;
CREATE TABLE `cp_web_user_attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `internalKey` int(10) NOT NULL DEFAULT '0',
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `role` int(10) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `mobilephone` varchar(100) NOT NULL DEFAULT '',
  `blocked` int(1) NOT NULL DEFAULT '0',
  `blockeduntil` int(11) NOT NULL DEFAULT '0',
  `blockedafter` int(11) NOT NULL DEFAULT '0',
  `logincount` int(11) NOT NULL DEFAULT '0',
  `lastlogin` int(11) NOT NULL DEFAULT '0',
  `thislogin` int(11) NOT NULL DEFAULT '0',
  `failedlogincount` int(10) NOT NULL DEFAULT '0',
  `sessionid` varchar(100) NOT NULL DEFAULT '',
  `dob` int(10) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '0' COMMENT '0 - unknown, 1 - Male 2 - female',
  `country` varchar(5) NOT NULL DEFAULT '',
  `state` varchar(25) NOT NULL DEFAULT '',
  `zip` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT 'link to photo',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT 'short comment',
  PRIMARY KEY (`id`),
  KEY `userid` (`internalKey`)
) TYPE=MyISAM AUTO_INCREMENT=2 COMMENT='Contains information for web users.';

--
-- Table structure for table `cp_web_user_settings`
--

DROP TABLE IF EXISTS `cp_web_user_settings`;
CREATE TABLE `cp_web_user_settings` (
  `webuser` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text,
  KEY `setting_name` (`setting_name`),
  KEY `webuserid` (`webuser`)
) TYPE=MyISAM COMMENT='Contains web user settings.';

--
-- Table structure for table `cp_web_users`
--

DROP TABLE IF EXISTS `cp_web_users`;
CREATE TABLE `cp_web_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `cachepwd` varchar(100) NOT NULL DEFAULT '' COMMENT 'Store new unconfirmed password',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM AUTO_INCREMENT=2;

--
-- Table structure for table `cp_webgroup_access`
--

DROP TABLE IF EXISTS `cp_webgroup_access`;
CREATE TABLE `cp_webgroup_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `webgroup` int(10) NOT NULL DEFAULT '0',
  `documentgroup` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 COMMENT='Contains data used for web access permissions.';

--
-- Table structure for table `cp_webgroup_names`
--

DROP TABLE IF EXISTS `cp_webgroup_names`;
CREATE TABLE `cp_webgroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM AUTO_INCREMENT=3 COMMENT='Contains data used for web access permissions.';

--
-- Table structure for table `xb_feed_category_mapping`
--

DROP TABLE IF EXISTS `xb_feed_category_mapping`;
CREATE TABLE `xb_feed_category_mapping` (
  `mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `status` enum('include','exclude') NOT NULL,
  PRIMARY KEY (`mapping_id`),
  KEY `feed_id` (`feed_id`)
) TYPE=InnoDB AUTO_INCREMENT=258;

--
-- Table structure for table `xb_feed_filter_mapping`
--

DROP TABLE IF EXISTS `xb_feed_filter_mapping`;
CREATE TABLE `xb_feed_filter_mapping` (
  `mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(10) unsigned NOT NULL,
  `filter_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mapping_id`)
) TYPE=InnoDB AUTO_INCREMENT=27;

--
-- Table structure for table `xb_feeds`
--

DROP TABLE IF EXISTS `xb_feeds`;
CREATE TABLE `xb_feeds` (
  `feed_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`feed_id`)
) TYPE=InnoDB AUTO_INCREMENT=5;

--
-- Table structure for table `xb_filters`
--

DROP TABLE IF EXISTS `xb_filters`;
CREATE TABLE `xb_filters` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` int(10) unsigned NOT NULL,
  `filter_description` varchar(255) NOT NULL,
  `filter_short_name` varchar(255) NOT NULL,
  `on_by_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`filter_id`),
  KEY `sort_order` (`sort_order`),
  KEY `filter_short_name` (`filter_short_name`)
) TYPE=InnoDB AUTO_INCREMENT=5;

--
-- Table structure for table `xb_runlog`
--

DROP TABLE IF EXISTS `xb_runlog`;
CREATE TABLE `xb_runlog` (
  `runlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_time` datetime NOT NULL,
  `entry_for` varchar(128) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`runlog_id`),
  KEY `entry_time` (`entry_time`),
  KEY `entry_for` (`entry_for`)
) TYPE=InnoDB AUTO_INCREMENT=3044;

--
-- Table structure for table `xb_template_mapping`
--

DROP TABLE IF EXISTS `xb_template_mapping`;
CREATE TABLE `xb_template_mapping` (
  `mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(10) unsigned NOT NULL,
  `feed_id` int(10) unsigned NOT NULL,
  `template_id` int(10) unsigned NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`mapping_id`),
  KEY `identifier` (`identifier`)
) TYPE=InnoDB AUTO_INCREMENT=6;

--
-- Table structure for table `xb_templates`
--

DROP TABLE IF EXISTS `xb_templates`;
CREATE TABLE `xb_templates` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_description` varchar(255) NOT NULL,
  `template_type` enum('RSS1','RSS2','ATOM1','XML','CUSTOM') NOT NULL,
  `template_custom` varchar(255) NOT NULL,
  `template_extension` char(64) NOT NULL,
  `suppress_in_list` tinyint(1) NOT NULL,
  `sort_order` tinyint(1) NOT NULL,
  PRIMARY KEY (`template_id`)
) TYPE=InnoDB AUTO_INCREMENT=9;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-10 16:42:20
