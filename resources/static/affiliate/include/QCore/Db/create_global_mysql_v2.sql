#========================================================================== #
# Project Filename:    E:\work\a_v\projects\QCore\Db\global_2.dez           #
# Project Name:        Version 2                                            #
# Author:                                                                   #
# DBMS:                MySQL 3                                              #
# Copyright:                                                                #
# Generated on:        14.4.2005 13:43:43                                   #
#========================================================================== #

#========================================================================== #
#  Tables                                                                   #
#========================================================================== #

CREATE TABLE wd_g_history (
    historyid CHAR(8) NOT NULL,
    accountid CHAR(8),
    rtype TINYINT NOT NULL,
    value TEXT NOT NULL,
    dateinserted DATETIME NOT NULL,
    hfile TEXT,
    line INTEGER,
    ip VARCHAR(20),
    module VARCHAR(20) NOT NULL,
    CONSTRAINT PK_wd_g_history PRIMARY KEY (historyid),
    KEY IDX_wd_g_history1(accountid)
);

CREATE TABLE wd_g_accounts (
    accountid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    dateinserted DATETIME NOT NULL,
    rstatus TINYINT NOT NULL DEFAULT 0,
    CONSTRAINT PK_wd_g_accounts PRIMARY KEY (accountid),
    UNIQUE (name),
    UNIQUE KEY IDX_wd_g_accounts1(accountid)
);

CREATE TABLE wd_g_righttypes (
    righttypeid CHAR(8) NOT NULL,
    parentrighttypeid CHAR(8),
    module VARCHAR(20) NOT NULL,
    category VARCHAR(40) NOT NULL,
    code VARCHAR(40) NOT NULL,
    righttype VARCHAR(20),
    dateinserted DATETIME NOT NULL,
    categorylangid VARCHAR(80) NOT NULL,
    rightlangid VARCHAR(80) NOT NULL,
    typelangid VARCHAR(80) NOT NULL,
    rorder INTEGER,
    CONSTRAINT PK_wd_g_righttypes PRIMARY KEY (righttypeid),
    UNIQUE KEY IDX_wd_g_righttypes1(righttypeid),
    KEY IDX_wd_g_righttypes2(parentrighttypeid)
);

CREATE TABLE wd_g_userprofiles (
    userprofileid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rtype VARCHAR(20) NOT NULL,
    accountid CHAR(8),
    CONSTRAINT PK_wd_g_userprofiles PRIMARY KEY (userprofileid),
    UNIQUE (name),
    UNIQUE KEY IDX_wd_g_userprofiles1(userprofileid),
    KEY IDX_wd_g_userprofiles2(accountid)
);

CREATE TABLE wd_g_userrights (
    userrightid CHAR(8) NOT NULL,
    userprofileid CHAR(8) NOT NULL,
    righttypeid CHAR(8),
    CONSTRAINT PK_wd_g_userrights PRIMARY KEY (userrightid),
    KEY IDX_wd_g_userrights1(userprofileid),
    KEY IDX_wd_g_userrights2(righttypeid)
);

CREATE TABLE wd_g_settings (
    settingsid CHAR(8) NOT NULL,
    rtype TINYINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    value TEXT,
    accountid CHAR(8),
    userid CHAR(8),
    id1 CHAR(8),
    id2 CHAR(8),
    CONSTRAINT PK_wd_g_settings PRIMARY KEY (settingsid),
    KEY IDX_wd_g_settings1(accountid),
    KEY IDX_wd_g_settings2(userid)
);

CREATE TABLE wd_pa_campaigns (
    campaignid CHAR(8) NOT NULL,
    accountid CHAR(8),
    name VARCHAR(100),
    description TEXT,
    shortdescription VARCHAR(200),
    dateinserted DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    disabled TINYINT NOT NULL DEFAULT 0,
    commtype TINYINT NOT NULL,
    products TEXT,
    CONSTRAINT PK_wd_pa_campaigns PRIMARY KEY (campaignid),
    UNIQUE KEY IDX_wd_pa_campaigns1(campaignid),
    KEY IDX_wd_pa_campaigns2(accountid)
);

