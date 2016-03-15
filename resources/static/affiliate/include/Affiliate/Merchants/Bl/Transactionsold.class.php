<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('QCore_History');

class Affiliate_Merchants_Bl_Transactionsold
{
    //--------------------------------------------------------------------------

    function changeState($params)
    {
        $transIDs = $params['transids'];
        $state = $params['state'];
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;

        if($state != AFFSTATUS_APPROVED && $state != AFFSTATUS_SUPPRESSED)
            return false;

        $chunkedTransIDs = array_chunk($transIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedTransIDs as $transIDsArray)
        {
            $transIDSql = "('".implode("','", $transIDsArray)."')";
            
            $sql = 'update wd_pa_transactions set rstatus='._q($state).
                   ' where transid in '.$transIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            // update also possible recurring commissions
            $sql = 'update wd_pa_recurringcommissions set rstatus='.myquotes($state).
                   ' where originaltransid in '.$transIDSql.
                   ' and rstatus='.AFFSTATUS_NOTAPPROVED;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        // check reward rules
        if($status != AFFSTATUS_APPROVED)
            return true;

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

        if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) === false) return true;

        $chunkedTransIDs = array_chunk($transIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedTransIDs as $transIDsArray)
        {
            $trans_users = Affiliate_Merchants_Bl_Transactions::getUserFromTransaction($transIDsArray);

            $params = array('users' => $trans_users,
                            'AccountID' => $GLOBALS['Auth']->getAccountID(),
                            'decimal_places' => $this->settings['Aff_round_numbers']
                           );

            Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getUserFromTransaction($transIDs)
    {
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;
           
        $transIDSql = "('".implode("','", $transIDs)."')";
            
        $sql = 'select transid, affiliateid from wd_pa_transactions '.
               'where transid in '.$transIDSql.
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $trans_users = array();
        
        while(!$rs->EOF)
        {
            $trans_users[$rs->fields['transid']] = $rs->fields['affiliateid'];
            
            $rs->MoveNext();
        }
        
        return $trans_users;
    }
    
    //--------------------------------------------------------------------------

    function delete($params)
    {
        $transIDs = $params['transids'];
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;

        $chunkedTransIDs = array_chunk($transIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedTransIDs as $transIDsArray)
        {
            $transIDSql = "('".implode("','", $transIDsArray)."')";
            
            $sql = 'delete from wd_pa_transactions'.
                   ' where transid in '.$transIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            // delete also possible recurring commissions
            $sql = 'update wd_pa_recurringcommissions set deleted=1'.
                   ' where originaltransid in '.$transIDSql.
                   ' and rstatus='.AFFSTATUS_NOTAPPROVED;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function loadTransactionInfo($params)
    {
        $transid = preg_replace('/[\'\"]/', '', $_REQUEST['tid']);

        $sql = 'select * from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        $_POST['tid'] = $rs->fields['transid'];
        $_POST['rstatus'] = $rs->fields['rstatus'];
        $_POST['transtype'] = $rs->fields['transtype'];
        $_POST['payoutstatus'] = $rs->fields['payoutstatus'];
        $_POST['cookiestatus'] = $rs->fields['cookiestatus'];
        $_POST['orderid'] = $rs->fields['orderid'];
        $_POST['totalcost'] = $rs->fields['totalcost'];
        $_POST['bannerid'] = $rs->fields['bannerid'];
        $_POST['transkind'] = $rs->fields['transkind'];
        $_POST['refererurl'] = $rs->fields['refererurl'];
        $_POST['affiliate'] = $rs->fields['affiliateid'];
        $_POST['campcategoryid'] = $rs->fields['campcategoryid'];
        $_POST['parenttrans'] = $rs->fields['parenttransid'];
        $_POST['commission'] = $rs->fields['commission'];
        $_POST['ip'] = $rs->fields['ip'];
        $_POST['recurringcommid'] = $rs->fields['recurringcommid'];
        $_POST['accountingid'] = $rs->fields['accountingid'];
        $_POST['productid'] = $rs->fields['productid'];
        $_POST['data1'] = $rs->fields['data1'];
        $_POST['data2'] = $rs->fields['data2'];
        $_POST['data3'] = $rs->fields['data3'];
    }
    
    //--------------------------------------------------------------------------
    
    function updateTransaction($params)
    {
        $sql = 'update wd_pa_transactions '.
               'set rstatus='._q($params['rstatus']).
               '   ,transtype='._q($params['transtype']).
               '   ,transkind='._q($params['transkind']).
               '   ,payoutstatus='._q($params['payoutstatus']).
               '   ,totalcost='._q($params['totalcost']).
               '   ,refererurl='._q($params['refererurl']).
               '   ,affiliateid='._q($params['affiliate']).
               '   ,parenttransid='._q($params['parenttrans']).
               '   ,commission='._q($params['commission']).
               '   ,ip='._q($params['ip']).
               '   ,productid='._q($params['productid']).
               '   ,data1='._q($params['data1']).
               '   ,data2='._q($params['data2']).
               '   ,data3='._q($params['data3']).
               ' where transid='._q($params['TransID']);
        if($params['AccountID'] != '') $sql .= ' and accountid='._q($params['AccountID']);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($params['rstatus'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($params['affiliate']),
                            'AccountID' => $params['AccountID'],
                            'decimal_places' => $params['decimal_places']
                           );

            if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkTransactionExists($TransID, $AccountID)
    {
        $sql = 'select transid from wd_pa_transactions '.
               'where transid='._q($TransID).
               '  and accountid='._q($AccountID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        if($rs->EOF)
            return true;

        return false;
    }
}
?>
