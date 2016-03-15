<script src="../cmsCore/include/csCore/JS/scriptaculous/prototype.js" type="text/javascript"></script>
<script src="../cmsCore/include/csCore/JS/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	function populateHiddenVars()
	{
		document.getElementById('draggableListOrder').value = Sortable.serialize('draggableList');
		return true;
	}

</script>
<center>
<form action="index.php" method="GET" onSubmit="populateHiddenVars();" name="draggableListForm" id="draggableListForm">
		<input type="hidden" name="draggableListOrder" id="draggableListOrder" size="60">
		<input type="hidden" name="draggableListsSubmitted" value="true">
		<input type="hidden" name="mod" value="<?=$_REQUEST['mod']?>">
		<input type='hidden' name='pageId' value='<?=$this->pageId?>'>
		<input type='hidden' name='siteId' value='<?=$this->siteId?>'>
<br>
<input type='submit' value='Commit Changes'>
<br><br>
<input type='button' value='BACK' onClick="window.location='<?=$this->returnlink?>'">
</center>
<div>
<div style="float:center;">

<!-- Begin List //-->

<?PHP
	echo $this->draggable->render();
?>

<!-- End List //-->

</div>		
</div>
</form>
</center>
<script type="text/javascript">
 	// <![CDATA[
    Sortable.create("draggableList",
     {tag:'li', dropOnEmpty:true,handle:'handle',containment:["draggableList"],constraint:false});

 	// ]]>
 	</script>
