<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvert13x extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConvert13x() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getName() {
        return 'DbConvert';
    }
    
    function getContent() {
        if($this->convert()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        $this->assign('action', 'DbConvert13x');
        return $this->fetch('db_convert');        
    }
    
    function process() { 
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        return false;    
    }  
    
    function convert() {
        $GLOBALS['convertStatus'] = '';
        
        if(!$this->model->connectDB()) {
            return false;
        }
        
        //--------------------------------------
        // start converting
        
        //--------------------------------------
        // backup table
        $GLOBALS['convertStatus'] .= L_G_BACKUPTABLES;
        $sql = "RENAME TABLE pa_impressions      TO bkp_pa_impressions;";        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
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
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }    
        

        //------------------------------------------------
        // converting impressions
        $GLOBALS['convertStatus'] .= L_G_IMPRESSIONS;

        $sql = "insert into pa_impressions(".
               "dateimpression, bannerid, affiliateid, all_imps_count, unique_imps_count)".
               " select date_format(dateimpression, '%Y-%m-%d %H:00:00'), bannerid, affiliateid,".
               " count(impressionid), count(impressionid) from bkp_pa_impressions".
               " group by date_format(dateimpression, '%Y-%m-%d %H:00:00'), affiliateid, bannerid";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }  
        
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           

        //------------------------------------------------
        // dropping backup tables
        $GLOBALS['convertStatus'] .= L_G_DROPPINGBACKUPTABLES;
        $sql = "DROP TABLE bkp_pa_impressions";    

        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }    
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';

        //------------------------------------------------
        // finish conversion
        return true;          
    }    
            
}
?>