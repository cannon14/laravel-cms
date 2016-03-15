<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_AffEmailTemplates extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['edittemplate'] = 'aff_comm_email_templates_modify';
        $this->modulePermissions['view'] = 'aff_comm_email_templates_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edittemplate':
                    if($this->processEditTemplate())
                        return;
                    break;
            }
        }

        $this->showCategories();
    }  

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================
  
    function processEditTemplate()
    {
        // protect against script injection
        $pcategory = preg_replace('/[\'\"]/', '', $_POST['emailcategory']);
        $plang = preg_replace('/[\'\"]/', '', $_POST['language']);

        if($plang == '') $plang = 'english';

        $pemailsubject = $_POST['emailsubject'];   // preg_replace('/[\'\"]/', '', $_POST['emailsubject']);
        $pemailtext = $_POST['emailtext'];   // preg_replace('/[\'\"]/', '', $_POST['emailtext']);
      
        // check correctness of the fields
        if(!in_array($pcategory, $GLOBALS['emailcategories']))
            QUnit_Messager::setErrorMessage(L_G_CATDOESNTEXISTS);
      
        $CategoryID = $this->checkCategoryExists($pcategory, $plang);

        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            // save changes of user to db
            if($CategoryID == false)
            {
                $emailtempsid = QCore_Sql_DBUnit::createUniqueID('wd_g_emailtemplates', 'emailtempsid');
                $sql = "insert into wd_g_emailtemplates(emailtempsid, categorycode, emailsubject, emailtext, lang)".
                       " values("._q($emailtempsid).", "._q($pcategory).
                       ","._q($pemailsubject).","._q($pemailtext).
                       ","._q($plang).")";
            }
            else
                $sql = "update wd_g_emailtemplates ".
                       "set emailsubject="._q($pemailsubject).
                       "   ,emailtext="._q($pemailtext).
                       " where emailtempsid="._q($CategoryID);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
      
            if (!$ret)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }    
            else
            {
                QUnit_Messager::setOkMessage(L_G_TEMPLATESAVED);
        
                return false;
            }
        }
    
        return false;
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showCategories()
    {
        if($_REQUEST['emailcategory'] == '')
            $_REQUEST['emailcategory'] = $GLOBALS['emailcategories'][0];

        if($_REQUEST['language'] == '')
            $_REQUEST['language'] = $_SESSION[SESSION_PREFIX.'lang'];

        $_REQUEST['emailcategory'] = preg_replace('/[\'\"]/', '', $_REQUEST['emailcategory']);
        $_REQUEST['language'] = preg_replace('/[\'\"]/', '', $_REQUEST['language']);

        // first check if template exists in merchant templates
        $sql = 'select * from wd_g_emailtemplates where deleted=0 and lang='._q(substr($_REQUEST['language'], 0, 10)).' and categorycode='._q($_REQUEST['emailcategory']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $_POST['action'] = '';
        $_POST['postaction'] = 'edittemplate';

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);
        
        $this->assign('a_list_data', $list_data);
        
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($GLOBALS['emailcategories']);
        
        $this->assign('a_list_data2', $list_data2);
        
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS(QCore_Settings::getAvailableLangs());
        
        $this->assign('a_list_data3', $list_data3);
        
        $temp_perm['edittemplate'] = $this->checkPermissions('edittemplate');
        
        $this->assign('a_action_permission', $temp_perm);
        
        $this->addContent('et_form');
    }

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

    function checkCategoryExists($catname, $lang)
    {
        $sql = 'select * from wd_g_emailtemplates '.
               'where deleted=0 and lang='._q(substr($lang, 0, 10)).
               '  and categorycode='._q($catname);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        if($rs->EOF)
            return false;
      
        return $rs->fields['emailtempsid'];
    }
}
?>