CREATE TABLE wd_g_users (
    userid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    refid VARCHAR(20),
    username VARCHAR(60) NOT NULL,
    rpassword VARCHAR(60) NOT NULL,
    name VARCHAR(100),
    surname VARCHAR(100),
    rstatus TINYINT NOT NULL DEFAULT 0,
    product VARCHAR(10) NOT NULL,
    dateinserted DATETIME,
    dateapproved DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    userprofileid CHAR(8),
    rtype TINYINT NOT NULL,
    parentuserid CHAR(8),
    leftnumber INTEGER,
    rightnumber INTEGER,
    company_name VARCHAR(150),
    weburl VARCHAR(250),
    street VARCHAR(250),
    city VARCHAR(250),
    state VARCHAR(250),
    country VARCHAR(150),
    zipcode VARCHAR(40),
    phone VARCHAR(100),
    fax VARCHAR(100),
    tax_ssn VARCHAR(100),
    data1 VARCHAR(250),
    data2 VARCHAR(250),
    data3 VARCHAR(250),
    data4 VARCHAR(250),
    data5 VARCHAR(250),
    payoptid CHAR(8),
    originalparentid CHAR(8),
    flags TINYINT,
    CONSTRAINT PK_wd_g_users PRIMARY KEY (userid),
    KEY IDX_pa_affiliates_1(deleted),
    KEY IDX_pa_affiliates_2(username, rpassword),
    UNIQUE KEY IDX_wd_g_users3(userid),
    KEY IDX_wd_g_users4(accountid),
    KEY IDX_wd_g_users5(userprofileid),
    KEY IDX_wd_g_users6(parentuserid),
    KEY IDX_wd_g_users7(payoptid),
    KEY IDX_wd_g_users8(originalparentid)
);

CREATE TABLE wd_pa_campaigncategories (
    campcategoryid CHAR(8) NOT NULL,
    name VARCHAR(100),
    deleted TINYINT NOT NULL DEFAULT 0,
    cpmcommission FLOAT,
    clickcommission FLOAT,
    salecommission FLOAT,
    recurringcommission FLOAT,
    recurringcommtype VARCHAR(5),
    recurringcommdate INTEGER,
    recurringdatetype TINYINT,
    campaignid CHAR(8),
    salecommtype VARCHAR(5),
    stsalecommtype VARCHAR(5),
    st2clickcommission FLOAT,
    st2salecommission FLOAT,
    st3clickcommission FLOAT,
    st3salecommission FLOAT,
    st4clickcommission FLOAT,
    st4salecommission FLOAT,
    st5clickcommission FLOAT,
    st5salecommission FLOAT,
    st6clickcommission FLOAT,
    st6salecommission FLOAT,
    st7clickcommission FLOAT,
    st7salecommission FLOAT,
    st8clickcommission FLOAT,
    st8salecommission FLOAT,
    st9clickcommission FLOAT,
    st9salecommission FLOAT,
    st10clickcommission FLOAT,
    st10salecommission FLOAT,
    strecurringcommtype VARCHAR(5),
    st2recurringcommission FLOAT,
    st3recurringcommission FLOAT,
    st4recurringcommission FLOAT,
    st5recurringcommission FLOAT,
    st6recurringcommission FLOAT,
    st7recurringcommission FLOAT,
    st8recurringcommission FLOAT,
    st9recurringcommission FLOAT,
    st10recurringcommission FLOAT,
    CONSTRAINT PK_wd_pa_campaigncategories PRIMARY KEY (campcategoryid),
    KEY IDX_pa_affiliatecategories_1(campaignid),
    UNIQUE KEY IDX_wd_pa_campaigncategories2(campcategoryid)
);

