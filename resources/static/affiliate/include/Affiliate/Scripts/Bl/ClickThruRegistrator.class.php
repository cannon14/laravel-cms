<?php

QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
class Affiliate_Scripts_Bl_ClickThruRegistrator extends Affiliate_Scripts_Bl_ClickRegistrator 
{
	function redirect($destUrl = '')
    {
        // if no POST variables are set, then only redirect
        if(count($_POST) == 0 || !extension_loaded('curl'))
        {
            if($this->settings['Aff_permanent_redirect'] == 1) {
                header("HTTP/1.1 301 Moved Permanently");
            }

            $a_bid = $_SESSION['bid'];
		  //------------------------array type----------------------------------
$send = array();
$noSend = array();
$sendWithslash = array();
$sendOffer = array();
$noSendOffer = array();

//-------------define card within an array type-----------------------
array_push ($send,"2200"); 			// Accucard
array_push ($send,"2201"); 			// Advanta
array_push ($noSend,"2202"); 		// Amazon
array_push ($send,"2203"); 			// American Express
array_push ($noSend,"2204"); 		// Aspire
array_push ($send,"2205"); 		    // Bank First
array_push ($noSend,"2206");		// Bank of America
array_push ($send,"2207");			// Bank One
array_push ($send,"2208");			// Barclay
array_push ($noSend,"2209");		// Buyright
array_push ($send,"2210");			// Capital One
array_push ($noSend,"2211");		// Catalog
array_push ($send,"2212");			// Chase
array_push ($send,"2214");			// Citi
array_push ($send,"2215");			// Create
array_push ($noSend,"2216");		// Cross Country
array_push ($noSend,"2217");		// Diners Club
array_push ($send,"2218");			// Discover
array_push ($send,"2219");			// Eufora
array_push ($send,"2220");			// Fifth Third
array_push ($send,"2221");			// First Premier
array_push ($send,"2222");			// First USA
array_push ($noSend,"2223");		// First Vineyard
array_push ($send,"2224");			// Liberty
array_push ($sendWithslash,"2225");	// GM
array_push ($send,"2226");			// Orchard & HSBC
array_push ($send,"2227");			// Marbles
array_push ($noSend,"2228");		// MBNA America Bank
array_push ($noSend,"2237");		// Morgan Stanley
array_push ($send,"2238");			// New Millenium Bank
array_push ($noSend,"2229");		// Prepaid
array_push ($noSend,"2230");		// Pulaski
array_push ($sendOffer,"22314550");	// True Credit (Single)
array_push ($sendOffer,"22314551");	// True Credit (3-in-1)
array_push ($noSendOffer,"22314499");// Annual Credit Report
array_push ($send,"2232");			// US Bank
array_push ($noSend,"2233");		// Union Plus
array_push ($noSend,"2234");		// Vaya
array_push ($noSend,"2235");		// Wired Plastic


//--------------------------------------------------------------------
//send with transid
if ( in_array ( substr($a_bid,0,4), $send) )
{
Header('refresh: 2; url= '.$this->destinationURL.$_SESSION['$TransID']);
readfile ("wrapper_loading.php");
}

//send without transid
if ( in_array ( substr($a_bid,0,4), $noSend) )
{
Header('refresh: 2; url= '.$this->destinationURL);
readfile ("wrapper_loading.php");
}

//send with transid and slash
if ( in_array ( substr($a_bid,0,4), $sendWithslash) )
{
Header('refresh: 2; url= '.$this->destinationURL.$_SESSION['$TransID'].'/');
readfile ("wrapper_loading.php");
}
//send offer with transid 
if ( in_array ( substr($a_bid,0,8), $sendOffer) )
{
Header('refresh: 2; url= '.$this->destinationURL.$_SESSION['$TransID']);
readfile ("loading3.php");
}
//send offer with no transid
if ( in_array ( substr($a_bid,0,8), $noSendOffer) )
{
Header('refresh: 2; url= '.$this->destinationURL);
readfile ("loading2.php");
}
        }
        else
        {
            // post whole content again using cURL and display returned value
            
            // prepare post fields
            $postfields = '';
            foreach($_POST as $key => $value)
            {
                if($key == 'a_aid' || $key == 'a_bid')
                    continue;
                
                if($postfields != '')
                    $postfields .= '&';
                
                $postfields .= $key.'='.urlencode($value);
            }
            
            // make post call and display the result
            $ch = curl_init();
            if($destUrl == '')
                curl_setopt($ch, CURLOPT_URL, $this->destinationURL);
            else
                curl_setopt($ch, CURLOPT_URL, $destUrl);
            
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_exec($ch);
        }
    }
}
?>