<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing width=770 border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(3, "Create Card Sub Category"); ?>  
	
      <tr>
      <td align="left">&nbsp;<b>Sub Category Title&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='catTitle' size='50' value='<?= $_POST['catTitle']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Sub Category Image&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='catImage' size='50' value='<?= $_POST['catImage']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    
    <tr>
      <td align="left">&nbsp;<b>Sub Category Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='catImageAltText' size='50' value='<?=$_POST['catImageAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td align="left">&nbsp;<b>Sub Category Description&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA COLS=80 ROWS=10 NAME='catDescription'><?=$_POST['catDescription']?></TEXTAREA>                        
                </td>
            </tr>
        </table>
      </td>
    </tr>
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CardSubCategoryManager'>
      <input type=hidden name=action value='<?=$_POST['action']?>'>
      <input type=hidden name=postaction value='<?=$_POST['action']?>'>
      <input type=hidden name=eid value='<?=$_POST['eid']?>'>
      <input class=formbutton type=submit value="SAVE">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
