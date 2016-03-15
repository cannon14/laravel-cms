<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Settings extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_Settings() {
        $this->init(); 
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }    
    
    function init() {
        parent::init();        
    }
           
    function getName() {
        return 'Settings';
    }     
            
    function getContent() {
         $this->loadDefaultSettings();
        return $this->fetch('settings');
    }      
    
    function process() { 
        if(isset($_POST['submit'])) {
            if($this->processSettings() === true) {      
                return true;
            } 
        }
        return false;
        
    }  
    
   //------------------------------------------------------------------------
    
    function loadDefaultSettings()
    {
        $currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

        $pos = strpos($currentUrl, '/install/');
        if($pos !== false)
            $currentUrl = substr($currentUrl, 0, $pos);
        else
            $currentUrl = '';

        $_POST['export_dir'] = '../exports/';
        $_POST['banners_dir'] = '../banners/';
        $_POST['main_site_url'] = "http://".$_SERVER['HTTP_HOST'];
        
        if($currentUrl != '')
        {
            $_POST['banners_url'] = $currentUrl.'/banners/';
            $_POST['export_url'] = $currentUrl.'/exports/';
            $_POST['scripts_url'] = $currentUrl.'/scripts/';
            $_POST['signup_url'] = $currentUrl.'/affsignup.php';
        }
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
        $main_site_url = preg_replace('/[\"\']/', '', $_POST['main_site_url']);
                            
        // check correctness of the fields
        checkCorrectness($_POST['export_dir'], $export_dir, L_G_EXPORTDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_dir'], $banners_dir, L_G_BANNERSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_url'], $banners_url, L_G_BANNERSURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['scripts_url'], $scripts_url, L_G_URLTOSCRIPTSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['signup_url'], $signup_url, L_G_SIGNUPURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['system_email'], $system_email, L_G_SYSTEMEMAIL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['main_site_url'], $main_site_url, L_G_MAINSITEURL, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }        

        if(!$this->model->checkDirIsWritable($export_dir)) {
            QUnit_Messager::setErrorMessage("'$export_dir' ".L_G_DIRNOTWRITABLE);
            return false;
        }
        if(!$this->model->checkDirIsWritable($banners_dir)) {
            QUnit_Messager::setErrorMessage("'$banners_dir' ".L_G_DIRNOTWRITABLE);
            return false;
        }        

        if($this->model->updateSettings(array('export_dir' => $export_dir, 'export_url' => $export_url, 'banners_dir' => $banners_dir, 'banners_url' => $banners_url, 'scripts_url' => $scripts_url, 'signup_url' => $signup_url, 'system_email' => $system_email, 'main_site_url' => $main_site_url)) === false) {
           return false;
        }

        return true;        
    }    
    
}
?>