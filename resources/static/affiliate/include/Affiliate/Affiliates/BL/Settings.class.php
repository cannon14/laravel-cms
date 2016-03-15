<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Affiliates_Bl_Settings
{
    function getAffCampaignSettings($params)
    {
        $sql = 'select code, value, id1 from wd_g_settings '.
               'where code like \''._q_noendtags(SETTINGTYPEPREFIX_AFF_CAMP).'%\''.
               '  and accountid='._q($params['accountid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        $settings = array();
        while(!$rs->EOF)
        {
            $settings[$rs->fields['id1']][$rs->fields['code']] = $rs->fields['value'];

            $rs->MoveNext();
        }

        return $settings;
    }
}
?>