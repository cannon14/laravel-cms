<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 22, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
 csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
 csCore_Import::importClass('csCore_Util_CsvWriter');
 
class CMS_view_ExportRates extends CMS_pages_cmsRestrictedPage
{

    function process() 
    {
    	$csvWriter = new csCore_Util_CsvWriter();
    	
    	$exportLoc = $this->settings->getSetting('CMS_xml_dir');
    	$exportUrl = $this->settings->getSetting('CMS_xml_url');
    	
    	$sql = "SELECT d.*, c.cardTitle FROM cs_carddata as d LEFT JOIN rt_cards as c ON (d.cardId = c.cardId) WHERE c.deleted != 1";
    	$orderBy = " ORDER BY c.cardTitle ASC";
 		
 		$columns = array('cardId', 'cardTitle', 'introApr', 'introAprPeriod', 'regularApr', 'monthlyFee', 'annualFee', 'balanceTransfers',  'creditNeeded');
    	
    	$csvWriter->buildFromSql($sql.$orderBy, $columns);
		
    	$csvWriter->writeCsvFile($exportLoc.'/rates.csv');
    	
    	if($csvWriter->encounteredError){
    		print_r($csvWriter->errors);	
    	}else{
    		CMS_libs_History::write($this->auth->username, "Exported rates CSV");
    		echo "<center><b><a href='".$exportUrl."/rates.csv'>Click Here to download CSV</a></b></center>";
    	}
    	
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_csvExports');	
    }  
}
?>