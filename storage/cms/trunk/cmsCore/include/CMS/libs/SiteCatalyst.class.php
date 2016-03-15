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


class CMS_libs_SiteCatalyst
{
   /**
    * Returns a result set of site catalyst variables.
    * @author mz
    * @static
    */
   function getSiteCatalystVariables()
   {
      $sql = 'select var_name from sc_page_vars';
      //echo $sql . '<br />';
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      return $rs; 
   }   
}
?>