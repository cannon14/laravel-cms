<?php

/**
 *
 * ClickSuccess, L.P.
 * March 23, 2006
 *
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 *
 */


csCore_Import::importClass('csCore_UI_restrictedPage');
csCore_Import::importClass('csCore_UI_action');
csCore_Import::importClass('csCore_UI_filter');
csCore_Import::importClass('csCore_UI_formItem');

class csCore_UI_restrictedDBList extends csCore_UI_restrictedPage
{
	var $filter;
	var $columns;
	var $style = array(
						"ASC" 	=> "bgcolor='#F0FFF0'",
						"DESC" 	=> "bgcolor='#FFE4E1'",
				      );

	var $selectActions;
	var $textActions;
	var $sql;
	var $where = " WHERE deleted != 1 ";
	var $keys = array();


	function setColumns()
	{
		return array();
	}

	function setSelectActions()
	{
		return array();
	}

	function setTextActions()
	{
		return array();
	}

	function _applySort()
	{
		$orderBy = "";
		if(isset($_SESSION[SORT_SESSION]) && is_array($_SESSION[SORT_SESSION])){
			foreach($_SESSION[SORT_SESSION] as $sort){
				if(array_key_exists($sort['col'], $this->getColumns())){
					if($orderBy != "")
						$orderBy .= ", ";
					$orderBy  .= $sort['col'] . " " . $sort['dir'] . " ";
				}
			}
		}
		if($orderBy != "")
			$orderBy = " ORDER BY " . $orderBy;
		$this->_setSortStyle();
		return $orderBy;
	}


	function _addSort($sortby, $dir)
	{

		$this->_killSort($sortby);
		$_SESSION[SORT_SESSION][] = array(
											"col" => $sortby,
											"dir" => $dir,
										);
	}

	function _killSort($sortKill)
	{
		$i = -1;
		if(isset($_SESSION[SORT_SESSION]) && is_array($_SESSION[SORT_SESSION]))
		foreach($_SESSION[SORT_SESSION] as $sort){
			++ $i;
			if($sort["col"] == $sortKill){
				$_SESSION[SORT_SESSION][$i] = null;
			}
		}
	}

	function _setSortStyle()
	{
		$styleArray = array();
		if(!isset($_SESSION[SORT_SESSION]) || !is_array($_SESSION[SORT_SESSION]))
			return;
			
		foreach($_SESSION[SORT_SESSION] as $s){

			$styleArray[$s['col']] = isset($this->style[$s['dir']]) ? $this->style[$s['dir']] : '';
		}
		$this->assignValue('styleArray', $styleArray);
	}

	function drawSelectActions($objectArray)
	{
		if(is_array($this->selectActions) && count($this->selectActions) > 0){

			$selectString = "<select name='action' OnChange=\"performAction(this);\">\n";


			$selectString .= "<option value=''>Select an Action</option>\n";
			$selectArray = $this->selectActions;
			foreach($selectArray as $label => $action){

				$vars = array();

				foreach($action->vars as $key => $val){
					$vars[$key] = $objectArray[$val];
				}
				$selectString .= "<option value=\"javascript:".$action->action."Object('".implode("','", array_values($vars))."');\">".$action->label."</a>\n";
			}
			$selectString .= "</select>\n";
			$this->assignValue('selectActions', true);
			return $selectString;
		}
    }

    function drawTextActions()
    {
    	$retString = '';
    	foreach((array)$this->textActions as $label => $action){
    		$retString .= "<a class='white' href='index.php?mod=".$_REQUEST['mod']."&action=".$action->action."'>".$action->label."</a> | ";
    	}
    	$this->assignValue("textActions", $retString);
    }

    function showData()
    {
    	$this->initFilter();

    	$this->initSql();
    	$this->setSql();
    	$this->setPaging();
    	$this->initPaging();
    	$this->setSelectActions();
    	$this->setTextActions();

    	if(isset($_REQUEST['sortby'])){
			$dir = strtoupper($_REQUEST['sort']);
			if($dir != "ASC" && $dir != "DESC")
				$dir = "ASC";
			$this->_addSort($_REQUEST['sortby'], $dir);
		}

		if(isset($_REQUEST['killSort'])){

			$this->_killSort($_REQUEST['killSort']);
		}

		if(isset($_REQUEST['removeAllSorts'])){
			unset($_SESSION['sortArray']);
		}


    	if(is_array($this->getTextActions()) && count($this->getTextActions()) > 0){
    		$this->assignValue('textActions', $this->getTextActions());
    	}

    	$this->sql .= $this->whereOrderBy();
    	//echo $this->sql . "<br>";

    	if($this->limitOffset === null || $this->numRows === null){
    		$rs = _sqlQuery($this->sql, __LINE__, __FILE__, DEBUG_MODE);
    	}else{
    		$rs = _sqlSelectLimit($this->sql, $this->limitOffset, $this->numRows, __LINE__,__FILE__, DEBUG_MODE);
    	}

		$selectArray =array();


		while($rs && !$rs->EOF){
			$selectArray[$rs->fields[$this->getKey()]] = $this->drawSelectActions($rs->fields);
			$rs->MoveNext();
		}

		$this->createActionListeners();
		$this->drawTextActions();

    	if($this->limitOffset === null || $this->numRows === null){
    		$rs = _sqlQuery($this->sql, __LINE__, __FILE__, DEBUG_MODE);
    	}else{
    		$rs = _sqlSelectLimit($this->sql, $this->limitOffset, $this->numRows, __LINE__,__FILE__, DEBUG_MODE);
    	}
    	$this->columns = $this->getColumns();
    	//echo "Size " . count($this->columns);

    	$data = array();
    	while($rs && !$rs->EOF){
    		foreach($rs->fields as $col => $val){
    			if(isset($this->columns[$col][3]) && $this->columns[$col][3] != ""){

    				$expr = '$this->'.$this->columns[$col][3].'($rs->fields);';
    				eval('$rslt = ' . $expr);
    				$rs->fields[$col] = $rslt;
    			}
    		}
    		$data[] = $rs->fields;
    		$rs->MoveNext();
    	}

    	$this->selectArray = $selectArray;

    	$this->assignValue('filter', $this->getFilter());
    	$this->assignValue('data', $data);
    	//$this->assignValue('selectArray', $selectArray);
    	$this->assignValue('key', $this->getKey());
    	$this->assignValue('columnData', $this->columns);
    	$this->assignValue('controller', $this);
    	$this->addContent('DBList', GLOBAL_TEMPLATES);
    }

