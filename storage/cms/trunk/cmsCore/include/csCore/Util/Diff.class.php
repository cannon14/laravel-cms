<?php

/**
 * 
 * ClickSuccess, L.P.
 * April 21, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */

class csCore_Util_Diff	{
	var $ignoredLines;
	function csCore_Util_Diff($file1, $file2)
	{
		$this->file1 = $file1;
		$this->file2 = $file2;
		
		$this->colors = array("<font style='BACKGROUND-COLOR: yellow'>",
							  "<font style='BACKGROUND-COLOR: #CCFFCC'>",
							  "<font style='BACKGROUND-COLOR: pink'>",
							);
	}
	
	function findDiff($caseInsensitive=false, $stripTags=true)	{
		
		$rFile1		= $this->file1;
		$rFile2		= $this->file2;
		
		$fCount1	= count($rFile1);
		$fCount2	= count($rFile2);

		$diffCounter	= 0;
		$diffArray = array();

		$comments		= "";
		$comments2		= "";
		$commentsOpen	= 0;
		
		if(is_Array($rFile1))
		foreach ($rFile1 as $k=>$v)	{
			$v = str_replace("\n", "", $v);
			$rFile2[$k] = str_replace("\n", "", $rFile2[$k]);
			
			if($stripTags){
				$v = strip_tags($v);
				$rFile2[$k] = strip_tags($rFile2[$k]);
			}
			
			$check	= ($caseInsensitive)	? @StriStr($v,$rFile2[$k]) : @StrStr($v,$rFile2[$k]);
			if ($check != $v)	{
				$diffCounter++;
					
				$diffArray[$k][2] = $this->cleanString($rFile2[$k]);
				$diffArray[$k][1] = $this->cleanString($v);
				
				$max = strlen($diffArray[$k][2]);
				if($max < ($tmp = count($diffArray[$k][1])))
					$max = $tmp;
				
				$hl1 = $diffArray[$k][1];
				$hl2 = $diffArray[$k][2];
				$retString1 = $retString2 = "";
				$offset = 0;
				$color = -1;
				$colorLock = true;
				for($i = 0; $i < $max; ++$i){
					
					if($hl1[$i] != $hl2[$i]){
						if(!$colorLock){
							$color ++;
							$color = $color % count($this->colors);
							
							$retString1 .=  $this->colors[$color];
							$retString2 .=  $this->colors[$color];
						}
						$colorLock = true;
						
						$retString1 .=  substr($hl1, $i, 1);
						$retString2 .=  substr($hl2, $i, 1);
						
					}else{
						
						if($colorLock){
							$retString1 .= '</font>';
							$retString2 .= '</font>';
						}
						$colorLock = false;
						
						$retString1 .= $hl1[$i];
						$retString2 .= $hl2[$i];
					}
					
				}
				
				$diffArray[$k][1] = $retString1;
				$diffArray[$k][2] = $retString2;
			}
		}

		if ($fCount2 > $fCount1)	{
			for($i=$fCount1;$i<$fCount2;$i++)	{
				$diffCounter++;
				$diffArray[$k][2] = $this->cleanString($rFile2[$i]);
				$diffArray[$k][1] = $this->cleanString($v);
			}
		}

		return $diffArray;

	}
	
	function cleanString($string){

		$string = htmlentities($string);
		$string = str_replace("&nbsp", "", $string);
		return $string;
	}

}

