<?php
class Affiliate_Merchants_Bl_BankRules 
{
	function getBankRules()
	{
		return array(SEND_WITH_TRANS_ID 			=> 'Send with TransID',
					SEND_WITHOUT_TRANS_ID 			=> 'Send without TransID',
					SEND_WITH_TRANS_ID_AND_SLASH	=> 'Send with TransID and Slash',
					SEND_OFFER_WITH_TRANS_ID 		=> 'Send offer with TransID',
					SEND_OFFER_WITH_NO_TRANS_ID 	=> 'Send offer with no TransID');
	}
	
	function _sendWithTransId()
	{
		Header('refresh: 2; url='.$this->destinationURL.$_SESSION['$TransID']);
		readfile ("loading.php");		
	}
	
	function _sendWithoutTransId()
	{
		Header('refresh: 2; url='.$this->destinationURL);
		readfile ("loading.php");
	}
	
	function _sendWithTransIdAndSlash()
	{
		Header('refresh: 2; url='.$this->destinationURL.$_SESSION['$TransID'].'/');
		readfile ("loading.php");
	}
	
	function _sendOfferWithTransId()
	{
		Header('refresh: 2; url='.$this->destinationURL.$_SESSION['$TransID']);
		readfile ("loading3.php");
	}
	
	function _sendOfferWithNoTransId()
	{
		Header('refresh: 2; url='.$this->destinationURL);
		readfile ("loading2.php");
	}
	
	function runBankRuleByBannerId($bannerid)
	{
		$sql = 'SELECT m.bank_rule FROM (wd_pa_banners AS b ' .
					'INNER JOIN wd_pa_campaigns AS c USING(campaignid)) ' .
					'INNER JOIN merchants AS m USING(merchant_id) ' .
					'WHERE b.bannerid = ' ._q($bannerid);	
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$bankrule = $rs->fields['bank_rule'];
		
		if($bankrule < SEND_WITH_TRANS_ID){
			QCore_History::writeHistory(WLOG_ERROR, "No error returned for banner id " . $bannerid, __FILE__, __LINE__);	
			return false;
		}
		
		Affiliate_Merchants_Bl_BankRules::runBankRule($bankrule);
	
	}
	
	function runBankRule($rule)
	{
		switch($rule){
			case SEND_WITH_TRANS_ID:
				Affiliate_Merchants_Bl_BankRules::_sendWithTransId();
			break;
			case SEND_WITHOUT_TRANS_ID:
				Affiliate_Merchants_Bl_BankRules::_sendWithoutTransId();
			break;
			case SEND_WITH_TRANS_ID_AND_SLASH:
				Affiliate_Merchants_Bl_BankRules::_sendWithTransIdAndSlash();
			break;
			case SEND_OFFER_WITH_TRANS_ID:
				Affiliate_Merchants_Bl_BankRules::_sendOfferWithTransId();
			break;
			case SEND_OFFER_WITH_NO_TRANS_ID:
				Affiliate_Merchants_Bl_BankRules::_sendOfferWithNoTransId();
			break;			
		}
	}
}
?>