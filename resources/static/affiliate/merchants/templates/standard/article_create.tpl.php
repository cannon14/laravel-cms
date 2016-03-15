<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing width=770 border=0 cellspacing=0 width=700 cellpadding=1>
    <? QUnit_Templates::printFilter(3, "Create Page"); ?>  
	
    <tr>
     <td align=left nowrap>&nbsp;<b>Article Title</td>
     <td align=left>
        <input type=text name=articleTitle size=40 value='<?=$_POST['articleTitle']?>'>
     </td>
    </tr>           
    <tr>       
      <td align="left">&nbsp;<b><?=L_G_ACTIVE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['active'] == 1 || $_POST['active'] == null)
						$checked = "checked='true'";
					?>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$checked?></INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Intro Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="articleIntroText" COLS=40 ROWS=6><?=$_POST['articleIntroText']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
    <td colspan=2>
    <b>
    Article Text
    <br>
    <? $_POST['editorObject']->create(); ?>
    </td>
    </tr>     
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_ArticleManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['action']?>>
      <input type=hidden name=eid value='<?=$_POST['articleId']?>'>
      <input class=formbutton type=submit value="SAVE">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
