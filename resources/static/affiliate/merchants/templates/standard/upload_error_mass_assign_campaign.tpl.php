<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action="index.php" method="post" name="update">
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=400 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, "Mass Assign Campaigns"); ?>  
	
    <tr>
     <td width="50%" align=left nowrap>&nbsp;<b>Date Errored:</b></td>
     <td  width="50%" align=left>
        <?=$this->error['errordate']?>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<b>Campaign Category:</b></td>
     <td align=left>
        <SELECT name='campaignid'>
        <?if($this->error['campaignid'] == null){?>
        <option value=''>No Campaign Associated</option>
        <? } ?>
        <?
        foreach($this->campaigns as $col=>$val){
        ?>
        <option value="<?=$col?>"><?=$val?></option>
        <?PHP
        }
        ?>
        </SELECT>

     </td>
    </tr>           
        </table>
      </td>
    </tr>  
      
    
    <tr>
      <td colspan=3 align=center>
        <br />
        <br />
      <input type=hidden name=commited value=1>
      <input type=hidden name=md value='Affiliate_Merchants_Views_UploadErrorManager'>
      <input type=hidden name=action value='editMassCampaigns'>
      <input type=hidden name=ids value="<?=$this->ids?>"> 
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>"> &nbsp;&nbsp;&nbsp; <input class=formbutton type=button value="Cancel" onclick="javascript:window.location='index.php?md=Affiliate_Merchants_Views_UploadErrorManager';">
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
