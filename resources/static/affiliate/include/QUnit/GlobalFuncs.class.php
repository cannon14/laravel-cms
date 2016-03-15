<?
/**
*
*   @author Maros Fric
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package global
*   @since Version 1.0
*
*   For support contact info@webradev.com
*/

class QUnit_GlobalFuncs
{
    /** combines directory and file to full path, also inserts last slash after directory 
    * if it is missing
    */
    function makePath($dir, $file)
    {
        if($dir == '' || $file == '')
        {
            return $dir.$file;
        }
        
        // check that dir ends with / or \ slash
        $lastChar = $dir[strlen($dir)-1];
        
        if($lastChar != '\\' && $lastChar != '/')
        {
            return $dir.'/'.$file;
        }
        else
        {
            return $dir.$file;
        }
    }
}

//----------------------------------------------------------------------------

function dbConnect()
{
    $db = ADONewConnection(DB_TYPE);
    $ret = $db->Connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if(!$ret || !$db)
    {
        echo "Error connecting database!";
        exit;
    }
    
    //$db->SetFetchMode(ADODB_FETCH_BOTH);
    $GLOBALS['db'] = $db;
    $GLOBALS['dbrequests'] = 0;
}

//----------------------------------------------------------------------------

function csvFormat($str)
{
    //  if(strpos($str, ' ') == false)
    //    return $str;
    //  else
    return "\"".$str."\"";
}

//----------------------------------------------------------------------------

function utf2ascii($str)
{  
    $s2 = preg_replace('/[^a-zA-Z\'\;\-\ ]/', '', $str);
    return (string) $s2;
    $str2 = '';
    
    for($i=0; $i<strlen($str); $i++)
    {
        if(ord($str[$i])>190)
        continue;
        
        if($i>0 && ord($str[$i-1])>190)
        $str2 .= '?';
        else
        $str2 .= $str[$i];
    }
    
    return $str2;
}

//----------------------------------------------------------------------------

function showPopupHelp($helpID)
{
//    echo "<a href=index_popup.php?md=QUnit_Help_Help&hid=$helpID target=helpwnd width=300 height=300><img src='".$_SESSION[SESSION_PREFIX.'templateImages']."help.gif' border=0></a>";
    echo "<a href='javascript:showPopupHelp(\"".$helpID."\")'><img src='".$_SESSION[SESSION_PREFIX.'templateImages']."help.gif' border=0></a>";
}

//----------------------------------------------------------------------------

function showHelp($helpID, $force = false)
{
    switch($GLOBALS['Auth']->userType)
    {
        case USERTYPE_ADMIN:      $prefix = SETTINGTYPEPREFIX_ACCOUNT; break;
        case USERTYPE_SUPERADMIN: $prefix = SETTINGTYPEPREFIX_SUPERADMIN; break;
        case USERTYPE_USER:       $prefix = SETTINGTYPEPREFIX_ACCOUNT; break;
        default: $prefix = ''; break;
    }
    
    if(!$force)
    {
        if($GLOBALS['Auth']->getSetting($prefix.'show_minihelp') != 1)
        return;
    }
    ?>
    <table border=0 width=100% cellspacing=0 cellpadding=0>
    <tr>
    <td class=minihelp align=left valign=top>
    <b>miniHelp</b>&nbsp;<?=(defined($helpID) ? constant($helpID) : $helpID)?>
    </td>
    </tr>
    </table>
    <?
}

//----------------------------------------------------------------------------
function PrepareSqlParameter($param, $fieldname, $checktype, $arr = '') {
    $rparam = preg_replace('/[\'\"]/', '', $param);
    checkCorrectness($param, $rparam, $fieldname, $checktype, $arr);
    return($rparam);
}

//----------------------------------------------------------------------------

define('CHECK_EMPTY', 1);
define('CHECK_ALLOWED', 2);
define('CHECK_EMPTYALLOWED', 3);
define('CHECK_NUMBER', 4);
define('CHECK_INARRAY', 8);

//----------------------------------------------------------------------------

