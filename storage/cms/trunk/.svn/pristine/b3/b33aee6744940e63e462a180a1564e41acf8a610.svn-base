<form action=index.php method=post name=update>
<table class='component' align='center' border="2">
	<tr>
		<td colspan=2 class='componentHead'>Edit Redirect</td>
	</tr>
	<tr>
		<td>Site</td>
		<td>
			<select name='site_id'>
				<?php
				    foreach($this->sites as $site){
				        $selected = $this->site_id == $site->fields['siteId'] ? 'selected' : '';
				        print '<option value="' . $site->fields['siteId'] . '" ' . $selected . '>' . $site->fields['siteName'] . '</option>';
				    }
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Filename (without extension)</td>
		<td><input type='text' name='filename' value='<?=$this->filename?>'></td>
	</tr>	
	<tr>
		<td>Destination Url</td>
		<td><input type='text' name='destination_url' value='<?=$this->destination_url?>'></td>
	</tr>	
	<tr>
		<td colspan=2 align=center>
			<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
			<input type=hidden name=action value="<?= $this->redirect_id != '' ? 'edit' : 'create' ?>">
			<input type=hidden name=redirect_id value='<?=$this->redirect_id?>'>
			<input type=hidden name=commited value=1>
			<input class=formbutton type=submit value="SAVE">   
			<input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
  		</td>
	</tr> 
</table>
</form>