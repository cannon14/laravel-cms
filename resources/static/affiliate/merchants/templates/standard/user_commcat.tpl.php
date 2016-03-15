
    <center>
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(3, L_G_CHANGECOMMCATEGORYLONG); ?> 
    <tr align=left>
        <td class=listresult colspan=3>
            <?=L_G_AFFILIATE?><br>
            <?=L_G_USERNAME;?>: <b><?=$_POST['uname']?></b>&nbsp;&nbsp;&nbsp;
            <?=L_G_CONTACTNAME;?>: <b><?=$_POST['name'].' '.$_POST['surname']?></b>
            <br><br>
        </td>
    </tr>    
    <tr class=listresult>
        <td class=listheader><b><?=L_G_CAMPAIGN?></b></td>
        <td class=listheader><b>ID</b></td>
        <td class=listheader><b><?=L_G_COMMCATEGORY?></b></td>
    </tr>
<?  
    while($data=$this->a_list_data->getNextRecord()) {
      if($this->a_Auth->getSetting('Aff_join_campaign') == '1'
          && $this->a_CampaignData[$data['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
          && $this->a_AffiliateCategories[$data['campaignid']] == ''
        ) {
            continue;
      }
?>
    <tr>
        <td  class=listresult-left >
        <?=$data['name'];?>&nbsp;
        </td>
        <td class=listresult>
        &nbsp;<?=$data['bannerid'];?>&nbsp;
        </td>
        <td align=left class=listresultnocenter >
        <select name=affcategoryid<?=$data['campaignid'];?>>
            <option value=''><?=L_G_NO_CHANGE?></option>
<?    
        // get categories for this campaign
        foreach($this->a_campaignCategories[$data['campaignid']] as $cat) { 
           echo '<option value="'.$cat['campcategoryid'].'" '.($cat['campcategoryid'] == $this->a_AffiliateCategories[$data['campaignid']] ? 'selected' : '').'>';

           Affiliate_Merchants_Views_CampaignManager::drawCommissionOption($cat);
?>
                </option>
<?    } ?>      
            </select>*
        </td>
    </tr>
    
<?  } ?>      
    
    <tr>
        <td class=dir_form colspan=2 align=center>
            <input type=hidden name=commited value=yes>
            <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
            <input type=hidden name=action value=<?=$_POST['action']?>>
            <input type=hidden name=aid value=<?=$_POST['aid']?>>
            <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
            <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
        </td>
    </tr>
    </table>
    </form>
    </center>
