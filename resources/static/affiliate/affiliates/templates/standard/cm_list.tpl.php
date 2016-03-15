<script>
function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffBannerManager&campaign="+ID;
}

function joinCamp(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=join_camp&campaign="+ID;
}

function showDeclineReason(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=show_decline_reason&campaign="+ID,"Affiliate","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}

function showDetails(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=details&campaign="+ID,"AffiliateDetails","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}
</script>
    <center>
    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Affiliates_Views_AffCampaignManager'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">      
    <table class=listing2 border=0 cellspacing=0 cellpadding=1>
    <tr class=header>
      <td class=listheader colspan=10 align=center><?=L_G_LISTOFPROGRAMS?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
     </tr>
    <tr>
<?
      QUnit_Templates::printHeader(L_G_BANNER);
      QUnit_Templates::printHeader(L_G_NAME, 'name');
      QUnit_Templates::printHeader(L_G_SHORT_DESCRIPTION, 'shortdescription');
      QUnit_Templates::printHeader(L_G_CAMPAIGNTYPE, 'commtype');   
      QUnit_Templates::printHeader(L_G_COMMISSIONS);
      QUnit_Templates::printHeader(L_G_BANNERS);
      if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
        QUnit_Templates::printHeader(L_G_STATUS);
?>    
      <td class=listheader><?=L_G_ACTIONS?></td>
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult valign=top>&nbsp;<? if($data['banner_url'] != '') { ?><img src='<?=$data['banner_url']?>' width=50 height=30><? } ?></td>
      <td class=listresultnocenter align=left valign=top nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresultnocenter valign=top align=left>
      <table border=0 cellspacing=0>
      <tr>
        <td style="padding-left: 3px; padding-right: 3px;" align=left valign=top>
            <?=(strlen($data['shortdescription']) < 50 ? $data['shortdescription'] : substr($data['shortdescription'], 0, 50).' ...')?>&nbsp;
        </td>
      </tr>
      </table>
      </td>
      <td class=listresult valign=top>&nbsp;
      <?
        print $GLOBALS['Auth']->getComposedCommissionTypeString($data['commtype']);
      ?> &nbsp;
      </td>
      <td class=listresultnocenter nowrap align=left>
        <? $this->a_this->drawCommissionField($data); ?>
      &nbsp;
      </td>
      <td class=listresult valign=top>&nbsp;<?=$data['bannercount']?>&nbsp;</td>
<? if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
      <td class=listresult valign=top nowrap>&nbsp;
<?
   if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
        <a href="javascript:showDeclineReason('<?=$data['campaignid']?>');">
<? }
   if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
   else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
   else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED.'</a>';
   else print L_G_NOTJOINED;
?>
      &nbsp;
      </td>
<? } ?>
      <td class=listresult valign=top>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <option value="javascript:showDetails('<?=$data['campaignid']?>');"><?=L_G_DETAILS?></option>
<? if($data['rstatus'] == AFFSTATUS_APPROVED 
      || $GLOBALS['Auth']->getSetting('Aff_join_campaign') != '1') { ?>
        <option value="javascript:viewBanners('<?=$data['campaignid']?>');"><?=L_G_VIEWBANNERS?></option>
<? } else if($data['rstatus'] == '') { ?>
        <option value="javascript:joinCamp('<?=$data['campaignid']?>');"><?=L_G_JOINCAMPAIGN?></option>
<? } ?>
        </select>
      </td>
    </tr>    
      
<?
    }
?>
  </table>
  </center>
  </form>
