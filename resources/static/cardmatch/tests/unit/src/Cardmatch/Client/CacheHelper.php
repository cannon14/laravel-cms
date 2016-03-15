<?php

/**
 * Test helper for Cache tests
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_CacheHelper extends Cardmatch_Client_Cache {

	protected function _setCookie($cookieName, $cookieValue, $ttl, $cookiePath, $cookieDomain) {
		$_COOKIE[$cookieName] = $cookieValue;
	}

}
