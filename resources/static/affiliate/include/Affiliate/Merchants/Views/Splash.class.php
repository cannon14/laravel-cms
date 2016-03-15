<?
//============================================================================
// Copyright (c) Cesar Gonzalez, rapidotech.com 2005
// All rights reserved
//
// For support contact support@rapidotech.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
class Affiliate_Merchants_Views_Splash extends QUnit_UI_TemplatePage
{
	function process()
    {
		$this->addContent('main_splash');
    }
}