<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_Settings extends QUnit_UI_TemplatePage
{
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'edit':
                    if($this->saveSettings())
                        return;
                    break;
            }
        }
        
        $this->showSettings();    
    }  

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function saveSettings()
    {
        // protect against script injection
        $email_affonaffsignup = preg_replace('/[^0-9]/', '', $_POST['email_affonaffsignup']);
        $email_affonsale = preg_replace('/[^0-9]/', '', $_POST['email_affonsale']);
        $email_affdailyreport = preg_replace('/[^0-9]/', '', $_POST['email_affdailyreport']);
        $aff_notificationlang = preg_replace('/[\'\"]/', '', $_POST['aff_notificationlang']);

        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            $update_array = array(
                            'Aff_email_affonaffsignup' => $email_affonaffsignup,
                            'Aff_email_affonsale' => $email_affonsale,
                            'Aff_email_affdailyreport' => $email_affdailyreport,
                            'Aff_aff_notificationlang' => $aff_notificationlang
                            );
                            
            foreach($update_array as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_USER,
                                            $GLOBALS['Auth']->getAccountID(),
                                            $GLOBALS['Auth']->getUserID()
                                            ) )
                    return false;
            }

            $GLOBALS['Auth']->loadSettings();

            QUnit_Messager::setOkMessage(L_G_CHANGESSAVED);
        }

        Affiliate_Affiliates_Views_Settings::showSettings();    

        return true;
    }
    
    
    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================
    
    function showSettings()
    {
        if($_POST['commited'] != 'yes')
        {
            // get settings from Auth
            $settings = $GLOBALS['Auth']->getSettings();

            $_POST['aff_notificationlang'] = $settings['Aff_aff_notificationlang'];
            $_POST['email_affonaffsignup'] = $settings['Aff_email_affonaffsignup'];
            $_POST['email_affonsale'] = $settings['Aff_email_affonsale'];
            $_POST['email_affdailyreport'] = $settings['Aff_email_affdailyreport'];

            if($_POST['aff_notificationlang'] == '')
                $_POST['aff_notificationlang'] = $_SESSION[SESSION_PREFIX.'lang'];
        }

       $availableLangs = QCore_Settings::getAvailableLangs();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($availableLangs);

        $this->assign('a_list_data', $list_data);

        $this->addContent('settings');

        return true;
    }    
}
?>