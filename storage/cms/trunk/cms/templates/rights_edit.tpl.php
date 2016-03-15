  <form action=index.php method=post name=update>
  
    <table class='component' align='center'>
	<tr>
	<td colspan=2 class='componentHead'>
	Rights for <?=$this->username?>
	</td>
	</tr>
	<tr>
	</tr>
	
	<? foreach($this->allRights as $id => $data){ ?>
	
	<tr>
	<td width='25%'><?=$data['label']?></td><td><input type='checkbox' <?=(in_array($id, $this->usersRights)) ? "checked" : ""?> value=1 name='<?=$id?>'></td>
	</tr>	
	
	<? } ?>
	
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value=setRights>
      <input type=hidden name=userid value='<?=$this->userid?>'>
      <input type=hidden name=commited value=1>
      <input class=formbutton type=submit value="SAVE">   
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
      </td>
    </tr> 
    </table>
  </form>
</center>