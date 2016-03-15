<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=1>
    <? //QUnit_Templates::printFilter(3, "Create Category"); ?>  
	<tr>
	<td colspan=10 align='center'>
	Create Category<br><br>
	</td>
	</tr>
    <tr>
     <td align=left nowrap>&nbsp;Category Name</td>
     <td align=left>
        <input type=text name=categoryName size=20 value='<?=$_POST['categoryName']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;Short Name</td>
     <td align=left>
        <input type=text name=shortName size=20 value='<?=$_POST['shortName']?>'>
     </td>
    </tr>            
      <td align="left">&nbsp;Active&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" checked='true'</INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;Category Description&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="categoryDescription" COLS=40 ROWS=6><?=$_POST['categoryDescription']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>     
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input type=hidden name=id value='<?=$_REQUEST['categoryId']?>'>
      <input type=hidden name=type value='<?=$_REQUEST['type']?>'>    
      <input class=formbutton type=submit value="CREATE"> 
      <input class=formbutton type=submit value="CANCEL" onClick="goToMod(<?=$_REQUEST['mod']?>)">    
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
