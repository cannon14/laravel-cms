    <form action='index.php'>
    <table class='component' align='center'>
	<tr>
	<td class='componentHead' colspan=2>
	Update Site
	</td>
	</tr>	    
	
    <tr>
      <td align="left">&nbsp;Site Name&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='name' size='80' value='<?= $_POST['name']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>	    
      <tr>
      <td align="left">&nbsp;Site URL&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='url' size='80' value='<?= $_POST['url']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=id value='<?=$_POST['id']?>'>
      <input class=formbutton type=submit value="UPDATE"> 
	 <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
         
      </td>
    </tr> 
    </table>
  </form>
