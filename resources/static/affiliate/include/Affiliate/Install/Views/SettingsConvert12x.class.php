<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_SettingsConvert12x extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_SettingsConvert12x() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getContent() {
        $this->assign('action', 'SettingsConvert12x');
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
        
}
?>