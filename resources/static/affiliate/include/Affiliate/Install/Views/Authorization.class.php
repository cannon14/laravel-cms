<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Authorization extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_Authorization() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();    
    }
    
    function getName() {
        return 'Authorization';
    }    
    
    function getContent() {        
        return $this->fetch('authorization');        
    }
    
    function process() { 
        if(isset($_POST['submit'])) {
            if($this->authorize() !== false) {
                return true;
            }            
        }
        return false;
    }  
    
    function authorize() {
        if($_POST['auth_code'] == "") {
            QUnit_Messager::setErrorMessage(L_G_AUTHCODENOTINSERTED);
            return false;
        }
        $domain = parseDomain(strtolower($_SERVER['HTTP_HOST']));

        $code = $_POST['auth_code'];
        $host = 'www.qualityunit.com';
        $path = "/members/check.php";
        if($domain === false) {
            QUnit_Messager::setErrorMessage(L_G_AUTHBADHOST);
            return false;
        }

        $req = "c=".urlencode($code)."&d=".urlencode($domain);

        $header .= "POST $path HTTP/1.0\r\n";
        $header .= "Host: $host\r\n";        
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        $fp = fsockopen($host, 80, $errno, $errstr, 30);
        if (!$fp) {
            QUnit_Messager::setErrorMessage(L_G_AUTHCONNECTIONFAILED);
            return false;
        }
        fwrite($fp, $header.$req);
        $answer = $this->getPageContents($fp);
        fclose($fp);
        //echo "ANSWER>>>".$answer."<<<ANSWER";           
        if(strstr($answer, 'FAILED')) {
            QUnit_Messager::setErrorMessage(L_G_AUTHWRONGCODE);
            return false;
        }
        $_SESSION[SESSION_PREFIX.'auth_id'] = $code;
        $_SESSION[SESSION_PREFIX.'auth_license'] = $answer; 
        return true;
    }
    
    function getPageContents(&$fp) {
         if(!preg_match('/^HTTP\/[0-9]\.[0-9]\s200 OK$/', trim(fgets($fp, 1024)))) {
             return false;
         }
         while(preg_match('/^[-a-zA-z]+:.+$/', trim(fgets($fp, 1024)))) {             
         }
         
         return trim(fgets($fp, 1024));
    }
    
}
?>