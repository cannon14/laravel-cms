<?php
/**
 * 
 * CreditCards.com L.P.
 * RevenueParser Class
 * 
 * Kyle Putnam
 * 
 **/
 
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Parser');

QUnit_Global::includeClass('Affiliate_Merchants_Bl_AdvantaParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_AmexParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CapitalOneParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ChaseParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CitiParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CommissionJunctionParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CommissionSoupParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_DiscoverApplicationParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_DiscoverApprovalParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_DiscoverETLParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_EuforaParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_FirstNationalParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_FirstPremierParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_HsbcGmParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_HsbcMetrisParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_HsbcOrchardParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_HsbcPlatinumParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_HsbcUpParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_IcommissionsParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_LinkshareParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MerchantServicesParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_NetspendParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_NcsParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PerformicsParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PerformicsETLParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PreCashParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_RushParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_SimmonsParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_TransactionSync');

class Affiliate_Merchants_Views_RevenueParser extends QUnit_UI_TemplatePage {
	
	var $cleanRecords = 0;
	var $errorRecords = 0;
	var $errorFiles = 0;
	var $uploadFiles = 0;
	
    function process() {
    	
    	if(!empty($_REQUEST['action'])){
    		switch($_REQUEST['action']){
		    	case "process" : 
		    		if ($_REQUEST["provider"])
		    		{
		    			$this->_walk_directory(REVENUE_PATH . $_REQUEST["provider"]);
		    		} else {
			    		$this->_walk_directory(REVENUE_PATH);
		    		}
		    	break;
		    	
		    	case "sync" :
		    		$this->processSync();
		    	break;
    		}
    	}
    	
    	$this->_showDefaultPage();
    }
    
    function processSync()
    {
    	if(Affiliate_Merchants_Bl_TransactionSync::sync($_REQUEST["providerid"]))
    		QUnit_Messager::setOkMessage("Transactions successfully synched.");
    	else
    		QUnit_Messager::setErrorMessage("There was an error synching the transactions!");		
    }
    	
