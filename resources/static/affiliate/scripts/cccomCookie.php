<?php
/*
 * Click Success, L.P.
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Created on Feb 23, 2006
 *
 */
	 
	 $prewd = getcwd(); 
	 chdir(realpath(dirname(__FILE__))); 
	 require_once('../include/Affiliate/Scripts/Bl/CookieManager.class.php');
	 chdir($prewd); 
 
 // The TTL is constrained by the limitations of the php long data type.
 // I had to settle for 1/3 the avg US life expectancy (right around 26 years).
 DEFINE("US_AVG_LIFE_EXPECTANCY", (60*60*24*365*77.5));
  
 // Grab the IP address, sessionid, aid, and did from the session.
 // These should all initially be set upon hitting settings2.php.
 $ip = $_SERVER['REMOTE_ADDR'];
 $session = session_id();
 $aid = $_SESSION['aid'];
 $bid = $_SESSION['bid'];
 
 if(trim($ip) == "") $ip = "null";
 if(trim($session) == "") $session = "null";
 if(trim($aid) == "")$aid = "null";
 if(trim($bid) == "")$bid = "null";
 	 	
 function createCCID($cookieManager, $ip){
  	$cookieValue = $ip."_".date("YmdHis")."_".substr(md5($ip.date("YmdHis").rand()), 0, 8);
 	$cookieTTL = (US_AVG_LIFE_EXPECTANCY / 3);
 	$_SESSION['CCCID'] = $cookieValue;
 	$CCID = new Cookie("CCCID", $cookieValue, null, $cookieTTL);
 	$cookieManager->setCookie($CCID);
 }
 
 function createACTREF($cookieManager, $session, $aid, $bid){
 
 	$cookieValue = $session."_".$aid."_".$bid."_".date("YmdHi");
 	$cookieTTL = (US_AVG_LIFE_EXPECTANCY / 3);
 	$ACTREF = new Cookie("ACTREF", $cookieValue, "_");
 	
 	$cookieManager->setCookie($ACTREF);
 	
 	// Set CURREFF
 	$cookieValue = $aid;
 	$CURRREF = new Cookie("CURRREF", $cookieValue, null, $cookieTTL);
 	$cookieManager->setCookie($CURRREF);
 	
 	//THIRDREF becomes PREVREF
 	if($cookieManager->cookieExists("PREVREF")){
 		$PREVREF = $cookieManager->fetchCookie("PREVREF");
 		$cookieValue = $PREVREF->getValue();
 		$THIRDREF = new Cookie("THIRDREF", $cookieValue, null, $cookieTTL);
 		$cookieManager->setCookie($THIRDREF);
 	}
 	
 	// PREVREF becomes CURREF
 	if($cookieManager->cookieExists("CURRREF")){
 		$CURRREF = $cookieManager->fetchCookie("CURRREF");
 		$cookieValue = $CURRREF->getValue();
 		$PREVREF = new Cookie("PREVREF", $cookieValue, null, $cookieTTL);
 		$cookieManager->setCookie($PREVREF);
 	}
 }
 
 function saveSearch()
 {
 	return Affiliate_Scripts_Bl_ReferalParser::store($_SESSION['CCCID'], $_SESSION['referer']);
 }
 
 $cookieManager = new Affiliate_Scripts_Bl_CookieManager();
 // 4.0 Session Fix and Activity Tracking Functional Specifications 
 
 // 1. When a user first enters, or sequentially visits 
 // the CCCOM site they will check for a CCCID.
 // If one exist it moves on. IF it does not exist, it creates the 
 // CCCID cookie and sets it in the session and in a static cookie 
 // for an infinite time period.
 if(!$cookieManager->cookieExists("CCCID")){	
	createCCID($cookieManager, $ip);
	
 }
 
 // 2. Then a user is checked for an ACTREF cookie to see if there is 
 // an Active Reference for the visit.  If there is an ACTREF cookie it moves on.  
 // IF it does not exist, an ACTREF is set by using the current session ID, 
 // Affiliate ID, Banner ID, and the date (YYYYMMDDMMSS).  Then it will move the PREVREF 
 // to THIRDREF, the CURREF to the PREVREF, and the ACTREF to the CURREF.
 if(!$cookieManager->cookieExists("ACTREF")){
	
	//QCore_History::writeHistory(WLOG_ERROR, "Organic Search: ACTREF DNE: AID=" . $aid . " REFERER=".$_SESSION['referer'], __FILE__, __LINE__);
	// Save search data
 	if($aid == 1000 || $aid == 999 || $aid == ''){
 		$aid = saveSearch();
 		$_SESSION['aid'] = $aid;
 	}
 	
 	
 		
	createACTREF($cookieManager, $session, $aid, $bid);
 	

 	
 }else{
 	$ACTREF = $cookieManager->fetchCookie("ACTREF", "_");
 	$ACTREF_aid = $ACTREF->getValue(1);
 	
 	// 3. If the ACTREF is different from the current A_ID in the $REQUEST, then the 
 	// ACTREF is overwritten and then it will move the PREVREF to THIRDREF, the CURREF 
 	// to the PREVREF, and the ACTREF to the CURREF.
 	if($_GET['a_aid'] != ""){
 		createACTREF($cookieManager, $session, $_GET['a_aid'], $_GET['a_bid']);
 	}
 }
?>