function checkCorrectness($postfield, $protectedfield, $fieldname, $checktype, $arr = '')
{
    if(($checktype & CHECK_EMPTY) == CHECK_EMPTY)
    {
        if($postfield == '')
        {
            QUnit_Messager::setErrorMessage($fieldname.' '.L_G_EMPTY);
        }
    }
    
    if(($checktype & CHECK_ALLOWED) == CHECK_ALLOWED)
    {
        if($postfield != $protectedfield)
        {
            if(QUnit_Messager::getErrorMessage() == '')
            QUnit_Messager::setErrorMessage($fieldname.' '.L_G_UNALLOWED);
        }
    }
    
    if(($checktype & CHECK_NUMBER) == CHECK_NUMBER)
    {
        if($postfield != '' && !is_numeric($postfield))
        {
            if(QUnit_Messager::getErrorMessage() == '')
            QUnit_Messager::setErrorMessage($fieldname.' '.L_G_NOTNUMBER);
        }
    }
    
    if(($checktype & CHECK_INARRAY) == CHECK_INARRAY && $arr != '' && is_array($arr))
    {
        if(!in_array($postfield, $arr))
        {
            if(QUnit_Messager::getErrorMessage() == '')
            QUnit_Messager::setErrorMessage($fieldname.' '.L_G_NOTALLOWED);
        }
    }
}

//----------------------------------------------------------------------------

function class_new($class)
{
    return new $class;
} 

//----------------------------------------------------------------------------

function begin_page()
{
    $GLOBALS['Auth'] = class_new(AUTH_CLASS);
    $GLOBALS['Auth']->getFromSession();
    
    if($GLOBALS['Auth']->settings == false || (is_array($GLOBALS['Auth']->settings) && count($GLOBALS['Auth']->settings) <1)) {
        $GLOBALS['Auth']->loadSettings();
    }
}

//----------------------------------------------------------------------------

function end_page()
{
    $_SESSION[SESSION_PREFIX.'Auth'] = serialize($GLOBALS['Auth']);
}

//----------------------------------------------------------------------------

function check_security($rights = '')
{
    if(!$GLOBALS['Auth']->isLogged())
    $GLOBALS['Auth']->showLoginPage();
    if(!$GLOBALS['Auth']->hasRights($rights))
    $GLOBALS['Auth']->showNoRightsPage();
}

//----------------------------------------------------------------------------

function showMsg($str, $type = 'error')
{
    echo "<center><span class='$type'>$str</span></center><br>";
}

//----------------------------------------------------------------------------

function showMsgNoBR($str, $type = 'error')
{
    echo "<span class='$type'>$str</span>";
}

//============================================================================
// function will redirects to the new page
//============================================================================
function Redirect($url, $time = 0)
{
    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=$url\">";
    
    echo "<br><center><span class=redirecttext>".L_G_WAITTRANSFER."</a><br><br><a class=redirectlink href=$url>".L_G_TRANSFERNOW."</a></center>";
}

function Redirect_nomsg($url, $time = 0)
{
    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=$url\">";
}

//============================================================================
// displays an array
//============================================================================
function showArray($arr2, $offset = '', $recursive = 20)
{
    if($recursive<=0)
    return;
    
    echo $offset."---------DBG: SHOW ARRAY----------<br>";
    
    if(is_array($arr2))
    {
        $arr = $arr2;
        ksort($arr);
        foreach($arr as $k=>$v)
        {
            if(!is_array($v)) // || $k == 0)
            echo $offset."$k = $v<br>";
            else
            {
                echo $offset."$k is array:<br>";
                showArray($v, $offset.'&nbsp;&nbsp;&nbsp;', $recursive-1);
            }
        }
    }
    echo $offset."----------------------------------<br>";
}

//----------------------------------------------------------------------------

function dbg($str = '')
{
    if(is_array($str))
    showArray($str);
    else
    echo "DBG: <b>$str</b><br>"; 
    flush();
}

//----------------------------------------------------------------------------

function microtime_diff($t1,$t2)
{
    if(($t1=="") || ($t2==""))
    return null;
    
    // now transform strings into numbers
    sscanf($t1,"%f %d",$micros1,$sec1);
    sscanf($t2,"%f %d",$micros2,$sec2);
    
    $diff = (float) ($sec2-$sec1) + ($micros2-$micros1);
    if($diff<0)
    $diff *= -1.0;
    
    return $diff;
}