CREATE TABLE wd_pa_banners (
    bannerid CHAR(8) NOT NULL,
    description TEXT,
    destinationurl TEXT,
    sourceurl TEXT,
    bannertype TINYINT,
    deleted TINYINT DEFAULT 0,
    campaignid CHAR(8),
    CONSTRAINT PK_wd_pa_banners PRIMARY KEY (bannerid),
    KEY IDX_pa_banners_1(campaignid),
    UNIQUE KEY IDX_wd_pa_banners2(bannerid)
);

CREATE TABLE wd_g_emailtemplates (
    emailtempsid CHAR(8) NOT NULL,
    categorycode VARCHAR(20) NOT NULL,
    emailsubject VARCHAR(250),
    emailtext TEXT,
    deleted TINYINT DEFAULT 0,
    lang VARCHAR(10) NOT NULL,
    CONSTRAINT PK_wd_g_emailtemplates PRIMARY KEY (emailtempsid)
);

CREATE TABLE wd_pa_impressions (
    impressionid CHAR(8) NOT NULL,
    accountid CHAR(8),
    dateimpression DATETIME NOT NULL,
    bannerid CHAR(8),
    affiliateid CHAR(8),
    all_imps_count INTEGER DEFAULT 0,
    unique_imps_count INTEGER DEFAULT 0,
    commissiongiven TINYINT NOT NULL DEFAULT 0,
    data1 VARCHAR(80),
    CONSTRAINT PK_wd_pa_impressions PRIMARY KEY (impressionid),
    KEY IDX_pa_impressions_3(bannerid, affiliateid, dateimpression),
    KEY IDX_wd_pa_impressions2(bannerid),
    KEY IDX_wd_pa_impressions3(affiliateid),
    KEY IDX_wd_pa_impressions4(accountid)
);

CREATE TABLE wd_pa_transactions (
    transid CHAR(8) NOT NULL,
    accountid CHAR(8),
    rstatus TINYINT NOT NULL DEFAULT 0,
    dateinserted DATETIME,
    dateapproved DATETIME,
    transtype TINYINT DEFAULT 0,
    payoutstatus TINYINT DEFAULT 1,
    datepayout DATETIME,
    cookiestatus TINYINT,
    orderid VARCHAR(200),
    totalcost FLOAT,
    bannerid CHAR(8),
    transkind TINYINT DEFAULT 0,
    refererurl VARCHAR(250),
    affiliateid CHAR(8),
    campcategoryid CHAR(8),
    parenttransid CHAR(8),
    commission FLOAT DEFAULT 0,
    ip VARCHAR(20),
    recurringcommid CHAR(8),
    accountingid CHAR(8),
    productid VARCHAR(200),
    data1 VARCHAR(80),
    data2 VARCHAR(80),
    data3 VARCHAR(80),
    CONSTRAINT PK_wd_pa_transactions PRIMARY KEY (transid),
    KEY IDX_pa_transactions_2(dateinserted),
    KEY IDX_pa_transactions_3(transkind, transtype, rstatus),
    KEY IDX_pa_transactions_4(campcategoryid),
    KEY IDX_wd_pa_transactions4(bannerid),
    KEY IDX_wd_pa_transactions5(affiliateid),
    KEY IDX_wd_pa_transactions6(parenttransid),
    UNIQUE KEY IDX_wd_pa_transactions7(transid),
    KEY IDX_wd_pa_transactions8(recurringcommid),
    KEY IDX_wd_pa_transactions9(accountingid),
    KEY IDX_wd_pa_transactions10(accountid)
);

CREATE TABLE wd_pa_affiliatescampaigns (
    affcampid CHAR(8) NOT NULL,
    campcategoryid CHAR(8),
    affiliateid CHAR(8),
    campaignid CHAR(8) NOT NULL,
    rstatus TINYINT NOT NULL,
    declinereason VARCHAR(250),
    CONSTRAINT PK_wd_pa_affiliatescampaigns PRIMARY KEY (affcampid),
    KEY IDX_wd_pa_affiliatescampaigns1(campcategoryid),
    KEY IDX_wd_pa_affiliatescampaigns2(affiliateid),
    KEY IDX_wd_pa_affiliatescampaigns3(campaignid)
);

