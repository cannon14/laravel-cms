<?php
/*
 * Created on Jul 17, 2006
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>
<br>
<br>
<form action="index.php?mod=<?=$_REQUEST['mod']?>" method="post">
<table class=component align='center'>
	<tr>
		<td class=componentHead colspan=2>Publish Sorting Database</td>
	</tr>
	<tr>
		<td width = 40%>Select site for database sync:</td>
		<td>
			<select name="site">
			<?foreach($this->sites as $site){ 
			$sel = "";
			if($site->fields['siteId'] == $_REQUEST['site'])
				$sel = "selected";	
			echo "<option value='".$site->fields['siteId']."' $sel>".$site->fields['siteTitle']."</option>";	
			}?>
	  		</select>
		</td>
	</tr>
	<tr>
		<td>Database Username:</td>
		<td><input type='text' name=dbuser></td>
	</tr>
	<tr>
		<td>Database Password:</td>
		<td><input type='password' name=dbpass></td>
	</tr>
	<tr>
		<td colspan=2 align='center'>
  			<input type="submit" name="submit" value="Publish"/>
		</td>
	</tr>
</table>
<input type='hidden' name='action' value='prepare'>
</form>
<?if($this->output){?>
<table class=component align='center'>
	<tr>
		<td class=componentHead colspan=2>Database Publish Console</td>
	</tr>
	<tr>
		<td align='center'>
			<textarea cols='80' rows='20' readonly style="color:black; background-color:white;" wrap=off><?=$this->output?></textarea>
		</td>
	</tr>
</table>
<?}?>
