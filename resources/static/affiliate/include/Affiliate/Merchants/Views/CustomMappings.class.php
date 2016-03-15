<?php

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapModel');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapAccess');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_CSVReader');
 QUnit_Global::includeClass('Affiliate_Merchants_Bl_FileReader');

class Affiliate_Merchants_Views_CustomMappings extends QUnit_UI_TemplatePage
{
	 var $error = false;
	 var $column_array = array(	 			'transid',
											'dateapproved',
											'totalcost',
											'providerprocessdate',
											'estimatedrevenue',
											'accountid',
											'rstatus',
											'dateinserted',
											'transtype',
											'payoutstatus',
											'datepayout',
											'cookiestatus',
											'orderid',
											'bannerid', 
											'transkind',
											'refererurl',
											'affiliateid',
											'campcategoryid',
											'parenttransid',
											'comission',
											'ip',
											'recurringcommid',
											'accountingid',
											'productid',
											'data1',
											'data2',
											'data3',
											'provideractionname',
											'providerorderid',
											'providertype',
											'providertatus',
											'providercorrected',
											'providerwebsiteid',
											'providerwebsitename',
											'provideracionid',
											'channel',
											'episode',
											'timeslot',
											'exit',
											'sid',
											'providereventdate',
											'merchantname',
											'providerid',
											'merchantsales',
											'quantity',
											'providerchannel',
											'dateestimated');
    	
	function process()
    {
    	
    	$action = $_REQUEST['action'];
 		if($action == "upload"){
 			$_POST['action'] = null;
 			$file = $_FILES['map_file']['tmp_name'];
 			$message = $this->processFile($file);
 			if($file != "" && $message == ""){
 				
 				QUnit_Messager::setOkMessage("File processed");
 				$_POST['select_box'] = $this->create_select_box();
				$_POST['show'] = "buildmap";
 			}else{
 				
 				$this->error = true;
 				
 				QUnit_Messager::setErrorMessage("File Upload Error - " . $message);
 			}
    		
    	}else if($action == "createmap"){
    		$_POST['action'] = null;
    		$size = $_POST['size'];
    		$map_Array = array();
    		$mapid = $_POST['mapid'];
    		$this->populate_new_map($mapid);
			$_POST['show'] = "";
 		}else if($action == "modifymap"){
			$_POST['action'] = null;
			$mapid = $_POST['mapid'];
			$oldmapid = $_POST['oldmapid'];
			$this->modify_custom_map($mapid, $oldmapid);
			$_POST['show'] = "";
    	}else if($action == "manage"){
			$_POST['action'] = null;
			$modAction = $_REQUEST['modAction'];
			$modName = $_REQUEST['modName'];
			if($modAction == ""){
				QUnit_Messager::setErrorMessage("No Action Selected");
				$_POST['show'] = "";
				$this->custom_mappings_for_selector();
				$this->addContent('custom_mappings');
				return;
			}
			if($modName == ""){
				QUnit_Messager::setErrorMessage("No Mapping Selected");
				$_POST['show'] = "";
				$this->custom_mappings_for_selector();
				$this->addContent('custom_mappings');
				return;
			}
			switch($modAction){
				case "Delete" : $this->process_delete($modName);
				break;
				case "Export" : QUnit_Messager::setErrorMessage("The export feature is still under development");
				break;
				case "Modify" : $_POST['select_box'] = $this->create_select_box();
								$this->get_modify_custom_map_form($modName);
								$_POST['show'] = 'modifymap';
				break;
				default :
				break;
			}
			
			
		}
    	$this->custom_mappings_for_selector();
    	$this->addContent('custom_mappings');
    }
    
    function initPermissions()
    {

        //$this->modulePermissions['view'] = 'aff_transparser_parse_use';
    }  
    
