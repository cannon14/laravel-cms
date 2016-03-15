<?php


class DashboardCest
{
    public function _before(AcceptanceTester $I)
    {
		$I->wantTo('Log in');
		$I->amOnPage('/admin/auth/login');
		$I->fillField('#username', 'admin');
		$I->fillField('password', 'admin');
		$I->click('login');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testIndex(AcceptanceTester $I)
    {
		$I->wantTo('Ensure that Dashboard works');
		$I->amOnPage('/admin');
		$I->see('Dashboard');
    }
}
