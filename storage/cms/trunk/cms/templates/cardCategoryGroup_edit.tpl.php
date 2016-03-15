<script>
function cancelAction(){
  	document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>";
		
}
</script>
<form action=index.php>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>
Update Card Category Group
</td>
</tr>
<tr>
<td>Category Group Name: </td><td><input type="text" name="card_category_group_name" value="<?=$this->data['card_category_group_name']?>" size="60"/></td>
</tr>
<tr>
<td colspan=2 align='center'>
<input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
<input type=hidden name=action value="processUpdateCardCategoryGroup">
<input type=hidden name=card_category_id value="<?=$this->id?>">
<input type="submit" value="Update Card Category Group">
<input type="button" onClick="javascript:cancelAction();" value="Cancel">
</td>
</tr>
</table>
</form>
