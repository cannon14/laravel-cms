<script>
function cancelAction(){
  	document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>";
		
}
</script>

<form action=index.php>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>
Add Card Category Group
</td>
</tr>
<tr>
<td>Category Group Name: </td><td><input type="text" name="card_category_group_name" value="<?=$_REQUEST['card_category_name']?>" size="60"/></td>
</tr>
<tr>
<td colspan=2 align='center'>
<input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
<input type=hidden name=action value="processCreateCardCategoryGroup">
<input type="submit" value="Add Card Category Group">
<input type="button" onClick="javascript:cancelAction();" value="Cancel">
</td>
</tr>
</table>
</form>