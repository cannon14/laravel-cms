<?
/**
 * CreditCards.com
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * Controller skeleton for Upload Errors.
 * 
 */
 
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Upload');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_TransactionSync');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Views_UploadManager extends QUnit_UI_ListPage
{
    
	/**
	 * TODO. Don't worry about this for now.
	**/
    function initPermissions()
    {

    }

    /**
	 * Handle all user input here.  I've implemnted the singleton delete 
	 * and mass action delete here.  Other functionality can be handled 
	 * similarly.
	**/
    function process()
    {

		if(!empty($_REQUEST['action']))
		{
			switch($_REQUEST['action']){
				case 'deleteTrans' :
					$this->processDelete();
				break;
				case 'rerateTrans' :
					$this->recalculateRates();
				break;
				case 'sync' :
		    		$this->processSync();
		    	break;
			}
				
		} else if ((!empty($_REQUEST['globalaction'])) && (!empty($_REQUEST['massaction'])))
		{
			//global must be checked BEFORE mass action is checked since mass action will ALWAYS be set when global action is set
			switch($_REQUEST['massaction']){
				case 'deleteTrans' :
					$this->processDelete();
				break;
				case 'rerateTrans' :
					$this->recalculateRates();
				break;	
			}
		}
		else if (!empty($_REQUEST['massaction'])) {
			
			switch($_REQUEST['massaction']){
				case 'deleteTrans' :
					$this->processDelete();
				break;
				case 'rerateTrans' :
					$this->recalculateRates();
				break;	
			}	
		}
    	
    	$this->showTransactions();      
    }
    
    function processSync()
    {
    	if($_REQUEST['providerid'] != null)
        {
        	if(Affiliate_Merchants_Bl_TransactionSync::sync($_REQUEST['providerid']))
	    		QUnit_Messager::setOkMessage("Transactions successfully synched.");
	    	else
	    		QUnit_Messager::setErrorMessage("There was an error synching the transactions!");
    	}
        else
        {
        	QUnit_Messager::setErrorMessage("There was an error synching the transactions. Please select a provider from the drop-down.");
        }
    }
    
    /*function processSync()
    {
    	if(Affiliate_Merchants_Bl_TransactionSync::sync())
    		QUnit_Messager::setOkMessage("Transactions successfully synched.");
    	else
    		QUnit_Messager::setErrorMessage("There was an error synching the transactions!");
    }*/
    
    /**
     * 
     * This method deletes upload errors.
     * 
     */
    
    function processDelete()
    {
    	$ids = $this->_returnIds();
    	
    	if(!is_array($ids)){
			$ids = array($ids);
		}
		
    	foreach($ids as $id)
    	{
    		$trans = Affiliate_Merchants_Bl_UploadTransaction::getUpload($id);
    		
    		/* MOVING TRANS TO DELETED TABLE FOR EFFICIENT FRONTIER ************/
			$success = Affiliate_Merchants_Bl_UploadTransaction::archiveDeleted($id);
    	}
    	
    	if(!$success)
    	{
    		QUnit_Messager::setErrorMessage("There was an error deleting records. Not able to archive items to deleted table.");
   			return false;
    	}
    	
		Affiliate_Merchants_Bl_Upload::deleteUploads($ids);
		
    	QUnit_Messager::setOkMessage('Upload Record(s) Deleted.');
    }
    
     /*
     * This method recalculates rates upload errors.
     * 
     */
     
    function recalculateRates()
    {
    	if(($IDs = $this->_returnIds()) == false)
            return false;
    	
    	foreach($IDs as $id)
    	{
    		$trans = Affiliate_Merchants_Bl_UploadTransaction::getUpload($id);
        	Affiliate_Merchants_Bl_Rate::recalculateRates($trans, UPLOAD_TABLE);
    	}
    	
    	QUnit_Messager::setOkMessage('Rate(s) Recalculated.');
    }
    
    
    
	/**
	 * 
	 * This is just a helper method to grab all of the id's sent in from the view.
	 * See the processDelete method for usage.
	 * 
	 */
    function _returnIds()
    {
        //global action must be checked BEFORE mass action since mass action will ALWAYS be set when global action is set
        if ((!empty($_REQUEST['globalaction'])) && (!empty($_REQUEST['massaction'])))
        {
        	$IDs = $this->_getTransByFilter();
        }
        else if(!empty($_REQUEST['massaction']))
        {
            $IDs = $_REQUEST['itemschecked'];
        }
        else
        {
            $IDs = array($_REQUEST['transid']);
        }
        
        return $IDs;
    }
    
    function _getTransByFilter()
    {
    	$orderby = '';
        $where = '';
        
        $this->createWhereOrderBy($orderby, $where);

        $recs = $this->getRecords($orderby, $where);
        
        $IDs = array();
        
        while(!$recs->EOF) {
            $IDs[] = $recs->fields['transid'];
            
        	$recs->MoveNext();	
        }
        
        return $IDs;
    }
    
	/**
	 * This method instanciates the template.  You can replace kyle_temp with
	 * the template you created.
	**/    
    function showTransactions()
    {
        
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $orderby = '';
        $where = '';
        
        $this->createWhereOrderBy($orderby, $where);

        $recs = $this->getRecords($orderby, $where);
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);
        
        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));
        
        $this->pageLimitsAssign();

        $this->addContent('upload_list');
    }
    

    function createWhereOrderBy(&$orderby, &$where)
    {
    	//--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 50;
        
        if($_REQUEST['tm_status'] == '') $_REQUEST['tm_status'] = '_';
        if($_REQUEST['tm_day1'] == '') $_REQUEST['tm_day1'] = date("j");
        if($_REQUEST['tm_month1'] == '') $_REQUEST['tm_month1'] = date("n");
        if($_REQUEST['tm_year1'] == '') $_REQUEST['tm_year1'] = date("Y");
        if($_REQUEST['tm_day2'] == '') $_REQUEST['tm_day2'] = date("j");
        if($_REQUEST['tm_month2'] == '') $_REQUEST['tm_month2'] = date("n");
        if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        
        $_SESSION['tm_status'] = $_REQUEST['tm_status'];
        $_SESSION['transactionid'] = $_REQUEST['transactionid'];
        $_SESSION['tm_day1'] = $_REQUEST['tm_day1'];
        $_SESSION['tm_month1'] = $_REQUEST['tm_month1'];
        $_SESSION['tm_year1'] = $_REQUEST['tm_year1'];
        $_SESSION['tm_day2'] = $_REQUEST['tm_day2'];
        $_SESSION['tm_month2'] = $_REQUEST['tm_month2'];
        $_SESSION['tm_year2'] = $_REQUEST['tm_year2'];
        $_SESSION['provider'] = $_REQUEST['provider'];
        $_SESSION['campaignid'] = $_REQUEST['campaignid'];
        $_SESSION['estimatedrevenue'] = $_REQUEST['estimatedrevenue'];
        
    	
		if($_REQUEST['sortby'] != '')
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by dateinserted desc";
        }
        
        if($_REQUEST['campaignid'] != null)
        {
        	if($_REQUEST['campaignid'] == 'unassigned')
        	{
        		$where .= " AND (t.campcategoryid='' OR t.campcategoryid IS NULL)";
        	} else {
        		$where .= " AND c.campaignid=". _q($_REQUEST['campaignid']);
        	}
        }
        
        if($_REQUEST['transactionid'] != null)
        {
        	$where .= " AND reftrans=". _q($_REQUEST['transactionid']);
        }
        
        if($_REQUEST['estimatedrevenue'] != null)
        {
        	if($_REQUEST['estimatedrevenue'] == 'empty')
        	{
        		$where .= " AND estimatedrevenue IS NULL";
        	} else {
        		$where .= " AND estimatedrevenue=". _q($_REQUEST['estimatedrevenue']);
        	}
        }
        
        if($_REQUEST['provider'] != null)
        {
        	$where .= " AND providerid=". _q($_REQUEST['provider']);
        }
        
        if($_REQUEST['estimateddatafilename'] != null)
        {
        	$where .= " AND estimateddatafilename=". _q($_REQUEST['estimateddatafilename']);
        }
        
        if(($_REQUEST['date'] != null) && ($_REQUEST['date'] != "all"))
        {
        	switch($_REQUEST['date'])
        	{
        		case "dateinserted": $where .= " AND ((t.dateinserted >= "._q($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1'] . " 00:00:00") .")".
                	      " AND (t.dateinserted <= "._q($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']." 23:59:59") ."))";
        		break;
        		
        		case "providerprocessdate": $where .= " AND ((t.providerprocessdate >= "._q($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1'] . " 00:00:00") .")".
                	      " AND (t.providerprocessdate <= "._q($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']." 23:59:59") ."))";
        		break;
        	}
        	
        }
        
    }
 
	/**
	 * TODO. Don't worry about this for now.
	**/
    function prepareExportFile($orderby, $where)
    {
        
    }
	
	/**
	 * Shouldn't need to mess with this method.
	**/    
    function getRecords($orderby, $where)
    {
		
        //$sql = 'SELECT COUNT(*) as count FROM ' .UPLOAD_TABLE. ' as t WHERE 1=1 ';
        $sql = 'SELECT COUNT(*) as count FROM ' .UPLOAD_TABLE. ' AS t' .
        		' Left Join ' . CAMPAIGN_CATEGORIES_TABLE . ' AS cc ON t.campcategoryid = cc.campcategoryid' .
        		' Left Join ' . CAMPAIGNS_TABLE . ' AS c ON cc.campaignid = c.campaignid' .
        		' Left Join ' . PROVIDER_TABLE . ' AS p ON t.providerid = p.provider_id' .
        		' WHERE 1=1 ';
        		
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
		
		$sql = 'SELECT c.campaignid, c.name, p.rate, t.* FROM ' .UPLOAD_TABLE. ' AS t' .
        		' Left Join ' . CAMPAIGN_CATEGORIES_TABLE . ' AS cc ON t.campcategoryid = cc.campcategoryid' .
        		' Left Join ' . CAMPAIGNS_TABLE . ' AS c ON cc.campaignid = c.campaignid' .
        		' Left Join ' . PROVIDER_TABLE . ' AS p ON t.providerid = p.provider_id' .
        		' WHERE 1=1 ';
		
        //if GLOBAL ACTION is calling this SQL, do not limit results to number displayed on page
		if ((!empty($_REQUEST['globalaction'])) && (!empty($_REQUEST['massaction'])))
    	{
			$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, 0, 100000000, __FILE__, __LINE__);
    	} else {
    		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
    	}
    	
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
    
   	/**
	 * This method defines which columns CAN be shown.  I've done three.
	**/   
    function getAvailableColumns()
    {
        return array(
            'transid'	=>  array('Transaction ID', 'transid'),
            'reftrans'	=>  array('TransID Reference', 'reftrans'),
            'dateinserted'	=>  array('Date Inserted', 'dateinserted'),
            'providerprocessdate'	=>  array('Prov. Process Date', 'providerprocessdate'),
            'providereventdate'	=>  array('Prov. Event Date', 'providereventdate'),
            'dateestimated'	=>  array('Date Uploaded', 'dateestimated'),
            'merchantname'	=>  array('Merchant Name', 'merchantname'),
            'quantity'	=>  array('Quantity', 'quantity'),
            'estimatedrevenue'	=>  array('Revenue', 'estimatedrevenue'),
            'providerchannel'	=>  array('Provider Channel', 'providerchannel'),
            'name'	=>  array('Product Name', 'name'),
            'campcategoryid'	=>  array('Camp. Category ID', 'campcategoryid'),
            'estimateddatafilename'	=>  array('Upload Filename', 'estimateddatafilename'),
            'actions'	=>  array('Actions', '')
			);
    }
    
   	/**
	 * This method defines name of controller.
	**/   
    function getListViewName()
    {
        return 'upload_list';
    }
    
   	/**
	 * This method defines which columns are shown by defualt.  This must be a subset
	 * of the array defined in the getAvailableColumns method.
	**/ 
    function initViews()
    {
        $viewColumns = array(
            'transid',
            'reftrans',
            'dateinserted',
            'providerprocessdate',
            'providereventdate',
            'dateestimated',
            'merchantname',
            'quantity',
			'estimatedrevenue',
			'providerchannel',
			'name',
			'campcategoryid',
			'estimateddatafilename',
            'actions'
        );
        
        $this->createDefaultView($viewColumns);

        $this->loadAvailableViews();
        
        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }

        $this->assign('a_list_views', $this->tplAvailableViews);
        
        $this->applyView();
    }
    
   	/**
	 * This method draws each column.  Every column defined in the getAvailableColumns
	 * method must have an entry defined here.
	**/ 
    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
		
        print '<td class="listresult"><input type=checkbox onclick="javascript:deselectApplyToAll();" id=itemschecked name="itemschecked[]" value="'.$row['transid'].'"></td>';
        
        foreach($view->columns as $column)
        {
			if($row['reversed'] == 1)
				$showred = "<font color='red'>";
			else
				$showred = "";
            switch($column)
            {
                case 'transid': print '<td class=listresult>&nbsp;' . $row['transid'].'&nbsp;</td>';
                        break;
                        
                case 'reftrans': print '<td class=listresult>&nbsp;' . $row['reftrans'].'&nbsp;</td>';
                        break;
                
                case 'dateinserted': print '<td class=listresult nowrap>&nbsp;' . $row['dateinserted'].'&nbsp;</td>';
                        break;
                
                case 'providerprocessdate': print '<td class=listresult nowrap>&nbsp;' . $row['providerprocessdate'].'&nbsp;</td>';
                        break;
                
                case 'providereventdate': print '<td class=listresult nowrap>&nbsp;' . $row['providereventdate'].'&nbsp;</td>';
                        break;
                
                case 'dateestimated': print '<td class=listresult nowrap>&nbsp;' . $row['dateestimated'].'&nbsp;</td>';
                        break;
				
                case 'merchantname': print '<td class=listresult>&nbsp;' . $row['merchantname'].'&nbsp;</td>';
                        break;
                
                case 'quantity': print '<td class=listresult>&nbsp;' . $row['quantity'].'&nbsp;</td>';
                        break;
                
                case 'estimatedrevenue': print '<td class=listresult>&nbsp;' .($row['rate'] == 1 ? '<a href="index.php?md=Affiliate_Merchants_Views_RateMicroManager&mode=rate&rid=' . $row['campaignid'] . '">' . Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue']).'</a>' : Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue'])) . '&nbsp;</td>';
                		break;
                
                case 'providerchannel': print '<td class=listresult>&nbsp;' . $row['providerchannel'].'&nbsp;</td>';
                        break;
                
                case 'name': print '<td class=listresult>&nbsp;' .($row['rate'] == 1 ? '<a href="index.php?md=Affiliate_Merchants_Views_RateMicroManager&mode=rate&rid=' . $row['campaignid'] . '">' . $row['name'].'</a>' : $row['name']) . '&nbsp;</td>';
                        break;
                
                case 'campcategoryid': print '<td class=listresult>&nbsp;' .($row['rate'] == 1 ? '<a href="index.php?md=Affiliate_Merchants_Views_RateMicroManager&mode=rate&rid=' . $row['campaignid'] . '">' . $row['campcategoryid'].'</a>' : $row['campcategoryid']) . '&nbsp;</td>';
                        break;
                
                case 'estimateddatafilename': print '<td class=listresult>&nbsp;' . $row['estimateddatafilename'].'&nbsp;</td>';
                        break;
                
                case 'actions':
?>                
                        <td class=listresult>
                            <select OnChange="performAction(this);">
                            	<option value="-">----------------------</option>
                            	<option value="javascript:rerateTrans('<?=$row['transid']?>');">Recalculate Rate</a>
                                <option value="-">----------------------</option>
                                <option value="javascript:deleteTrans('<?=$row['transid']?>');">Delete</a>
                            </select>
                        </td>
<?
                        break;
            }
        }
    }
    
    
   	/**
	 * These are your mass actions.
	**/ 

    function printMassAction()
    {
?>
		<select name="massaction">
			<option value=""><?=L_G_CHOOSEACTION?></option>
			<option value="rerateTrans">Recalculate Rates</option>
			<option value="">--------------------------</option>
			<option value="deleteTrans">Delete Records</option>
		</select>
<?
    }
    
    /**
	 * uploaded filenames from upload table.
	**/
	
    function printUploadedFilenames()
    {
    	$sql = "Select distinct estimateddatafilename From " .UPLOAD_TABLE. " ORDER BY estimateddatafilename asc";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $filenames = QUnit_Global::newobj('QCore_RecordSet');
	        $filenames->setTemplateRS($rs);
	        
	        print('<select name="estimateddatafilename" class=formbutton>' .
	        		'<option value="">All</option>');
	        			
        	 while($row = $filenames->getNextRecord())
        	{
	      		print('<option value="' .$row['estimateddatafilename']. '"' .($_REQUEST['estimateddatafilename'] == $row['estimateddatafilename'] ? 'selected' : ''). '>'. $row['estimateddatafilename']. '</a>');
        	}
        	
        	print('</select>');
		}
    }
    
    /**
	 * ProviderChannel field from upload table.
	**/
	
    function printUploadedProviderChannels()
    {
    	$sql = "Select DISTINCT P.provider_id, P.name " .
    			"From " .UPLOAD_TABLE. " as UE LEFT JOIN " .PROVIDER_TABLE. " as P ON UE.providerid = P.provider_id " .
    			"ORDER BY providerchannel asc";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $filenames = QUnit_Global::newobj('QCore_RecordSet');
	        $filenames->setTemplateRS($rs);
	        
	        print('<select name="provider" class=formbutton>' .
	        		'<option value="">All</option>');
	        			
        	 while($row = $filenames->getNextRecord())
        	{
      			print('<option value="' .$row['provider_id']. '"' .($_REQUEST['provider'] == $row['provider_id'] ? ' selected' : ''). '>'. $row['name']. '</option>');
        	}
        	
        	print('</select>');
		}
    }
    
    function printFilterProductList()
    {
    	$sql = "Select DISTINCT c.campaignid, c.name " .
    			"From " .UPLOAD_TABLE. " as u " .
    			"LEFT JOIN " .CAMPAIGN_CATEGORIES_TABLE. " as cc ON u.campcategoryid = cc.campcategoryid " .
    			"LEFT JOIN " .CAMPAIGNS_TABLE. " as c ON cc.campaignid = c.campaignid " .
    			"WHERE c.campaignid <> ''" .
				"ORDER BY name asc";
    			
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $filenames = QUnit_Global::newobj('QCore_RecordSet');
	        $filenames->setTemplateRS($rs);
	        
	        print('<select name="campaignid" class=formbutton>' .
	        		'<option value="">All Products</option>');
	        			
        	 while($row = $filenames->getNextRecord())
        	{
      			print('<option value="' .$row['campaignid']. '" ' .($_REQUEST['campaignid'] == $row['campaignid'] ? ' selected' : ''). '>'. $row['name']. '</option>');
        	}
        	
        	print('<option value="unassigned"' .$row['campaignid']. '" ' .($_REQUEST['campaignid'] == 'unassigned' ? ' selected' : ''). '>Unassigned</option>');
        	
        	print('</select>');
		}
    }
    
    function printFilterRevenueList()
    {
    	$sql = "Select DISTINCT estimatedrevenue " .
    			"From " .UPLOAD_TABLE . " ORDER BY estimatedrevenue asc";
    			
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $filenames = QUnit_Global::newobj('QCore_RecordSet');
	        $filenames->setTemplateRS($rs);
	        
	         print('<select name="estimatedrevenue" class=formbutton>' .
	        		'<option value="">All Amounts</option>');
	        
        	 while($row = $filenames->getNextRecord())
        	{
      			if($row['estimatedrevenue'] == "")
			    {
					print('<option value="empty" ' .($_REQUEST['estimatedrevenue'] == 'empty' ? ' selected' : ''). '>Empty</option>');
			    } else {
      				print('<option value="' .$row['estimatedrevenue']. '" ' .($_REQUEST['estimatedrevenue'] == $row['estimatedrevenue'] ? ' selected' : ''). '>'. Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue']). '</option>');
      			}
        	}
        	
        	print('</select>');
		}
    }
    
    function printSyncProviderList()
    {
    	$sql = "Select DISTINCT P.provider_id, P.name " .
    			"From " .UPLOAD_TABLE. " as UE LEFT JOIN " .PROVIDER_TABLE. " as P ON UE.providerid = P.provider_id " .
    			"ORDER BY providerchannel asc";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $filenames = QUnit_Global::newobj('QCore_RecordSet');
	        $filenames->setTemplateRS($rs);
	        
	        print('<select name="providerid" class=formbutton>' .
	        		'<option value="" selected>Select Provider</option>');
	        			
        	 while($row = $filenames->getNextRecord())
        	{
      			print('<option value="' .$row['provider_id']. '">'. $row['name']. '</option>');
        	}
        	
        	print('</select>');
		}
    }

}
?>