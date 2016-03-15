<?php


class CardsCest
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
		$I->wantTo('Ensure that Cards index works');
		$I->amOnPage('/admin/cards');
		$I->see('Cards');
	}
}
