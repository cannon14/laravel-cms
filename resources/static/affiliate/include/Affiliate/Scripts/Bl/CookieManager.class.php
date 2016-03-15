<?php
//============================================================================
//
// Click Success, L.P.
// Patrick J. Mizer
// patrick@clicksuccess.com
// 
// CookieManager Class
//
// A small cookie abstraction class
//============================================================================

class Affiliate_Scripts_Bl_CookieManager {

    function Affiliate_Scripts_Bl_CookieManager() {
    	
    }
    
    function cookieExists($cookieName){
    	return isset($_COOKIE[$cookieName]);
    }
    
    function fetchCookie($cookieName, $delimiter = null){
    	if(!isset($_COOKIE[$cookieName]))
    		return null;
    	$cookieObject = new Cookie($cookieName, $_COOKIE[$cookieName], $delimiter);
    	
    	return $cookieObject;
    }
    
    function setCookie($cookieObject){
    	 if(!is_a($cookieObject,'Cookie')){
    	 	//echo "[DEBUG] Argument must be of type Cookie";
    	 	return false;	
    	 }
    	 $cookieObject->setCookie();
    	 return true;
    }
}

//============================================================================
//
// Click Success, L.P.
// Patrick J. Mizer
// patrick@clicksuccess.com
// 
// CreditCards.com SessionCookieManager Class
//
// This class facilitates in restoring CCCOM session data upon session time out.
// This class also prepares additional data to be inserted on each click regarding
// cookies.
//============================================================================

class SessionCookieManager{
	
	var $backupCookies = array(	"CURRREF",
								"PREVREF",
								"THIRDREF",
								);
								
	var $storeOnClick = array(  "CURRREF" => "",
								"PREVREF" => "",
								"THIRDREF" => "",
								"CCCID" => "",
								);
	

	public function getInceptionDate(){
		$cookieManager = new Affiliate_Scripts_Bl_CookieManager();
		if($cookieManager->cookieExists("CCCID")){
			$CCCID = $cookieManager->fetchCookie("CCCID", "_");
			$dateHash = $CCCID->getValue(1);
			$yyyy = substr($dateHash, 0, 4);
			$mm = substr($dateHash, 4, 2);
			$dd = substr($dateHash, 6, 2);
			$hh = substr($dateHash, 8, 2);
			$ii = substr($dateHash, 10, 2);
			$ss = substr($dateHash, 12, 2);
			//echo $yyyy ."<br>" . $mm . "<br>" . $dd . "<br>" . $hh . "<br>" . $mm . "<br>" . $ss;
			return ($yyyy."-".$mm."-".$dd." ".$hh.":".$ii.":".$ss);
		}
		return date("Y-m-d H:i:S");
	}
	
 	// 4.0 Session Fix and Activity Tracking Functional Specifications 
	//
	// 5. If at anytime the session expires or times out 
	// (does not exist) and an ACTREF exists, an attempt 
	// should be made to load the information of the SESSION_ID 
	// found on disk that the ACTREF's SESSION_ID refers to.
	
