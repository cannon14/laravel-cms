<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>

Select Group
</td>
</tr>
<tr>
<td align='center'>
<br>
<b>Group: </b>
<select name='group'>
<option>
-----------------------
</option>
  <input type="submit" name="change" value="Change"/>
</select>
<br><br>
</td>
</tr>
</table>
<br>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=4>
Set Permissions
</td>
</tr>
<td align='center'><b>Active</td><td><b>Module Label</td><td><b>Class Name</td><td><b>File Name</td>
<?php
foreach($this->modules as $module){
?>
<tr>
<td align='center'><input type='checkbox'></td><td><?=$module['modulelabel']?></td><td><?=$module['classname']?></td><td><?=$module['filename']?></td>
</tr>
<?PHP
}
?>
</table>
