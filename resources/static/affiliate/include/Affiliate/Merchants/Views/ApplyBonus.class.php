<?php
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Bonus');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategoryGroups');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign');

class Affiliate_Merchants_Views_ApplyBonus extends QUnit_UI_ListPage{
    function process(){    	
		$this->_getOptions();
		$this->showPage();
		
		if($_REQUEST['commited']){
			$this->_saveFilter();
			$this->getTransactions();
		}
	    if($_REQUEST['applyBonus']){
		    $this->doApply();
	    }
    }
    
    function showPage(){
    	//initialize results table
    	$this->initViews();
    	
    	//default "To" Date to today
    	$this->assign('curyear', date('Y'));
    	$_REQUEST['rq_year2']?null:$_REQUEST['rq_year2']=date('Y');
    	$this->assign('curmonth', date('n'));
    	$_REQUEST['rq_month2']?null:$_REQUEST['rq_month2']=date('n');
    	$this->assign('curday', date('j'));
    	$_REQUEST['rq_day2']?null:$_REQUEST['rq_day2']=date('j')-1;
    	
    	$campCatTypes = Affiliate_Merchants_Bl_CampaignCategoryGroups::getGroupsAsArray();
    	$this->assign('a_campcategorytypes', $campCatTypes);
    	$this->assign('a_selected', Affiliate_Merchants_Bl_Campaign::getCampaignsInSet($_REQUEST['selectedcampcategory']));
    	
    	$this->addContent('apply_bonus_filter');
    }
    
    function showTransactions(){
    	$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($this->transdata);		
		
		$this->assign('a_allcount', $_REQUEST['allcount']);
		$this->pageLimitsAssign();
		$this->assign('a_list_data', $list_data);
		$this->assign('a_this', $this);
		
		$this->addContent('apply_bonus_list');
    }
    
    function doApply(){
    	if($this->_validateData()){
	    	QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');
	    	$this->getTransactions(false);
	    	//calculate Bonus amount per Transaction
	    	$amountPer = round(($_REQUEST['bonus']/$this->transdata->_numOfRows), 2);
	    	while($this->transdata && !$this->transdata->EOF){
	    		Affiliate_Merchants_Bl_Bonus::insertBonus($amountPer, $this->transdata->fields);
	    		$this->transdata->MoveNext();
	    	}
    	}
    }
    
    function getTransactions($pagination=true){
    	//initialize conditions array with mandatory information
        $conditions = array('pagination'		=>	$pagination,
        					'to'				=>	$_SESSION['filter']['to'],
        					'from'				=>	$_SESSION['filter']['from'],
		                    'rowsPerPage'		=>	$_SESSION['filter']['numrows'],
		                    'page'				=>	$_SESSION['filter']['page'],
		                    'campcategory'		=>	$_SESSION['filter']['campcategory'],
		                    'orderBy'			=>	$this->_createOrderBy());
	
		$this->transdata = Affiliate_Merchants_Bl_Bonus::getTransactions($conditions);
		if($pagination)
			$this->showTransactions();
    }
    
    function _createOrderBy(){    	
    	if($_REQUEST['sortby'] && $_REQUEST['sortorder'])
    		$orderBy = 'ORDER BY '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
    	else
    		$orderBy = 'ORDER BY providerprocessdate ASC';
    	return $orderBy;
    }
    
    function _getOptions(){
    	!$_REQUEST['campcategorytype']||$_REQUEST['campcategorytype']=='_'
    	?$this->assign('a_campaigns', Affiliate_Merchants_Bl_Campaign::getAllCampaignsWithExclude($_REQUEST['selectedcampcategory']))
    	:$this->assign('a_campaigns', Affiliate_Merchants_Bl_Campaign::getCampaignsByCampaignType($_REQUEST['campcategorytype'], $_REQUEST['selectedcampcategory']));
    }
    
    function _saveFilter(){
    	//convert dates into timestamps
    	if($_REQUEST['rq_month1']<10)$_REQUEST['rq_month1']='0'.$_REQUEST['rq_month1'];
    	if($_REQUEST['rq_day1']<10)$_REQUEST['rq_day1']='0'.$_REQUEST['rq_day1'];
    	$conditions['from'] = $_REQUEST['rq_year1'].'-'.$_REQUEST['rq_month1'].'-'.$_REQUEST['rq_day1'].' 00:00:00';
    	
		if($_REQUEST['rq_month2']<10)$_REQUEST['rq_month2']='0'.$_REQUEST['rq_month2'];
    	if($_REQUEST['rq_day2']<10)$_REQUEST['rq_day2']='0'.$_REQUEST['rq_day2'];
    	$conditions['to'] = $_REQUEST['rq_year2'].'-'.$_REQUEST['rq_month2'].'-'.$_REQUEST['rq_day2'].' 00:00:00';
    	
    	$conditions['campcategorytype'] = $_REQUEST['campcategorytype'];
    	$conditions['numrows'] = $_REQUEST['numrows'];
    	$conditions['listview'] = $_REQUEST['listview']; 
    	$conditions['byCampaign'] = $_REQUEST['byCampaign']; 

    	if($conditions['byCampaign'])
			$conditions['campcategory']=$_REQUEST['selectedcampcategory'];
		$_SESSION['filter'] = $conditions;
    }
    
    function _validateData(){
    	//convert dates into timestamps
    	$from = mktime(0,0,0,$_REQUEST['rq_month1'],$_REQUEST['rq_day1'],$_REQUEST['rq_year1']);
    	$to = mktime(23,59,59,$_REQUEST['rq_month2'],$_REQUEST['rq_day2'],$_REQUEST['rq_year2']);
    	if($to > time() || $from > time()){
    		QUnit_Messager::setErrorMessage("Please enter a date not after today.");
    		return false;
    	}
    	
    	preg_match('/[^0-9]*\.[0-9]*/', trim($_REQUEST['bonus']), $matches);
    	if($_REQUEST['bonus'] == '' || sizeof($matches) <= 0){
    		QUnit_Messager::setErrorMessage("Please enter a valid bonus amount.");
    		return false;
    	}
    	return true;
    }
//--------------------------------------------END PROCESSING FUNCTIONS----------------------------------------
    
    function printListRow($row){
		print '<td>'.$row['reftrans'].'</td>
			   <td>'.$row['bannerid'].'</td>
			   <td>'.$row['campcategoryid'].'</td>
			   <td>'.$row['affiliateid'].'</td>
			   <td>$'.$row['totalestimatedrevenue'].'</td>
			   <td>'.$row['providerprocessdate'].'</td>';
    }
    
    function getAvailableColumns()
    {
        return array(
            'reftrans'		=>  array('ID', 'reftrans'),
            'bannerid'		=>  array('Banner ID', 'bannerid'),
            'campaignid'	=>  array('Campaign ID', 'campcategoryid'),
            'affiliate'	=>  array('Affiliate', 'affiliateid'),
			'totalestimatedrevenue'	=>  array('Revenue', 'totalestimatedrevenue'),
            'providerprocessdate'	=>  array('Date', 'providerprocessdate'),
			);
    }
    
   	/**
	 * This method defines name of controller.
	**/   
    function getListViewName()
    {
        return 'ApplyBonus';
    }
    
   	/**
	 * This method defines which columns are shown by defualt.  This must be a subset
	 * of the array defined in the getAvailableColumns method.
	**/ 
    function initViews()
    {
        $viewColumns = array(
            'reftrans',
            'bannerid',
            'campaignid',
            'affiliate',
            'totalestimatedrevenue',
			'providerprocessdate');
        
        $this->createDefaultView($viewColumns);        
        $this->applyView();
    }
}
?>