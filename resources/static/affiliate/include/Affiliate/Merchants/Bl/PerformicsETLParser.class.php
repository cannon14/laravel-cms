<?php

class Affiliate_Merchants_Bl_PerformicsETLParser extends Affiliate_Merchants_Bl_Parser {
    
    var $i = 1;
    
    var $validColumns = array(
        'Client ID',
        'Client Name',
        'Member ID',
        'Approval Date',
        'Commission'
    );
    
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
        
        $buffer = array();
		$fd = fopen ($path, "r");
		
		$providerchannel = "Performics";
		
        // initialize a loop to go through each line of the file
		while (!feof ($fd)) {
			// declare an array to hold all of the contents of each row, indexed
		    $bufferStr = fgets($fd, 4096);
			
			$buffer = explode("	",$bufferStr);
			
			//if file not validated yet, test validation
			if(!$this->fileValidated)
			{
				$this->fileValidated = $this->_validateFileFormat($buffer, $this->validColumns);
			}
			else
			{
				$this->skipHeaderRow = true;
			}
			
			//if file not validated after 5 rows, error out file
			if (($this->i > 5) && (!$this->fileValidated))
			{
				$this->copyFile($path, $fileErrorPath);
				
				QUnit_Messager::setErrorMessage(L_G_REVENUE_FILE_ERROR .$path);
				$this->errorFlag = true;
				break;
			}
            
            if (($this->fileValidated) && ($this->skipHeaderRow))
            {
                if (($buffer[0] != "") && ($buffer[1] != "") && ($buffer[3] != ""))
                {
                    $rowArr = array();
                    $rowArr["merchantname"] = $buffer[1];
                    $rowArr["transid"] = $buffer[2];
                    $rowArr["providerprocessdate"] = $this->_convertDate($buffer[3]);
                    $rowArr["providereventdate"] = $this->_convertDate($buffer[3]);
                    $rowArr["providerchannel"] = $providerchannel;
                    
                    $rowArr["dateestimated"] = $this->getDate();
                    $rowArr["quantity"] = 1;
                    $rowArr["estimateddatafilename"] = $filename;

                    $this->addRow($rowArr, $cleanPath, $sqlErrorPath);
                }
            }
            
            $this->i++;
		}
        
        fclose ($fd);
		
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		if(!$this->errorFlag)
			QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date)
    {
    	//incoming format: 2008-01-27 19:23:16
    	$dateTime = explode(" ", $date);
        $dateArr = explode("-", $dateTime[0]);
        $timeArr = explode(":", $dateTime[1]);
        return (date("Y-m-d H:i:s", mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[1] , $dateArr[2], $dateArr[0])));
    }
}
?>