//============================================================================
// function will replace all ' with ''
//============================================================================
function myquotes_noendtags($str)
{
    $magic_quotes = get_magic_quotes_runtime();
    $magic_quotes_gpc = get_magic_quotes_gpc();
    
    if($magic_quotes_gpc)
    {
        // undo magic quotes
        $str = str_replace("\\\"", "\"", $str);    
        $str = str_replace("\\'", "'", $str);    
        $str = str_replace("\\\\", "\\", $str);    
    }
    
    $nofixquotes=false;
    if (!$magic_quotes) 
    {
        $str = str_replace("\\","\\\\",$str);    
        //    $str = str_replace("\"","\\\"",$str);   
        $str = str_replace("'","''",$str);
        
        return $str;
    }
    
    return $str;  
}

function myquotes($str)
{
    return "'".myquotes_noendtags($str)."'";
}

//----------------------------------------------------------------------------

function _q($str)
{
    return "'".myquotes_noendtags($str)."'";
}

//----------------------------------------------------------------------------
// added to aid with alphabet filter.  - mz 1/2/08
function _qWithAppendingWildCard($str)
{   
    return "'".myquotes_noendtags($str)."%'";
}

//----------------------------------------------------------------------------

function _q_noendtags($str)
{
    return myquotes_noendtags($str);
}

//----------------------------------------------------------------------------

function _qOrNull($data)
{
    if($data == '')
    return 'NULL';
    else
    return _q($data);
}

//----------------------------------------------------------------------------

function myslashes($str)
{
    $magic_quotes_gpc = get_magic_quotes_gpc();
    
    if($magic_quotes_gpc)
    {
        // undo magic quotes
        $str = str_replace("\\\"", "\"", $str);    
        $str = str_replace("\\'", "'", $str);    
        $str = str_replace("\\\\", "\\", $str);    
    }
    
    return $str;  
}
//============================================================================
// function will check and log db error
//============================================================================
// checks $db for errror in a query, in such case, logs it.
function checkDBError($db, $sql,$f,$l, $quiet = false)
{
    if (!$db->_queryID) // || $db->_queryID == null)
    { 
        $lastDBErrorMsg = $db->errorMsg();
        // error in query
        LogError("SQL error: ".$lastDBErrorMsg." SQL:$sql",$f,$l);
        
        if (defined('DB_DEBUG') && $quiet != true)
        {
            showMsg("SQL error: ".$lastDBErrorMsg."; SQL:$sql; File: $f; Line: $l", 'error');
        }
    }
}


//============================================================================
// function will log error
//============================================================================
function LogError($log_msg, $file = '', $line = '')
{
    QCore_History::writeHistory(WLOG_ERROR, $log_msg, $file, $line);
}

//----------------------------------------------------------------------------

function LogMsg($log_msg, $file = '', $line = '')
{
    global $REMOTE_ADDR;
    
    QCore_History::writeHistory(WLOG_DEBUG, $log_msg, $file, $line);
}

//----------------------------------------------------------------------------

function DebugMsg($log_msg, $file = '', $line = '')
{
    QCore_History::writeHistory(WLOG_DEBUG, $log_msg, $file, $line);
}

//----------------------------------------------------------------------------

// definitions of number of days in month
$GLOBALS['daysinmonth'][1] = 31;
$GLOBALS['daysinmonth'][2] = 28;
$GLOBALS['daysinmonth'][3] = 31;
$GLOBALS['daysinmonth'][4] = 30;
$GLOBALS['daysinmonth'][5] = 31;
$GLOBALS['daysinmonth'][6] = 30;
$GLOBALS['daysinmonth'][7] = 31;
$GLOBALS['daysinmonth'][8] = 31;
$GLOBALS['daysinmonth'][9] = 30;
$GLOBALS['daysinmonth']['01'] = 31;
$GLOBALS['daysinmonth']['02'] = 28;
$GLOBALS['daysinmonth']['03'] = 31;
$GLOBALS['daysinmonth']['04'] = 30;
$GLOBALS['daysinmonth']['05'] = 31;
$GLOBALS['daysinmonth']['06'] = 30;
$GLOBALS['daysinmonth']['07'] = 31;
$GLOBALS['daysinmonth']['08'] = 31;
$GLOBALS['daysinmonth']['09'] = 30;
$GLOBALS['daysinmonth'][10] = 31;
$GLOBALS['daysinmonth'][11] = 30;
$GLOBALS['daysinmonth'][12] = 31;

