    <form name=MyForm action=index_popup.php method=post>
    <table border=0 cellspacing=0>
    </table>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=5 align=center><?=L_G_LIST?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap>&nbsp;</td>
      <td class=listheader width=1% nowrap><?=L_G_AFFILIATEID?></td>
      <td class=listheader><?=L_G_NAME?></td>
      <td class=listheader><?=L_G_WEBURL?></td>
      <td class=listheader><?=L_G_DATEADDED?></td>
    </tr>    
<?
      
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox name="campid_<?=$data['affiliatecampaignid']?>" value=1></td>
      <td class=listresult><?=$data['userid']?></td>
      <td class=listresult><?=$data['name']?></td>
      <td class=listresult><?=$data['weburl']?></td>
      <td class=listresult><?=$data['dateinserted']?></td>
    </tr>    
      
<?
    }
?>
    <tr class=listresult>
      <td height=15 colspan=5 align=center>&nbsp;</td>
    </tr>
    <tr class=listresult>
      <td class=listresult colspan=5 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_ApprovalManager'>
      <input type=hidden name=postaction value=approvecamps>
      <input type=hidden name=type value=camps>
      <input class=formbutton type=button value='<?=L_G_CLOSE; ?>' onClick='javascript:window.opener.document.location.reload(); window.close();'>
      &nbsp;&nbsp;
      <input class=formbutton type=button value='<?=L_G_DENYSELECTED; ?>'  onclick="javascript:MyForm.postaction.value='denycamps'; MyForm.submit();">
      &nbsp;&nbsp;
      <input class=formbutton type=submit value='<?=L_G_APPROVESELECTED; ?>'>
      </td>
    </tr>
    </table>
    </form>