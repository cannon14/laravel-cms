<?php

//global connection file
require_once('global.php');

session_start();

//Set the friendly cookie so that a some of the compliance checks do not get done on trans-node.
//This cookie assumes anypage that needs this cookie will be a sub-domain of creditcards.com.
setcookie('ccfriendly','1',0,'/','.creditcards.com');

//post click card history
$historyExceptions = array(
	"22215012",
	"22215013",
	"22215009"
);

if( !in_array($a_bid, $historyExceptions) ) {

	$historyCookie = $_COOKIE['cardOfferHistory'];
	if (empty($historyCookie)) {
		$historyCookie = $a_bid;
	} else {
		$historyCookie = $a_bid . "," . $historyCookie;
		//limit cookie length to 20 cards (180 characters)
		$historyCookie = substr( $historyCookie, 0, 180 );
	}
	setcookie('cardOfferHistory', $historyCookie, time()+60*60*24*30, '/' );
}

//require_once( dirname( __FILE__ ).'/cardmatch/src/User.class.php' );

if(isset($_GET['pid'])) {

	$badCharsExpression = '/[\'\"\@\%\;]/';
	$replacementChars = '';
	$a_bid                  =  preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['pid']));
	$_SESSION['fid']        =  preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['pg']));
	$_SESSION['page_pos']   =  preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['pgpos']));
	$directTransfer         =  preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['tfr']));

} else {

	$all = $_SERVER['QUERY_STRING'];
	list ($a_bid, $directTransfer) = split ('-', $all);

}

//Check for referrer and see if its creditcards.com
$referrer = $_SERVER['HTTP_REFERER'];
$ccPattern = "/creditcards.com/";
$fromCCCOM = (preg_match($ccPattern,$referrer) > 0 ? TRUE : FALSE);

//Set the cookie.
setcookie('ccppr',' ',0,'/','.creditcards.com');

if($fromCCCOM){
	//Do the first Encryption.  Obscure the product id.
	$cookieContents = "Ajz53K2ZG" . md5($a_bid) . "7gWAJBaqDt";
	//Now encrypt the entire contents.
	$ccproperHash = md5($cookieContents);
	
	//No do it 20 more times to prevent decryption.
	for ($i = 0; $i <= 10; $i++){
		$ccproperHash = md5($ccproperHash.$ccproperHash);
	}
	
	//Set the cookie.
	setcookie('ccppr',$ccproperHash,0,'/','.creditcards.com');
}

/*
 * Add check for mobile site ID override (sido) param. If it doesn't exist,
 * send CCCOMUS main site ID.
 */
if(isset($_GET['sido'])) {
	$_SESSION['sid'] = $_GET['sido'];
} else {
	$_SESSION['sid'] = CCCOMUS_MAIN_SID;
}

//if redirected from mobile site, oid (offer id) will be present
// The session variable being set will be checked by ClickRegistrator later
if(isset($_GET['oid'])) {
	//came from mobile site
	$_SESSION['oid'] = $_GET['oid'];
} else {
	//we still want variable present, just not set
	$_SESSION['oid'] = null;
}


// data3 is 1 if matched via cardmatch
if ($_REQUEST['data3'] == 1) { $_SESSION['data3'] = 1; } else { $_SESSION['data3'] = 0; }

QUnit_Global::includeClass('Affiliate_Scripts_Bl_CookieManager');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Chameleon');
QUnit_Global::includeClass('QCore_Settings');


$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

$_SESSION['bid'] = $a_bid;

$settings = QCore_Settings::_getSettings(3);

