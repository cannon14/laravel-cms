<?php

	function getLabel(){
		$modMap = array(	'Affiliate_Merchants_Views_MerchantProfile' => 'Account Overview',
							'Affiliate_Merchants_Views_CampaignManager' => 'Product Manager',
							'Affiliate_Merchants_Views_CampaignCategoryGroupsManager' => 'Product Groups Manager',
							'Affiliate_Merchants_Views_BannerManager' => 'Ad Units Manager',
							'Affiliate_Merchants_Views_AffiliateManager' => 'Traffic Sources Manager',
							'Affiliate_Merchants_Views_AppliedAffiliate' => 'Applied Traffic Source',
							'Affiliate_Merchants_Views_AffiliateGroupsManager' => 'Traffic Source Groups Manager',
							'Affiliate_Merchants_Views_AffiliatePayments' => 'Pay Traffic Source',
							'Affiliate_Merchants_Views_Accounting' 				=> 'Accounting',
							'Affiliate_Merchants_Views_MerchantReports' 		=> '',
							'Affiliate_Merchants_Views_TransactionManager' 		=> 'Transactions Manager',
							'Affiliate_Merchants_Views_ExpensesManager' 		=> 'Expenses Manager',
							'Affiliate_Merchants_Views_AffEmailTemplates'		=> 'Email Templates',
							'Affiliate_Merchants_Views_Communications' 			=> 'Communications',
							'Affiliate_Merchants_Views_BroadcastMessage' 		=> 'Broadcast Message',
							'Affiliate_Merchants_Views_AdminsManager' 			=> 'Admin Accounts',
							'Affiliate_Merchants_Views_UserProfiles' 			=> 'User Roles',
							'Affiliate_Merchants_Views_Settings' 				=> 'Settings',
							'Affiliate_Merchants_Views_History' 				=> 'History and Error Log.',
							'Affiliate_Merchants_Views_TrackingManager' 		=> 'Trackers',
							'Affiliate_Merchants_Views_CsvParser2' 				=> 'UPLOAD Statement',
							'Affiliate_Merchants_Views_CustomMappings' 			=> 'Manage Custom Mappings',
							'Affiliate_Merchants_Views_QueryTool' 				=> 'Query Transactions',
							'Affiliate_Merchants_Views_TransactionErrors' 		=> 'Transactions Error Log',
							'Affiliate_Merchants_Views_AdjustmentsLog' 			=> 'Adjustments Log',
							'Affiliate_Merchants_Views_ExpenseCsvParser2' 		=> 'UPLOAD Expenses',
							'Affiliate_Merchants_Views_ExpensesManager' 		=> 'Query Expenses',
							'Affiliate_Merchants_Views_ExpensesErrorsManager' 	=> 'Expenses Error Log',
							'Affiliate_Merchants_Views_SearchManager' 			=> 'Search Manager'
		);
		
		$reportType = array (	'traffic' 			=> 'Traffic & Sales Reporting',
								'quick' 			=> 'Quick Report',
								'top20affiliates' 	=> 'Top Providers',
								'affiliatecounts' 	=> 'Number of Providers',
								'transactions'		=> 'Transactions',
								'atransactions'		=> 'All Transactions',
								'atraffic'			=> 'Traffic & Sales Reporting - All');
		
		$ret = $modMap[$_REQUEST['md']];
		$ret .= ($_REQUEST['md'] == 'Affiliate_Merchants_Views_MerchantReports' ? $reportType[$_REQUEST['reporttype']] : "");
		
		return $ret;
	} 
	
	if($GLOBALS['Auth']->getUserID() != '')
		$_SESSION['modName'] = getLabel();
	else{
		$_SESSION['modName'] = null;	
	}
?>
