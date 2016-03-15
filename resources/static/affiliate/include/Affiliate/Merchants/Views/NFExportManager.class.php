<?php


QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_NFExport');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Merchants_Views_NFExportManager extends QUnit_UI_ListPage
{

    function process() 
    {
    	
    	$zeroCom = $this->_getZeroCommissionCount();
    	if($zeroCom > 0)
    	{
    		QUnit_Messager::setErrorMessage('There are currently ' . $zeroCom . ' NETFINITI transactions with a commission of 0!');
    	}
    	
    	
    	if(isset($_REQUEST['massaction'])){
    		switch($_REQUEST['massaction']){
    			case 'approve':
    				$this->processPayout($_REQUEST['itemschecked']);
    			break;
    		}
    	}
    	
    	if(isset($_REQUEST['action'])){
    		switch($_REQUEST['action']){
    			case 'exportAll':
    				$this->processPayout($this->_getAllTransIds());
    			break;
    		}
    	}    	
    	
    	$this->showExports();
    }
    
    
    function processPayout($ids)
    {
		Affiliate_Merchants_Bl_NFExport::payout($ids);
    }
    
    function getAvailableColumns()
    {
        return array(
            'transid' =>            	array('Transaction ID', 'transid'),
            'commission' =>         	array('Commission', 'commission'),
            'dateinserted' =>       	array('Date Inserted', 't.dateinserted'),
            'campcategoryid' =>     	array('Camp. Category ID', 'campcategoryid'),
            'data1' =>     				array('Netfiniti TransID / data1 ', 'data1'),
            'providerprocessdate' =>	array(L_G_PROVIDERPROCESSDATE, 'providerprocessdate'),
            'quantity' =>            	array(L_G_QUANTITY, 'quantity'),
            'providerchannel' =>        array(L_G_PROVIDERCHANNEL, 'providerchannel'),
            'estimatedrevenue' =>       array('Estimated Revenue', 'estimatedrevenue'),
            'estimateddatafilename' =>  array(L_G_ESTIMATEDDATAFILENAME, 'estimateddatafilename'),
			'reftrans' =>            	array('TransID Reference', 'reftrans'),
			'name' =>            	array("Product Name", 'name'),
			'provider' =>            	array("Provider", 'provider')
        );
    }
    
    function showExports()
    {
    	
    	$this->initViews();
    	
    	$redirectRules = $this->getRecords();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($redirectRules);
       
        $this->assign('exports', $list_data);
        
        $this->pageLimitsAssign();
        
        $this->addContent('NFExport_filter');
        $this->addContent('NFExport_list');        	
    }
    
    function _getAllTransIds()
    {
 		$sql = 'SELECT transid FROM ' . TABLE_TRANS_RECENT . ' ';
 		$where = ' WHERE payoutstatus = 1 AND transtype = ' . TRANSTYPE_SALE . 
					' AND affiliateid = ' ._q(Affiliate_Merchants_Bl_Affiliate::getAffiliateIdByRef(NETFINITI_AID)) .
					' AND data1 !=  "" AND commission > 0';

        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $trans = array();
        
        while (!$rs->EOF){
        	$trans[] = $rs->fields['transid'];
        	$rs->MoveNext();
        	
        }
        
        return $trans;    	
    }
    
    function _getZeroCommissionCount()
    {
 		$sql = 'SELECT COUNT(*) as cnt FROM ' . TABLE_TRANS_RECENT . ' ';
 		$where = ' WHERE payoutstatus = 1 AND transtype = ' . TRANSTYPE_SALE . 
					' AND affiliateid = ' ._q(Affiliate_Merchants_Bl_Affiliate::getAffiliateIdByRef(NETFINITI_AID)) .
					' AND data1 !=  "" AND commission <= 0';

        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        return $rs->fields['cnt'];    	
    }
    
    function getRecords()
    {
		$this->createWhereOrderBy(&$orderby, &$where);
		
        $sql = 'SELECT COUNT(*) as count FROM ' . TABLE_TRANS_RECENT . ' AS t' .
        		' Left Join ' . CAMPAIGN_CATEGORIES_TABLE . ' AS cc ON t.campcategoryid = cc.campcategoryid' .
        		' Left Join ' . CAMPAIGNS_TABLE . ' AS c ON cc.campaignid = c.campaignid' .
        		' Left Join ' . PROVIDER_TABLE . ' AS p ON t.providerid = p.provider_id';
        
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        
        $sql = 'SELECT c.campaignid, c.name, p.name as provider, t.* FROM ' . TABLE_TRANS_RECENT . ' AS t' .
        		' Left Join ' . CAMPAIGN_CATEGORIES_TABLE . ' AS cc ON t.campcategoryid = cc.campcategoryid' .
        		' Left Join ' . CAMPAIGNS_TABLE . ' AS c ON cc.campaignid = c.campaignid' .
        		' Left Join ' . PROVIDER_TABLE . ' AS p ON t.providerid = p.provider_id';
        		
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, 20, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        return $rs;
    }
    
    function createWhereOrderBy(&$orderby, &$where)
    {
    	if($_REQUEST['sortby'] != '')
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
    	
		$where = ' WHERE payoutstatus = 1 AND transtype = ' . TRANSTYPE_SALE . 
					' AND affiliateid = ' ._q(Affiliate_Merchants_Bl_Affiliate::getAffiliateIdByRef(NETFINITI_AID)) .
					' AND data1 !=  ""';
					
		
		/*if($_REQUEST['file']){
			$where .= ' AND estimateddatafilename='._q($_REQUEST['file']);
			$orderby = ' GROUP BY estimateddatafilename';
		}
		if($_REQUEST['beginDay'] && $_REQUEST['beginMonth'] && $_REQUEST['beginYear']){
			if(!$_REQUEST['endDay'] || !$_REQUEST['endMonth'] || !$_REQUEST['endYear']){
				$_REQUEST['endDay'] = date("j");
				$_REQUEST['endMonth'] = date("n");
				$_REQUEST['endYear'] = date("Y");
			}

			$where .= ' AND ';
			$where .= 'DATE(dateestimated)>=DATE("'.$_REQUEST['beginYear'].'-'.$_REQUEST['beginMonth'].'-'.$_REQUEST['beginDay'].'") AND DATE(dateestimated)<=DATE("'.$_REQUEST['endYear'].'-'.$_REQUEST['endMonth'].'-'.$_REQUEST['endDay'].'")';
			$orderby = ' ORDER BY dateestimated';
		}*/
    }
    
    function getListViewName()
    {
    	return 'NFExport_list';	
    }
    
    function initViews()
    {
    	
        $viewColumns = array(
            'transid',
            'reftrans',
            'data1',
            'commission',
            'estimatedrevenue',
            'dateinserted',
            'campcategoryid',
			'quantity',
			'name',
			'provider',
            'providerprocessdate',
            'providerchannel',
            'estimateddatafilename'
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
    
    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['transid'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'transid': print '<td class=listresult>&nbsp;'.$row['transid'].'&nbsp;</td>';
                        break;
                        
                case 'commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['commission'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['commission']) : '').'&nbsp;</td>';
                        break;

                case 'dateinserted': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateinserted'].'&nbsp;</td>';
                        break;
				case 'data1': print '<td class=listresult align=right nowrap>&nbsp;'.$row['data1'].'&nbsp;</td>';
                        break;
                        
                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['productid'].'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'.$this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;
                case 'providerprocessdate': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerprocessdate'].'&nbsp;</td>';
                        break;
                case 'provider': print '<td class=listresult align=right nowrap>&nbsp;'.$row['provider'].'&nbsp;</td>';
                        break;
                case 'quantity': print '<td class=listresult align=right nowrap>&nbsp;'.$row['quantity'].'&nbsp;</td>';
                        break;
                case 'providerchannel': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerchannel'].'&nbsp;</td>';
                        break;
                case 'estimatedrevenue': print '<td class=listresult align=right nowrap>&nbsp;'. Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue']) .'&nbsp;</td>';
                        break;
                case 'reftrans': print '<td class=listresult align=right nowrap>&nbsp;'.$row['reftrans'].'&nbsp;</td>';
                        break;
                case 'estimateddatafilename': print '<td class=listresult align=right nowrap>&nbsp;'.$row['estimateddatafilename'].'&nbsp;</td>';
                        break;
                case 'providerchannel': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerchannel'].'&nbsp;</td>';
                        break;
                case 'name': print '<td class=listresult align=right nowrap>&nbsp;'.$row['name'].'&nbsp;</td>';
                        break;
                        
				case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
       
                                <? if($this->checkPermissions('approve')) { ?>
                                  <? if($row['rstatus'] != AFFSTATUS_APPROVED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['transid']?>','approve');"><?=L_G_APPROVE?></a>
                                  <? } ?>
                                  <? if($row['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['transid']?>','suppress');"><?=L_G_SUPPRESS?></a>
                                <?   }
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['transid']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
                            </select>
                        </td>
<?
                        break;
                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.' '.$column.'</font>&nbsp;</td>';
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
          <option value=""><?=L_G_CHOOSEACTION?></option>
          <? 
             if($this->checkPermissions('approve')) { ?>
               <option value="approve"><?=L_G_APPROVE?></a>
          <? } ?>

        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
}
?>