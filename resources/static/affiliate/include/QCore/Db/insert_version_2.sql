# MySQL-Front Dump 2.5
#
# Host: localhost   Database: version_2
# --------------------------------------------------------
# Server version 4.0.20a-nt


#
# Table structure for table 'wd_g_accounts'
#

CREATE TABLE wd_g_accounts (
  accountid varchar(8) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  description text,
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  rstatus tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (accountid),
  UNIQUE KEY name (name),
  UNIQUE KEY IDX_wd_g_accounts1 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_emailtemplates'
#

CREATE TABLE wd_g_emailtemplates (
  emailtempsid varchar(8) NOT NULL default '',
  categorycode varchar(20) NOT NULL default '',
  emailsubject varchar(250) default NULL,
  emailtext text,
  deleted tinyint(4) default '0',
  lang varchar(10) NOT NULL default '',
  PRIMARY KEY  (emailtempsid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_groups'
#

CREATE TABLE wd_g_groups (
  groupid varchar(8) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  rstatus tinyint(4) NOT NULL default '0',
  product varchar(10) NOT NULL default '',
  dateinserted datetime default NULL,
  deleted tinyint(4) NOT NULL default '0',
  parentgroupid varchar(8) default NULL,
  leftnumber int(11) default NULL,
  rightnumber int(11) default NULL,
  PRIMARY KEY  (groupid),
  UNIQUE KEY IDX_wd_g_groups1 (groupid),
  KEY IDX_wd_g_groups2 (parentgroupid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_history'
#

CREATE TABLE wd_g_history (
  historyid varchar(8) NOT NULL default '',
  accountid varchar(8) default NULL,
  rtype tinyint(4) NOT NULL default '0',
  value text NOT NULL,
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  hfile text,
  line int(11) default NULL,
  ip varchar(20) default NULL,
  module varchar(20) NOT NULL default '',
  PRIMARY KEY  (historyid),
  KEY IDX_wd_g_history1 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_listviews'
#

CREATE TABLE wd_g_listviews (
  viewid varchar(8) NOT NULL default '',
  accountid varchar(8) NOT NULL default '',
  userid varchar(8) NOT NULL default '',
  name varchar(30) NOT NULL default '',
  rcolumns text NOT NULL,
  listname varchar(60) NOT NULL default '',
  payoptid varchar(8) NOT NULL default '',
  PRIMARY KEY  (viewid,accountid,userid,payoptid),
  KEY IDX_wd_g_listviews1 (accountid),
  KEY IDX_wd_g_listviews2 (userid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_messages'
#

CREATE TABLE wd_g_messages (
  messageid varchar(8) NOT NULL default '',
  rtype tinyint(4) NOT NULL default '0',
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  title varchar(100) NOT NULL default '',
  rtext text NOT NULL,
  deleted tinyint(4) NOT NULL default '0',
  accountid varchar(8) default NULL,
  PRIMARY KEY  (messageid),
  UNIQUE KEY IDX_wd_g_messages2 (messageid),
  KEY IDX_wd_g_messages1 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_messagestousers'
#

CREATE TABLE wd_g_messagestousers (
  messagetouserid varchar(8) NOT NULL default '',
  messageid varchar(8) default NULL,
  userid varchar(8) default NULL,
  email varchar(80) default NULL,
  rstatus tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (messagetouserid),
  KEY IDX_wd_g_messagestousers1 (messageid),
  KEY IDX_wd_g_messagestousers2 (userid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_righttypes'
#

CREATE TABLE wd_g_righttypes (
  righttypeid varchar(8) NOT NULL default '',
  parentrighttypeid varchar(8) default NULL,
  module varchar(20) NOT NULL default '',
  category varchar(40) NOT NULL default '',
  code varchar(40) NOT NULL default '',
  righttype varchar(20) default NULL,
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  categorylangid varchar(80) NOT NULL default '',
  rightlangid varchar(80) NOT NULL default '',
  typelangid varchar(80) NOT NULL default '',
  rorder int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (righttypeid),
  UNIQUE KEY IDX_wd_g_righttypes1 (righttypeid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_settings'
#

CREATE TABLE wd_g_settings (
  settingsid varchar(8) NOT NULL default '',
  rtype tinyint(3) unsigned NOT NULL default '0',
  code varchar(50) NOT NULL default '',
  value text,
  accountid varchar(8) default NULL,
  userid varchar(8) default NULL,
  id1 varchar(8) default NULL,
  id2 varchar(8) default NULL,
  PRIMARY KEY  (settingsid),
  KEY IDX_wd_g_settings1 (accountid),
  KEY IDX_wd_g_settings2 (userid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_usergroups'
#

CREATE TABLE wd_g_usergroups (
  usergroupid char(8) NOT NULL default '',
  userid char(8) NOT NULL default '',
  groupid char(8) NOT NULL default '',
  PRIMARY KEY  (usergroupid),
  KEY IDX_wd_g_usergroups1 (userid),
  KEY IDX_wd_g_usergroups2 (groupid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_userprofiles'
#

CREATE TABLE wd_g_userprofiles (
  userprofileid varchar(8) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  rtype varchar(20) NOT NULL default '',
  accountid varchar(8) NOT NULL default '',
  PRIMARY KEY  (userprofileid),
  UNIQUE KEY name (name),
  UNIQUE KEY IDX_wd_g_userprofiles1 (userprofileid),
  KEY IDX_wd_g_userprofiles2 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_userrights'
#

CREATE TABLE wd_g_userrights (
  userrightid char(8) NOT NULL default '',
  userprofileid char(8) NOT NULL default '',
  righttypeid char(8) default NULL,
  PRIMARY KEY  (userrightid),
  KEY IDX_wd_g_userrights1 (userprofileid),
  KEY IDX_wd_g_userrights2 (righttypeid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_g_users'
#

CREATE TABLE wd_g_users (
  userid varchar(8) NOT NULL default '',
  accountid varchar(8) NOT NULL default '',
  username varchar(60) NOT NULL default '',
  rpassword varchar(60) NOT NULL default '',
  name varchar(100) default NULL,
  surname varchar(100) default NULL,
  rstatus tinyint(4) NOT NULL default '0',
  product varchar(10) NOT NULL default '',
  dateinserted datetime default NULL,
  dateapproved datetime default NULL,
  deleted tinyint(4) NOT NULL default '0',
  userprofileid varchar(8) default NULL,
  rtype tinyint(4) NOT NULL default '0',
  parentuserid varchar(8) default NULL,
  leftnumber int(11) default NULL,
  rightnumber int(11) default NULL,
  company_name varchar(150) default NULL,
  weburl varchar(250) default NULL,
  street varchar(250) default NULL,
  city varchar(250) default NULL,
  state varchar(250) default NULL,
  country varchar(150) default NULL,
  zipcode varchar(40) default NULL,
  phone varchar(100) default NULL,
  fax varchar(100) default NULL,
  tax_ssn varchar(100) default NULL,
  data1 varchar(250) default NULL,
  data2 varchar(250) default NULL,
  data3 varchar(250) default NULL,
  data4 varchar(250) default NULL,
  data5 varchar(250) default NULL,
  payoptid varchar(8) default NULL,
  originalparentid varchar(8) default NULL,
  PRIMARY KEY  (userid),
  UNIQUE KEY IDX_wd_g_users3 (userid),
  KEY IDX_pa_affiliates_1 (deleted),
  KEY IDX_pa_affiliates_2 (username,rpassword),
  KEY IDX_wd_g_users4 (accountid),
  KEY IDX_wd_g_users5 (userprofileid),
  KEY IDX_wd_g_users6 (parentuserid),
  KEY IDX_wd_g_users7 (payoptid),
  KEY IDX_wd_g_users8 (originalparentid),
  KEY username (username)
) TYPE=MyISAM;



#
# Table structure for table 'wd_nl_newsletters'
#

CREATE TABLE wd_nl_newsletters (
  newsletterid varchar(8) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  description text,
  subject text,
  plaintext text,
  htmltext text,
  encoding varchar(100) NOT NULL default '',
  dateinserted datetime default NULL,
  PRIMARY KEY  (newsletterid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_accounting'
#

CREATE TABLE wd_pa_accounting (
  accountingid varchar(8) NOT NULL default '',
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  datefrom datetime NOT NULL default '0000-00-00 00:00:00',
  dateto datetime NOT NULL default '0000-00-00 00:00:00',
  note text,
  paypalfile varchar(100) default NULL,
  mbfile varchar(100) default NULL,
  wirefile varchar(100) default NULL,
  PRIMARY KEY  (accountingid),
  UNIQUE KEY IDX_wd_pa_accounting1 (accountingid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_affiliatescampaigns'
#

CREATE TABLE wd_pa_affiliatescampaigns (
  affcampid varchar(8) NOT NULL default '',
  campcategoryid varchar(8) default NULL,
  affiliateid varchar(8) default NULL,
  campaignid varchar(8) NOT NULL default '',
  rstatus tinyint(4) NOT NULL default '0',
  declinereason varchar(250) default NULL,
  PRIMARY KEY  (affcampid),
  KEY IDX_wd_pa_affiliatescampaigns1 (campcategoryid),
  KEY IDX_wd_pa_affiliatescampaigns2 (affiliateid),
  KEY IDX_wd_pa_affiliatescampaigns3 (campaignid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_banners'
#

CREATE TABLE wd_pa_banners (
  bannerid varchar(8) NOT NULL default '',
  description text,
  destinationurl text,
  sourceurl text,
  flashsource text,
  bannertype tinyint(4) default NULL,
  deleted tinyint(4) default '0',
  campaignid varchar(8) default NULL,
  PRIMARY KEY  (bannerid),
  UNIQUE KEY IDX_wd_pa_banners2 (bannerid),
  KEY IDX_pa_banners_1 (campaignid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_campaigncategories'
#

CREATE TABLE wd_pa_campaigncategories (
  campcategoryid varchar(8) NOT NULL default '',
  name varchar(100) default NULL,
  deleted tinyint(4) NOT NULL default '0',
  cpmcommission float default NULL,
  clickcommission float default NULL,
  salecommission float default NULL,
  recurringcommission float default NULL,
  recurringcommtype varchar(5) default NULL,
  recurringcommdate int(11) default NULL,
  recurringdatetype tinyint(4) default NULL,
  campaignid varchar(8) default NULL,
  salecommtype varchar(5) default NULL,
  stsalecommtype varchar(5) default NULL,
  st2clickcommission float default NULL,
  st2salecommission float default NULL,
  st3clickcommission float default NULL,
  st3salecommission float default NULL,
  st4clickcommission float default NULL,
  st4salecommission float default NULL,
  st5clickcommission float default NULL,
  st5salecommission float default NULL,
  st6clickcommission float default NULL,
  st6salecommission float default NULL,
  st7clickcommission float default NULL,
  st7salecommission float default NULL,
  st8clickcommission float default NULL,
  st8salecommission float default NULL,
  st9clickcommission float default NULL,
  st9salecommission float default NULL,
  st10clickcommission float default NULL,
  st10salecommission float default NULL,
  strecurringcommtype varchar(5) default NULL,
  st2recurringcommission float default NULL,
  st3recurringcommission float default NULL,
  st4recurringcommission float default NULL,
  st5recurringcommission float default NULL,
  st6recurringcommission float default NULL,
  st7recurringcommission float default NULL,
  st8recurringcommission float default NULL,
  st9recurringcommission float default NULL,
  st10recurringcommission float default NULL,
  PRIMARY KEY  (campcategoryid),
  UNIQUE KEY IDX_wd_pa_campaigncategories2 (campcategoryid),
  KEY IDX_pa_affiliatecategories_1 (campaignid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_campaigns'
#

CREATE TABLE wd_pa_campaigns (
  campaignid varchar(8) NOT NULL default '',
  accountid varchar(8) default NULL,
  name varchar(100) default NULL,
  description text,
  shortdescription varchar(200) default NULL,
  dateinserted datetime default NULL,
  deleted tinyint(4) NOT NULL default '0',
  disabled tinyint(4) NOT NULL default '0',
  commtype tinyint(4) NOT NULL default '0',
  products text,
  PRIMARY KEY  (campaignid),
  UNIQUE KEY IDX_wd_pa_campaigns1 (campaignid),
  KEY IDX_wd_pa_campaigns2 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_impressions'
#

CREATE TABLE wd_pa_impressions (
  impressionid char(8) NOT NULL default '',
  accountid char(8) default NULL,
  dateimpression datetime NOT NULL default '0000-00-00 00:00:00',
  bannerid char(8) default NULL,
  affiliateid char(8) default NULL,
  all_imps_count int(11) default '0',
  unique_imps_count int(11) default '0',
  PRIMARY KEY  (impressionid),
  KEY IDX_pa_impressions_1 (dateimpression),
  KEY IDX_pa_impressions_2 (bannerid),
  KEY IDX_pa_impressions_3 (bannerid,affiliateid,dateimpression),
  KEY IDX_pa_impressions_4 (affiliateid),
  KEY IDX_wd_pa_impressions5 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_payoutfields'
#

CREATE TABLE wd_pa_payoutfields (
  payfieldid varchar(8) NOT NULL default '',
  payoptid varchar(8) NOT NULL default '',
  code varchar(20) NOT NULL default '',
  name varchar(40) NOT NULL default '',
  langid varchar(80) NOT NULL default '',
  rtype tinyint(4) NOT NULL default '0',
  mandatory tinyint(4) NOT NULL default '0',
  visible tinyint(3) unsigned NOT NULL default '0',
  availablevalues text,
  rorder tinyint(3) unsigned NOT NULL default '0',
  value text,
  PRIMARY KEY  (payfieldid,payoptid),
  KEY IDX_wd_pa_payoutfields1 (payoptid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_payoutoptions'
#

CREATE TABLE wd_pa_payoutoptions (
  payoptid varchar(8) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  exporttype tinyint(4) NOT NULL default '0',
  exportformat text,
  disabled tinyint(4) NOT NULL default '0',
  langid varchar(80) NOT NULL default '',
  accountid varchar(8) NOT NULL default '',
  rorder tinyint(3) unsigned NOT NULL default '0',
  paybuttonformat text,
  PRIMARY KEY  (payoptid),
  UNIQUE KEY IDX_wd_pa_payoutptions1 (payoptid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_recurringcommissions'
#

CREATE TABLE wd_pa_recurringcommissions (
  recurringcommid varchar(8) NOT NULL default '',
  commission float NOT NULL default '0',
  commtype varchar(5) default NULL,
  commdate tinyint(4) NOT NULL default '0',
  datetype tinyint(4) NOT NULL default '0',
  rstatus tinyint(4) NOT NULL default '0',
  deleted tinyint(4) default '0',
  campcategoryid varchar(8) default NULL,
  affiliateid varchar(8) default NULL,
  originaltransid varchar(8) default NULL,
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  stcommtype varchar(5) default NULL,
  st2affiliateid int(10) unsigned default NULL,
  st2commission float default NULL,
  st3affiliateid int(10) unsigned default NULL,
  st3commission float default NULL,
  st4affiliateid int(10) unsigned default NULL,
  st4commission float default NULL,
  st5affiliateid int(10) unsigned default NULL,
  st5commission float default NULL,
  st6affiliateid int(10) unsigned default NULL,
  st6commission float default NULL,
  st7affiliateid int(10) unsigned default NULL,
  st7commission float default NULL,
  st8affiliateid int(10) unsigned default NULL,
  st8commission float default NULL,
  st9affiliateid int(10) unsigned default NULL,
  st9commission float default NULL,
  st10affiliateid int(10) unsigned default NULL,
  st10commission float default NULL,
  PRIMARY KEY  (recurringcommid),
  UNIQUE KEY IDX_wd_pa_recurringcommissions4 (recurringcommid),
  KEY IDX_wd_pa_recurringcommissions1 (campcategoryid),
  KEY IDX_wd_pa_recurringcommissions2 (affiliateid),
  KEY IDX_wd_pa_recurringcommissions3 (originaltransid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_rules'
#

CREATE TABLE wd_pa_rules (
  ruleid varchar(8) NOT NULL default '',
  name varchar(100) default NULL,
  cond_when varchar(20) default NULL,
  cond_in varchar(20) default NULL,
  cond_is varchar(20) default NULL,
  cond_value1 varchar(40) default NULL,
  cond_value2 varchar(40) default NULL,
  cond_action varchar(40) default NULL,
  cond_action_value varchar(100) default NULL,
  accountid varchar(8) NOT NULL default '',
  campaignid varchar(8) NOT NULL default '',
  PRIMARY KEY  (ruleid,accountid,campaignid),
  KEY IDX_wd_pa_rules1 (accountid),
  KEY IDX_wd_pa_rules2 (campaignid)
) TYPE=MyISAM;



#
# Table structure for table 'wd_pa_transactions'
#

CREATE TABLE wd_pa_transactions (
  transid varchar(8) NOT NULL default '',
  accountid varchar(8) default NULL,
  rstatus tinyint(4) NOT NULL default '0',
  dateinserted datetime default NULL,
  dateapproved datetime default NULL,
  transtype tinyint(4) default '0',
  payoutstatus tinyint(4) default '1',
  datepayout datetime default NULL,
  cookiestatus tinyint(4) default NULL,
  orderid varchar(200) default NULL,
  totalcost float default NULL,
  bannerid varchar(8) default NULL,
  transkind tinyint(4) default '0',
  refererurl varchar(250) default NULL,
  affiliateid varchar(8) default NULL,
  campcategoryid varchar(8) default NULL,
  parenttransid varchar(8) default NULL,
  commission float default '0',
  ip varchar(20) default NULL,
  recurringcommid varchar(8) default NULL,
  accountingid varchar(8) default NULL,
  productid varchar(200) default NULL,
  data1 varchar(80) default NULL,
  data2 varchar(80) default NULL,
  data3 varchar(80) default NULL,
  PRIMARY KEY  (transid),
  UNIQUE KEY IDX_wd_pa_transactions8 (transid),
  KEY IDX_pa_transactions_1 (affiliateid),
  KEY IDX_pa_transactions_2 (dateinserted),
  KEY IDX_pa_transactions_3 (transkind,transtype,rstatus),
  KEY IDX_pa_transactions_4 (campcategoryid),
  KEY IDX_pa_transactions_5 (ip),
  KEY IDX_wd_pa_transactions6 (bannerid),
  KEY IDX_wd_pa_transactions7 (parenttransid),
  KEY IDX_wd_pa_transactions9 (recurringcommid),
  KEY IDX_wd_pa_transactions10 (accountingid),
  KEY IDX_wd_pa_transactions11 (accountid)
) TYPE=MyISAM;



#
# Table structure for table 'wrapper_categories'
#

CREATE TABLE wrapper_categories (
  catid int(11) NOT NULL auto_increment,
  title varchar(250) NOT NULL default '',
  PRIMARY KEY  (catid),
  UNIQUE KEY IDX_Entity_11 (title),
  UNIQUE KEY IDX_wrapper_categories2 (catid)
) TYPE=MyISAM;



#
# Table structure for table 'wrapper_processes'
#

CREATE TABLE wrapper_processes (
  processid varchar(32) NOT NULL default '',
  serverid int(11) NOT NULL default '0',
  started datetime NOT NULL default '0000-00-00 00:00:00',
  last_loop datetime NOT NULL default '0000-00-00 00:00:00',
  enabled char(1) NOT NULL default '',
  PRIMARY KEY  (processid,serverid),
  UNIQUE KEY IDX_wrapper_processes2 (processid,serverid),
  KEY IDX_wrapper_processes1 (serverid)
) TYPE=MyISAM;



#
# Table structure for table 'wrapper_schedule'
#

CREATE TABLE wrapper_schedule (
  schedule_id int(11) NOT NULL auto_increment,
  scriptid int(11) default NULL,
  serverid int(11) default NULL,
  processid varchar(32) default NULL,
  created datetime NOT NULL default '0000-00-00 00:00:00',
  schedule_at datetime NOT NULL default '0000-00-00 00:00:00',
  started datetime default NULL,
  finished datetime default NULL,
  context_vars text,
  priority int(11) default NULL,
  result char(1) NOT NULL default '',
  logger longtext,
  PRIMARY KEY  (schedule_id),
  KEY IDX_wrapper_schedule1 (processid,serverid),
  KEY IDX_wrapper_schedule2 (scriptid)
) TYPE=MyISAM;



#
# Table structure for table 'wrapper_scripts'
#

CREATE TABLE wrapper_scripts (
  scriptid int(11) NOT NULL auto_increment,
  catid int(11) default NULL,
  title varchar(250) NOT NULL default '',
  script text NOT NULL,
  last_modification datetime NOT NULL default '0000-00-00 00:00:00',
  confirmation char(1) NOT NULL default '',
  logger_level varchar(32) default NULL,
  PRIMARY KEY  (scriptid),
  UNIQUE KEY IDX_wrapper_scripts1 (title),
  UNIQUE KEY IDX_wrapper_scripts3 (scriptid),
  KEY IDX_wrapper_scripts2 (catid)
) TYPE=MyISAM;



#
# Table structure for table 'wrapper_servers'
#

CREATE TABLE wrapper_servers (
  serverid int(11) NOT NULL auto_increment,
  textid varchar(250) NOT NULL default '',
  max_processes int(11) default '10',
  enabled char(1) NOT NULL default '',
  PRIMARY KEY  (serverid),
  UNIQUE KEY IDX_Entity_11 (textid),
  UNIQUE KEY IDX_wrapper_servers2 (serverid)
) TYPE=MyISAM;

