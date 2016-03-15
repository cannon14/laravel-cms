<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvert12x extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConvert12x() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getContent() {
        $this->assign('action', 'DbConvert12x');
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
        
    function convert()
    {
        $GLOBALS['convertStatus'] = '';
        
        if(!$this->model->connectDB()) {
            return false;
        }
        
        // check if it is 1.2.1 or 1.2.2
        // get columns from pa_recurring
        $cols = $this->model->DBColumns('pa_recurringcommissions');
        if(!in_array('staffiliateid', $cols))
        {
            //it is version 1.2.1, apply patch
            if(!$this->model->executeSqlFile('./sql/update_12x_122.sql')) {
                return false;
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
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';
        
        //--------------------------------------
        // create new structure
        $GLOBALS['convertStatus'] .= L_G_CREATINGNEWSTRUCTURE;
        
        if(!$this->model->executeSqlFile('./sql/create_pap_131_mysql.sql')) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';        
        
        //------------------------------------------------
        // converting merchants
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGMERCHANTS;
        $oldColumns = $this->model->DBcolumns('bkp_pa_merchants');
        $newColumns = $this->model->DBcolumns('pa_merchants');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_merchants($values)".
               "select $values from bkp_pa_merchants";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }               
        
        // get fraud protection settings
        $sql = "select declinefrequentclicks,declinefrequentsales,declinesameorderid,clickfrequency,salefrequency,affiliateapproval,afflogouturl,affpostsignupurl from bkp_pa_merchants where merchantid=1";
        if(($rs = $this->model->executeDB($sql)) === false) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
                
        if(!$rs->EOF)
        {
            $this->updateSetting('declinefrequentclicks', $rs->fields['declinefrequentclicks']);
            $this->updateSetting('declinefrequentsales', $rs->fields['declinefrequentsales']);
            $this->updateSetting('declinesameorderid', $rs->fields['declinesameorderid']);
            $this->updateSetting('clickfrequency', $rs->fields['clickfrequency']);
            $this->updateSetting('salefrequency', $rs->fields['salefrequency']);
            $this->updateSetting('affiliateapproval', $rs->fields['affiliateapproval']);
            $this->updateSetting('afflogouturl', $rs->fields['afflogouturl']);
            $this->updateSetting('affpostsignupurl', $rs->fields['affpostsignupurl']);
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         
        
        
        //------------------------------------------------
        // converting affiliates
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGAFFILIATES;
        $oldColumns = $this->model->DBColumns('bkp_pa_affiliates');
        $newColumns = $this->model->DBColumns('pa_affiliates');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_affiliates($values)".
               "select $values from bkp_pa_affiliates";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         
        
        
        //------------------------------------------------
        // converting campaigns
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGCAMPAIGNS;
        $oldColumns = $this->model->DBColumns('bkp_pa_campaigns');
        $newColumns = $this->model->DBColumns('pa_campaigns');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_campaigns($values)".
               "select $values from bkp_pa_campaigns";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';         


        //------------------------------------------------
        // converting campaign categories
        $GLOBALS['convertStatus'] .= L_G_CONVERTINGCAMPAIGNCATEGORIES;
        $oldColumns = $this->model->DBColumns('bkp_pa_campaigncategories');
        $newColumns = $this->model->DBColumns('pa_campaigncategories');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_campaigncategories($values, st2clickcommission, st2salecommission, st2recurringcommission)".
               "select $values, stclickcommission, stsalecommission, strecurringcommission  from bkp_pa_campaigncategories";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';
  
         
        //------------------------------------------------
        // converting banners
        $GLOBALS['convertStatus'] .= L_G_BANNERS;
        $oldColumns = $this->model->DBColumns('bkp_pa_banners');
        $newColumns = $this->model->DBColumns('pa_banners');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_banners($values)".
               "select $values from bkp_pa_banners";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
       
         
        //------------------------------------------------
        // converting email templates
        $GLOBALS['convertStatus'] .= L_G_EMAILTEMPLATES;
        $oldColumns = $this->model->DBColumns('bkp_pa_emailtemplates');
        $newColumns = $this->model->DBColumns('pa_emailtemplates');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_emailtemplates($values)".
               "select $values from bkp_pa_emailtemplates";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        
        $sql = "update pa_emailtemplates set lang='english' where lang='eng'";
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
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
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        
        $sql = "drop table IF EXISTS seq_pa_impressions";
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           

        
        //------------------------------------------------
        // converting transactions
        $GLOBALS['convertStatus'] .= L_G_TRANSACTIONS;
        $oldColumns = $this->model->DBColumns('bkp_pa_transactions');
        $newColumns = $this->model->DBColumns('pa_transactions');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_transactions($values)".
               "select $values from bkp_pa_transactions";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        
        $sql = "update pa_transactions set transkind=12 where transkind=2";        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
        

        //------------------------------------------------
        // converting affiliatescampaigns
        $GLOBALS['convertStatus'] .= L_G_AFFILIATESCAMPAIGNS;
        $oldColumns = $this->model->DBColumns('bkp_pa_affiliatescampaigns');
        $newColumns = $this->model->DBColumns('pa_affiliatescampaigns');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into bkp_pa_affiliatescampaigns($values)".
               "select $values from pa_affiliatescampaigns";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
       
                 
        //------------------------------------------------
        // converting recurring commissions
        $GLOBALS['convertStatus'] .= L_G_RECURRINGCOMMISSIONS;
        $oldColumns = $this->model->DBColumns('bkp_pa_recurringcommissions');
        $newColumns = $this->model->DBColumns('pa_recurringcommissions');
        $colsIntersection = array_intersect($oldColumns, $newColumns);
        $values = $this->model->DBcreateInsert($colsIntersection);
        
        $sql = "insert into pa_recurringcommissions($values, st2commission, st2affiliateid)".
               "select $values, stcommission, staffiliateid from bkp_pa_recurringcommissions";
        
        if(!$this->model->executeDB($sql)) {
            $GLOBALS['convertStatus'] .= L_G_ERROR.'<br>';
            return false;
        }
        $GLOBALS['convertStatus'] .= '...'.L_G_OK.'<br>';           
        
        
        //------------------------------------------------
        // dropping backup tables
        $GLOBALS['convertStatus'] .= L_G_DROPPINGBACKUPTABLES;
        $sql = "DROP TABLE bkp_pa_merchants, bkp_pa_affiliates, bkp_pa_affiliatescampaigns, bkp_pa_banners, bkp_pa_campaigns,".
               "bkp_pa_campaigncategories, bkp_pa_emailtemplates, bkp_pa_recurringcommissions, bkp_pa_impressions, bkp_pa_transactions";    

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