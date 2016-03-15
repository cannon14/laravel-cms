<?
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_UI_MainPage extends QUnit_UI_TemplatePage
{
    var $defaultView;
    
    //--------------------------------------------------------------------------

    function init()
    {
        parent::init();

        $this->template = $this->getMainTemplate();
    }
    
    //--------------------------------------------------------------------------

    function _getPageName() 
    {
        if($_REQUEST['md'] == '')
        {
            $pageName = $this->getFilePrefix().$this->defaultView;
        } 
        else 
        {
            $pageName = $_REQUEST['md'];
        }

        if(strtolower($pageName) == $this->getFilePrefix().'Login') 
        {
            $this->menu = 'blank';
        }
        
        return $pageName;
    }

    //--------------------------------------------------------------------------

    function _checkPage($pageName) 
    {
        return QUnit_Global::existsClass($pageName);
    }
    
    //--------------------------------------------------------------------------
    
    function &_getPage() 
    {
        $pageName = $this->_getPageName();

        if(!$this->_checkPage($pageName)) 
        {
            echo "class $pageName does not exist";
        }

        return QUnit_Global::newobj($pageName);
    }
                       
    //--------------------------------------------------------------------------

    function process()
    {
        $this->init();

        check_security();

        $page =& $this->_getPage();

        $this->initPage($page);

        if($page->isLoginPage())
        {
            if($GLOBALS['Auth']->isLogged())
            {
                // load menu again after succesful login
                loadMenu('./menu_left.php');
                
                // proces new page to display content, not login form
                $page =& $this->_getPage();

                $this->initPage($page);
            }
        }
        
        return parent::process();
    }
    
    //--------------------------------------------------------------------------

    function processNoSecurityCheck()
    {
        $this->init();

        $page =& $this->_getPage();

        $this->initPage($page);
        
        return parent::process();
    }

    //--------------------------------------------------------------------------

    function processWizard($fromPage, $to_call, $params)
    {
        $this->init();

        $page =& $this->_getPage();

        $page->init(); //???

        $page->setFromPage('SuperAdmins_Views_Accounts');
        $page->$to_call($params['AccountID'],$params['UserProfileID']);//$params['AccountID'], $this->createParams($params)

        $this->assign('content', $page->temp_content);
        $this->assign('leftMenu', $GLOBALS['leftMenu']);
        $this->assign('menu_left', $this->getTemplateName('menu_left'));
        $this->assign('my_message', $this->getTemplateName('errorMsg'));

        return parent::process();
    }
    
    //--------------------------------------------------------------------------

    function initPage($page)
    {
        $page->init();

        $page->user_type = $this->user_type;

        if($page->checkPermissions())
        {
            $page->process();
            
            $this->assign('content', $page->temp_content);
        }
        else
        {
            $this->assign('content', L_G_YOU_DONT_HAVE_RIGHTS);
        }

        $this->assign('leftMenu', $GLOBALS['leftMenu']);
        $this->assign('menu_left', $this->getTemplateName('menu_left'));
        $this->assign('menu_top', $this->getTemplateName('menu_top'));
        $this->assign('my_message', $this->getTemplateName('errorMsg'));
        $this->assign('okMessages', QUnit_Messager::getOkMessages());
        $this->assign('errorMessages', QUnit_Messager::getErrorMessages());
    }

    //--------------------------------------------------------------------------
    
    function createParams($params)
    {
        if(is_array($params))
        {
            $param_str = '';

            foreach($params as $k => $v)
            {
                $param_str .= $v.',';
            }
            
            $param_str = substr($param_str,0,-1);

            return $param_str;
        }
        else
            return '';
    }
    
    //--------------------------------------------------------------------------
    
    function setDefaultView($view)
    {
        $this->defaultView = $view;
    }

    //--------------------------------------------------------------------------
}
?>
