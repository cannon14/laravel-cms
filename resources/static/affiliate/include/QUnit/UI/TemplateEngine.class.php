<?
require_once(BASEDIR . "/Savant/Savant2.php");

class QUnit_UI_TemplateEngine extends Savant2
{
    function QUnit_UI_TemplateEngine() 
    {
        if(isset($GLOBALS['mainTemplatePath']))
            $path = $GLOBALS['mainTemplatePath'];
        else
            $path = BASEDIR;
            
        $opts = array(
            'template_path' => $path . $_SESSION[SESSION_PREFIX.'template']
        );

        parent::Savant2($opts);
    }
}

?>
