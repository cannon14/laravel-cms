<?php
class Affiliate_Merchants_Bl_UploadScrubber
{
	var $rows;
	function Affiliate_Merchants_Bl_UploadScrubber(){
		$this->rows = array();		
	}
	
	function add($row){
		if(isset($this->rows[$row['transid']])){
			$dupArray = $this->rows[$row['transid']];
			while($dup = current($dupArray)){
				if($dup['estimatedrevenue'] == ($row['estimatedrevenue']*-1) && $dup['estimatedrevenue'] != 0){
					unset($this->rows[$row['transid']][key($dupArray)]);
					return false;
				}
			next($dupArray);
			}
		}
		$this->rows[$row['transid']][] = $row;
		return true;
	}
	
	function getRows(){
		foreach($this->rows as $row1)
			foreach($row1 as $row2)
				$return[] = $row2;
		return $return;
	}
}
?>