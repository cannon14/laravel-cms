<?php
 
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_CSVReader');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_FileReader');
 QUnit_Global::includeClass('QUnit_UI_TemplatePage');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapModel');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapAccess');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_TransactionModel');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadClicks');
 
class Affiliate_Merchants_Views_CsvParser2 extends QUnit_UI_TemplatePage
{
	function process()
    {

			
    	$action = $_REQUEST['action'];
 		if($action == "upload"){
 			$_POST['action'] = null;
 			
 			$file = $_FILES['csv_file']['tmp_name'];
 	
 			$_POST['csv_file'] = null;
 			$provider = $_REQUEST['provider'];
 			$success = "<p class='normaltext'>File successfuly processed.</p>";
 			$failure = "<p class='errortext'>Error processing file - ";
 
 			if($file != "" && $message == ""){
 				$message = $this->processFile($file, $provider);
 			}else{
 				$message = $failure . "No file uploaded</p>";	
 			}
 			  $_POST['message'] = $message;
    	}
    	$macc = new Affiliate_Merchants_Bl_MapAccess();
    	$map_array = $macc->select_all_mappings();
    	$_POST['map_array'] = $map_array;
    	$this->addContent('csv_parser');
    }
    function processFile($file, $provider){
 		set_time_limit(30);
 		
 		$custom = ($_POST['input_op'] == "custom");
 		if($_POST['input_op'] == "custom"){
			//echo $provider;
 			$provider = $_POST['custom'];
 		}
 		else if($_POST['input_op'] == "standard"){
			$provider = $_POST['standard'];
 		}
		else if($_POST['input_op'] == "other"){
			$provider = "uploaded click";
		}
 			
 		
 		
 		$error_log = "";
 		$errors = 0;
 		$no_trans_id = 0;
 	
 		$arr_filename = explode("\\", $_FILES['csv_file']['name']);
		$index = sizeof($arr_filename) - 1;
		$filename = $arr_filename[$index];
	
		$arr_val_csv = explode(".", $filename);
		$index = sizeof($arr_val_csv) - 1;
		$ext = $arr_val_csv[$index];
	
		$file_size = filesize($file); 
	
		if (!file_exists($file)){
			return "<p class='errortext'>unsupported filetype!</p>";	
		} 
		if(strtolower($ext) != "csv"){
			return "<p class='errortext'>File must be in csv format!</p>";	
		}
		if ($file_size >= 3200000) {
			return "<p class='errortext'>Maximum file size is 3.0 MB.</p>";
		}
		if($provider == null && $_POST['input_op'] != "other"){
			return "<p class='errortext'>No provider or template selelcted</p>";
		}
	
		$thisfile = fread(fopen($file, "r"), $file_size);
		$csv =& new CSVReader( new FileReader( $file ) );
		$csv->setSeparator( ',' );
	
		$_POST['fileinfo'] = $filename . " (" . $file_size . "b)";


		
		if($_POST['input_op'] == "custom"){
			$tacc = new Affiliate_Merchants_Bl_Transactions($provider, $provider);
		}else if ($_POST['input_op'] == "standard"){
			$tacc = new Affiliate_Merchants_Bl_Transactions($provider, null);
		}else if ($_POST['input_op'] == "other"){
			$clicks = 0;
			QCore_History::systemNotify(" parsed " . $filename);
			while( false != ( $cell = $csv->next() ) ){
				for ( $i = 0; $i < count( $cell ); ++ $i ){
					if($line > 0){
						$line_array[$i] = $cell[$i];
						//echo $line . " " . $i . " " . $cell[$i] . "<br>";
					}
				}
				if($line > 0){
					$clicks += abs(Affiliate_Merchants_Bl_UploadClicks::insertClicks($line_array, $line));
				}
				++$line;
			}
			QUnit_Messager::setOkMessage($clicks . " clicks successfully uploaded.");
			return;
			
		}
		

		// write to sysnotify
		QCore_History::systemNotify(" parsed " . $filename);
		
		
		while( false != ( $cell = $csv->next() ) ){
			for ( $i = 0; $i < count( $cell ); ++ $i ){
				if($line > 0){
					$line_array[$i] = $cell[$i];
					//echo $line . " " . $i . " " . $cell[$i] . "<br>";
				}
			}
			if($line > 0){
				$current_trans = $tacc->populate_transaction_from_csv_line($line_array);
				
				$status = $tacc->get_type($current_trans);
				
				if($tacc->is_empty($current_trans)){
					++$bad_trans;	
				}else{
					//QUnit_Messager::setOkMessage($status);
					switch($status){
						case 0 : 
								 QUnit_Messager::setErrorMessage($tacc->_insert_error_transaction($current_trans, 2));
								 $errors ++;
						break;
						case 1 : $errors += $tacc->update_actual($current_trans, $filename);
						break;
						case 2 : $errors += $tacc->insert_sale($current_trans, $filename, $provider);
						break;
						case 3 : $errors += $tacc->insert_non_click_sale($current_trans, $filename);
						break;
						case 4 : QUnit_Messager::setErrorMessage($tacc->_insert_error_transaction($current_trans, -1));
								 $errors ++;
						break;
						default : 		 
						break;
					}
				}
			}	
			$line ++;

 		 }
	
		$ret_string = "Template: " .$provider . "<br>File processed.<br>" . ($line - $errors - 1 - $bad_trans)  . " transaction(s) successfully updated.<br>";
	
		if($errors > 0)
			$ret_string .= "<br>Error Log Processed: ". $errors ." error(s) - <br>";
	
		return $ret_string;
 	} 
}
?>