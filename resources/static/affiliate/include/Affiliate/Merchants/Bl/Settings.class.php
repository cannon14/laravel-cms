<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Settings');

class Affiliate_Merchants_Bl_Settings extends QCore_Settings
{
    function getCampaignInfo($params)
    {
        $sql = 'select code, value from wd_g_settings '.
               'where id1='._q($params['campaignid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        $settings = array();
        while(!$rs->EOF)
        {
            $settings[$rs->fields['code']] = $rs->fields['value'];

            $rs->MoveNext();
        }

        return $settings;
    }

    //------------------------------------------------------------------------

    function updateCampaignInfo($campaignid, $params)
    {
        foreach($params as $k => $v)
        {
            if(!QCore_Settings::_update(SETTINGTYPEPREFIX_AFF_CAMP.$k, $v, SETTINGTYPE_AFF_CAMP, $GLOBALS['Auth']->getAccountID(), $GLOBALS['Auth']->getUserID(), $campaignid))
                return false;
        }
        
        return true;
    }

    //------------------------------------------------------------------------

    function deleteCampaignInfo($campaignid)
    {
        $sql = 'delete from wd_g_settings '.
               'where id1='._q($campaignid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());

        return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    }
    
    //------------------------------------------------------------------------

    function getAccountUsersSettings($accountID)
    {
        $sql = 'select * from wd_g_settings '.
               'where rtype='._q(SETTINGTYPE_USER).
               '  and accountid='._q($accountID).
               ' order by userid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return array();

        $settings = array();
        while(!$rs->EOF)
        {
            $settings[$rs->fields['userid']][$rs->fields['code']] = $rs->fields['value'];

            $rs->MoveNext();
        }

        return $settings;
    }    

    //------------------------------------------------------------------------
    
    function showCurrency($value)
    {
        return ($GLOBALS['Auth']->getSetting('Aff_currency_left_position') == '1' ? 
                        $GLOBALS['Auth']->getSetting('Aff_system_currency').' '._rnd($value) :
                        _rnd($value).' '.$GLOBALS['Auth']->getSetting('Aff_system_currency'));
    }
}
