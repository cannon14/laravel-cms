

<br><br>

<form action="index.php?mod=<?=$_REQUEST['mod']?>" method="post">
  
<table class=component align='center' width=100%>
<tr>
<td class=componentHead colspan=2>
Export site to XML
</td>
</tr>
<tr>
	<td align="right" width=50%>Select site to export:</td>
	<td align="left" width=50%>
	  <select name="site">
	    
		<?PHP foreach($this->sites as $site){ 
			$sel = '';
			if($site->fields['siteId'] == $_REQUEST['site'])
				$sel = 'selected';	
		?>
			
		<option value="<?=$site->fields['siteId']?>" <?=$sel?>><?=$site->fields['siteTitle']?></option>	
		<?PHP } ?>
	  </select>
	</td>
</tr>
<tr>
	<td align="right" width=50%>Include inactive cards:</td>
	<td align="left" width=50%><input type="checkbox" name="includeInactive" value=1 /></td>
</tr>
<tr>
	<td colspan=2 align='center'>
	  <input type="hidden" name="export" value="1"/>
	  <input type="submit" name="submit" value="EXPORT"/>
	</td>
</tr>
</table>
</form>


	<script type="text/javascript" src="tree/tree.js"></script>
	<script type="text/javascript">
		<!--
		var Tree = new Array;
		// nodeId | parentNodeId | nodeName | nodeUrl
		
<?=$this->tree?>
		//-->
	</script>
<?if($this->tree != null){ ?> 
<table class=component align='center'>
<tr>
<td class=componentHead colspan=2>
Tree View
</td>
</tr>
<tr>
<td width='35%'>
</td>
<td >	
	<div class="tree">
	<script type="text/javascript">
	<!--
		createTree(Tree,1);  
	//-->
	</script>
	</div>
</td>
</tr>
</table>
<? } ?>
