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

class Affiliate_Merchants_Bl_MerchantDBAuth extends QCore_Auth
{
    function Affiliate_Merchants_Bl_MerchantDBAuth()
    {
        $this->sessionPrefix = 'merchauth';
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
            $array_data2 = QCore_Settings::getAdminSettings(SETTINGTYPE_ADMIN, $this->accountID, $this->userID);
        }

        $this->settings = array_merge($array_data1, $array_data2);

        $this->saveToSession();
    }
    
    //------------------------------------------------------------------------

    function getCommissionTypeString($type)
    {
        if($type & TRANSTYPE_CPM) return L_G_TYPECPM;
        else if($type & TRANSTYPE_CLICK) return L_G_TYPECLICK;
        else if($type & TRANSTYPE_SALE) return L_G_TYPESALE;
        else if($type & TRANSTYPE_LEAD) return L_G_TYPELEAD;
        else if($type & TRANSTYPE_RECURRING) return L_G_TYPERECURRING;
        else if($type & TRANSTYPE_SIGNUP) return L_G_TYPESIGNUP;
        else if($type & TRANSTYPE_REFERRAL) return L_G_TYPEREFERRAL;
        
        return L_G_UNKNOWN;
    }
    
    //------------------------------------------------------------------------

    function getComposedCommissionTypeString($type)
    {
        $strtype = '';
        
        if($type & TRANSTYPE_CPM) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPECPM;
        if($type & TRANSTYPE_CLICK) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPECLICK;
        if($type & TRANSTYPE_SALE) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPESALE;
        if($type & TRANSTYPE_LEAD) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPELEAD;
        if($type & TRANSTYPE_RECURRING) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPERECURRING;
        if($type & TRANSTYPE_SIGNUP) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPESIGNUP;
        if($type & TRANSTYPE_REFERRAL) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPEREFERRAL;
        
        if($strtype == '')
            $strtype = L_G_UNKNOWN;
            
        return $strtype;
    }
    
    //------------------------------------------------------------------------

    function getCommissionTypeSelect($selectName, $selected, $onlyStrict = true)
    {
        print '<select name="'.$selectName.'" multiple>';
        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1)
        {
            print '  <option value="'.TRANSTYPE_CPM.'" '.(is_array($selected) ? (in_array(TRANSTYPE_CPM, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_CPM ? 'selected' : '')).'>'.L_G_TYPECPM.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_CLICK.'" '.(is_array($selected) ? (in_array(TRANSTYPE_CLICK, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_CLICK ? 'selected' : '')).'>'.L_G_PERCLICK.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_LEAD.'" '.(is_array($selected) ? (in_array(TRANSTYPE_LEAD, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_LEAD ? 'selected' : '')).'>'.L_G_PERLEAD.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_SALE.'" '.(is_array($selected) ? (in_array(TRANSTYPE_SALE, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_SALE ? 'selected' : '')).'>'.L_G_PERSALE.'</option>';
        }

        if(!$onlyStrict)
        {
            if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1)
            {
                print '  <option value="'.TRANSTYPE_RECURRING.'" '.(is_array($selected) ? (in_array(TRANSTYPE_RECURRING, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_RECURRING ? 'selected' : '')).'>'.L_G_RECURRINGCOMMISSIONS.'</option>';
            }
            
            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1)
            {
                print '  <option value="'.TRANSTYPE_SIGNUP.'" '.(is_array($selected) ? (in_array(TRANSTYPE_SIGNUP, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_SIGNUP ? 'selected' : '')).'>'.L_G_SIGNUPBONUS.'</option>';
            }
            
            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1)
            {
                print '  <option value="'.TRANSTYPE_REFERRAL.'" '.(is_array($selected) ? (in_array(TRANSTYPE_REFERRAL, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_REFERRAL ? 'selected' : '')).'>'.L_G_PERREFERRAL.'</option>';
            }
        }

        print '</select>';
    }
    
    //------------------------------------------------------------------------

    function getAllowedCommissionTypes($strict = false)
    {
        $arr = array();
        
        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) $arr[] = TRANSTYPE_CPM;
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1) $arr[] = TRANSTYPE_CLICK;
        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1) $arr[] = TRANSTYPE_LEAD;
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1) $arr[] = TRANSTYPE_SALE;
        
        if(!$strict)
        {
            if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) $arr[] = TRANSTYPE_RECURRING;
            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1) $arr[] = TRANSTYPE_SIGNUP;
            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1) $arr[] = TRANSTYPE_REFERRAL;
        }
        
        return $arr;
    }
    
    //------------------------------------------------------------------------

    function getCountOfAllowedCommissionTypes($strict = false)
    {
        $arr = 0;
        
        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) $arr++;
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1) $arr++;
        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1) $arr++;
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1) $arr++;
        
        if(!$strict)
        {
            if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) $arr++;
            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1) $arr++;
            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1) $arr++;
        }
        
        return $arr;
    }
}
?>
