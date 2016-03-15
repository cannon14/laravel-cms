<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 16, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * 
 */
 class csCore_DataMerger 
 {
 	
 	var $regEx = null;
 	var $delim = null;
 	var $currentMapping = array();
 	var $internalMapping = array();
 	var $sqlTable = null;
 	var $priKey = null;
 
 	function csCore_DataMerger($e, $ma, $table, $key = null)
 	{
 		$this->regEx = "(".$e.").+(".$e.")";
 		$this->delim = $e;
 		if(is_array($ma)){
 			$this->currentMapping = $ma;	
 		}
 		
 		$this->sqlTable = $table;
 		$this->_mapSql($table, $key);
	
 	}
 	
 	function parseString($string, $id)
 	{
 		$parseArray = @explode(" ", $string);
 		$retArray = array();
 		if(@is_array($parseArray)){
 			foreach($parseArray as $token){
 				if(@ereg($this->regEx, $token)){
 					$tokenArray = @explode($this->delim, $token); 	
 					$token = $this->internalMapping[$id][$tokenArray[1]];
 					for($i = 2; $i < count($tokenArray); ++$i)
 						$token .= $tokenArray[$i];
 				}
 				$retArray[] = $token;
 			}
 		}
 		return @implode(" ", $retArray);
 	}
 	
 	function _mapSql($table, $key)
 	{
 		$describe = "DESCRIBE " . $table;
 		$rs = _sqlQuery($describe, __LINE__, __FILE__, DEBUG_MODE);

 		if($key == null){
	 		while($rs && !$rs->EOF){
	 			if($rs->fields['Key'] == 'PRI'){
	 				$this->priKey = $rs->fields['Field'];
	 				break;
	 			}
	 			$rs->MoveNext();
	 		}
	 		
	 		if($this->priKey == null){
	 			echo "<br>No primary key for table " . $table . "!<br>";
	 			return null;
	 		}
 		}else{
 			$this->priKey = $key;
 		}
 		
 		$sql = "SELECT * FROM " . $table;
 		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
 		
 		while($rs && !$rs->EOF){
	 		foreach($this->currentMapping as $key=>$val){
	 			if(is_array($val)){
	 				$this->internalMapping[$rs->fields[$this->priKey]][$key] = $val[$rs->fields[$key]];
	 			}else
	 				$this->internalMapping[$rs->fields[$this->priKey]][$key] = $rs->fields[$val];
	 		}
	 		$rs->MoveNext();
 		}
 	}
 }
?>
