<?php


class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testRedirection(AcceptanceTester $I)
    {
		$I->wantTo('Ensure that Redirection to login page works');
		$I->amOnPage('/admin/users');
		$I->see('Login');
	}

	public function testLogin(AcceptanceTester $I) {

		$I->wantTo('Log in');
		$I->amOnPage('/admin/auth/login');
		$I->fillField('#username', 'admin');
		$I->fillField('password', 'admin');
		$I->click('login');

		$I->wantTo('Ensure that successful login is sent to dashboard');
		$I->amOnPage('/admin/dashboard');
		$I->see('Dashboard');
	}

	public function testLogout(AcceptanceTester $I) {

		$I->wantTo('Log out');
		$I->amOnPage('/admin/auth/logout');
		$I->see('Login');
	}

	public function testInvalidLoginCredentials(AcceptanceTester $I) {
		$I->wantTo('Log in with invalid credentials');
		$I->amOnPage('/admin/auth/login');
		$I->fillField('#username', 'wrong');
		$I->fillField('password', 'wrong');

		$I->click('login');
	}
}
