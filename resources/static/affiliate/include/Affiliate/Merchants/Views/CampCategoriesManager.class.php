<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

class Affiliate_Merchants_Views_CampCategoriesManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['addcategory'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['editcategory'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['add'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['edit'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['delete'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['view'] = 'aff_camp_product_categories_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'addcategory':
                    if($this->processAddCategory())
                        return;
                    break;
                
                case 'editcategory':
                    if($this->processEditCategory())
                        return;
                    break;
            }
        }
        
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add':
                    if($this->drawFormAddCategory())
                        return;
                    break;              
                
                case 'edit':
                    if($this->drawFormEditCategory())
                        return;
                    break;
                
                case 'delete':
                    if($this->processDeleteCategory())
                        return;
                    break;         
            }
        }
        
        $this->showCategories($_POST['cid']);
    }  
    
    //--------------------------------------------------------------------------
    
    function processDeleteCategory()
    {
        $CategoryID = preg_replace('/[\'\"]/', '', $_REQUEST['catid']);
        $sql = 'update wd_pa_campaigncategories set deleted=1 where campcategoryid='._q($CategoryID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $this->redirect('Affiliate_Merchants_Views_CampaignManager&action=edit&cid='.$_REQUEST['cid']);
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCategory()
    {
        // protect against script injection    
        $params = Affiliate_Merchants_Bl_CampaignCategories::protectVars();
        $this->checkCategoryCorrectness($params['CampaignID']);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawFormEditCategory();
            return true;
        }
        else
        {
            // now update commissions
            if(!Affiliate_Merchants_Bl_CampaignCategories::updateCategory($params))
            {
                return false;
            }
            
            QUnit_Messager::setOkMessage(L_G_CATEGORYEDITED);
            
            $this->closeWindow('Affiliate_Merchants_Views_ProductManager&action=edit&cid='.$params['CampaignID'].'&sheet=specialcommissions');
            $this->addContent('closewindow');
            
            return true;
        }
        
        return false;
    }  
    
    //--------------------------------------------------------------------------
    
    function processAddCategory()
    {
        // protect against script injection    
        $params = Affiliate_Merchants_Bl_CampaignCategories::protectVars();
        $this->checkCategoryCorrectness($params['CampaignID']);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawFormAddCategory();
            return true;
        }
        else
        {
            // insert campaigncategory to db
            $UserCategoryID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigncategories', 'campcategoryid');
            $sql = 'insert into wd_pa_campaigncategories '.
                   '(campcategoryid,campaignid,name,clickcommission,salecommission,'.
                   'salecommtype,stsalecommtype,recurringcommission,recurringcommtype,'.
                   'recurringdatetype,strecurringcommtype)'.
                   ' values ('._q($UserCategoryID).','._q($params['CampaignID']).
                   ','._q($params['catname']).','._q($params['clickcommission']).
                   ','._q($params['salecommission']).','._q($params['salecommtype']).
                   ','._q($params['stsalecommtype']).','._q($params['recurringcommission']).
                   ','._q($params['recurringcommtype']).','._q($params['recurringdatetype']).
                   ','._q($params['strecurringcommtype']).')';
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            $_POST['catid'] = $UserCategoryID;
            $params['CategoryID'] = $UserCategoryID;
            
            // now update commissions
            if(!Affiliate_Merchants_Bl_CampaignCategories::updateCategory($params))
            {
                return false;
            }
            
            QUnit_Messager::setOkMessage(L_G_CATEGORYADDED);
            
            $this->closeWindow('Affiliate_Merchants_Views_ProductManager&action=edit&cid='.$params['CampaignID'].'&sheet=specialcommissions');
            $this->addContent('closewindow');
            
            return true;
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormEditCategory()
    {
        if($_POST['commited'] != 'yes')
        {
            $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);
            $CategoryID = preg_replace('/[\'\"]/', '', $_REQUEST['catid']);
            
            // get option from campaign
            $sql = 'select * from wd_pa_campaigns '.
                   'where deleted=0 and campaignid='._q($CampaignID).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if (!$rs || $rs->EOF)
            {      
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray($rs->fields['commtype']);
            $_POST['commtypenoarray'] = $rs->fields['commtype'];
            
            $CategoryID = preg_replace('/[\'\"]/', '', $_REQUEST['catid']);
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($CampaignID).' and campcategoryid='._q($CategoryID);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if (!$rs || $rs->EOF)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }        
            
            $_POST['cid'] = $CampaignID;
            $_POST['catid'] = $rs->fields['campcategoryid'];
            $_POST['catname'] = $rs->fields['name'];
            $_POST['cpmcommission'] = $rs->fields['cpmcommission'];
            $_POST['clickcommission'] = $rs->fields['clickcommission'];
            $_POST['salecommission'] = $rs->fields['salecommission'];
            $_POST['st2clickcommission'] = ($rs->fields['st2clickcommission'] == 0 ? '' : $rs->fields['st2clickcommission']);
            $_POST['st2salecommission'] = ($rs->fields['st2salecommission'] == 0 ? '' : $rs->fields['st2salecommission']);
            $_POST['st3clickcommission'] = ($rs->fields['st3clickcommission'] == 0 ? '' : $rs->fields['st3clickcommission']);
            $_POST['st3salecommission'] = ($rs->fields['st3salecommission'] == 0 ? '' : $rs->fields['st3salecommission']);
            $_POST['st4clickcommission'] = ($rs->fields['st4clickcommission'] == 0 ? '' : $rs->fields['st4clickcommission']);
            $_POST['st4salecommission'] = ($rs->fields['st4salecommission'] == 0 ? '' : $rs->fields['st4salecommission']);
            $_POST['st5clickcommission'] = ($rs->fields['st5clickcommission'] == 0 ? '' : $rs->fields['st5clickcommission']);
            $_POST['st5salecommission'] = ($rs->fields['st5salecommission'] == 0 ? '' : $rs->fields['st5salecommission']);
            $_POST['st6clickcommission'] = ($rs->fields['st6clickcommission'] == 0 ? '' : $rs->fields['st6clickcommission']);
            $_POST['st6salecommission'] = ($rs->fields['st6salecommission'] == 0 ? '' : $rs->fields['st6salecommission']);
            $_POST['st7clickcommission'] = ($rs->fields['st7clickcommission'] == 0 ? '' : $rs->fields['st7clickcommission']);
            $_POST['st7salecommission'] = ($rs->fields['st7salecommission'] == 0 ? '' : $rs->fields['st7salecommission']);
            $_POST['st8clickcommission'] = ($rs->fields['st8clickcommission'] == 0 ? '' : $rs->fields['st8clickcommission']);
            $_POST['st8salecommission'] = ($rs->fields['st8salecommission'] == 0 ? '' : $rs->fields['st8salecommission']);
            $_POST['st9clickcommission'] = ($rs->fields['st9clickcommission'] == 0 ? '' : $rs->fields['st9clickcommission']);
            $_POST['st9salecommission'] = ($rs->fields['st9salecommission'] == 0 ? '' : $rs->fields['st9salecommission']);
            $_POST['st10clickcommission'] = ($rs->fields['st10clickcommission'] == 0 ? '' : $rs->fields['st10clickcommission']);
            $_POST['st10salecommission'] = ($rs->fields['st10salecommission'] == 0 ? '' : $rs->fields['st10salecommission']);
            
            $_POST['salecommtype'] = $rs->fields['salecommtype'];
            $_POST['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $_POST['recurringcommission'] = $rs->fields['recurringcommission'];
            $_POST['st2recurringcommission'] = ($rs->fields['st2recurringcommission'] == 0 ? '' : $rs->fields['st2recurringcommission']);
            $_POST['st3recurringcommission'] = ($rs->fields['st3recurringcommission'] == 0 ? '' : $rs->fields['st3recurringcommission']);
            $_POST['st4recurringcommission'] = ($rs->fields['st4recurringcommission'] == 0 ? '' : $rs->fields['st4recurringcommission']);
            $_POST['st5recurringcommission'] = ($rs->fields['st5recurringcommission'] == 0 ? '' : $rs->fields['st5recurringcommission']);
            $_POST['st6recurringcommission'] = ($rs->fields['st6recurringcommission'] == 0 ? '' : $rs->fields['st6recurringcommission']);
            $_POST['st7recurringcommission'] = ($rs->fields['st7recurringcommission'] == 0 ? '' : $rs->fields['st7recurringcommission']);
            $_POST['st8recurringcommission'] = ($rs->fields['st8recurringcommission'] == 0 ? '' : $rs->fields['st8recurringcommission']);
            $_POST['st9recurringcommission'] = ($rs->fields['st9recurringcommission'] == 0 ? '' : $rs->fields['st9recurringcommission']);
            $_POST['st10recurringcommission'] = ($rs->fields['st10recurringcommission'] == 0 ? '' : $rs->fields['st10recurringcommission']);
            $_POST['recurringcommtype'] = $rs->fields['recurringcommtype'];
            $_POST['recurringdatetype'] = $rs->fields['recurringdatetype'];
            $_POST['strecurringcommtype'] = $rs->fields['strecurringcommtype'];
            
            if($_POST['recurringcommission'] != '' && $_POST['recurringcommission'] != '0')
            $_POST['recurring'] = 1;
        }
        else
        {
            // convert commtype sent by form to array
            Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray($_POST['commtypenoarray']);
        }
        
        $_POST['header'] = L_G_EDITCOMMCATEGORY;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editcategory';  
        
        $this->assign('a_commissions', $this->getTemplateName('commissions'));
        
        $this->addContent('campcategories_edit');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormAddCategory()
    {
        if(!isset($_POST['postaction']))
        {
            $_POST['postaction'] = 'addcategory';
        }
        
        if(!isset($_POST['header']))
        {
            $_POST['header'] = L_G_ADDCOMMCATEGORY;
        }
        
        // get option from campaign
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);
        
        $sql = 'select * from wd_pa_campaigns '.
               'where deleted=0 and campaignid='._q($campaignid).' and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {      
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray($rs->fields['commtype']);

        $this->assign('a_commissions', $this->getTemplateName('commissions'));
        
        $this->addContent('campcategories_edit');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function showCategories($CampaignID)
    {
        $sql = 'select ac.campcategoryid, ac.name, c.commtype, ac.clickcommission,'.
               ' ac.salecommission, ac.salecommtype, ac.stsalecommtype '.
               'from wd_pa_campaigncategories ac, wd_pa_campaigns c '.
               'where ac.campaignid=c.campaignid and ac.campaignid='._q($CampaignID).
               '  and ac.deleted=0 and c.deleted=0 and c.accountid='._q($GLOBALS['Auth']->getAccountID());
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $affiliatesCount = Affiliate_Merchants_Views_CampCategoriesManager::getAffiliatesCount($CampaignID);
        
        $data = array();
        $first = true;
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['affiliatescount'] = $affiliatesCount[$rs->fields['campcategoryid']];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['clickcommission'] = ($rs->fields['clickcommission'] == '' || $rs->fields['clickcommission'] == '0' ? '-' : $rs->fields['clickcommission']);
            $temp['salecommission'] = ($rs->fields['salecommission'] == ''  || $rs->fields['salecommission'] == '0' ? '-' : $rs->fields['salecommission']);
            if($rs->fields['name'] == UNASSIGNED_USERS)
            {
                $temp['basiccategory'] = true;
                $first = false;
            }
            else
            {
                $temp['basiccategory'] = false;
            }
            
            $data[] = $temp;
            
            $rs->MoveNext();
        }
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        
        $this->assign('a_list_data', $list_data);
        
        $this->addContent('campcategories_list');
    }
    
    //--------------------------------------------------------------------------
    
    function getCategoriesAsArray($CampaignID)
    {
        $sql = 'select * from wd_pa_campaigncategories c where c.deleted=0 and c.campaignid='.myquotes($CampaignID).'order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $affcat = array();
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['clickcommission'] = ($rs->fields['clickcommission'] == '' || $rs->fields['clickcommission'] == '0' ? '-' : $rs->fields['clickcommission']);
            $temp['stclickcommission'] = ($rs->fields['stclickcommission'] == '' || $rs->fields['stclickcommission'] == '0' ? '-' : $rs->fields['stclickcommission']);
            $temp['salecommission'] = ($rs->fields['salecommission'] == ''  || $rs->fields['salecommission'] == '0' ? '-' : $rs->fields['salecommission']);
            $temp['stsalecommission'] = ($rs->fields['stsalecommission'] == ''  || $rs->fields['stsalecommission'] == '0' ? '-' : $rs->fields['stsalecommission']);
            
            $affcat[$rs->fields['campcategoryid']] = $temp;
            
            $rs->MoveNext();
        }
        
        return $affcat;
    }
    
    //--------------------------------------------------------------------------
    
    function getCampCategoriesAsArray()
    {
        $sql = 'select cc.campcategoryid, c.name from wd_pa_campaigns c, wd_pa_campaigncategories cc '.
        ' where c.campaignid=cc.campaignid '.
        '   and c.deleted=0 and cc.deleted=0'.
        '   and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
        '   order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $data = array();
        
        while(!$rs->EOF)
        {
            $data[$rs->fields['campcategoryid']] = $rs->fields['name'];
            
            $rs->MoveNext();
        }
        
        return $data;
    }
    
    //--------------------------------------------------------------------------
    
    function checkCategoryExists($catname, $cid = '', $CampaignID)
    {
        $sql = 'select * from wd_pa_campaigncategories where deleted=0 and campaignid='._q($CampaignID).' and name='._q($catname);
        if($cid != '')
        {
            $sql .= ' and campcategoryid<>'._q($cid);
        }

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        if($rs->EOF)
        {
            return false;
        }
        
        return true;
    }  
    
    //--------------------------------------------------------------------------
    
    function getAffiliatesCount($CampaignID)
    {
        
        $affiliatesCount = array();      
        
        $sql = 'select campcategoryid from wd_pa_campaigncategories where deleted=0 and campaignid='.myquotes($CampaignID).' order by campcategoryid asc';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $basicCategory = false;
        while(!$rs->EOF)
        {
            $affiliatesCount[$rs->fields['campcategoryid']] = 0;
            if(!$basicCategory)
            $basicCategory = $rs->fields['campcategoryid'];
            
            $rs->MoveNext();
        }
        
        $sql = 'select cc.campcategoryid, count(a.userid) as countaffiliates '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc, wd_g_users a '.
               'where a.userid=ac.affiliateid and a.deleted=0 '.
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and cc.campaignid='._q($CampaignID).
               '  and a.accountid='._q($GLOBALS['Auth']->getAccountID()).
               ' group by cc.campcategoryid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $totalAssignedUsers = 0;
        while(!$rs->EOF)
        {
            $affiliatesCount[$rs->fields['campcategoryid']] = $rs->fields['countaffiliates'];
            $totalAssignedUsers += $rs->fields['countaffiliates'];
            
            $rs->MoveNext();
        }
        
        // get total number of users
        $sql = 'select count(userid) as countaffiliates from wd_g_users '.
        'where deleted=0 and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $totalUsers = $rs->fields['countaffiliates'];
        
        $affiliatesCount[$basicCategory] += $totalUsers - $totalAssignedUsers;
        
        return $affiliatesCount;
    }  
    
    //--------------------------------------------------------------------------
    
    function checkCategoryCorrectness($CampaignID)
    {
        // protect against script injection
        $params = Affiliate_Merchants_Bl_CampaignCategories::protectVars();
        
        $maxCommissionLevels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
        if($maxCommissionLevels == '')
            $maxCommissionLevels = 1;

        // check correctness of the fields
        checkCorrectness($_POST['catname'], $params['catname'], L_G_CATEGORYNAME, CHECK_EMPTYALLOWED);
        
        
        if($_POST['catname'] != '' && Affiliate_Merchants_Views_CampCategoriesManager::checkCategoryExists($params['catname'], $params['CategoryID'], $CampaignID))
        {
            QUnit_Messager::setErrorMessage(L_G_CATEGORYEXISTS);
        }
        
        
        if($params['commtype'] == TRANSTYPE_CLICK || $params['commtype'] == TRANSTYPE_CLICKPERSALE ) 
        {
            checkCorrectness($_POST['clickcommission'], $params['clickcommission'], L_G_CLICKCOMMISSIONAMOUNT, CHECK_EMPTYALLOWED, CHECK_NUMBER);
            
            // check correctness of multi tier commissions
            for($i=2; $i<=$maxCommissionLevels; $i++)
            {
                $params['stcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'clickcommission']);
                checkCorrectness($_POST['st'.$i.'clickcommission'], $params['stcommission'], $i.' - '.L_G_TIER.' '.L_G_CLICKCOMMISSIONAMOUNT, CHECK_ALLOWED, CHECK_NUMBER);
            }
        }
        
        if(($params['commtype'] & TRANSTYPE_SALE) || ($params['commtype'] & TRANSTYPE_LEAD)) 
        {
            if($params['commtype'] & TRANSTYPE_SALE)
            {
                checkCorrectness($_POST['salecommission'], $params['salecommission'], L_G_SALECOMMISSIONAMOUNT, CHECK_EMPTYALLOWED, CHECK_NUMBER);
            }
            else 
            {
                // per lead
                checkCorrectness($_POST['salecommission'], $params['salecommission'], L_G_SALECOMMISSIONAMOUNT, CHECK_EMPTYALLOWED, CHECK_NUMBER);
            }
            
            // check correctness of multi tier commissions
            for($i=2; $i<=$maxCommissionLevels; $i++)
            {
                $params['stcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'salecommission']);
                checkCorrectness($_POST['st'.$i.'salecommission'], $params['stcommission'], $i.' - '.L_G_TIER.' '.L_G_SALECOMMISSIONAMOUNT, CHECK_ALLOWED, CHECK_NUMBER);
            }
            
            checkCorrectness($_POST['salecommtype'], $params['salecommtype'], L_G_COMMISSIONTYPE, CHECK_ALLOWED);
            
            if($params['salecommtype'] == '')
            QUnit_Messager::setErrorMessage(L_G_COMMISSIONTYPEMUSTBECHOSEN);
        }
        
        if($params['recurring'] == 1)
        {
            checkCorrectness($_POST['recurringcommission'], $params['recurringcommission'], L_G_RECCOMMISSIONAMOUNT, CHECK_EMPTYALLOWED, CHECK_NUMBER);
            
            // check correctness of multi tier commissions
            for($i=2; $i<=$maxCommissionLevels; $i++)
            {
                $params['stcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'recurringcommission']);
                checkCorrectness($_POST['st'.$i.'recurringcommission'], $params['stcommission'], $i.' - '.L_G_TIER.' '.L_G_SALECOMMISSIONAMOUNT, CHECK_ALLOWED, CHECK_NUMBER);
            }
        }
        
        return;
    }
    
    //--------------------------------------------------------------------------
    
    function getCampCategoriesForRulesAsArray($params)
    {
        $sql = 'select cc.campcategoryid, cc.name '.
               'from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
               'where cc.deleted=0'.
               '  and cc.campaignid='._q($params['CampaignID']).
               '  and cc.campaignid=c.campaignid'.
               '  and c.accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        $data = array();
        
        while(!$rs->EOF)
        {
            $data[$rs->fields['campcategoryid']] = $rs->fields['name'];
            
            $rs->MoveNext();
        }
        
        return $data;
    }
}
?>
