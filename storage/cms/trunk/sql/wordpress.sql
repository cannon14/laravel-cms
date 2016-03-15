/*
MySQL Backup
Source Host:           localhost
Source Server Version: 5.0.15-nt
Source Database:       wordpress
Date:                  2006/08/17 15:00:24
*/

SET FOREIGN_KEY_CHECKS=0;
use wordpress;
#----------------------------
# Table structure for wp_alinks_keyphrases
#----------------------------
CREATE TABLE `wp_alinks_keyphrases` (
  `id` int(11) NOT NULL auto_increment,
  `keyphrase` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `defines` text NOT NULL,
  `module` varchar(60) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `keyword_keyword` (`keyphrase`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_alinks_keyphrases
#----------------------------

#----------------------------
# Table structure for wp_categories
#----------------------------
CREATE TABLE `wp_categories` (
  `cat_ID` bigint(20) NOT NULL auto_increment,
  `cat_name` varchar(55) NOT NULL default '',
  `category_nicename` varchar(200) NOT NULL default '',
  `category_description` longtext NOT NULL,
  `category_parent` bigint(20) NOT NULL default '0',
  `category_count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`cat_ID`),
  KEY `category_nicename` (`category_nicename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_categories
#----------------------------

#----------------------------
# Table structure for wp_comments
#----------------------------
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL auto_increment,
  `comment_post_ID` int(11) NOT NULL default '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL default '',
  `comment_author_url` varchar(200) NOT NULL default '',
  `comment_author_IP` varchar(100) NOT NULL default '',
  `comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL default '0',
  `comment_approved` enum('0','1','spam') NOT NULL default '1',
  `comment_agent` varchar(255) NOT NULL default '',
  `comment_type` varchar(20) NOT NULL default '',
  `comment_parent` bigint(20) NOT NULL default '0',
  `user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`comment_ID`),
  KEY `comment_approved` (`comment_approved`),
  KEY `comment_post_ID` (`comment_post_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_comments
#----------------------------

#----------------------------
# Table structure for wp_linkcategories
#----------------------------
CREATE TABLE `wp_linkcategories` (
  `cat_id` bigint(20) NOT NULL auto_increment,
  `cat_name` tinytext NOT NULL,
  `auto_toggle` enum('Y','N') NOT NULL default 'N',
  `show_images` enum('Y','N') NOT NULL default 'Y',
  `show_description` enum('Y','N') NOT NULL default 'N',
  `show_rating` enum('Y','N') NOT NULL default 'Y',
  `show_updated` enum('Y','N') NOT NULL default 'Y',
  `sort_order` varchar(64) NOT NULL default 'rand',
  `sort_desc` enum('Y','N') NOT NULL default 'N',
  `text_before_link` varchar(128) NOT NULL default '<li>',
  `text_after_link` varchar(128) NOT NULL default '<br />',
  `text_after_all` varchar(128) NOT NULL default '</li>',
  `list_limit` int(11) NOT NULL default '-1',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_linkcategories
#----------------------------

#----------------------------
# Table structure for wp_links
#----------------------------
CREATE TABLE `wp_links` (
  `link_id` bigint(20) NOT NULL auto_increment,
  `link_url` varchar(255) NOT NULL default '',
  `link_name` varchar(255) NOT NULL default '',
  `link_image` varchar(255) NOT NULL default '',
  `link_target` varchar(25) NOT NULL default '',
  `link_category` bigint(20) NOT NULL default '0',
  `link_description` varchar(255) NOT NULL default '',
  `link_visible` enum('Y','N') NOT NULL default 'Y',
  `link_owner` int(11) NOT NULL default '1',
  `link_rating` int(11) NOT NULL default '0',
  `link_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL default '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`link_id`),
  KEY `link_category` (`link_category`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_links
#----------------------------

#----------------------------
# Table structure for wp_options
#----------------------------
CREATE TABLE `wp_options` (
  `option_id` bigint(20) NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL default '0',
  `option_name` varchar(64) NOT NULL default '',
  `option_can_override` enum('Y','N') NOT NULL default 'Y',
  `option_type` int(11) NOT NULL default '1',
  `option_value` longtext NOT NULL,
  `option_width` int(11) NOT NULL default '20',
  `option_height` int(11) NOT NULL default '8',
  `option_description` tinytext NOT NULL,
  `option_admin_level` int(11) NOT NULL default '1',
  `autoload` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`option_id`,`blog_id`,`option_name`),
  KEY `option_name` (`option_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_options
#----------------------------

#----------------------------
# Table structure for wp_post2cat
#----------------------------
CREATE TABLE `wp_post2cat` (
  `rel_id` bigint(20) NOT NULL auto_increment,
  `post_id` bigint(20) NOT NULL default '0',
  `category_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`rel_id`),
  KEY `post_id` (`post_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_post2cat
#----------------------------

#----------------------------
# Table structure for wp_postmeta
#----------------------------
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) NOT NULL auto_increment,
  `post_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_postmeta
#----------------------------

#----------------------------
# Table structure for wp_posts
#----------------------------
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `post_author` bigint(20) NOT NULL default '0',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_category` int(4) NOT NULL default '0',
  `post_excerpt` text NOT NULL,
  `post_status` enum('publish','draft','private','static','object','attachment') NOT NULL default 'publish',
  `comment_status` enum('open','closed','registered_only') NOT NULL default 'open',
  `ping_status` enum('open','closed') NOT NULL default 'open',
  `post_password` varchar(20) NOT NULL default '',
  `post_name` varchar(200) NOT NULL default '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content_filtered` text NOT NULL,
  `post_parent` bigint(20) NOT NULL default '0',
  `guid` varchar(255) NOT NULL default '',
  `menu_order` int(11) NOT NULL default '0',
  `post_type` varchar(100) NOT NULL default '',
  `post_mime_type` varchar(100) NOT NULL default '',
  `comment_count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `post_name` (`post_name`),
  FULLTEXT KEY `post_related` (`post_name`,`post_content`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_posts
#----------------------------

#----------------------------
# Table structure for wp_usermeta
#----------------------------
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_usermeta
#----------------------------

#----------------------------
# Table structure for wp_users
#----------------------------
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `user_login` varchar(60) NOT NULL default '',
  `user_pass` varchar(64) NOT NULL default '',
  `user_nicename` varchar(50) NOT NULL default '',
  `user_email` varchar(100) NOT NULL default '',
  `user_url` varchar(100) NOT NULL default '',
  `user_registered` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL default '',
  `user_status` int(11) NOT NULL default '0',
  `display_name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `user_login_key` (`user_login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table wp_users
#----------------------------


