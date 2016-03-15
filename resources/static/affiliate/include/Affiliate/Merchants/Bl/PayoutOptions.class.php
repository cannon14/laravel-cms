<?php
class Affiliate_Merchants_Bl_PayoutOptions
{
    function loadPayoutOptionsInfo($pid, $accountid)
    {
        $payoptid = preg_replace('/[\'\"]/', '', $pid);
        $accountid = preg_replace('/[\'\"]/', '', $accountid);

        if($payoptid == '' && $accountid == '') return false;
        
        $sql = 'select * from wd_pa_payoutoptions '.
               'where payoptid='._q($payoptid).
               '  and accountid='._q($accountid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        $_POST['pid'] = $rs->fields['payoptid'];
        $_POST['name'] = $rs->fields['name'];
        $_POST['langid'] = $rs->fields['langid'];
        $_POST['exporttype'] = $rs->fields['exporttype'];
        $_POST['exportformat'] = $rs->fields['exportformat'];
        $_POST['buttonformat'] = $rs->fields['paybuttonformat'];
        $_POST['disabled'] = $rs->fields['disabled'];
        $_POST['rorder'] = $rs->fields['rorder'];
    }
    
    //--------------------------------------------------------------------------

    function loadPayoutFieldsInfo($fid, $accountid)
    {
        $payfieldid = preg_replace('/[\'\"]/', '', $fid);
        $accountid = preg_replace('/[\'\"]/', '', $accountid);

        if($payfieldid == '' && $accountid == '') return false;

        $sql = 'select pf.* from wd_pa_payoutfields pf, wd_pa_payoutoptions po '.
               'where pf.payfieldid='._q($payfieldid).
               '  and pf.payoptid=po.payoptid'.
               '  and po.accountid='._q($accountid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $_POST['fid'] = $rs->fields['payfieldid'];
        $_POST['pid'] = $rs->fields['payoptid'];
        $_POST['code'] = $rs->fields['code'];
        $_POST['name'] = $rs->fields['name'];
        $_POST['langid'] = $rs->fields['langid'];
        $_POST['rtype'] = $rs->fields['rtype'];
        $_POST['mandatory'] = $rs->fields['mandatory'];
        $_POST['visible'] = $rs->fields['visible'];
        $_POST['rorder'] = $rs->fields['rorder'];
        $_POST['availablevalues'] = $rs->fields['availablevalues'];
        $_POST['value'] = $rs->fields['value'];
    }
    
    //--------------------------------------------------------------------------

    function getPayoutMethodsAsArray($accountid='', $status='')
    {
        if($accountid == '') return array();
    
        $sql = 'select * from wd_pa_payoutoptions '.
               'where accountid='._q($accountid);
        if($status != '')
            $sql .= '  and disabled='._q($status);
        $sql .=' order by rorder, name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }
        
        $payopt = array();

        while(!$rs->EOF)
        {
            $payopt[$rs->fields['payoptid']]['payoptid'] = $rs->fields['payoptid'];
            $payopt[$rs->fields['payoptid']]['name'] = $rs->fields['name'];
            $payopt[$rs->fields['payoptid']]['exporttype'] = $rs->fields['exporttype'];
            $payopt[$rs->fields['payoptid']]['exportformat'] = $rs->fields['exportformat'];
            $payopt[$rs->fields['payoptid']]['disabled'] = $rs->fields['disabled'];
            $payopt[$rs->fields['payoptid']]['langid'] = $rs->fields['langid'];
            $payopt[$rs->fields['payoptid']]['rorder'] = $rs->fields['rorder'];
            
            $rs->MoveNext();
        }

        return $payopt;
    }
    
    //--------------------------------------------------------------------------
    
    function getPayoutFieldsAsArray($accountid, $status = '', $payoptid = '')
    {
        $sql = 'select pf.* from wd_pa_payoutfields pf, wd_pa_payoutoptions po '.
               'where po.accountid='._q($accountid).
               '  and po.payoptid=pf.payoptid ';
               
        if($status != '')
        {
            $sql .= '  and po.disabled='._q($status);
        }
        
        if($payoptid != '')
        {
            $sql .= '  and po.payoptid='._q($payoptid);
        }

        $sql .=' order by po.rorder, po.name, pf.rorder, pf.name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }

        $payopt = array();
        
        while(!$rs->EOF)
        {
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['payoptid'] = $rs->fields['payoptid'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['payfieldid'] = $rs->fields['payfieldid'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['name'] = $rs->fields['name'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['langid'] = $rs->fields['langid'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['rtype'] = $rs->fields['rtype'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['mandatory'] = $rs->fields['mandatory'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['rorder'] = $rs->fields['rorder'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['availablevalues'] = $rs->fields['availablevalues'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['availablevalues_array'] = Affiliate_Merchants_Bl_PayoutOptions::stringToArrayByNL($rs->fields['availablevalues']);
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['code'] = $rs->fields['code'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['visible'] = $rs->fields['visible'];
            $payopt[$rs->fields['payoptid']][$rs->fields['payfieldid']]['value'] = $rs->fields['value'];
            
            $rs->MoveNext();
        }
        
        return $payopt;
    }
    
    //--------------------------------------------------------------------------
    
    function getPayoutFieldsForOption($payoptID)
    {
        $sql = 'select * from wd_pa_payoutfields where payoptid='._q($payoptID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) 
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $payfields = array();
        
        while(!$rs->EOF)
        {
            $payfields[$rs->fields['payfieldid']]['code'] = $rs->fields['code'];
            $payfields[$rs->fields['payfieldid']]['rtype'] = $rs->fields['rtype'];
            $payfields[$rs->fields['payfieldid']]['payfieldid'] = $rs->fields['payfieldid'];

            $rs->MoveNext();
        }
        
        return $payfields;
    }
    
    //--------------------------------------------------------------------------
    
    function deletePayoutMethod($pid, $accountid)
    {
        if($accountid == '' || $pid == '') {
            return false;
        }

        if(Affiliate_Merchants_Bl_PayoutOptions::checkPayoutMethodExists($accountid, '', $pid)) {
            return false;
        } 

        if(Affiliate_Merchants_Bl_PayoutOptions::deletePayoutFields('', $pid) == false) {
            return false;
        }

        $sql = 'delete from wd_pa_payoutoptions '.
               'where payoptid='._q($pid).' and accountid='._q($accountid);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }
        
    //--------------------------------------------------------------------------
    
    function deletePayoutFields($fid='', $pid='')
    {
        if($fid == '' && $pid == '') {
            return false;
        }
    
        $sql = 'delete from wd_pa_payoutfields where 1=1 ';
        if($pid != '') $sql .= ' and payoptid='._q($pid);
        if($fid != '') $sql .= ' and payfieldid='._q($fid);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    

        return true;
    }

    //--------------------------------------------------------------------------

    function insertPayoutMethod($params)
    {
        $sql = 'insert into wd_pa_payoutoptions '.
               '(payoptid, name, exporttype, exportformat, paybuttonformat, disabled, accountid, '.
               'langid, rorder)'.
               ' values '.
               '('._q($params['payoptid']).','._q($params['name']).
               ','._q($params['exporttype']).','._q($params['exportformat']).','._q($params['paybuttonformat']).
               ','._q($params['status']).','._q($params['accountid']).
               ','._q($params['langid']).','._q($params['rorder']).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }
    
    //--------------------------------------------------------------------------

    function insertPayoutField($params)
    {
        // save changes of admin to db
        $sql = 'insert into wd_pa_payoutfields '.
               '(payfieldid, payoptid, name, langid, rtype, mandatory, '.
               'availablevalues, rorder, code, visible, value)'.
               ' values '.
               '('._q($params['payfieldid']).','._q($params['payoptid']).
               ','._q($params['name']).','._q($params['langid']).
               ','._q($params['rtype']).','._q($params['mandatory']).
               ','._q($params['availablevalues']).','._q($params['rorder']).
               ','._q($params['code']).','._q($params['visible']).
               ','._q($params['value']).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    

        return true;
    }
    
    //--------------------------------------------------------------------------

    function updatePayoutMethod($params)
    {
        // save changes of admin to db
        $sql = 'update wd_pa_payoutoptions '.
               'set name='._q($params['name']).
               '   ,langid='._q($params['langid']).
               '   ,exporttype='._q($params['exporttype']).
               '   ,exportformat='._q($params['exportformat']).
               '   ,paybuttonformat='._q($params['paybuttonformat']).
               '   ,disabled='._q($params['status']).
               '   ,rorder='._q($params['rorder']).
               ' where payoptid='._q($params['payoptid']).
               '   and accountid='._q($params['accountid']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    

        return true;
    }

    //--------------------------------------------------------------------------

    function updatePayoutField($params)
    {
        // save changes of admin to db
        $sql = 'update wd_pa_payoutfields '.
               'set name='._q($params['name']).
               '   ,langid='._q($params['langid']).
               '   ,rtype='._q($params['rtype']).
               '   ,mandatory='._q($params['mandatory']).
               '   ,rorder='._q($params['rorder']).
               '   ,availablevalues='._q($params['availablevalues']).
               '   ,code='._q($params['code']).
               '   ,visible='._q($params['visible']).
               '   ,value='._q($params['value']).
               ' where payfieldid='._q($params['payfieldid']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    

        return true;
    }

    //--------------------------------------------------------------------------

    function checkPayoutMethodExists($accountid='', $name='', $payoptid='', $pmexist = true)
    {
        if($accountid == '' || ($name == '' && $payoptid == ''))
            return false;

        $sql = 'select payoptid from wd_pa_payoutoptions '.
               'where accountid='._q($accountid);
        if($name != '') $sql .= ' and name='._q($name);
        if($payoptid != '') {
            if($pmexist) {
                $sql .= ' and payoptid='._q($payoptid);
            }
            else {
                $sql .= ' and payoptid <> '._q($payoptid);
            }
        }
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return true;

        return false;
    }

    //------------------------------------------------------------------------

    function checkPayoutFieldExistsInPayoutMethod($name='',$payoptid='',$payfieldid='')
    {
        if($name == '' && $payoptid == '' && $payfieldid == '')
            return false;
            
        $sql = 'select payfieldid from wd_pa_payoutfields where 1=1 ';
        if($name != '') $sql .= ' and name='._q($name);
        if($payoptid != '') $sql .= ' and payoptid='._q($payoptid);
        if($payfieldid != '') $sql .= ' and payfieldid <> '._q($payfieldid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    

        if($rs->EOF) return true;
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function stringToArrayByNL($str)
    {
        $str = str_replace("\r\n", "\n", $str);
        $str = str_replace("\r", "\n", $str);
        
        return explode("\n", $str);
    }

    //------------------------------------------------------------------------

    function getExportFormat($payoptID)
    {
        if($payoptID == '')
            return false;
            
        $sql = 'select exportformat from wd_pa_payoutoptions where payoptid='._q($payoptID).
               ' and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) 
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if($rs->EOF)
        {
            return false;
        }

        return $rs->fields['exportformat'];
    }
}
?>