    /**
     * 
     * Public getSystemStatus
     * 
     * This method checks to see if any records exist in the errors table.
     * 
     */
    function getSystemStatus()
    {
    	$sql = "SELECT * FROM " .PROVIDER_TABLE. " WHERE deleted='0' ORDER BY name ASC";
   		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    	while(!$rs->EOF)
        {
    		$sql2 = "SELECT COUNT(*) as count, SUM(estimatedrevenue) as revenue FROM " .UPLOAD_TABLE. " where providerid='" . $rs->fields['provider_id'] . "'";
   			$rs2 = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__);
    		
    		$sql3 = "SELECT COUNT(*) as count, SUM(estimatedrevenue) as revenue FROM " .UPLOAD_ERROR_TABLE. " where providerid='" . $rs->fields['provider_id'] . "'";
   			$rs3 = QCore_Sql_DBUnit::execute($sql3, __FILE__, __LINE__);
   			
   			/**
    		if ($rs3->fields['count']>0)
    		{
    			$actionContent = '<a href="index.php?md=Affiliate_Merchants_Views_UploadErrorManager&provider=' . $rs->fields['provider_id'] . '" style="color: #FF0000; font-weight: bold;">Must Clear Errors</a>';
    		
    		} elseif (($rs3->fields['count']==0) && ($rs2->fields['count']==0) && ($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump") == 0))
    		{
    			$actionContent = 'No Action Necessary';
    		
    		} elseif (($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump") == 0) && ($rs2->fields['count']>0))
    		{
    			$actionContent = '<span style="color: #00CC66; font-weight: bold;">Sync Clean Records</span>';
    		
    		} else
    		{
				$actionContent = '<input type="button" value="Run Manually" onclick="javascript:parseFiles(\'' .$rs->fields['directory']. '\');">';
			}
    		*/

            if (($rs3->fields['count']==0) && ($rs2->fields['count']==0) && ($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump") == 0))
            {
                $actionContent = 'No Action Necessary';
            
            } elseif ($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump") > 0)
            {
                $actionContent = '<input type="button" value="Run Manually" onclick="javascript:parseFiles(\'' .$rs->fields['directory']. '\');">';
            
            } elseif ($rs3->fields['count']>0)
            {
                $actionContent = '<a href="index.php?md=Affiliate_Merchants_Views_UploadErrorManager&provider=' . $rs->fields['provider_id'] . '" style="color: #FF0000; font-weight: bold;">Clear Errors</a>';
            } else
            {
            	$actionContent = 'No Action Necessary';
            }
   		
            
    		$this->cleanRecords += $rs2->fields['count'];
			$this->errorRecords += $rs3->fields['count'];
			$this->totalCleanRevenue += $rs2->fields['revenue'];
			$this->totalErrorRevenue += $rs3->fields['revenue'];
			$this->errorFiles +=  $this->_getFilesInDirectory($rs->fields['directory'], "errors");
			$this->uploadFiles += $this->_getFilesInDirectory($rs->fields['directory'], "raw_dump");
			
    		print('<tr>' .
    				'<td class="listresult">' . $rs->fields['name']. '</td>' .
    				'<td class="listresult"> ' . ($rs2->fields['count']>0?'<input type="button" value="Sync - ' .$rs2->fields['count']. '" onclick="javascript:syncTransactions(' .$rs->fields['provider_id']. ');">':'0') . '</td>' .
    				'<td class="listresult" ' . ($rs3->fields['count']>0?'style="color: #FF0000; font-weight: bold;"':'') . '>' .$rs3->fields['count'] . '</td>' .
    			 	'<td class="listresult">' . ($rs2->fields['revenue'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($rs2->fields['revenue']) : '-') . '&nbsp;|&nbsp;<span style="color: #FF0000; font-weight: bold;">' . ($rs3->fields['revenue'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($rs3->fields['revenue']) : '-') . '</span></td>' .
					'<td class="listresult">' . ($this->_getFilesInDirectory($rs->fields['directory'], "errors")). '</td>' .
					'<td class="listresult">' . ($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump")). '</td>' .
    			 	'<td class="listresult">' . $actionContent . '</td>' .
    			 '</tr>');
    		
    		$rs->MoveNext();
    	}
    	
    	print('<tr><td colspan="7" class="listresult">&nbsp;</td></tr>' .
    			'<tr>' .
    				'<td class="listresult" style="font-weight: bold;">TOTALS:</td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . $this->cleanRecords . ' </td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . $this->errorRecords . '</td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . ($this->totalCleanRevenue > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($this->totalCleanRevenue) : '-') . '&nbsp;|&nbsp;<span style="color: #FF0000; font-weight: bold;">' . ($this->totalErrorRevenue > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($this->totalErrorRevenue) : '-') . '</td>' .
    			 	'<td class="listresult" style="font-weight: bold;">' . $this->errorFiles . '</td>' .
					'<td class="listresult" style="font-weight: bold;">' . $this->uploadFiles . '</td>' .
    			 	'<td class="listresult">&nbsp;</td>' .
    			 '</tr>');
    }
    
    function _getFilesInDirectory($provider, $dir)
    {
    	$directory = REVENUE_PATH . $provider . "/" . $dir . "/";
    	$count = 0;
    	
    	// open the directory
		$handle = opendir($directory);
		
		// scan through items inside
		while (FALSE !== ($item = readdir($handle)))
		{
			// if filepointer is not current directory/parent directory
			if($item != '.' && $item != '..')
			{
				$count++;
			}
		}
		// close the directory
		closedir($handle);
		
		return $count;
    }
    
    /**
     * 
     * Private _showDefaultPage
     * 
     * This method takes in a string correpsonding to a directory.
     * 
     */
    
    function _showDefaultPage()
    {
    	$this->addContent('revenue_process_status');
    }
    
    /**
     * 
     * Private _walk_directory
     * 
     * This method takes in a string correpsonding to a directory.
     * 
     */
    
	function _walk_directory($directory) {
    	
		// open the directory
		$handle = opendir($directory);
		
		// scan through items inside
		while (FALSE !== ($item = readdir($handle)))
		{
			// if filepointer is not current directory/parent directory
			if($item != '.' && $item != '..')
			{
				// build new path
				$path = $directory.'/'.$item;

				// if new path is directory
				if(is_dir($path)) 
				{
					// call this function with new path
					$this->_walk_directory($path);
					
					// if new path is file, execute parse on file
				} else {
					
					$pathArr = explode("/", $directory);
					
					//only run script on raw_dump directory
					if ($pathArr[count($pathArr) - 1] == "raw_dump")
					{
						//grab dir name a level above current
						$tmpPath = $pathArr[count($pathArr) - 2];
						
						array_pop($pathArr);
						$rootPath = implode("/", $pathArr);

						$pattern = ".xls";
						$pattern2 = ".txt";
						$replacement = ".csv";
						$errorReplacement = "_sql.csv";
						
						$fileErrorPath = $rootPath. "/errors/" .$item;
						$fileErrorPath = $this->_checkFilename($fileErrorPath);
						
						$archivePath = $rootPath. "/archive_original/" .$item;
						$archivePath = $this->_checkFilename($archivePath);
						
						$cleanPath = $rootPath. "/archive_clean/" .$item;
						$cleanPath = str_replace($pattern, $replacement, $cleanPath);
						$cleanPath = str_replace($pattern2, $replacement, $cleanPath);
						$cleanPath = $this->_checkFilename($cleanPath);
						
						$sqlErrorPath = $rootPath. "/errors/" .$item;
						$sqlErrorPath = str_replace($pattern, $errorReplacement, $sqlErrorPath);
						$sqlErrorPath = str_replace($pattern2, $errorReplacement, $sqlErrorPath);
						$sqlErrorPath = $this->_checkFilename($sqlErrorPath);
						
						$sql = "SELECT * FROM " .PROVIDER_TABLE;
				   		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				
				    	while(!$rs->EOF)
				        {
				        	if ($tmpPath == $rs->fields['directory'])
				        		$parser = new $rs->fields['class']($rs->fields);
				        	
				        	$rs->MoveNext();
				        }
						
				    	$parser->parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $item);
					}
				}
			}
		}
		// close the directory
		closedir($handle);
    }
    
    /**
     * 
     * Private checkFilename
     * 
     * Accepts full path to file and 
     * returns full path.
     * 
     */
    function _checkFilename($path)
    {
    	if (file_exists($path))
		
	    	for ($i=1; true; $i++)
    		{
    			//check for "_v2" version number already in filename
    			if (strstr($path, '_v'))
    			{
    				//version number present -> parse it out and replace with incremented number
    				$search = '/(_v[0-9]+)\.(csv|xls|txt)/';
					
					$replacement = "_v$i" . '.\2';
					$path = preg_replace($search, $replacement, $path);
					
				} else {
					//no version number present
					$replacement = "_v$i" .  '.\1';
					$path = preg_replace('/\.(csv|xls|txt)/', $replacement, $path);
				}
								
				if (!file_exists($path))
				{
					break;
				}
			}

		return $path;
    }
}
?>