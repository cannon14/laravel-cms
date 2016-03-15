<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 27, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
 
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CsCore_Util_csv');

class CMS_view_uploadRates2 extends CMS_pages_cmsRestrictedPage
{
	
	
	var $keys = array(		"rt_cards" => "id",
							"rt_carddetails" => "cardId",
							"cs_carddata" => "cardId",
						);
	
	var $mapping = array(
							"",
							"",
							array ("cardTitle", "rt_cards"),
							array ("cardDescription","rt_cards"),
							array ("merchant","rt_cards"),
							array ("introApr","rt_cards"),
							array ("active_introApr","rt_cards"),
							array ("introAprPeriod","rt_cards"),
							array ("active_introAprPeriod","rt_cards"),
							array ("regularApr","rt_cards"),
							array ("active_regularApr","rt_cards"),
							array ("annualFee","rt_cards"),
							array ("active_annualFee","rt_cards"),
							array ("monthlyFee","rt_cards"),
							array ("active_monthlyFee","rt_cards"),
							array ("balanceTransfers","rt_cards"),
							array ("active_balanceTransfers","rt_cards"),
							array ("creditNeeded", "rt_cards"),
							array ("active_creditNeeded", "rt_cards"),
							array ("imagePath", "rt_cards"),
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							array("cardLink", "rt_carddetails"),
							array("appLink", "rt_carddetails"),
							array("cardDetailVersion", "rt_carddetails"),
							array("cardDetailLabel", "rt_carddetails"),
							"",
							array("campaignLink", "rt_carddetails"),
							"",
							array("cardIntroDetail", "rt_carddetails"),
							array("cardMoreDetail", "rt_carddetails"),
							array("cardSeeDetails", "rt_carddetails"),
							array("categoryImage", "rt_carddetails"),
							array("categoryAltText", "rt_carddetails"),
							array("cardIOImage", "rt_carddetails"),
							array("cardIOAltText", "rt_carddetails"),
							array("cardButtonImage", "rt_carddetails"),
							array("cardButtonAltText", "rt_carddetails"),
							array("cardIOButtonAltText", "rt_carddetails"),
							array("cardIconSmall", "rt_carddetails"),
							array("cardIconMid", "rt_carddetails"),
							array("cardIconLarge", "rt_carddetails"),
							array("detailOrder", "rt_carddetails"),
							"",
							"",
							"",
							array("cardListingString", "rt_carddetails"),
							array("cardPageHeaderString", "rt_carddetails"),
							"",
							array("imageAltText", "rt_carddetails"),
							array("active", "rt_carddetails"),
							array("deleted", "rt_carddetails"),
							array("cardId", "cs_carddata"),
							array("introApr", "cs_carddata"),
							array("introAprPeriod", "cs_carddata"),
							array("regularApr", "cs_carddata"),
							array("annualFee", "cs_carddata"),
							array("balanceTransfers", "cs_carddata"),
							array("introApr", "cs_carddata"),
							array("monthlyFee", "cs_carddata"),
							array("creditNeeded", "cs_carddata"),
						);

	function process()
	{
		$this->addContent('upload_rates');
		if($_REQUEST['upload'] != null){
			$this->processCSV();
		}
	}
	
	function processCSV()
	{
		
		$csv = new CsCore_Util_csv($_FILES['csv_file']['tmp_name']);

		while ($arr_data = $csv->NextLine()){
			_setMessage("Processing line ". $csv->RowCount());
			$this->parseRow($arr_data);
		}
	}
	
	function parseRow($arr_data)
	{
		$sql = array();
		$id = $arr_data[0];
		$i = 0;
		foreach ($arr_data as $cell){
			
		
			if (is_array($this->mapping[$i])){
				$sql[$this->mapping[$i][1]][$this->mapping[$i][0]] = $cell; 
			}
			++$i;
		}
		foreach($sql as $table => $data){
			$sql = "UPDATE " . $table . " SET " . _updateAssociative($data) . " WHERE ".$this->keys[$table]." = " . _q($id);
			_setMessage("<code>".htmlEntities($sql)."</code>");
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		}
	}
}
?>