    function createActionListeners()
    {
    	$javaScript = "";
    	$actions = (array)$this->selectActions + (array)$this->textActions;
    	if(is_array($actions))
    	foreach((array)$actions as $label => $action){
    		$javaScript .= "function ".$action->action."Object(".implode(", ",array_keys($action->vars)).")\n{\n";

			if($action->confirm){
				if($action->message == null)
					$javaScript .= "\tif(confirm('". $action->label . "?'))\n";
				else
					$javaScript .= "\tif(confirm('". $action->message . "'))\n";
			}
			$javaScript .= "\tdocument.location.href = 'index.php?mod=".$_REQUEST['mod']."&action=".$action->action;

			foreach((array)$action->vars as $var){
				$javaScript .= "&$var=' + $var";
			}

			foreach((array)$this->filter->items as $item){
				$javaScript .= " + '&".$item->params['name'] . "=" . $item->params['value'] ."'";
			}

			$javaScript .= ";\n";
			$javaScript .= "}\n";
		}
		$this->assignValue('actionListeners', $javaScript);
    }

    function getSelectActions()
    {
    	$retArray = array();
    	foreach($this->selectActions as $action){
    		$retArray[$action->label] = $action->makeArray();
    	}
		return $retArray;
    }

    function getTextActions()
    {
    	$retArray = array();
    	if(is_array($this->textActions))
    	foreach($this->textActions as $action){
    		$retArray[$action->label] = $action->makeArray();
    	}
		return $retArray;
    }

    function whereOrderBy()
    {
    	$where = $this->where;
    	$orderBy = $this->_applySort();

    	return $where.$orderBy;
    }

    function returnIds()
    {
        if(isset($_POST['massaction']) && $_POST['massaction'] != ''){
            $ids = $_POST['itemschecked'];
        }
        else{
            $ids = array($_REQUEST[$this->getKey()]);
        }
        return $ids;
    }

    function getTotalNumberOfRecords($sql)
    {
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

    	return $rs->fields['count'];
    }

    function initPaging()
    {
    	$this->limitOffset = _sqlInitPaging($this->getTotalNumberOfRecords($this->paging.$this->where));
    	$this->numRows = $_SESSION[FILTER_SESSION]['numrows'];
    }

    function setPaging()
    {

    }

    function initFilter()
    {

    	$this->filter = new csCore_UI_filter();

    	$this->filter->addItem(new csCore_UI_formHidden(array('name' => 'mod',
    															'value' => isset($_REQUEST['mod']) ? $_REQUEST['mod'] : '')));
    	$this->filter->addItem(new csCore_UI_formHidden(array('name' => 'sortby',
    															'value' => isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : '')));
  		$this->filter->addItem(new csCore_UI_formHidden(array('name' => 'sort',
    															'value' => isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '')));
  		$this->filter->addItem(new csCore_UI_formHidden(array('name' => 'list_page',
    															'value' => isset($_REQUEST['list_page']) ? $_REQUEST['list_page'] : '')));
  		$this->filter->addItem(new csCore_UI_formHidden(array('name' => 'killSort',
    															'value' => '')));
    	$options = array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100, 1000 => 1000, 999999 => 'ALL');
    	$this->filter->addItem(new csCore_UI_formSelect(array('name' => 'numrows',
    														'default'	=> 20,
															'options' => $options,
    														'value' => isset($_REQUEST['numrows']) ? $_REQUEST['numrows'] : '',
															'label' => 'Num Rows: ')));

		$this->setFilter();

		if($this->filter->getTitle() == ''){
			$this->filter->setTitle($_REQUEST['mod']);
		}

		$this->filter->addItem(new csCore_UI_formSubmitButton(array('name'=>'submit',
																	'value' => 'SEARCH')));
    }

    function setFilter()
    {

    }

    function &getFilter()
    {
    	return $this->filter;
    }

    function initSql()
    {
    	foreach($this->getColumns() as $key => $valArray){
    		if(isset($valArray[2]) && $valArray[2] != ''){
    			$this->keys[] = $valArray[2].".".$key;
    		}else
    			$this->keys[] = $key;
    	}
    }

    function getMouseOverStyle($row)
    {
    	return 'listresultMouseOver';
    }

    function getMouseOutStyle($row)
    {
    	return 'listresult';
    }

    function printActions($key, $object)
    {
    	//print_r($this->selectArray);
		return $this->selectArray[$key];
    }
}



?>
