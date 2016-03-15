<?php

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
class Affiliate_Merchants_Views_ParserLogs extends QUnit_UI_TemplatePage
{
	function process()
    {
		$this->addContent('parser_logs');
    }
}
?>