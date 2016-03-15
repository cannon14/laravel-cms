<?
//============================================================================
// Christian Lavender
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');


class Affiliate_Merchants_Views_SearchManager extends QUnit_UI_TemplatePage
{

    //--------------------------------------------------------------------------    

    function initPermissions()
    {

    }

    //--------------------------------------------------------------------------

    function process()
    {
       $this->drawHelp();      
    }
	
	// --------------------------------------------------------------------------
	
	function drawHelp(){
		$this->addContent('search_admin');
	}
}
?>
