<?php
require_once('global.php');

// Define the tid QS variable name.	
define('TID_TOKEN', 'tid');

// Define the table we wish to store the data in.
define('APPLICATION_TABLE', 'completed_applications');

// Define a regex pattern to validate transid.
define('VALIDATION_REGEX', '/^([a-z0-9]{30})$/');
		
ApplicationService::storeApplication($_GET[TID_TOKEN]);

class ApplicationService
{
		
	function storeApplication($tid)
	{
		// if tid is null, then we'll log this as an error.
		if($tid == null){
			ApplicationService::_throwError('null transid!');	
			return;
		}
		
		// if tid is malformed we'll log this as an error.
		if(!ApplicationService::_validateTransactionId($tid)){
			ApplicationService::_throwError('The transaction id '. $tid .' is invalid!');	
		}
		
		$sql = 'INSERT INTO ' . APPLICATION_TABLE . ' ' .
				'(completed_application_id, transaction_id, date_inserted) ' .
				'VALUES ('._q('CA' . QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid')).','._q($tid).', '._q(date('Y-m-d- h:i:s')).')';
					
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
		
	function _validateTransactionId($tid)
	{
		$tid = trim($tid);
		return preg_match(VALIDATION_REGEX, $tid);
	}
	
	function _throwError($msg)
	{
		// Log errors here (if you want to.).
		QCore_History::writeHistory(WLOG_ERROR, 'ERROR: ' . $msg, __FILE__, __LINE__);
	}
}
?>