	function validateSessionData(){
		$cookieManager = new Affiliate_Scripts_Bl_CookieManager();
		QCore_History::writeHistory(WLOG_DEBUG, "ENTERING VALIDATE SESSIONS", __FILE__, __LINE__);
		if($cookieManager->cookieExists("ACTREF")){
			QCore_History::writeHistory(WLOG_DEBUG, "ACTREF EXISTS", __FILE__, __LINE__);
			$ACTREF = $cookieManager->fetchCookie("ACTREF", "_");
			$sessionId = $ACTREF->getValue(0);
			$affiliateId = $ACTREF->getValue(1); 
			
			$bannerId = $ACTREF->getValue(2); 
			$dateHash = $ACTREF->getValue(3);
			// First thing we check is to see whether or not 
			// session has timed out.  If it hasn't our work is done.
			if(trim($_SESSION['aid']) == trim($affiliateId)){
				QCore_History::writeHistory(WLOG_DEBUG, "SESSION IS STILL VALID", __FILE__, __LINE__);
				
				// session is still in tact, we're done.
				return true;	
			}
			
			// Next we try to revive the session from cache
			/**
			QCore_History::writeHistory(WLOG_DEBUG, "ATTEMPTING TO REVIVE SESSION", __FILE__, __LINE__);
						
			$sessionId = ereg_replace("[^A-Za-z0-9]","", $sessionId);
			@session_id($sessionId);
			if($_SESSION['aid'] != ""){
				QCore_History::writeHistory(WLOG_DEBUG, "Successfully Recovered Session data from cache.", __FILE__, __LINE__);
				return true;	
			}
			**/
			
			/**
			// If we're here we know that the session has timed out
			// and that the session cache has been destroyed.
			//
			// We must now attempt to recover the session data.
			// Best case: If the ACTREF cookie exists then we can
			// grab its data and reset the session.

			//assuming the affiliateid actually exists, we can restore the session. 
			/**
			if($affiliateId != ""){
					
					
					QCore_History::writeHistory(WLOG_DEBUG, "USING ACTREFS AFFILIATEID", __FILE__, __LINE__);
					
					$_SESSION['aid'] = $affiliateId;
					$_SESSION['did'] = $bannerId;
					
					// Now that we've artificially restord the session
					// we need to modify the ACTREF cookie to point to
					// this new session.
					$newSessionId = session_id();
					$ACTREF->setValue($newSessionId, 0);
					$cookieManager->setCookie($ACTREF);
				
					return true;
					
			}		
			**/		
			
		}
		return false; 
			

		/**
		QCore_History::writeHistory(WLOG_DEBUG, "ACTREF NOT FOUND", __FILE__, __LINE__);
		
		// If the ACTREF cookies does not exist, or we couldn't
		// get any meaningful data from it then we will try the 
		// currref cookie to see if we can find a suitable 
		// aid at least.
		if($cookieManager->cookieExists("CURRREF")){
			QCore_History::writeHistory(WLOG_DEBUG, "ATTEMPTING TO GRAB INFO FROM CURRREF", __FILE__, __LINE__);
			
			$BACKUP = $cookieManager->fetchCookie("CURRREF", "_");
			$affiliateId = $BACKUP->getValue();
			if(trim($affiliateId) != null){
				QCore_History::writeHistory(WLOG_DEBUG, "DATA RESTORED FROM CURREF", __FILE__, __LINE__);
				
				$_SESSION['aid'] = $affiliateId;
				return true;	
			}
		}		
		QCore_History::writeHistory(WLOG_DEBUG, "SESSION COULD NOT BE RESTORED", __FILE__, __LINE__);
		
		// If we're here that means we've exhausted all means of recovering 
		// our session data via cookies.
		//
		// This will also handle the case where a user has cookies and disabled and their
		// session is still valid.
		 **/
	}
	
	// 4.0 Session Fix and Activity Tracking Functional Specifications 
	//
	// 4.  On any offer click, the system must record the current 
	// CURREF, the PREVREF, THIRDREF and the CCCID as part of the transaction.
	
	function prepareClickData(){
		
		$cookieManager = new Affiliate_Scripts_Bl_CookieManager();
		// Iterate through each of the cookies whose data we need stored.
		// If they exist their value is stored in the array.
		// the client code can at this data by accessing the getClickData
		// method and supplying the cookie name.
		foreach($this->storeOnClick as $cookie => $data){
			if($cookieManager->cookieExists($cookie)){
				$currentCookie = $cookieManager->fetchCookie($cookie);
				$this->storeOnClick[$cookie] = $currentCookie->getValue(0);
			}	
		}
	}
	
	function getClickData($cookie){
		return $this->storeOnClick[$cookie];
	}
}

//============================================================================
//
// Click Success, L.P.
// Patrick J. Mizer
// patrick@clicksuccess.com
// 
// Cookie Model Class
//
// This is a cookie model class.  The class basically follows PHP's built in 
// cookie handling.  The biggest difference is that this class allows you to 
// to get at delimited data via random access. 
//============================================================================

class Cookie {
	var $name;
	var $value;
	var $ttl;
	var $path;
	var $domain;
	
	var $valueArray;
	var $delimiter;
	
	function Cookie($name, $value = null, $delimiter = null, $ttl = null, $path = null, $domain = null){
		$this->name = $name;
		$this->value = $value;
		$this->delimiter = $delimiter;
		$this->ttl = $ttl;
		$this->path = $path;
		$this->domain = $domain;
		
		if($this->delimiter != ""){
			$this->valueArray = explode($this->delimiter, $this->value);
		}else {
			$this->valueArray[0] = $this->value;
		}
	}
	
	function setCookie(){
		$time = time()+$this->ttl;
		if($this->ttl == "")
			$time = null;
		setcookie($this->name, $this->value, $time, '/', '.creditcards.com');
	}
	
	function getValue($i = null){
		if($i === null)
			$ret = $this->value;
		else
			$ret = $this->valueArray[$i];
			
		return $ret;
	}
	
	function setValue($value, $i = null){
		if($i == null){
			$this->value = $value;
			$this->valueArray[0] = $value;
			return;	
		}
		$this->valueArray[$i] = $value;
		$this->value = implode($this->delimiter, $this->valueArray);
		return;
	}
}