CREATE TABLE wd_pa_recurringcommissions (
    recurringcommid CHAR(8) NOT NULL,
    commission FLOAT NOT NULL,
    commtype VARCHAR(5),
    commdate TINYINT NOT NULL,
    datetype TINYINT NOT NULL,
    rstatus TINYINT NOT NULL DEFAULT 0,
    deleted TINYINT DEFAULT 0,
    campcategoryid CHAR(8),
    affiliateid CHAR(8),
    originaltransid CHAR(8),
    dateinserted DATETIME NOT NULL,
    stcommtype VARCHAR(5),
    st2affiliateid INTEGER UNSIGNED,
    st2commission FLOAT,
    st3affiliateid INTEGER UNSIGNED,
    st3commission FLOAT,
    st4affiliateid INTEGER UNSIGNED,
    st4commission FLOAT,
    st5affiliateid INTEGER UNSIGNED,
    st5commission FLOAT,
    st6affiliateid INTEGER UNSIGNED,
    st6commission FLOAT,
    st7affiliateid INTEGER UNSIGNED,
    st7commission FLOAT,
    st8affiliateid INTEGER UNSIGNED,
    st8commission FLOAT,
    st9affiliateid INTEGER UNSIGNED,
    st9commission FLOAT,
    st10affiliateid INTEGER UNSIGNED,
    st10commission FLOAT,
    CONSTRAINT PK_wd_pa_recurringcommissions PRIMARY KEY (recurringcommid),
    KEY IDX_wd_pa_recurringcommissions1(campcategoryid),
    KEY IDX_wd_pa_recurringcommissions2(affiliateid),
    KEY IDX_wd_pa_recurringcommissions3(originaltransid),
    UNIQUE KEY IDX_wd_pa_recurringcommissions4(recurringcommid)
);

CREATE TABLE wd_pa_accounting (
    accountingid CHAR(8) NOT NULL,
    dateinserted DATETIME NOT NULL,
    datefrom DATETIME NOT NULL,
    dateto DATETIME NOT NULL,
    note TEXT,
    rfile VARCHAR(200),
    mbfile VARCHAR(100),
    wirefile VARCHAR(100),
    CONSTRAINT PK_wd_pa_accounting PRIMARY KEY (accountingid),
    UNIQUE KEY IDX_wd_pa_accounting1(accountingid)
);

CREATE TABLE wd_g_groups (
    groupid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rstatus TINYINT NOT NULL,
    product VARCHAR(10) NOT NULL,
    dateinserted DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    parentgroupid CHAR(8),
    leftnumber INTEGER,
    rightnumber INTEGER,
    CONSTRAINT PK_wd_g_groups PRIMARY KEY (groupid),
    UNIQUE KEY IDX_wd_g_groups1(groupid),
    KEY IDX_wd_g_groups2(parentgroupid)
);

CREATE TABLE wd_g_usergroups (
    usergroupid CHAR(8) NOT NULL,
    userid CHAR(8) NOT NULL,
    groupid CHAR(8) NOT NULL,
    CONSTRAINT PK_wd_g_usergroups PRIMARY KEY (usergroupid),
    KEY IDX_wd_g_usergroups1(userid),
    KEY IDX_wd_g_usergroups2(groupid)
);

CREATE TABLE wd_nl_newsletters (
    newsletterid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    subject TEXT,
    plaintext TEXT,
    htmltext TEXT,
    encoding VARCHAR(100) NOT NULL,
    dateinserted DATETIME,
    CONSTRAINT PK_wd_nl_newsletters PRIMARY KEY (newsletterid)
);

CREATE TABLE wrapper_servers (
    serverid INTEGER NOT NULL AUTO_INCREMENT,
    textid VARCHAR(250) NOT NULL,
    max_processes INTEGER DEFAULT 10,
    enabled VARCHAR(1) NOT NULL,
    PRIMARY KEY (serverid),
    UNIQUE KEY IDX_Entity_11(textid),
    UNIQUE KEY IDX_wrapper_servers2(serverid)
);