    function populate_new_map($mapid, $modified = false){
    	
    	if($mapid == null){
    		QUnit_Messager::setErrorMessage("No template name entered");
    		return;
    	}
    	
    	$size = $_POST['size'];
    	$result_array = array();
    	$i = 0;
    	foreach($_POST as $name=>$value){
    		if($name >= 0 && $name < $size)
    			$result_array[$name] = $value;
    		else
    			$result_array[$name] = null;
    		
    	}
    	$macc = new Affiliate_Merchants_Bl_MapAccess();
    	$current_map = $macc->create_custom_map_from_array($mapid, $result_array);
    	if($current_map == null){
    		QUnit_Messager::setErrorMessage("Template Name Already exists!");
    	}else{
    		if($modified)
				QUnit_Messager::setOkMessage("Template " . $mapid . " Has been successfully modoified.");	
			else
				QUnit_Messager::setOkMessage("Template " . $mapid . " Has been successfully created.");
    	}
    }
	
	function process_delete($mapid){
		$macc = new Affiliate_Merchants_Bl_MapAccess();
		$macc->delete_custom_map($mapid);
		QUnit_Messager::setOkMessage($mapid . " Successfully deleted");
	}
    
    function processFile($file){
 		$error_log = "";
 		$errors = 0;
 		$no_trans_id = 0;
 	
 		$arr_filename = explode("\\", $_FILES['map_file']['name']);
		$index = sizeof($arr_filename) - 1;
		$filename = $arr_filename[$index];
	
		$arr_val_csv = explode(".", $filename);
		$index = sizeof($arr_val_csv) - 1;
		$ext = $arr_val_csv[$index];
	
		$file_size = filesize($file); 
	
		if (!file_exists($file)){
			$this->error = true;
			return "Unsupported filetype!";	
		
		} 
		if(strtolower($ext) != "csv"){
			$this->error = true;
			return "File must be in csv format!";	
		}
		if ($file_size >= 3200000) {
			$this->error = true;
			return "Maximum file size is 3.0 MB.";
		}  	
	
		$thisfile = fread(fopen($file, "r"), $file_size);
		$csv =& new CSVReader( new FileReader( $file ) );
		$csv->setSeparator( ',' );
	
		$_POST['fileinfo'] = $filename . " (" . $file_size . "b)";
	
		$line = 0;
		 while( false != ( $cell = $csv->next() ) && $line < 1){
			for ( $i = 0; $i < count( $cell ); ++ $i ){
				if($line == 0){
					$line_array[$i] = $cell[$i];
					//echo $line . " " . $i . " " . $cell[$i] . "<br>";
				}
			}
			$_POST['line_array'] = $line_array;
			$line ++;		
 		 }
	
		$ret_string = "Template: " .$provider . "<br>File processed.<br>"."<br>";
		
		return null;
 	}
	
	function get_modify_custom_map_form($mapid){
		$line_array = array();
		$sql = "SELECT * FROM custom_mapping WHERE mapid = " . _q($mapid) . " ORDER BY maporder DESC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		if($rs->fields['mapid'] != $mapid){
			QUnit_Messager::setErrorMessage($mapid . " does not exist");
			return;
		}
		
		while(!$rs->EOF){
			$line_array[$rs->fields['maporder']] = $rs->fields['col'];
			
			$rs->MoveNext();
		}
		$_POST['line_array'] = $line_array;
		$_POST['mapname'] = $mapid;
	}
	
	function modify_custom_map($mapid, $oldmapid){
		if($mapid == $oldmapid){
			$sql = "DELETE FROM custom_mapping WHERE mapid = " . _q($oldmapid);
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		
		$this->populate_new_map($mapid, true);
	}
 	
 	function create_select_box(){
		
		$spooler = "<option selected>Not Imported</option>";
		sort($this->column_array);
		foreach($this->column_array as $col){
			$spooler .= "<option>" . $col . "</option>";	
		}
		return $spooler;
 	}
 	
 	function custom_mappings_for_selector(){
 		$sql = "SELECT distinct mapid FROM custom_mapping";
 		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
 		while(!$rs->EOF){
 			$mappings_array[] = $rs->fields['mapid'];
 			$rs->MoveNext();	
 		}
 		$_POST['mapping_selector'] = $mappings_array;
 	}
 
}
?>