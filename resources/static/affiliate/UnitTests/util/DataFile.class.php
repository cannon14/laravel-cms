<?php
/**
 * 
 * DataFile Class
 * 
 * This class will create CSV and XLS files in order to
 * automate testing on the CCCOM Revenue Parser.
 * 
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */
 

 
class DataFile {

	var $rows;
	var $delim;
	var $quotes;

    function DataFile( $delim = ',', $quotes = "'") 
    {
    	$this->rows 	= array();
    	$this->delim 	= $delim;
    	$this->quotes  	= $quotes;
    }
    
    function appendRow( $row )
    {
    	$this->rows[] = $row;
    }
    
    function writeFile( $name )
    {
		$fp = fopen($name, "w");
		
		foreach($this->rows as $row){
			fwrite($fp, $this->_csvPrep($row));
		}
		
		fclose($fp);    	
    }
    
    function _csvPrep($array)
    {
    	return $this->quotes . implode($this->quotes.$this->delim.$this->quotes, $array) .$this->quotes . "\n";
    }
}

class DataFile2XlsCoverter {

	
	function convert($df, $name)
	{
		
		$workbook = new Spreadsheet_Excel_Writer($name);
		$worksheet =& $workbook->addWorksheet(basename($name));
		
		//echo $name;
		
		for($line = 0; $line <= count($df->rows); ++$line){
			DataFile2XlsCoverter::_writeLine($df->rows[$line], $line, $worksheet);
		}
		
		$workbook->close();
		
	}
	
	function _writeLine($array, $line, &$ws)
	{
		$length = count($array);
		
		$i = 0;
		foreach($array as $col => $val)
		{
			$ws->write($line, $i, $val);
			++$i;
		}
	}
}
?>