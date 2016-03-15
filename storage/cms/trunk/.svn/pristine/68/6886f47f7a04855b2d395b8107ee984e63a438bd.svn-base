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

class CMS_view_uploadRates extends CMS_pages_cmsRestrictedPage
{
	var $mapping = array(
							"",
							"",
							"introApr",
							"introAprPeriod",
							"regularApr",
							"monthlyFee",
							"annualFee",
							"balanceTransfers",
							"creditNeeded",
						);

	function process()
	{
		
		if($_REQUEST['upload'] != null){
			$this->processCSV();
		}
		$this->addContent('upload_rates');
	}
	
    function getRequiredPermissions()
    {
    	return array('CMS_rates');	
    }   	
	
	function processCSV()
	{
		$extensionArray = explode(".", $_FILES['csv_file']['name']);
		$extension = $extensionArray[count($extensionArray) - 1];
		if(strtolower($extension) != "csv"){
			_setMessage("File must be in csv format!", true);
		}else{
			$csv = new CsCore_Util_csv($_FILES['csv_file']['tmp_name']);

			while ($arr_data = $csv->NextLine()){
				_setMessage("Processing line ". $csv->RowCount());
				if($csv->RowCount() > 1)
					$this->parseRow($arr_data);
			}
			_setSuccess('CSV Uploaded.');
			CMS_libs_History::write($this->auth->username, "Uploaded rates");
		}
		
	}
	
	function parseRow($arr_data)
	{
		$sql = array();
		$id = $arr_data[0];
		$i = 0;
		foreach ($arr_data as $cell){
			
			if ($this->mapping[$i] != ""){
				$sql[$this->mapping[$i]] = $cell; 
			}
			++$i;
		}
			$sql['dateModified'] = date('Y-m-d H:i:s');
			$sql = "UPDATE cs_carddata SET " . _updateAssociative($sql) . " WHERE cardId = " . _q($id);
			_setMessage($sql);
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
}
?>
