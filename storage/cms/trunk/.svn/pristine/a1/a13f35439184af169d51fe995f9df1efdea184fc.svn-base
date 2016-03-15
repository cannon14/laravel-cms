
  <form action=index.php method=post name=update>
  
    <table class='component' align='center'>
	<tr>
	<td colspan=2 class='componentHead'>
	Create Version
	</td>
	</tr>
    <tr>
     <td align=left nowrap>&nbsp;Version Name</td>
     <td align=left>
        <input type=text name=version_name size=40 value=''>
     </td>
    </tr>   
     	   
    <tr>
      <td align="left">&nbsp;Version Description;</td>
      <td align="left"><TEXTAREA NAME="version_description" COLS=80 ROWS=6></TEXTAREA></td>
    </tr>   
   
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['action']?>>
      <input class=formbutton type=submit value="SAVE">   
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
      </td>
    </tr> 
    </table>
  </form>
</center>
<script>
    function showHide(control, id){
        var elmnt = document.getElementById(id);
        var ctrl = document.getElementById(control);
        elmnt.style.display = ctrl.checked == false?"none":"inline";
    }
    showHide("landingPage", "landingPageOptions");
</script>