<?
/**
*
*   @author webradev.com
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

class QCore_Constants
{
	private static $_initialized = false;

    public static function initConstants()
    {

	    if(self::$_initialized) {
		    return true;
	    }

		define('QUERY_NF', 1);
		define('QUERY_CCCOM', 2);
        
        define('PRODUCT_AFFILIATE', 'affiliate');
        
        define('DEFAULT_ACCOUNT', 'default1');
        define('DEFAULT_USER_PROFILE', 'default1');
        
        define('AFFSTATUS_NOTAPPROVED', 1);
        define('AFFSTATUS_APPROVED',    2);
        define('AFFSTATUS_SUPPRESSED',  3);
        
        define('WD_MAX_PROCESSED_IDS', 50);
        
        define('APPROVE_MANUAL',    1);
        define('APPROVE_AUTOMATIC', 2);
        
        define('ERRORCODE_NOTRANSID', 		 101);
        define('ERRORCODE_DUPTRANSID',    	 102);
        define('ERRORCODE_NOREVENUE',        103);
        define('ERRORCODE_NOTRANSIDCLICK',	 104);
        define('ERRORCODE_MISSINGFIELDS',  	 105);
        define('ERRORCODE_VERIFYRATE',  	 106);
        define('ERRORCODE_NEGATIVEREVENUE',  108);
        define('ERRORCODE_INSERT_DATE',      107);
        define('ERRORCODE_PROCESS_DATE',     109);
        define('ERRORCODE_EVENT_DATE',       110);
        define('ERRORCODE_ESTIMATED_DATE',   111);
        define('ERRORCODE_NOCOMMISSION',	 112);
        
        define('WLOG_NOTHING',   0);
        define('WLOG_DBERROR',   1);
        define('WLOG_ERROR',     2);
        define('WLOG_ACTIONS',   4);
        define('WLOG_DEBUG',     8);
        
        define('STATUS_ENABLED',     '0');
        define('STATUS_DISABLED',    '1');
        
        define('USERTYPE_SUPERADMIN',   1);
        define('USERTYPE_ACCOUNT',      2);
        define('USERTYPE_ADMIN',        3);
        define('USERTYPE_USER',         4);
        
        define('SETTINGTYPE_GLOBAL',       1);
        define('SETTINGTYPE_SUPERADMIN',   2);
        define('SETTINGTYPE_ACCOUNT',      3);
        define('SETTINGTYPE_ADMIN',        4);
        define('SETTINGTYPE_USER',         5);
        define('SETTINGTYPE_AFF_CAMP',     6);
        
        define('SETTINGTYPEPREFIX_GLOBAL',       'Glob_');
        define('SETTINGTYPEPREFIX_SUPERADMIN',   'SupA_');
        define('SETTINGTYPEPREFIX_ACCOUNT',      'Aff_');
        define('SETTINGTYPEPREFIX_ADMIN',        'Admn_');
        define('SETTINGTYPEPREFIX_USER',         'User_');
        define('SETTINGTYPEPREFIX_AFF_CAMP',     'Aff_camp_');
        define('SETTINGTYPEPREFIX_LISTVIEW',     'List_view_');

        define('MESSAGETYPE_EMAIL',   1);
        define('MESSAGETYPE_NEWS',    2);
        
        define('MESSAGESTATUS_NOT_READED',  1);
        define('MESSAGESTATUS_SHOW',        2);
        define('MESSAGESTATUS_NOT_SHOW',    3);

        define('EMAILBY_MAIL',    1);
        define('EMAILBY_SMTP',    2);
        
        define('REDIRECT_RULE_SEND', 1);
        define('REDIRECT_RULE_NO_SEND', 2);
        define('REDIRECT_RULE_SEND_W_SLASHES', 3);
        define('REDIRECT_RULE_SEND_OFFER', 4);
        define('REDIRECT_RULE_NO_SEND_OFFER', 5);    
        
        define('REVENUE_PATH', '/mnt/ccfinance/revenue/');
        //define('REVENUE_PATH', '/home/jasonh/revenue/');
        //define('REVENUE_PATH', 'C:/ccdev/ccfinance/revenue/');
        define('EXPENSE_PATH', '/mnt/ccfinance/expense/');
        //define('EXPENSE_PATH', '/home/jasonh/expense/');
        //define('EXPENSE_PATH', 'C:/ccdev/ccfinance/expense/');
        
        define('UPLOAD_ERROR_TABLE', 			'transactions_upload_errors');
        define('UPLOAD_TABLE', 					'transactions_upload');
        define('UPLOAD_CCCOM_TABLE', 			'transactions_cccom');
        
        define('RATE_TABLE', 					'card_revenue_rates');
        define('PROVIDER_TABLE', 				'providers');
        
        define('KEYWORDS_TABLE', 				'keywords');
        define('KEYWORD_TEXT_TABLE', 			'keyword_text');
        
        define('TRACKERS_TABLE',				'trackers');
        
        define('EXPENSE_NETWORK_TABLE', 		'expenses_networks');
        define('EXPENSE_UPLOAD_TABLE', 			'expenses_upload');
        define('EXPENSE_UPLOAD_ERROR_TABLE', 	'expenses_upload_errors');
        define('EXPENSE_TABLE', 				'expenses');
        
		define('CAMPAIGNS_TABLE', 				'cms_cards');
		define('CAMPAIGN_CATEGORIES_TABLE', 	'wd_pa_campaigncategories');
		
		define('USERS_TABLE', 					'partner_affiliates');
		
		define('TRANS_TABLE', 					'transactions');
		define('TRANS_ERROR_TABLE', 			'wd_pa_transactions_errors');
		define('MERCHANTS_TABLE',				'merchants');		
		define('TRANS_REPORTING_TABLE', 		'transactions_reporting');
		define('TRANS_DELETED_TABLE', 			'transactions_deleted');
		
		define('TABLE_CAMPAIGN_RATE_GROUPS',	'campaign_rate_groups');
		define('TABLE_CAMPAIGN_RATE_GROUPS_MAP','campaign_rate_groups_map');
		define('TABLE_TRANS_RECENT', 			'transactions_recent');
		
        define('NETFINITI_AID', '1042');
        
		define('CAMPCATID_WIRED', 	'22354503');
		define('CAMPCATID_VAYA', 	'22344502');
		define('CAMPCATID_ASPIRE', 	'22044418');
		
		define('TRANS_STATUS_APPROVED', 	2);
		define('TRANS_KIND_DEFAULT', 		1);
		
		define('EXPENSE_DEFAULT_CID', 				1000);
		define('EXPENSE_DEFAULT_DID', 				9999);
		
		define('SEND_WITH_TRANS_ID', 			1);
		define('SEND_WITHOUT_TRANS_ID', 		2);
		define('SEND_WITH_TRANS_ID_AND_SLASH', 	3);
		define('SEND_OFFER_WITH_TRANS_ID', 		4);
		define('SEND_OFFER_WITH_NO_TRANS_ID', 	5);
		
		define('AFFILIATE_TYPE_TRAFFIC_SOURCE', 'TRAFFIC_SOURCE');
		
		//CHAMELEON Affiliate
		define('CHAMELEON_AFFILIATE', '1059');

	    self::$_initialized = true;

	    return true;
    }
}