<?
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_UI_ResourcesPage extends QUnit_UI_TemplatePage
{
    //------------------------------------------------------------------------

    function findPage($page)
    {
        $completePath = './resources/'.$_SESSION[SESSION_PREFIX.'lang'].'/'.$page.'.html';
        
        if(file_exists($completePath))
        {
            // load its contents
            ob_start();
    
            // include the requested template filename in the local scope
            // (this will execute the view logic).
            include($completePath);
    
            $contents = ob_get_contents();
            ob_end_clean();
            
            return $contents;
        }
        else 
            return false;
    }
}
?>
