<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');

class Affiliate_Merchants_Bl_PerformicsParser extends Affiliate_Merchants_Bl_Parser {
    
    var $validColumns = array(
        'Date',
        'Order#',
        'Link ID',
        'Link Name',
        'Keyword ID',
        'Keyword',
        'Match Type',
        'Advertiser ID',
		'Advertiser Name',
        'Publisher Member ID',
        'Amount',
        'Partner Fee, by Product',
        'Status',
        'Event Type'
    );
    
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
        
        $data = new Affiliate_Merchants_Bl_ExcelReader();
        $data->setOutputEncoding('CP1251');
        error_reporting(E_ALL ^ E_NOTICE);
        
        $data->read($path);
        $errorCsvHeaderFlag = false;
        
        $providerchannel = "Performics";
        
        for ($i=1; $i <= $data->sheets[0]['numRows']; $i++)
        {
            $buffer = array();
            
            for ($j=1; $j <= $data->sheets[0]['numCols']; $j++)
            {
                array_push($buffer, $data->sheets[0]['cells'][$i][$j]);
            }
            
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
            if (($i > 5) && (!$this->fileValidated))
            {
                $this->copyFile($path, $fileErrorPath);
                
                QUnit_Messager::setErrorMessage(L_G_REVENUE_FILE_ERROR .$path);
                $this->errorFlag = true;
                break;
            }
            
            if (($this->fileValidated) && ($this->skipHeaderRow))
            {

                /** 
                 * check for empty row. Do not accept any rows with zero revenue.
                 * 
                 */
                 
                $buffer[10] = $this->cleanFinancial($buffer[10]);
                
                if ((($buffer[0] != "") && ($buffer[1] != "") && ($buffer[2] != "") && ($buffer[7] != "") && ($buffer[8] != "")) && (($buffer[11] != 0) || ($buffer[11] != "0.00") || ($buffer[11] != "0")))
                {
                    $rowArr = array();
                    $rowArr["merchantname"] = $buffer[8];
                    $rowArr["transid"] = $buffer[9];
                    $rowArr["providerprocessdate"] = $this->_convertDate($buffer[0]);
                    $rowArr["providereventdate"] = $this->_convertDate($buffer[0]);
                    $rowArr["estimatedrevenue"] = $buffer[11];
                    $rowArr["providerchannel"] = $providerchannel;
                    
                    $rowArr["dateestimated"] = $this->getDate();
                    $rowArr["quantity"] = 1;
                    $rowArr["estimateddatafilename"] = $filename;

                    $this->addRow($rowArr, $cleanPath, $sqlErrorPath);
                }
            }
        }
        
        //create archive of raw file
        $this->moveFile($path, $archivePath);
        
        if(!$this->errorFlag)
            QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date)
    {
        $dateArr = explode("-", $date);
        return (date("Y-m-d H:i:s", mktime(0, 0, 0, $dateArr[1] , $dateArr[2], $dateArr[0])));
    }
}
?>