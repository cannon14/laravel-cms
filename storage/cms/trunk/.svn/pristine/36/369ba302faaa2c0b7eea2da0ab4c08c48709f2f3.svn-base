<br>
<form action="index.php?mod=<?=$_REQUEST['mod']?>&action=ftp" method="post">
  
<table class=component align='center'>
<tr>
<td class=componentHead colspan=2>
Publish FTP Site
</td>
</tr>
<tr>
<td>
Select site to publish:
</td>
<td>

  <select name="sites[]">
    
	<?PHP if(is_array($this->ftpsites))foreach($this->ftpsites as $site){ 
		$sel = "";
		if($site->fields['siteId'] == $_REQUEST['sites'])
			$sel = "SELECTED";	
	?>
	<option value="<?=$site->fields['siteId']?>" <?=$sel?>><?=$site->fields['siteTitle']?></option>	
	<?PHP } ?>
  </select>
  
</td>
</tr>
<tr>
<td>
	<?//if($this->ftp){
	?>
	FTP Username: </td><td><input value="<?= isset($_REQUEST['ftp_user']) ? $_REQUEST['ftp_user'] : '' ?>" type=input name=ftp_user><br>
</td>
</tr>
<tr>
<td>
	Password: </td><td><input type=password name=ftp_pass><br>
	<input type=hidden name=committed value=1>
	<?	
	//}
	?>
</td>
</tr>
<tr>
<td colspan=2 align='center'>
  <input type="hidden" name="publish" value="1"/>
  <input type="submit" name="submit" value="PUBLISH"/>
</td>
</tr>
</table>
</form>

<?if(isset($this->ftpconsole)){ ?>
<table align="center" class=component> 
	    <tr>
	    <td class="fctitle_blue">
	    FTP Console 
	    </td>
	    </tr>
	    <tr>
	    <td>
	    <div style="width:100%; height:100px; background-color:#ffffff; overflow:auto;">
	    <?=$this->ftpconsole?>
	    </td></tr></table></div>
<? } ?>
<br><br>

<form action="index.php?mod=<?=$_REQUEST['mod']?>&action=script" method="post">
  
<table class=component align='center'>
<tr>
<td class=componentHead colspan=2>
Publish Sync Script Site
</td>
</tr>
<tr>
<td>
Select site to publish:
</td>
<td>

  <select name="sites[]" size=20 multiple>
    
	<?PHP if(is_array($this->scriptsites))foreach($this->scriptsites as $site){ 
		$sel = "";
		if(isset($_REQUEST['site']) && $site->fields['siteId'] == $_REQUEST['site'])
			$sel = "SELECTED";	
	?>
	<option value="<?=$site->fields['siteId']?>" <?=$sel?>><?=$site->fields['siteTitle']?></option>	
	<?PHP } ?>
  </select>
  
</td>
</tr>
<tr>
<td colspan=2 align='center'>
  <input type="hidden" name="publish" value="1"/>
  <input type="submit" name="submit" value="PUBLISH"/>
</td>
</tr>
</table>
</form>

<?if($this->scripts != null){ ?>
<table align="center" class=component> 
	    <tr>
	    <td class="fctitle_blue">
	    Publish Results 
	    </td>
	    </tr>
	    <tr>
	    <td>
	    <div style="width:100%; height:100px; background-color:#ffffff; overflow:auto;">
	    <?foreach($this->scripts as $script)echo $script->getOutput('<br>')?>
	    </td></tr></table></div>
<? } ?>


	<script type="text/javascript" src="tree/tree.js"></script>
	<script type="text/javascript">
		var Tree = new Array;

<?=isset($this->tree) ? $this->tree : ''?>
		//-->
	</script>
<? if(isset($this->tree)) { ?>

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
		createTree(Tree, 1);  
	//-->
	</script>
	</div>
</td>
</tr>
</table>
<? } ?>