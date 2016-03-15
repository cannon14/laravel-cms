<?
QUnit_Global::includeClass('QUnit_UI_TemplateEngine');

class QUnit_UI_TemplatePage
{
    var $templateEngine;
    var $temporaryTemplateEngine;
    var $template = '';
    var $mainTemplate = '';
    var $templateSuffix = '';
    var $filePrefix = '';
    var $user_type = '';
    var $modulePermissions = array();
    
    //------------------------------------------------------------------------
    
    function init($template = 'blank') 
    {
        $this->template = $template;
        if($this->mainTemplate == '')
            $this->mainTemplate = 'main';
        $this->templateSuffix = '.tpl.php';
        $this->initTemplateEngine();
        $this->initPermissions();
    }
    
    //------------------------------------------------------------------------

    function initPermissions()
    {
    }
    
    //------------------------------------------------------------------------

    function checkPermissions($action = '')
    {
        if($action == '') $action = $this->getAction();

        if(!is_array($this->modulePermissions) || count($this->modulePermissions)<=0)
            return true;

        $necessaryPermission = $this->modulePermissions[$action];

        if($necessaryPermission == '' || $GLOBALS['Auth']->checkPermission($necessaryPermission))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //------------------------------------------------------------------------
    
    function getAction()
    {
        if($_REQUEST['postaction'] != '')
            return $_REQUEST['postaction'];
        if($_REQUEST['massaction'] != '')
            return $_REQUEST['massaction'];
        if($_REQUEST['action'] != '')
            return $_REQUEST['action'];
        if($_REQUEST['reporttype'] != '')
            return $_REQUEST['reporttype'];
        
        return 'view';
    }
    
    //------------------------------------------------------------------------

    /**
     * inits temporary Template Engine which can be used for rendering subsections 
     * of the page
     */
    function initTemplateEngine() 
    {
        $this->templateEngine =& QUnit_Global::newobj('QUnit_UI_TemplateEngine');
    }
    
    //------------------------------------------------------------------------

    function initTemporaryTE() 
    {
        $this->temporaryTemplateEngine =& QUnit_Global::newobj('QUnit_UI_TemplateEngine');
    }
    
    //------------------------------------------------------------------------
    
    function process() 
    {
        QUnit_Page::end_timer();
        
        $this->mainPageAssigns();
        
        return $this->fetch($this->template);
    }

    //------------------------------------------------------------------------

    function fetch($template) 
    {
        $this->globalAssigns();

        $content = $this->templateEngine->fetch($template . $this->templateSuffix);

        if(is_object($content))
            return $content->text;
        else
            return $content;
	    echo $this->template;
    }

    //------------------------------------------------------------------------

    function temporaryFetch($template)
    {
        $this->temporaryAssign('a_Auth', $GLOBALS['Auth']);

        $content = $this->temporaryTemplateEngine->fetch($template . $this->templateSuffix);

        if(is_object($content))
            return $content->text;
        else
            return $content;        
    }
    
    //------------------------------------------------------------------------

    function mainPageAssigns()
    {
        $this->assign('a_dbrequests', $GLOBALS['dbrequests']);
        $this->assign('a_timegenerated', QUnit_Page::getTimeGenerated());
    }

    //------------------------------------------------------------------------

    function globalAssigns()
    {
        $this->assign('a_Auth', $GLOBALS['Auth']);
        $this->assign('a_this', $this);
    }
    
    //------------------------------------------------------------------------

    function pageLimitsAssign()
    {
        $this->assign('a_list_page', $_REQUEST['list_page']);
        $this->assign('a_list_pages', $_REQUEST['list_pages']);
        $this->assign('a_allcount', $_REQUEST['allcount']);
    }

    //------------------------------------------------------------------------

    function redirect($request)
    {
        QUnit_UI_TemplatePage::timeRedirectNomsg($request);
        //header("Location: index.php?md=".$request);
        exit;
    }

    //------------------------------------------------------------------------    

    function timeRedirect($request, $time = 0)
    {
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=index.php?md=$request\">";
    
      echo "<br><center><span class=redirecttext>".L_G_WAITTRANSFER."</a><br><br><a class=redirectlink href=index.php?md=$request>".L_G_TRANSFERNOW."</a></center>";
    }

    //------------------------------------------------------------------------
    
    function timeRedirectNomsg($request, $time = 0)
    {
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=index.php?md=$request\">";
    }


    //------------------------------------------------------------------------

    function closeWindow($modul)
    {
        $this->assign('redirect_modul', $modul);
    }
    
    //------------------------------------------------------------------------

    function assign($var, $value)
    {
        $this->templateEngine->assign($var, $value);
    }

    //------------------------------------------------------------------------

    function temporaryAssign($var, $value)
    {
        $this->temporaryTemplateEngine->assign($var, $value);
    }
    
    //------------------------------------------------------------------------

    function getFilePrefix()
    {
        return $this->filePrefix;
    }
    
    //------------------------------------------------------------------------

    function setFilePrefix($filePrefix)
    {
        $this->filePrefix = $filePrefix;
    }

    //------------------------------------------------------------------------

    function getMainTemplate()
    {
        return $this->mainTemplate;
    }
    
    //------------------------------------------------------------------------

    function setMainTemplate($mainTemplate)
    {
        $this->mainTemplate = $mainTemplate;
    }
    
    //------------------------------------------------------------------------
    
    function addContent($template, $main_tpl = '')
    {
//        if($main_tpl != '')
//            $this->setMainTemplate($main_tpl);

        $this->assign('okMessages', QUnit_Messager::getOkMessages());
        $this->assign('errorMessages', QUnit_Messager::getErrorMessages());
        
        $this->temp_content .= $this->fetch($template);
    }
    
    //------------------------------------------------------------------------
    
    function clearTempContent()
    {
        $this->temp_content = '';
    }

    //------------------------------------------------------------------------

    function getTemplateName($file)
    {
        return $file.$this->templateSuffix;
    }
    
    //------------------------------------------------------------------------

    function isLoginPage()
    {
        return false;
    }
}
?>
