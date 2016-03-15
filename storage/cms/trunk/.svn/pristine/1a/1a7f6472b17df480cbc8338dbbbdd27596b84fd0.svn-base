<script>
<?=$this->actionListeners?>
</script>

<?PHP if($this->filter != '') {
	$this->filter->write();	
}
?>
<table width='100%' class=textAction>
<tr>
<td>
<?
if($this->textActions != null){
echo $this->textActions;
?>
<? } ?>
</td>
</tr>
</table>
<table width='100%' class=dbList>
<tr>
<td colspan=100 class='listResult' align='left'>
<? if($_REQUEST['list_pages'] < 1){
	$_REQUEST['list_pages'] = 1;
} ?>
<?if($_REQUEST['list_page'] > 0) { ?><a href='javascript: filterform.list_page.value=<?=($_REQUEST['list_page'] - 1)?>; filterform.submit();'>&lt;&lt;</a><? } ?> Page <?=$_REQUEST['list_page'] + 1?> of <?=$_REQUEST['list_pages']?> <?if($_REQUEST['list_page']+1 < $_REQUEST['list_pages']) { ?><a href='javascript: filterform.list_page.value=<?=($_REQUEST['list_page'] + 1)?>; filterform.submit();'>&gt;&gt;</a><? } ?>
</td>
</td>
</tr>
<tr>
<?php
if(isset($this->selectActions)){
?>
<td nowrap class='listHead'>Action<br><br></td>
<?PHP	
}
foreach($this->columnData as $col => $data){
	if($data != null){
?>
<td nowrap class='listHead'> <?=$data[0]?> <br> <?if($data[1]){ ?>[<a  href='javascript: filterform.sortby.value="<?=$col?>"; filterform.sort.value="ASC"; filterform.list_page.value="<?=$_REQUEST['list_page']?>"; filterform.submit();'>ASC</a> | <a  href='javascript: filterform.sortby.value="<?=$col?>"; filterform.sort.value="DESC"; filterform.list_page.value="<?=$_REQUEST['list_page']?>"; filterform.submit();'>DESC</a> | <a  href='javascript: filterform.killSort.value="<?=$col?>"; filterform.list_page.value="<?=$_REQUEST['list_page']?>"; filterform.sortby.value=""; filterform.sortby.sort=""; filterform.submit();'>NONE</a>] <? }else{ ?><br> <?PHP }?></td>
<?PHP
	}
}
?>
</tr>
<?PHP

//while($this->data && !$this->data->EOF){
	
if(is_array($this->data)) 
foreach($this->data as $object){
?>
<tr onMouseover="this.className='<?=$this->controller->getMouseOverStyle($object)?>'" onMouseOut="this.className='<?=$this->controller->getMouseOutStyle($object)?>';">
<?php
if($this->selectActions){
?>
<td class='listResult'><?=$this->controller->printActions($object[$this->key], $object)?></td>
<?PHP	
}
	foreach($object as $col=>$data){
		
		
		if(array_key_exists($col, $this->columnData) && $this->columnData[$col] != null){
?>
<td class='<?=$this->controller->getMouseOutStyle($object)?>' 
	nowrap <?= isset($this->styleArray[$col]) ? $this->styleArray[$col] : '' ?>>
		&nbsp;<?=$data?>&nbsp;
</td>
<?PHP
		}
	}
?>
</tr>
<?PHP
//$this->data->MoveNext();
}
?>
<tr>
</tr>

</table>

