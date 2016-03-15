<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvertFree extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConvertFree() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getContent() {
        $this->assign('action', 'DbConvertFree');
        return $this->fetch('db_convert');        
    }
    
    function process() { 
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        if($this->convert()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        return false;    
    }  
    
    function convert() {
        $GLOBALS['convertStatus'] = '';
        $db_pro = ADONewConnection($_SESSION[SESSION_PREFIX.'dbtype']);
        $ret = @$db_pro->Connect($_SESSION[SESSION_PREFIX.'dbhostname'], $_SESSION[SESSION_PREFIX.'dbusername'], $_SESSION[SESSION_PREFIX.'dbpwd'], $_SESSION[SESSION_PREFIX.'dbname']);
        if(!$ret || !$db_pro)
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTOPRODATABASE.$db->errorMsg());
        
        if(   $_SESSION[SESSION_PREFIX.'dbhostname'] != $_SESSION[SESSION_PREFIX.'dbhostname_free'] 
           || $_SESSION[SESSION_PREFIX.'dbusername'] != $_SESSION[SESSION_PREFIX.'dbusername_free']
           || $_SESSION[SESSION_PREFIX.'dbpwd'] != $_SESSION[SESSION_PREFIX.'dbpwd_free']
           || $_SESSION[SESSION_PREFIX.'dbname'] != $_SESSION[SESSION_PREFIX.'dbname_free']
           
          )
        {
            $db_free = ADONewConnection('mysql');
            $ret = @$db_free->Connect($_SESSION[SESSION_PREFIX.'dbhostname_free'], $_SESSION[SESSION_PREFIX.'dbusername_free'], $_SESSION[SESSION_PREFIX.'dbpwd_free'], $_SESSION[SESSION_PREFIX.'dbname_free']);
            if(!$ret || !$db_free)
                QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTOFREEDATABASE.$db->errorMsg());
        }
        else
            $db_free = $db_pro;
        
        //--------------------------------------
        // start converting
        $GLOBALS['convertStatus'] .= '<b>'.L_G_CONVERTINGAFFILIATES.'</b><br>';
        $sql = "select * from affiliates";
        $rs = $db_free->execute($sql);
        if (!$rs || !$db_free->_queryID)
        { 
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$db_free->errorMsg());
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfromfree';
            $this->addContent('db_convert_free_upgrade');
            return true;
        }
        $affiliates = array();
        while(!$rs->EOF)
        {
            $AffiliateID = $db_pro->GenID('seq_pa_affiliates', SEQ_AFFILIATES);
            
            $sql = "insert into pa_affiliates(affiliateid, ".
                            "username, ".
                            "password, ".
                            "company_name, ".
                            "contactname, ".
                            "weburl, ".
                            "payableto, ".
                            "street, ".
                            "city, ".
                            "zipcode, ".
                            "state, ".
                            "country, ".
                            "phone, ".
                            "fax, ".
                            "dateinserted, ".
                            "status)".
                            
                            " values (".
                            _q($AffiliateID).",".               
                            _q($rs->fields['email']).",".
                            _q($rs->fields['pass']).",".
                            _q($rs->fields['company']).",".
                            _q($rs->fields['firstname']." ".$rs->fields['lastname']).",".
                            _q($rs->fields['website']).",".
                            _q($rs->fields['payableto']).",".
                            _q($rs->fields['street']).",".
                            _q($rs->fields['town']).",".
                            _q($rs->fields['postcode']).",".
                            _q($rs->fields['county']).",".
                            _q($GLOBALS['countries_free'][$rs->fields['country']]).",".
                            _q($rs->fields['phone']).",".
                            _q($rs->fields['fax']).",".
                            _q($rs->fields['date']).",".
                            "2)";
//echo $sql."<br><br>";
            $ret = $db_pro->execute($sql);
            if (!$ret)
            {
                $GLOBALS['convertStatus'] .= "Affiliate '".$rs->fields['refid']."' not converted because of error<br>";
                $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
                QUnit_Messager::setErrorMessage(L_G_DBERROR.$db_free->errorMsg());
                QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
                
                $_POST['action'] = 'startconvertfromfree';
                $this->addContent('db_convert_free_upgrade');
                return true;
            }
            else
                $GLOBALS['convertStatus'] .= "Affiliate '".$rs->fields['refid']."' inserted OK<br>";
        
            $affiliates[$rs->fields['refid']] = $AffiliateID;
        
            $rs->MoveNext();
        }
        
        
        //--------------------------------------
        // convert clicks
        $GLOBALS['convertStatus'] .= '<br><b>'.L_G_CONVERTINGCLICKS.'</b><br>';
        $sql = "select * from clickthroughs";
        $rs = $db_free->execute($sql);
        if (!$rs || !$db_free->_queryID)
        { 
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfromfree';
            $this->addContent('db_convert_free_upgrade');
            return true;
        }

        while(!$rs->EOF)
        {
            $sql = "insert into pa_transactions(".
                    "affiliateid, ".
                    "dateinserted, ".
                    "dateapproved, ".
                    "ip, ".
                    "refererurl, ".
                    "campcategoryid, ".                    
                    "transtype, ".
                    "transkind, ".
                    "status)".
                                
                   " values (".
                    _q($affiliates[$rs->fields['refid']]).",".               
                    _q($rs->fields['date']." ".$rs->fields['time']).",".
                    _q($rs->fields['date']." ".$rs->fields['time']).",".
                    _q($rs->fields['ipaddress']).",".
                    _q($rs->fields['refferalurl']).",".
                     "1, 1, 1, 2)";

//echo $sql."<br><br>";
            $ret = $db_pro->execute($sql);
            if (!$ret)
                $GLOBALS['convertStatus'] .= "Click for '".$rs->fields['refid']."' from date '".$rs->fields['date']." ".$rs->fields['time']."' was not inserted due to error<br>";
            else
                $GLOBALS['convertStatus'] .= "Click for '".$rs->fields['refid']."' from date '".$rs->fields['date']." ".$rs->fields['time']."' inserted OK<br>";
            
            $rs->MoveNext();
        }
        
        
        //--------------------------------------
        // convert sales
        $GLOBALS['convertStatus'] .= '<br><b>'.L_G_CONVERTINGSALES.'</b><br>';
        $sql = "select * from sales";
        $rs = $db_free->execute($sql);
        if (!$rs || !$db_free->_queryID)
        { 
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfromfree';
            $this->addContent('db_convert_free_upgrade');
            return true;
        }

        while(!$rs->EOF)
        {
            $sql = "insert into pa_transactions(".
                    "affiliateid, ".
                    "dateinserted, ".
                    "dateapproved, ".
                    "ip, ".
                    "commission, ".                    
                    "campcategoryid, ".                      
                    "transtype, ".
                    "transkind, ".
                    "status)".
                    
                   " values (".
                    _q($affiliates[$rs->fields['refid']]).",".               
                    _q($rs->fields['date']." ".$rs->fields['time']).",".
                    _q($rs->fields['date']." ".$rs->fields['time']).",".
                    _q($rs->fields['ipaddress']).",".
                    _q($rs->fields['payment']).",".
                     "1, 3, 1, 2)";

//echo $sql."<br><br>";
            $ret = $db_pro->execute($sql);
            if (!$ret)
                $GLOBALS['convertStatus'] .= "Sale for '".$rs->fields['refid']."' from date '".$rs->fields['date']." ".$rs->fields['time']."' was not inserted due to error<br>";
            else
                $GLOBALS['convertStatus'] .= "Sale for '".$rs->fields['refid']."' from date '".$rs->fields['date']." ".$rs->fields['time']."' inserted OK<br>";
            
            $rs->MoveNext();
        }
        
        $GLOBALS['convertStatus'] .= '<br><br><b>'.L_G_CONVERSIONFINISHED.'</b><br>';
        
        //------------------------------------------------
        // finish conversion
        if($GLOBALS['errorMsg'] != '')
            $_POST['action'] = 'convertedfromfree';
        else
        {
            $GLOBALS['convertStatus'] .= L_G_UPGRADEWASSUCCESFUL.'<br>';
            $_POST['action'] = 'finish';
        }
        
        $this->addContent('db_convert_free_upgrade');
        return true;        
    }    
        
}
?>