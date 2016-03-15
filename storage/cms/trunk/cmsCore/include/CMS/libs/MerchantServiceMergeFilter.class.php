<?php
/**
 * 
 * CreditCards.com
 * March 14, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
csCore_Import::importClass('csCore_Util_DataMerger');
class CMS_libs_MerchantServiceMergeFilter
{

	var $merger;
	
	/**
	 * Constructor:  Setup up a map array, defines the table needed, and creates an internal merger 
	 * @author Jason Huie
	 * @version 1.0
	 */
    function CMS_libs_MerchantServiceMergeFilter() 
    {
    	$mapArray = array	(
								'setup_fee'			=>	'setup_fee',
								'monthly_minimum' 	=>	'monthly_minimum',
								'gateway_fee' 		=>	'gateway_fee', 
								'statement_fee'  	=>	'statement_fee',
								'discount_rate' 	=>	'discount_rate',
								'transaction_fee' 	=>	'transaction_fee',
								'tech_support_fee' 	=>	'tech_support_fee',
							);
							
    	
    	$table = "merchant_service_data";
    	
    	$this->merger = new csCore_Util_DataMerger("@@", $mapArray, $table, 'merchant_service_id');
    }
    
    /**
	 * Call the internal merger parseString method 
	 * @author Jason Huie
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