<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=1>
	
    <tr>
     <td align=left nowrap>&nbsp;Category Name</td>
     <td align=left>
        <input type=text name=categoryName size=20 value='<?=$this->categoryName?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;Short Name</td>
     <td align=left>
        <input type=text name=shortName size=20 value='<?=$this->shortName?>'>
     </td>
    </tr>               
      <td align="left">&nbsp;Active&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($this->active == 1)
						$checked = "checked='true'";
					?>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$checked?></INPUT>
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
					<TEXTAREA NAME="categoryDescription" COLS=40 ROWS=6><?=$this->categoryDescription?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>     
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=categoryId value='<?=$this->categoryId?>'>   
      <input class=formbutton type=submit value="Update Category">  
      <input class=formbutton type=submit value="CANCEL" onClick="goToMod(<?=$_REQUEST['mod']?>)">   
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
