<?php
//============================================================================
// Rapido Technologies Addition
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Bl_Timeslot
{
    function load($params)
    {
        $sql = 'select * from wd_pa_campaigns '.
               'where deleted=0 and campaignid='._q($params['campaignid']).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        if($rs->EOF)
            return array();
            
        return $rs->fields;
    }

    //--------------------------------------------------------------------------

    function updateSettings($params)
    {
        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'overwrite_cookie' => $params['overwrite_cookie']
                               );

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['cid'], $setting_params);

        return true;
    }

    //--------------------------------------------------------------------------

    function updateCampaign($params)
    {
        $sql = 'update wd_pa_campaigns '.
               'set name='._q($params['cname']).
               '   ,commtype='._q($params['commtype']).
               '   ,shortdescription='._q($params['shortdescription']).
               '   ,description='._q($params['description']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql .= ' ,products='._q($params['products']);
        $sql .= ' where campaignid='._q($params['campaignid']).
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $setting_params = array('banner_url' => $params['banner_url']);

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);

        return true;
    }

    //--------------------------------------------------------------------------

    function insert($params)
    {
        $sql = 'insert into wd_pa_campaigns(campaignid, accountid, name';
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=',products';
        $sql.= ' ,dateinserted, commtype, description, shortdescription) values'.
               '('._q($params['campaignid']).','._q($GLOBALS['Auth']->getAccountID()).
               ','._q($params['cname']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=','._q($params['products']);
        $sql.=','.sqlNow().','._q($params['commtype']).','._q($params['description']).
              ','._q($params['shortdescription']).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }    

        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'overwrite_cookie' => $params['overwrite_cookie'],
                                'banner_url' => $params['banner_url']
                               );

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);

        // add commission to first unassigned category
        $sql = 'insert into wd_pa_campaigncategories(campcategoryid, campaignid, name)'.
               'values('._q($params['affcategoryid']).','._q($params['campaignid']).
               ','._q(UNASSIGNED_USERS).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$ret)
        {
            $sql = 'delete from wd_pa_campaigns '.
                   'where campaignid='._q($params['campaignid']).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            Affiliate_Merchants_Bl_Settings::deleteCampaignInfo($params['campaignid']);

            QUnit_Messager::setErrorMessage(L_G_DBERROR);

            return false;
        }

        return true;            
    }

    //--------------------------------------------------------------------------

    function delete($params)
    {
        $sql = 'update wd_pa_campaigns set deleted=1 '.
               'where campaignid='._q($params['campaignid']).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $ret = Affiliate_Merchants_Bl_Settings::deleteCampaignInfo($params['campaignid']);

        return $ret;
    }
    //--------------------------------------------------------------------------
    
    function getTimeslotsAsArray()
    {
        $sql = 'select * from rt_timeslots t where t.deleted=0 order by timeslotName';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $thisList = array();
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['timeslotId'] = $rs->fields['timeslotId'];
            $temp['name'] = $rs->fields['timeslotName'];
            $temp['entryId'] = $rs->fields['entryId'];
            $thisList[$rs->fields['timeslotId']] = $temp;
            
            $rs->MoveNext();
        }
        
        return $thisList;
    }
}
?>
