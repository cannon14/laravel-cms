<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, "Edit Page"); ?>  
	
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_PAGENAME?></td>
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
      <td align="left">&nbsp;<?=L_G_ACTIVE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['active'] == 1)
						$checked = "checked='true'";
					?>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$checked?></INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_SITEDESCRIPTION?>&nbsp;</td>
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
      <input type=hidden name=md value='Affiliate_Merchants_Views_CategoryManager'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=eid value='<?=$_POST['categoryId']?>'>
      <input type=hidden name=type value='<?=$_REQUEST['type']?>'>    
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
