<?php

/**
 * CreditCards.com
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * UploadError DataAccess Object -
 * All SQL pertaining to Upload Errors should be placed here.
 * 
 * 
 */
class Affiliate_Merchants_Bl_Upload {
	
	function deleteUploads($ids)
	{
		$sql = 'DELETE FROM ' .UPLOAD_TABLE. ' WHERE transid in ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
	}
	
}
?>