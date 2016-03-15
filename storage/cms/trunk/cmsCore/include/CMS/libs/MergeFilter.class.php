<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 17, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
csCore_Import::importClass('csCore_Util_DataMerger');
class CMS_libs_MergeFilter
{

	var $merger;
	
	/**
	 * Constructor
	 * @author Patrick Mizer
	 * @version 1.0
	 */
    function CMS_libs_MergeFilter() 
    {
    	$mapArray = array	(
							"introApr" 			=>	"introApr",
							"introAprPeriod" 	=> 	"introAprPeriod",
							"regularApr" 		=> 	"regularApr",
							"annualFee" 		=>	"annualFee",
							"monthlyFee" 		=>	"monthlyFee",
							"annualFee"			=>  "annualFee",
							"balanceTransfers" 	=> 	array(
														"0" => "N/A",
														"1" => "Yes",
													),
							"balanceTransferFee" => "balanceTransferFee",
							"balanceTransferIntroApr" => "balanceTransferIntroApr",
							"balanceTransferIntroAprPeriod" => "balanceTransferIntroAprPeriod",
							"creditNeeded" 		=>	array(
														"0" => "No Credit Check",
														"1" => "Bad Credit",
														"2" => "Fair Credit",
														"3" => "Good Credit",
														"4" => "Excellent Credit",
													),
							);
							
    	
    	$table = "cs_carddata";
    	
    	$this->merger = new csCore_Util_DataMerger("@@", $mapArray, $table);
    }
    
    /**
	 * Call the internal merger parseString method 
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Fields to be merged
	 * @param int Merchant Service ID
	 * @return array Merged results
	 */
    function translate($string, $id){
    	$res = $this->merger->parseString($string, $id);
    	return $res;
    }
}
?>