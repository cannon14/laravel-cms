<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Install extends QUnit_UI_TemplatePage
{
    var $className = "Install";
    var $model;
    
    function Affiliate_Install_Views_Install() {
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    //------------------------------------------------------------------------
    
    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'chooseinstmethod':
                if($this->processChooseInstMethod())
                    return;
                break;    
                
                case 'dbconfig':
                if($this->processDBConfig())
                    return;
                break;    
                
                case 'dbcreate':
                if($this->drawDBCreation())
                    return;
                break;    
                
                case 'merchantcreate':
                if($this->drawMerchantCreation())
                    return;
                break;    
                
                case 'merchantsave':
                if($this->processMerchantCreation())
                    return;
                break;    

                case 'settings':
                if($this->processSettings())
                    return;
                break;
                
                case 'finishconvert':
                if($this->drawFinishConvert())
                    return;
                break;    
                
                case 'startconvertfrom12x':
                if($this->processConvertDB())
                    return;
                break;
                
                case 'convertedfrom12x':
                if($this->processConvertSettings())
                    return;
                break;

                case 'startconvertfrom13':
                if($this->processConvertDB_13_131())
                    return;
                break;

                case 'convertedfrom13':
                if($this->drawFinishConvert13())
                    return;
                break;
                
                case 'settingscheckoutfree':
                if($this->checkSettingsUpgradeFree())
                    return;
                break;
            }
        }

        $this->step0();
    }  
    
    //------------------------------------------------------------------------

    function processChooseInstMethod()
    {
        // check if installation method is selected
        if(!in_array($_POST['installmethod'], array('install', 'upgradefree', 'upgrade122', 'upgrade13')))
            QUnit_Messager::setErrorMessage(L_G_CHOOSEINSTALLMETHOD);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            
            return false;
        }
        
        if($_POST['installmethod'] == 'install')
            $this->drawDBConfig();
        else if($_POST['installmethod'] == 'upgradefree')
            $this->drawUpgradeFree();
            //$this->addContent('not_available');
        else if($_POST['installmethod'] == 'upgrade122')
            $this->drawSettingsCheckout();
        else if($_POST['installmethod'] == 'upgrade13')
            $this->drawSettingsCheckout13();
        
        return true;
    }

    //------------------------------------------------------------------------

    function checkSettingsUpgradeFree()
    {
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
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            
            $this->drawUpgradeFree();
            return true;
        }

        $this->processDBConversionUpgradeFree();
        return true;
    }

    //------------------------------------------------------------------------

    function processDBConversionUpgradeFree()
    {
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
    
    //------------------------------------------------------------------------
    
    function drawUpgradeFree()
    {
        $_POST['action'] = 'settingscheckoutfree';
        
        $_SESSION[SESSION_PREFIX.'dbtype'] = DB_TYPE;
        $_SESSION[SESSION_PREFIX.'dbhostname'] = DB_HOSTNAME;
        $_SESSION[SESSION_PREFIX.'dbusername'] = DB_USERNAME;
        $_SESSION[SESSION_PREFIX.'dbpwd'] = DB_PASSWORD;
        $_SESSION[SESSION_PREFIX.'dbname'] = DB_DATABASE;
                
        $this->addContent('settings_free_upgrade');
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function drawSettingsCheckout13()
    {
        // check connect to database
        $db = ADONewConnection(DB_TYPE);
        $ret = @$db->Connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(!$ret || !$db)
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$db->errorMsg());
        else
        {
            $_SESSION[SESSION_PREFIX.'dbtype'] = DB_TYPE;
            $_SESSION[SESSION_PREFIX.'dbhostname'] = DB_HOSTNAME;
            $_SESSION[SESSION_PREFIX.'dbusername'] = DB_USERNAME;
            $_SESSION[SESSION_PREFIX.'dbpwd'] = DB_PASSWORD;
            $_SESSION[SESSION_PREFIX.'dbname'] = DB_DATABASE;
        }
        
        
        
        if(QUnit_Messager::getErrorMessage() == '')
            $_POST['action'] = 'startconvertfrom13';
        else
            $_POST['action'] = 'settingscheckout13';
                    
        $this->addContent('settings_checkout');
        return true;
    }

    //------------------------------------------------------------------------
    
    function drawSettingsCheckout()
    {
        // check connect to database
        $db = ADONewConnection(DB_TYPE);
        $ret = @$db->Connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(!$ret || !$db)
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$db->errorMsg());
        else
        {
            $_SESSION[SESSION_PREFIX.'dbtype'] = DB_TYPE;
            $_SESSION[SESSION_PREFIX.'dbhostname'] = DB_HOSTNAME;
            $_SESSION[SESSION_PREFIX.'dbusername'] = DB_USERNAME;
            $_SESSION[SESSION_PREFIX.'dbpwd'] = DB_PASSWORD;
            $_SESSION[SESSION_PREFIX.'dbname'] = DB_DATABASE;
        }
        
        
        
        if(QUnit_Messager::getErrorMessage() == '')
            $_POST['action'] = 'startconvertfrom12x';
        else
            $_POST['action'] = 'settingscheckout';
                    
        $this->addContent('settings_checkout');
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function drawMerchantCreation()
    {
        $_POST['action'] = 'merchantsave';
        
        $this->addContent('merchant_config');
        return true;
    }

    //------------------------------------------------------------------------

    function processMerchantCreation()
    {
        $username = preg_replace('/[\'\"]/', '', $_POST['username']);
        $pwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $pwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        
        // check correctness of the fields
        checkCorrectness($_POST['username'], $username, L_G_MUSERNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd1'], $pwd1, L_G_MPWD, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd2'], $pwd2, L_G_VERIFYMPWD, CHECK_EMPTYALLOWED);
        
        if(QUnit_Messager::getErrorMessage() != '') {
            $this->drawMerchantCreation();
            return true;
        }
        
        if($pwd1 != $pwd2) {
            QUnit_Messager::setErrorMessage(L_G_PASSWORDSDONTMATCH);
            $this->drawMerchantCreation();
            return true;
        }
        
        if($this->model->createMerchantAccount($username, $pwd1) === false) {
            $this->drawMerchantCreation();
            return true;
        }
        
        $_SESSION['merchantemail'] = $email;        
        $this->loadDefaultSettingsToPost();
        $this->drawSettings();
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function loadDefaultSettingsToPost()
    {
        $currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

        $pos = strpos($currentUrl, '/install/');
        if($pos !== false)
            $currentUrl = substr($currentUrl, 0, $pos);
        else
            $currentUrl = '';

        $_POST['export_dir'] = '../exports/';
        $_POST['banners_dir'] = '../banners/';
        $_POST['system_email'] = $_SESSION['merchantemail'];
        
        if($currentUrl != '')
        {
            $_POST['banners_url'] = $currentUrl.'/banners/';
            $_POST['export_url'] = $currentUrl.'/exports/';
            $_POST['scripts_url'] = $currentUrl.'/scripts/';
            $_POST['signup_url'] = $currentUrl.'/affsignup.php';
        }
    }
    
    //------------------------------------------------------------------------

    function drawSettings()
    {
        $_POST['action'] = 'settings';
        
        $this->addContent('settings');

        return true;        
    }
    
    //------------------------------------------------------------------------

    function processSettings()
    {
        // protect against script injection
        $export_dir = preg_replace('/[\"\']/', '', $_POST['export_dir']);
        $export_url = preg_replace('/[\"\']/', '', $_POST['export_url']);
        $banners_dir = preg_replace('/[\"\']/', '', $_POST['banners_dir']);
        $banners_url = preg_replace('/[\"\']/', '', $_POST['banners_url']);
        $scripts_url = preg_replace('/[\"\']/', '', $_POST['scripts_url']);
        $signup_url = preg_replace('/[\"\']/', '', $_POST['signup_url']);
        $system_email = preg_replace('/[\"\']/', '', $_POST['system_email']);
                            
        // check correctness of the fields
        checkCorrectness($_POST['export_dir'], $export_dir, L_G_EXPORTDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_dir'], $banners_dir, L_G_BANNERSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_url'], $banners_url, L_G_BANNERSURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['scripts_url'], $scripts_url, L_G_URLTOSCRIPTSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['signup_url'], $signup_url, L_G_SIGNUPURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['system_email'], $system_email, L_G_SYSTEMEMAIL, CHECK_EMPTYALLOWED);
        
        if(!$this->model->checkDirIsWritable($export_dir))
            QUnit_Messager::setErrorMessage("'$export_dir' ".L_G_DIRNOTWRITABLE);
        if(!$this->model->checkDirIsWritable($banners_dir))
            QUnit_Messager::setErrorMessage("'$banners_dir' ".L_G_DIRNOTWRITABLE);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawSettings();
            return true;
        }        

        if($this->model->updateSettings($_POST) === false) {
           $this->drawMerchantCreation();
           return true;
        }
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawSettings();
            return true;
        }        

        $this->drawFinish();
        return true;        
    }
    
    //------------------------------------------------------------------------

    function drawFinish()
    {
        $_POST['action'] = 'finish';
        
        $this->addContent('finish');

        return true;        
    }

    //------------------------------------------------------------------------

    function drawDBConfig()
    {
        $_POST['action'] = 'dbconfig';
        
        if(!isset($_POST['dbhostname']))
            $_POST['dbhostname'] = 'localhost';
        
        $this->addContent('db_config');

        return true;        
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
            if(!$this->model->checkDbConnection($dbtype, $dbhostname, $dbusername, $dbpwd, $dbname)) {
                QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$db->errorMsg());
            } else {    
                $_SESSION[SESSION_PREFIX.'dbtype'] = $_POST['dbtype'];
                $_SESSION[SESSION_PREFIX.'dbhostname'] = $_POST['dbhostname'];
                $_SESSION[SESSION_PREFIX.'dbusername'] = $_POST['dbusername'];
                $_SESSION[SESSION_PREFIX.'dbpwd'] = $_POST['dbpwd'];
                $_SESSION[SESSION_PREFIX.'dbname'] = $_POST['dbname'];
            }
        }
        
        if($this->model->checkFileIsWritable('../settings/settings.php') === false) {
            QUnit_Messager::setErrorMessage(L_G_SETTINGSFILENOTWRITABLE);
        }

        if($this->model->writeSettingsFile() === false) {
            QUnit_Messager::setErrorMessage(L_G_SETTINGSFILENOTWRITABLE);
        }        
            
        if(QUnit_Messager::getErrorMessage() != '') {
            $this->drawDBConfig();
            return true;   
        } else {
            $this->drawDBCreation();
            return true;                
        }

    }

    //------------------------------------------------------------------------

    function drawDBCreation() {        
        if($this->model->processDbCreation() === false) {
            $_POST['action'] = 'dbcreate';
        } else {
            $_POST['action'] = 'merchantcreate';            
        }        
        $this->addContent('db_created');
        return true;
    }
    
    //------------------------------------------------------------------------

    function step0()
    {
        $_POST['action'] = 'chooseinstmethod';

        $this->addContent('step0');
    }
    
    //------------------------------------------------------------------------

    function getDBErrorMsg()
    {
        if($GLOBALS['db'] == false)
            return L_G_DBCONNECTIONDOESNTEXIST;
            
        return $GLOBALS['db']->errorMsg();
    }    
    
    //------------------------------------------------------------------------

    function processConvertDB_13_131()
    {
        $GLOBALS['convertStatus'] = '';
        
        if(!$this->connectDB())
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$this->getDBErrorMsg());
            $this->drawSettingsCheckout();
            return true;
        }
        
        //--------------------------------------
        // start converting
        
        //--------------------------------------
        // backup table
        $GLOBALS['convertStatus'] .= L_G_BACKUPTABLES;
        $sql = "RENAME TABLE pa_impressions      TO bkp_pa_impressions;";        
        $rs = $this->executeDB($sql, $error);        
        if(!$rs)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom13';
            $this->addContent('db_convert');
            return true;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';
        
        //--------------------------------------
        // create new pa_impressions table
        $sql = "CREATE TABLE pa_impressions(".
               "impressionid INT NOT NULL AUTO_INCREMENT,".
               "dateimpression DATETIME NOT NULL,".
               "bannerid INT UNSIGNED,".
               "affiliateid INT UNSIGNED,".
               "all_imps_count INT DEFAULT 0,".
               "unique_imps_count INT DEFAULT 0,".
               "FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),".
               "FOREIGN KEY (bannerid) REFERENCES pa_banners (bannerid),".
               "PRIMARY KEY (impressionid),".
               "INDEX IDX_pa_impressions_1 (dateimpression),".
               "INDEX IDX_pa_impressions_2 (bannerid),".
               "INDEX IDX_pa_impressions_3 (bannerid,affiliateid,dateimpression),".
               "INDEX IDX_pa_impressions_4 (affiliateid));";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error." SQL: $sql");
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfrom13';
            $this->addContent('db_convert');
            return true;
        }        
        

        //------------------------------------------------
        // converting impressions
        $GLOBALS['convertStatus'] .= L_G_IMPRESSIONS;

        $sql = "insert into pa_impressions(".
               "dateimpression, bannerid, affiliateid, all_imps_count, unique_imps_count)".
               " select date_format(dateimpression, '%Y-%m-%d %H:00:00'), bannerid, affiliateid,".
               " count(impressionid), count(impressionid) from bkp_pa_impressions".
               " group by date_format(dateimpression, '%Y-%m-%d %H:00:00'), affiliateid, bannerid";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom13';
            $this->addContent('db_convert');
            return true;            
        }
        
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           

        //------------------------------------------------
        // dropping backup tables
        $GLOBALS['convertStatus'] .= L_G_DROPPINGBACKUPTABLES;
        $sql = "DROP TABLE bkp_pa_impressions";    

        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom13';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';


        //------------------------------------------------
        // finish conversion
        $_POST['action'] = 'convertedfrom13';
        $this->addContent('db_convert');
        return true;        
    }
    
    //------------------------------------------------------------------------

    function processConvertDB()
    {
        $GLOBALS['convertStatus'] = '';
        
        if(!$this->connectDB())
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$this->getDBErrorMsg());
            $this->drawSettingsCheckout();
            return true;
        }
        
        // check if it is 1.2.1 or 1.2.2
        // get columns from pa_recurring
        $cols = $this->DBColumns('pa_recurringcommissions');
        if(!in_array('staffiliateid', $cols))
        {
            //it is version 1.2.1, apply patch
            $patchSql = $this->getFileContents('./sql/update_12x_122.sql');
            if($patchSql == false || $patchSql == '')
            {
                QUnit_Messager::setErrorMessage(L_G_CANNOTOPENSQLSCRIPT);
                $_POST['action'] = 'startconvertfrom12x';
                $this->addContent('db_convert');
                
                return true;
            }
            
            //------------------------------------------------
            // create database
            $sqlcommands = explode(';', $patchSql);
            foreach($sqlcommands as $sql)
            {
                if(strlen($sql) > 20)
                {
                    $error = '';
                    $rs = $this->executeDB($sql, $error);
                    if($rs == false)
                    {
                        QUnit_Messager::setErrorMessage(L_G_DBERROR.$error." SQL: $sql");
                        break;
                    }
                }
            }
            
            if(QUnit_Messager::getErrorMessage() != '')
            {
                QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
                $_POST['action'] = 'startconvertfrom12x';
                $this->addContent('db_convert');
                return true;
            }
            
            $GLOBALS['convertStatus'] .= L_G_DBUPGRADEDTO122.'<br>';
        }

        //--------------------------------------
        // start converting
        
        //--------------------------------------
        // backup tables
        $GLOBALS['convertStatus'] .= L_G_BACKUPTABLES;
        $sql = "RENAME TABLE pa_merchants                TO bkp_pa_merchants,".
                    "pa_affiliates               TO bkp_pa_affiliates,".
                    "pa_affiliatescampaigns      TO bkp_pa_affiliatescampaigns,".
                    "pa_banners                  TO bkp_pa_banners,".
                    "pa_campaigns                TO bkp_pa_campaigns,".
                    "pa_campaigncategories       TO bkp_pa_campaigncategories,".
                    "pa_emailtemplates           TO bkp_pa_emailtemplates,".
                    "pa_recurringcommissions     TO bkp_pa_recurringcommissions,".
                    "pa_impressions              TO bkp_pa_impressions,".
                    "pa_transactions             TO bkp_pa_transactions;";        
        $rs = $this->executeDB($sql, $error);        
        if(!$rs)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';
        
        //--------------------------------------
        // create new structure
        $GLOBALS['convertStatus'] .= L_G_CREATINGNEWSTRUCTURE;
        $createSql = $this->getFileContents('./sql/create_pap_131_mysql.sql');
        if($createSql == false || $createSql == '')
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTOPENSQLSCRIPT);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            
            return true;
        }
        
        //------------------------------------------------
        // create database
        $sqlcommands = explode(';', $createSql);
        foreach($sqlcommands as $sql)
        {
            if(strlen($sql) > 20)
            {
                $error = '';
                $rs = $this->executeDB($sql, $error);
                if($rs == false)
                {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR.$error." SQL: $sql");
                    break;
                }
            }
        }
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;
        }        
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';        
        
        //------------------------------------------------
        // converting merchants
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGMERCHANTS;
        $oldColumns = $this->DBcolumns('bkp_pa_merchants');
        $newColumns = $this->DBcolumns('pa_merchants');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_merchants($values)".
               "select $values from bkp_pa_merchants";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        
        // get fraud protection settings
        $sql = "select declinefrequentclicks,declinefrequentsales,declinesameorderid,clickfrequency,salefrequency,affiliateapproval,afflogouturl,affpostsignupurl from bkp_pa_merchants where merchantid=1";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        if(!$rs->EOF)
        {
            $this->updateSetting('declinefrequentclicks', $rs->fields['declinefrequentclicks'], $errorMsg);
            $this->updateSetting('declinefrequentsales', $rs->fields['declinefrequentsales'], $errorMsg);
            $this->updateSetting('declinesameorderid', $rs->fields['declinesameorderid'], $errorMsg);
            $this->updateSetting('clickfrequency', $rs->fields['clickfrequency'], $errorMsg);
            $this->updateSetting('salefrequency', $rs->fields['salefrequency'], $errorMsg);
            $this->updateSetting('affiliateapproval', $rs->fields['affiliateapproval'], $errorMsg);
            $this->updateSetting('afflogouturl', $rs->fields['afflogouturl'], $errorMsg);
            $this->updateSetting('affpostsignupurl', $rs->fields['affpostsignupurl'], $errorMsg);
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         
        
        
        //------------------------------------------------
        // converting affiliates
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGAFFILIATES;
        $oldColumns = $this->DBColumns('bkp_pa_affiliates');
        $newColumns = $this->DBColumns('pa_affiliates');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_affiliates($values)".
               "select $values from bkp_pa_affiliates";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         
        
        
        //------------------------------------------------
        // converting campaigns
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGCAMPAIGNS;
        $oldColumns = $this->DBColumns('bkp_pa_campaigns');
        $newColumns = $this->DBColumns('pa_campaigns');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_campaigns($values)".
               "select $values from bkp_pa_campaigns";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         


        //------------------------------------------------
        // converting campaign categories
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGCAMPAIGNCATEGORIES;
        $oldColumns = $this->DBColumns('bkp_pa_campaigncategories');
        $newColumns = $this->DBColumns('pa_campaigncategories');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_campaigncategories($values, st2clickcommission, st2salecommission, st2recurringcommission)".
               "select $values, stclickcommission, stsalecommission, strecurringcommission  from bkp_pa_campaigncategories";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';
  
         
        //------------------------------------------------
        // converting banners
        $GLOBALS['convertStatus'] .= L_G_BANNERS;
        $oldColumns = $this->DBColumns('bkp_pa_banners');
        $newColumns = $this->DBColumns('pa_banners');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_banners($values)".
               "select $values from bkp_pa_banners";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
       
         
        //------------------------------------------------
        // converting email templates
        $GLOBALS['convertStatus'] .= L_G_EMAILTEMPLATES;
        $oldColumns = $this->DBColumns('bkp_pa_emailtemplates');
        $newColumns = $this->DBColumns('pa_emailtemplates');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_emailtemplates($values)".
               "select $values from bkp_pa_emailtemplates";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        
        $sql = "update pa_emailtemplates set lang='english' where lang='eng'";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }        
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';   


        //------------------------------------------------
        // converting impressions
        $GLOBALS['convertStatus'] .= L_G_IMPRESSIONS;

        $sql = "insert into pa_impressions(".
               "dateimpression, bannerid, affiliateid, all_imps_count, unique_imps_count)".
               " select date_format(dateimpression, '%Y-%m-%d %H:00:00'), bannerid, affiliateid,".
               " count(impressionid), count(impressionid) from bkp_pa_impressions".
               " group by date_format(dateimpression, '%Y-%m-%d %H:00:00'), affiliateid, bannerid";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        
        $sql = "drop table IF EXISTS seq_pa_impressions";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }      
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           

        
        //------------------------------------------------
        // converting transactions
        $GLOBALS['convertStatus'] .= L_G_TRANSACTIONS;
        $oldColumns = $this->DBColumns('bkp_pa_transactions');
        $newColumns = $this->DBColumns('pa_transactions');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_transactions($values)".
               "select $values from bkp_pa_transactions";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        
        $sql = "update pa_transactions set transkind=12 where transkind=2";        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
        

        //------------------------------------------------
        // converting affiliatescampaigns
        $GLOBALS['convertStatus'] .= L_G_AFFILIATESCAMPAIGNS;
        $oldColumns = $this->DBColumns('bkp_pa_affiliatescampaigns');
        $newColumns = $this->DBColumns('pa_affiliatescampaigns');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into bkp_pa_affiliatescampaigns($values)".
               "select $values from pa_affiliatescampaigns";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
       
                 
        //------------------------------------------------
        // converting recurring commissions
        $GLOBALS['convertStatus'] .= L_G_RECURRINGCOMMISSIONS;
        $oldColumns = $this->DBColumns('bkp_pa_recurringcommissions');
        $newColumns = $this->DBColumns('pa_recurringcommissions');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_recurringcommissions($values, st2commission, st2affiliateid)".
               "select $values, stcommission, staffiliateid from bkp_pa_recurringcommissions";
        
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
        
        
        //------------------------------------------------
        // dropping backup tables
        $GLOBALS['convertStatus'] .= L_G_DROPPINGBACKUPTABLES;
        $sql = "DROP TABLE bkp_pa_merchants, bkp_pa_affiliates, bkp_pa_affiliatescampaigns, bkp_pa_banners, bkp_pa_campaigns,".
               "bkp_pa_campaigncategories, bkp_pa_emailtemplates, bkp_pa_recurringcommissions, bkp_pa_impressions, bkp_pa_transactions";    

        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            
            $_POST['action'] = 'startconvertfrom12x';
            $this->addContent('db_convert');
            return true;            
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';


        //------------------------------------------------
        // finish conversion
        $_POST['action'] = 'convertedfrom12x';
        $this->addContent('db_convert');
        return true;        
    }
    
    //------------------------------------------------------------------------
    
    function processConvertSettings()
    {
        if(!$this->connectDB())
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$this->getDBErrorMsg());
            
            $this->addContent('settings_convert');
            return true;
        }        

        // convert settings (from settings file write them to database)
        $value = (AFF_SHOWBANKINFO == 1 ? 1 : 0);

        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('showbankinfo', "._q($value).", NULL)";

        $rs = $this->executeDB($sql, $error);

        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        $value = (L_G_SHOWPAYPALINFO == 1 ? 1 : 0);
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('showpaypalinfo', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }

        $value = (AFF_SHOWCHECKINFO == 1 ? 1 : 0);
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('showcheckinfo', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = SCRIPTS_URL;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('scripts_url', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = SYSTEM_EMAIL;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('system_email', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = SYSTEM_EMAIL;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('notifications_email', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = SYSTEM_CURRENCY;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('system_currency', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = EXPORT_DIR;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('export_dir', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = (LOGIN_PROTECTION_RETRIES != '' ? LOGIN_PROTECTION_RETRIES : 0);
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('login_protection_retries', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = (LOGIN_PROTECTION_DELAY != '' ? LOGIN_PROTECTION_DELAY : 0);
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('login_protection_delay', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = (SUPPORT_RECURRING_COMMISSIONS != '' ? 1 : 0);
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('support_recurring_commissions', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = BANNERS_DIR;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('banners_dir', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        $value = BANNERS_URL;
        $sql = "insert into pa_settings(code, value, affiliateid)".
               " values('banners_url', "._q($value).", NULL)";
        $rs = $this->executeDB($sql, $error);
        if($rs == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$error);
            
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;            
        }
        
        
        // update other settings that were not in previous settings file
        $currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

        $pos = strpos($currentUrl, '/install/');
        if($pos !== false)
            $currentUrl = substr($currentUrl, 0, $pos);
        else
            $currentUrl = '';
        
        if($currentUrl != '')
        {
            $export_url = $currentUrl.'/exports/';
            $signup_url = $currentUrl.'/affsignup.php';
        }
        else
        {
            $export_url = '';
            $signup_url = '';
        }
        
        
        $update_array = array(
                            'signup_url' => $signup_url,
                            'show_minihelp' => '1', 
                            'allow_choose_lang' => '0',
                            'min_payout_options' => '100;200;300;400;500',
                            'initial_min_payout' => '300',
                            'link_style' => '1',
                            'email_onaffsignup' => '1',
                            'email_onsale' => '0',
                            'email_dailyreport' => '0',
                            'email_recurringtrangenerated' => '0',
                            'email_supportdailyreports' => '0',
                            'forcecommfromproductid' => 'no',
                            'maxcommissionlevels' => '10',
                            'version' => '1.3',
                            'default_lang' => 'english',
                            'debug_trans' => '0'
        );
        
        $errorMsg2 = '';
        foreach($update_array as $code => $value)
        {
            if(!$this->updateSetting($code, $value, $errorMsg2))
                break;
        }  
        
        if($errorMsg2 != '')
        {
            QUnit_Messager::setErrorMessage($errorMsg2);
            $_POST['action'] = 'convertedfrom12x';
            $this->addContent('settings_convert');
            return true;               
        } 
        
        $_POST['action'] = 'finishconvert';
        $this->addContent('settings_convert');
        
        return true;  
    }
    
    //------------------------------------------------------------------------

    function drawFinishConvert()
    {
        $_POST['action'] = 'finishconvert2';
        
        $this->addContent('finish_convert');

        return true;        
    }
    
    //------------------------------------------------------------------------

    function drawFinishConvert13()
    {
        $_POST['action'] = 'finishconvert2';
        
        $this->addContent('finish_convert_13');

        return true;        
    }
    
    //------------------------------------------------------------------------

    function DBcolumns($table)
    {
        $columnsObj = $GLOBALS['db']->MetaColumns($table);
        
        $columns = array();
        foreach($columnsObj as $col)
        {
            $columns[] = strtolower($col->name);
        }
        
        return $columns;
    }
    
    //------------------------------------------------------------------------

    function DBcreateInsert($columns)
    {
        $values = '';
        
        foreach($columns as $column)
        {
            if($values != '')
            $values .= ', ';
            
            $values .= $column;   
        }
        
        return $values;
    }
}
?>