if($settings['Aff_csCookie'] == 1){

		// [Begin Session Fix and Activity Tracking]
		// Here we will check to make sure Session is valid, if not
		// we will try to reload them from cookies.
		$scManager = new SessionCookieManager();

		if(!$scManager->validateSessionData()){
				if ($_SESSION['aid'] == '' && $_SESSION['bid'] == '') {  
					$vCookie = $a_aid = 1099;
						$_SESSION['aid'] = $a_aid;
				}

				if ($_SESSION['aid'] == '' && $_SESSION['bid'] != '') {   
					$vCookie = $a_aid = 998;
						$_SESSION['aid'] = $a_aid;
				}
				include_once('affiliate/scripts/cccomCookie.php');
		}

		// Next we set additional tracking data
		$scManager->prepareClickData();
		// ... and pass them along to registrator so that ClickRegistrator has access.

		if($vCookie != null){

				if(($ccid = $scManager->getClickData("CCCID")) == null) {
						$ccid = $_SESSION['CCCID'];
		}

				$clickReg->setCookieData(
														$vCookie, 
														$scManager->getClickData("CURRREF"), 
														$scManager->getClickData("PREVREF"),
														$ccid,
														$scManager->getInceptionDate()
														);
		}else{
				$clickReg->setCookieData(
														$scManager->getClickData("CURRREF"), 
														$scManager->getClickData("PREVREF"), 
														$scManager->getClickData("THIRDREF"),
														$scManager->getClickData("CCCID"),
														$scManager->getInceptionDate()
														);
		}
		// [End Session Fix and Activity Tracking]
}

				
if ($_SESSION['aid'] == '' && $_SESSION['bid'] == '') {
	$a_aid = 1099;
		$_SESSION['aid'] = $a_aid;
}

if ($_SESSION['aid'] == '' && $_SESSION['bid'] != '') {
	$a_aid = 998;
		$_SESSION['aid'] = $a_aid;
}
				 
// This code is to handle if any of the vars are not set 
//         *** SHOULD BE REVIEWED ***
if ($_SESSION['cid'] == '') {
	  $_SESSION['cid'] = '9999';
}
if ($_SESSION['eid'] == '') {
	  $_SESSION['eid'] = '99';
}
if ($_SESSION['did'] == '') {
	  $_SESSION['did'] = '9999';
}
if ($_SESSION['fid'] == '') {
	  $_SESSION['fid'] = '98';
}

// check if it has correct parameters
if (!isset($_SESSION['aid']) || $_SESSION['aid'] == '') {
	$errorMsg = "Click registration: Missing Affiliate ID when calling click registration";
	LogError($errorMsg, __FILE__, __LINE__);
	return;
}

$affiliateID = preg_replace('/[\'\"]/', '', $_SESSION['aid']);
$bannerID = preg_replace('/[\'\"]/', '', $_SESSION['bid']);
$data1 = preg_replace('/[\'\"]/', '', $_SESSION['tid']);
$data2 = preg_replace('/[\'\"]/', '', $_REQUEST['data2']);
$data3 = preg_replace('/[\'\"]/', '', $_REQUEST['data3']);

$clickReg->setExtraData($data1, $data2, $data3);


// check if this affiliate and campaign exist

if(!$clickReg->checkUserExists($affiliateID)) {
	$errorMsg = "Click registration: Affiliate with ID: $affiliateID doesn't exist";
	LogError($errorMsg, __FILE__, __LINE__);
	require_once('invalid-card-level.php');
}

/*
if(!$clickReg->checkBannerExists($bannerID, true))
{
  $errorMsg = "Click registration: Banner with ID: $bannerID doesn't exist and cannot find any campaign for affiliate with ID: $affiliateID";
  LogError($errorMsg, __FILE__, __LINE__);
  require_once('invalid-banner-level.php');
}

if(!$clickReg->checkCampaignExists())
{
  $errorMsg = "Click registration: Campaign with ID: ".$clickReg->campaignID." doesn't exist";
  LogError($errorMsg, __FILE__, __LINE__);
 require_once('invalid-campaign-level.php');
}

if(!$clickReg->checkUserInCampaign())
{
  $errorMsg = "Click registration: Affiliate ID: $affiliateID doesn't belong to the campaign ID: ".$clickReg->campaignID;
  LogError($errorMsg, __FILE__, __LINE__);
  require_once('invalid-campaign-cat-level.php');
}
*/



//CHAMELEON CODE----------------------------------------------------------------------------------------
if(isset($_COOKIE['chameleon'])){
		$chameleon = new Affiliate_Scripts_Bl_Chameleon($_COOKIE['chameleon']);
		$chameleon->setCard($a_bid);
		$chameleon->setExitPage($_SESSION['fid']);
		$chameleon->setDate(date('Y-m-d H:i:s'));


		$chameleon->sendCookie();
		$chameleon->saveCookie();
}
//END CHAMELEON CODE------------------------------------------------------------------------------------

// this script should:
//  1. set cookie
//  2. save transaction to the DB
//  3. redirect to destination page

// setting cookie
$clickReg->setCookie();

/* New redirect code */
#$clickReg->redirect();
$clickReg->redirect('', $directTransfer);
?>