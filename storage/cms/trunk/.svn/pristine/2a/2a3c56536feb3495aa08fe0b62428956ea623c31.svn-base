<?php
/**
 * 
 * CreditCards.com
 * 01/04/08
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
class CMS_libs_CardPlacementSnapshot 
{
	function recordState($siteid)
	{
		$sql  = 'INSERT INTO card_placement_history 
				  SELECT 
				    rt_cardpagemap.cardpageId, 
				    rt_cardpagemap.cardId, 
				    rt_cardpagemap.rank,  
				    rt_cards.active as active, 
				    NOW() as time_snapped
				  FROM rt_cardpagemap 
				  INNER JOIN rt_cards           USING (cardId)   
				  INNER JOIN rt_pagecategorymap USING (cardpageId)
				  INNER JOIN rt_cardpages       USING (cardpageId)
				  WHERE rt_pagecategorymap.categoryId = '._q($siteid).'
				    AND rt_cards.deleted != 1 AND rt_cardpages.deleted != 1';		
	
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE); 
	}
}
?>