$GLOBALS['wd_monthname'][1] = 'L_G_JANUARY';
$GLOBALS['wd_monthname'][2] = 'L_G_FEBRUARY';
$GLOBALS['wd_monthname'][3] = 'L_G_MARCH';
$GLOBALS['wd_monthname'][4] = 'L_G_APRIL';
$GLOBALS['wd_monthname'][5] = 'L_G_MAY';
$GLOBALS['wd_monthname'][6] = 'L_G_JUNE';
$GLOBALS['wd_monthname'][7] = 'L_G_JULY';
$GLOBALS['wd_monthname'][8] = 'L_G_AUGUST';
$GLOBALS['wd_monthname'][9] = 'L_G_SEPTEMBER';
$GLOBALS['wd_monthname']['01'] = 'L_G_JANUARY';
$GLOBALS['wd_monthname']['02'] = 'L_G_FEBRUARY';
$GLOBALS['wd_monthname']['03'] = 'L_G_MARCH';
$GLOBALS['wd_monthname']['04'] = 'L_G_APRIL';
$GLOBALS['wd_monthname']['05'] = 'L_G_MAY';
$GLOBALS['wd_monthname']['06'] = 'L_G_JUNE';
$GLOBALS['wd_monthname']['07'] = 'L_G_JULY';
$GLOBALS['wd_monthname']['08'] = 'L_G_AUGUST';
$GLOBALS['wd_monthname']['09'] = 'L_G_SEPTEMBER';
$GLOBALS['wd_monthname'][10] = 'L_G_OCTOBER';
$GLOBALS['wd_monthname'][11] = 'L_G_NOVEMBER';
$GLOBALS['wd_monthname'][12] = 'L_G_DECEMBER';

//----------------------------------------------------------------------------

function isLeapYear($year)
{
    return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0); 
}

//----------------------------------------------------------------------------

function getDaysInMonth($month, $year)
{
    $days = $GLOBALS['daysinmonth'][$month];
    if(isLeapYear($year) && $month == 2)
    $days++;
    
    return $days;
}

//----------------------------------------------------------------------------

function computeDateToDays($day, $month, $year)
{
    $century = substr($year,0,2);
    $year = substr($year,2,2);
    
    if($month > 2)
    $month -= 3;
    else
    {
        $month += 9;
        if($year)
        $year--;
        else
        {
            $year = 99;
            $century --;
        }
    }
    
    return (floor((146097 * $century) / 4) + floor((1461 * $year) / 4) + floor((153 * $month + 2) / 5) + $day + 1721119);
}

//----------------------------------------------------------------------------

function computeDaysToDate($days, &$day2, &$month2, &$year2)
{
    $days -= 1721119;
    $century = floor(( 4 * $days -  1) /  146097);
    $days = floor(4 * $days - 1 - 146097 * $century);
    $day = floor($days /  4);
    
    $year = floor(( 4 * $day +  3) /  1461);
    $day = floor(4 * $day +  3 -  1461 * $year);
    $day = floor(($day +  4) /  4);
    
    $month = floor(( 5 * $day -  3) /  153);
    $day = floor(5 * $day -  3 -  153 * $month);
    $day = floor(($day +  5) /  5);
    
    if($month < 10)
    $month +=3;
    else
    {
        $month -=9;
        if($year++ == 99)
        {
            $year = 0;
            $century++;
        }
    }
    
    $century = sprintf("%02d",$century);
    $year = sprintf("%02d",$year);
    
    $day2 = $day;
    $month2 = $month;
    $year2 = $century.$year;
    
    return true;
}

//----------------------------------------------------------------------------

