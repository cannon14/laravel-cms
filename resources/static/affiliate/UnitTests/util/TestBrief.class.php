<?php
class TestBrief 
{
	var $name;
	var $format;
	var $tests;
	var $data;
	var $_transid;
	var $_lastValid;
	var $_commission;
	var $transactions;
	var $headerSpace;
	var $hideHeaders;
	
	var $testTypes 		= array(CCCOM, 
								NF_CO, 
								NF_BANNER);
								
	var $transTypes 	= array(VALID_TRANS,
								ERR_101, 
								ERR_102, 
								ERR_103, 
								ERR_104
								); 

    function TestBrief($scriptname, $scriptdir = '') 
    {
    	$scriptdir = ($scriptdir == '' ? SCRIPT_DIR : $scriptdir);
    	
    	$ini = parse_ini_file($scriptdir.'/'.$scriptname, true);
    	
    	$this->name			= $ini['script_info']['name'];
    	
    	$this->format		= $ini['script_info']['format'];
    	$this->headerSpace 	= ($ini['script_info']['headerspace'] == null ? 1 : $ini['script_info']['headerspace']);
		$this->hideHeaders 	=  $ini['script_info']['hideheaders'];
		
		foreach($this->testTypes as $type){
			foreach($ini[$type] as $trans => $qty)
				$this->tests[$type][$trans] = $qty;
		}
		    	
    	foreach($ini['data_mapping'] as $col=>$val)
    		$this->data[$this->_paren($col)] = $val;
    }
    
    function compile()
    {

    	foreach($this->transTypes as $trans){
    		$this->_buildCCCOMTrans(CCCOM, $trans, $this->tests[CCCOM][$trans]);
    	}
    	
    	foreach($this->transTypes as $trans){
    		$this->_buildCoBrandTrans(NF_CO, $trans, $this->tests[NF_CO][$trans]);
    	}    	
    	
    	foreach($this->transTypes as $trans){
    		$this->_buildNFBannerTrans(NF_BANNER, $trans, $this->tests[NF_BANNER][$trans]);
    	}     	
 
    	$this->_writeFile();
    }
    
    function _writeFile()
    {
    	switch($this->format)
    	{
    		case 'csv' :
    			$delim = ',';
    			$quotes = "";
    		break;
    		
    		case 'txt' : 
    			$delim = "\t";
    			$quotes = "";
    		break;		
    	}
		
		$datafileWriter = new DataFile($delim, $quotes);
    	
    	$headers = array_keys($this->data);
    	
    	if($this->hideHeaders){
    		for($i = 0; $i < count($headers); ++$i){
    			$headers[$i] = "";
    		}
    	}
    	
    	if($this->headerSpace < 1){
    		$headers = null;
    	}
    
    	if($this->headerSpace > 1){
    		$padding = null;
    		for($i = 0; $i < count($headers); ++$i)
    			$padding[$i] = "";
    		for($c = 1; $c < $this->headerSpace; ++$c){
    			$datafileWriter->appendRow($padding);
    		}
    	}
    	
    	if($headers != null)
    		$datafileWriter->appendRow($headers); 
    	
    	foreach($this->transactions as $trans){
    		$datafileWriter->appendRow($trans);
    	}    	
    	
    	$filename = UPLOAD_FILE_DIR.'/'.$this->name.'/raw_dump/'.date('Ymd').'_'.$this->name.'.'.$this->format;

    	//$filename = 'tmp/'.$this->name.'.'.$this->format;
    	
    	if($this->format == 'xls'){
    		DataFile2XlsCoverter::convert($datafileWriter, $filename);
    	}
    	else
    		$datafileWriter->writeFile($filename);
    }
    
    function _buildCCCOMTrans($testType, $transType, $qty)
    {
    	$transType = trim($transType);
    	
    	$clicker = new Clicker(URL, ($transType == ERR_103 ? INVALID_RATE : VALID_RATE));
		
		$this->_transid = ($transType == ERR_101 ? '' : $clicker->click());
		$this->_transid = ($transType == ERR_104 ? substr(md5($this->_transid), 0, 30) : $this->_transid);
		$this->_commission = ($transType == ERR_103 ? '' : rand(1, 20));
		
		if($transType == VALID_TRANS){
			$this->_lastValid = $this->_transid;
		}		
				
		$this->_transid = ($transType == ERR_102 ? $this->_lastValid : $this->_transid);
		
		//println($transType . ": " . $clicker->url);
		//println($this->_transid . "<br />--------------------<br />");
		
		for($i = 0; $i < $qty; ++$i){
			foreach($this->data as $col => $val){
				$data[$col] = $this->_eval($val);
			}
			$this->transactions[] = $data; 
		}
    }
    
    function _buildCoBrandTrans($testType, $transType, $qty)
    {
    	$transid = '97t' . substr(md5(date('Y-m-d h:i:s') . rand(0, 100)), 0, 27);
		$this->_transid = ($transType == ERR_101 ? '' : $transid);
		$this->_commission = ($transType == ERR_103 ? '' : rand(1, 20));
		
		if($transType == VALID_TRANS){
			$this->_lastValid = $this->_transid;
		}		
				
		$this->_transid = ($transType == ERR_102 ? $this->_lastValid : $this->_transid);
		
		for($i = 0; $i < $qty; ++$i){
			foreach($this->data as $col => $val){
				$data[$col] = $this->_eval($val);
			}
			$this->transactions[] = $data; 
		}
    }
    
    function _buildNFBannerTrans($testType, $transType, $qty)
    {
    	$transType = trim($transType);
    	
    	$clicker = new NFClicker(URL, ($transType == ERR_103 ? INVALID_RATE : VALID_RATE), '1042', '12345');
    	
    	//$clicker->click();
		$this->_transid = ($transType == ERR_101 ? '' : $clicker->click());
		$this->_transid = ($transType == ERR_104 ? substr(md5($this->_transid), 0, 30) : $this->_transid);
		$this->_commission = ($transType == ERR_103 ? '' : rand(1, 20));
		
		if($transType == VALID_TRANS){
			$this->_lastValid = $this->_transid;
		}		
				
		$this->_transid = ($transType == ERR_102 ? $this->_lastValid : $this->_transid);
		
		//println($transType . ": " . $clicker->url);
		//println($this->_transid . "<br />--------------------<br />");
		
		for($i = 0; $i < $qty; ++$i){
			foreach($this->data as $col => $val){
				$data[$col] = $this->_eval($val);
			}
			$this->transactions[] = $data; 
		} 	
    }
    
    function _eval($string)
    {
		$regex = '/({.*})/';
    	return preg_replace_callback($regex, array($this, "_callback"), $string);	
    }
    
    function _callback($str)
    {
		$transid = $this->_transid;
		$commission = $this->_commission;
		
		$return = null;
		
		$ret = str_replace('}', '', str_replace('{', '', $str[0]));
		eval ('$return = ' . $ret . ';');
		return $return;    	
    }
    
	// HACK!
    function _paren($str)
    {
    	return str_replace('-OP-', '(', str_replace('-CP-', ')', $str));
    }    
}

?>