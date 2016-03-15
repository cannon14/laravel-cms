<?
/**
*
*   @author Maros Fric, Ladislav Tamas
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

QUnit_Global::includeClass('QCore_Auth');

class Affiliate_Scripts_Bl_Auth extends QCore_Auth
{
    var $loadedSettingsForAccountID = '';
    
    //------------------------------------------------------------------------

    function Affiliate_Scripts_Bl_Auth()
    {
        $this->sessionPrefix = 'gaffauth';
        
        if($this->accountID == '') {
            $this->accountID = 'default1';
        }
    }

    //------------------------------------------------------------------------

    function loadSettings()
    {
        if($this->accountID == '')
            return false;
  
        if($this->loadedSettingsForAccountID == $this->accountID) {
            // settings already loaded
        }
        else {
            $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->accountID);
            $this->loadedSettingsForAccountID = $this->accountID;
        }

        if($this->userID != '')
        {
            $userSettings = QCore_Settings::getAdminSettings(SETTINGTYPE_USER, $this->accountID, $this->userID);
            
            $this->settings = array_merge($this->settings, $userSettings);
        }
        
        $this->saveToSession();
    }
    
    //------------------------------------------------------------------------

    function setAccountID($accountID)
    {
        $this->accountID = $accountID;
        
        $this->loadSettings();
    }

}
?>