CREATE TABLE wrapper_processes (
    processid VARCHAR(32) NOT NULL,
    serverid INTEGER NOT NULL,
    started DATETIME NOT NULL,
    last_loop DATETIME NOT NULL,
    enabled VARCHAR(1) NOT NULL,
    PRIMARY KEY (processid, serverid),
    KEY IDX_wrapper_processes1(serverid),
    UNIQUE KEY IDX_wrapper_processes2(processid, serverid)
);

CREATE TABLE wrapper_schedule (
    schedule_id INTEGER NOT NULL AUTO_INCREMENT,
    scriptid INTEGER,
    serverid INTEGER,
    processid VARCHAR(32),
    created DATETIME NOT NULL,
    schedule_at DATETIME NOT NULL,
    started DATETIME,
    finished DATETIME,
    context_vars TEXT,
    priority INTEGER,
    result VARCHAR(1) NOT NULL,
    logger LONGTEXT,
    PRIMARY KEY (schedule_id),
    KEY IDX_wrapper_schedule1(processid, serverid),
    KEY IDX_wrapper_schedule2(scriptid)
);

CREATE TABLE wrapper_categories (
    catid INTEGER NOT NULL AUTO_INCREMENT,
    title VARCHAR(250) NOT NULL,
    PRIMARY KEY (catid),
    UNIQUE KEY IDX_Entity_11(title),
    UNIQUE KEY IDX_wrapper_categories2(catid)
);

CREATE TABLE wrapper_scripts (
    scriptid INTEGER NOT NULL AUTO_INCREMENT,
    catid INTEGER,
    title VARCHAR(250) NOT NULL,
    script TEXT NOT NULL,
    last_modification DATETIME NOT NULL,
    confirmation VARCHAR(1) NOT NULL,
    logger_level VARCHAR(32),
    PRIMARY KEY (scriptid),
    UNIQUE KEY IDX_wrapper_scripts1(title),
    KEY IDX_wrapper_scripts2(catid),
    UNIQUE KEY IDX_wrapper_scripts3(scriptid)
);

CREATE TABLE wd_pa_payoutoptions (
    payoptid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    exporttype TINYINT NOT NULL,
    exportformat TEXT,
    disabled TINYINT NOT NULL DEFAULT 0,
    langid VARCHAR(80) NOT NULL,
    rorder TINYINT NOT NULL,
    paybuttonformat TEXT,
    PRIMARY KEY (payoptid),
    UNIQUE KEY IDX_wd_pa_payoutoptions1(payoptid),
    KEY IDX_wd_pa_payoutoptions2(accountid)
);

CREATE TABLE wd_pa_payoutfields (
    payfieldid CHAR(8) NOT NULL,
    payoptid CHAR(8) NOT NULL,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(40) NOT NULL,
    langid VARCHAR(80) NOT NULL,
    rtype TINYINT NOT NULL,
    mandatory TINYINT NOT NULL DEFAULT 0,
    visible TINYINT NOT NULL,
    availablevalues TEXT,
    rorder TINYINT UNSIGNED NOT NULL,
    value TEXT,
    PRIMARY KEY (payfieldid),
    KEY IDX_wd_pa_payoutfields1(payoptid)
);

CREATE TABLE wd_g_listviews (
    viewid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    userid CHAR(8) NOT NULL,
    name VARCHAR(30) NOT NULL,
    rcolumns TEXT NOT NULL,
    listname VARCHAR(60) NOT NULL,
    PRIMARY KEY (viewid, accountid, userid),
    KEY IDX_wd_g_listviews1(accountid),
    KEY IDX_wd_g_listviews2(userid)
);

