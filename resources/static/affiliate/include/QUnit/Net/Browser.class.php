<?php

class QUnit_Net_Browser {
    var $url;
    var $curl = null;
    var $userAgent = 'Mozilla/5.0 (Windows XP; U) Opera 6.01 [en]';
    var $cookieFile = 'mcookies.txt'; // toto vytvori subor niekde v adresari apache
    var $errorMsg = '';
    var $errorNumber = 0;
    var $referer = '';
    var $last_page_info;
    var $getHeaders = false;
    var $sendHeaders = array();
    
    //------------------------------------------------------------------------

    function QUnit_Net_Browser() {
    }
    
    //------------------------------------------------------------------------

    function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;

        if($this->curl != null)
            curl_setopt($this->curl, CURLOPT_USERAGENT, $userAgent);
    }

    function setGetHeaders($value) {
        $this->getHeaders = $value;
    }
    
    //------------------------------------------------------------------------

    
    function setCookieFileName($filename) {
        $this->cookieFile = $filename;
        return true;
    }
    
    
    function setCookieFile($cookieFile) {
        $this->cookieFile = $cookieFile;

        if($this->curl != null) {
            curl_setopt($this->curl, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($this->curl, CURLOPT_COOKIEFILE, $cookieFile);               
        }
    }
    
    
    function addHeader($strHeader) {
        if (strlen($strHeader)) {
            $this->sendHeaders[] = $strHeader;
        }
        return true;
    }

    function setHeaders() {
        if (!empty($this->sendHeaders)) {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->sendHeaders);
        }
    }
    
    //------------------------------------------------------------------------

    function setReferer($referer) {
        $this->referer = $referer;

        if($this->curl != null && strlen($this->referer)) {
            curl_setopt($this->curl, CURLOPT_REFERER, $this->referer);
        }
    }
    
    //------------------------------------------------------------------------

    function setCookie($cookie) {
    	if($this->curl != null) {
    		curl_setopt($this->curl, CURLOPT_COOKIE, $cookie);
    	}
    }
    
    //------------------------------------------------------------------------

    function setPost($fields) {
    	if($this->curl != null) {
    		if($fields != '') {
	    		curl_setopt($this->curl, CURLOPT_POST, 1);
    			$postfields = '';
    			if(is_array($fields)) {
    				foreach($fields as $key => $value)
    				$postfields .= ($postfields == '' ? '' : '&').$key.'='.urlencode($value);
    			} else {
    				$postfields = $fields;
    			}
    			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postfields);
    		}
    	}
    }
    
    //------------------------------------------------------------------------

    function init() {
        $this->curl = curl_init();
        
        if($this->userAgent != '')
            curl_setopt($this->curl, CURLOPT_USERAGENT, $this->userAgent);
            
        if($this->cookieFile) {
            curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookieFile);
            curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookieFile);               
        }
        if(strlen($this->referer)) {
            curl_setopt($this->curl, CURLOPT_REFERER, $this->referer);
        }
    }
    
    //------------------------------------------------------------------------
    
    function setUrl($url) {
        $this->url = str_replace(' ', '%20', $url);
    }
    
    //------------------------------------------------------------------------

    function getPage() {
        if($this->curl == null)
            die('Class was not initialized.');
            
        $this->setHeaders();
        if ($this->getHeaders) {
            curl_setopt($this->curl, CURLOPT_HEADER, 1);
        }
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        if (strpos($this->url, 'https://') !== false) {
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        }
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_VERBOSE, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
        $resultHtml = curl_exec($this->curl); 

        $this->last_page_info = curl_getinfo($this->curl);
        $errorNumber = curl_errno($this->curl);
        if($resultHtml == '' || $errorNumber != 0)
        {
            $this->errorMsg = 'CURL error: '.curl_error($this->curl);
            $this->errorNumber = $errorNumber;
            return false;
        }
        else
            return $resultHtml;
    }
    
    //------------------------------------------------------------------------
    
    function close()
    {
        $this->curl = curl_close($this->curl);
    }
}


?>
