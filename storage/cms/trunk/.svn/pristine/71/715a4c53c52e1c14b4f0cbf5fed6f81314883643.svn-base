<?
/**
 * 
 * CreditCards.com
 * Jul 2, 2009
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_View
 */ 

csCore_Import::importClass('csCore_UI_page');
csCore_Import::importClass('CMS_libs_Previewer');

class CMS_view_preview extends csCore_UI_page
{
    private $param;
    private $siteId;
    private $pageId;
    private $struct;

	/**
	 * Parses incoming variables and exectues proper methods
	 * @author Patrick Mizer
	 * @version 1.0
	 */
    public function process(){
        if($_REQUEST['elChapo'] != ''){
            $struct = json_decode( stripslashes($_REQUEST['elChapo']), true );

            $siteId = $struct['siteId'];
            unset($struct['siteId']);

            $pageId = $struct['pageId'];
            unset($struct['pageId']);

            $previewer = new CMS_libs_Previewer($siteId);
            $previewer->compilePage($pageId);
            $previewer->compileSubPages($struct);
            $previewer->compileCards($struct);
            $previewer->compileSite();

            print $previewer->preview();
            //print '<pre>';print_r($previewer->getSite()); print'</pre>';
        }else{
            print 'JSON object required!';
        }
    }
}
?>
