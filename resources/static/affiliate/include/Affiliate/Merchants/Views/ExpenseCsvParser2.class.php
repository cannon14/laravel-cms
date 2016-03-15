<?php
 
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_CSVReader');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_FileReader');
 QUnit_Global::includeClass('QUnit_UI_TemplatePage');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExpenseParser');

 
class Affiliate_Merchants_Views_ExpenseCsvParser2 extends QUnit_UI_TemplatePage
{
	function process()
    {

			
    	$action = $_REQUEST['action'];
 		if($action == "upload"){
 			$_POST['action'] = null;
 			
 			$file = $_FILES['csv_file']['tmp_name'];
 	
 			$_POST['csv_file'] = null;

 			$success = "<p class='normaltext'>File successfuly processed.</p>";
 			$failure = "<p class='errortext'>Error processing file - ";
 
 			if($file != "" && $message == ""){
 				$message = $this->processFile($file);
 			}else{
 				$message = $failure . "No file uploaded</p>";	
 			}
 			  $_POST['message'] = $message;
    	}
    	$this->addContent('expense_csv_parser');
    }
    
	function processFile($file){
 		set_time_limit(30);

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
	
		$thisfile = fread(fopen($file, "r"), $file_size);
		$csv =& new CSVReader( new FileReader( $file ) );
		$csv->setSeparator( ',' );
	
		$_POST['fileinfo'] = $filename . " (" . $file_size . "b)";

		$eacc = new Affiliate_Merchants_Bl_ExpenseParser();

		// write to sysnotify
		QCore_History::systemNotify(" parsed expense csv - " . $filename);
		
		$line = 0;
		$errors = 0;
		
		while( false != ( $cell = $csv->next() ) ){
			for ( $i = 0; $i < count( $cell ); ++ $i ){
				if($line > 0){
					$line_array[$i] = $cell[$i];
					//echo $line . " " . $i . " " . $cell[$i] . "<br>";
				}
			}
			if($line > 0){
				$error = $eacc->insert_line($line_array);
				if($error != 0)
					$errors ++;
					
			
			}
			$line ++;
			

 		 }
	
		$ret_string = "File processed.<br>" . ($line - $errors - 1)  . " expense(s) successfully created.<br>";
	
		if($errors > 0)
			$ret_string .= "<br>Error Log Processed: ". $errors ." error(s) - <br>";
	
		return $ret_string;
 	} 
}


?>