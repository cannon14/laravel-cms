<?

 
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');

class Affiliate_Merchants_Views_RateMicroManager extends QUnit_UI_ListPage
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
		$this->assign('a_curyear', date("Y"));
		
		if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'addRate':
                    if($this->processAdd($_REQUEST['mode']))
                        return;
                     else {
                     	$this->drawFormAddRate();
                     	return;
                     }
                     	
                break;

                case 'editRate':
                    if($this->processEdit($_REQUEST['mode']))
                        return;
                break;
            }
            
            switch($_POST['massaction'])
            {
                case 'deactivate':
               	    if($this->processDeactivateRates()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
                
                case 'activate':
               	    if($this->processActivateRates()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
                
            }
            
            $this->showTransactions();
        }
		
		if(!empty($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case 'add' :
					$this->drawFormAddRate();
				break;
				case 'edit' :
					$this->drawFormEditRate();
				break;
				/*case 'closeout' :
					$this->processRateCloseout();
					$this->showTransactions();
				break;*/
				
				case 'deactivate' :
					$this->processDeactivateRates();
					$this->showTransactions();
				break;
				
				case 'activate' :
					$this->processActivateRates();
					$this->showTransactions();
				break;
			}
		}else if (!empty($_REQUEST['massaction'])){
			switch($_REQUEST['massaction'])
            {
                case 'deactivate':
               	    if($this->processDeactivateRates()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
                
                case 'activate':
               	    if($this->processActivateRates()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
            }
		}else{
    	   	$this->showTransactions();
		}
    }
    
    /**
     * 
     * This method udpates the end date of a selection of rates.
     * 
     */
    
    function processRateCloseout()
    {
    	$ids = $this->_returnIds();
  
    	Affiliate_Merchants_Bl_Rate::closeOutRates($ids);
    	
    	QUnit_Messager::setOkMessage('Rate(s) Closed Out.');
    }
    
    /**
     * 
     * This method sets rates to inactive (0).
     * 
     */
    
    function processDeactivateRates()
    {
    	$ids = $this->_returnIds();
    	Affiliate_Merchants_Bl_Rate::deactivateRates($ids);
    	
    	QUnit_Messager::setOkMessage('Rate(s) Deactivated.');
    }
    
    /**
     * 
     * This method sets rates to active (1).
     * 
     */
    
    function processActivateRates()
    {
    	$ids = $this->_returnIds();
    	Affiliate_Merchants_Bl_Rate::activateRates($ids);
    	
    	QUnit_Messager::setOkMessage('Rate(s) Activated.');
    }
    
    /*
     * This method Adds new rates.
     * 
     */
    
    function processAdd($mode)
    {
    	switch ($mode) {
    		case "rate":
        		$params['rate'] = $_REQUEST['rate'];
        		$params['campaign_id'] = $_REQUEST['campaignid'];
				
				//if no start date, set it to today
				if($_REQUEST['day1'] == '') $_REQUEST['day1'] = date("j");
		        if($_REQUEST['month1'] == '') $_REQUEST['month1'] = date("n");
		        if($_REQUEST['year1'] == '') $_REQUEST['year1'] = date("Y");
		        $params['rate_start_date'] = $_REQUEST['year1']. "-" .$_REQUEST['month1']. "-" .$_REQUEST['day1'];
		        
		        //--------------------------------------
		        // put settings into session
		        /*$_SESSION['day1'] = $_REQUEST['day1'];
		        $_SESSION['month1'] = $_REQUEST['month1'];
		        $_SESSION['year1'] = $_REQUEST['year1'];
		        */
				
				

				
				if(($_REQUEST['day2'] > 0) && ($_REQUEST['month2'] > 0) && ($_REQUEST['year2'] > 0))
				{
					$_SESSION['day2'] = $_REQUEST['day2'];
			        $_SESSION['month2'] = $_REQUEST['month2'];
			        $_SESSION['year2'] = $_REQUEST['year2'];
					
					$params['rate_end_date'] = $_REQUEST['year2']. "-" .$_REQUEST['month2']. "-" .$_REQUEST['day2'];
				}else{
					
					$params['rate_end_date'] = '0000-00-00'; 
				}
				
				if($params['rate_end_date'] != '0000-00-00' && mktime(0, 0, 0, $_REQUEST['month1'], $_REQUEST['day1'], $_REQUEST['year1']) > mktime(0, 0, 0, $_REQUEST['month2'], $_REQUEST['day2'], $_REQUEST['year2'])){
                	QUnit_Messager::setErrorMessage('Your start date must be before your end date');
            		return false;					
				}				
				
			    //if no start date, set it to today
				/*if($_REQUEST['day2'] == '') $_REQUEST['day2'] = '00';
		        if($_REQUEST['month2'] == '') $_REQUEST['month2'] = '00';
		        if($_REQUEST['year2'] == '') $_REQUEST['year2'] = '0000';
		        $enddate = $_REQUEST['year2']. "-" .$_REQUEST['month2']. "-" .$_REQUEST['day2'] . " 23:59:59:";
		        */
				
				$params['comment'] = $_REQUEST['comment'];
				$params['active'] = 1;
				
				$rs = Affiliate_Merchants_Bl_Rate::insertRate($params);
				
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_RATEADDED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_RateMicroManager&rid='.$_REQUEST['rid']);
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
    	}
    	
    	return false;
    }
    
    /*
     * This method Edits rates.
     * 
     */
    
    function processEdit($mode)
    {
    	switch ($mode) {
    		case "rate":
    			$id = $_REQUEST['id'];
        		
        		$rate = $_REQUEST['rate'];
        		$campaignid = $_REQUEST['campaignid'];
				
				//if no start date, set it to today
				if($_REQUEST['day1'] == '') $_REQUEST['day1'] = date("j");
		        if($_REQUEST['month1'] == '') $_REQUEST['month1'] = date("n");
		        if($_REQUEST['year1'] == '') $_REQUEST['year1'] = date("Y");
		        $startdate = $_REQUEST['year1']. "-" .$_REQUEST['month1']. "-" .$_REQUEST['day1'] . " 00:00:00";
		        
			    //if no end date, set to 0000-00-00 00:00:00
				if(($_REQUEST['day2'] > 0) && ($_REQUEST['month2'] > 0) && ($_REQUEST['year2'] > 0))
				{
					$_SESSION['day2'] = $_REQUEST['day2'];
			        $_SESSION['month2'] = $_REQUEST['month2'];
			        $_SESSION['year2'] = $_REQUEST['year2'];
					
					$enddate = $_REQUEST['year2']. "-" .$_REQUEST['month2']. "-" .$_REQUEST['day2'] . " 23:59:59";
				}
		        
				$sql = 'update ' .RATE_TABLE. '  set product_rate_id="'.$id.'", rate="'.$rate.'", campaign_id="'.$campaignid.'", rate_start_date="'.$startdate.'", rate_end_date="'.$enddate.'" where product_rate_id="'.$id.'"';
				
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RATEUPDATED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_RateManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
    	}
    	
    	return false;
    }
    
    /*
     * This method Adds new rates.
     * 
     */
     
    function drawFormAddRate()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRate';  
		if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['header'])) $_POST['header'] = "Add Product Rate";

        $this->addContent('rate_edit');
        return true;
        
    }
    
    /*
     * This method Edits new rates.
     * 
     */
     
    function drawFormEditRate()
    {
        if($_POST['commited'] != 'yes') $this->loadRateInfo($_REQUEST['rid']);

		$_POST['entryId'] = $_REQUEST['entryId'];
        $_POST['header'] = L_G_EDITRATE;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editRate';  

        $this->drawFormAddRate();
        return true;
    }
    
    function loadRateInfo($id)
     {
        $sql = 'select * from ' . RATE_TABLE.
               ' where product_rate_id='.$id;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['id'] = $rs->fields['product_rate_id'];
        $_POST['rate'] = $rs->fields['rate'];
        $_REQUEST['campaignid'] = $rs->fields['campaign_id'];
		
		$begin = explode("-", $rs->fields['rate_start_date']);
		$bYear = $begin[0];
		$bMonth = strlen($begin[1])==1?"0".$begin[1]:$begin[1];
		$bDay = strlen($begin[2])==1?"0".$begin[2]:$begin[2];
		
		$_REQUEST['month1'] = $bMonth;
		$_REQUEST['day1'] = $bDay;
		$_REQUEST['year1'] = $bYear;
		
		$end = explode("-", $rs->fields['rate_end_date']);
		$eYear = $end[0];
		$eMonth = strlen($end[1])==1?"0".$end[1]:$end[1];
		$eDay = strlen($end[2])==1?"0".$end[2]:$end[2];
		
		$_REQUEST['month2'] = $eMonth;
		$_REQUEST['day2'] = $eDay;
		$_REQUEST['year2'] = $eYear;
		
        return true;
    }
    
	/**
	 * 
	 * This is just a helper method to grab all of the id's sent in from the view.
	 * See the processDelete method for usage.
	 * 
	 */
    function _returnIds()
    {
        if($_POST['massaction'] != '')
        {
            $IDs = $_POST['itemschecked'];
        }
        else
        {
            $IDs = array($_REQUEST['id']);
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
        
        $this->pageLimitsAssign();

        $this->addContent('micro_rate_list');
    }
    

    function createWhereOrderBy(&$orderby, &$where)
    {
		if(isset($_REQUEST['show'])){
			$_SESSION['show'] = $_REQUEST['show'];
		}
		
		$_REQUEST['show'] = $_SESSION['show'];
		
		if($_REQUEST['sortby'] != '')
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by active DESC, rate_start_date ASC";
        }      
        
        if($_REQUEST['show'] == ''){
        	$where .= ' AND active = 1';
        }  else if($_REQUEST['show'] == 'inactive'){
        	$where .= ' AND active = 0';
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
		
        $sql = 'SELECT COUNT(*) as count FROM ' .  RATE_TABLE. ' as r WHERE campaign_id = ' . _q($_REQUEST['rid']);
	
		
		
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        $sql = 'SELECT * FROM ' . RATE_TABLE . ' AS r WHERE campaign_id = ' . _q($_REQUEST['rid']);
				
			
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);

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
            'rate'	=>  array('Rate', 'rate'),
            'active'	=>  array('Status', 'active'),
            'insert_time'	=>  array('Date Created', 'insert_time'),
            'rate_start_date'	=>  array('Start Date', 'rate_start_date'),
            'rate_end_date'	=>  array('End Date', 'rate_end_date'),
            'comment'	=>  array('Comment', 'comment'),
            
            'actions'	=>  array('Actions', '')
			);
    }
    
   	/**
	 * This method defines name of controller.
	**/   
    function getListViewName()
    {
        return 'rate_list';
    }
    
   	/**
	 * This method defines which columns are shown by defualt.  This must be a subset
	 * of the array defined in the getAvailableColumns method.
	**/ 
    function initViews()
    {
        $viewColumns = array(
            'rate',
            'active',
            'insert_time',
            'rate_start_date',
            'rate_end_date',
            'comment',
            
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
		
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['product_rate_id'].'"></td>';
        
        foreach($view->columns as $column)
        {
			if($row['reversed'] == 1)
				$showred = "<font color='red'>";
			else
				$showred = "";
            switch($column)
            {
                        
                case 'rate': print '<td class=listresult>&nbsp;' . $row['rate'].'&nbsp;</td>';
                        break;
    			case 'comment': print '<td class=listresult>&nbsp;' . $row['comment'].'&nbsp;</td>';
                        break;                     
                case 'insert_time': print '<td class=listresult>&nbsp;' . $row['insert_time'].'&nbsp;</td>';
                        break;                        
                case 'rate_start_date': print '<td class=listresult>&nbsp;' . $row['rate_start_date'].'&nbsp;</td>';
                        break;
                case 'rate_end_date': print '<td class=listresult>&nbsp;' . ($row['rate_end_date'] == '0000-00-00 00:00:00' ? 'Continuous' : $row['rate_end_date']).'&nbsp;</td>';
                        break;
                case 'active': print '<td class=listresult>&nbsp;' . ($row['active'] ? 'Active' : '<b><font color="red">Inactive</font></b>').'&nbsp;</td>';
                        break;
                
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                            	<option value="-">----------------------</option>
                            	<?php if($row['active']){ ?>
                            	<option value="javascript:deActivate('<?=$row['product_rate_id']?>');">Deactivate</a>
                            	<? } ?>
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
      <td align=left>&nbsp;&nbsp;&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value="-"><?=L_G_CHOOSEACTION?></option>
          <option value="deactivate">Deactivate</a>
        </select>
        &nbsp;&nbsp;
        <input type=submit class=formbutton value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
    
    /**
	 * Populate product drop-down on addRate form.
	**/
	
    function printRateAvailableProducts()
    {
    	$sql = "Select c.campaignid, c.name From " .CAMPAIGNS_TABLE. " AS c
				Where c.deleted = '0' AND
					c.commtype = '4'
				ORDER BY c.name asc";
				
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
		{
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
    		
		} else {
        	
	        $product_data = QUnit_Global::newobj('QCore_RecordSet');
	        $product_data->setTemplateRS($rs);
	        
	        print('<select name="campaignid">' .
	        		'<option value="">' .L_G_CHOOSECAMPAIGN. '</option>');
	        			
        	 while($row = $product_data->getNextRecord())
        	{
        		print('<option value="' .$row['campaignid']. '"' .($_REQUEST["campaignid"] == $row['campaignid'] ? ' selected' : ''). '>' .$row['name']. '</a>');
        	}
        	
        	print('</select>');
		}
    }
    
}
?>
