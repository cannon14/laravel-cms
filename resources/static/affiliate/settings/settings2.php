<?php
/**
  * 
  * This function will check to see whether or not the ampersands within
  * the query string are encoded.  If they are, the key value pairs will be 
  * extracted and pushed into the $_GET array
  * 
  */
 /**
 function pushAmpEncodedVarsToGet()
 {
 	if(strpos($_SERVER['QUERY_STRING'], '%26') != null 
 		&& strpos($_SERVER['QUERY_STRING'], '&') == null){
 			
 		$array = explode('%26', $_SERVER['QUERY_STRING']);
 		
 		foreach($array as $data){
 			$tmp = explode('=', $data);
 			$_GET[$tmp[0]] = $tmp[1];
 		}
 		
 	}
 }
 
 pushAmpEncodedVarsToGet();
**/

//Session Start
	session_start();

//Set path to Root Domain
	$GLOBALS['RootPath'] = "http://".$_SERVER['HTTP_HOST']."/";


// set session data with tid.
if(isset($_GET['tid'])){
	//$clickReg = new Affiliate_Scripts_Bl_ClickRegistrator();
	$_SESSION['tid'] = $_REQUEST['tid'];
	$_SESSION['aid'] = $_REQUEST['a_aid'];
	$_SESSION['bid'] = $_REQUEST['a_bid'];
	//insert a dummy transaction here.
	//$clickReg->saveTransientClick();
}

//Set Affiliate ID 
 if($_GET['a_aid'] != '') { 
        $_SESSION['aid'] = $_GET['a_aid'];
 }
        else {
                if ($_SESSION['aid'] == '') {
                   $ref = $_SERVER['HTTP_REFERER'];
                   $_SESSION['referer'] = $ref;
                   if ($ref == ''){
                        $a_aid = 999;
                   }
                   else {
                        $a_aid = 1000;
                   }
                   $_SESSION['aid'] = $a_aid;
                }
 }

 
 //Set Tracker
	
 if($_GET['a_cid'] != '') { 
	$_SESSION['cid'] = $_GET['a_cid'];
 }
	else {
		if ($_SESSION['cid'] == '') {
		$a_cid = 9999;
		$_SESSION['cid'] = $a_cid;
		}
 }

//Set Reference
//BAD CODE - ASK Christian about it
//	if($_GET['a_bid'] != '') { 
//	$_SESSION['did'] = $_GET['a_bid'];
// }
 if($_GET['a_did'] != '') { 
	$_SESSION['did'] = $_GET['a_did'];
 }
	else {
		if ($_SESSION['did'] == '') {
		$a_did = 9999;
		$_SESSION['did'] = $a_did;
		}
 }

//Set Timeslot
	if($_GET['a_eid'] != '') { 
	$_SESSION['eid'] = $_GET['a_eid'];
 }
	else {
		if ($_SESSION['eid'] == '') {
		$a_eid = 99;
		$_SESSION['eid'] = $a_eid;
		}
 }

//Set Date-Time Variable
$_SESSION['gid'] = date('YmdHis');

//Set Global Tracking Variable
$_SESSION['hid'] = "36";

