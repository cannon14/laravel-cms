<?php
/**
 * 
 * CreditCards.com
 * July 19, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */ 


class CMS_libs_SiteCatalystMerchantService
{
	/**
	 * Remove the current site catalyst page vars and reinsert new ones
	 * @author mz
    * @param int fid
	 * @param Array varData
	 * @static
	 */
	function savePageVarData($detailId, $pageVarData)
	{
      if(!is_array($pageVarData))
      {
         trigger_error('Param of invalid type.', E_USER_ERROR);
      }
      
      if(count($pageVarData) > 0)
      {
         // delete
         $sql = 'delete from sc_merchant_page_data where merchant_service_details_id = ' . _q($detailId);
         // echo $sql.'<br>';
         $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
         
         // re insert
         $sql = 'insert into sc_merchant_page_data (merchant_service_details_id, var_name, var_value) values';
         
         foreach($pageVarData as $varName => $varValue)
         {
            $varValue = trim($varValue);
            if($varValue != '')
            {
               $sql.= " ($detailId, '$varName', '$varValue'),";
            }           
         }
         
         // remove the trailing comma. - mz
         $sql = substr_replace($sql, '', -1);         
         // echo $sql . '<br />';
         
         $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
         return $rs;
      }			
	}
	
   function getPageVarValues($detailId)
   {
      $sql = 
      '
      select          
          v.var_name,
          d.var_value
      from sc_page_vars v
      left outer join sc_merchant_page_data d on v.var_name = d.var_name
         and d.merchant_service_details_id = '._q($detailId);
      
      // echo $sql . '<br />';
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      return $rs; 
   }
}
?>