<table class='component' align='center' border="2">
	<tr>
		<td colspan="2" class='componentHead'>Edit Redirect</td>
	</tr>
	<tr>
		<td>Site</td>
		<td><select name='site_id' id='site_id'>
			<?php
			    foreach($this->sites as $site){
			        $selected = $_REQUEST['siteId'] == $site->fields['siteId'] ? 'selected' : '';
			        print '<option value="' . $site->fields['siteId'] . '" ' . $selected . '>' . $site->fields['siteName'] . '</option>';
			    }
			?>
		</select></td>
	</tr>
	<tr>
		<td>Filename (without extension)</td>
		<td><input type='text' name='filename' id='filename' value='<?=$_REQUEST['filename']?>'></td>
	</tr>
	<tr>
		<td>Destination Url</td>
		<td><input type='text' name='destination_url' id='destination_url' value='/'></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<button class="formbutton" type="button" onclick="createRedirect();">Create Redirect</button>
		</td>
	</tr>
</table>