<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PayoutOptions');

class Affiliate_Affiliates_Views_AffiliateProfile extends QUnit_UI_TemplatePage
{
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edituser':
                    if($this->processEditProfile())
                        return;
                    break;
            }
        }

        $this->drawFormEditProfile();    
    }

    //------------------------------------------------------------------------

    function processEditProfile()
    {
        $_POST['aid'] = $GLOBALS['Auth']->getUserID();

        $params = array();
        $params['type'] = 'edit';
        
        $protectedParams = Affiliate_Merchants_Bl_Affiliate::checkData($params);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_Affiliate::update($protectedParams))
                QUnit_Messager::setOkMessage(L_G_AFFILIATEEDITED);

            return false;
        }
    
        return false;
    }

    //------------------------------------------------------------------------

    function drawFormEditProfile()
    {
        if($_POST['commited'] != 'yes')
        {
            Affiliate_Merchants_Bl_Affiliate::loadUserInfoToPost($GLOBALS['Auth']->userID);
        }

        // get info about parent affiliate
        if($_POST['parentuserid'] != '')
        {
            $sql = 'select * from wd_g_users '.
                   'where deleted=0 '.
                   '  and userid='._q($_POST['parentuserid']).
                   '  and rtype='._q(USERTYPE_USER).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());

            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }        
      
            $_POST['parentuseridtext'] = $rs->fields['userid'].': '.$rs->fields['name'].' '.$rs->fields['surname'].' - '.$rs->fields['username'];
        }

        $_POST['action'] = 'edit';
        $_POST['header'] = L_G_EDITPROFILE;
        $_POST['postaction'] = 'edituser';  

        $minPayouts = QCore_Settings::getMinPayoutsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($minPayouts);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($GLOBALS['countries']);
        $this->assign('a_list_data2', $list_data2);

        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($payout_methods);
        $this->assign('a_list_data4', $list_data4);

        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data5', $payout_fields);

        $this->addContent('aff_profile');

        return true;
    }

    //------------------------------------------------------------------------
}
?>
