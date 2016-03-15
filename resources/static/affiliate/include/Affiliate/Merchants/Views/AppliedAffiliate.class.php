<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_AffiliateCampaigns');

class Affiliate_Merchants_Views_AppliedAffiliate extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edit_reason':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED, unserialize(str_replace('\\','', $_POST['itemschecked']))))
                        return;
                break;
            }
            
            switch($_POST['massaction'])
            {
                case 'suppress':
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'suppress':
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;
            }
        }
    
        $this->showAffiliateCampaigns();
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processChangeStateCheck($state)
    {
        if(($affCampIDs = $this->returnACIDs()) == false)
            return false;

        if($state == AFFSTATUS_SUPPRESSED)
        {
            $_POST['header'] = L_G_EDIT_DECLINE_REASON;
            $_POST['action'] = '';
            $_POST['postaction'] = 'edit_reason';
            $_POST['itemschecked'] = serialize($affCampIDs);

            $this->addContent('decline_reason_edit');
            
            return true;
        }

        $this->processChangeState($state, $affCampIDs);
    }

    //--------------------------------------------------------------------------

    function processChangeState($state, $affCampIDs)
    {
        $params = array();
        $params['affCampIDs'] = $affCampIDs;
        $params['state'] = $state;
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['decline_reason'] = $_POST['decline_reason'];
        $params['round_numbers'] = $GLOBALS['Auth']->getSetting('Aff_round_numbers');

        Affiliate_Merchants_Bl_AffiliateCampaigns::changeState($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function returnACIDs()
    {
        if($_POST['massaction'] != '')
        {
            $affCampIDs = $_POST['itemschecked'];
        }
        else
        {
            $affCampIDs = array($_REQUEST['acid']);
        }
        
        if(!is_array($affCampIDs) || count($affCampIDs) < 1 ) return false;
        
        return $affCampIDs;
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showAffiliateCampaigns()
    {
        $orderby = '';

        $a = array('a.userid', 'a.name', 'a.surname', 'camp_name',
                   'c.dateinserted', 'ac.rstatus');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
        else
            $orderby = ' order by a.username'; 

        $where = ' where a.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userid=ac.affiliateid'.
                 '   and ac.campaignid=c.campaignid'.
                 '   and a.rstatus='._q(AFFSTATUS_APPROVED);

        $params = array('where' => $where);

        $camp_cats = Affiliate_Merchants_Bl_AffiliateCampaigns::getCampCats($params);

        if($camp_cats == false) return false;

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'aa_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
        }
       
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['aa_status'] == '') $_REQUEST['aa_status'] = '_';
        if($_REQUEST['aa_prod_cat'] == '') $_REQUEST['aa_prod_cat'] = '_';
        
        //--------------------------------------
        // put settings into session
        $_SESSION['aa_prod_cat'] = $_REQUEST['aa_prod_cat'];
        $_SESSION['aa_status'] = $_REQUEST['aa_status'];

        if($_REQUEST['aa_status'] != '_')
            $where .= ' and ac.rstatus='._q($_REQUEST['aa_status']);
        if($_REQUEST['aa_prod_cat'] != '_')
            $where .= ' and c.campaignid='._q($_REQUEST['aa_prod_cat']);

        $sql = 'select a.userid, a.name, a.surname, c.name as camp_name '.
               '      ,c.dateinserted, ac.rstatus, ac.affcampid '.
               'from wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac';

        $rs = QCore_Sql_DBUnit::execute($sql.' '.$where.' '.$orderby, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($camp_cats);

        $this->assign('a_list_data', $list_data);

        $this->addContent('appl_aff_filter');

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac', $where));

        $this->addContent('appl_aff_show');
    }

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

}  
?>
