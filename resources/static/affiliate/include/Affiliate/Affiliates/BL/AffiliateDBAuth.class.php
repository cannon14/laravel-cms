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

QUnit_Global::includeClass('Affiliate_Merchants_Bl_MerchantDBAuth');

class Affiliate_Affiliates_Bl_AffiliateDBAuth extends Affiliate_Merchants_Bl_MerchantDBAuth
{
    function Affiliate_Affiliates_Bl_AffiliateDBAuth()
    {
        $this->sessionPrefix = 'affauth';
    }

    //------------------------------------------------------------------------

    function loadSettings()
    {
        if($this->accountID == '' && $this->userID == '') {
            return false;
        }
        
        $array_data1 = array();
        $array_data2 = array();

        if($this->accountID != '') {
            $array_data1 = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->accountID);
        }
        
        if($this->userID != '') {
            $array_data2 = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->accountID, $this->userID);
        }

        $this->settings = array_merge($array_data1, $array_data2);

        $this->saveToSession();
    }
}
?>