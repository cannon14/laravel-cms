<?php
/**
 * GeoIP redirection script.
 * 
 * This script leverges the GeoIP PHP Extension
 * to redirect users based on their location. 
 */

/* GEOIP IS TURNED ON! */
// return;

// Only run this script if the geoip PECL extension is loaded and registered.
if(extension_loaded('geoip') && !isset($_SESSION['geo_override']) && !isset($_COOKIE['ccOverrideGeoIP']))
{
	// Turn this on if you want to debug the script.
	// ***But look at the _debug() function before you turn this on***
	// ...becasue if _debug is writing to standard out the redirect won't work. 
	define('DEBUG', false);
	
	// Turns the header redirect on or off.
	define('REDIRECT', true);
	
	function _getCountryCode()
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$ipParts = explode(',', $ip);
	    $finalIp = (count($ipParts) > 1 ? $ipParts[0] : $ip);
	    
	    if($finalIp == null) {
	    	$finalIp = $_SERVER['REMOTE_ADDR'];
	    }
	    
	    return geoip_country_code_by_name($finalIp);
	}
	
	function _geoRedirect($redirectUrl, $mapping = array())
	{
		if(REDIRECT)
				header('Location: ' . $redirectUrl);
	}		
	
	function _geoRedirectUk()
	{
		$redirectUrl  = 'http://uk.creditcards.com/';
		$redirectMap = array(
			'/bad-credit.php' 			=> 'http://uk.creditcards.com/poor-credit.php',
			'/prepaid.php' 				=> 'http://uk.creditcards.com',
			'/specials.php' 			=> 'http://uk.creditcards.com/low-interest.php',
			'/instant-approval.php' 	=> 'http://uk.creditcards.com',
			'/balance-transfer.php' 	=> 'http://uk.creditcards.com',
			'/low-interest.php' 		=> 'http://uk.creditcards.com/low-interest.php',
			'/airline-miles.php' 		=> 'http://uk.creditcards.com/travel.php',
			'/Chase.php'	 			=> 'http://uk.creditcards.com',
			'/college-students.php' 	=> 'http://uk.creditcards.com/prepaid.php',
			'/Visa.php' 				=> 'http://uk.creditcards.com/visa.php',
			'/Capital-One.php' 			=> 'http://uk.creditcards.com/capital-one.php',
			'/business.php' 			=> 'http://uk.creditcards.com/business.php',
			'/reward.php' 				=> 'http://uk.creditcards.com/reward.php',
			'/Citi.php' 				=> 'http://uk.creditcards.com',
			'/American-Express.php' 	=> 'http://uk.creditcards.com/american-express.php',
			'/cash-back.php' 			=> 'http://uk.creditcards.com/cash-back.php',
			'/Discover.php' 			=> 'http://uk.creditcards.com',
			'/credit_cards_faq.php' 	=> 'http://uk.creditcards.com/credit-card-news/credit-card-stories.php',
			'/Bank-of-America.php' 		=> 'http://uk.creditcards.com',
			'/fair-credit.php' 			=> 'http://uk.creditcards.com',
			'/excellent-credit.php' 	=> 'http://uk.creditcards.com',
			'/good-credit.php' 			=> 'http://uk.creditcards.com',
			'/HSBC-Bank.php' 			=> 'http://uk.creditcards.com/hsbc.php',
			'/Mastercard.php' 			=> 'http://uk.creditcards.com/mastercard.php',
			'/credit-card-articles.php' => 'http://uk.creditcards.com/credit-card-news/credit-card-stories.php'	
		);	
		
		_geoRedirect($redirectUrl, $redirectMap);
	}
	
	function _geoRedirectCa()
	{
		$redirectUrl  = 'http://canada.creditcards.com';
		
		_geoRedirect($redirectUrl);
	}
	
	function _geoRedirectAu()
	{
		$redirectUrl  = 'http://australia.creditcards.com';
		
		_geoRedirect($redirectUrl);
	}
	
	
	
	if($_REQUEST['geotest']) {
		/* Back door test */
		switch(strtolower($_REQUEST['geotest'])) {
			case 'uk':
			case 'gb':
				_geoRedirectUk();
				break;
			case 'ca':
				_geoRedirectCa();
				break;
			case 'au':
				_geoRedirectAu();
				break;
            case 'us':
                $_SESSION['geo_override'] = true;
                break;
		}
		
	} else {
	
		/* Test geo locations and redirect */
		switch(_getCountryCode()) {
			case 'UK':
			case 'GB':
				_geoRedirectUk();
				break;
			case 'CA':
				_geoRedirectCa();
				break;
			case 'AU':
				_geoRedirectAu();
				break;
			
		}	
	}	

}else{
	_debug('Geoip extension not installed.');
}


function _debug($str)
{
	// Simple debug method.  
	// if(DEBUG)
	//	DebugMsg('GEOIP: ' . $str, __FILE__, __LINE__);
	
}
?>