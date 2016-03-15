<?php

class Affiliate_Merchants_Bl_DiscoverETLParser extends Affiliate_Merchants_Bl_Parser {
    
    var $i = 1;
    
    var $validColumns = array(
        'iq_id',
        'decision_date',
        'source_code',
        'decision_code',
        'near_prime_ind'
    );
    
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    
        $buffer = array();
        $fd = fopen ($path, "r");
        
        $merchantname = "Discover";
        $providerchannel = "Discover";
        
        // initialize a loop to go through each line of the file
        while (!feof ($fd)) {
            // declare an array to hold all of the contents of each row, indexed
            $buffer = fgetcsv($fd, 4096);
            
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
            	// check for empty row
                if (($buffer[1] != "") && ($buffer[2] != "") && (strtolower($buffer[3]) == "bk") && (strtolower($buffer[4]) == "n"))
                {
                    $rowArr = array();
                    
                    $dDate = $this->_convertDate($buffer[1]);
                    
                    $rowArr["providereventdate"] = $dDate;
                    //$rowArr["orderid"] = $buffer[1];
                    $rowArr["transid"] = $buffer[0];
                    $rowArr["providerprocessdate"] = $dDate;
                    
                    $rowArr["merchantname"] = $merchantname;
                    $rowArr["providerchannel"] = $providerchannel;
                    $rowArr["quantity"] = 1;
                    $rowArr["estimateddatafilename"] = $filename;
                    
                    $this->addRow($rowArr, $cleanPath, $sqlErrorPath);
                }
            }
            
            $this->i ++;
        }
        
        fclose ($fd);
        
        //create archive of raw file
        $this->moveFile($path, $archivePath);
        
        if(!$this->errorFlag)
            QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date)
    {
        //accept mm/dd/yyyy
        $dateArr = explode("/", $date);
        //return yyyy-mm-dd
        return ($dateArr[2] ."-". $dateArr[0] ."-". $dateArr[1]);
    }
}
?>