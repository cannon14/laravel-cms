<?php
/**
 * 
 * Clicker Class
 * 
 * This class will emulate a click to a provided url.
 * If the click is successful it will return the transid
 * of the click from the transactions table.
 * 
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */


class Clicker 
{	
	var $url;
	var $errors;
	var $errorEncounted;
    
    function Clicker($url, $pid = null) 
    {
		$this->url = $url;
		$this->url .= '?'.$pid;
		$this->errors = array();
    	$this->errorEncountered = false;
    	
    	sleep(1);
    	
    	//return $this->url;
    }	
    
    function click()
    {	
 	   $ch = curl_init();
		   
		curl_setopt($ch, CURLOPT_URL, $this->url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$shh = curl_exec($ch);
		if (curl_errno($ch)) {
			$this->_handleError(curl_error($ch));
		}
		curl_close($ch);
	   
		if(!$this->errorEncountered)
			return TransListener::peek();
		else 
			return null;		
    }
    
    function getErrors()
    {
    	$errors = $this->errors;
    	$this->errors = array();
    	$this->encounteredErrors = false;
    	
    	return $errors;
    }
    
    function _handleError($error)
    {
    	$this->errorEncountered;
    	$this->errors[] = $error;	
    }
}



class NFClicker extends Clicker
{
    function NFClicker($url, $pid = null, $aid='', $tid='') 
    {
		$this->url = $url;
		$this->url = $url;
		$this->url .= '?'.$pid;
		$this->aid = $aid;
		$this->tid = $tid;
		$this->errors = array();
    	$this->errorEncountered = false;
    	
    	sleep(1);
    	
    	//return $this->url;
    }	
	
	
	function click()
    {	
 	   $ch = curl_init();
 	   
 	   //println("click: " . BASE_URL.'?a_aid='.$this->aid.'&tid='.$this->tid);
	    
	    curl_setopt($ch, CURLOPT_URL, BASE_URL.'?a_aid='.$this->aid.'&tid='.$this->tid);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE);
	    curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    $collectOut = curl_exec($ch);
	    

	
	    curl_setopt($ch, CURLOPT_URL, $this->url);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE);
	    $data = curl_exec($ch);
	    
		$file = fopen(COOKIE, "w+");
	    fclose($file);
       
		curl_close($ch);
		
		return TransListener::peek();	
    }
}


class TransListener
{
	function peek()
	{
		$sql = 'SELECT transid FROM ' . TRANS_TABLE . ' ORDER BY dateinserted DESC LIMIT 1';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields['transid'];
	}
}
?>