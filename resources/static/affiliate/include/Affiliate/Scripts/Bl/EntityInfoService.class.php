<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Scripts_Bl_EntityInfoService 
{

    function Affiliate_Scripts_Bl_EntityInfoService() 
    {
    }
    
    function processRequest($entity, $id)
    {
    	switch($entity){
    		
    		case 'trafficSource':
    			
    			return $this->_getTrafficSourceInfo($id);
    		break;
    		default:
    			return $this->_throwError('Entity ' . $entity . ' not defined!');
    		break;
    	}
    }
    
    function _getTrafficSourceInfo($id)
    {
    	$affiliate = Affiliate_Merchants_Bl_Affiliate::getTrafficSourceById($id);
    	
    	$ret = '';
    	
    	if(is_array($affiliate) && count($affiliate > 0)){
	    	foreach($affiliate as $col => $val){
	    		$ret .= $col . ': ' . $val . '<br />';
	    	}
    	}else{
    		$ret = $this->_throwError("No data found!");
    	}
    	
    	return $ret;
    }
    
    function _throwError($msg)
    {
    	return 'ERROR: ' . $msg;
    }
}
?>