function setLanguage()
{
    $lang = '';


    if(!empty($_REQUEST['lang']) && file_exists(LANG_PATH.$_REQUEST['lang'].'.php'))
    {
        $lang = $_REQUEST['lang'];
    }
    
    if($lang == '' && !empty($_SESSION[SESSION_PREFIX.'lang']) && file_exists(LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php'))
    {
        $lang = $_SESSION[SESSION_PREFIX.'lang'];
    }
    
    if($lang == '' && is_object($GLOBALS['Auth']))
    {
        $lang = $GLOBALS['Auth']->getSetting('Aff_default_lang');
    }
    
    if($lang == '')
    {
        $lang = 'english';
    }

    if(file_exists(LANG_PATH.$lang.'.php'))
    {
        include_once(LANG_PATH.$lang.'.php');
    }
    else
    {
        showMsg('LANGUAGE FILE '.LANG_PATH.$lang.'.php'.'NOT FOUND!', 'error');
    }
    
    $_SESSION[SESSION_PREFIX.'lang'] = $lang;
}

//----------------------------------------------------------------------------

function getNextPaymentDate($orderDay, $orderDayOfWeek, $orderMonth, $orderWeek, $orderYear, $datetype)
{
    $dayofmonth = date('j');
    $month = date("n");
    $year = date("Y");
    $dayofweek = date('w');
    $dayofweek++; // set it to MySql format (1-Sunday, .., 7-Saturday)
    
    if($datetype == RECURRINGTYPE_WEEKLY)
    {
        $daysNow = computeDateToDays($dayofmonth, $month, $year);
        
        if($orderDayOfWeek > $dayofweek)
        {
            computeDaysToDate($daysNow + ($orderDayOfWeek - $dayofweek), $nextDay, $nextMonth, $nextYear);
        }
        else
        {
            // it is next week
            computeDaysToDate($daysNow + 7 - ($dayofweek - $orderDayOfWeek), $nextDay, $nextMonth, $nextYear);
        }
    }
    else if($datetype == RECURRINGTYPE_MONTHLY)
    {
        $nextYear = $year;
        $nextMonth = $month;
        
        if(($nextMonth == $orderMonth && $year == $orderYear) || ($nextMonth != $orderMonth && $dayofmonth > $orderDay))
        {
            // it is this month's order, increment month
            $nextMonth++;
        }
        
        if($nextMonth>12)
        {
            $nextYear++;
            $nextMonth = 1;
        }
        
        $nextDay = $orderDay;
        $daysInMonth = getDaysInMonth($nextMonth, $nextYear);
        if($nextDay > $daysInMonth)
        $nextDay = $daysInMonth;
    }
    else if($datetype == RECURRINGTYPE_QUARTERLY)
    {
        $daysInQuarter = 91;
        
        $nowTotalDays = computeDateToDays($dayofmonth, $month, $year);
        $orderTotalDays = computeDateToDays($orderDay, $orderMonth, $orderYear);
        
        if($nowTotalDays - $orderTotalDays < $daysInQuarter)
        {
            $newOrderDays = $orderTotalDays + $daysInQuarter;
        }
        else
        {
            $newOrderDays = $nowTotalDays + ($daysInQuarter - (($nowTotalDays - $orderTotalDays)%$daysInQuarter));
        }
        
        $nexOrderDays += floor(($nowTotalDays - $orderTotalDays)/365);
        computeDaysToDate($newOrderDays, $nextDay, $nextMonth, $nextYear);
        
    }
    else if($datetype == RECURRINGTYPE_BIANNUALLY)
    {
        $daysInHalfYear = 182;
        
        $nowTotalDays = computeDateToDays($dayofmonth, $month, $year);
        $orderTotalDays = computeDateToDays($orderDay, $orderMonth, $orderYear);
        
        if($nowTotalDays - $orderTotalDays < $daysInHalfYear)
        {
            $newOrderDays = $orderTotalDays + $daysInHalfYear;
        }
        else
        {
            $newOrderDays = $nowTotalDays + ($daysInHalfYear - (($nowTotalDays - $orderTotalDays)%$daysInHalfYear));
        }
        
        $nexOrderDays += floor(($nowTotalDays - $orderTotalDays)/365);
        computeDaysToDate($newOrderDays, $nextDay, $nextMonth, $nextYear);
    }
    else if($datetype == RECURRINGTYPE_YEARLY)
    {
        if($year == $orderYear)
        $nextYear = $year++;
        else
        $nextYear = $year;
        
        $nextMonth = $orderMonth;
        $nextDay = $orderDay;
        
        $daysInMonth = getDaysInMonth($nextMonth, $nextYear);
        if($nextDay > $daysInMonth)
        $nextDay = $daysInMonth;
    }
    else
    return "undefined";
    
    return "$nextYear-$nextMonth-$nextDay";
}

//----------------------------------------------------------------------------

function sqlToDays($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "TO_DAYS($date)";
        else
        return "TO_DAYS('$date')";
    }
    if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "CAST( CONVERT( VARCHAR, $date, 102) as datetime)";
        else
        return "'$date'";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlDayOfMonth($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "DAYOFMONTH($date)";
        else
        return "DAYOFMONTH('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "DAY($date)";
        else
        return "DAY('$date')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlMonth($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
        $nameOfColumn = false;
    else
        $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
            return "MONTH($date)";
        else
            return "MONTH('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
            return "MONTH($date)";
        else
            return "MONTH('$date')";
    }
    else
        return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlYear($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
        $nameOfColumn = false;
    else
        $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
            return "YEAR($date)";
        else
            return "YEAR('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
            return "YEAR($date)";
        else
            return "YEAR('$date')";
    }
    else
        return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlWeek($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "WEEK($date)";
        else
        return "WEEK('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "DATEPART ( week, $date)";
        else
        return "DATEPART ( week, '$date')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlDayOfWeek($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "DAYOFWEEK($date)";
        else
        return "DAYOFWEEK('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "DATEPART ( weekday, $date)";
        else
        return "DATEPART ( weekday, '$date')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlNow()
{
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        return 'NOW()';
    }
    else if($dbType == 'mssql')
    {
        return 'GETDATE()';
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlTimeToSec($time)
{
    // check if $date is date string or name of column
    if(strpos($time, ':') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "UNIX_TIMESTAMP($time)";
        else
        return "UNIX_TIMESTAMP('$time')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "DATEPART(hour, $time)*3600+DATEPART(minute, $time)*60+DATEPART(second, $time)";
        else
        return "DATEPART(hour, '$time')*3600+DATEPART(minute, '$time')*60+DATEPART(second, '$time')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlHour($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "HOUR($date)";
        else
        return "HOUR('$date')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "DATEPART ( hour, $date)";
        else
        return "DATEPART ( hour, '$date')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlShortDate($date)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        if($nameOfColumn)
        return "DATE_FORMAT($date, '%m/%d/%Y')";
        else
        return "DATE_FORMAT('$date', '%m/%d/%Y')";
    }
    else if($dbType == 'mssql')
    {
        if($nameOfColumn)
        return "CONVERT ( VARCHAR, $date, 101)";
        else
        return "CONVERT ( VARCHAR, '$date', 101)";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

function sqlDateAdd($date, $amount, $type)
{
    // check if $date is date string or name of column
    if(strpos($date, '-') !== false)
    $nameOfColumn = false;
    else
    $nameOfColumn = true;
    
    // protection if somebody uses 'mysqlt', or 'mssqlpo'
    $dbType = substr(DB_TYPE, 0, 5);
    
    if($dbType == 'mysql')
    {
        switch(strtolower($type))
        {
            case 'seconds': $type = 'second'; break;
            case 'minutes': $type = 'minute'; break;
            case 'hours': $type = 'hour'; break;
            case 'days': $type = 'day'; break;
            case 'months': $type = 'month'; break;
            case 'years': $type = 'year'; break;
        }
        
        if($nameOfColumn)
        return "DATE_ADD($date, INTERVAL $amount $type)";
        else
        return "DATE_ADD('$date', INTERVAL $amount $type)";
    }
    else if($dbType == 'mssql')
    {
        switch(strtolower($type))
        {
            case 'seconds': $type = 'second'; break;
            case 'minutes': $type = 'minute'; break;
            case 'hours': $type = 'hour'; break;
            case 'days': $type = 'day'; break;
            case 'months': $type = 'month'; break;
            case 'years': $type = 'year'; break;
        }
        
        if($nameOfColumn)
        return "DATEADD ( $type, $amount, $date)";
        else
        return "DATEADD ( $type, $amount, '$date')";
    }
    else
    return '!UNDEFINED DATABASE!';
}

//----------------------------------------------------------------------------

/** inits paging variables and returns actual offset */
function initPaging($allcount)
{
    $_REQUEST['allcount'] = $allcount;
    
    if(empty($_REQUEST['list_page'])) 
    $page = 0;
    else 
    $page = $_REQUEST['list_page'];
    
    if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;    
    if($allcount<$page*$_REQUEST['numrows'])
    $page = 0;          
    
    $_REQUEST['list_pages'] = (int) ceil($allcount/$_REQUEST['numrows']);
    $_REQUEST['list_page'] = $page;
    
    if($page == 0)
    $limitOffset = 0;
    else
    $limitOffset = ($page)*$_REQUEST['numrows'];
    
    return $limitOffset;
}

//----------------------------------------------------------------------------

/** inits paging variables and returns actual offset */
function _r($value, $decimalPlaces = 2)
{
    $val = round($value, $decimalPlaces);
    if($val == 0)
    return 0;
    else
    return sprintf("%.".$decimalPlaces."f", $val);
}

//----------------------------------------------------------------------------

function removeMysqlComments($sql)
{
    $lines = explode("\n", $sql);
    
    $sql = '';
    
    $linecount = count($lines);
    $output = "";
    
    for ($i=0; $i<$linecount; $i++)
    {
        if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
        {
            if ($lines[$i][0] != "#")
            {
                $output .= $lines[$i]."\n";
            }
            else
            {
                $output.="\n";
            }
            
            $lines[$i] = '';
        }
    }
    
    return $output;
}

//----------------------------------------------------------------------------

function splitSqlFile($sql, $delimiter)
{
    $tokens = explode($delimiter, $sql);
    
    $sql = '';
    $output = array();
    $matches = array();
    
    $token_count = count($tokens);
    for ($i = 0; $i < $token_count; $i++)
    {
        // Don't wanna add an empty string as the last thing in the array.
        if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
        {
            // This is the total number of single quotes in the token.
            $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
            // Counts single quotes that are preceded by an odd number of backslashes, 
            // which means they're escaped quotes.
            $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
            
            $unescaped_quotes = $total_quotes - $escaped_quotes;
            
            // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
            if (($unescaped_quotes % 2) == 0)
            {
                // It's a complete sql statement.
                $output[] = $tokens[$i];
                // save memory.
                $tokens[$i] = '';
            }
            else
            {
                // incomplete sql statement. keep adding tokens until we have a complete one.
                // $temp will hold what we have so far.
                $temp = $tokens[$i] . $delimiter;
                // save memory..
                $tokens[$i] = '';
                
                // Do we have a complete statement yet? 
                $complete_stmt = false;
                
                for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
                {
                    // This is the total number of single quotes in the token.
                    $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                    // Counts single quotes that are preceded by an odd number of backslashes, 
                    // which means they're escaped quotes.
                    $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
                    
                    $unescaped_quotes = $total_quotes - $escaped_quotes;
                    
                    if (($unescaped_quotes % 2) == 1)
                    {
                        // odd number of unescaped quotes. In combination with the previous incomplete
                        // statement(s), we now have a complete statement. (2 odds always make an even)
                        $output[] = $temp . $tokens[$j];
                        
                        // save memory.
                        $tokens[$j] = '';
                        $temp = '';
                        
                        // exit the loop.
                        $complete_stmt = true;
                        // make sure the outer loop continues at the right point.
                        $i = $j;
                    }
                    else
                    {
                        // even number of unescaped quotes. We still don't have a complete statement. 
                        // (1 odd and 1 even always make an odd)
                        $temp .= $tokens[$j] . $delimiter;
                        // save memory.
                        $tokens[$j] = '';
                    }
                    
                } // for..
            } // else
        }
    }
    
    return $output;
}

//----------------------------------------------------------------------------

function getUpdateNews($system)
{
    return 'this is some system news...';
}

//----------------------------------------------------------------------------
/** get min year from db tables */
function getMinYear($tab_colm)
{
    $min = date("Y");
    foreach($tab_colm as $key => $value)
    {
        if($key != "" && $value != "")
        {
            $sql = 'select MIN(YEAR('.$value.')) as min_year from '.$key;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                return false;
            }
            
            if($rs->fields['min_year'] > 0 && $rs->fields['min_year'] < $min)
            {
                $min = $rs->fields['min_year'];
            }
        }
    }
    return $min;
}

//----------------------------------------------------------------------------
/** get max year from db tables */
function getMaxYear($tab_colm)
{
    $max = date("Y");
    foreach($tab_colm as $key => $value)
    {
        if($key != "" && $value != "")
        {
            $sql = 'select MAX(YEAR('.$value.')) as max_year from '.$key;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                return false;
            }
            if($rs->fields['max_year'] > 0 && $rs->fields['max_year'] > $max)
            {
                $max = $rs->fields['max_year'];
            }
        }
    }
    return $max;
}

//----------------------------------------------------------------------------
/** user defined comparison function for uasort function */
function cmp_sort($a, $b) 
{
    if($a[$GLOBALS['uasort_by']] == $b[$GLOBALS['uasort_by']]) return 0;

    return ($a[$GLOBALS['uasort_by']] > $b[$GLOBALS['uasort_by']]) 
        ? (($GLOBALS['uasort_order'] == 'asc') ? 1 : (-1)) : (($GLOBALS['uasort_order'] == 'asc') ? (-1) : 1);
}

//----------------------------------------------------------------------------
/** round numbers by setting parameter */
function _rnd($value)
{
    $decimalPlaces = $GLOBALS['Auth']->getSetting(SETTINGTYPEPREFIX_ACCOUNT.'round_numbers');
    if(!is_numeric($decimalPlaces))
    {
        $decimalPlaces = 2;
    }
    
    $val = round($value, $decimalPlaces);
    if($val == 0)
    {
        return 0;
    }
    else
    {
        return sprintf("%.".$decimalPlaces."f", $val);
    }
}

//----------------------------------------------------------------------------
/** return rs fields as array */
function rsfields2array($rs)
{
    return $rs->fields;
}

//----------------------------------------------------------------------------
/** remove value from array */
function removeFromArray($arr1, $valueToRemove)
{
    $arr2 = array();
    foreach($arr1 as $k => $v)
    {
        if($v != $valueToRemove)
            $arr2[$k] = $v;
    }
    
    return $arr2;
}

//----------------------------------------------------------------------------

function getParams($array)
{
    $str = '';
    
    foreach($array as $k => $v) {
        $str .= ($str != '' ? ', ' : '').$k.'='.$v;
    }
    
    return $str;
}

//----------------------------------------------------------------------------

function loadMenu($menuFile)
{
    if(is_object($GLOBALS['Auth']))
    {
        if($GLOBALS['Auth']->isLogged())
        {
            include_once($menuFile);
        }
    }
}

//----------------------------------------------------------------------------

function getFormatedDate($date)
{
    $dbweek = substr($date,0,10);
    $year = substr($dbweek, 0, 4);
    $month = substr($dbweek, 5, 2);
    $day = substr($dbweek, 8, 2);
    
    if($day <= 15) {
        $day = '01';
    } else {
        $day = '16';
    }
    
    return $year.'-'.$month.'-'.$day;
}

//----------------------------------------------------------------------------

function parseDomain($host) 
{
    // first remove any :port part
    $pos = strpos($host, ':');
    if($pos !== false) {
        $host = substr($host, 0, $pos);
    }
    
    $domain = explode('.', $host);
    $last = count($domain) - 1;
    if(count($domain) < 1) {            
        return false;
    } else if(count($domain) < 2) {            
        return $domain[0];
    } elseif(count($domain) > 3) {
        return $domain[$last-2].'.'.$domain[$last-1].'.'.$domain[$last];            
    } else {
        return $domain[$last-1].'.'.$domain[$last];
    }
}

function displayDate($thisdate)
{	
	  $sep = '-';
      $err = false;
	  $tempTime = "";
	  if (strpos($thisdate, ':') !== false){
		  $dateANDtime = explode(' ',$thisdate);
		  $thisdate = $dateANDtime[0];
		  $tempTime = $dateANDtime[1];
	  }
      if (strlen($thisdate) == 10){
            $tempDate = explode('-', $thisdate);
            if (count ($tempDate) == 3){
                $year = $tempDate[0];
                $month = $tempDate[1];
                $daynum = $tempDate[2];
            }
            else
                  $err = true;
      }
      else
            $err = true;

      if (! $err )
            return $month . $sep . $daynum . $sep . $year. " " . $tempTime;
      else
            return '[format error]';
}

function isNF($transid){
	return preg_match('/^(9{1}([0-9]|[a-z])(t|T)).*/', $transid);
}

function println($str)
{
	echo '<pre>' . $str . "\n\n" . '</pre>';
}

function printstruct($struct)
{
	echo '<pre>' . print_r($struct, 1) . "\n\n" . '</pre>';
}

function zeroPadDay($day)
{
	if($day < 10){
		return '0'.$day;
	}
	
	return $day;
}

function zeroPadMonth($month)
{
	return zeroPadDay($month);
}

?>
