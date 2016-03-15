/*
MySQL Backup
Source Host:           localhost
Source Server Version: 5.0.15-nt
Source Database:       ccdata
Date:                  2006/08/17 15:08:31
*/

SET FOREIGN_KEY_CHECKS=0;
use ccdata;
#----------------------------
# Table structure for cs_amenities
#----------------------------
CREATE TABLE `cs_amenities` (
  `amenityid` int(11) NOT NULL auto_increment,
  `label` text character set latin1 collate latin1_general_ci,
  `description` text,
  `deleted` tinyint(1) default '0',
  PRIMARY KEY  (`amenityid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_amenities
#----------------------------

#----------------------------
# Table structure for cs_banners
#----------------------------
CREATE TABLE `cs_banners` (
  `bannerid` varchar(8) NOT NULL default '',
  `description` text,
  `destinationurl` text,
  `sourceurl` text,
  `bannertype` tinyint(4) default NULL,
  `deleted` tinyint(4) default '0',
  `campaignid` varchar(8) default NULL,
  PRIMARY KEY  (`bannerid`),
  UNIQUE KEY `IDX_wd_pa_banners2` (`bannerid`),
  KEY `IDX_pa_banners_1` (`campaignid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_banners
#----------------------------

#----------------------------
# Table structure for cs_cardamenitymap
#----------------------------
CREATE TABLE `cs_cardamenitymap` (
  `cardid` int(11) NOT NULL,
  `amenityid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
#----------------------------
# No records for table cs_cardamenitymap
#----------------------------

#----------------------------
# Table structure for cs_carddata
#----------------------------
CREATE TABLE `cs_carddata` (
  `cardId` varchar(16) NOT NULL default '0',
  `introApr` double(11,2) default NULL,
  `introAprPeriod` tinyint(4) default NULL,
  `regularApr` double(11,2) default NULL,
  `annualFee` double(11,2) default NULL,
  `balanceTransfers` tinyint(1) default NULL,
  `monthlyFee` double(11,2) default NULL,
  `creditNeeded` tinyint(4) default NULL,
  `dateModified` datetime default NULL,
  PRIMARY KEY  (`cardId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_carddata
#----------------------------

#----------------------------
# Table structure for cs_cardhistory
#----------------------------
CREATE TABLE `cs_cardhistory` (
  `cardid` int(11) NOT NULL,
  `introApr` double default NULL,
  `introAprPeriod` int(4) default NULL,
  `regularApr` double default NULL,
  `monthlyFee` double default NULL,
  `annualFee` double default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`cardid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_cardhistory
#----------------------------

#----------------------------
# Table structure for cs_difftable
#----------------------------
CREATE TABLE `cs_difftable` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) default NULL,
  `content` text,
  `changed` tinyint(1) default '0',
  `deleted` tinyint(1) default '0',
  `name` varchar(255) default NULL,
  `ignoreLines` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_difftable
#----------------------------

#----------------------------
# Table structure for cs_history
#----------------------------
CREATE TABLE `cs_history` (
  `id` int(11) NOT NULL auto_increment,
  `dateinserted` datetime default NULL,
  `user` varchar(255) character set latin1 collate latin1_general_ci default NULL,
  `action` varchar(255) character set latin1 collate latin1_general_ci default NULL,
  `deleted` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_history
#----------------------------

#----------------------------
# Table structure for cs_pagecardexclusionmap
#----------------------------
CREATE TABLE `cs_pagecardexclusionmap` (
  `mapid` int(11) NOT NULL auto_increment,
  `siteid` int(11) default NULL,
  `pageid` int(11) default NULL,
  `cardid` int(11) default NULL,
  PRIMARY KEY  (`mapid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_pagecardexclusionmap
#----------------------------

#----------------------------
# Table structure for cs_pagecomponentmap
#----------------------------
CREATE TABLE `cs_pagecomponentmap` (
  `mapid` int(10) NOT NULL auto_increment,
  `siteid` int(10) default NULL,
  `pagetype` varchar(50) default NULL,
  `pageid` int(10) default NULL,
  `itemid` int(10) default '-1',
  `rank` int(10) default NULL,
  PRIMARY KEY  (`mapid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_pagecomponentmap
#----------------------------

#----------------------------
# Table structure for cs_pagecomponents
#----------------------------
CREATE TABLE `cs_pagecomponents` (
  `itemid` int(10) NOT NULL auto_increment,
  `item` varchar(50) character set latin1 collate latin1_general_ci default NULL,
  `render` mediumtext,
  `deleted` int(1) default '0',
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_pagecomponents
#----------------------------

#----------------------------
# Table structure for cs_rights
#----------------------------
CREATE TABLE `cs_rights` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(255) collate latin1_general_ci NOT NULL,
  `code` varchar(75) collate latin1_general_ci NOT NULL,
  `type` varchar(25) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
#----------------------------
# No records for table cs_rights
#----------------------------

#----------------------------
# Table structure for cs_settings
#----------------------------
CREATE TABLE `cs_settings` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) default NULL,
  `key` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `data1` varchar(255) default NULL,
  `data2` varchar(255) default NULL,
  `settingLabel` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_settings
#----------------------------

#----------------------------
# Table structure for cs_sitearticlecategorymap
#----------------------------
CREATE TABLE `cs_sitearticlecategorymap` (
  `mapid` int(11) NOT NULL auto_increment,
  `siteid` int(11) default NULL,
  `articlecategoryid` int(11) default NULL,
  `rank` int(4) default NULL,
  PRIMARY KEY  (`mapid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_sitearticlecategorymap
#----------------------------

#----------------------------
# Table structure for cs_userrights
#----------------------------
CREATE TABLE `cs_userrights` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `rightid` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
#----------------------------
# No records for table cs_userrights
#----------------------------

#----------------------------
# Table structure for cs_users
#----------------------------
CREATE TABLE `cs_users` (
  `userid` int(11) NOT NULL auto_increment,
  `firstName` varchar(25) character set latin1 collate latin1_general_ci default NULL,
  `lastName` varchar(25) character set latin1 collate latin1_general_ci default NULL,
  `password` varchar(32) character set latin1 collate latin1_general_ci default NULL,
  `username` varchar(25) character set latin1 collate latin1_general_ci default NULL,
  `userGroup` int(3) default '0',
  `deleted` int(1) default '0',
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table cs_users
#----------------------------

#----------------------------
# Table structure for rt_cardcategorymap
#----------------------------
CREATE TABLE `rt_cardcategorymap` (
  `cardcategorymapId` int(10) NOT NULL auto_increment,
  `categoryId` int(10) default NULL,
  `cardId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`cardcategorymapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_cardcategorymap
#----------------------------

#----------------------------
# Table structure for rt_carddetails
#----------------------------
CREATE TABLE `rt_carddetails` (
  `id` int(11) NOT NULL auto_increment,
  `cardShortName` varchar(30) default NULL,
  `cardLink` varchar(100) default NULL,
  `appLink` varchar(100) default NULL,
  `cardDetailVersion` int(10) default NULL,
  `cardDetailLabel` varchar(50) default NULL,
  `cardId` int(11) default NULL,
  `campaignLink` varchar(32) default NULL,
  `cardDetailText` text,
  `cardIntroDetail` text,
  `cardMoreDetail` text,
  `cardSeeDetails` text,
  `categoryImage` varchar(255) default NULL,
  `categoryAltText` varchar(255) default NULL,
  `cardIOImage` varchar(255) default NULL,
  `cardIOAltText` varchar(255) default NULL,
  `cardButtonImage` varchar(255) default NULL,
  `cardButtonAltText` varchar(255) default NULL,
  `cardIOButtonAltText` varchar(255) default NULL,
  `cardIconSmall` varchar(255) default NULL,
  `cardIconMid` varchar(255) default NULL,
  `cardIconLarge` varchar(255) default NULL,
  `detailOrder` int(3) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default '0000-00-00 00:00:00',
  `fid` varchar(50) default NULL,
  `cardListingString` varchar(100) default NULL,
  `cardPageHeaderString` varchar(100) default NULL,
  `imageAltText` varchar(100) default NULL,
  `active` tinyint(1) default '1',
  `deleted` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_carddetails
#----------------------------

#----------------------------
# Table structure for rt_cardpagemap
#----------------------------
CREATE TABLE `rt_cardpagemap` (
  `cardcategorymapId` int(10) NOT NULL auto_increment,
  `pageInsert` int(1) default '0',
  `cardpageId` int(10) default NULL,
  `cardId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`cardcategorymapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_cardpagemap
#----------------------------

#----------------------------
# Table structure for rt_cardpages
#----------------------------
CREATE TABLE `rt_cardpages` (
  `cardpageId` int(11) NOT NULL auto_increment,
  `pageName` varchar(50) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default NULL,
  `type` tinyint(1) default '0',
  `active` int(1) default '1',
  `deleted` int(1) default '0',
  PRIMARY KEY  (`cardpageId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_cardpages
#----------------------------

#----------------------------
# Table structure for rt_cards
#----------------------------
CREATE TABLE `rt_cards` (
  `id` int(11) NOT NULL auto_increment,
  `cardId` int(11) default NULL,
  `cardTitle` varchar(100) default NULL,
  `cardDescription` text,
  `merchant` varchar(100) default NULL,
  `introApr` varchar(50) default NULL,
  `active_introApr` int(1) default '0',
  `introAprPeriod` varchar(50) default NULL,
  `active_introAprPeriod` int(1) default '0',
  `regularApr` varchar(50) default NULL,
  `active_regularApr` int(1) default '0',
  `annualFee` varchar(50) default NULL,
  `active_annualFee` int(1) default '0',
  `monthlyFee` varchar(255) default NULL,
  `active_monthlyFee` int(1) default '0',
  `balanceTransfers` varchar(50) default NULL,
  `active_balanceTransfers` int(1) default '0',
  `creditNeeded` varchar(50) default NULL,
  `active_creditNeeded` int(1) default NULL,
  `imagePath` varchar(255) default NULL,
  `ratesAndFees` text,
  `rewards` text,
  `cardBenefits` text,
  `onlineServices` text,
  `footNotes` text,
  `layout` varchar(50) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default NULL,
  `subCat` tinyint(1) default '0',
  `catTitle` varchar(100) default NULL,
  `catDescription` text,
  `catImage` varchar(100) default NULL,
  `catImageAltText` varchar(100) default NULL,
  `syndicate` tinyint(1) default '1',
  `url` varchar(255) default NULL,
  `private` tinyint(1) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_cards
#----------------------------

#----------------------------
# Table structure for rt_categories
#----------------------------
CREATE TABLE `rt_categories` (
  `categoryId` int(10) NOT NULL auto_increment,
  `categoryName` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `shortName` varchar(25) character set latin1 collate latin1_general_ci default NULL,
  `categoryDescription` text character set latin1 collate latin1_general_ci,
  `order` int(10) default NULL,
  `parentId` int(10) default NULL,
  `siteId` int(10) default NULL,
  `type` tinyint(1) default '0',
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default '0000-00-00 00:00:00',
  `active` tinyint(1) default '1',
  `deleted` tinyint(1) default '0',
  PRIMARY KEY  (`categoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_categories
#----------------------------

#----------------------------
# Table structure for rt_keywords
#----------------------------
CREATE TABLE `rt_keywords` (
  `entryId` int(10) NOT NULL auto_increment,
  `keywordId` int(10) NOT NULL default '0',
  `keyword` varchar(255) default NULL,
  `dateinserted` datetime default NULL,
  `ordering` int(10) NOT NULL default '0',
  `deleted` tinyint(1) unsigned zerofill NOT NULL default '0',
  PRIMARY KEY  (`entryId`,`keywordId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB; InnoDB free: 4096 kB; InnoDB free: 112';
#----------------------------
# No records for table rt_keywords
#----------------------------

#----------------------------
# Table structure for rt_merchants
#----------------------------
CREATE TABLE `rt_merchants` (
  `merchantId` int(10) NOT NULL auto_increment,
  `shortName` varchar(20) default NULL,
  `longName` varchar(100) default NULL,
  `description` varchar(255) default NULL,
  `type` varchar(100) default NULL,
  `acctId` varchar(50) default NULL,
  `addressLine1` varchar(100) default NULL,
  `addressLine2` varchar(100) default NULL,
  `city` varchar(50) default NULL,
  `state` char(2) default NULL,
  `zipCode` varchar(10) default NULL,
  `phone` varchar(15) default NULL,
  `contact` varchar(100) default NULL,
  `notes` text,
  `dateinserted` datetime default NULL,
  `deleted` int(1) unsigned zerofill default NULL,
  `active` int(1) default '1',
  PRIMARY KEY  (`merchantId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB; InnoDB free: 4096 kB; InnoDB free: 112';
#----------------------------
# No records for table rt_merchants
#----------------------------

#----------------------------
# Table structure for rt_pagecategorymap
#----------------------------
CREATE TABLE `rt_pagecategorymap` (
  `categoryPageMapId` int(10) NOT NULL auto_increment,
  `cardpageId` int(10) default NULL,
  `categoryId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`categoryPageMapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
#----------------------------
# No records for table rt_pagecategorymap
#----------------------------

#----------------------------
# Table structure for rt_pagedetails
#----------------------------
CREATE TABLE `rt_pagedetails` (
  `id` int(11) NOT NULL auto_increment,
  `pageDetailVersion` int(11) default '-1',
  `pageDetailLabel` varchar(100) default NULL,
  `cardpageId` int(11) default NULL,
  `pageTitle` varchar(100) default NULL,
  `pageIntroDescription` text,
  `pageDescription` text,
  `pageSpecial` text,
  `pageMeta` text,
  `pageLearnMore` text,
  `pageDisclaimer` text,
  `pageHeaderImage` varchar(100) default NULL,
  `pageHeaderImageAltText` varchar(100) default NULL,
  `pageSpecialOfferImage` varchar(100) default NULL,
  `pageSpecialOfferImageAltText` varchar(100) default NULL,
  `pageSpecialOfferLink` varchar(100) default NULL,
  `pageSmallImage` varchar(100) default NULL,
  `pageSmallImageAltText` varchar(100) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default NULL,
  `pageLink` varchar(100) default NULL,
  `fid` int(20) default NULL,
  `pageHeaderString` varchar(100) default NULL,
  `primaryNavString` varchar(100) default NULL,
  `secondaryNavString` varchar(100) default NULL,
  `topPickAltText` varchar(100) default NULL,
  `flagTopPick` int(1) default NULL,
  `flagAdditionalOffer` int(1) default '0',
  `enableSort` int(1) default '0',
  `itemsPerPage` int(7) default '10000',
  `pageSeeAlso` text,
  `siteMapDescription` varchar(255) default NULL,
  `siteMapTitle` varchar(100) default NULL,
  `active` int(1) default '1',
  `deleted` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_pagedetails
#----------------------------

#----------------------------
# Table structure for rt_pages
#----------------------------
CREATE TABLE `rt_pages` (
  `entryId` int(10) NOT NULL auto_increment,
  `pageId` int(10) NOT NULL default '0',
  `pageName` varchar(255) default NULL,
  `dateInserted` datetime default NULL,
  `deleted` int(1) unsigned zerofill NOT NULL default '0',
  `ordering` int(10) NOT NULL default '0',
  PRIMARY KEY  (`entryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_pages
#----------------------------

#----------------------------
# Table structure for rt_pagesubpagemap
#----------------------------
CREATE TABLE `rt_pagesubpagemap` (
  `mapid` int(10) NOT NULL auto_increment,
  `siteid` int(10) default NULL,
  `masterpageid` int(10) default NULL,
  `subpageid` int(10) default NULL,
  `rank` int(3) default NULL,
  PRIMARY KEY  (`mapid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_pagesubpagemap
#----------------------------

#----------------------------
# Table structure for rt_sitecategorymap
#----------------------------
CREATE TABLE `rt_sitecategorymap` (
  `sitecategorymapId` int(10) NOT NULL auto_increment,
  `siteId` int(10) default NULL,
  `categoryId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`sitecategorymapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
#----------------------------
# No records for table rt_sitecategorymap
#----------------------------

#----------------------------
# Table structure for rt_sites
#----------------------------
CREATE TABLE `rt_sites` (
  `siteId` int(10) NOT NULL auto_increment,
  `siteName` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `siteTitle` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `siteDescription` text character set latin1 collate latin1_general_ci,
  `layout` varchar(50) character set latin1 collate latin1_general_ci default NULL,
  `applyLogo` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  `ftpSite` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  `ftpPath` varchar(250) default NULL,
  `sourcePath` varchar(250) default NULL,
  `publishPath` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  `hostname` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `publishTestScript` varchar(255) default NULL,
  `publishScript` varchar(255) default NULL,
  `order` int(10) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default '0000-00-00 00:00:00',
  `dateLastBuilt` datetime default NULL,
  `dblocation` varchar(255) default NULL,
  `dbname` varchar(255) default NULL,
  `sitemap` int(1) default NULL,
  `active` tinyint(1) default '1',
  `deleted` tinyint(1) default '0',
  PRIMARY KEY  (`siteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_sites
#----------------------------

#----------------------------
# Table structure for rt_articlepagecategorymap
#----------------------------
CREATE TABLE `rt_articlepagecategorymap` (
  `mapId` int(10) NOT NULL auto_increment,
  `cardpageId` int(10) default NULL,
  `categoryId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`mapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_articlepagecategorymap
#----------------------------

#----------------------------
# Table structure for rt_articlepagemap
#----------------------------
CREATE TABLE `rt_articlepagemap` (
  `mapId` int(10) NOT NULL auto_increment,
  `cardpageId` int(10) default NULL,
  `articleId` int(10) default NULL,
  `rank` int(10) default NULL,
  PRIMARY KEY  (`mapId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_articlepagemap
#----------------------------

#----------------------------
# Table structure for rt_articles
#----------------------------
CREATE TABLE `rt_articles` (
  `articleId` int(11) NOT NULL auto_increment,
  `subCat` tinyint(1) default '0',
  `articleTitle` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `articleIntroText` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  `articleLink` varchar(250) default NULL,
  `articleLinkName` varchar(20) character set latin1 collate latin1_general_ci default NULL,
  `articleBody` text character set latin1 collate latin1_general_ci,
  `deleted` int(1) default '0',
  `active` int(1) default '1',
  `catTitle` varchar(100) default NULL,
  `catDescription` text,
  `catImage` varchar(100) default NULL,
  `catImageAltText` varchar(100) default NULL,
  `dateUpdated` datetime default NULL,
  `dateCreated` datetime default NULL,
  PRIMARY KEY  (`articleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
#----------------------------
# No records for table rt_articles
#----------------------------


