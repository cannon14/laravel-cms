<?
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Merchants');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_BankRules');

class Affiliate_Merchants_Views_MerchantManager extends QUnit_UI_ListPage
{
    function initPermissions()
    {
		//TODO
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['massaction'])){
    		switch($_POST['massaction']){
    			case 'delete':
    			    if($this->processDeleteMerchants())
                        return;
                break;
    		}
        }
        
        if(!empty($_POST['commited'])){
            switch($_POST['postaction'])
            {
                case 'create':
                    if($this->processCreateMerchant())
                        return;
                    break;
                
                case 'update':
                    if($this->processUpdateMerchant())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action'])){
            switch($_REQUEST['action'])
            {
                case 'create':
                    if($this->drawFormCreateMerchant())
                        return;
                    break;       
                
                case 'update':
                    if($this->drawFormUpdateMerchant())
                        return;
                    break;       
                
                case 'delete':
                    if($this->processDeleteMerchants())
                        return;
                    break;
            }
        }
        
        $this->showMerchants(false);
    }
    
    function processDeleteMerchants()
    {
    	$ids = $this->returnEIDs();
    	if(!is_array($ids)){
    		$ids = array($ids);
    	}
    	
    	$result = Affiliate_Merchants_Bl_Merchants::deleteMerchants($ids);
    	
    	if($result !== false){
    		QUnit_Messager::setOkMessage('Merchant Deleted.');	
    	}
    }

    function drawFormUpdateMerchant()
    {
    	$merchant = $this->_loadMerchantInfo($_REQUEST['merchantId']);
    	
    	
    	$this->assign('merchantId', 	$merchant['merchant_id']);
		$this->assign('shortName', 		$merchant['short_name']);
		$this->assign('longName', 		$merchant['long_name']);
		$this->assign('bankRule', 		$merchant['bank_rule']);
		$this->assign('description', 	$merchant['description']);
		$this->assign('addressLine1',	$merchant['address_line_1']);
		$this->assign('addressLine2',	$merchant['address_line_2']);
		$this->assign('city', 			$merchant['city']);
		$this->assign('state', 			$merchant['state']);
		$this->assign('zipCode', 		$merchant['zip_code']);
		$this->assign('phone', 			$merchant['phone']);
		$this->assign('contact', 		$merchant['contact']);
    	
    	$this->assign('bankRules',		Affiliate_Merchants_Bl_BankRules::getBankRules());
    	
    	$this->assign('header', 		'Update Merchant');
    	$this->assign('postAction', 	'update');
    	$this->assign('action', 		'update');
    	
    	$this->addContent('merchants_edit'); 
    	
    	return true;    	
    }
    
    function processUpdateMerchant()
    {
    	$params['merchant_id'] 		= $_REQUEST['merchantId'];
    	$params['short_name'] 		= $_REQUEST['shortName'];
    	$params['long_name'] 		= $_REQUEST['longName'];
    	$params['bank_rule'] 		= $_REQUEST['bankRule'];
    	$params['description'] 		= $_REQUEST['description'];
    	$params['address_line_1'] 	= $_REQUEST['addressLine1'];
    	$params['address_line_2'] 	= $_REQUEST['addressLine2'];
    	$params['city'] 			= $_REQUEST['city'];
    	$params['state'] 			= $_REQUEST['state'];
    	$params['zip_code'] 		= $_REQUEST['zipCode'];
    	$params['phone'] 			= $_REQUEST['phone'];
    	$params['contact'] 			= $_REQUEST['contact'];
    	
    	$result = Affiliate_Merchants_Bl_Merchants::updateMerchant($params);
    	
    	if($result !== false){
    		QUnit_Messager::setOkMessage('Merchant Updated.');	
    		$this->closeWindow('Affiliate_Merchants_Views_MerchantManager');
            $this->addContent('tracking_closewindow');
            return true;
    	}
    	
    	return false;      
    }

   
    
    function _loadMerchantInfo($id)
    {
		return Affiliate_Merchants_Bl_Merchants::getMerchantByMerchantId($id);
    }

    
    

    
    
    function drawFormCreateMerchant()
    {
    	
    	$this->assign('header', 	'Create Merchant');
    	$this->assign('postAction', 'create');
    	$this->assign('action', 	'create');
    	
    	    	
    	$this->assign('bankRules',		Affiliate_Merchants_Bl_BankRules::getBankRules());
    	
    	
		$this->addContent('merchants_edit');     
		
		return true; 
    }
    
    
    function processCreateMerchant()
    {
    	$params['short_name'] 		= $_REQUEST['shortName'];
    	$params['long_name'] 		= $_REQUEST['longName'];
    	$params['bank_rule'] 		= $_REQUEST['bankRule'];
    	$params['description'] 		= $_REQUEST['description'];
    	$params['address_line_1'] 	= $_REQUEST['addressLine1'];
    	$params['address_line_2'] 	= $_REQUEST['addressLine2'];
    	$params['city'] 			= $_REQUEST['city'];
    	$params['state'] 			= $_REQUEST['state'];
    	$params['zip_code'] 		= $_REQUEST['zipCode'];
    	$params['phone'] 			= $_REQUEST['phone'];
    	$params['contact'] 			= $_REQUEST['contact'];
    	
    	$result = Affiliate_Merchants_Bl_Merchants::createMerchant($params);
    	
    	if($result !== false){
    		QUnit_Messager::setOkMessage('Merchant Created.');	
    		$this->closeWindow('Affiliate_Merchants_Views_MerchantManager');
            $this->addContent('tracking_closewindow');
            return true;
    	}
    	
    	return false;
    	
    }    

    function getRecords($orderby, $where)
    {
        if($_REQUEST['runQuery'] == 'false'){
			$_POST['runQuery'] = 'false';
			return;
		}
		
		
        $sql = 'SELECT COUNT(*) AS count FROM ' . MERCHANTS_TABLE;
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
    
        $sql = 'SELECT * FROM ' . MERCHANTS_TABLE;
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
    
    function getAvailableColumns()
    {
        $a = array();
        
        		$a = array(
            		'merchant_id' =>        array("Merchant ID", 'merchant_id'),
            		'short_name' =>       	array("Short Name", 'short_name'),
            		'long_name' =>       	array("Long Name", 'long_name'),
            		'description' =>       	array("Description", 'description'),
            		'merchant_type' =>       		array("Type", 'type'),
            		'account_number' =>     array("Account ID", 'account_number'),
            		'address_line_1' =>     array("Address Line 2", 'address_line_1'),
            		'address_line_2' =>     array("Address Line 2", 'address_line_2'),
            		'city' =>       		array("City", 'city'),
            		'state' =>       		array("Province", 'state'),
            		'zip_code' =>       	array("Zip", 'zip_code'),
            		'phone' =>       		array("Phone", 'phone'),
            		'contact' =>       		array("Contact", 'contact'),
            		'notes' =>       		array("Notes", 'notes'),
            		'active' =>       		array("Active", 'active'),
            		'insert_date' =>   		array(L_G_JOINED, 'insert_date'),
					'merchactions' =>       array(L_G_ACTIONS, ''),
			        );
        
        return $a;
    }
    

    function getListViewName()
    {
        return 'Merchant_List';
    }

    function initViews()
    {
    	

		$viewColumns = array(
            		'merchant_id',
            		'short_name',
            		'long_name',
            		//'description', 
            		//'type',
            		//'account_number', 
            		'address_line_1', 
            		'address_line_2',
            		'city',
            		'state',
            		'zip_code',
            		'phone' ,
            		'contact', 
            		//'notes',
            		//'active',
            		'insert_date',
					'merchactions', 
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

    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';
        

        if($_REQUEST['sortby'] != '') {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        
        $where = ' where deleted != 1 ';
        
        if($_REQUEST['search'] != null){
        	$where .= ' AND (' . $a[0] .' = ' . _q($_REQUEST['search']) . ' OR  ' . 
        	$a[1] . ' LIKE ' . _q('%'. $_REQUEST['search'] .'%') .')';
        }

        return true;
    }
    
    function showMerchants($exportToCsv)
    {

        $this->createWhereOrderBy($orderby, $where);
       

        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }

        $recs = $this->getRecords($orderby, $where);
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);
        
        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));
        
        $this->pageLimitsAssign();

        $this->addContent('merchants_list');        
    }    
    
    //--------------------------------------------------------------------------

    function printListRow($row)
    {
		
		$view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
        
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['merchant_id'].'"></td>';
        
        foreach($view->columns as $column)
        {

            switch($column)
            {
              
                        
                case 'merchant_id': print '<td class=listresult nowrap>&nbsp;'.$row['merchant_id'].'&nbsp;</td>';
                        break;
                        
                case 'short_name': print '<td class=listresult nowrap>&nbsp;'.$row['short_name'].'&nbsp;</td>';
                        break;
                        
                case 'long_name': print '<td class=listresult nowrap>&nbsp;'.$row['long_name'].'&nbsp;</td>';
                        break;
                        
                case 'description': print '<td class=listresult nowrap>&nbsp;'.$row['description'].'&nbsp;</td>';
                        break;
                        
                case 'type': print '<td class=listresult nowrap>&nbsp;'.$row['type'].'&nbsp;</td>';
                        break;
                        
                case 'account_number': print '<td class=listresult nowrap>&nbsp;'.$row['account_number'].'&nbsp;</td>';
                        break;
                        
                case 'address_line_1': print '<td class=listresult nowrap>&nbsp;'.$row['address_line_1'].'&nbsp;</td>';
                        break;
                        
                case 'address_line_2': print '<td class=listresult nowrap>&nbsp;'.$row['address_line_2'].'&nbsp;</td>';
                        break;
                        
                case 'city': print '<td class=listresult nowrap>&nbsp;'.$row['city'].'&nbsp;</td>';
                        break;
                        
                case 'state': print '<td class=listresult nowrap>&nbsp;'.$row['state'].'&nbsp;</td>';
                        break;
                        
                case 'zip_code': print '<td class=listresult nowrap>&nbsp;'.$row['zipCode'].'&nbsp;</td>';
                        break;
                        
                case 'phone': print '<td class=listresult nowrap>&nbsp;'.$row['phone'].'&nbsp;</td>';
                        break;
                        
                case 'contact': print '<td class=listresult nowrap>&nbsp;'.$row['contact'].'&nbsp;</td>';
                        break;
                        
                case 'notes': print '<td class=listresult nowrap>&nbsp;'.$row['notes'].'&nbsp;</td>';
                        break;
                        
                case 'active': print '<td class=listresult nowrap>&nbsp;'.$row['active'].'&nbsp;</td>';
                        break;
                        
                case 'insert_date': print '<td class=listresult nowrap>&nbsp;'.$row['insert_date'].'&nbsp;</td>';
                        break;
                        
                case 'merchactions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <option value="javascript:updateMerchant('<?=$row['merchant_id']?>');"><?=L_G_EDIT?></option>
                                <option value="javascript:deleteMerchant('<?=$row['merchant_id']?>');"><?=L_G_DELETE?></option>                      
                            </select>
                        </td>
<?
                        break;

                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
                        break;
            }
        }
    }
    
    //--------------------------------------------------------------------------

    function printMassAction()
    {
?>
      <td align=left>&nbsp;&nbsp;&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value="-"><?=L_G_CHOOSEACTION?></option>
          <? if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit class=formbutton value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
    
    function returnEIDs()
    {
        if($_POST['massaction'] != '')
        {
            $eIDs = $_POST['itemschecked'];
        }
        else
        {
            $eIDs = array($_REQUEST['merchantId']);
        }
        
        return $eIDs;
    }	
    
    
    
    function printTrackingAvailableViews($className)
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '') {
            return false;
        }
            
        print '&nbsp;'.L_G_LISTVIEW.'&nbsp;<select name="list_view">';
        
        foreach($this->availableViews as $objView) {
            print '<option value="'.$objView->dbid.'" '.($_REQUEST['list_view'] == $objView->dbid ? 'selected' : '').'>'.$objView->getName().'</option>';
        }
        
        print '</select>&nbsp;<input type="button" onClick="submitTrackingView()" value="'.L_G_CHANGEVIEW.'">';
        
        print '&nbsp;&nbsp;&nbsp;';
        if($_REQUEST['list_view'] != '_' && $_REQUEST['list_view'] != '')
        {
            print '<a class="simplelink" href="javascript:editTrackingView(\''.$_REQUEST['list_view'].'\', \''.$className.'\');">'.L_G_EDITVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
            print '<a class="simplelink" href=\'javascript:deleteTrackingView("'.$_REQUEST['list_view'].'", "'.$className.'", "'.L_G_CONFIRMDELETEVIEW.'");\'>'.L_G_DELETEVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
        }
        print '<a class="simplelink" href="javascript:addTrackingView(\''.$className.'\');">'.L_G_NEWVIEW.'</a>';
    } 
}  
?>
    
  