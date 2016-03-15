<?php

class Affiliate_Merchants_Bl_TransactionModel {
	var $transid;
	var $errorcode;
	var $data_set = array();
	var $type = null;
	
	function Affiliate_Merchants_Bl_TransactionModel(){
		$this->data_set = array('transid' => null, 
	'accountid' => null, 
	'rstatus' => null, 
	'dateinserted' => null, 
	'dateapproved' => null, 
	'transtype' => null, 
	'payoutstatus' => null,  
	'datepayout' => null,  
	'cookiestatus' => null,  
	'orderid' => null,  
	'totalcost' => null,  
	'bannerid' => null,  
	'transkind' => null,  
	'refererurl' => null,  
	'affiliateid' => null,  
	'campcategoryid' => null,  
	'parenttransid' => null,  
	'commission' => null,  	
	'ip' => null,  
	'recurringcommid' => null,  	
	'accountingid' => null,  
	'productid' => null,  
	'data1' => null,  
	'data2' => null,  
	'data3' => null,  
	'channel' => null,  
	'episode' => null,  
	'timeslot' => null,  
	'exit' => null,  
	'sid' => null,  
	'provideractionname' => null,  
	'providerorderid' => null,  
	'providertype' => null,  
	'providereventdate' => null,  
	'providerprocessdate' => null,  
	'merchantname' => null,  
	'providerid' => null,  
	'merchantsales' => null,  
	'quantity' => null,  
	'providerchannel' => null,  
	'estimatedrevenue' => null,  
	'dateestimated' => null,  
	'dateactual' => null,  
	'estimateddatafilename' => null,  
	'actualdatafilename' => null,  
	'providerstatus' => null,  
	'providercorrected' => null,  
	'providerwebsiteid' => null,  
	'providerwebsitename' => null,  
	'provideractionid' => null,  
	'modifiedby' => null, 
	'reftrans' => null,
	'reversed' => 0,
	'dateadjusted' => null,
		);
		
	}
}
?>