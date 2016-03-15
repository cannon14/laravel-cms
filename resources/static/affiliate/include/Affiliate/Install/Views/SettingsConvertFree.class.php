<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_SettingsConvertFree extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_SettingsConvertFree() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getContent() {
        $this->assign('action', 'SettingsConvertFree');
        return $this->fetch('settings_convert');        
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
        $dbsame = preg_replace('/[\'\"]/', '', $_POST['dbsame']);
        $dbhostname = preg_replace('/[\'\"]/', '', $_POST['dbhostname']);
        $dbusername = preg_replace('/[\'\"]/', '', $_POST['dbusername']);
        $dbpwd = preg_replace('/[\'\"]/', '', $_POST['dbpwd']);
        $dbname = preg_replace('/[\'\"]/', '', $_POST['dbname']);
    
        // check correctness of the fields
        if($dbsame != 1)
        {
            checkCorrectness($_POST['dbhostname'], $dbhostname, L_G_DBHOSTNAME, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['dbusername'], $dbusername, L_G_DBNAME, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['dbpwd'], $dbpwd, L_G_DBUSERNAME, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['dbname'], $dbname, L_G_DBPWD, CHECK_EMPTYALLOWED);
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            // check connect to database of PostAff Pro
            $db = ADONewConnection($_SESSION[SESSION_PREFIX.'dbtype']);
            $ret = @$db->Connect($_SESSION[SESSION_PREFIX.'dbhostname'], $_SESSION[SESSION_PREFIX.'dbusername'], $_SESSION[SESSION_PREFIX.'dbpwd'], $_SESSION[SESSION_PREFIX.'dbname']);
            if(!$ret || !$db)
                QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTOPRODATABASE.$db->errorMsg());
            
            if($dbsame != 1)
            {
                // check connect to database of PostAff free
                $db = ADONewConnection('mysql');
                $ret = @$db->Connect($dbhostname, $dbusername, $dbpwd, $dbname);
                if(!$ret || !$db)
                    QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTOFREEDATABASE.$db->errorMsg());
                else
                {
                    $_SESSION[SESSION_PREFIX.'dbtype_free'] = 'mysql';
                    $_SESSION[SESSION_PREFIX.'dbhostname_free'] = $dbhostname;
                    $_SESSION[SESSION_PREFIX.'dbusername_free'] = $dbusername;
                    $_SESSION[SESSION_PREFIX.'dbpwd_free'] = $dbpwd;
                    $_SESSION[SESSION_PREFIX.'dbname_free'] = $dbname;
                }
                
                $db->Disconnect();
            }
            else
            {
                $_SESSION[SESSION_PREFIX.'dbtype_free'] = 'mysql';
                $_SESSION[SESSION_PREFIX.'dbhostname_free'] = $_SESSION[SESSION_PREFIX.'dbhostname'];
                $_SESSION[SESSION_PREFIX.'dbusername_free'] = $_SESSION[SESSION_PREFIX.'dbusername'];
                $_SESSION[SESSION_PREFIX.'dbpwd_free'] = $_SESSION[SESSION_PREFIX.'dbpwd'];
                $_SESSION[SESSION_PREFIX.'dbname_free'] = $_SESSION[SESSION_PREFIX.'dbname'];
            }
        }
                
        if(QUnit_Messager::getErrorMessage() != '') {            
            return false;
        }
        return true;
    }    
        
}
?>