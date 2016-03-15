<?
/**
*   License computation class
*   code has format: 8 characters validFrom, 8 characters validTo, rest is productId
*   all is formated in hexadecimal numbers
*
*   @author Viktor Zeman
*   @copyright Copyright @ 2005 Quality Unit, Viktor Zeman
*   @package qcore
*   @since Version 1.0
*   $Id: Gate.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/
class QCore_Gate {

    //------------------------------------------------------------------------

    function currentVersion() {
        return '01';
    }

    //------------------------------------------------------------------------

    function testGate() {
        return '0086c12433833a144902f69d2d08bd30';
    }

    //------------------------------------------------------------------------

    function checkLicense() {
        if (!strlen(APPLICATION_LICENSE)) {
            return false;
        }

        $ret = QCore_Gate::decodeLicense(APPLICATION_LICENSE, QCore_Gate::getDomain());
        
        // add two days tolerance (for different time zone or incorreclty set server date)
        $validFrom = time() + 172800;
        $validTo = time() - 172800;

        $currentProductID = substr(QCore_Gate::transformProductID(CUSTPRODUCT_ID), 0, 6);
        $licenseProductID = substr($ret['custProduktId'], 0, 6);

        return strtotime($ret['validFrom']) < $validFrom && 
        strtotime($ret['validTo']) > $validTo && 
        $currentProductID == $licenseProductID;
    }

    //------------------------------------------------------------------------

    function generateKey($domain, $length = 32) {
        $key = md5(strtolower($domain));
        while (strlen($key) < $length) {
            $key .= md5($key);
        }
        return substr($key, 0, $length);
    }

    //------------------------------------------------------------------------

    function getDomain() {
        $host = $_SERVER['HTTP_HOST'];
        if($host == '') $host = getenv('HTTP_HOST');
        
        $host = parseDomain($host);
        
        if (strlen(strtolower($host))) {
            return strtolower($host);
        } else {
            return 'commandline';
        }
    }

    //------------------------------------------------------------------------
    
    function fnxor($key, $string) {
	    $res = '';
        for($i = 0; $i < (strlen($string) / 4); $i++) {
            $res .= str_pad(base_convert((int)(base_convert(substr($key, $i*4, 4), 16, 10)) ^ 
            (int)(base_convert(substr($string, $i*4, 4), 16, 10)), 10, 16), 4, '0', STR_PAD_LEFT);                        
        }
        return $res;
    }

    //------------------------------------------------------------------------

    function encodeDate($date) {
        return base_convert(strtotime($date), 10, 16);
    }

    //------------------------------------------------------------------------
    
    function decodeDate($date) {
        return date('Y-m-d H:i:s', base_convert($date, 16, 10));
    }

    //------------------------------------------------------------------------

    function transformProductID($productId) {
        $productId .= str_repeat('0', strlen($productId) - (((int)(strlen($productId)/4)) * 4));
        return $productId;
    }

    //------------------------------------------------------------------------
    
    //productId has to be hexadecimal string
    function encodeLicense($validFrom, $validTo, $domain, $productId) {
        if (CUSTPRODUCT_ID == $productId) {
            die("Can't generate license for this product id: " . CUSTPRODUCT_ID);
        }
        
        if (!strlen(trim($validFrom))) {
            $validFrom = date('Y-m-d H:i:s');
        }
        
        if (!strlen(trim($validTo))) {
            $validTo = '2037-12-31 12:00:00';
        }
        
        $str = QCore_Gate::currentVersion() . 
        QCore_Gate::encodeDate($validFrom) . 
        QCore_Gate::encodeDate($validTo) . 
        QCore_Gate::transformProductID($productId);
        
        return QCore_Gate::fnxor(QCore_Gate::generateKey($domain, strlen($str)), $str); 
    }

    //------------------------------------------------------------------------
    
    function decodeLicense($license, $domain) {
        $ret = array();
        $strRet = QCore_Gate::fnxor(QCore_Gate::generateKey($domain, strlen($license)), $license);
        
        $ret['licenseVersion'] = substr($strRet, 0, 2);
        
        switch ($ret['licenseVersion']) {
            case '01':
                $ret['validFrom'] = QCore_Gate::decodeDate(substr($strRet, 2, 8));
                $ret['validTo'] = QCore_Gate::decodeDate(substr($strRet, 10, 8));
                $ret['custProduktId'] = substr($strRet, 18);
                break;
            default:
                break;
        }
        
        return $ret;
    }
}
?>
