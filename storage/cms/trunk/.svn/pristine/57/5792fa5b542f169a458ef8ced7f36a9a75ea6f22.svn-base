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
 * @package CMS_View
 */
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');

class CMS_view_cvsUpdate extends CMS_pages_cmsRestrictedPage{
	
	var $addArray = array();
	var $added = array();
	var $committed = array();

    function process(){
    	if($_REQUEST['commited']){
	    	chdir($this->settings->getSetting('CMS_cvs_folder'));
	    	$this->_parseFiles();
	    	$this->_addFiles();
	    	$this->_commit();
	    	chdir('/usr/local/apache2/htdocs/dev/cms/cms');
	    	$this->assignValue('committed', $this->committed);
	    	$this->assignValue('added', $this->added);
    	}
	    	$this->addContent('cvs_commit');
    }
    
    function _parseFiles(){
    	shell_exec('cvs update>../log');
		$fh = fopen('../log', 'r') or die("Can't open file");
		while($line = fgets($fh))
    		$this->_parseLine($line);
    	fclose($fh);
    }
    
    function _parseLine($line)
    {
    	$parse = explode(" ", $line);
    	if($parse[0]=='?')
    		$this->addArray[] = $parse[1];    			
    }
    
    function _addFiles()
    {
    	foreach($this->addArray as $file){
    		$addOut = shell_exec('cvs add '.$file);
    		$this->added[] = $file;
    	}
    }
    
    function _commit()
    {
    		$commitOut = shell_exec('cvs commit -m "CMS Article Update - '.date("n/j/Y").'">../log');
    		$fh = fopen('../log', 'r') or die("Can't open file");
			while($line = fgets($fh))
				$this->committed[] = $line;
			shell_exec('cvs update>../log');
			fclose($fh);	
    }
}
?>