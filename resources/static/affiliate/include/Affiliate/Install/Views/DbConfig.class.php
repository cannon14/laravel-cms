<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConfig extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConfig() {
        $this->init(); 
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }    
    
    function init() {
        parent::init();        
    }
        
    function getName() {
        return 'DbConfig';
    }      
    
    function getContent() {
        return $this->fetch('db_config');
    }
    
    //------------------------------------------------------------------------
    
    function process() { 
        if(isset($_POST['submit'])) {
            if($this->processDbConfig() === true) {      
                //$this->gotoNext($this->getNextView());
                //return $view->process();
                return true;
            }
        }
        return false;
        
    } 
         
    //------------------------------------------------------------------------

    function processDBConfig()
    {
        $dbtype = preg_replace('/[\'\"]/', '', $_POST['dbtype']);
        $dbhostname = preg_replace('/[\'\"]/', '', $_POST['dbhostname']);
        $dbusername = preg_replace('/[\'\"]/', '', $_POST['dbusername']);
        $dbpwd = preg_replace('/[\'\"]/', '', $_POST['dbpwd']);
        $dbname = preg_replace('/[\'\"]/', '', $_POST['dbname']);

        // check correctness of the fields
        checkCorrectness($_POST['dbhostname'], $dbhostname, L_G_DBHOSTNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['dbusername'], $dbusername, L_G_DBNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['dbpwd'], $dbpwd, L_G_DBUSERNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['dbname'], $dbname, L_G_DBPWD, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            if($this->model->checkDbConnection($dbtype, $dbhostname, $dbusername, $dbpwd, $dbname) === true) {
                $_SESSION[SESSION_PREFIX.'dbtype'] = $_POST['dbtype'];
                $_SESSION[SESSION_PREFIX.'dbhostname'] = $_POST['dbhostname'];
                $_SESSION[SESSION_PREFIX.'dbusername'] = $_POST['dbusername'];
                $_SESSION[SESSION_PREFIX.'dbpwd'] = $_POST['dbpwd'];
                $_SESSION[SESSION_PREFIX.'dbname'] = $_POST['dbname'];
            }
        }               

        if($this->model->writeSettingsFile() === false) {
            return false;
        }        
            
        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        } else {
            return true;                
        }

    }    
}
?>