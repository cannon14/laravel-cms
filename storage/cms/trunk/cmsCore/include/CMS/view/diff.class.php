<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 31, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
	
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('csCore_Util_Diff');

class CMS_view_diff extends CMS_pages_cmsList
{
	
	var $diffOnContent = true;
	
    function process()
    {
	        if(!empty($_REQUEST['commited']))
	        {		
	            switch($_REQUEST['postaction'])
	            {
	               case 'update':
	                    $this->processUpdateSite();
	                    break;
	                    
					case 'create':
	                    if($this->processCreateSite())
	                        return;
	                    break;				
	            }
	        }
	        if(!empty($_REQUEST['action']))
	        {
	            switch($_REQUEST['action'])
	            {             
	                case 'resetAll':
	                    if($this->resetAll())
	                        return;
	                    break;	                
	                case 'edit':
	                    if($this->drawFormEditSite())
	                        return;
	                    break;
					case 'create':
	                    if($this->drawFormCreateSite())
	                        return;
	                    break;                                   									
	                case 'delete':
	                    if($this->processDelete())
	                        return;
	                    break;
	                case 'audit':
	                    if($this->auditSites())
	                        return;
	                    break;
	                case 'resetAll':
	                    if($this->resetAll())
	                        return;
	                    break;	                    
	                case 'reset':
	                    if($this->replaceSite($_REQUEST[$this->getKey()]))
	                        return;
	                    break; 	
	                case 'diff':
	                    if($this->showDiff($_REQUEST[$this->getKey()]))
	                        return;
	                    break; 		
	                case 'ignore':
	                    if($this->addToIgnore($_REQUEST[$this->getKey()], $_REQUEST['line']))
	                        return;
	                    break;	
	                case 'unignore':
	                    if($this->removeFromIgnore($_REQUEST[$this->getKey()], $_REQUEST['line']))
	                        return;
	                    break;	                    	                     		                                          	                                        					
	            }
	        }    
				$this->showData();      
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_diff');	
    }     
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_diffTable';
    }       
	
    function setSql()
    {

    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM cs_diffTable ";
    	//$this->where .= " AND changed = 1";
    	if($_REQUEST['type'] != -1)
    		$this->where .= " AND changed = " ._q($_REQUEST['type']);
    }	
    
    function setFilter()
    {
    
    	$this->filter->setTitle("Diff Filter");
    	
    	$options = array(-1 => 'all', 0 => 'unchanged', 1 => 'changed');

    	
    	$this->filter->addItem(new csCore_UI_formSelect(array('name' => 'type', 
    														'default' => -1,
															'value' => $_REQUEST['type'],
    														'options' => $options,
															'label' => 'State: ')));
		
    	
    }    
    
    function getColumns()
    {
		// db Column name => array(Label, sortable, table alias, mapping)
		return array(
			
			"name"	 			=> array("Site Name", true, "", 'getLink'),
			"url" 				=> null,
			"changed" 			=> array("Site Status", true, "", 'getChangedString'),
			"id"	 			=> array("Site ID", true),
		);
    }    
	
    function getKey()
    {
    	return "id";
    }	
	
   function setSelectActions()
    {
    	
    	$label 		= "Edit Site";
    	$action		= "edit";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
 		
 		$label 		= "Delete Site";
    	$action		= "delete";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    	
    	$label		= "Reset Site";
    	$action		= "reset";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
  
  		$label		= "Diff Site";
    	$action		= "diff";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
  
    }	
    
    function setTextActions()
    {
    	$label 		= "Create New Site";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    
    	$label 		= "Audit Sites";
    	$action		= "audit";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    	
    	$label 		= "Reset All Sites";
    	$action		= "resetAll";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
        
    }
    
    function changedValue($params)
	{
		if($params['changed'] == 1){
			return "<font color='red'><b>CHANGED!</font> <a href='index.php?mod=".$_REQUEST['mod']."&id=".$params['id']."&action=diff'> [View Diff]</a></font>";
		}else
			return "<font color='green'>UNCHANGED</font>";
	}
    
    function drawFormEditSite()
    {
    	$this->loadSiteInfo($_REQUEST[$this->getKey()]);
    	$this->addContent('diffSite_edit');
    	return true;
    }
    
    function processUpdateSite()
    {
    	$params['name'] = $_REQUEST['name'];
    	$params['url'] = $_REQUEST['url'];
    	$sqlUpdate = _updateAssociative($params);
    	$sql = "UPDATE cs_diffTable SET " . $sqlUpdate . " WHERE id = " . $_REQUEST[$this->getKey()];
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    function drawFormCreateSite()
    {
    	$this->addContent('diffSite_create');
    	return true;
    }
    
    function resetAll()
    {
    
    	$sql = "UPDATE cs_diffTable set changed = 0";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	$sql = "SELECT * FROM cs_diffTable WHERE deleted != 1";
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	while(!$rs->EOF){
    		$this->replaceSite($rs->fields['id']);
    		$rs->MoveNext();	
    	}
    	return false;
    }
    
    function processCreateSite()
    {
		$curlOut = $this->fetchCurlString($_REQUEST['url']);	
 		if($curlOut == ""){
 			_setMessage("URL does not exist!", true);
 		}else{
 		
	    	$params = array(
				'url' => $_REQUEST['url'],
				'name' => $_REQUEST['name'],
				'content' => $curlOut,
			);	
			
	    	$sql = "INSERT INTO cs_diffTable " . _insertAssociative($params);
	    	//echo $sql ."<br>";
	    	_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
 		}
    }
    
    
    function processDelete()
    {
		if(($ids = $this->returnIds()) == false)
            return false;
			
		$sqlIDs = "('" . implode("','", $ids) . "')";
    
		$sql = "UPDATE cs_diffTable SET deleted = 1 WHERE id IN " . $sqlIDs;
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE); 
      
        return false;
    } 
    
    function loadSiteInfo($id)
    {
		$sql = "SELECT * FROM cs_diffTable WHERE id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$_POST['name'] 	= $rs->fields['name'];
		$_POST['url'] 	= $rs->fields['url'];
		$_POST['id'] 	= $rs->fields['id'];
    }   
        
    
	
	function auditSites()
	{
		
		
		$sql = "SELECT * FROM cs_diffTable WHERE deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$ids = array();
		
		while($rs && $rs->fields){
			set_time_limit(30);
			$ignoredLines = $this->getIgnoredLines($rs->fields['id']);
			//print_r($ignoredLines);
			$equal = true;
			$curlArray = $this->fetchCurlArray($this->removeBlankLines($rs->fields['url']));
			//echo "FOO";
			$fDiff = new csCore_Util_Diff($this->fetchContentArray($this->removeBlankLines($rs->fields['content'])), $curlArray);
			$diffArray = $fDiff->findDiff(true);
			if(count($diffArray) > 0){
				if($this->diffOnContent){
					foreach($diffArray as $line => $array){
						//echo "checking..." . $line;
						if(in_array($line, $ignoredLines)){
							//echo "IGNORING LINE " . $line . "<Br>";
							continue;
						}
						$t1 = str_replace(" ", "", $array[1]);
						$t2 = str_replace(" ", "", $array[2]);
						if(strip_tags(html_entity_decode($t1) != strip_tags(html_entity_decode($t2)))){
							$ids[] = $rs->fields['id'];
							$equal = false;
						}
						if(!$equal){
							break;
						}
					}
				}else{
					$ids[] = $rs->fields['id'];
				}
				
			}
			$rs->MoveNext();
		}
		$sql = "UPDATE cs_diffTable SET changed = 1 WHERE id in " . _array2paren($ids, "'"); 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	function showDiff($id)
	{
		$sql = "SELECT * FROM cs_diffTable WHERE id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$curlArray = $this->fetchCurlArray($rs->fields['url']);
		
		$ignoredLines = explode(' ', $rs->fields['ignoreLines']);
		
		$fDiff = new csCore_Util_Diff($this->fetchContentArray($this->removeBlankLines($rs->fields['content'])), $curlArray, $ignoredLines);
	
		$diffArray = $fDiff->findDiff(true);

		$this->assignValue('cardName', $rs->fields['name']);
		$this->assignValue('diffArray', $diffArray);
		$this->assignValue('ignoredLines', $ignoredLines);
		$this->addContent('showdiff');

		return true;
	}
	
	function replaceSite($id)
	{
		$sql = "SELECT url FROM cs_diffTable WHERE id = " . _q($id);
	
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$curlOut = $this->removeBlankLines($this->fetchCurlString($rs->fields['url']));
				
			
		$sql = "UPDATE cs_diffTable set changed = 0, content = "._q($curlOut) .", changed = '0' WHERE id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	function prepareCurlData($str)
	{
		$str = str_replace("'", "", $str);
		//$str = str_replace(" ", "", $str);
		$str = strtolower($str);
		return textScrub($str);
	}
	
	function fetchCurlString($url)
	{
		$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
		
		$curlOut = "";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		$curlOut = curl_exec($ch);
		curl_close($ch);
		
		//echo "out: " . htmlentities($curlOut);
		
		return  $this->removeBlankLines($this->prepareCurlData($curlOut));
	}
	
	function fetchCurlArray($url)
	{
		$curlOut = $this->fetchCurlString($url);
		return @explode("\n", $curlOut);
	}
	
	function fetchContentArray($content)
	{
		return @explode("\n", $content);
	}
	
	function addToIgnore($id, $line)
	{
		$sql = "SELECT ignoreLines FROM cs_diffTable WHERE id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$ignoreLine = trim($rs->fields['ignoreLines']) . " " . $line;
		$sql = "UPDATE cs_diffTable set ignoreLines = " . _q($ignoreLine) . " WHERE id = " ._q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		//echo $sql;
		return $this->showDiff($id);
	
	}
	
	function removeFromIgnore($id, $line){
		$sql = "SELECT ignoreLines FROM cs_diffTable WHERE id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$lines = explode(' ', $rs->fields['ignoreLines']);
		$newLines = '';
		foreach($lines as $curline){
			if((int)$line != (int)$curline){
				$newLines .= $curline . ' ';
			}
		}
		$sql = "UPDATE cs_diffTable set ignoreLines = " . _q($newLines) . " WHERE id = " ._q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		//echo $sql;
		return $this->showDiff($id);
		
	}
	
	function getIgnoredLines($id)
	{
		$sql = "SELECT ignoreLines FROM cs_diffTable WHERE id = " . _q($id);
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$ret = explode(' ', trim($rs->fields['ignoreLines']));
		if(is_array($ret)){
			
			
			return $ret;
		}
		return array();
	}
	
	function getChangedString($valArray)
	{
		$val = $valArray['changed'];
		$map = array(0 => '<font color=green>Unchanged</font>', 1 => '<font color=red>Changed</font>');
		
		
		return $map[(int)$val];
	}
	
	function getLink($valArray)
	{
		$link = $valArray['url'];	
		
		return "<a target=_BLANK href='$link'>".$valArray['name']."</a>";
	}
	
	function removeBlankLines($string)
	{
		return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
	}	
}
?>