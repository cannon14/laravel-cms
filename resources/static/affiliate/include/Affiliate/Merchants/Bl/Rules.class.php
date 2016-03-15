<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategories');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

class Affiliate_Merchants_Bl_Rules
{
    function loadRuleToPost($params)
    {
        if($params['AccountID'] == '' || $params['CampaignID'] == '') return false;
        
        $sql = 'select * from wd_pa_rules '.
               'where accountid='._q($params['AccountID']).
               '  and campaignid='._q($params['CampaignID']);
        if($params['ruleid'] != '') $sql .= ' and ruleid='._q($params['ruleid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if($rs->EOF) return false;

        $_POST['ruleid'] = $rs->fields['ruleid'];
        $_POST['cond_when'] = $rs->fields['cond_when'];
        $_POST['cond_in'] = $rs->fields['cond_in'];
        $_POST['cond_is'] = $rs->fields['cond_is'];
        $_POST['cond_value1'] = $rs->fields['cond_value1'];
        $_POST['cond_value2'] = $rs->fields['cond_value1'];
        $_POST['cond_value3'] = $rs->fields['cond_value2'];
        $_POST['cond_action'] = $rs->fields['cond_action'];
        $_POST['cond_action_value'] = $rs->fields['cond_action_value'];
        
        if($rs->fields['cond_value2'] != '')
        {
            $_POST['cond_is_type'] = RULE_IS_BETWEEN;
            $_POST['cond_value1'] = '';
        }
        else 
        {
            $_POST['cond_is_type'] = RULE_IS;
            $_POST['cond_value2'] = '';
            $_POST['cond_value3'] = '';
        }
    }
    
    //--------------------------------------------------------------------------

    function getRulesAsArray($params)
    {
        if($params['AccountID'] == '') return false;
        
        $sql = 'select r.*, cc.name as campaign_name '.
               'from wd_pa_rules r, wd_pa_campaigncategories cc '.
               'where r.accountid='._q($params['AccountID']).
               '  and r.campaignid=cc.campaignid'.
               '  and r.cond_action_value=cc.campcategoryid';
        if($params['cond_when'] != '') $sql .= ' and r.cond_when='._q($params['cond_when']);
        if($params['CampaignID'] != '') $sql .= ' and r.campaignid='._q($params['CampaignID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return false;

        $rules = array();

        while(!$rs->EOF)
        {
            $rules[$rs->fields['ruleid']]['ruleid'] = $rs->fields['ruleid'];
            $rules[$rs->fields['ruleid']]['special_campaign_name'] = $rs->fields['campaign_name'];
            $rules[$rs->fields['ruleid']]['cond_when'] = $rs->fields['cond_when'];
            $rules[$rs->fields['ruleid']]['cond_in'] = $rs->fields['cond_in'];
            $rules[$rs->fields['ruleid']]['cond_is'] = $rs->fields['cond_is'];
            $rules[$rs->fields['ruleid']]['cond_value1'] = $rs->fields['cond_value1'];
            $rules[$rs->fields['ruleid']]['cond_value2'] = $rs->fields['cond_value2'];
            $rules[$rs->fields['ruleid']]['cond_action'] = $rs->fields['cond_action'];
            $rules[$rs->fields['ruleid']]['cond_action_value'] = $rs->fields['cond_action_value'];
            $rules[$rs->fields['ruleid']]['campaignid'] = $rs->fields['campaignid'];

            if($rs->fields['cond_value2'] != '')
                $rules[$rs->fields['ruleid']]['cond_is_type'] = RULE_IS_BETWEEN;
            else $rules[$rs->fields['ruleid']]['cond_is_type'] = RULE_IS;

            $rs->MoveNext();
        }

        return $rules;
    }

    //--------------------------------------------------------------------------

    function updateRule($params)
    {
        $sql = 'select ruleid from wd_pa_rules '.
               'where cond_action='._q($params['cond_action']).
               '  and cond_action_value='._q($params['cond_action_value']).
               '  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($params['ruleid'] == '' || $rs->EOF)
        {
            $sql = 'select cc.campaignid from wd_pa_campaigncategories cc '.
                   'where cc.campcategoryid='._q($params['cond_action_value']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs || $rs->EOF) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            $CampaignID = $rs->fields['campaignid'];

            $RuleID = QCore_Sql_DBUnit::createUniqueID('wd_pa_rules', 'ruleid');

            $sql = 'insert into wd_pa_rules ('.
                   'ruleid, accountid, campaignid, cond_when, cond_in,'.
                   'cond_is,cond_value1,cond_value2,cond_action,cond_action_value '.
                   ') values ('.
                   _q($RuleID).','._q($params['AccountID']).','._q($CampaignID).
                   ','._q($params['cond_when']).','._q($params['cond_in']).
                   ','._q($params['cond_is']).','._q($params['cond_value1']).
                   ','._q($params['cond_value2']).','._q($params['cond_action']).
                   ','._q($params['cond_action_value']).')';
    
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }
        else
        {
            $sql = 'update wd_pa_rules '.
                   'set cond_when='._q($params['cond_when']).
                   '   ,cond_in='._q($params['cond_in']).
                   '   ,cond_is='._q($params['cond_is']).
                   '   ,cond_value1='._q($params['cond_value1']).
                   '   ,cond_value2='._q($params['cond_value2']).
                   '   ,cond_action='._q($params['cond_action']).
                   '   ,cond_action_value='._q($params['cond_action_value']).
                   ' where ruleid='._q($rs->fields['ruleid']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function deleteRule($params)
    {
        if($params['ruleid'] == '' || $params['AccountID'] == '') return false;
        
        $sql = 'delete from wd_pa_rules '.
               'where ruleid='._q($params['ruleid']).
               '  and accountid='._q($params['AccountID']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function innerRuleCheck($value, $rule, $params, $userid)
    {
        if($rule['cond_value2'] != '')
        {
            // is between
            if( $rule['cond_value1'] <= $value && $value <= $rule['cond_value2'])
            {
                Affiliate_Merchants_Bl_CampaignCategories::insertAffiliateSpecialCategory($params, $rule, $userid);
                return true;
            }
        }
        else
        {
            // is
            if($rule['cond_is'] == RULE_HIGHER)
            {
                if($rule['cond_value1'] <= $value)
                {
                    Affiliate_Merchants_Bl_CampaignCategories::insertAffiliateSpecialCategory($params, $rule, $userid);
                    return true;
                }
            }
            else if($rule['cond_is'] == RULE_LOWER)
            {
                if($rule['cond_value1'] >= $value)
                {
                    Affiliate_Merchants_Bl_CampaignCategories::insertAffiliateSpecialCategory($params, $rule, $userid);
                    return true;
                }
            }
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function checkPerformanceRules($params, $rules = '')
    {
        if($rules == '')
            if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) === false) return true;

        if($params['AccountID'] == '' || !is_array($params['users']) 
           || count($params['users']) < 1 || !is_array($rules) || count($rules) < 1) return false;

        if(($stats = Affiliate_Scripts_Bl_SaleStatistics::getStatsForRules($params)) === false) return false;
        if(($user_special_categories = Affiliate_Merchants_Bl_CampaignCategories::getUserSpecialCategoriesShortAsArray($params)) === false) return false;

        if(!is_array($user_special_categories) || !is_array($stats) || count($stats) < 1) return false;

        if($params['decimal_places'] == '') $params['decimal_places'] = 0;
        
        $actual_month = date('n');
        $actual_year = date('Y');

        $temp_rules = $rules;
        foreach($params['users'] as $k => $userid)
        {
            foreach($rules as $rule)
            {
                // check if user is in testing special category
                if(is_array($user_special_categories[$userid]) 
                   && count($user_special_categories[$userid]) > 0
                   && in_array($rule['cond_action_value'], $user_special_categories[$userid]))
                  continue;
    
                // take stats value to compare with rule value
                if($rule['cond_in'] == RULE_ACTUAL_MONTH)
                    $value = $stats[$userid]['month'][$actual_month][$rule['cond_when']];
                else if($rule['cond_in'] == RULE_ACTUAL_YEAR)
                    $value = $stats[$userid]['year'][$actual_year][$rule['cond_when']];
                else if($rule['cond_in'] == RULE_ALL)
                    $value = $stats[$userid]['all'][$rule['cond_when']];
    
                // check stats value
                $value = _r($value, $params['decimal_places']);
                if($value == '' || $value == '0') continue;
    
                // more checks
                $ret = Affiliate_Merchants_Bl_Rules::innerRuleCheck($value, $rule, $params, $userid);
                if($ret == true) break;
            }
            
            $rules = $temp_rules;
        }
    }
}
?>
