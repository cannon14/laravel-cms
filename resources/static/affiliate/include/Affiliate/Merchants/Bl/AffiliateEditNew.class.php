<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_AffiliateAddNew');

class Affiliate_Merchants_Bl_AffiliateEditNew extends Affiliate_Merchants_Bl_AffiliateAddNew {
    
    function setStatus() {
        $this->user->setNeeded('rstatus', false);        
    }
    
    function sendMail($userId, $aid, $userName, $pwd, $status) {
        return true;
    }    
    
    function getUserId() {
        return $_POST['userid'];
    }    

    function saveUser() {
        return $this->user->updateUser();
    }       
    
    function setPassword($pwd) {
        if(preg_match('/\*+/', $pwd) || empty($pwd)) {
            $this->user->setNeeded('rpassword', false);
        } else {
            $this->user->setColumn('rpassword', $pwd);
        }        
    }  
    
    function checkUserExists() {
        if($this->getUserName() != $this->getOriginalUserName()) {            
            if(QCore_Bl_Users::checkUserExists('', $this->getUserName()) === true) {
                $this->addErrorMessage(L_G_UNAMEEXISTS);
                return false;
            }         
        }
        return true;
    }   

    function getOriginalUserName() {
        $sql = "select username from wd_g_users where userid='".$this->getUserId()."'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }       
        return $rs->Fields['username'];
         
    }   
}
?>
