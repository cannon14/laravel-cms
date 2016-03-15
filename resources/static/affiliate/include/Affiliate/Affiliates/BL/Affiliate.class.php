<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Affiliates_Bl_Affiliate
{
    //--------------------------------------------------------------------------

    function getAffiliatesCampaigns($params)
    {
        $sql = 'select c.* from wd_pa_campaigns c, wd_pa_affiliatescampaigns ac '.
               'where c.deleted=0 and c.campaignid=ac.campaignid'.
               '  and ac.affiliateid='._q($params['userID']).
               '  and ac.rstatus='._q(AFFSTATUS_APPROVED).
               '  and c.accountid='._q($params['accountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $campaigns = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['commtype'] = $rs->fields['commtype'];
            $campaigns[$rs->fields['campaignid']] = $temp;

            $rs->MoveNext();
        }
        
        return $campaigns;
    }

    //--------------------------------------------------------------------------

    function insertAffCamp($params)
    {
        $AffCampID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigns', 'campaignid');
        $sql = 'insert into wd_pa_affiliatescampaigns '.
               '(affcampid, campcategoryid, affiliateid, campaignid, rstatus)'.
               ' values '.
               '('._q($AffCampID).',null,'._q($params['userID']).
               ','._q($params['CampaignID']).','._q(AFFSTATUS_NOTAPPROVED).')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function getDeclineReason($params)
    {
        $sql = 'select c.name, c.description, ac.declinereason '.
               'from wd_pa_campaigns c, wd_pa_affiliatescampaigns ac '.
               'where c.campaignid='._q($params['campaign']).
               '  and c.campaignid=ac.campaignid'.
               '  and ac.affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $data['name'] = $rs->fields['name'];
        $data['description'] = $rs->fields['description'];
        $data['declinereason'] = $rs->fields['declinereason'];

        return $data;
    }

    //--------------------------------------------------------------------------

    function getAffiliateCampaignsStatus($params)
    {
        $sql = 'select campaignid, rstatus from wd_pa_affiliatescampaigns '.
               'where affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $affcamps = array();
        while(!$rs->EOF)
        {
            $affcamps[$rs->fields['campaignid']] = $rs->fields['rstatus'];

            $rs->MoveNext();
        }
        
        return $affcamps;
    }
}
?>
