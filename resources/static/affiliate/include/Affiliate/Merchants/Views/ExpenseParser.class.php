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
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExpenseParserNew');

QUnit_Global::includeClass('Affiliate_Merchants_Bl_7SearchParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_AskParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_BankrateParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_BusinessParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_GoogleParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_GoogleContentParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_LooksmartParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MivaParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MSNParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Pulse360Parser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_SuperpagesParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_YahooCMParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_YahooSMParser');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_YahooSSParser');

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExpenseSync');

class Affiliate_Merchants_Views_ExpenseParser extends QUnit_UI_TemplatePage {
	
	var $cleanRecords = 0;
	var $errorRecords = 0;
	var $totalCleanExpense;
	var $totalErrorExpense;
	var $errorFiles = 0;
	var $uploadFiles = 0;
	
    function process() {
    	
    	if(!empty($_REQUEST['action'])){
    		switch($_REQUEST['action']){
		    	case "process" : 
		    		if ($_REQUEST["provider"])
		    		{
		    			$this->_walk_directory(EXPENSE_PATH . $_REQUEST["provider"]);
		    		} else {
			    		$this->_walk_directory(EXPENSE_PATH);
		    		}
		    	break;
		    	
		    	case "syncOther" :
		    		$this->processSyncOther();
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
    	if(Affiliate_Merchants_Bl_ExpenseSync::sync($_REQUEST["affiliate_id"]))
    		QUnit_Messager::setOkMessage("Expenses successfully synched.");
    	else
    		QUnit_Messager::setErrorMessage("There was an error synching expenses!");		
    }
    
    function processSyncOther()
    {
    	if(Affiliate_Merchants_Bl_ExpenseSync::syncOther())
    		QUnit_Messager::setOkMessage("Other expenses successfully synched.");
    	else
    		QUnit_Messager::setErrorMessage("There was an error synching expenses!");		
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
    	$sql = "Select n.class, n.directory, n.affiliate_id, u.name " .
    			"From " . EXPENSE_NETWORK_TABLE . " n Inner Join " . USERS_TABLE . " u ON n.affiliate_id = u.userid " .
    			"ORDER BY u.username ASC";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    	while(!$rs->EOF)
        {
    		$sql2 = "SELECT COUNT(*) as count, SUM(total_expense) as totalExpense FROM " .EXPENSE_UPLOAD_TABLE. " where affiliate_id=" . _q($rs->fields['affiliate_id']);
   			$rs2 = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__);
    		
    		$sql3 = "SELECT COUNT(*) as count, SUM(total_expense) as totalExpense FROM " .EXPENSE_UPLOAD_ERROR_TABLE. " where affiliate_id=" . _q($rs->fields['affiliate_id']);
   			$rs3 = QCore_Sql_DBUnit::execute($sql3, __FILE__, __LINE__);
   			
   			if ($rs3->fields['count']>0)
    		{
    			$actionContent = '<a href="index.php?md=Affiliate_Merchants_Views_ExpensesUploadErrorsManager" style="color: #FF0000; font-weight: bold;">Must Clear Errors</a>';
    		
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
    		
    		$this->cleanRecords += $rs2->fields['count'];
			$this->errorRecords += $rs3->fields['count'];
			
			$this->totalCleanExpense += $rs2->fields['totalExpense'];
			$this->totalErrorExpense += $rs3->fields['totalExpense'];
			
			$this->errorFiles +=  $this->_getFilesInDirectory($rs->fields['directory'], "errors");
			$this->uploadFiles += $this->_getFilesInDirectory($rs->fields['directory'], "raw_dump");
    		
    		print('<tr>' .
    				'<td class="listresult">' . $rs->fields['name']. '</td>' .
    				'<td class="listresult"> ' . ($rs2->fields['count']>0?'<input type="button" value="Sync - ' .$rs2->fields['count']. '" onclick="javascript:syncExpenses(' . _q($rs->fields['affiliate_id']). ');">':'0') . '</td>' .
    				'<td class="listresult" ' . ($rs3->fields['count']>0?'style="color: #FF0000; font-weight: bold;"':'') . '>' .$rs3->fields['count']. '</td>' .
					'<td class="listresult">' . ($rs2->fields['totalExpense'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($rs2->fields['totalExpense']) : '-') . '&nbsp;|&nbsp;<span style="color: #FF0000; font-weight: bold;">' . ($rs3->fields['totalExpense'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($rs3->fields['totalExpense']) : '-') . '</span></td>' .    			 	
					'<td class="listresult">' . ($this->_getFilesInDirectory($rs->fields['directory'], "errors")). '</td>' .
					'<td class="listresult">' . ($this->_getFilesInDirectory($rs->fields['directory'], "raw_dump")). '</td>' .
    			 	'<td class="listresult">' . $actionContent . '</td>' .
    			 '</tr>');
    		
    		$rs->MoveNext();
    	}
    	
    	//print row for affiliate_id's that are not in expense networks table
    	$otherSql = "select count(*) as count, SUM(total_expense) as totalOtherExpense from " . EXPENSE_UPLOAD_TABLE . " where affiliate_id NOT in (select affiliate_id from " . EXPENSE_NETWORK_TABLE . ")";
   		$otherRs = QCore_Sql_DBUnit::execute($otherSql, __FILE__, __LINE__);
   		
   		$otherSqlErrors = "select count(*) as count, SUM(total_expense) as totalOtherExpense from " . EXPENSE_UPLOAD_ERROR_TABLE . " where affiliate_id NOT in (select affiliate_id from " . EXPENSE_NETWORK_TABLE . ")";
   		$otherRsErrors = QCore_Sql_DBUnit::execute($otherSqlErrors, __FILE__, __LINE__);
   		
   		if ($otherRsErrors->fields['count']>0)
		{
			$actionContent = '<a href="index.php?md=Affiliate_Merchants_Views_UploadErrorManager" style="color: #FF0000; font-weight: bold;">Must Clear Errors</a>';
		
		} elseif (($otherRsErrors->fields['count']==0) && ($otherRs->fields['count']==0))
		{
			$actionContent = 'No Action Necessary';
		
		} elseif ($otherRs->fields['count']>0)
		{
			$actionContent = '<span style="color: #00CC66; font-weight: bold;">Sync Clean Records</span>';
		
		}
    	print('<tr><td colspan="7" class="listresult">&nbsp;</td></tr>' .
    			'<tr>' .
    				'<td class="listresult">Other Affiliates</td>' .
    				'<td class="listresult"> ' . ($otherRs->fields['count']>0?'<input type="button" value="Sync - ' .$otherRs->fields['count']. '" onclick="javascript:syncOtherExpenses();">':$otherRs->fields['count']) . '</td>' .
    				'<td class="listresult" ' . ($otherRsErrors->fields['count']>0?'style="color: #FF0000; font-weight: bold;"':'') . '>' .$otherRsErrors->fields['count']. '</td>' .
    			 	'<td class="listresult">' . ($otherRs->fields['totalOtherExpense'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($otherRs->fields['totalOtherExpense']) : '-') . '&nbsp;|&nbsp;<span style="color: #FF0000; font-weight: bold;">' . ($otherRsErrors->fields['totalOtherExpense'] > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($otherRsErrors->fields['totalOtherExpense']) : '-') . '</span></td>' .
					'<td class="listresult">N/A</td>' .
					'<td class="listresult">N/A</td>' .
    			 	'<td class="listresult">' . $actionContent . '</td>' .
    			 '</tr>');
    	
    	$this->cleanRecords += $otherRs->fields['count'];
    	$this->errorRecords += $otherRsErrors->fields['count'];
    	
    	//print totals row
    	print('<tr><td colspan="7" class="listresult">&nbsp;</td></tr>' .
    			'<tr>' .
    				'<td class="listresult" style="font-weight: bold;">TOTALS:</td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . $this->cleanRecords . ' </td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . $this->errorRecords . '</td>' .
    				'<td class="listresult" style="font-weight: bold;"> ' . ($this->totalCleanExpense > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($this->totalCleanExpense) : '-') . '&nbsp;|&nbsp;<span style="color: #FF0000; font-weight: bold;">' . ($this->totalErrorExpense > 0 ? Affiliate_Merchants_Bl_Settings::showCurrency($this->totalErrorExpense) : '-') . '</td>' .
    			 	'<td class="listresult" style="font-weight: bold;">' . $this->errorFiles . '</td>' .
					'<td class="listresult" style="font-weight: bold;">' . $this->uploadFiles . '</td>' .
    			 	'<td class="listresult">&nbsp;</td>' .
    			 '</tr>');
    }
    
    function _getFilesInDirectory($provider, $dir)
    {
    	$directory = EXPENSE_PATH . $provider . "/" . $dir . "/";
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
    	$this->addContent('expense_process_status');
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
						
						$sql = "SELECT * FROM " .EXPENSE_NETWORK_TABLE;
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