<script>
function cancelAction(){
  	document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>";
		
}
</script>
<form action=index.php>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>
Update Amenity
</td>
</tr>
<tr>
<td>Amenity label: </td><td><input type="text" name="label" value="<?=$this->data['label']?>" size="60"/></td>
</tr>
<tr>
<td valign=top>
Description:
</td>
<td>
<textarea name="description" rows=20 cols=60>
<?=$this->data['description']?>
</textarea>
</td>
</tr>
<tr>
<td colspan=2 align='center'>
<input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
<input type=hidden name=action value="processUpdateAmenity">
<input type=hidden name=amenityid value="<?=$this->amenityid?>">
<input type="submit" value="Update Amenity">
<input type="button" onClick="javascript:cancelAction();" value="Cancel">
</td>
</tr>
</table>
</form>
