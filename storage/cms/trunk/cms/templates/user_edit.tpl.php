  <form action=index.php method=post name=update>
  
    <table class='component' align='center'>
	<tr>
	<td colspan=2 class='componentHead'>
	Edit User
	</td>
	</tr>
	<tr>
	<td>Username</td><td><?=$this->username?></td>
	</tr>
	<tr>
	<td>Password</td><td><input type='password' name='password'></td>
	</tr>	
	<tr>
	<td>Confirm Password</td><td><input type='password' name='password2'></td>
	</tr>
	<tr>
	<td>First Name</td><td><input type='text' name='firstName' value='<?=$this->firstName?>'></td>
	</tr>				
	<tr>
	<td>Last Name</td><td><input type='text' name='lastName' value='<?=$this->lastName?>'></td>
	</tr>	
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value=edit>
      <input type=hidden name=userid value='<?=$_REQUEST['userid']?>'>
      <input type=hidden name=commited value=1>
      <input class=formbutton type=submit value="SAVE">   
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
      </td>
    </tr> 
    </table>
  </form>
</center>