CREATE TABLE wd_g_messages (
    messageid CHAR(8) NOT NULL,
    rtype TINYINT NOT NULL,
    dateinserted DATETIME NOT NULL,
    title VARCHAR(100) NOT NULL,
    rtext TEXT NOT NULL,
    deleted TINYINT NOT NULL DEFAULT 0,
    accountid CHAR(8),
    PRIMARY KEY (messageid),
    KEY IDX_wd_g_messages1(accountid),
    UNIQUE KEY IDX_wd_g_messages2(messageid)
);

CREATE TABLE wd_g_messagestousers (
    messagetouserid CHAR(8) NOT NULL,
    messageid CHAR(8),
    userid CHAR(8),
    email VARCHAR(80),
    rstatus TINYINT NOT NULL,
    PRIMARY KEY (messagetouserid),
    KEY IDX_wd_g_messagestousers1(messageid),
    KEY IDX_wd_g_messagestousers2(userid)
);

CREATE TABLE wd_pa_rules (
    ruleid CHAR(8) NOT NULL,
    name VARCHAR(100),
    cond_when VARCHAR(20),
    cond_in VARCHAR(20),
    cond_is VARCHAR(20),
    cond_value1 VARCHAR(40),
    cond_value2 VARCHAR(40),
    cond_action VARCHAR(40),
    cond_action_value VARCHAR(100),
    accountid CHAR(8) NOT NULL,
    campaignid CHAR(8) NOT NULL,
    PRIMARY KEY (ruleid, accountid, campaignid),
    KEY IDX_wd_pa_rules1(accountid),
    KEY IDX_wd_pa_rules2(campaignid)
);

#========================================================================== #
#  Foreign Keys                                                             #
#========================================================================== #

ALTER TABLE wd_g_history
    ADD CONSTRAINT wd_g_accounts_wd_g_history FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_righttypes
    ADD FOREIGN KEY (parentrighttypeid) REFERENCES wd_g_righttypes (righttypeid);

ALTER TABLE wd_g_userprofiles
    ADD CONSTRAINT wd_g_userprofiles_wd_g_accounts FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_userrights
    ADD CONSTRAINT pa_userprofiles_pa_adminrights FOREIGN KEY (userprofileid) REFERENCES wd_g_userprofiles (userprofileid);

ALTER TABLE wd_g_userrights
    ADD CONSTRAINT pa_righttypes_pa_adminrights FOREIGN KEY (righttypeid) REFERENCES wd_g_righttypes (righttypeid);

