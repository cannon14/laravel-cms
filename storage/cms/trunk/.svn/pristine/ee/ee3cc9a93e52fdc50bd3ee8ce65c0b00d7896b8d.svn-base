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

class csCore_Cookie_CookieManager {

    function csCore_Cookie_CookieManager() {
    	
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
// Cookie Model Class
//
// This is a cookie model class.  The class basically follows PHP's built in 
// cookie handling.  The biggest difference is that this class allows you to 
// to get at delimited data via random access. 
//============================================================================

class csCore_Cookie_Cookie {
	var $name;
	var $value;
	var $ttl;
	var $path;
	var $domain;
	
	var $valueArray;
	var $delimiter;
	
	function csCore_Cookie_Cookie($name, $value = null, $delimiter = null, $ttl = null, $path = null, $domain = null){
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
		setcookie($this->name, $this->value, $time, $this->path, $this->domain);
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
?>