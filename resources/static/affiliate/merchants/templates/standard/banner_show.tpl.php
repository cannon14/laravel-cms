<?
    $paging = $this->a_Auth->getSetting('Aff_paging');
    if($paging == '' || $paging == 0) {
        $paging = 10;
    }
    
    if($this->a_numrows > $paging) {
        $pages = floor($this->a_numrows / $paging);
        if($this->a_numrows%$paging) $pages++;
    }
    
    if($_REQUEST['list_page'] == '' || $_REQUEST['list_page'] > $pages) {
        $_REQUEST['list_page'] = 1;
    }
?>
<script>
function deleteBanner(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEBANNER?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&bid="+ID+"&action=delete";
}

function addBanner(Type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&action=add&campaign=<?=$campaignid?>&type="+Type;
}

function editBanner(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&action=edit&bid="+ID;
}

function addBannersForCampaign()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&action=show&campid=<?=$campaignid?>";
}

function backToCampaigns(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=addbanners&cid="+ID;
}
</script>

   <table border=0>
<? if($this->a_action_permission['add']) { ?>
   <tr>
   <td align=left>
     <table border=0 cellspacing=0>
     <tr>
       <td><input type=button class=formbutton value="<?=L_G_ADDHTML?>"  onclick="javascript:addBanner('html');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?=L_G_ADDTEXT?>"  onclick="javascript:addBanner('text');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?=L_G_ADDIMAGE?>"  onclick="javascript:addBanner('image');">&nbsp;&nbsp;&nbsp;</td>
     </tr>
     <tr>
        <td>&nbsp;</td>
     </tr>
     </table>
   </td>
   </tr>
<? } ?>
   <tr>
   <td align=left>
   <? include('banner_show_filter.tpl.php'); ?>
   </td>   
   </tr>   
   <tr>
   <td align=center>
<?
    if($this->a_numrows > $paging)
    {
      echo "<center>";      
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
          if($i != $_REQUEST['list_page']) {
              echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_BannerManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
          } else {
              echo "&nbsp;<b>$i</b>&nbsp;";
          }
      }
      echo "</center><br>";
    }
    
    if($this->a_numrows == 0)
        print L_G_NOBANNERSINCAMPAIGN;
        
    $count = 0;
    while($data=$this->a_list_data->getNextRecord())
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }

      // get statistics data (impressions and clicks)
      $stat_data = $this->a_bannerStats[$data['bannerid']];      
?>  
    <br>
    <table class=listing width=750 border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=tableheader align=left>
        <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align=left class=whitetext>
                <?=L_G_BANNER?> <?=L_G_ID?>: <?=$data['bannerid']?>&nbsp;&nbsp;|&nbsp;&nbsp;
                <?=L_G_CAMPAIGN?>: <b><?=$data['campaignname']?></b>&nbsp;&nbsp;|&nbsp;&nbsp;
            </td>
            <td align=right>
            <? if($this->a_action_permission['edit']) { ?>
                <a class=mainlink href="javascript:editBanner('<?=$data['bannerid']?>');"><?=L_G_EDIT?></a>
            <? } ?>
            <? if($this->a_action_permission['delete']) { ?>
                &nbsp;&nbsp;
                <a class=mainlink href="javascript:deleteBanner('<?=$data['bannerid']?>');"><?=L_G_DELETE?></a>
            <? } ?>
            </td>
        </tr>
        </table>
         </td>
      </tr>
      <tr>
      	<td colspan=2 class="subinfo"><?=L_G_DESTURL?>: <b><?=$data['destinationurl']?></td>
      </tr>
<? if($_REQUEST['showBannerStats']){ ?>
      <tr>
        <td align=left class=listheaderNoLineLeft>
<? if($_REQUEST['bs_affiliate'] != '' && $_REQUEST['bs_affiliate'] != '_') { ?>      
        <?=L_G_STATISTICSFORALLAFFS?>
<? } ?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data['unique_impressions_period']?> / <?=$stat_data['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data['unique_impressions_all']?> / <?=$stat_data['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
<? if($_REQUEST['bs_affiliate'] != '' && $_REQUEST['bs_affiliate'] != '_') { ?>      
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?=L_G_STATISTICSFORCHOSENAFF?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['unique_impressions_period']?> / <?=$stat_data[$_REQUEST['bs_affiliate']]['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['unique_impressions_all']?> / <?=$stat_data[$_REQUEST['bs_affiliate']]['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data[$_REQUEST['bs_affiliate']]['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
<? } 
 }?>      
      <tr><td class=settingsLine><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
      <tr>
        <td align=center colspan=2>
<?
 if($data['bannertype'] == BANNERTYPE_TEXT)
 {
//     if(isset($this->textbanner_tpl)) {
//          $code = $this->textbanner_tpl;
//          $code = str_replace('{TITLE}', $data['description'], $code);
//              $code = str_replace('{DESCRIPTION}', $data['description'], $code);
//              $code = str_replace('{DESTINATION}', 
//                 $clickUrlOnly."&a_bid=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : ''), $code);
//              $code = str_replace('{IMPRESSION_TRACK}', "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?a_aid=".$GLOBALS['Auth']->userID."&a_bid=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>", $code);
//              
//              echo $code;         
//     } else {
        echo "<b>".$data['sourceurl']."</b><br>".$data['description'];
//     }
 }
 else if($data['bannertype'] == BANNERTYPE_HTML)
 {
   echo $data['description'];
 } 
 else if($data['bannertype'] == BANNERTYPE_IMAGE)
 {
   echo "<br><img src='".$data['sourceurl']."' border=0><br>";
 }
?>        
        </td>
      </tr>
    </table>
    <br>
<?
    }
    
    if($this->a_numrows>$paging)
    {
      $pages = floor($this->a_numrows/$paging);
      if($this->a_numrows%$paging) $pages++;

      echo "<br><center>";      
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_BannerManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center>";
    }    
?>    
   </td>
   </tr>
   <tr>
     <td width=750 align=left>
     <? showHelp(L_G_CLICKTHROUGHS); ?>
     </td>
   </tr>
   </table>