ALTER TABLE wd_g_settings
    ADD CONSTRAINT pa_accounts_pa_settings FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_settings
    ADD CONSTRAINT pa_affiliates_pa_settings FOREIGN KEY (userid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_campaigns
    ADD CONSTRAINT wd_g_accounts_wd_pa_campaigns FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_users
    ADD CONSTRAINT wd_g_accounts_wd_pa_affiliates FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_users
    ADD CONSTRAINT wd_g_userprofiles_wd_g_users FOREIGN KEY (userprofileid) REFERENCES wd_g_userprofiles (userprofileid);

ALTER TABLE wd_g_users
    ADD FOREIGN KEY (parentuserid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_g_users
    ADD FOREIGN KEY (payoptid) REFERENCES wd_pa_payoutoptions (payoptid);

ALTER TABLE wd_g_users
    ADD FOREIGN KEY (originalparentid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_campaigncategories
    ADD CONSTRAINT pa_campaigns_pa_campaigncategories FOREIGN KEY (campaignid) REFERENCES wd_pa_campaigns (campaignid);

ALTER TABLE wd_pa_banners
    ADD CONSTRAINT pa_campaigns_pa_banners FOREIGN KEY (campaignid) REFERENCES wd_pa_campaigns (campaignid);

ALTER TABLE wd_pa_impressions
    ADD CONSTRAINT pa_banners_pa_impressions FOREIGN KEY (bannerid) REFERENCES wd_pa_banners (bannerid);

ALTER TABLE wd_pa_impressions
    ADD CONSTRAINT pa_affiliates_pa_impressions FOREIGN KEY (affiliateid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_impressions
    ADD CONSTRAINT wd_g_accounts_wd_pa_impressions FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_banners_pa_transactions FOREIGN KEY (bannerid) REFERENCES wd_pa_banners (bannerid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_affiliates_pa_transactions FOREIGN KEY (affiliateid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_affiliatecategories_pa_transactions FOREIGN KEY (campcategoryid) REFERENCES wd_pa_campaigncategories (campcategoryid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_transactions_pa_transactions FOREIGN KEY (parenttransid) REFERENCES wd_pa_transactions (transid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_recurringcommissions_pa_transactions FOREIGN KEY (recurringcommid) REFERENCES wd_pa_recurringcommissions (recurringcommid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT pa_accounting_pa_transactions FOREIGN KEY (accountingid) REFERENCES wd_pa_accounting (accountingid);

ALTER TABLE wd_pa_transactions
    ADD CONSTRAINT wd_g_accounts_wd_pa_transactions FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_pa_affiliatescampaigns
    ADD CONSTRAINT pa_campaigncategories_pa_affiliatescampaigns FOREIGN KEY (campcategoryid) REFERENCES wd_pa_campaigncategories (campcategoryid);

ALTER TABLE wd_pa_affiliatescampaigns
    ADD CONSTRAINT pa_affiliates_pa_affiliatescampaigns FOREIGN KEY (affiliateid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_affiliatescampaigns
    ADD FOREIGN KEY (campaignid) REFERENCES wd_pa_campaigns (campaignid);

ALTER TABLE wd_pa_recurringcommissions
    ADD CONSTRAINT pa_campaigncategories_pa_recurringcommissions FOREIGN KEY (campcategoryid) REFERENCES wd_pa_campaigncategories (campcategoryid);

ALTER TABLE wd_pa_recurringcommissions
    ADD CONSTRAINT pa_affiliates_pa_recurringcommissions FOREIGN KEY (affiliateid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_recurringcommissions
    ADD CONSTRAINT pa_transactions_pa_recurringcommissions FOREIGN KEY (originaltransid) REFERENCES wd_pa_transactions (transid);

ALTER TABLE wd_g_groups
    ADD FOREIGN KEY (parentgroupid) REFERENCES wd_g_groups (groupid);

ALTER TABLE wd_g_usergroups
    ADD CONSTRAINT wd_g_users_wd_g_usergroups FOREIGN KEY (userid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_g_usergroups
    ADD CONSTRAINT wd_g_groups_wd_g_usergroups FOREIGN KEY (groupid) REFERENCES wd_g_groups (groupid);

ALTER TABLE wrapper_processes
    ADD FOREIGN KEY (serverid) REFERENCES wrapper_servers (serverid);

ALTER TABLE wrapper_schedule
    ADD FOREIGN KEY (processid,serverid) REFERENCES wrapper_processes (processid, serverid);

ALTER TABLE wrapper_schedule
    ADD FOREIGN KEY (scriptid) REFERENCES wrapper_scripts (scriptid);

ALTER TABLE wrapper_scripts
    ADD FOREIGN KEY (catid) REFERENCES wrapper_categories (catid);

ALTER TABLE wd_pa_payoutoptions
    ADD FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_pa_payoutfields
    ADD FOREIGN KEY (payoptid) REFERENCES wd_pa_payoutoptions (payoptid);

ALTER TABLE wd_g_listviews
    ADD FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_listviews
    ADD FOREIGN KEY (userid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_g_messages
    ADD FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_g_messagestousers
    ADD FOREIGN KEY (messageid) REFERENCES wd_g_messages (messageid);

ALTER TABLE wd_g_messagestousers
    ADD FOREIGN KEY (userid) REFERENCES wd_g_users (userid);

ALTER TABLE wd_pa_rules
    ADD FOREIGN KEY (accountid) REFERENCES wd_g_accounts (accountid);

ALTER TABLE wd_pa_rules
    ADD FOREIGN KEY (campaignid) REFERENCES wd_pa_campaigns (campaignid);
