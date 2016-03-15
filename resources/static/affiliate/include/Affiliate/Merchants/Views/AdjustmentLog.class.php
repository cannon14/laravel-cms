<?php

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ChangeLog');
class Affiliate_Merchants_Views_AdjustmentLog extends QUnit_UI_TemplatePage
{
	function process()
    {
    	$log = new Affiliate_Merchants_Bl_ChangeLog(null, null);
    	$_POST['log'] = $log->print_log();
		$this->addContent('adjustment_log');
    }
}
?>