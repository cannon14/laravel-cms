

<br><br>
<form action="index.php?mod=<?=$_REQUEST['mod']?>" method="post">  
<table class=component align='center' border=0>
<tr>
<td class=componentHead>Publish Site(s) to ccbuild</td>
</tr>
<tr>
<td align="center">
  <select name="site[]" size=20 multiple>
	<?PHP foreach($this->sites as $site){ 
	    $sel = isset($_REQUEST['site']) && $site->fields['siteId'] == $_REQUEST['site'] ? 'selected' : '';	
	?>
	<option value="<?=$site->fields['siteId']?>" <?=$sel?>><?=$site->fields['siteTitle']?></option>	
	<?PHP } ?>
  </select>
</td>
</tr>
<tr>
<td align="center">
<input type="hidden" name="publish" value="1"/>
<input type="submit" name="submit" value="PUBLISH"/>
</td>
</tr>
</table>
</form>


<? if(isset($this->script)) { ?>
<table class=component align='center'>
<tr>
<td class=componentHead colspan=2>
<?=$this->script->script?>
</td>
</tr>
<tr>
<td colspan=2>	
<?=$this->script->getOutput('<br>')?>
</td>
</tr>
</table>	
	
<? } ?>