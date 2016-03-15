<?PHP
/**
 * 
 * CreditCards.com
 * March 7, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
 
define("MERCHANT_SERVICES_TABLE", "merchant_services");
define("PAGE_MAP_TABLE", "merchant_services_page_map");
define("DETAILS_TABLE", "merchant_service_details");
define("DATA_TABLE", "merchant_service_data");
 
class CMS_libs_MerchantServices {

	/**
	 * Add a Merchant Service to the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function addMerchantService($params){	
		//check that the id does not already exist and is not deleted
		if($params['merchant_service_id']){
		$sql = 'SELECT merchant_service_id, deleted FROM '.MERCHANT_SERVICES_TABLE.' WHERE merchant_service_id = '. _q($params['merchant_service_id']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
			if($rs->fields['merchant_service_id'] == $params['merchant_service_id']){
				if($rs->fields['deleted'] == 1){
					$sql = 'DELETE FROM '.MERCHANT_SERVICES_TABLE.' WHERE merchant_service_id = ' . _q($rs->fields['merchant_service_id']);
					_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
					$sql = 'DELETE FROM '.DETAILS_TABLE.' WHERE merchant_service_id = '. _q($rs->fields['merchant_service_id']);
					_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
					$sql = 'DELETE FROM '.DATA_TABLE.' WHERE merchant_service_id = '. _q($rs->fields['merchant_service_id']);
					_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
					_setMessage('Deleting Card.');
				}else{
					_setMessage('The ID '. $params['merchant_service_id'] .' already exists.', true);
					return;
				}
			}
		}
		
		foreach($params as $col=>$value)
			$cols[] = $col;
			
		$sqlParams =  '"' . implode('","', $params) . '"';
		$sqlCols = implode(',', array_keys($params));
		
		$sql = 'INSERT INTO '.MERCHANT_SERVICES_TABLE.' ('. $sqlCols.', date_created, date_updated)'. 
		' VALUES ('.$sqlParams.','._q(date("Y-m-d H:i:s")).','._q(date("Y-m-d H:i:s")).')';
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = 'INSERT INTO '.DATA_TABLE.' (merchant_service_id) VALUES ("'.$params['merchant_service_id'].'")';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, "Added Cards: ".$params['id']."<br>SQL: $sql");      
		
		return;
	}
	
	/**
	 * Add the default version for a Merchant Service to the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function addDefaultVersion($merchantId, $params){
		$sql = 'SELECT merchant_service_id FROM '.DETAILS_TABLE.' WHERE merchant_service_id = ' . _q($merchantId) . ' AND merchant_service_detail_version = -1';
		//echo $sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		if($rs->fields['merchant_service_id'] == $merchantId){
			_setMessage("The ID " . $params['merchant_service_id'] . " already exists, can not instanciate version.", true);
			return;
		}
		
		$sqlParams =  "'" . implode("','", $params) . "'";
		
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		
		$sqlCols = implode(",", $cols);
		
		$sql = 'INSERT INTO '.DETAILS_TABLE.'( ' . $sqlCols . ', date_created, date_updated, merchant_service_detail_version, merchant_service_detail_label, merchant_service_id) ' . 
		' VALUES (' . $sqlParams  . ', ' ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ', "-1", "Default", ' . _q($merchantId) . ')';
		
//		echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      $sql = 
      "
      select 
         merchant_service_detail_id, 
         merchant_service_link 
      from ".DETAILS_TABLE."
      where merchant_service_id = '$merchantId'
      and merchant_service_detail_version = -1
      ";
      
//       echo $sql.'<br><br>';
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      // print_R($params);
      $merchantServiceDetailId = $rs->fields['merchant_service_detail_id'];
      $merchantServiceLink = $rs->fields['merchant_service_link'];
      
      CMS_libs_MerchantServices::writeSiteCatalystDefaults($merchantServiceDetailId, $merchantServiceLink);
	}
	
	/**
	 * Update Merchant Data
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateMerchantData($id, $params){
      
		if(!is_array($params))
			return;
		$sql = 'UPDATE '.DATA_TABLE.' SET ';
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ', ';
		}
		$sql .=  ' date_modified = ' . _q(date("Y-m-d H:i:s")). ' where merchant_service_id = ' . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		//echo "SQL " .echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, 'Edited Merchant Service: '.$id.'<br>SQL: '.$sql);
	}
	
	/**
	 * Get the data for a merchant service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @return ResultSet Merchant Service Data
	 * @static
	 */
	function getMerchantServiceById($id){
		$sql = 'SELECT m.*, '.
						'd.setup_fee as d_setupFee, '.
						'd.monthly_minimum as d_monthlyMinimum, '.
						'd.gateway_fee as d_gatewayFee, '.
						'd.statement_fee as d_statementFee, '.
						'd.transaction_fee as d_transactionFee, '.
						'd.discount_rate as d_discountRate, '.
						'd.tech_support_fee as d_techSupportFee, '.
						'd.internet_discount_rate as d_internet_discount_rate, '.
						'd.internet_transaction_fee  as d_internet_transaction_fee, '.
						'd.address_verification_fee  as d_address_verification_fee, '.
						'd.application_fee  as d_application_fee, '.
						'd.reserve  as d_reserve, '.
						'd.chargeback_fee  as d_chargeback_fee '.
		
				'FROM '.DATA_TABLE.' as d, '.MERCHANT_SERVICES_TABLE.' as m ' .
				'WHERE m.merchant_service_id = '._q($id).' '.
				'AND m.merchant_service_id = d.merchant_service_id AND deleted != 1';
				
		//echo $sql . "<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	/**
	 * Get the version info for a merchant service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @return ResultSet Merchant Service version information
	 * @static
	 */
	function getVersion($id){
		$sql = 'SELECT * FROM '.DETAILS_TABLE.' WHERE merchant_service_detail_id = ' . _q($id) . ' AND deleted != 1 ORDER BY merchant_service_detail_label ASC';
		//echo $sql;		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Get the version information from all versions of a merchant service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @return ResultSet All versions information
	 * @static
	 */
	function getVersions($id){
		$sql = 'SELECT * FROM '.DETAILS_TABLE.' WHERE merchant_service_id = ' . _q($id) . ' AND deleted != 1 ORDER BY merchant_service_detail_label ASC';
		//echo $sql;		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Get the default version information for a Merchant Service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @return ResultSet Default version information
	 * @static
	 */
	function getDefaultVersion($id){
		$sql = 'SELECT * '.
				'FROM '.MERCHANT_SERVICES_TABLE.' as m, '.DETAILS_TABLE.' as d '.
				'WHERE m.merchant_service_id = d.merchant_service_id '.
				'AND m.merchant_service_id = ' . _q($id) . ' '.
				'AND d.merchant_service_detail_version = -1';
		//echo $sql;
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Update a Merchant Service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateMerchantService($id, $params){      
		if(!is_array($params))
			return;
		$sql = 'UPDATE '.MERCHANT_SERVICES_TABLE.' set ';
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " date_updated = " . _q(date("Y-m-d H:i:s")). " where merchant_service_id = " . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);		
	}
	
	/**
	 * Delete a Merchant Service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @static
	 */
	function deleteMerchantService($id){
		$sql = 'UPDATE '.MERCHANT_SERVICES_TABLE.' set deleted = 1 where merchant_service_id = ' . $id;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $versionSQL = 'UPDATE '.DETAILS_TABLE.' set deleted = 1 where merchant_service_id = ' . $id;
        //echo $versionSQL;
        $rs = _sqlQuery($versionSQL, __LINE__, __FILE__, DEBUG_MODE);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}
	
	/**
	 * Get all sites that do not currently have a specific version of the Merchant Service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @return ResultSet Sites w/o a version of the Merchant Service
	 * @static
	 */
	function getUnusedVersions($id){
		$sql = 'SELECT * FROM rt_sites WHERE siteId NOT IN ('.
				'SELECT merchant_service_detail_version as siteId FROM '.DETAILS_TABLE.' WHERE merchant_service_id='._q($id).')'.
				' AND deleted != 1';
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Add version data for a Merchant Service to the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function addVersion($params){
      
		$sql = 'SELECT merchant_service_id FROM '.DETAILS_TABLE.' WHERE merchant_service_id = ' . _q($params['merchant_service_id']) . ' AND merchant_service_detail_version = ' . _q($params['merchant_service_detail_version']);
//		print '<pre>';print_r($params);print'</pre>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		if($rs->fields['merchant_service_id'] == $params['merchant_service_id'] && 
		   $rs->fields['merchant_service_detail_version'] == $params['merchantServiceDetailVersion']){
		       _setMessage('The ID ' . $params['merchant_service_id'] . ' already exists, can not instanciate version.');
			return;
		}
		
		// not sure if this was ever working, $params['merchant_service_detail_version'] seems to always be
      // empty, and merchant_service_details.detail_version_id always gets 0 for new versions. 
		$sql = 'SELECT siteName FROM rt_sites WHERE siteId = ' . _q($params['merchant_service_detail_version']); 
      // echo $sql.'<br><br>';
            
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$params['merchant_service_detail_label'] = $rs->fields['siteName'];
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = 'INSERT INTO '.DETAILS_TABLE.' ( ' . $sqlCols . ', date_created, date_updated) ' . 
		' VALUES (' . $sqlParams  . ', ' ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ')';
		
		// echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
              
      $sql = 
      "
      select 
         merchant_service_detail_id, 
         merchant_service_link 
      from ".DETAILS_TABLE."
      where merchant_service_id = "._q($params['merchant_service_id'])."
      and merchant_service_detail_version = "._q($params['merchant_service_detail_version']);
      
      // echo $sql.'<br><br>';
      
      
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      // print_R($params);
      $merchantServiceDetailId = $rs->fields['merchant_service_detail_id'];
      $merchantServiceLink = $rs->fields['merchant_service_link'];
      
      CMS_libs_MerchantServices::writeSiteCatalystDefaults($merchantServiceDetailId, $merchantServiceLink);      
	}
	
	/**
	 * Update version information for a Merchant Service
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Merchant Service ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateVersion($id, $params){

		if(!is_array($params))
			return;
		$sql = 'UPDATE '.DETAILS_TABLE.' SET ';
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " date_updated = " . _q(date("Y-m-d H:i:s")). " where merchant_service_detail_id = " . _q($id);
		// echo $sql;
		//QUnit_Messager::setErrorMessage($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      $sql = 
      "
      select          
         merchant_service_link 
      from ".DETAILS_TABLE."      
      where merchant_service_detail_id = $id
      ";
      
      // echo $sql.'<br><br>';
      
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      // print_R($params);      
      $merchantServiceLink = $rs->fields['merchant_service_link'];
      
      CMS_libs_MerchantServices::writeSiteCatalystDefaults($id, $merchantServiceLink);
	}
	
	/**
	 * Get all Merchant Services associated with a page<br>
	 * This function will return the default version if a site specific version is not defined
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Page ID
	 * @param int Site ID
	 * @return ResultSet Set of all Merchant Services that belong to the page and site (with correct versions)
	 * @static
	 */
	function getMerchantServicesByPage($pageId, $siteId){
		$sql = 
<<<SQL
SELECT 
	* 
FROM 
	merchant_services AS ms
	INNER JOIN merchant_service_details AS d USING (merchant_service_id)
	INNER JOIN merchant_services_page_map AS map USING (merchant_service_id)
	INNER JOIN (
		SELECT 
			merchant_service_id,
			MAX(merchant_service_detail_version) as maxVersion
		FROM merchant_service_details
		WHERE ( merchant_service_detail_version = -1 OR merchant_service_detail_version = "$siteId" )
		GROUP BY merchant_service_id
	) as maxVersion USING (merchant_service_id)
WHERE 
	map.page_id = "$pageId"
	AND d.merchant_service_detail_version = maxVersion.maxVersion
	AND d.deleted != 1 
	AND d.active = 1 
	AND ms.active =1 
	AND ms.deleted != 1
ORDER BY rank
SQL;
		
		//echo $sql.'<hr><hr>';
        $rs = _sqlQuery($sql, __LINE__, __FILE__);		
        return $rs;	
	}
	
	function getMerchantServicesBySite($siteId, $orderby='ORDER BY ms.merchant_service_name'){
				$sql = 'SELECT ms.*, msd.*, mspm.page_id FROM merchant_services as ms
				JOIN merchant_services_page_map as mspm ON ms.merchant_service_id=mspm.merchant_service_id
				JOIN merchant_service_details as msd ON ms.merchant_service_id=msd.merchant_service_id
				WHERE ms.deleted="0"
				AND msd.deleted="0"
				AND ms.active="1"
				AND msd.active="1"
				AND msd.merchant_service_detail_version = IF((
												SELECT merchant_service_id FROM merchant_service_details 
												WHERE merchant_service_detail_version='._q($siteId).' 
												AND merchant_service_id=ms.merchant_service_id AND deleted=0) 
											IS NULL, "-1", '._q($siteId).') '.$orderby;
		//echo $sql.'<hr><hr>';
        $rs = _sqlQuery($sql, __LINE__, __FILE__);		
        return $rs;	
	}
   
   /**
    * Gets merchants services for site catalyst tool.  This only needs
    * to return the merchant service page id and merchant service name.
    * @author mz
    * @param int siteId
    * 
    **/
   function getIndividualMerchantServicesBySite($siteId)
   {
      $sql = 
      '
      select
         merchant_service_detail_id, 
         '.SITECATALYST_MERCHANT_SERVICE_IDENTIFIER.'          
      from merchant_service_details
      order by '.SITECATALYST_MERCHANT_SERVICE_IDENTIFIER.'
      ';
      //echo $sql.'<hr><hr>';
      $rs = _sqlQuery($sql, __LINE__, __FILE__);    
      return $rs;  
   }   
   
   
   ////////////////////////////////////////
   function writeSiteCatalystDefaults($detailId, $merchantLink)
   {  
      /**
       * channel = individual card page
       * prop1 = merchant_service_link
       * s.pageName = channel:prop1
       **/
      if(empty($merchantLink))
      {
         trigger_error('Empty merchant service link.', E_USER_ERROR);
      }      
      
      $sql = 
      "
      insert into sc_merchant_page_data (merchant_service_details_id, var_name, var_value) 
      select merchant_service_details_id, tmp_var_name, tmp_var_value
      from
         (
            select $detailId as merchant_service_details_id, var_name as tmp_var_name, 'merchants' as tmp_var_value from sc_page_vars 
            where var_name like 'channel' 
            union all
            select $detailId as merchant_service_details_id, var_name as tmp_var_name, '$merchantLink' as tmp_var_value from sc_page_vars 
            where var_name like 'prop1' 
            union all 
            select $detailId as merchant_service_details_id, var_name as tmp_var_name, 'merchants:".$merchantLink."' as tmp_var_value 
            from sc_page_vars 
            where var_name like 'pageName' 
         ) as tmpValues
      on duplicate key update var_value = tmpValues.tmp_var_value 
      ";        
      // echo $sql.'<br><br>';
      
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);      
   }   
}
?>