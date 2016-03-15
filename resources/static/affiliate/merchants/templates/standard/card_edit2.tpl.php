<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<center>
  <form action=index_popup.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, "Edit Site"); ?>  
	
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_SITENAME?></td>
     <td align=left>
        <input type=text name=siteName size=20 value='<?=$_POST['siteName']?>'>
     </td>
    </tr>          
      <tr>
      <td align="left">&nbsp;<?=L_G_SITETITLE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='siteTitle' size='20' value='<?= $_POST['siteTitle']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_HOSTNAME?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='hostname' size='20' value='<?= $_POST['hostname']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>
      <td align="left">&nbsp;<?=L_G_LAYOUT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='layout' size='20' value='<?= $_POST['layout']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    <tr>
      <td align="left">&nbsp;<?=L_G_PUBLISHPATH?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='publishPath' size='20' value='<?= $_POST['publishPath']?>'>                          
                </td>
            </tr>
        </table>
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
					<TEXTAREA NAME="siteDescription" COLS=40 ROWS=6><?=$_POST['siteDescription']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_SiteManager'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=eid value='<?=$_POST['siteId']?>'>
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
