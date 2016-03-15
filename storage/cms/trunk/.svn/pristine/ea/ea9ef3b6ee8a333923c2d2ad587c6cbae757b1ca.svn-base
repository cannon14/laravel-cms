<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 27, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
 
class CMS_libs_History 
{
	/**
	 * Write history to the history table
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param String User name
	 * @param String Action taken
	 * @static
	 */
	function write($user, $action)
	{
		$sql = "INSERT INTO cs_history (dateinserted, user, action) VALUES ("._q(date("Y-m-d H:i:s")).","._q($user).","._q(addslashes($action)).")";
		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Purge all data from the history table
	 * @author Patrick Mizer
	 * @version 1.0
	 * @static
	 */
	function purge()
	{
		$sql = "TRUNCATE cs_history";
		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

}
?>