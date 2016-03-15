<form action=index.php method=post name=update>
<table class=listing width=770 border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(3, L_G_CRM_EDITVERSION); ?>  

    
    
    
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDDETAILTEXT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="cardDetailText" COLS=40 ROWS=6><?=$_POST['cardDetailText']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDINTRODETAIL?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="cardIntroDetail" COLS=40 ROWS=6><?=$_POST['cardIntroDetail']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDMOREDETAIL?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="cardMoreDetail" COLS=40 ROWS=6><?=$_POST['cardMoreDetail']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>       
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDSEEDETAILS?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="cardSeeDetails" COLS=40 ROWS=6><?=$_POST['cardSeeDetails']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CATEGORYIMAGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImage' size='30' value='<?= $_POST['categoryImage']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>           
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CATEGORYALTTEXT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryAltText' size='30' value='<?= $_POST['categoryAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>         
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDIOIMAGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOImage' size='30' value='<?= $_POST['cardIOImage']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDIOIMAGEALTTEXT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOAltText' size='30' value='<?= $_POST['cardIOAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDBUTTONIMAGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardButtonImage' size='30' value='<?= $_POST['cardButtonImage']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDICONSMALL?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconSmall' size='30' value='<?= $_POST['cardIconSmall']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDICONMID?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconMid' size='30' value='<?= $_POST['cardIconMid']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDICONLARGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconLarge' size='30' value='<?= $_POST['cardIconLarge']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>      
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CardDetailManager'>
      <input type=hidden name=action value='updateVersion'>
      <input type=hidden name=postaction value='updateVersion'>
      <input type=hidden name=versionId value='<?=$_POST['versionId']?>'>
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
