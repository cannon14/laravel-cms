<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, "Edit Page"); ?>  
	
    <tr>
     <td align=left nowrap>&nbsp;Page Name</td>
     <td align=left>
        <input type=text name=pageName size=20 value='<?=$_POST['pageName']?>'>
     </td>
    </tr>   
    <tr>       
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
					<TEXTAREA NAME="pageDescription" COLS=40 ROWS=6><?=$_POST['pageDescription']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>     
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_PageManager'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=eid value='<?=$_POST['cardpageId']?>'>
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
