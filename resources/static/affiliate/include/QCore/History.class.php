<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

/**
 * Class handles displaying of history information as well as adding new history records.  
 */
 
class QCore_History
{
    /**
    * function writes history record into DB. 
    */  
    function writeHistory($type, $text, $file, $line, $userType = '', $userid = '')
    {
		/* TODO */
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function DebugMsg($logType,$log_msg,$file='',$line='',$userType='',$userID='')
    {
        $errorMsg = '';

        if($userID == '' && is_object($GLOBALS['Auth']))
        {
            $method = 'getUserID';

            if( method_exists($GLOBALS['Auth'], $method) )
            {
                $userID = $GLOBALS['Auth']->getUserID();
            }
            else
            {
                $errorMsg .= L_G_METHOD.' '.$method.' '.L_G_NOT_REACHABLE.'. ';
            }
        }

        if($userID == '')
        {
            $errorMsg .= L_G_CANNOT_GET_USERID.'. ';
        }


        if($userType == '' && is_object($GLOBALS['Auth']))
        {
            $method = 'getUserType';

            if( method_exists($GLOBALS['Auth'], $method) )
            {
                $userType = $GLOBALS['Auth']->getUserType();
            }
            else
            {
                $errorMsg .= L_G_METHOD.' '.$method.' '.L_G_NOT_REACHABLE.'. ';
            }
        }

        if($userType == '')
        {
            $errorMsg .= L_G_CANNOT_GET_USERTYPE.'. ';
        }

    
        if($log_msg == '')
        {
            $errorMsg .= L_G_LOG_MESSAGE_NOT_SPECIFIED.'. ';
        }
        
        if( is_object($GLOBALS['Auth']) )
        {
            if($userType == USERTYPE_ADMIN || $userType == USERTYPE_USER) {
                $log_level = (int)$GLOBALS['Auth']->settings['Aff_log_level'];
            } else if($userType == USERTYPE_SUPERADMIN) {
                $log_level = (int)$GLOBALS['Auth']->settings['SupA_log_level'];
            }
        }

        if($log_level == '' || !is_int($log_level) || (int)$log_level < 0)
        {
            $errorMsg .= L_G_LOG_LEVEL.' '.L_G_NOT_REACHABLE.'. ';
        }

        if(((int)$log_level & (int)$logType) == (int)$logType)
        {
            if(QCore_History::writeHistory($logType, $log_msg, $file, $line, $userType, $userID))
                return true;
            else{ return false;}
        }
        else if($userID == '' ||  $userType == '')
        {
            if(QCore_History::writeHistory($logType, $log_msg, $file, $line)) return true;
            else{ return false;}
        }
    }
    
    function systemNotify($text, $userType = '', $userid = '')
    {
    	/* TODO */

        return true;
    }
}
?>
