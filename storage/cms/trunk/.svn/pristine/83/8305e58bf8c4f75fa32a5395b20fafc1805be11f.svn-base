<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 15, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * Add global functions that you would like to add
 * throughout csCore here.  Leave a brief explanation
 * if function's purpose is not entirely intuitive.
 * 
 */
 

// This function executes a SQL query via AdoDB
// send in __LINE__ & __FILE__ for debug purposes.
// You can also define whether or not to complain
// on SQL error, it does by default.
function _sqlQuery($sql, $line, $file, $error = true)
{
	csCore_import::importClass('csCore_DB_db');
	$DB = new csCore_DB_db();
	return $DB->query($sql, $line, $file, $error);
}

function _sqlSelectLimit($sql, $offset, $limit, $f, $l, $errorout = false)
{
	csCore_import::importClass('csCore_DB_db');
	$DB = new csCore_DB_db();
	return $DB->selectLimit($sql, $offset, $limit, $f, $l, $errorout);
}



function _sqlInitPaging($allcount)
{
    $_REQUEST['allcount'] = $allcount;
    
    if(empty($_REQUEST['list_page'])) {
        $page = 0;
    }
    else{
        $page = $_REQUEST['list_page'];
    }
    if(empty($_SESSION[FILTER_SESSION]['numrows'])) $_SESSION[FILTER_SESSION]['numrows'] = 20;    
    if($allcount < $page*$_SESSION[FILTER_SESSION]['numrows'])
        $page = 0;          
    
    $_REQUEST['list_pages'] = (int) ceil($allcount/$_SESSION[FILTER_SESSION]['numrows']);

    $_REQUEST['list_page'] = $page;
    
    if($page == 0)
        $limitOffset = 0;
    else
        $limitOffset = ($page)*$_SESSION[FILTER_SESSION]['numrows'];
        
    return $limitOffset;
}

// $foo = _q("Foo");
// echo $foo; 
// outputs: 'Foo'
function _q($string)
{
	return "'".mysql_escape_string(textScrub($string))."'";
}

// Takes an array and puts it within parens delimited by commas
// and another delimiter you define.
// $array1 = ("A", "B", "C");
// $sqlCols = _array2Paren($array1);
// $array2 = (1, 2, 3);
// $sqlVals = _array2Paren($array2, "'");
// echo "INSERT INTO a_table " . $sqlCols . " VALUES " . $sqlVals;
// outputs: INSERT INTO a_table (A, B, C) VALUES ('1', '2', '3');  
function _array2paren($array, $delim = "")
{
	if(!is_array($array)){
		return "($delim$delim)";
	}
	$ret = "($delim" . implode("$delim,$delim", str_replace($delim, "\\".$delim, $array)) . "$delim)";
	return $ret;
}

function _updateAssociative($sqlArray)
{
	$totalCount = count($sqlArray);
	$i = 1;
	$retString = '';
	foreach($sqlArray as $col=>$data){
		$retString .= $col . " = " . _q($data);
		if($i < $totalCount)
			$retString .= ", ";
		++ $i;
	}
	return $retString;
}

function _insertAssociative($sqlArray)
{
	return _array2paren(array_keys($sqlArray)) . " VALUES " . _array2paren(array_values($sqlArray), "'");
}

// Gives you the current date/time in SQL datetime format.
function _sqlNow()
{
	return date("Y-m-d H:i:s");
}

function _setMessage($msg, $error = false, $line = "n/a", $file = "n/a")
{
	
	$messager = csCore_import::instanciateSingleton('csCore_Messaging_messager');
	$messager->setMessage($msg, $error, $line, $file);	
	
}

function _getMessages()
{
	
	$messager = csCore_import::instanciateSingleton('csCore_Messaging_messager');
	return $messager->getMessages();
	
}

function _getErrorMessages()
{
	
	$messager = csCore_import::instanciateSingleton('csCore_Messaging_messager');
	return $messager->getErrors();
	
}

function _numErrors()
{
	
	$messager = csCore_import::instanciateSingleton('csCore_Messaging_messager');
	return $messager->numErrors();
	
}


function _sendDebug()
{
	$messager =& csCore_import::instanciateSingleton('csCore_Messaging_messager');
	$messager->mailDebug();
}

function _setSuccess($msg)
{
?>
<table width=770>
<tr>
<td color='green'>
<b>Success!</b>
</td>
</tr>
<tr>
<td>
<font color='green'><?=$msg?>
</td>
</tr>
</table>

<?PHP	
}

function _userAttention($msg)
{
?>
<table width=770>
<tr>
<td color='red'>
<b>Attention!</b>
</td>
</tr>
<tr>
<td>
<font color='red'><?=$msg?>
</td>
</tr>
</table>

<?PHP	
}

function _printR($object)
{
	echo '<pre>';print_r($object);echo'</pre>';
}

// Appends to the log file.
function _log($string, $line, $file)
{
	csCore_import::importClass('csCore_Logging_log');
	$log = new csCore_Logging_log(LOG_PATH);
	$log->write($string, $line, $file);
}

// Custom error handler function which will pipe errors to our console.
// instead of standardout.
// TODO => I would like to move this into a class so that it can be
// extended.
function _errorHandler ($error_level, $error_message, $file, $line) {
		
		$EXIT = false;
	
	    if ( ! ($error_level & error_reporting ()) || ! (ini_get ('display_errors') || ini_get ('log_errors')))
	        return;
	
	     switch ($error_level) {
	        case E_NOTICE:
	        case E_USER_NOTICE:
	            $error_type = 'Notice';
	            break;
	
	        case E_WARNING:
	        case E_USER_WARNING:
	            $error_type = 'Warning';
	            break;
	
	        case E_ERROR:
	        case E_USER_ERROR:
	        
	            $error_type = 'Fatal Error';
	            break;
	
	        default:
	            $error_type = 'Unknown';
	            break;
	    }
	
	    if (ini_get ('display_errors')){
	    	_setMessage("<b>$error_type</b>: $error_message in <b>$file</b> on line <b>$line</b>\n", true);
	    }
	    
	    if (ini_get ('log_errors')){
	        error_log (sprintf ("%s: %s in %s on line %d", $error_type, $error_message, $file, $line));
	    	_setMessage("<b>$error_type</b>: $error_message in <b>$file</b> on line <b>$line</b>\n", true);
	    }
	    
	    if ($EXIT)
	        exit;
}

function textScrub($text)
{
	$text = str_replace("&reg;", "&#174;", $text);
	$text = str_replace("�", "&#174;", $text);
	$text = str_replace("�", "", $text); 
	$text = str_replace("�", "<sup>TM</sup>", $text); 
	
	return $text;
}

function cleanTitle($text)
{
	$chars = array(
				"<sup>TM</sup>",
                "<sup>tm</sup>",
                "<sup>SM</sup>",
                "<sup>sm</sup>",
                "<sup></sup>",
                "&reg;",
				"&#174;",
				"�",
				"�",
	            "�",
				"&trade;",
				"<sup>",
				"</sup>",
				"(SM)",
				"(TM)",
				"&#8482;",
                "&amp;"
	       );
	
    for($i=0; $i<count($chars); $i++)
    {
    	$text = str_replace($chars[$i], "", $text);
    }
    
    return $text;
}

?>
