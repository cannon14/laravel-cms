<?
/**
 * CreditCards.com
 * Jason Huie
 * 
 * Created: 8/13/2007
 */
 
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_ReportHandler extends QUnit_UI_TemplatePage
{
    function process(){
        $settings = $GLOBALS['Auth']->getSettings();
        $report = $settings['reporting_url'].'/'.$_REQUEST['report'].'.php';
        $this->assign('report', $report);
        $this->addContent('report_handler');
    }
}