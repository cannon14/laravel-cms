<?php

class Affiliate_Scripts_Services_TrafficService 
{
	/**
	 * Array of filters
	 * 
	 * @access private
	 */
	var $filters;
	
	/**
	 * TrafficService Constructor
	 */	
	function Affiliate_Scripts_Services_TrafficService()
	{
		$this->filters = array();
	}
	
	/**
	 * Registers filter by placing it in the filter array.
	 * 
	 * @access public
	 * @params filter
	 **/
	function registerFilter($filter)
	{
		$this->filters[] = $filter;
	}
	
	/**
	 * Executes all registered filters
	 * 
	 * @access public
	 */
	function executeFilters()
	{
		foreach($this->filters as $filter){
			$filter->filter($this);
		}
	}
	
	function log($msg) {
		
		$sql = 'INSERT INTO 
					app_log
				(
					log_type, 
					message,
					time_logged
				) VALUES (
					"NOTICE", ' . _q($msg) . ', NOW())';
		
		$this->_query($sql);	
	}
	
	/**
	 * Thriows an error.  Error logging
	 * should be implemented here.
	 * 
	 * @access protected
	 */
    function _throwError($msg)
    {
    	$err = 'TRAFFIC SERVICE ERROR: ' . __CLASS__ . ': ' . $msg;
    	
    	QCore_History::writeHistory(WLOG_ERROR, $err, __FILE__, __LINE__);
    }
    
    /**
     * Unified query method.  Query the database here
     * 
     * @access protected
     * @param SQL query.
     */
    function _query($sql)
    {
    	// shh...
    	//ob_start();
    		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
    	//$out = ob_get_clean();
    	
    	if($out != null){
    		$this->_throwError('AdoDB threw SQL Error: ' . $sql);
    	}
    	
    	return $rs;
    }	

}
?>